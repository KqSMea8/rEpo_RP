<?php 
 	include_once("includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$CustomerID=$_GET["CustomerID"];
	 	$arryFormFields=$webcmsObj->getFormFields($CustomerID);
		$num=$webcmsObj->numRows();
	

                          }
          $RedirectURL = "dashboard.php?curP=".$_GET['curP'];                 
	$MainModuleName='Form Field';
  require_once("includes/footer.php");
  
?>
