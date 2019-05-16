<?php 
 	include_once("../includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  $MainModuleName = 'Form Fields ';
	 if (is_object($webcmsObj)) {
	 	$arryFormFields=$webcmsObj->getFormFields();
		$num=$webcmsObj->numRows();
	

                          }
                          
	
  require_once("../includes/footer.php");
  
?>
