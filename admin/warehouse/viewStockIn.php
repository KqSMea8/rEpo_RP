<?php   

	$FancyBox = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");	
	require_once($Prefix."classes/warehouse.class.php");
	include_once("language/en_lead.php");
	$ModuleName 	= 	"Purchase";
	$objPurchase = new purchase();
    
        $objWarehouse = new warehouse();
	$RedirectURL = "viewPO.php?module=Order";

	/*************************/
	$_GET['module']='Order'; 
	$_GET['Status'] = 'Completed';

	$arryPurchase=$objPurchase->ListPurchase($_GET);
	$num=$objPurchase->numRows();

	$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
	(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>




