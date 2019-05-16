<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/customer.class.php");
$objCustomer = new Customer();

/*************************/
$arryExportCustomer=$objCustomer->exportCustomers();
$num=$objCustomer->numRows();
 
 
/*************************/

$filename = "CustomerList_".date('d-m-Y').".xls";
if(count($arryExportCustomer)>0){
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

	$header = "CustomerID\tGroupName\tFirstName\tLastName\tEmail\tPhone\tCompany\tAddress1\tAddress2\tCity\tState\tCountry\tZipCode\tCreatedDate\tStatus";

	$data = '';
        
          /********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
                
	foreach($arryExportCustomer as $key=>$values){
		 $CityName=$StateName=$CountryName='';

		 if($values['Status'] =="Yes"){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
                 
                  if($values['Country']>0){
			$arryCountryName = $objRegion->GetCountryName($values['Country']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($values['State'])) {
			$StateName = $objRegion->getAllStateName($values['State']);
                                           
		} else if(!empty($values['OtherState'])){
			 $StateName = stripslashes($values['OtherState']);
		}
                
                  if(!empty($values['City'])) {
                            $arryCity = $objRegion->getCityName($values['City']);
                            if(!empty($arryCity[0]["name"])) { $CityName = stripslashes($arryCity[0]["name"]);}
                    }else if(!empty($values['OtherCity'])){
                             $CityName = stripslashes($values['OtherCity']);
                    }

		$line = $values["Cid"]."\t".$values["GroupName"]."\t".stripslashes($values['FirstName'])."\t".stripslashes($values["LastName"])."\t".$values["Email"]."\t".$values["Phone"]."\t".$values["Company"]."\t".$values["Address1"]."\t".$values["Address2"]."\t"
                        .stripslashes($CityName)."\t".stripslashes($StateName)."\t".stripslashes($CountryName)."\t".$values["ZipCode"]."\t".$values["CreatedDate"]."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No Customer found.";
}
exit;
?>

