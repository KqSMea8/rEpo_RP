<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/payroll.class.php");
include_once("includes/FieldArray.php");
$objPayroll=new payroll();

/*************************/
$arrySalary=$objPayroll->ListSalary($_GET);
$num = sizeof($arrySalary);
/*************************/

$PayMethod = $arryCurrentLocation[0]['PayMethod'];

$filename = "EmployeeSalary_".date('d-m-Y').".xls";
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

	if($PayMethod=='H'){
		$header = "Emp Code\tEmployee Name\tDepartment\tDesignation\tPay Rate\tHourly Rate";
	}else{
		$header = "Emp Code\tEmployee Name\tDepartment\tDesignation\tCTC (".$Config['Currency'].")\tGROSS (".$Config['Currency'].")\tNet Salary (".$Config['Currency'].")";
	}	

	$data = '';
	foreach($arrySalary as $key=>$values){
		
		if($values["PayRate"]=="" || $values["PayRate"]=="H"){
			$PayRate="Hourly";			
		}else{ 
			$PayRate="Salary";		
		}

		
		if($PayMethod=='H'){
		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values['Department'])."\t".stripslashes($values["JobTitle"])."\t".$PayRate."\t".$values['HourRate']."\n";
		}else{

		$CTC='';$Gross='';$NetSalary='';
		if($values["CTC"]>0) $CTC= number_format($values["CTC"]);
		if($values["Gross"]>0) $Gross= number_format($values["Gross"]); 
		if($values["NetSalary"]>0) $NetSalary= number_format($values["NetSalary"]); 

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values['Department'])."\t".stripslashes($values["JobTitle"])."\t".$CTC."\t".$Gross."\t".$NetSalary."\n";
		}
		

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

