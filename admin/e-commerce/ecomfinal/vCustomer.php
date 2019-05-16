<?php
/**************************************************/
$ThisPageName = 'viewCustomer.php';
/**************************************************/
include_once("includes/header.php");

require_once("classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(customer)) {
	$objCustomer=new Customer();
} else {
	echo "Class Not Found Error !! Cart Settings Class Not Found !";
	exit;
}

$CustId = isset($_REQUEST['view'])?$_REQUEST['view']:"";
$ListUrl = "viewCustomer.php?curP=".$_GET['curP'];
$ListTitle = "Customers";
$ModuleTitle = "View Customer";
$ModuleName = "Customer";
 
if(!empty($CustId)){
	$arryCustomer = $objCustomer->getCustomerById($CustId);
	$CustomerGroup = $objCustomer->getCustomerGroupName($arryCustomer[0]['GroupID']);
}












require_once("includes/footer.php");


?>
