<?php 
 	include_once("../includes/header.php");
	
	require_once($Prefix."classes/cartsettings.class.php");
        
	 $objcartsettings=new Cartsettings();
	  
	 if (is_object($objcartsettings)) {
	 	$arrySocialLinks=$objcartsettings->getSocialLinks();	 	
	 	
		$num=$objcartsettings->numRows();

         }
                          
	
  require_once("../includes/footer.php");
  
?>
