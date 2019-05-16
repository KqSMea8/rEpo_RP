<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPO.php'; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
        require_once($Prefix."classes/finance.account.class.php");
	$objCommon=new common();

	$objPurchase=new purchase();
	$objTax=new tax();
        $objBankAccount = new BankAccount();
 	
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	(empty($_GET['po']))?($_GET['po']=""):("");
	$module = $_GET['module'];
	/**************/
	$ModuleArray = array('Quote','Order'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/
 
	
	$ModuleName = "Purchase ".$_GET['module'];
	$ModuleDepName="Purchase";
	$RedirectURL = "viewPO.php?module=".$module."&curP=".$_GET['curP'];
	$EditUrl = "editPO.php?edit=".$_GET["view"]."&module=".$module."&curP=".$_GET["curP"]; 
	 $DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName;

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
	}

	/*********************/
	/*********************/
	$CloneURL = "vPO.php?module=".$module."&curP=".$_GET['curP']."&CloneID=".base64_encode($_GET['view']); 
	if(!empty($_GET['CloneID'])){
		$CloneID = base64_decode($_GET['CloneID']);
		$NewCloneID = $objPurchase->CreateCloneOrder($CloneID,$_GET['module']);
		if(!empty($NewCloneID)){
			$CloneCreated = str_replace("[MODULE]", "Purchase ".$_GET["module"], CLONE_CREATED);
			$CloneCreated = str_replace("[MODULE_ID]", $NewCloneID, $CloneCreated);
			$_SESSION['mess_purchase'] = $CloneCreated;
		}else{
			$_SESSION['mess_purchase'] = CLONE_NOT_CREATED;
		}
		header("Location:".$RedirectURL);
		exit;
	}
	/*********************/
	/*********************/



	if(!empty($_GET['view']) || !empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],$_GET['po'],$module);
		$OrderID   = $arryPurchase[0]['OrderID'];

   /****start code for get tempalte name for dynamic pdf by sachin***/
		$_GET['ModuleName']=$ModuleDepName;
		$_GET['Module']=$ModuleDepName.$_GET['module'];
		$_GET['ModuleId']=$_GET['view'];
		$_GET['listview']='1';
		$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);	
		/*to get default template*/
		$_GET['setDefautTem']='1';
		$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);

		/****end code for get tempalte name for dynamic pdf by sachin***/  
		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/


	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);

			$NumLine = sizeof($arryPurchaseItem);

			$BankAccount='';
			if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='prepayment' && !empty($arryPurchase[0]['AccountID'])){
			    $arryBankAccount = $objBankAccount->getBankAccountById($arryPurchase[0]['AccountID']);
			    $BankAccount = $arryBankAccount[0]['AccountName'] . ' [' . $arryBankAccount[0]['AccountNumber'] . ']';
			}


		}else{
			$ErrorMSG = $NotExist;
		}
			
			
		}else{
			header("Location:".$RedirectURL);
			exit;
		}
				


	$OrderIsOpen = '';$TotalInvoice=''; $tempnmval='';
	/*******************/
	$arryOrderStatusTemp = $objCommon->GetFixedAttribute('OrderStatus','');		
	for($i=0;$i<sizeof($arryOrderStatusTemp);$i++) {
		$arryOrderStatus[] = $arryOrderStatusTemp[$i]['attribute_value'];
	}
	if(in_array($arryPurchase[0]['Status'],$arryOrderStatus) && $arryPurchase[0]['Approved'] == 1){
		$OrderIsOpen = 1;
	}else if($arryPurchase[0]['Status'] == 'Cancelled' || $arryPurchase[0]['Status'] == 'Rejected'){
		$CancelledRejected = 1;
	}
	/*******************/

	$TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');





	if(empty($NumLine)) $NumLine = 1;	


	$arryPurchaseTax = $objTax->GetTaxRate('2');

	

	require_once("../includes/footer.php"); 	 
?>


