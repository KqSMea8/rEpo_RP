<?php 
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../../classes/erp.superAdminCms.class.php");
        
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	
	 	$CmpId=$_GET['view'];
	 	
	 	$arryohByCmpId=$supercmsObj->paymentByCmpId($CmpId);

		$num=$supercmsObj->numRows();

		//echo "<pre>";print_r($arryohByCmpId);
}

	require_once("includes/footer.php"); 	 
?>
