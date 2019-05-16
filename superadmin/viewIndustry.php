<?php 
	include_once("includes/header.php");
	require_once("../classes/industry.class.php");

	$industry=new industry();

	

	/***********Count Records****************/
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryIndustry=$industry->getIndustry();	
	$Config['GetNumRecords'] = 1;
	$arryCount=$industry->getIndustry();
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	
	/****************************************/

	require_once("includes/footer.php"); 	 
?>


