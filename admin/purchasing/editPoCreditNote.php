<?php 
	/**************************************************/
	$ThisPageName = 'viewPoCreditNote.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase=new purchase();
	$objTax=new tax();
	$ModuleName = "Credit Note";

	$RedirectURL = "viewPoCreditNote.php?curP=".$_GET['curP'];


	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_credit'] = CREDIT_REMOVED;
		$objPurchase->RemovePurchase($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	
	 if($_POST) {
			$_POST['CreditID'] = $_POST['PoCreditID'];		
			/***************/
			 if(empty($_POST['SuppCode'])) {
				$errMsg = ENTER_SUPPLIER_ID;
			 }else {
				if(!empty($_POST['OrderID'])) {
					$objPurchase->UpdatePurchase($_POST);
					$order_id = $_POST['OrderID'];
					$_SESSION['mess_credit'] = CREDIT_UPDATED;
				}else {	 
					$order_id = $objPurchase->AddPurchase($_POST); 
					$_SESSION['mess_credit'] = CREDIT_ADDED;
				}
				$objPurchase->AddUpdateItem($order_id, $_POST); 
				
				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		

	if(!empty($_GET['edit'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Credit');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = NOT_EXIST_CREDIT;
		}
	}else{
		$arryPurchase[0]['Taxable'] = 'Yes';
	}
				

	if(empty($NumLine)) $NumLine = 1;	



	$arryPurchaseTax = $objTax->GetTaxByLocation('2',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);
	//$arryPurchaseTax = $objTax->GetTaxRate('2');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrdStatus','');		


	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


