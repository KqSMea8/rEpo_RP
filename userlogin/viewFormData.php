<?php 
 	include_once("includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$CustomerID=$_GET["CustomerID"];
	 	$arryFormData=$webcmsObj->getFormData($CustomerID);
		$num=$webcmsObj->numRows();
	

                          }
         $RedirectURL = "dashboard.php?curP=".$_GET['curP'];                  
	$MainModuleName= 'Form Data'; 
  require_once("includes/footer.php");
  
?>
