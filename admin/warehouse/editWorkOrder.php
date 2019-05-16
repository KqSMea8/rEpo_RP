<?php

/* * *********************************************** */
$ThisPageName = 'viewWorkOrder.php'; $EditPage=1;
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

 

(empty($selectCond))?($selectCond=""):("");

$objItem = new items();
$RedirectURL = "viewWorkOrder.php?curP=" . $_GET['curP'] . "";
$ModuleName = "Work Order";
$objBom = new bom();
$EditUrl = "editWorkOrder.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "";
$pageUrl ="editWorkOrder.php";

if (  !empty($_GET['del_id'])) {
    $objBom->RemoveWorkOrder($_GET['del_id']);
    $_SESSION['mess_asm'] = 'Work Order' . ADJ_REMOVED;
    header("location: " . $RedirectURL);
exit;
}


if (!empty($_POST)) {
	CleanPost();
    if (empty($_POST['warehouse'])) {
        $errMsg = ENTER_WAREHOUSE_ID;
    } else {

	if(!empty($_POST['WON'])){		 
		if($objBom->isWoNumberExists($_POST['WON'],$_POST['edit'])){
			$OtherMsg = str_replace("[MODULE]","Work Order Number", ALREADY_EXIST_ASSIGNED);			 
			$_POST['WON'] = $objConfigure->GetNextModuleID('w_workorder','');
		}
	}


        if (!empty($_POST['edit'])) {
            $objBom->UpdateWorkOrder($_POST);
            $editID = $_POST['edit'];
            $_SESSION['mess_asm'] = 'Work Order' . ADJ_UPDATED.$OtherMsg;
        } else {
             $objBom->AddWorkOrder($_POST);
            $_SESSION['mess_asm'] = 'Work Order' . ADJ_ADDED.$OtherMsg;
        }
        header("Location:" . $RedirectURL);
        exit;
    }
}






	if (!empty($_GET['edit'])) {
			$_GET['id'] = $_GET['edit'];
			$arryWorkOrder = $objBom->ListWorkOrder($_GET);
			//echo $arryWorkOrder[0]['OrderType'];
			//if($arryWorkOrder[0]['OrderType']=='Sale Order') { 


			$Oid = $arryWorkOrder[0]['Oid'];

	    if ($Oid > 0) {
		$arrySaleItem = $objBom->GetWorkOrderItem($Oid);
		$NumLine = sizeof($arrySaleItem);
	    } else {
		$ErrorMSG = $NotExist;
	    }
	}else{
	   $NextModuleID= $objConfigure->GetNextModuleID('w_workorder','');
	}


	if (!empty($_GET['so'])) {
			$arryWorkOrder = $objSale->GetSale($_GET['so'],'','');
			$arryWorkOrder[0]['OrderType']= "Sale Order"; 
			$Oid = $_GET['so'];
		    if ($Oid > 0) {
					$arryBomItem = $objSale->GetSaleBomItem($_GET['so']);
					if(!empty($arryBomItem[0]['sku'])){
						$arryWorkOrder[0]['BOM'] = $arryBomItem[0]['sku'];
						$arryWorkOrder[0]['description'] = $arryBomItem[0]['description'];
						$arryWorkOrder[0]["woCondition"] = $arryBomItem[0]['Condition'];
						$arryWorkOrder[0]["warehouse"] = $arryBomItem[0]['WID'];
						$arryWorkOrder[0]['item_id'] =$arryBomItem[0]['item_id'];
						$arryWorkOrder[0]['req_item'] =$arryBomItem[0]['req_item'];
						$arryWorkOrder[0]['WoQty'] =$arryBomItem[0]['qty'];
						if($arryBomItem[0]['item_id']>0){
							$PID = $arryBomItem[0]['item_id'];
							$arrySaleItem = $objSale->GetSaleComponentItem($_GET['so'],$PID);
							$NumLine = sizeof($arrySaleItem);
						}
					}
			
		    } else {
			$ErrorMSG = $NotExist;
		    }
	}



	$woCondition = (!empty($arryWorkOrder[0]["woCondition"]))?($arryWorkOrder[0]["woCondition"]):('');
 
	$ConditionSelectedDrop  =$objCondition->GetConditionDropValue($woCondition);
 
	$arryWarehouse = $objWarehouse->ListWarehouse('', $_GET['key'], '', '', 1);

	if(empty($NumLine))   $NumLine = 1;
 

	if(empty($arryWorkOrder) ){
		$arryWorkOrder = $objConfigure->GetDefaultArrayValue('w_workorder');	
 	}
	if(empty($arrySaleItem) ){		 
		$arrySaleItem = $objConfigure->GetDefaultArrayValue('w_workorder_bom');				
	}

 
require_once("../includes/footer.php");
?>
