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

function createDateRangeArray($strDateFrom,$strDateTo)
{
   

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom));
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; 
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}
	/****************************/




	if(!empty($_GET['CustomReport'])){
		$arryReport = $objReport->GetReportRule($_GET['CustomReport']);
		$delimiters = Array(",",":");
		$reportHeader = multiexplode($delimiters,$arryReport[0]['ReportRule']);

		foreach($arryReport as $key=>$values){
		$arrayHead[$values['reportID']]['FormDate'] = $arryReport[0]['FromDate'];
		$arrayHead[$values['reportID']]['ToDate'] = $arryReport[0]['FromDate'];
		}

	}


$arrYDate = createDateRangeArray($arryReport[0]['FromDate'],$arryReport[0]['ToDate']);
//echo "<pre>";
//print_r($arrYDate);
#echo count($arrYDate);


if($FromDate>0){
	$FromDate =  $arryReport[0]['FromDate']; 
	$arryTime = explode(" ",$FromDate);
	$arryYearMonth = explode("-",$FromDate);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];
}

	/****************************/
	$RedirectUrl ="viewAttendence.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['depID']))?("&depID=".$_GET['depID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");



	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
		$arryAttendence=$objTime->getAttendence($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryAttendence);
		$ShowList = 1;
		
		$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryAttendence,$RecordsPerPage,$_GET['curP']);
		(count($arryAttendence)>0)?($arryAttendence=$objPager->getPageRecords()):("");

		
	}else{

$arryAttendence=$objTime->getAttendence($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryAttendence);
		$ShowList = 1;
		
		$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryAttendence,$RecordsPerPage,$_GET['curP']);
		(count($arryAttendence)>0)?($arryAttendence=$objPager->getPageRecords()):("");}
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
$arrayList = array();
$date = array();
	foreach($arryAttendence as $key=>$values){
		$empID = $values['EmpID'];
		$Intime = $values['InTime'];
		$OutTime = $values['OutTime'];
		$attDate = $values['attDate'];
		$arrayList[$empID]['EmpName'] =  $values['UserName'];
		$arrayList[$empID][$attDate]['Intime'] = $Intime;
		$arrayList[$empID][$attDate]['OutTime'] = $OutTime;
if(!array_key_exists($attDate,$date)){
                $date[$attDate] = $attDate;
}

		//$arrayDate[] = $attDate;


	}

echo "<pre>";
print_r($date);
echo "</pre>";

	require_once("../includes/footer.php");
?>

