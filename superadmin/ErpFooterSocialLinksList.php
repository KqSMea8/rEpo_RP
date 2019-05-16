<?php 
    /**************************************************/
    $ThisPageName = 'ErpHeaderMenu.php';
    /**************************************************/
	include_once("includes/header.php");
	require_once("../classes/erp.superAdminCms.class.php");
       
	 $erpsupercmsObj=new erpsupercms();
	  
	 if (is_object($erpsupercmsObj)) {
	 	$arryPages=$erpsupercmsObj->getSocialLink();
		$num=$erpsupercmsObj->numRows();

}
  
	require_once("includes/footer.php"); 	 
?>
