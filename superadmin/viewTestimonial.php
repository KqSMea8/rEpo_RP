<?php 
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
	$supercmsObj=new supercms();

	/*******Get Testimonial Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryTestimonials=$supercmsObj->getTestimonial();
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$supercmsObj->getTestimonial();
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/

	require_once("includes/footer.php"); 	 
?>


