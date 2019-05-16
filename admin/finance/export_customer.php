<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
 $objCustomer=new Customer();

/*************************/
$arryCustomer = $objCustomer->ListCustomer($_GET);
$num=$objCustomer->numRows();

/*$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");*/
/*************************/

$filename = "SalesCustomerList_".date('d-m-Y').".xls";
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

	$header = "Name\tCompany Name\tCountry\tState\tCity\tCurrency\tStatus";

	$data = '';
	foreach($arryCustomer as $key=>$values){
		 if($values['Status'] == "Yes"){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$line = $values["FirstName"]."\t".stripslashes($values["Company"])."\t".stripslashes($values["CountryName"])."\t".stripslashes($values["StateName"])."\t".stripslashes($values["CityName"])."\t".$values["Currency"]."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

