<?php
include_once("includes/header.php");
require_once("classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(Customer)) {
	$objCustomer = new Customer();
} else {
	echo "Class Not Found Error !! Customer Class Not Found !";
	exit;
}
 
if (is_object($objCustomer)) {
	$arryCustomerGroups =$objCustomer->getCustomerGroups();
	$num=$objCustomer->numRows();

}

require_once("includes/footer.php");

?>
