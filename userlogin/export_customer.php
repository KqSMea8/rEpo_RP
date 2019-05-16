<?php  	
include_once("includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
 $objCustomer=new Customer();

/*************************/
$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objCustomer->numRows();

/*$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");*/
/*************************/

$filename = "CustomerList_".date('d-m-Y').".xls";
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

	$header = "Customer Code\tCustomer Name\tEmail Address\tPhone\tCountry\tState\tStatus";

	$data = '';
	foreach($arryCustomer as $key=>$values){
		 if($values['Status'] == "Yes"){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		

		$line = $values['CustCode']."\t".stripslashes($values['FullName'])."\t".stripslashes($values["Email"])."\t".stripslashes($values["Landline"])."\t".stripslashes($values["CountryName"])."\t".stripslashes($values["StateName"])."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

