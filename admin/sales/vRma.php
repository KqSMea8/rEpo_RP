<?php

if(!empty($_GET['pop']))$HideNavigation = 1;
/* * *********************************************** */
$ThisPageName = "viewRma.php";
$EditPage = 1;
$SetFullPage = 1;
/* * *********************************************** */

include_once("../includes/header.php");
require_once($Prefix . "classes/rma.sales.class.php");
require_once($Prefix . "classes/inv_tax.class.php");

$objrmasale = new rmasale();

$objTax = new tax();

$Module = "RMA";
$ModuleDepName = 'Sales' . $Module; //bysachin
$ModuleIDTitle = "Return Number";
$ModuleID = "ReturnID";
$PrefixPO = "RTN";
$NotExist = NOT_EXIST_ORDER;
$RedirectURL = "viewRma.php?curP=" . $_GET['curP'];
//$DownloadUrl = "pdfRma.php?RTN=" . $_GET["view"] . "";
$DownloadUrl = "../pdfCommonhtml.php?o=" . $_GET["view"] . "&ModuleDepName=" . $ModuleDepName; //bysachin

if (!empty($_GET['view'])) {

    if (!empty($_GET['Module'])) {
        $Md = $_GET['Module'];
    } else {
        $Md = 'RMA';
    }
    $arrySale = $objrmasale->GetReturn($_GET['view'], '', $Md);
    $OrderID = $arrySale[0]['OrderID'];
    $SaleID = $arrySale[0]['SaleID'];
    /*     * **start code for get template name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName;
    $_GET['ModuleId'] = $_GET['view'];
    $_GET['listview']='1';
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	/*to get default template16Apr2018by chetan*/
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//End//
    /*     * **end code for get template name for dynamic pdf by sachin**** */

    if ($OrderID > 0) {
        $arrySaleItem = $objrmasale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);
        //if($_GET['d']==1)print_r($arrySaleItem);
        $TotalGenerateReturn = $objrmasale->GetQtyReturned($OrderID);
        if ($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']) {
            $HideSubmit = 1;
            $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
        }
    }
    $ModuleName = "View " . $Module;
    $HideSubmit = 1;
}


if (empty($NumLine))
    $NumLine = 1;
$arrySaleTax = $objTax->GetTaxRate('1');

	$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

require_once("../includes/footer.php");
?>


