<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/payroll.class.php");
include_once("includes/FieldArray.php");
$objPayroll=new payroll();

/*************************/
$arryAdvance=$objPayroll->ListAdvance($_GET);
$num = sizeof($arryAdvance);

$pagerLink=$objPager->getPager($arryAdvance,$RecordsPerPage,$_GET['curP']);
(count($arryAdvance)>0)?($arryAdvance=$objPager->getPageRecords()):("");
/*************************/

$filename = "AdvanceList_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee\tDepartment\tAmount(".$Config['Currency'].")\tApply Date\tAmount Returned(".$Config['Currency'].")\tStatus\tApproved";

	$data = '';
	foreach($arryAdvance as $key=>$values){

		if($values['Approved'] == '1'){
			$ApprovedStatus = 'Yes';
		}else{
			$ApprovedStatus = 'No';
		}

		$Amount = (!empty($values['Amount']))?(round($values['Amount'],2)):("0");
		$ApplyDate = ($values["ApplyDate"]>0)?(date($Config['DateFormat'], strtotime($values["ApplyDate"]))):(""); 
		$AmountReturned = (!empty($values['AmountReturned']))?(round($values['AmountReturned'],2)):("0");

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["Department"])."\t".$Amount."\t".$ApplyDate."\t".$AmountReturned."\t".$values['Status']."\t".$ApprovedStatus."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

