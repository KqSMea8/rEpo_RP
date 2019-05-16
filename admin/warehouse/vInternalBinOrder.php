<?php

    /**************************************************/
	$ThisPageName = 'viewInternalBinOrder.php'; 
    /**************************************************/
	
	require_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/warehousing.class.php");
	/**************************************************/
		$objCommon=new common();
		$objWarehouse=new warehouse();
		$objTax = new tax();
		$objItem = new items();
		$arryPackageType = $objCommon->GetAttribValue('PackageType','');
		$arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
		$ModuleIDTitle = "Receive Number"; 
		$RedirectURL = "viewInternalBinOrder.php?curP=".$_GET['curP']."";
		$ModuleName  = "Internal Bin Order";
		$objBom=new bom();        
		$EditUrl = "editInternalBinOrder.php?edit=".$_GET["view"]."&curP=".$_GET["curP"].""; 
		(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number	
	/**************************************************/
	
		
			if(!empty($_GET['view']))	 {
				$arryAssemble = $objWarehouse->ListBinAssembly($_GET['view'],'','','','');
				$BomID = $arryAssemble[0]['bomID'];
				$bID   = $arryAssemble[0]['asmID'];	
				
						if($bID>0)	{ 
								$arryBomItem = $objWarehouse->GetAssembleStock($bID);
								$loadAssemble = 0;
								$NumLine = sizeof($arryBomItem);
						}else	{
								$ErrorMSG = $NotExist;
						}
		
			}


			if($_GET['del_id'] && !empty($_GET['del_id']))	{
		
				$objWarehouse->RemoveAssembleFromBin($_GET['del_id']);
				$_SESSION['mess_asm'] = 'Assemble'.ADJ_REMOVED;
				header("location: ".$RedirectURL);
			}

			if(!empty($_POST))	{

		//	$checkAssembly=$objWarehouse->checkAssembly($arryAssemble[0]);
				if(!empty($_GET['edit'])&&empty($_GET['popup']))	{
				
					$updateItemID=$objWarehouse->updateAssemblyIntoBin($_POST,$NumLine,$arryAssemble[0]);
					$_SESSION['mess_asm'] = 'Assemble'.ADJ_UPDATED;
				}else if(!empty($_GET['popup'])&&empty($_GET['edit']))	{
				
					$warehouseID=$objWarehouse->getAssemblyIntoBin($arryAssemble[0],$_POST);	
					//$warehouseItemID=$objWarehouse->getAssemblyItemsIntoWarehouse($arryBomItem,$NumLine,$_POST);
					$_SESSION['mess_asm'] = 'Assemble'.ADJ_ADDED;
				}
			
				header("Location:".$RedirectURL);
				exit;
			}
		

	/**************************************************/
	require_once("../includes/footer.php"); 
?>
 