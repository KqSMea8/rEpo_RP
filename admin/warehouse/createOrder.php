<?php

/* * *********************************************** */
$ThisPageName = 'viewWorkOrder.php';
/* * *********************************************** */
require_once("../includes/header.php");
require_once($Prefix . "classes/bom.class.php");
require_once($Prefix . "classes/item.class.php");
require_once($Prefix."classes/inv.condition.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix . "classes/warehouse.class.php");

$objWarehouse = new warehouse();
$objSale = new sale();
$objCondition=new condition();

(!$_GET['curP']) ? ($_GET['curP'] = 1) : (""); // current page number
$objItem = new items();
$RedirectURL = "vWorkOrder.php?view=".$_GET['woID']."&curP=" . $_GET['curP'] . "";
$ModuleName = "Work Order";
$objBom = new bom();

$arryBomItem =array();
if (!empty($_GET['woID'])) {
		$_GET['id'] = $_GET['woID'];
		$arryWorkOrder = $objBom->ListWorkOrder($_GET);

			//echo $arryWorkOrder[0]['OrderType'];
			//if($arryWorkOrder[0]['OrderType']=='Sale Order') { 
			
			$arryBomItem['Sku'] = $arryWorkOrder[0]['BOM'];
			$arryBomItem['description'] = $arryWorkOrder[0]['description'];
			
       $arryBomItem['bomCondition'] = $arryWorkOrder[0]["woCondition"];

			$arryBomItem['on_hand_qty'] = $arryWorkOrder[0]["warehouse"];
			$arryBomItem['assembly_qty'] = $arryWorkOrder[0]["WoQty"];
      $arryBomItem['disassembly_qty'] = $arryWorkOrder[0]["WoQty"];
      $arryBomItem['price'] =$arryWorkOrder[0]['price']*$arryWorkOrder[0]["WoQty"];
			$arryBomItem["warehouse"] = $arryWorkOrder[0]['warehouse'];
			$arryBomItem['item_id'] =$arryWorkOrder[0]['item_id'];
			$arryBomItem['req_item'] =$arryWorkOrder[0]['req_item'];
			$arryBomItem['WoQty'] =$arryWorkOrder[0]['qty'];

		$Oid = $arryWorkOrder[0]['Oid'];

    if ($Oid > 0) {
        $arrySaleItem = $objBom->GetWorkOrderItem($Oid);
        $NumLine = sizeof($arrySaleItem);
$arryBomItem['NumLine'] =$NumLine;
for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;
$arryBomItem['sku'.$Line] = $arrySaleItem[$Count]['sku'];
$arryBomItem['description'.$Line] = $arrySaleItem[$Count]['description'];
$arryBomItem['Condition'.$Line] = $arrySaleItem[$Count]['Condition'];
$arryBomItem['item_id'.$Line] = $arrySaleItem[$Count]['item_id'];
$arryBomItem['qty'.$Line] = $arrySaleItem[$Count]['qty'];
$arryBomItem['price'.$Line] = $arrySaleItem[$Count]['price'];
$arryBomItem['amount'.$Line] = $arrySaleItem[$Count]['price']*$arrySaleItem[$Count]['qty'];

$total +=$arryBomItem[0]['amount'.$Line];
}

$arryBomItem['TotalValue'] = $total;
//array_merge($a1,$a2)
$arrMain = array_merge($arryBom,$arryBomItem);

if($_GET['type'] == 'Assembly'){
$assemblyID = $objBom->AddAssemble($arryBomItem); 
			$objBom->AddAssembleItem($assemblyID, $arryBomItem); 
$objBom->UpdateRefID('',$assemblyID, $_GET['woID']);                  
			$_SESSION['mess_asm'] = 'Assembly Item'.ADJ_ADDED;
	header("Location:".$RedirectURL);
		exit;
}
if($_GET['type'] == 'Dassembly'){

$exist=$objItem->checkItemSku($arryBomItem['Sku']);

//echo "<pre>";
//print_r($exist);
			if(!empty($exist))
			{
				$arryProduct=$objItem->getItemCondionQty($arryBomItem['Sku'],$arryBomItem['bomCondition']);
        $arrayItem[0]['evaluationType'] = $exist[0]['evaluationType'];
			}
			if($arryProduct[0]['condition_qty']!=''){
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
              $_GET['Condition']  = $arryBomItem['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET);
							$cost[0]['AvgCost'] =number_format($arryVendorPrice[0]['price'],2);
					}else if($arrayItem[0]['evaluationType'] =='FIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'DESC';
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $arryBomItem['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET);
							$cost[0]['AvgCost'] = number_format($arryVendorPrice[0]['price'],2);
					}else{
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $arryBomItem['bomCondition'];
							$arryVendorPrice=$objItem->GetAvgSerialPrice($exist[0]['ItemID'],$_GET);
							//$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
							$cost[0]['AvgCost'] = number_format($arryVendorPrice[0]['price'],2);
					}

$arryBomItem['total_dis_cost'] = (!empty($cost[0]['AvgCost'])) ? $cost[0]['AvgCost']:'0.00';

$arryBomItem['Serialized'] = $exist[0]['evaluationType'];



$disassemblyID = $objBom->AddDisassemble($arryBomItem);
            //$objBom->AddDisassembleItem($disassemblyID, $_POST);
            $_SESSION['mess_asm'] = 'Disassembly Item' . ADJ_ADDED;
$objBom->AddUpdateDisassembleItem($disassemblyID, $arryBomItem);

$objBom->UpdateRefID($disassemblyID,'', $_GET['woID']);



	header("Location:".$RedirectURL);
		exit;

}

    } else {
        $ErrorMSG = $NotExist;
    }
}



require_once("../includes/footer.php");
?>
