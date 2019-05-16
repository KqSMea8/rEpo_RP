<?php 
    /**************************************************/
    $ThisPageName = 'viewReseller.php'; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/reseller.class.php");	
	require_once("../classes/company.class.php");		
	$objReseller =	new reseller();
	$objCompany =	new company();

	$ModuleName = "Reseller";
	$RedirectURL = "viewReseller.php?curP=".$_GET['curP'];
	$_GET['rs'] = (int)$_GET['rs'];

	if (!empty($_GET['rs'])) {
		$arryReseller = $objReseller->GetReseller($_GET['rs'],'');	
	}
	/***************/
	if(empty($arryReseller[0]['RsID'])){
		header("Location:".$RedirectURL);
		exit;
	}
	/***************/

	$_GET['RsID']=$_GET['rs'];
	$arryCompany=$objCompany->CompanyListing($_GET);
	$num=$objCompany->numRows();

	$pagerLink=$objPager->getPager($arryCompany,$RecordsPerPage,$_GET['curP']);
	(count($arryCompany)>0)?($arryCompany=$objPager->getPageRecords()):("");

	require_once("includes/footer.php"); 
?>


