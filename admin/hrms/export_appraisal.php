<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/payroll.class.php");
include_once("includes/FieldArray.php");
$objPayroll=new payroll();

/*************************/
$arryAppraisal=$objPayroll->ListAppraisal($_GET);
$num = sizeof($arryAppraisal);
/*************************/

$filename = "AppraisalList_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee Name\tDepartment\tCTC (".$Config['Currency'].")\tGROSS (".$Config['Currency'].")\tNet Salary (".$Config['Currency'].")\tAppraisal From\tAppraisal Amount (".$Config['Currency'].")";

	$data = '';
	foreach($arryAppraisal as $key=>$values){

	
		$FromDate = ($values["FromDate"]>0)?(date($Config['DateFormat'], strtotime($values["FromDate"]))):('');

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values['Department'])."\t".number_format($values["CTC"])."\t".number_format($values["Gross"])."\t".number_format($values["NetSalary"])."\t".$FromDate."\t".number_format($values["AppraisalAmount"])."\n";
		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

