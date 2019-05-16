<?php

    /**************************************************/
	$ThisPageName = 'viewAssemble.php';  $EditPage = 1; 
    /**************************************************/
	
      //require_once("phpuploader/include_phpuploader.php");
	require_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix . "classes/inv.condition.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	
	$objCondition = new condition();
	$objCommon=new common();
	$objWarehouse=new warehouse();
	$objTax = new tax();
	$objItem = new items();
	$objTransaction=new transaction();	
	$ref_code=$BomID=$TaxShowHide='';

	(empty($_GET['option_code'])) ? ($_GET['option_code']='') : ("");

	$InventoryGL = $objConfigure->getSettingVariable('InventoryAR');
	
        $RedirectURL = "viewAssemble.php?curP=".$_GET['curP']."";
	$ModuleName  = "Assembly";
	$objBom=new bom();        
        $EditUrl = "editAssemble.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"].""; 
	$pageUrl ="editAssemble.php";
        
	 if(!empty($_GET['del_id'])){		
		$objBom->RemoveAssemble($_GET['del_id']);
                $_SESSION['mess_asm'] = 'Assemble'.ADJ_REMOVED;
		header("location: ".$RedirectURL);
		exit;
	 }
	 

	
	if(!empty($_GET['bc'])){
		$arryAssemble = $objBom->ListBom($_GET['bc'],'','','','');
                //$arryAssemble = $objBom->GetBOM($_GET['bc']);
                $arryOptionCat=$objBom->GetOptionBill($_GET['option_code'],$_GET['bc']);
               
		$BomID = $_GET['bc'];
		$bID   = $arryAssemble[0]['bomID'];
	
			if($bID>0){
                        $loadAssemble =1;
			if($arryAssemble[0]['bill_option']=='Yes'){
			   $arryBomItem = $objBom->GetOptionStock($bID,$_GET['option_code']);
			}else{
			  $arryBomItem = $objBom->GetBOMStock($bID,'');
			}
			$arrayItem = $objItem->checkItemSku($arryAssemble[0]['Sku']);
			$NumLine = sizeof($arryBomItem);
			}else{
			$ErrorMSG = $NotExist;
			}
	}

                
	if(!empty($_GET['edit'])){
		$arryAssemble = $objBom->ListAssemble($_GET['edit'],'','','','');

		$BomID = $arryAssemble[0]['bomID'];
		$bID   = $arryAssemble[0]['asmID'];	
                
                $arrayItem = $objItem->checkItemSku($arryAssemble[0]['Sku']);
			if($bID>0){
				$arryBomItem = $objBom->GetAssembleStock($bID);
                                $loadAssemble = 0;
			          $NumLine = sizeof($arryBomItem);
			}else{
			          $ErrorMSG = $NotExist;
			}
                 
	}
		

		

if($_POST) {
	CleanPost();
	if(empty($_POST['warehouse'])) {
		$errMsg = ENTER_WAREHOUSE_ID;
	}else {

		if($_POST['Status']=="2" && empty($InventoryGL)){
			$_SESSION['mess_asm']  = SELECT_GL_ASM;		 
			header("Location:" . $EditUrl);
			exit;
		}
	 

		if(!empty($_POST['asmID'])) {
			$objBom->UpdateAssemble($_POST);
			$assemblyID = $_POST['asmID'];
			$objBom->AddUpdateAssembleItem($assemblyID, $_POST);
			$_SESSION['mess_asm'] = 'Assembly Item'.ADJ_UPDATED;
		}else {	 
			$assemblyID = $objBom->AddAssemble($_POST); 
			$objBom->AddAssembleItem($assemblyID, $_POST);                   
			$_SESSION['mess_asm'] = 'Assembly Item'.ADJ_ADDED;
		}
		//$objBom->updateStockQty($_POST);

		/***PK********/
		if($assemblyID>0 && $_POST['Status']=="2"){ //Assembly Post To GL	 		 
			$arryPostData['PostToGLDate'] = $_POST['PostToGLDate']; //empty now
			$arryPostData['PaymentType'] = 'Assembly';
			$arryPostData['InventoryGL'] = $InventoryGL;
			$objTransaction->AssemblyPostToGL($assemblyID,$arryPostData);
		}
		/**************/ 


		header("Location:".$RedirectURL);
		exit;		
	}
}



	if(empty($arryAssemble)){    
		$arryAssemble = $objConfigure->GetDefaultArrayValue('inv_assembly');
	}
	/*if(empty($arryBomItem)){    
		$arryBomItem = $objConfigure->GetDefaultArrayValue('inv_item_assembly');
	}*/

	 

	$arryReason = $objCommon->GetCrmAttribute('AdjReason','');
        $arryWarehouse=$objWarehouse->ListWarehouse('',$_GET['key'],'','',1);
	
	$arrySaleTax = $objTax->GetTaxRate(1);
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	if(empty($NumLine)) $NumLine = 1;

	$ConditionDrop  =$objCondition-> GetConditionDropValue($arryAssemble[0]['bomCondition']);



	
 
			 
	
	require_once("../includes/footer.php"); 
	
?>
