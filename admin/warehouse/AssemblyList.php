<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/bom.class.php");
	$ModuleName = "Production";
	$objProduction = new warehouse();
	$objBOM = new bom();
	/*************************/
	$_GET['module']='Order'; 
	$_GET['Status'] = 2;
	//print_r($_GET);exit;
	if(!empty($_GET['key']))
	{
		$arryAssemble = $objBOM->ListAssemble('',$_GET['key'],'','',$_GET['Status']);
	}
	else
	{
		$arryAssemble = $objBOM->ListAssemble('','','','',$_GET['Status']);
	}
	$num=$objBOM->numRows();
	$pagerLink=$objPager->getPager($arryAssemble,$RecordsPerPage,$_GET['curP']);
	(count($arryAssemble)>0)?($arryAssemble=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 
	/**************************************************/	
?>
