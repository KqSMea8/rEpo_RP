<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPoCreditNote.php'; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	$objPurchase=new purchase();
	$objTax=new tax();
	$objBankAccount=new BankAccount();
	$ModuleName = "Credit Memo";
        $ModuleDepName = "PurchaseCreditMemo";

	$RedirectURL = "viewPoCreditNote.php?curP=".$_GET['curP'];
	$EditUrl = "editPoCreditNote.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
//	$DownloadUrl = "pdfPoCreditNote.php?o=".$_GET["view"]; 
        $DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&ModuleDepName=".$ModuleDepName;


	(empty($_GET['po']))?($_GET['po']=""):("");
	 (empty($mmodule))?($mmodule=""):("");

	if(!empty($_GET['view']) || !empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],$_GET['po'],"Credit");
		$OrderID   = $arryPurchase[0]['OrderID'];
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


			$GLAccount = NOT_SPECIFIED;
			if(!empty($arryPurchase[0]['AccountID'])){
				$arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
				$GLAccount = $arryBankAccount[0]['AccountName'].' ['.$arryBankAccount[0]['AccountNumber'].']';
			}
		}else{
			$ErrorMSG = NOT_EXIST_CREDIT;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	if(empty($NumLine)) $NumLine = 1;	


	$arryPurchaseTax = $objTax->GetTaxRate('2');

	$_SESSION['DateFormat']= $Config['DateFormat'];

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	require_once("../includes/footer.php"); 	 
?>


