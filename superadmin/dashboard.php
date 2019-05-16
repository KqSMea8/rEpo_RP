<?php 
	$NavText=1;
	require_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");

	$supercms=new supercms();	
	$arryProject=$supercms->getProject();

	require_once("includes/footer.php"); 
?>
