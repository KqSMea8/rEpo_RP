<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objEmployee=new employee();

/*************************/
$arryRequest=$objEmployee->ListRequest($id,$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['FromDate'],$_GET['ToDate']);
$num = sizeof($arryRequest);

$pagerLink=$objPager->getPager($arryRequest,$RecordsPerPage,$_GET['curP']);
(count($arryRequest)>0)?($arryRequest=$objPager->getPageRecords()):("");
/*************************/

$filename = "RequestList_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee\tDepartment\tSubject\tMessage\tRequest Date";

	$data = '';
	foreach($arryRequest as $key=>$values){

		if($values['Approved'] == '1'){
			$ApprovedStatus = 'Yes';
		 }else{
			$ApprovedStatus = 'No';
		 }

		$mLength = strlen(stripslashes($values['Message']));
			if($mLength > 100)
			{
			$Message = substr(stripslashes($values['Message']),0,100)."...";
			}else{
			 $Message = stripslashes($values['Message']);
			}
			$Subject = stripslashes($values['Subject']);
		$RequestDate = ($values["RequestDate"]>0)?(date($Config['DateFormat'], strtotime($values["RequestDate"]))):(""); 
		$AmountReturned = (!empty($values['AmountReturned']))?(round($values['AmountReturned'],2)):("0");

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["Department"])."\t".$Subject."\t".$Message."\t".$RequestDate."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

