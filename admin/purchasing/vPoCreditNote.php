<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPoCreditNote.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objPurchase=new purchase();
	$objTax=new tax();
	$ModuleName = "Credit Note";

	$RedirectURL = "viewPoCreditNote.php?curP=".$_GET['curP'];
	$EditUrl = "editPoCreditNote.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfPoCreditNote.php?o=".$_GET["view"]; 

	if(!empty($_GET['view']) || !empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],$_GET['po'],"Credit");
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
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

	require_once("../includes/footer.php"); 	 
?>


