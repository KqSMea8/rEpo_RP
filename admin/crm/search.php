<?php 
	$TopSearch=1; $ThisPageName = 'home.php';
	include_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	$objLead = new lead();
	$num = 0;
	if(!empty($_GET['k'])){
		$arryResult = $objLead->SearchCRM($_GET['k'],$_GET['t']);

		if(!empty($arryResult)){
		   	$num = $objLead->numRows();

			$pagerLink = $objPager->getPager($arryResult, 99 , $_GET['curP']);
			(count($arryResult) > 0) ? ($arryResult = $objPager->getPageRecords()) : ("");
		}

	}

	require_once("../includes/footer.php"); 	
?>


