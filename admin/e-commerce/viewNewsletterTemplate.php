<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/customer.class.php");
        
	  $customerObj=new Customer();
	  
	 if (is_object($customerObj)) {
	 	$arryTemplates=$customerObj->getNewsletterTemplateList('','','','','');
		$num=$customerObj->numRows();
	
                        }
  
  require_once("../includes/footer.php");
  
?>
