<?php 
 	include_once("../includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$CustomerID=$_GET["CustomerID"];
	 	$arryForms=$webcmsObj->getForms($CustomerID);
		$num=$webcmsObj->numRows();
	

                          }
   $MainModuleName='Form';                       
	
  require_once("../includes/footer.php");
  
?>
