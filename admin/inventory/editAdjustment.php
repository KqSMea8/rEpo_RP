<?php
/**************************************************/
$ThisPageName = 'viewAdjustment.php'; $EditPage = 1;  $SetFullPage = 1;
/**************************************************/

require_once("../includes/header.php");
require_once($Prefix . "classes/item.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix . "classes/inv.condition.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
$objTransaction=new transaction();
$objCommon = new common();
$objWarehouse = new warehouse();
$objTax = new tax();
$objCondition = new condition();
$objItem = new items();

$RedirectURL = "viewAdjustment.php?curP=" . $_GET['curP'] . "";
$ModuleName = "Adjustment";
$EditUrl = "editAdjustment.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "";
$disNone=$ModuleIDTitle=$TaxShowHide=$PrefixPO='';
/***PK********/
$OpeningStock = $objConfigure->getSettingVariable('OpeningStock');
$InventoryGL = $objConfigure->getSettingVariable('InventoryAR');
$InventoryAdjustment = $objConfigure->getSettingVariable('InventoryAdjustment');
/***********/

if($_GET['AllStock']=='353455345pk123') {
	#$objTransaction->AllStockAdjustmentPostToGL();exit;
}

/*******  Multiple Actions To Perform *********

if (!empty($_GET['multiple_action_id'])) {
    $multiple_action_id = rtrim($_GET['multiple_action_id'], ",");
    $RedirectURLPage = "viewItem.php?curP=" . $_GET['curP'] . "&CatID=" . $_GET['dCatID'];

    switch ($_GET['multipleAction']) {
        case 'delete':
            $objItem->RemoveMultipleItem($multiple_action_id, 0);
            $_SESSION['mess_adjustment'] = 'Adjustment ' . ADJ_REMOVED;
            break;
        case 'active':
            $objItem->MultipleItemStatus($multiple_action_id, 1);
            $_SESSION['mess_adjustment'] = 'Adjustment ' . ACTIVATED;
            break;
        case 'inactive':
            $objItem->MultipleItemStatus($multiple_action_id, 0);
            $_SESSION['mess_adjustment'] = 'Adjustment ' . INACTIVATED;
            break;
    }
    header("location: " . $RedirectURLPage);
}

/********  End Multiple Actions **********/

if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $objItem->RemoveAdjustment($_GET['del_id']);
    $_SESSION['mess_adjustment'] = 'Adjustment' . ADJ_REMOVED;
    header("location: " . $RedirectURL);
    exit;
}




if ($_POST) {
    CleanPost();

    if (empty($_POST['warehouse'])) {
        $errMsg = ENTER_WAREHOUSE_ID;
    }else{

	if($_POST['Status']=="2" && (empty($InventoryGL) || empty($InventoryAdjustment))){
		$_SESSION['mess_adjustment']  = SELECT_GL_ADJUSTMENT;		 
		header("Location:" . $EditUrl);
		exit;
	}


        if(!empty($_POST['adjID'])) {
            $objItem->UpdateAdjustment($_POST);
            $adjustID = $_POST['adjID'];
            $_SESSION['mess_adjustment'] = 'Adjustment' . ADJ_UPDATED;
        }else {
            $adjustID = $objItem->AddAdjustment($_POST);
            $_SESSION['mess_adjustment'] = 'Adjustment' . ADJ_ADDED;
        }
       	
	$objItem->AddUpdateStock($adjustID, $_POST);

	/***PK********/
	if($adjustID>0 && $_POST['Status']=="2"){ //Adjustment Post To GL
 		$arryPostData['OpeningStock'] = $OpeningStock;
		$arryPostData['PostToGLDate'] = $_POST['PostToGLDate']; //empty now
		$arryPostData['PaymentType'] = 'Stock Adjustment ('.$_POST['adjustment_reason'].')';
		$arryPostData['InventoryGL'] = $InventoryGL;
		$arryPostData['InventoryAdjustment'] = $InventoryAdjustment;
		$objTransaction->StockAdjustmentPostToGL($adjustID,$arryPostData);
	}
	/**************/ 

        header("Location:" . $RedirectURL);
        exit;
    }
}


/**************/ 
if(!empty($_GET['edit'])) {
    $arryAdjustment = $objItem->ListingAdjustment($_GET['edit'], '', '', '', '');
    $adjID = $arryAdjustment[0]['adjID'];
    if ($adjID > 0) {
        $arryAdjustmentItem = $objItem->GetAdjustmentStock($adjID);
        $NumLine = sizeof($arryAdjustmentItem);
    } else {
        $ErrorMSG = $NotExist;
    }
	$HideTr='';
}else{
	$arryAdjustment[0]['adjDate'] = $Config["TodayDate"];
	$HideTr = '  style="display:none"';
}

 if($arryAdjustment[0]['Status'] == 2){     
	  header("location: " . $RedirectURL);
	  exit;     
 }
/**************/ 



$arryReason = $objCommon->GetCrmAttribute('AdjReason', '');
$arryWarehouse = $objWarehouse->ListWarehouse('', $_GET['key'], '', '', 1);



$arrySaleTax = $objTax->GetTaxRate(1);
$arryPurchaseTax = $objTax->GetTaxRate('2');
if (empty($NumLine))
    $NumLine = 1;



require_once("../includes/footer.php");
?>
