<?php 
	$HideNavigation = 1;
	include ('includes/function.php');
	include_once("includes/header.php");
	require_once($Prefix."classes/erp.superAdminCms.class.php");
        
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	
	 	$OrderId=$_GET['view'];
	 	
	 	$arryohByCmpId=$supercmsObj->paymentByCmpId($OrderId);

		$num=$supercmsObj->numRows();

		//echo "<pre>";print_r($arryohByCmpId);
}

	require_once("includes/footer.php"); 	 
?>
