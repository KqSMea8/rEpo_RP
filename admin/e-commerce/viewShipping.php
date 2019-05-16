<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/cartsettings.class.php");
           
	
	  $objCartsettings=new Cartsettings();
	  
	 if (is_object($objCartsettings)) {
	 	$arryShipingMethod=$objCartsettings->getShipingMethods();
             
		$num=$objCartsettings->numRows();
	

                          }
  
  require_once("../includes/footer.php");
  
?>
