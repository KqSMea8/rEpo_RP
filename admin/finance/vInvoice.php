<?php

if(!empty($_GET['pop']))$HideNavigation = 1;

$SetFullPage = 1;
/* * *********************************************** */
$ThisPageName = 'viewInvoice.php';
/* * *********************************************** */

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/sales.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix."classes/card.class.php");
require_once($Prefix."classes/employee.class.php");		
 
$objEmployee=new employee();
$objCommon = new common();
$objSale = new sale();
$objTax = new tax();
$objBankAccount = new BankAccount();
$objCard = new card();

$module = 'Invoice';
$ModuleDepName = 'Sales' . $module;
$ModuleName = $module;

$RedirectURL = "viewInvoice.php?curP=" . $_GET['curP'];
$EditUrl = "editInvoice.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"];

(empty($_GET['so']))?($_GET['so']=""):("");
(empty($_GET['inv']))?($_GET['inv']=""):("");
(empty($_GET['IE']))?($_GET['IE']=""):("");
(empty($Config['Junk']))?($Config['Junk']=""):("");
 (empty($_GET['OrderID']))?($_GET['OrderID']=""):("");

 $HideEdit=$CreditCardFlag=$OrderSourceFlag='';

//$DownloadUrl = "pdfInvoice.php?IN=".$_GET["view"].""; 
$DownloadUrl = "../pdfCommonhtml.php?o=" . $_GET["view"] . "&ModuleDepName=" . $ModuleDepName;

$ModuleIDTitle = "Invoice Number";
$ModuleID = "InvoiceID";
$PrefixSale = "IN";
$NotExist = NOT_EXIST_INVOICE;




	/*********************/
	/*********************/
	$CloneURL = "vInvoice.php?curP=".$_GET['curP']."&CloneID=".base64_encode($_GET['view']); 
	if(!empty($_GET['CloneID'])){
		$CloneID = base64_decode($_GET['CloneID']);
		$NewCloneID = $objSale->CreateCloneOrder($CloneID,$module);
		if(!empty($NewCloneID)){
			$CloneCreated = str_replace("[MODULE]", $module, CLONE_CREATED);
			$CloneCreated = str_replace("[MODULE_ID]", $NewCloneID, $CloneCreated);
			$_SESSION['mess_Invoice'] = $CloneCreated;
		}else{
			$_SESSION['mess_Invoice'] = CLONE_NOT_CREATED;
		}
		header("Location:".$RedirectURL);
		exit;
	}
	/*********************/
	/*********************/





if (!empty($_GET['view']) || !empty($_GET['so']) || !empty($_GET['inv'])) {
	//$arrySale = $objSale->GetSale($_GET['view'], $_GET['so'], $module);
	$arrySale = $objSale->GetInvoice($_GET['view'], $_GET['inv'], $module);
	$OrderID = $arrySale[0]['OrderID'];
	$SaleID   = $arrySale[0]['SaleID'];

        /*****code for get document by sachin******/

		 $OrderIDForOrderDocumentArry=$objSale->GetOrderIDForOrderDocument($arrySale[0]['SaleID'],'Order');
		 //PR($OrderIDForOrderDocumentArry);
		 //echo $OrderIDForOrderDocumentArry[0]['OrderID'];
if($_GET['IE']==1){

		$_GET['OrderID']=$_GET['view'];
                $_GET['Module']='SalesInvoice';
                $_GET['ModuleName']='SalesInvoice';

}else{
	      if(!empty($OrderIDForOrderDocumentArry[0]['OrderID']))  
			$_GET['OrderID']=$OrderIDForOrderDocumentArry[0]['OrderID'];

                $_GET['Module']='SalesOrder';
                $_GET['ModuleName']='Sales';
}
                $getDocumentArry=$objConfig->GetOrderDocument($_GET);
                //PR($getDocumentArry);
	/*****code for get document by sachin******/
	if($arrySale[0]['InvoiceEntry']>0){	 
		$EditUrl = "editInvoiceEntry.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"];
	} else {
		$EditUrl = "editInvoice.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"];
	}



	if($arrySale[0]['InvoicePaid'] != 'Unpaid' || $arrySale[0]['PostToGL'] == "1") { 
		$HideEdit=1;
	}

	if($arrySale[0]['InvoiceEntry'] == "2" || $arrySale[0]['InvoiceEntry'] == "3"){
		$RedirectURL = 'vInvoiceGl.php?view='.$OrderID.'&pop='.$_GET['pop'];
		header('location:' . $RedirectURL);
            	exit;
	}


    /*     * **start code for get tempalte name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName;
    $_GET['ModuleId'] = $_GET['view'];
    $_GET['listview']='1';
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	/*to get default dynamic template on 12Mar2018 by chetan*/
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//End//

    /*     * **end code for get tempalte name for dynamic pdf by sachin** */
