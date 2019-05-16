<?php
/**************************************************/
//$ThisPageName = 'viewItem.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/category.class.php");
require_once($Prefix."classes/function.class.php");


$ModuleName = "Category";
$objCategory=new category();
$objFunction=new functions();
$RedirectURL = "viewCategory.php";



if($_POST){
	$objCategory->sync_category($_POST);	
	$_SESSION['mess_cat']='Category sync successfully.';
}

header("Location:".$RedirectURL);
exit;

require_once("../includes/footer.php");
?>
