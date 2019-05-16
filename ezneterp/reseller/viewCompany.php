<?php 
    include ('includes/function.php');
    	ValidateCrmSession();
	include ('includes/header.php');

	require_once($Prefix."classes/company.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Company";
	$objCompany=new company();
	if($_SESSION['CrmRsID']>0){
		$_GET['RsID']=$_SESSION['CrmRsID'];
		$arryCompany=$objCompany->CompanyListing($_GET);
		$num=$objCompany->numRows();

		$pagerLink=$objPager->getPager($arryCompany,$RecordsPerPage,$_GET['curP']);
		(count($arryCompany)>0)?($arryCompany=$objPager->getPageRecords()):("");
	}
	include ('includes/footer.php');	 
?>


