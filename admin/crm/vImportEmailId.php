<?php 
/**************************************************************/
$ThisPageName = 'viewImportEmailId.php'; 
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	
	$_GET['view'] = (int)$_GET['view'];

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
	$RedirectURL = "viewImportEmailId.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

	$EditUrl = "editImportEmailId.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 


        /*
	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
         * 
         */
		

	if (!empty($_GET['view'])) {
		$arryEmailInfo = $objImportEmail->GetEmailId($_GET['view']);


	}
 
	if(empty($arryEmailInfo[0]['id'])) {
		header('location:'.$RedirectURL);
		exit;
	}		
	

	require_once("../includes/footer.php"); 	 
?>
