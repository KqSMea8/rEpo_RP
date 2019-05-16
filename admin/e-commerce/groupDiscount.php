<?php
/**************************************************/
$EditPage = 1;
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/cartsettings.class.php");
require_once($Prefix."classes/customer.class.php");
$objCustomer = new Customer();
$objcartsettings=new Cartsettings();

$ModuleName = 'Group Discount';
$ListUrl = "groupDiscount.php";
 

 
$listAllCustomerGroups =$objCustomer->getCustomerGroupsetting();
$arrygroupdiscount =$objcartsettings->getgroupdiscount();
 

		
	if(!empty($_POST)){
		 
		$_SESSION['mess_cart'] = $ModuleName.$MSG[102];
		

		/********set group discount***********/
		$objcartsettings->setgroupdiscount($_POST['groupdiscount']);
			
		header("location:".$ListUrl);
		exit;
			
	}





require_once("../includes/footer.php");


?>
