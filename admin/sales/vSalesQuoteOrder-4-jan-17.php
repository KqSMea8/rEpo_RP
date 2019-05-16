<?php 
	if($_GET['pop']==1)$HideNavigation = 1;$SetFullPage = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/finance.account.class.php");

	$objSale = new sale();
	$objTax = new tax();
	$objBankAccount = new BankAccount();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sale ".$_GET['module'];
	$ModuleDepName="Sales";
	$RedirectURL = "viewSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
	$EditUrl = "editSalesQuoteOrder.php?edit=".$_GET["view"]."&module=".$module."&curP=".$_GET["curP"]; 
	$DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName;
$DownloadPickingSheetUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName."&PickingSheet=PickingSheet";//30-may-2015 by sachin
        $editsalespdf="editcustompdf.php?module=".$module."&curP=".$_GET['curP']."&view=".$_GET["view"];
        $convertUrl = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET["curP"]."&view=".$_GET["view"]."&convert=1"; 

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
	}

	if(!empty($_GET['view']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['view'],$_GET['so'],$module);		
		$OrderID   = $arrySale[0]['OrderID'];	

			/****start code for get tempalte name for dynamic pdf by sachin***/
		$_GET['ModuleName']=$ModuleDepName;
		$_GET['Module']=$ModuleDepName.$_GET['module'];
		$_GET['ModuleId']=$_GET['view'];
		$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);	
		/****end code for get tempalte name for dynamic pdf by sachin***/                           



                //Get Purchase Order Status
                  $PONumber   = $arrySale[0]['PONumber'];
                  if(!empty($PONumber)){
                    $POStatus = $objSale->GetPOStatus($PONumber);  
                  }
                  
                 

		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/


		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);

			$BankAccount='';
			if($arrySale[0]['PaymentTerm']=='Credit Card'){
				$arryCard = $objSale->GetSaleCreditCard($OrderID);
				if(sizeof($arryCard)>0){
					$CreditCardFlag = 1;
				}
				 
			}else if(strtolower(trim($arrySale[0]['PaymentTerm']))=='prepayment' && !empty($arrySale[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arrySale[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}

		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if ($_POST) {
			
			if(!empty($_POST['ConvertOrderID'])) {
				$objSale->ConvertToSaleOrder($_POST['ConvertOrderID'],$_POST['SaleID']);
				$_SESSION['mess_Sale'] = QUOTE_TO_SO_CONVERTED;
				$RedirectURL = "viewSalesQuoteOrder.php?module=Order";
				header("Location:".$RedirectURL);
				exit;
			 } 
		}	
                
                
                //Convert Order in Standard
                
                    if($_GET['convert'] == 1 && ($POStatus == 'Completed' || $POStatus == 'Invoicing')){
                        
                        $objSale->ConvertToStandardOrder($_GET['view']);
                        $_SESSION['mess_Sale'] = CONVERTED_ORDER_TYPE;
                        $convertUrlRedirect = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET["curP"]."&view=".$_GET["view"];
                        header("Location:".$convertUrlRedirect);
			exit;
                    }
                
                //end
                

	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');

	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>


