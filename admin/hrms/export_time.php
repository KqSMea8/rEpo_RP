<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/time.class.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objTime=new time();
$objEmployee=new employee();

/*************************/
if(!empty($_GET['tmID']) && $_GET['emp']>0){
	$arryTimesheet=$objTime->getTimesheet('', $_GET['emp'], $_GET['tmID']);
	$num=sizeof($arryTimesheet);

	$arryPeriodDetail = $objTime->getTimesheetPeriod($_GET['tmID'], $_GET['emp']);
	$arryEmployee = $objEmployee->GetEmployeeBrief($_GET['emp']);
	$FromDate = $arryPeriodDetail[0]['FromDate'];

}
/*************************/

$filename = "TimesheetFor_".$arryEmployee[0]["UserName"]."_".date('d-m-Y').".xls";
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

	$heading = "Department:\t".$arryEmployee[0]["Department"];
	$heading .= "\nEmployee:\t".$arryEmployee[0]["UserName"];
	$heading .= "\nWeek:\t".$arryPeriodDetail[0]['FromDate']." to ".$arryPeriodDetail[0]['ToDate'];

	$header = "Project\tActivity";

	$arryDate = explode("-",$FromDate);
	list($year, $month, $day) = $arryDate;
	for($i=1;$i<=7;$i++){
		$tomorrow  = mktime(0, 0, 0, $month , $day+$i-1, $year);
		$header .= "\t".date("D, d",$tomorrow);
	}
	$header .= "\tTotal";

	$data = ''; $Line=0;  $FinalHour=0;
	foreach($arryTimesheet as $key=>$values){
		$Line++;
		$Total=0; $Hour=0; $Minute=0;

		$line = stripslashes($values["Project"])."\t".stripslashes($values["Activity"]);

		for($i=1;$i<=7;$i++){
			$line .= "\t".$values["Time".$i];
			if(!empty($values["Time".$i])){
				$arryTime = explode(":",$values["Time".$i]);
				$Hour += $arryTime[0];
				$Minute += $arryTime[1];
				
				$arryHour[$i] += $arryTime[0];
				$arryMinute[$i] += $arryTime[1];
			}
			
		}
		
		if($Minute>=60){
			$rem = floor($Minute/60); $Minute = $Minute%60;
			$Hour += $rem;
		}
		if($Minute<10) $Minute = '0'.$Minute;
		$Total = $Hour.':'.$Minute;
		
		$FinalHour += $Hour; 
		$FinalMinute += $Minute;

		$line .= "\t".$Total."\n";

		$data .= trim($line)."\n";
	}


	$line = "Total\t";
	for($i=1;$i<=7;$i++){ 
		$TotalTd=0;
		$HourTd = $arryHour[$i];
		$MinuteTd = $arryMinute[$i];
		
		if($MinuteTd>=60){
			$rem = floor($MinuteTd/60); $MinuteTd = $MinuteTd%60;
			$HourTd += $rem;
		}
		if($MinuteTd<10) $MinuteTd = '0'.$MinuteTd;
		if($HourTd>0 || $MinuteTd>0){
			$TotalTd = $HourTd.':'.$MinuteTd;
		}
		
		$line .= "\t".$TotalTd;
	}
	
	
	/******Calculating Final Duration **/
	if($FinalMinute>=60){
		$rem = floor($FinalMinute/60); $FinalMinute = $FinalMinute%60;
		$FinalHour += $rem;
	}
	if($FinalMinute<10) $FinalMinute = '0'.$FinalMinute;
	
	$FinalTotal = $FinalHour.':'.$FinalMinute;

	$line .= "\t".$FinalTotal;


	$data .= "\n".trim($line)."\n";
	/*************************/
	$data = str_replace("\r","",$data);

	print "$heading\n\n$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

