<?php    if($_GET['pop']==1)$HideNavigation = 1;
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
	$ModuleIDTitle = "Reciept Number"; $ModuleID = "ReturnID"; $PrefixPO = "RCPT";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewSalesReturn.php?curP=".$_GET['curP'];
	$DownloadUrl = "pdfWarehouseReturn.php?RTN=".$_GET["view"].""; 

   	if(!empty($_GET['view']) && !empty($_GET['rcpt'])){
		$arrySale = $objWarehouseRma->GetReceiptRmaListing($_GET['view'],$_GET['rcpt'],'Receipt');
		$OrderID   = $arrySale[0]['ReceiptID'];	
		$SaleID = $arrySale[0]['SaleID'];
		

		/*****************/
		if($Config['vAllRecord']!=1 && $HideNavigation != 1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/


		if($OrderID>0){
			$arrySaleItem = $objWarehouseRma->GetSaleReceiptItem($OrderID,'');
			$NumLine = sizeof($arrySaleItem);
			
			 $TotalGenerateReturn = $objrmasale->GetQtyReturned($OrderID);
			 
			if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){
		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}
			
		} 
		$ModuleName = "View ".$Module;
		$HideSubmit = 1;
	} 
				

	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');


	require_once("../includes/footer.php"); 	 
?>


