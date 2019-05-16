<?php

/* * *********************************************** */
$ThisPageName = 'viewDisassembly.php';  $EditPage = 1; 
/* * *********************************************** */

// require_once("phpuploader/include_phpuploader.php");
require_once("../includes/header.php");
require_once($Prefix . "classes/bom.class.php");
require_once($Prefix . "classes/item.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix . "classes/inv.condition.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
	
$objCondition = new condition();

$objCommon = new common();
$objWarehouse = new warehouse();
$objTax = new tax();
$objTransaction=new transaction();	
$UnitCost =$TaxShowHide ='';

$InventoryGL = $objConfigure->getSettingVariable('InventoryAR');

$objItem = new items();
$RedirectURL = "viewDisassembly.php?curP=" . $_GET['curP'] . "";
$ModuleName = "Disassembly";
$objBom = new bom();
$EditUrl = "editDassemble.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "";
$pageUrl ="editDassemble.php";

/**********************/
/**********************/
if(!empty($_GET['PK3453463463'])) {
	if(empty($InventoryGL)){
		echo SELECT_GL_DSM;die;		 
	}
	$arryDisAssemble = $objBom->ListDisassemble('','','','','');
	$arryPostData['PaymentType'] = 'Disassembly';
	$arryPostData['InventoryGL'] = $InventoryGL;
	foreach ($arryDisAssemble as $key => $values) { 
		if($values['DsmID']>0 && $values['Status']=="2"){ //Dissembly Post To GL 		
			$objTransaction->DisassemblyPostToGL($values['DsmID'],$arryPostData);
 
		}
		
 	}
	die;
}
/**********************/
/**********************/

if(!empty($_GET['del_id'])){
    $objBom->RemoveDisassemble($_GET['del_id']);
    $_SESSION['mess_asm'] = 'Disassembly' . ADJ_REMOVED;
    header("location: " . $RedirectURL);exit;
}



if (!empty($_GET['bc'])) {
    $arryAssemble = $objBom->ListBom($_GET['bc'], '', '', '', '');

//$UnitCost = $objBom->GetUnitCost($arryAssemble[0]['Sku']);
    $bID = $arryAssemble[0]['bomID'];
    if ($bID > 0) {

        if ($arryAssemble[0]['bill_option'] == 'Yes') {
            $arryBomItem = $objBom->GetOptionStock($bID, $_GET['option_code']);
        } else {

            $arryBomItem = $objBom->GetBOMStock($bID, '');
        }
        $loadAssemble = 1;
        //$arrayItem = $objItem->checkItemSku($arryAssemble[0]['Sku']);
        //$UnitCost =$arrayItem[0]['purchase_cost'];

$exist=$objItem->checkItemSku($arryAssemble[0]['Sku']);

//echo "<pre>";
//print_r($exist);
			if(!empty($exist))
			{
				$arryProduct=$objItem->getItemCondionQty($arryAssemble[0]['Sku'],$arryAssemble[0]['bomCondition']);
        $arrayItem[0]['evaluationType'] = $exist[0]['evaluationType'];
			}
			if(!empty($arryProduct[0]['condition_qty'])){
						$arrayItem[0]['qty_on_hand']=$arryProduct[0]['condition_qty'];
						$arrayItem[0]['SalePrice'] = $arryProduct[0]['SalePrice'];
			}else {
						$arrayItem[0]['condition_qty']='0';
						$arrayItem[0]['SalePrice'] = '0.00';
			}

 


if($arrayItem[0]['evaluationType'] =='LIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'ASC';
							$_GET['Sku'] = $exist[0]['Sku'];
              $_GET['Condition']  = $arryAssemble[0]['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET,'');
							$cost[0]['AvgCost'] = (!empty($arryVendorPrice[0]['price']))?(number_format($arryVendorPrice[0]['price'],2)):(0);

					}else if($arrayItem[0]['evaluationType'] =='FIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'DESC';
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $arryAssemble[0]['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET,'');
							

							$cost[0]['AvgCost'] =  (!empty($arryVendorPrice[0]['price']))?(number_format($arryVendorPrice[0]['price'],2)):(0);
					}else{
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $arryAssemble[0]['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgSerialPrice($exist[0]['ItemID'],$_GET);
							//$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
							 
							$cost[0]['AvgCost'] =  (!empty($arryVendorPrice[0]['price']))?(number_format($arryVendorPrice[0]['price'],2)):(0);
					}

$arryAssemble[0]['total_dis_cost'] = (!empty($cost[0]['AvgCost'])) ? $cost[0]['AvgCost']:'0.00';
			
        $NumLine = sizeof($arryBomItem);
    } else {
        $ErrorMSG = $NotExist;
    }
}


if (!empty($_GET['edit'])) {

    $arryAssemble = $objBom->ListDisassemble($_GET['edit'], '', '', '', '');


    //$arrayItem = $objItem->checkItemSku($arryAssemble[0]['Sku']);
//$UnitCost =$arrayItem[0]['purchase_cost'];
    $bID = $arryAssemble[0]['DsmID'];
$exist=$objItem->checkItemSku($arryAssemble[0]['Sku']);

//echo "<pre>";
//print_r($exist);
			if(!empty($exist))
			{
				$arryProduct=$objItem->getItemCondionQty($arryAssemble[0]['Sku'],$arryAssemble[0]['bomCondition']);
        $arrayItem[0]['evaluationType'] = $exist[0]['evaluationType'];
			}
			if(!empty($arryProduct[0]['condition_qty'])){
						$arrayItem[0]['qty_on_hand']=$arryProduct[0]['condition_qty'];
						$arrayItem[0]['SalePrice'] = $arryProduct[0]['SalePrice'];
			}else {
						$arrayItem[0]['qty_on_hand']='0';
						$arrayItem[0]['SalePrice'] = '0.00';
			}


if($arrayItem[0]['evaluationType'] =='LIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'ASC';
							$_GET['Sku'] = $exist[0]['Sku'];
              $_GET['Condition']  = $arryAssemble[0]['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET,'');
							$cost[0]['AvgCost'] =number_format($arryVendorPrice[0]['price'],2);
					}else if($arrayItem[0]['evaluationType'] =='FIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'DESC';
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $arryAssemble[0]['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET,'');
							$cost[0]['AvgCost'] = number_format($arryVendorPrice[0]['price'],2);
					}else{
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $arryAssemble[0]['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgSerialPrice($exist[0]['ItemID'],$_GET);
							//$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
							$cost[0]['AvgCost'] = number_format($arryVendorPrice[0]['price'],2);
					}

$arryAssemble[0]['total_dis_cost'] = (!empty($cost[0]['AvgCost'])) ? $cost[0]['AvgCost']:'0.00';
    $loadAssemble = 0;

    if ($bID > 0) {
        $arryBomItem = $objBom->GetDisassembleStock($bID);
        $NumLine = sizeof($arryBomItem);
    } else {
        $ErrorMSG = $NotExist;
    }
}




if ($_POST) {
	CleanPost();



    if (empty($_POST['warehouse'])) {
        $errMsg = ENTER_WAREHOUSE_ID;
    } else {

	if($_POST['Status']=="2" && empty($InventoryGL)){
		$_SESSION['mess_dsm']  = SELECT_GL_DSM;		 
		header("Location:" . $EditUrl);
		exit;
	}


        if (!empty($_POST['DsmID'])) {

            $objBom->UpdateDisassemble($_POST);
            $disassemblyID = $_POST['DsmID'];
            //$objBom->AddUpdateDisassembleItem($disassemblyID, $_POST);
            $_SESSION['mess_asm'] = 'Disassembly Item' . ADJ_UPDATED;
        } else {
            $disassemblyID = $objBom->AddDisassemble($_POST);
            //$objBom->AddDisassembleItem($disassemblyID, $_POST);
            $_SESSION['mess_asm'] = 'Disassembly Item' . ADJ_ADDED;
        }

	$objBom->AddUpdateDisassembleItem($disassemblyID, $_POST);
        //$objBom->updateStockQty($_POST);


	/***PK********/
	if($disassemblyID>0 && $_POST['Status']=="2"){ //Dissembly Post To GL	 		 
		$arryPostData['PostToGLDate'] = $_POST['PostToGLDate']; //empty now
		$arryPostData['PaymentType'] = 'Disassembly';
		$arryPostData['InventoryGL'] = $InventoryGL;
		$objTransaction->DisassemblyPostToGL($disassemblyID,$arryPostData);
	}
	/**************/ 

        header("Location:" . $RedirectURL);
        exit;
    }
}




if(empty($arryAssemble)){    
	$arryAssemble = $objConfigure->GetDefaultArrayValue('inv_disassembly');
}


$ConditionDrop  =$objCondition-> GetConditionDropValue($arryAssemble[0]['bomCondition']);
$arryReason = $objCommon->GetCrmAttribute('AdjReason', '');
$arryWarehouse = $objWarehouse->ListWarehouse('', $_GET['key'], '', '', 1);
$arrySaleTax = $objTax->GetTaxRate(1);
$arryPurchaseTax = $objTax->GetTaxRate('2');

if (empty($NumLine))
    $NumLine = 1;



require_once("../includes/footer.php");
?>
