<?php  	
include_once("includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
include_once("crm/includes/FieldArray.php");
 $objCustomer=new Customer();

/*************************/
$id = (!empty($id)) ? $id :'';  
	(empty($_GET['status']))?($_GET['status']=""):(""); 
$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objCustomer->numRows();


$filename = "CustomerList_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';

//echo '<tr align="left"><th>Customer Code</th><th>Customer Name</th><th>Email Address</th><th>Phone</th><th>Address</th><th>Country</th><th>State</th><th>City</th><th>Zip</th><th>Status</th></tr>';//updated on 19Dec2017 by chetan//


echo '<tr align="left"><th>Customer Code </th><th> Company </th><th> Address </th><th> Country </th><th> First Name </th><th> Last Name </th><th> State </th><th> City </th><th> Zip </th><th> Gender </th><th> Email </th><th> Mobile </th><th> Phone </th><th> Website </th><th> Customer Since </th><th> TaxRate</th></tr>'; //update by bhoodev 2 agust 2018

if($num>0)
{
foreach($arryCustomer as $key=>$values)
	{
	


		 if($values['Status'] ==1)
		 {
			  $status = 'Active';
			
		 }
		 else
		 {
			  $status = 'InActive';
			    
		 }
		
	
//echo '<tr><td>'.$values['CustCode'].'</td><td>'.$values['FullName'].'</td><td>'.$values['Email'].'</td><td>'.$values['Landline'].'</td><td>'.$values['Address'].'</td><td>'.$values["CountryName"].'</td><td>'.$values["StateName"].'</td><td>'.$values["CityName"].'</td><td>'.$values["ZipCode"].'</td><td>'.$status.'</td></tr>';	//updated on 19Dec2017 by chetan//	


echo  '<tr><td>'.$values['CustCode'].'</td><td>'.stripslashes($values['Company']).'</td><td>'.stripslashes($values["Address"]).'</td><td>'.stripslashes($values["CountryName"]).'</td><td>'.stripslashes($values["FirstName"]).'</td><td>'.stripslashes($values["LastName"]).'</td><td>'.stripslashes($values["StateName"]).'</td><td>'.stripslashes($values["CityName"]).'</td><td>'.stripslashes($values["ZipCode"]).'</td><td>'.stripslashes($values["Gender"]).'</td><td>'.stripslashes($values["Email"]).'</td><td>'.stripslashes($values["Mobile"]).'</td><td>'.stripslashes($values["Landline"]).'</td><td>'.stripslashes($values["Website"]).'</td><td>'.stripslashes($values["CustomerSince"]).'</td><td>'.stripslashes($values["c_taxRate"]).'</td></tr>'; //update by bhoodev 2 agust 2018




}
}
echo '</table>';
echo "</body>";
echo "</html>";

?>

