<?php 
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	$ModuleName = "Bank";
	$objCompany=new company();

	if($_GET['type']=='') $_GET['type']='Banking';
	/*******Get License Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryInstitution=$objCompany->GetInstitution($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCompany->GetInstitution($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/


	require_once("includes/footer.php"); 	 
?>


