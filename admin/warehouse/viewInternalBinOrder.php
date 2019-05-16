<?php 
	/**************************************************/
	include_once("../includes/header.php");
	require_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	/**************************************************/
		$objWarehouse=new warehouse();
	
		if(empty($_POST['Add_Production']))	{
			
			
		$arryInternalBinOrder=$objWarehouse->ListBinAssembly('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status']);
				$num=$objWarehouse->numRows();
			}

		$pagerLink=$objPager->getPager($arryInternalBinOrder,$RecordsPerPage,$_GET['curP']);
		(count($arryInternalBinOrder)>0)?($arryInternalBinOrder=$objPager->getPageRecords()):("");
	/**************************************************/	
	require_once("../includes/footer.php"); 	
?>
