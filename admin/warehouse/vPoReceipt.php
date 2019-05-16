<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPoReceipt.php'; $SetFullPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	$objPurchase=new purchase();
	$objBankAccount = new BankAccount();
	$ModuleName = "Receipt";
        $ModuleDepName='WhousePOReceipt';//by sachin

	$RedirectURL = "viewPoReceipt.php?curP=".$_GET['curP'];
	$EditUrl = "editPoReceipt.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	//$DownloadUrl = "pdfPoReceipt.php?o=".$_GET["view"]; 
        $DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName;


	if(!empty($_GET['po'])){
		$MainModuleName = "Receipts for PO Number# ".$_GET['po'];
		$RedirectURL .= "&po=".$_GET['po'];
		$EditUrl .= "&po=".$_GET['po'];
	}





	if(!empty($_GET['view'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],'','Receipt');

		$OrderID   = $arryPurchase[0]['OrderID'];
		
		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/
               /****start code for get tempalte name for dynamic pdf by sachin***/
		$_GET['ModuleName']=$ModuleDepName;
		$_GET['Module']=$ModuleDepName.$_GET['module'];
		$_GET['ModuleId']=$_GET['view'];
		$_GET['listview']='1';
		$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);	
		/****end code for get tempalte name for dynamic pdf by sachin***/ 


	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			//////////*/

			$BankAccount='';
			if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='prepayment' && !empty($arryPurchase[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}	
		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				
	if(empty($NumLine)) $NumLine = 1;	
	
 	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	require_once("../includes/footer.php"); 	 
?>


