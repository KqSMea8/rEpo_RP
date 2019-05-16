<?php
include_once("includes/header.php");
require_once("classes/cartsettings.class.php");


$objCartsettings=new Cartsettings();
 
if (is_object($objCartsettings)) {
	$arryTaxClasses =$objCartsettings->getTaxClasses();
	$num=$objCartsettings->numRows();

}

require_once("includes/footer.php");

?>
