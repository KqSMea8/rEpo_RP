<?php
	require_once("../includes/header.php");
    require_once($Prefix."classes/webcms.class.php");   
	$webcmsObj=new webcms();   
    $totalAllowedSites= $webcmsObj->totalAllowedSites();    
    $assigndWebsite=$webcmsObj->totalAssignedSites();    
	require_once("../includes/footer.php"); 
?>
