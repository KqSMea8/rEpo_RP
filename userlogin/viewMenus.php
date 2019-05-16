<?php 
	
 	require_once("includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {

	 	$CustomerID=$_GET["CustomerID"];
	 	
	 	$arryMenus=$webcmsObj->getMenus($CustomerID);
		$num=$webcmsObj->numRows();
	

                          }
       $RedirectURL = "dashboard.php?curP=".$_GET['curP'];                   
	$MainModuleName='Menu';
  require_once("includes/footer.php"); 
  
?>
