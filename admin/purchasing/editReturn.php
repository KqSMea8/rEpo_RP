<?php 
	/**************************************************/
	$ThisPageName = "viewReturn.php"; $EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase=new purchase();
	$objTax=new tax();

	$Module = "Return";

	$RedirectURL = "viewReturn.php?curP=".$_GET['curP'];

	CleanPost();


	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RETURN_REMOVED;
		$objPurchase->RemovePurchase($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}



	if(!empty($_POST['ReturnOrderID'])){   
		$OrderID = $objPurchase->ReturnOrder($_POST);
		$_SESSION['mess_return'] = RETURN_ADDED;
		#$RedirectURL = "vReturn.php?view=".$OrderID;
		header("Location:".$RedirectURL);
		exit;
	}else if(!empty($_POST['OrderID'])){  
		$objPurchase->UpdateReturn($_POST);
		$_SESSION['mess_return'] = RETURN_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}
		

	if(!empty($_GET['po'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['po'],'','Order');
		$OrderID   = $arryPurchase[0]['OrderID'];
		$po =  $arryPurchase[0]['PurchaseID'];


		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryPurchase[0]['AssignedEmpID'] != $_SESSION['AdminID'] && $arryPurchase[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/


		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			$PurchaseID = $arryPurchase[0]['PurchaseID'];
			#$arryInvoiceOrder = $objPurchase->GetInvoiceOrder($PurchaseID);
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

		$ModuleName = "Add ".$Module;

	}else if(!empty($_GET['edit'])){

		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Return');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		$po = $arryPurchase[0]['PurchaseID'];


		/*****************/
		if($Config['vAllRecord']!=1){
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
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_PO_FIRST;
		$ModuleName = "Add ".$Module;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	$arryPurchaseTax = $objTax->GetTaxRate('2');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');


	require_once("../includes/footer.php"); 	 
?>


