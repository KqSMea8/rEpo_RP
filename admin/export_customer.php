<?php  	
include_once("includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
include_once("crm/includes/FieldArray.php");
$objCustomer=new Customer();

$id = (!empty($id)) ? $id :'';  
	(empty($_GET['status']))?($_GET['status']=""):(""); 
/*************************/
$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objCustomer->numRows();

/*$pagerLink=$objPager->getPager($arryCustomer,$RecordsPerPage,$_GET['curP']);
(count($arryCustomer)>0)?($arryCustomer=$objPager->getPageRecords()):("");*/
/*************************/





$filename = "CustomerList_".date('d-m-Y').".xls";


if($_GET['flage']==2)
{
$filename = "CustomerList_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";

	$delm=",";	
	

}
else
{
$filename = "CustomerList_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";

$delm="\t";	
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

	//$header = "Customer Code $delm Customer Name $delm Email Address $delm Phone $delm Address $delm Country $delm State $delm City $delm Zip $delm Status"; //updated on 19Dec2017 by chetan//
	
	$header = "Customer Code $delm Company $delm Address $delm Country $delm First Name $delm Last Name $delm State $delm City $delm Zip $delm Gender $delm Email $delm Mobile $delm Phone $delm Website $delm Customer Since $delm TaxRate"; //updated on 19Dec2017 by chetan//

	$data = '';
	foreach($arryCustomer as $key=>$values){
		 if($values['Status'] == "Yes"){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		

		//$line = "\"".$values['CustCode']."\"".$delm."\"".stripslashes($values['FullName'])."\"".$delm."\"".stripslashes($values["Email"])."\"".$delm."\"".stripslashes($values["Landline"])."\"".$delm."\"".stripslashes($values["Address"])."\"".$delm."\"".stripslashes($values["CountryName"])."\"".$delm."\"".stripslashes($values["StateName"])."\"".$delm."\"".stripslashes($values["CityName"])."\"".$delm."\"".stripslashes($values["ZipCode"])."\"".$delm."\"".$status."\""."\n";//updated on 19Dec2017 by chetan//
		
		
		$line = "\"".$values['CustCode']."\"".$delm."\"".stripslashes($values['Company'])."\"".$delm."\"".stripslashes($values["Address"])."\"".$delm."\"".stripslashes($values["CountryName"])."\"".$delm."\"".stripslashes($values["FirstName"])."\"".$delm."\"".stripslashes($values["LastName"])."\"".$delm."\"".stripslashes($values["StateName"])."\"".$delm."\"".stripslashes($values["CityName"])."\"".$delm."\"".stripslashes($values["ZipCode"])."\"".$delm."\"".stripslashes($values["Gender"])."\"".$delm."\"".stripslashes($values["Email"])."\"".$delm."\"".stripslashes($values["Mobile"])."\"".$delm."\"".stripslashes($values["Landline"])."\"".$delm."\"".stripslashes($values["Website"])."\"".$delm."\"".stripslashes($values["CustomerSince"])."\"".$delm."\"".stripslashes($values["c_taxRate"])."\""."\n";//updated on 19Dec2017 by chetan//
		
		
		

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

