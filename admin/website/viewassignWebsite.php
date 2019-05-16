<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	  
	 if (is_object($webcmsObj)) {
	 	$arryCustomers=$webcmsObj->getWebAssignCustomer();
		$num=$webcmsObj->numRows();
		$allowedWebsite=$webcmsObj->totalAllowedSites();
		$assigndWebsite=$webcmsObj->totalAssignedSites();

        }
  
  require_once("../includes/footer.php");
  
?>
