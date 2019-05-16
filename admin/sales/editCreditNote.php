<?php 
	/**************************************************/
	$ThisPageName = 'viewCreditNote.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	$objCommon = new common();
	$objSale = new sale();
	$objTax=new tax();
	
	$ModuleName = "Credit Note";
	$RedirectURL = "viewCreditNote.php?curP=".$_GET['curP'];

	 

	
		if($_GET['del_id'] && !empty($_GET['del_id'])){
			$_SESSION['mess_credit'] = $ModuleName.REMOVED;
			$objSale->RemoveSale($_GET['del_id']);
			header("Location:".$RedirectURL);
			exit;
		}

	 if ($_POST) {
			

			 if(empty($_POST['CustCode'])) {
				$errMsg = ENTER_CUSTOMER_ID;
			 } else {
				if (!empty($_POST['OrderID'])) {
					$objSale->UpdateSale($_POST);
					$order_id = $_POST['OrderID'];
					$_SESSION['mess_credit'] = $ModuleName.UPDATED;
					
				}else {	 
					  $order_id = $objSale->AddSale($_POST); 
					  $_SESSION['mess_credit'] = $ModuleName.ADDED;
				}
				$objSale->AddUpdateItem($order_id, $_POST); 
				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		

	if(!empty($_GET['edit'])){
		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}
				

	if(empty($NumLine)) $NumLine = 1;	

 $arrySaleTax = $objTax->GetTaxByLocation('1',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);


	//$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		


	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


