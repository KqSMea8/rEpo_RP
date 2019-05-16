<?php
/**************************************************/
$ThisPageName = 'viewItem.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix."classes/function.class.php");


$ModuleName = "Product";
$objItem=new items();
$objFunction=new functions();
$RedirectURL = "viewProduct.php";



if($_POST){
	$objItem->sync_items($_POST);	
	$_SESSION['mess_product']='Product sync successfully.';
}

header("Location:".$RedirectURL);
exit;


require_once("../includes/footer.php");
?>
