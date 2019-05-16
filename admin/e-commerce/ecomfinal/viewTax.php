<?php 
 	include_once("includes/header.php");
	require_once("classes/cartsettings.class.php");
        
	  $objCartsettings=new Cartsettings();
	  
	 if (is_object($objCartsettings)) {
	 	$arryTax=$objCartsettings->getTaxes();
                
               
                
                 for($i=0; $i<count($arryTax); $i++){

                           $arryTax[$i]["Class"] = $objCartsettings->getTaxClassName($arryTax[$i]["ClassId"]);

                    }
                
          
             
		$num=$objCartsettings->numRows();
	

                          }
  
  require_once("includes/footer.php");
  
?>
