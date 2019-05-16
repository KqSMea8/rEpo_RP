<?php  	
include_once("../includes/settings.php");
//require_once($Prefix."classes/contact.class.php");
require_once($Prefix."classes/sales.customer.class.php");
//$objContact=new contact();
$objCustomer=new Customer(); 
/*************************/
$arryContact=$objCustomer->ListContact('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objCustomer->numRows();

/*$pagerLink=$objPager->getPager($arryContact,$RecordsPerPage,$_GET['curP']);
(count($arryContact)>0)?($arryContact=$objPager->getPageRecords()):("");
/*************************/

$filename = "Contact_List_".date('d-m-Y').".xls";
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

	$header = "First Name\tLast Name\tEmail\tTitle\tAssign TO\tStatus";

	$data = '';
	foreach($arryContact as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = 
			stripslashes($values['FirstName'])."\t".stripslashes($values['LastName'])."\t".stripslashes($values['Email'])."\t".stripslashes($values['Title'])."\t".stripslashes($values["AssignTo"])."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

