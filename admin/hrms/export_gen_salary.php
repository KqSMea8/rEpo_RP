<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/payroll.class.php");
include_once("includes/FieldArray.php");
$objPayroll=new payroll();

/*************************/
$arrySalary=$objPayroll->ListPaySalary($_GET['Department'],$_GET['emp'],$_GET['y'],$_GET['m'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num = sizeof($arrySalary);
/*************************/

$filename = "Salary_".date('F_Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01')).".xls";
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

	$header = "Salary for the period of ".date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'))."\n\n";

	$header .= "Year\tMonth\tEmp Code\tEmployee Name\tDepartment\tDesignation\tGROSS (".$Config['Currency'].")\tNet Salary (".$Config['Currency'].")\tCurrent Salary (".$Config['Currency'].")\tPayment";

	$data = '';
	foreach($arrySalary as $key=>$values){

		 if($values['Status'] ==1){
			$status_val = ' Paid ';
		 }else{
			$status_val = 'Pending';
		 }


		$line = date('Y', strtotime($values['Year']))."\t". date('F', strtotime($values['Year'].'-'.$values['Month'].'-01'))."\t". $values["EmpCode"]."\t". stripslashes($values["UserName"])."\t". stripslashes($values['Department'])."\t". stripslashes($values["JobTitle"])."\t". number_format($values["Gross"])."\t". number_format($values["NetSalary"])."\t". number_format($values["CurrentSalary"])."\t". $status_val."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

