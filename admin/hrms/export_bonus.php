<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/payroll.class.php");
include_once("includes/FieldArray.php");
$objPayroll=new payroll();

/*************************/
$arryBonus=$objPayroll->ListBonus($_GET);
$num = sizeof($arryBonus);

$pagerLink=$objPager->getPager($arryBonus,$RecordsPerPage,$_GET['curP']);
(count($arryBonus)>0)?($arryBonus=$objPager->getPageRecords()):("");
/*************************/

$filename = "BonusList_".date('d-m-Y').".xls";
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

	$header = "Year\tMonth\tEmp Code\tEmployee\tDepartment\tAmount(".$Config['Currency'].")\tStatus\tApproved";

	$data = '';
	foreach($arryBonus as $key=>$values){

		if($values['Approved'] == '1'){
			$ApprovedStatus = 'Yes';
		 }else{
			$ApprovedStatus = 'No';
		 }

		$Amount = (!empty($values['Amount']))?(round($values['Amount'],2)):("0");
		$Month = date('F', strtotime($values['Year'].'-'.$values['Month'].'-01'));

		$line = $values["Year"]."\t".$Month."\t".$values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["Department"])."\t".$Amount."\t".$values['Status']."\t".$ApprovedStatus."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

