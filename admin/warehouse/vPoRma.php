<?php    if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = "viewPoRma.php";	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/warehouse.purchase.rma.class.php");
	$objPurchase = new purchase();
	$objTax=new tax();
        $objWarehouse = new warehouse();

	$Module = "RMA";
	$ModuleDepName='WhouseVendorRMA';
	$ModuleIDTitle = "Reciept Number"; $ModuleID = "ReturnID"; $PrefixPO = "RCPT";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewPoRma.php?curP=".$_GET['curP'];
	//$DownloadUrl = "pdfPoRma.php?RCPT=".$_GET["view"].""; 
	$DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName;

   	if(!empty($_GET['view'])){  		
    		
		$arryPurchase = $objWarehouse->GetPurchaseReceipt($_GET['view'],'','','','','');
		//pr($arryPurchase); 
		$OrderID   = $arryPurchase[0]['ReceiptID'];	
		$PurchaseID = $arryPurchase[0]['PurchaseID'];
		$ReturnID   = $arryPurchase[0]['ReturnID'];	
		$InvoiceID = $arryPurchase[0]["InvoiceID"];
		$_GET['rcpt'] = $arryPurchase[0]["ReceiptNo"];
		$RmaOrderID   = $arryPurchase[0]['OrderID'];	
		if(!empty($ReturnID)){			 
			$arryRMA = $objWarehouse->GetPORma('',$ReturnID,'RMA');
			 
		}
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
			
			$arryPurchaseItem = $objWarehouse->GetPurchaseReceiptItem($OrderID,'');

			
			$NumLine = sizeof($arryPurchaseItem);
			
		} 
		$ModuleName = "View ".$Module;
		$HideSubmit = 1;
	} 
				

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('1');

  $TaxableBillingAp = $objConfigure->getSettingVariable('TaxableBillingAp');

	require_once("../includes/footer.php"); 	 
?>





