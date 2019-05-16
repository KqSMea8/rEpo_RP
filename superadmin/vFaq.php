<?php 
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
        
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	
	 	$FaqID=$_GET['view'];
	 	
	 	$arryvFaq=$supercmsObj->vFaq($FaqID);
		$num=$supercmsObj->numRows();
		
}

	require_once("includes/footer.php"); 	 
?>
