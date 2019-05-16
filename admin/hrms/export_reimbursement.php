<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/reimbursement.class.php");
include_once("includes/FieldArray.php");
$objReimbursement=new reimbursement();

/*************************/
$arryReimbursement=$objReimbursement->ListReimbursementDetail($_GET);
$num = sizeof($arryReimbursement);

$pagerLink=$objPager->getPager($arryReimbursement,$RecordsPerPage,$_GET['curP']);
(count($arryReimbursement)>0)?($arryReimbursement=$objPager->getPageRecords()):("");
/*************************/

$filename = "Reimbursement_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee\tDepartment\tExpense Reason\tApplyDate\tApproved Amount(".$Config['Currency'].")\tPayment Status\tApproved";

	$data = '';
	foreach($arryReimbursement as $key=>$values){

		if($values['Approved'] == '1'){
			$ApprovedStatus = 'Yes';
		 }else{
			$ApprovedStatus = 'No';
		 }

		//$ClaimAmount = (!empty($values['ClaimAmount']))?(round($values['ClaimAmount'],2)):("0");
		$ApplyDate = ($values["ApplyDate"]>0)?(date($Config['DateFormat'], strtotime($values["ApplyDate"]))):(""); 
		$SancAmount = (!empty($values['SancAmount']))?(round($values['SancAmount'],2)):("0");

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["Department"])."\t".stripslashes($values['ExReason'])."\t".$ApplyDate."\t".$SancAmount."\t".$values['Status']."\t".$ApprovedStatus."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

