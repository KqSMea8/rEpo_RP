<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/report.rule.class.php");
	$objTime=new time();
	$objEmployee=new employee();
	$objReport = new report();


	/****************************/
	function time_diff_total($s){
		$m=0;$hr=0;$d=0; $td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			//$td = "$d day"; 
			if($d>1) $td .= "s";
			if($d<3){
				//if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		//if($s>0) $td .=  " $s sec";

		return $td;
	} 
	/****************************/

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryYearMonth = explode("-",$arryTime[0]);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];


	/****************************/
	$RedirectUrl ="viewAttendence.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['depID']))?("&depID=".$_GET['depID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = ATT_REMOVED;
		$objTime->deleteAttendence($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	


	if($_POST){
		
		if(sizeof($_POST['attID']>0)){
			$att = implode(",",$_POST['attID']);
			$_SESSION['mess_att'] = ATT_REMOVED;
			$objTime->deleteAttendence($att);
			header("location:".$RedirectUrl);
			exit;
		}
		
	}








	/*
	if($_POST) {
		if($_POST['attID']>0) {
			$objTime->updateAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_OUT;
		} else {		
			$objTime->addAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_IN;
		}
	
		header("location:".$RedirectUrl);
		exit;
		
	}
	*/

	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
		$arryAttendence=$objTime->getAttendence($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryAttendence);
		$ShowList = 1;
		
		$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryAttendence,$RecordsPerPage,$_GET['curP']);
		(count($arryAttendence)>0)?($arryAttendence=$objPager->getPageRecords()):("");

		
	}
$arryCustomReport = $objReport->GetReportRule('');

 function multiexplode ($delimiters,$string) {
    $ary = explode($delimiters[0],$string);
    array_shift($delimiters);
    if($delimiters != NULL) {
        foreach($ary as $key => $val) {
             $ary[$key] = multiexplode($delimiters, $val);
        }
    }
    return  $ary;
}  



	if(!empty($_GET['CustomReport'])){
		$arryReport = $objReport->GetReportRule($_GET['CustomReport']);
		$delimiters = Array(",",":");
		$reportHeader = multiexplode($delimiters,$arryReport[0]['ReportRule']);
	}
	

	require_once("../includes/footer.php");
?>

