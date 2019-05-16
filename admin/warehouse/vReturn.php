<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewReturn.php'; $SetFullPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase=new purchase();

	$ModuleName = "Return";

	$RedirectURL = "viewReturn.php?curP=".$_GET['curP'];
	$EditUrl = "editReturn.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfReturn.php?o=".$_GET["view"]; 


	if(!empty($_GET['po'])){
		$MainModuleName = "Return for PO Number# ".$_GET['po'];
		$RedirectURL .= "&po=".$_GET['po'];
		$EditUrl .= "&po=".$_GET['po'];
	}





	if(!empty($_GET['view'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['view'],'','Return');
		$OrderID   = $arryPurchase[0]['OrderID'];


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
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				
	if(empty($NumLine)) $NumLine = 1;	
	

	require_once("../includes/footer.php"); 	 
?>


