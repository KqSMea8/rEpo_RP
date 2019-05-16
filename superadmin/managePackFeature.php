<?php 
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
        
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	$arryPages=$supercmsObj->getPackFeatureList();
		$num=$supercmsObj->numRows();

}
 
	require_once("includes/footer.php"); 	 
?>
