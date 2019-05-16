<?php    $ThisPageName = 'viewCustomer.php'; $EditPage = 1;
 	include_once("../includes/header.php");
	
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {

	 	$CustomerID=$_GET["CustomerID"];
	 	
	 	$arryMenus=$webcmsObj->getMenus($CustomerID);
		$num=$webcmsObj->numRows();
	

                          }
                          
	$MainModuleName='Menu';
  require_once("../includes/footer.php");
  
?>