//echo '<pre>';print_r($arrySale);exit;
    /*     * ************** */
    if ($Config['vAllRecord'] != 1 && $HideNavigation != 1) {
        if ($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']) {
            header('location:' . $RedirectURL);
            exit;
        }
    }
    /*     * ************** */



    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);

	/***********************/
	 
		$arryShippInfo = $objCommon->GetShippingInfoInvoice($arrySale[0]['TrackingNo'],$arrySale[0]['InvoiceID']);
	if(!empty($arryShippInfo[0]['ShipType'])){
		$ShipType = $arryShippInfo[0]['ShipType'];
		$ShipTrackingID = $arryShippInfo[0]['trackingId'];
		$ShipFreight = $arryShippInfo[0]['totalFreight'];				 
	}			
	/***********************/


        //get payment history

        $arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
        $paidAmnt = $objSale->GetTotalPaymentAmntForInvoice($OrderID);

        $InvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];

        if ($paidAmnt > 0) {
            $remainInvoiceAmount = $InvoiceAmount - $paidAmnt;
        } else {
            $remainInvoiceAmount = $InvoiceAmount;
        }
        if ($paidAmnt == $InvoiceAmount) {
            $objSale->updateInvoiceStatus($OrderID);
        }
        //end

        /*$GLAccount = NOT_SPECIFIED;
        if (!empty($arrySale[0]['AccountID'])) {
            $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
            $GLAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
        }*/

 //modified by nisha on 24 sept 2018
	if((!empty($arrySale[0]['SalesPersonID'])) || (!empty($arrySale[0]['VendorSalesPerson']))){
        	if(!empty($arrySale[0]['VendorSalesPerson'])){
	$SuppID=$arrySale[0]['VendorSalesPerson'];
		}
		if(!empty($arrySale[0]['SalesPersonID'])){
			$EmpID=$arrySale[0]['SalesPersonID']; 
		}	
		$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID,$SuppID); 
	}

	$BankAccount='';
	if($arrySale[0]['PaymentTerm']=='Credit Card'){
		if($arrySale[0]['InvoiceEntry']=="1"){
			$arryCard = $objSale->GetSaleCreditCard($OrderID);
		}else if($arrySale[0]['InvoiceEntry']=="0" && !empty($SaleID)){
			$arryCard = $objSale->GetSaleCreditCard($OrderID);
			if(empty($arryCard[0]["CardType"])){
				$SaleOrderID = $objSale->getOrderIDBySaleID($SaleID);
				$arryCard = $objSale->GetSaleCreditCard($SaleOrderID);
			}
		}

		if(sizeof($arryCard)>0){
			$CreditCardFlag = 1;

			if($arrySale[0]['InvoicePaid'] == 'Unpaid' && $arrySale[0]['PostToGL'] != "1") {  

				/*********************/
				$TotalInvoiceAmount = $arrySale[0]['TotalInvoiceAmount'];
				$PaymentTerm = $arrySale[0]['PaymentTerm'];
				$CardOrderID = $OrderID;
				include_once("includes/html/box/edit_invoice_credit.php");
				/*********************/

				if($CreditCardFlag==1 && !empty($ProviderName) && $AmountToCharge>0){
					$HideEdit=0;
				}else{
					$HideEdit=1;
				}
				
			}

		}				 
	}else if(strtolower(trim($arrySale[0]['PaymentTerm']))=='prepayment' && !empty($arrySale[0]['AccountID'])){
	    $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
	    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
	}
    } else {
        $ErrorMSG = $NotExist;
    }
} else {
    header("Location:" . $RedirectURL);
    exit;
}


if (empty($NumLine))
    $NumLine = 1;


$arrySaleTax = $objTax->GetTaxRate('1');
$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod', '');
$_SESSION['DateFormat'] = $Config['DateFormat'];
$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

require_once("../includes/footer.php");
?>


