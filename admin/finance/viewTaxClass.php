<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/inv_tax.class.php");
        
	
	  $objTax=new tax();
	  
	 if (is_object($objTax)) {
	 	$arryTaxClasses =$objTax->getTaxClasses();
		$num=$objTax->numRows();
	
                          }
  
  require_once("../includes/footer.php");
  
?>
