<?php  
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");
	include_once("includes/FieldArray.php");
	$objWarehouse=new warehouse();
        
        $data_Collection = $warehouse_listted = $objWarehouse->AllWarehouses('');
        
        /******Get Warehouse Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryWarehouse=$objWarehouse->ListManageBin($_GET['warehouse'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objWarehouse->ListManageBin($_GET['warehouse'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/
       


	require_once("../includes/footer.php"); 	 
?>


