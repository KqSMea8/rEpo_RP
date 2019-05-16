<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");

$MenuTitle = "Best Seller Items";
$bestseller_items = $objProduct->getItemsBestSellers($settings);
	
$num=$objProduct->numRows();



require_once("includes/footer.php"); 

               
?>