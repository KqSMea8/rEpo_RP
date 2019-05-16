<?php 
	/**************************************************/
	include_once("../includes/header.php");
	require_once("../includes/header.php");
	
	require_once($Prefix."classes/warehouse.class.php");
	/**************************************************/
		$objWarehouse=new warehouse();
	
			if(empty($_POST['Add_Production']))	{
			
				$arryAssemble = $objWarehouse->ListProduction('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status']);
				$num=$objWarehouse->numRows();
			}
	
		$pagerLink=$objPager->getPager($arryAssemble,$RecordsPerPage,$_GET['curP']);
		(count($arryAssemble)>0)?($arryAssemble=$objPager->getPageRecords()):("");
	/**************************************************/	
	require_once("../includes/footer.php"); 	
?>


