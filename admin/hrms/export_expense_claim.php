<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/payroll.class.php");
include_once("includes/FieldArray.php");
$objPayroll=new payroll();

/*************************/
$arryExpenseClaim=$objPayroll->ListExpenseClaim($_GET);
$num = sizeof($arryExpenseClaim);

$pagerLink=$objPager->getPager($arryExpenseClaim,$RecordsPerPage,$_GET['curP']);
(count($arryExpenseClaim)>0)?($arryExpenseClaim=$objPager->getPageRecords()):("");
/*************************/

$filename = "ExpenseClaim_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee\tDepartment\tClaim Amount(".$Config['Currency'].")\tExpense Reason\tExpense Date\tSanctioned Amount(".$Config['Currency'].")\tStatus\tApproved";

	$data = '';
	foreach($arryExpenseClaim as $key=>$values){

		if($values['Approved'] == '1'){
			$ApprovedStatus = 'Yes';
		 }else{
			$ApprovedStatus = 'No';
		 }

		$ClaimAmount = (!empty($values['ClaimAmount']))?(round($values['ClaimAmount'],2)):("0");
		$ExpenseDate = ($values["ExpenseDate"]>0)?(date($Config['DateFormat'], strtotime($values["ExpenseDate"]))):(""); 
		$SancAmount = (!empty($values['SancAmount']))?(round($values['SancAmount'],2)):("0");

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["Department"])."\t".$ClaimAmount."\t".stripslashes($values['ExpenseReason'])."\t".$ExpenseDate."\t".$SancAmount."\t".$values['Status']."\t".$ApprovedStatus."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

