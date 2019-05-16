<?php

if(!empty($_GET['pop']))$HideNavigation = 1;
/* * *********************************************** */
$SetFullPage = 1;
/*
if ($_GET['IE'] > 0) {
    $ThisPageName = 'viewVendorInvoiceEntry.php';
} else {
    $ThisPageName = 'viewPoInvoice.php';
}*/
 $ThisPageName = 'viewPoInvoice.php';

/* * *********************************************** */
include_once("../includes/header.php");
require_once($Prefix . "classes/purchase.class.php");
 require_once($Prefix."classes/finance.account.class.php");
$objPurchase = new purchase();
$objBankAccount = new BankAccount();
$ModuleName = "Invoice";
$module = $ModuleName;
$ModuleDepName = 'Purchase' . $ModuleName;
$RedirectURL = $ThisPageName . "?curP=" . $_GET['curP'];



$EditUrl = "editPoInvoice.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"];
//$DownloadUrl = "pdfPoInvoice.php?o=" . $_GET["view"];
$DownloadUrl = "../pdfCommonhtml.php?o=" . $_GET["view"] . "&ModuleDepName=" . $ModuleDepName;

(empty($_GET['IE']))?($_GET['IE']=""):("");
(empty($_GET['po']))?($_GET['po']=""):("");

	/*********************/
	/*********************/
	$CloneURL = "vPoInvoice.php?curP=".$_GET['curP']."&CloneID=".base64_encode($_GET['view']); 
	if(!empty($_GET['CloneID'])){
		$CloneID = base64_decode($_GET['CloneID']);
		$NewCloneID = $objPurchase->CreateCloneOrder($CloneID,$module);
		if(!empty($NewCloneID)){
			$CloneCreated = str_replace("[MODULE]", $module, CLONE_CREATED);
			$CloneCreated = str_replace("[MODULE_ID]", $NewCloneID, $CloneCreated);
			$_SESSION['mess_invoice'] = $CloneCreated;
		}else{
			$_SESSION['mess_invoice'] = CLONE_NOT_CREATED;
		}
		header("Location:".$RedirectURL);
		exit;
	}
	/*********************/
	/*********************/

	



if (!empty($_GET['po'])) {
    $MainModuleName = "Invoices for PO Number# " . $_GET['po'];
    $RedirectURL .= "&po=" . $_GET['po'];
    $EditUrl .= "&po=" . $_GET['po'];
}





if (!empty($_GET['view']) || !empty($_GET['inv'])) {
  
	if(!empty($_GET['inv'])) {
		$arryPurchase = $objPurchase->GetPurchaseDetail('', '', $_GET['inv'] , 'Invoice');
	}else{
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'], '', 'Invoice');
	}
    $OrderID = $arryPurchase[0]['OrderID'];
    /*     * **start code for get tempalte name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName;
    $_GET['ModuleId'] = $_GET['view'];
    $_GET['listview']='1';
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	/*to get default template13Apr2018*/
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//End//
    //echo '<pre>'; print_r($GetPFdTempalteNameArray);die('');
    /*     * **end code for get tempalte name for dynamic pdf by sachin** */
    /*     * ************** */
    if ($Config['vAllRecord'] != 1 && $HideNavigation != 1) {
        if ($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']) {
            header('location:' . $RedirectURL);
            exit;
        }
    }
    /*     * ************** */


	if($arryPurchase[0]['InvoiceEntry'] == "2" || $arryPurchase[0]['InvoiceEntry'] == "3"){
		$RedirectURL = 'vOtherExpense.php?view='.$arryPurchase[0]['ExpenseID'].'&pop='.$_GET['pop'];
		header('location:' . $RedirectURL);
            	exit;
	}



    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);

        /*         * **************************
          $arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
          $arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
          ////////// */

		$BankAccount='';
			if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='prepayment' && !empty($arryPurchase[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}
    } else {
        $ErrorMSG = NOT_EXIST_INVOICE;
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


