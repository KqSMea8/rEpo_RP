<?php

if(!empty($_GET['pop']))$HideNavigation = 1;
/* * *********************************************** */
$ThisPageName = 'viewRma.php';
$SetFullPage = 1;
/* * *********************************************** */
include_once("../includes/header.php");
require_once($Prefix . "classes/rma.purchase.class.php");
$objPurchase = new purchase();

$ModuleName = "RMA";
$module = $ModuleName;
$ModuleDepName = 'Purchase' . $ModuleName; //sachin
$RedirectURL = "viewRma.php?curP=" . $_GET['curP'];
$EditUrl = "editRma.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"];
//$DownloadUrl = "pdfRma.php?o=" . $_GET["view"];
$DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName;


if (!empty($_GET['po'])) {
    $MainModuleName = "Return for PO Number# " . $_GET['po'];
    $RedirectURL .= "&po=" . $_GET['po'];
    $EditUrl .= "&po=" . $_GET['po'];
}


if (!empty($_GET['view'])) {
    $arryPurchase = $objPurchase->GetPurchaserma($_GET['view'], '', '');

    $OrderID = $arryPurchase[0]['OrderID'];
    /*     * **start code for get template name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName;
    $_GET['ModuleId'] = $_GET['view'];
    $_GET['listview']='1';
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	/*to get default template*/
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
    /*     * **end code for get template name for dynamic pdf by sachin**** */

    /*     * ************** */

    /*     * ************** */
    if ($Config['vAllRecord'] != 1 && $HideNavigation != 1) {
        if ($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']) {
            header('location:' . $RedirectURL);
            exit;
        }
    }
    /*     * ************** */


    if ($OrderID > 0) {
        //echo "hello";
        $arryPurchaseItem = $objPurchase->GetPurchaseItemRMA($OrderID);
        //echo "<pre>";print_r($arryPurchaseItem);
        $NumLine = sizeof($arryPurchaseItem);
    } else {
        $ErrorMSG = NOT_EXIST_RETURN;
    }
} else {
    header("Location:" . $RedirectURL);
    exit;
}

if (empty($NumLine))
    $NumLine = 1;

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

require_once("../includes/footer.php");
?>


