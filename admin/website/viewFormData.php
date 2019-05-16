<?php 
 	include_once("../includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$arryFormData=$webcmsObj->getFormData();
		$num=$webcmsObj->numRows();
	

                          }
                          
	
  require_once("../includes/footer.php");
  
?>
