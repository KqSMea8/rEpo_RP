<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/time.class.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objTime=new time();
$objEmployee=new employee();

	/****************************/

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryYearMonth = explode("-",$arryTime[0]);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];

/*********************/
if($arryCurrentLocation[0]['UseShift']==1){
	$LunchPaidMain = 1;
	$ShortBreakPaidMain = 1;
}else{
	$LunchPaidMain = $arryCurrentLocation[0]['LunchPaid'];
	$ShortBreakPaidMain = $arryCurrentLocation[0]['ShortBreakPaid'];
}
/*********************/
	/****************************/
/*************************/
if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
	$arryAttendence=$objTime->getAttendence($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
	$num=sizeof($arryAttendence);
	$ShowList = 1;

	/*$RecordsPerPage = 100;
	$pagerLink=$objPager->getPager($arryAttendence,$RecordsPerPage,$_GET['curP']);
	(count($arryAttendence)>0)?($arryAttendence=$objPager->getPageRecords()):("");*/
}
/*************************/

$filename = "AttendenceList_".date('d-m-Y').".xls";
if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Emp Code\tEmployee\tDepartment\tDate\tIn Time\tIn Time Comment\tOut Time\tOut Time Comment\tDuration";

	$data = ''; $Line=0; $TotalDuration = 0;
	foreach($arryAttendence as $key=>$values){
		$Line++;$BreakTime = 0;

		/****************/
		$LunchPaid = $LunchPaidMain; 
		$ShortBreakPaid = $ShortBreakPaidMain;
		if(!empty($values['shiftName'])){
			$LunchPaid = $values['LunchPaid']; 
			$ShortBreakPaid = $values['ShortBreakPaid'];
		}
		$BreakType = '';unset($arryBreakTime);
		if($LunchPaid!=1) $BreakType .= "'Lunch',";
		if($ShortBreakPaid!=1) $BreakType .= "'Short Break',";
		$BreakType =rtrim($BreakType,",");
		if(!empty($BreakType)){
			$arryBreakTime=$objTime->getBreakTime($values['attID'],$BreakType);
			foreach($arryBreakTime as $keytime=>$valuestime){		
				$BreakTime += ConvertToSecond($valuestime['TimeDuration']);
			}
		
		}
		/****************/






		/*$Duration = 0;
		if(!empty($values["InTime"]) && !empty($values["OutTime"])){
			$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
			$TotalDuration += $Duration;
			$Duration = time_diff($Duration);
			
		}*/

		$Duration = ConvertToSecond($values["TimeDuration"]) - $BreakTime;
		if($Duration>0){$TotalDuration += $Duration; $Duration = time_diff($Duration);}


		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values['Department'])."\t". date($Config['DateFormat'],strtotime($values["attDate"]))."\t" .$values["InTime"]. "\t".$values["InComment"]."\t".$values["OutTime"]."\t".$values["OutComment"]."\t".$Duration."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

