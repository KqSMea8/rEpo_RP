<?php

    /**************************************************/
	$ThisPageName = 'viewProduction.php'; 
    /**************************************************/
	
      //require_once("phpuploader/include_phpuploader.php");
	require_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	

	$objCommon=new common();
	$objWarehouse=new warehouse();
	$objTax = new tax();
	$objItem = new items();
	
$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
	
        $RedirectURL = "viewProduction.php?curP=".$_GET['curP']."";
		$ModuleName  = "Assemble";
		$objBom=new bom();        
        $EditUrl = "editProduction.php?edit=".$_GET["view"]."&curP=".$_GET["curP"].""; 
                    
	if(!empty($_GET['view'])){
	
		$arryAssemble = $objWarehouse->ListAssemble($_GET['view'],'','','','');
		//print_r($arryAssemble);
		//exit;
		$BomID = $arryAssemble[0]['bomID'];
		$bID   = $arryAssemble[0]['asmID'];	
			if($bID>0)
				{
					$arryBomItem = $objBom->GetAssembleStock($bID);
					$loadAssemble = 0;
					$NumLine = sizeof($arryBomItem);
				}
			else
				{
					$ErrorMSG = $NotExist;
				}
	}
	
	if(!empty($_POST['Submit'])&&$_POST['Submit'])
		{
		//echo '<pre>';
		//print_r($arryAssemble);
		$checkAssembly=$objWarehouse->checkAssembly($arryAssemble[0]);
        //print_r($_POST);
		//exit;
		if(empty($checkAssembly))
		{
		$warehouseID=$objWarehouse->getAssemblyIntoWarehouse($arryAssemble[0],$_POST);	
		$warehouseItemID=$objWarehouse->getAssemblyItemsIntoWarehouse($arryBomItem,$NumLine,$_POST);
		}
		/*else
		{
		$updateItemID=$objWarehouse->updateAssemblyItemsIntoWarehouse($_POST,$NumLine);
		}
		*/
		header("Location:".$RedirectURL);
				exit;
		}
	require_once("../includes/footer.php"); 
	
?>
