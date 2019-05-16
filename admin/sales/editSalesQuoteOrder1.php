<?php 
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	$objCommon = new common();
	$objSale = new sale();
	$objTax=new tax();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sales ".$_GET['module'];

	$RedirectURL = "viewSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixSale = "QT"; 
		$UpdateMSG = SO_QUOTE_UPDATED;  $AddMSG = SO_QUOTE_ADDED; $RemoveMSG = SO_QUOTE_REMOVED; $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "Sale Number"; $ModuleID = "SaleID"; $PrefixSale = "SO"; 
		$UpdateMSG = SO_ORDER_UPDATED;  $AddMSG = SO_ORDER_ADDED; $RemoveMSG = SO_ORDER_REMOVED; $NotExist = NOT_EXIST_ORDER;
	}

	
		if($_GET['del_id'] && !empty($_GET['del_id'])){
			$_SESSION['mess_Sale'] = $ModuleName.REMOVED;
			$objSale->RemoveSale($_GET['del_id']);
			header("Location:".$RedirectURL);
			exit;
		}

	 if ($_POST) {
			
			if(!empty($_POST['ConvertOrderID'])) {
				$objSale->ConvertToSaleOrder($_POST['ConvertOrderID'],$_POST['SaleID']);
				$_SESSION['mess_Sale'] = QUOTE_TO_SO_CONVERTED;
				$RedirectURL = "viewSalesQuoteOrder.php?module=Order";
				header("Location:".$RedirectURL);
				exit;
			 } 

		

			 if(empty($_POST['CustCode'])) {
				$errMsg = ENTER_CUSTOMER_ID;
			 } else {
				if (!empty($_POST['OrderID'])) {
					$objSale->UpdateSale($_POST);
					$order_id = $_POST['OrderID'];
					
					/****************************************************************/
						 if(!empty($_POST['SentEmail']) && ($_POST['Approved'] == 1)){
							$_SESSION['mess_Sale'] = $ModuleName.UPDATED;
							$objSale->AuthorizeSales($_POST['OrderID'],1,'');
							header("Location:".$RedirectURL);
							exit;
						}else if(!empty($_POST['Status']) && $_POST['Status'] == "Cancelled"){
							$_SESSION['mess_Sale'] = $ModuleName.UPDATED;
							$objSale->AuthorizeSales($_POST['OrderID'],2,'');
							header("Location:".$RedirectURL);
							exit;
						}else if(!empty($_POST['Status']) && $_POST['Status'] == "Closed"){
							$_SESSION['mess_Sale'] = $ModuleName.UPDATED;
							$objSale->AuthorizeSales($_POST['OrderID'],3,'');
							header("Location:".$RedirectURL);
							exit;

						} 
				
					/*****************************************************************/
					
					$_SESSION['mess_Sale'] = $ModuleName.UPDATED;
					
				}else {	 
					  $order_id = $objSale->AddSale($_POST); 
					  $_SESSION['mess_Sale'] = $ModuleName.ADDED;
					  
					  $objSale->sendSalesEmail($order_id);
				}
				$objSale->AddUpdateItem($order_id, $_POST); 
				/***********************************/
				if($_POST['SalesPersonID']>0 && $_POST['OldSalesPersonID']!=$_POST['SalesPersonID']){
					$objSale->sendAssignedEmail($order_id, $_POST['SalesPersonID']); 
				}
				/***********************************/
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
	$arryPaymentTerm = $objCommon->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objCommon->GetAttribValue('ShippingMethod','');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		


	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


