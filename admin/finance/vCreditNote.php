<?php

if(!empty($_GET['pop']))$HideNavigation = 1;
/* * *********************************************** */
$ThisPageName = 'viewCreditNote.php';
$SetFullPage = 1;
/* * *********************************************** */

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/sales.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix."classes/card.class.php");
$objCard = new card();
$objSale = new sale();
$objTax = new tax();
$objBankAccount = new BankAccount();

/* * **************************************************************************************** */
$ModuleName = "Credit Memo";
$module = 'CreditNote';
$ModuleDepName = "SalesCreditMemo";
$RedirectURL = "viewCreditNote.php?curP=" . $_GET['curP'];
$EditUrl = "editCreditNote.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"];
//		$DownloadUrl = "pdfCreditNote.php?o=".$_GET["view"]; 
$DownloadUrl = "../pdfCommonhtml.php?o=" . $_GET["view"] . "&module=&ModuleDepName=" . $ModuleDepName;

(empty($_GET['so']))?($_GET['so']=""):("");
(empty($CreditCardFlag))?($CreditCardFlag=""):("");
 (empty($mmodule))?($mmodule=""):("");

 


/*******Credit Card Process**********/
if(!empty($_GET['OrderID']) && !empty($_GET['Amnt'])  && $_GET['Action']=='VCard'){	 
	$OrderID = base64_decode($_GET['OrderID']);	
	$Config["CreditOrderID"] = $_GET['Crd'];
	$Amnt = base64_decode($_GET['Amnt']);	
	if(!empty($_POST['CardVoidAmount'])){
		$Amnt = $_POST['CardVoidAmount'];
	}
	 	 
	$objCard->VoidSaleCreditCard($OrderID,$Amnt);		
	if(!empty($_SESSION['mess_Sale'])){
		$_SESSION['mess_credit'] = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']);			
	}	
	if(!empty($_SESSION['mess_error_sale'])){
		$_SESSION['mess_credit'] = $_SESSION['mess_error_sale'];
		unset($_SESSION['mess_error_sale']);			
	}  
	$objCard->VoidReverseOrderTransaction($OrderID,'Credit Card');	

	/*******Generate PDF************/			
	$PdfArray['ModuleDepName'] = "SalesCreditMemo";
	$PdfArray['Module'] = "Credit";
	$PdfArray['ModuleID'] = "CreditID";
	$PdfArray['TableName'] =  "s_order";
	$PdfArray['OrderColumn'] =  "OrderID";
	$PdfArray['OrderID'] =  $Config["CreditOrderID"];				 				   
	$objConfigure->GeneratePDF($PdfArray);
	/*******************************/


	$vUrl = "vCreditNote.php?view=".$Config["CreditOrderID"]."&curP=".$_GET["curP"]; 	
	header("Location:".$vUrl);
	exit;
}
/*************************************/

if (!empty($_GET['view']) || !empty($_GET['so'])) {
    $arrySale = $objSale->GetSale($_GET['view'], $_GET['so'], "Credit");
    $OrderID = $arrySale[0]['OrderID'];
     /****start code for get tempalte name for dynamic pdf by sachin***/
		$_GET['ModuleName']=$ModuleDepName;
		$_GET['Module']=$ModuleDepName.$_GET['module'];
		$_GET['ModuleId']=$_GET['view'];
        	$_GET['listview']='1';
		$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);
		/*to get default template3May2018*/
		$_GET['setDefautTem']='1';
		$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);	
    /****end code for get tempalte name for dynamic pdf by sachin***/ 
    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);

	
	if(!empty($arrySale[0]['InvoiceID'])) { 
		$arryInvoice = $objSale->GetInvoice('',$arrySale[0]['InvoiceID'],"Invoice");
		$InvOrderID = (!empty($arryInvoice[0]['OrderID']))?($arryInvoice[0]['OrderID']):("");
 		$PaymentTermInvoice = (!empty($arryInvoice[0]['PaymentTerm']))?($arryInvoice[0]['PaymentTerm']):("");  
 
		/*******Refund Credit Memo Amount*************/
		if($ModifyLabel==1 && $arrySale[0]['Approved'] == 1 && $arrySale[0]['PostToGL'] == 1 && $arrySale[0]['Status'] == "Open" && $PaymentTermInvoice=='Credit Card' && ($arryInvoice[0]['OrderPaid'] == "1" || $arryInvoice[0]['OrderPaid'] == "3") ){ //paid or partially refunded
	
					
			$PaymentTerm = $arryInvoice[0]['PaymentTerm'];
			$CardOrderID = $InvOrderID;

			 
			$TotalRefunded = $objCard->GetTransactionTotalCrd($CardOrderID,'Void',$PaymentTerm,$OrderID);

			$Config["CreditMemoRefund"] = $arrySale[0]['TotalAmount'] -$TotalRefunded ;	
			$TotalInvoiceAmount = $arryInvoice[0]['TotalInvoiceAmount'];
			if($Config["CreditMemoRefund"]>0 && $TotalInvoiceAmount>0 && $Config["CreditMemoRefund"]<=$TotalInvoiceAmount){   
				include_once("includes/html/box/edit_invoice_credit.php");
			}
		}		
		/************************/
 


		if($PaymentTermInvoice=='Credit Card'){
			if($arryInvoice[0]['InvoiceEntry']=="1"){
				$arryCard = $objSale->GetSaleCreditCard($InvOrderID);
			}else if($arryInvoice[0]['InvoiceEntry']=="0" && !empty($arryInvoice[0]['SaleID'])){
				$arryCard = $objSale->GetSaleCreditCard($InvOrderID);
				if(empty($arryCard[0]["CardType"])){
					$SaleOrderID = $objSale->getOrderIDBySaleID($arryInvoice[0]['SaleID']);
					$arryCard = $objSale->GetSaleCreditCard($SaleOrderID);
				}
			}		 
		}
		/************************/
		
	}



        $GLAccount = NOT_SPECIFIED;
        if (!empty($arrySale[0]['AccountID'])) {
            $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
            $GLAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
        }
    } else {
        $ErrorMSG = NOT_EXIST_CREDIT;
    }
} else {
    header("Location:" . $RedirectURL);
    exit;
}


if (empty($NumLine))
    $NumLine = 1;


$arrySaleTax = $objTax->GetTaxRate('1');
$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

$_SESSION['DateFormat'] = $Config['DateFormat'];

/* * ******************************************************************************************************** */

require_once("../includes/footer.php");
?>


