<?php    if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = "viewCredit.php";	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	$objSale = new sale();
	$objTax=new tax();
	
	$Module = "RMA";
	$ModuleIDTitle = "Return Number"; $ModuleID = "ReturnID"; $PrefixPO = "RTN";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewCredit.php?curP=".$_GET['curP'];
	$DownloadUrl = "pdfCustCredit.php?RTN=".$_GET["view"].""; 

   	if(!empty($_GET['view']) && !empty($_GET['rtn'])){
		$arrySale = $objSale->GetReturn($_GET['view'],$_GET['rtn'],'Credit');
		$OrderID   = $arrySale[0]['OrderID'];	
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
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			$TotalGenerateReturn = $objSale->GetQtyReturned($OrderID);
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


