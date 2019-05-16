<?php  	
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
//require_once($Prefix."classes/contact.class.php");
require_once($Prefix."classes/sales.customer.class.php");
include_once("includes/FieldArray.php");
//$objContact=new contact();
$objCustomer=new Customer(); 
/*************************/
$arryContact=$objCustomer->ListContact('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objCustomer->numRows();

/*$pagerLink=$objPager->getPager($arryContact,$RecordsPerPage,$_GET['curP']);
(count($arryContact)>0)?($arryContact=$objPager->getPageRecords()):("");
/*************************/

//$filename = "Contact_List_".date('d-m-Y').".xls";
if($_GET['flage']==1)
{
$filename = "Contact_List_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";
$del="\t";
$delm="\t";
}
else if($_GET['flage']==2)
{
	$filename = "Contact_List_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";

	$delm=",";
}

if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: $contanttype");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "First Name $delm Last Name $delm Email $delm Title $delm Assign TO $delm Status";

	$data = '';
	foreach($arryContact as $key=>$values){
		 if($values['Status'] ==1)
		 {
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = 
			"\"".stripslashes($values['FirstName'])."\"".$delm."\"".stripslashes($values['LastName'])."\"".$delm."\"".stripslashes($values['Email'])."\"".$delm."\"".stripslashes($values['Title'])."\"".$delm."\"".stripslashes($values["AssignTo"])."\"".$delm."\"".$status."\""."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

