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
$filename = "ContactList_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");



echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';


echo '<tr align="left"><th>First Name</th><th>Last Name</th><th>Email</th><th>Title</th><th>Assign TO</th><th>Status</th></tr>';

if($num>0)
{

	$status="";
	foreach($arryContact as $key=>$values)
	{

	if($values['Status'] ==1)
		 {
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		

echo '<tr><td>'.$values['FirstName'].'</td><td>'.$values['LastName'].'</td><td>'.$values['Email'].'</td><td>'.$values['Title'].'</td><td>'.$values["AssignTo"].'</td><td>'.$status.'</td></tr>';
	
	}
}



echo '</table>';
echo "</body>";
echo "</html>";
?>
