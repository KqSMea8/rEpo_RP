<?php   if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = "viewSalesReturn.php";	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.sales.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/warehouse.rma.class.php");

    $objrmasale = new rmasale();
	$objTax=new tax();
    $objWarehouseRma = new warehouserma();

	$Module = "Reciept";
	$ModuleDepName='WhouseCustomerRMA';//by sachin
	$ModuleIDTitle = "Reciept Number"; $ModuleID = "ReturnID"; $PrefixPO = "RCPT";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewSalesReturn.php?curP=".$_GET['curP'];
	//$DownloadUrl = "pdfWarehouseReturn.php?RTN=".$_GET["view"]."";
	$DownloadUrl = "../pdfCommonhtml.php?o=".$_GET["view"]."&module=".$module."&ModuleDepName=".$ModuleDepName;//by sachin 

   	if(!empty($_GET['view'])){
		$arrySale = $objWarehouseRma->GetReceiptRmaListing($_GET['view'],'','Receipt');
 

		$OrderID   = $arrySale[0]['ReceiptID'];	
		$SaleID = $arrySale[0]['SaleID'];
		$_GET['rcpt'] = $arrySale[0]['ReceiptNo'];	
 		$RmaOrderID   = $arrySale[0]['OrderID'];	
		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}

		 /****start code for get tempalte name for dynamic pdf by sachin***/
		$_GET['ModuleName']=$ModuleDepName;
		$_GET['Module']=$ModuleDepName.$_GET['module'];
		$_GET['ModuleId']=$_GET['view'];
		$_GET['listview']='1';
		$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);	
		/****end code for get tempalte name for dynamic pdf by sachin***/ 
		/*****************/


		if($OrderID>0){
			$arrySaleItem = $objWarehouseRma->GetSaleReceiptItem($OrderID,'');
			$NumLine = sizeof($arrySaleItem);
			
			 $TotalGenerateReturn = $objrmasale->GetQtyReturned($OrderID);
			 
			$QtyInvoiced = (!empty($TotalGenerateReturn[0]['QtyInvoiced']))?($TotalGenerateReturn[0]['QtyInvoiced']):('');
			$QtyReturned = (!empty($TotalGenerateReturn[0]['QtyReturned']))?($TotalGenerateReturn[0]['QtyReturned']):('');

			if($QtyInvoiced == $QtyReturned){
				$HideSubmit = 1;
				$RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}
			
		} 
		$ModuleName = "View ".$Module;
		$HideSubmit = 1;
	} 
				

	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');
		$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

	require_once("../includes/footer.php"); 	 
?>


