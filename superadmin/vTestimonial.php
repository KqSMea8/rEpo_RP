<?php 
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
        
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	
	 	$TestimonialID=$_GET['view'];
	 	
	 	$arryvTestimonial=$supercmsObj->vTestimonial($TestimonialID);
		$num=$supercmsObj->numRows();

		//echo "<pre>";print_r($arryvTestimonial);
}

	require_once("includes/footer.php"); 	 
?>
