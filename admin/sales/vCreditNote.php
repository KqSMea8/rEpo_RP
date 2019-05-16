<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewCreditNote.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");

	$objSale = new sale();
	$objTax = new tax();
	
	
	/*******************************************************************************************/
		$ModuleName = "Credit Note";

		$RedirectURL = "viewCreditNote.php?curP=".$_GET['curP'];
		$EditUrl = "editCreditNote.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
		$DownloadUrl = "pdfCreditNote.php?o=".$_GET["view"]; 

		if(!empty($_GET['view']) || !empty($_GET['so'])){
			$arrySale = $objSale->GetSale($_GET['view'],$_GET['so'],"Credit");
			$OrderID   = $arrySale[0]['OrderID'];	
			if($OrderID>0){
				$arrySaleItem = $objSale->GetSaleItem($OrderID);
				$NumLine = sizeof($arrySaleItem);
			}else{
				$ErrorMSG = NOT_EXIST_CREDIT;
			}
		}else{
			header("Location:".$RedirectURL);
			exit;
		}
					

		if(empty($NumLine)) $NumLine = 1;	


		$arrySaleTax = $objTax->GetTaxRate('1');

		$_SESSION['DateFormat']= $Config['DateFormat'];

   /***********************************************************************************************************/	

	require_once("../includes/footer.php"); 	 
?>


