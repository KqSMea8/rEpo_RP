<?php 
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php'; $EditPage = 1;$SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");	
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/card.class.php");
    require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/variant.class.php");	
	require_once($Prefix."classes/item.class.php");
	
ini_set('display_errors',1);
	 
	
	//require_once($Prefix."lib/paypal/invoice/src/angelleye/PayPal/PayPal.php");
	//require_once($Prefix."lib/paypal/invoice/src/angelleye/PayPal/Adaptive.php");
	//require_once($Prefix."classes/paypal.invoice.class.php");
	
	
		
		
	require_once($Prefix."classes/paypal.invoice.class1.php");
	$objpaypalInvoice=new paypalInvoice1();
	
	
	
	
	
	
		if(!empty($_GET['saveTransaction'])){
	
					 $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
					
							if(!empty($PaymentProviderData[0]['PaypalToken'])){
									$paypalUsername=$PaymentProviderData[0]['paypalUsername'];
									$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
									  require_once($Prefix."admin/includes/html/box/paypalInvoiceUserInfo.php");
							}
		die('asdasd');
	
	}
/*
if(!empty($_GET['saveInvoiceTest'])){
	$objpaypalInvoice->SavePaypalInvoiceTransaction();

}*/
	
	$objItem=new items();
	$_GET["edit"] = (int)$_GET["edit"];
	$_GET["del_id"] = (int)$_GET["del_id"];
	$_GET["OrderID"] = (int)$_GET["OrderID"];
	if($_GET["edit"]>0)$_GET["OrderID"]=$_GET["edit"];
	$module = $_GET['module'];

        $objvariant=new varient(); 
	$objCommon = new common();
	$objSale = new sale();
	$objCard = new card();
	$objTax=new tax();
        $objCondition=new condition();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sales ".$_GET['module'];
     	$AutomaticApprove = $objCommon->getSettingVariable('SO_APPROVE');

	$RedirectURL = "viewSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
	$EditUrl = "editSalesQuoteOrder.php?edit=".$_GET["OrderID"]."&module=Order&curP=".$_GET["curP"]; 

	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixSale = "QT"; 
		$UpdateMSG = SO_QUOTE_UPDATED;  $AddMSG = SO_QUOTE_ADDED; $RemoveMSG = SO_QUOTE_REMOVED; $NotExist = NOT_EXIST_QUOTE; 

		
		 
	}else{
		$ModuleIDTitle = "Sale Number"; $ModuleID = "SaleID"; $PrefixSale = "SO"; 
		$UpdateMSG = SO_ORDER_UPDATED;  $AddMSG = SO_ORDER_ADDED; $RemoveMSG = SO_ORDER_REMOVED; $NotExist = NOT_EXIST_ORDER;
		
	}


	/*******Credit Card Process**********/
	if(!empty($_GET['OrderID']) && !empty($_GET['ID']) && $_GET['Action']=='PCard'){		 
		$objCard->ProcessSaleCreditCard($_GET['OrderID'],'','');
		
		header("Location:".$EditUrl);
		exit;
	}else if(!empty($_GET['OrderID']) && !empty($_GET['PID']) && $_GET['Action']=='VCard'){		 
		$objCard->VoidSaleCreditCard($_GET['OrderID'],'');
		if(!empty($_SESSION['mess_error_sale'])){
			$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
			unset($_SESSION['mess_error_sale']);			
		}
		header("Location:".$EditUrl);
		exit;
	}
	/***********************************/
	
	if($_GET['del_id'] && !empty($_GET['del_id'])){

		/************************ refund invoice paypal*******************/
		$arrySale = $objSale->GetSale($_GET['del_id'],'',$module);
		
		if(!empty($arrySale[0]['paypalInvoiceId'])){
		
			if($arrySale[0]['OrderPaid']==0){
				$responce=$objpaypalInvoice->DeletePaypalInvoice($arrySale[0]['paypalInvoiceId']);	
			
			}else{	

				$res = $objCard->GetLastSalesTransaction($arrySale[0]['OrderID'],'Invoice Payment',"PayPal");	
				
				if(!empty($res[0]['TransactionID'])){
					  require_once($Prefix."lib/paypal/paypal_pro.inc.php");
					 
				     	   $methodToCall = 'RefundTransaction';
				      	  $paypalInvoiceid = $arrySale[0]['paypalInvoiceId'];
					  $tid=$res[0]['TransactionID'];
					  $nvpstr = '&TRANSACTIONID=' . $tid .'&INVOICEID='.$paypalInvoiceid.$nvpRecurring;
					  $detail=$objpaypalInvoice->GetPaypalDetail();
					  $paypaldetail=array();					  
					  $Username =$detail[0]['paypalUsername'];
					  $APIPassword=$detail[0]['paypalPassword'];
				 	  $APISignature=$detail[0]['paypalSignature'];			 
		              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
					  $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
					
					  if($resArray['ACK']=='Success'){
					 	    $arryTr['OrderID'] = $res[0]['OrderID'];
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $resArray['REFUNDTRANSACTIONID'];
							$arryTr['TransactionType'] = 'Invoice Refund';
							$arryTr['TotalAmount'] = $resArray['GROSSREFUNDAMT'];
							$arryTr['Currency'] = 	$resArray['CURRENCYCODE'];
							$arryTr['PaymentTerm'] = 'PayPal';
							$arryTr['Fee'] = $resArray['FEEREFUNDAMT'];
							$objCard->SaveCardProcess($arryTr);		
					  }else{
						$RemMsg = '<br>'.$resArray['L_SHORTMESSAGE0'].' : '.$resArray['L_LONGMESSAGE0'];
					  }	
				}
			
			}
			
		}

				/***************End*********/










		$_SESSION['mess_Sale'] = $ModuleName.REMOVED.$RemMsg;
		$objSale->RemoveSale($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	 if ($_POST){
			
			CleanPost();			
			if(!empty($_POST['ConvertOrderID'])) {
				$objSale->ConvertToSaleOrder($_POST['ConvertOrderID'],$_POST['SaleID']);
				$_SESSION['mess_Sale'] = QUOTE_TO_SO_CONVERTED;
				$RedirectURL = "viewSalesQuoteOrder.php?module=Order";
				header("Location:".$RedirectURL);
				exit;
			} 
			if($_POST['Spiff']!='Yes') {
				unset($_POST['SpiffContact']);
				unset($_POST['SpiffAmount']);
			}


			/*******Update Sales Status Message*******			
			if($_POST['Reseller']=='Yes' && $_POST['tax_auths']=='No'){
				$_POST['StatusMsg'] = 'Credit Hold';
			}else{
				$_POST['StatusMsg'] = 'Credit Approved';
			}
			

			/*************************************/
			if(empty($_POST['CustCode'])) {
				$errMsg = ENTER_CUSTOMER_ID;
			}else if(!empty($_POST['OrderID'])){
				/*if($_POST['PaymentTerm']=='Credit Card' && $_POST['TransactionAmount']>0 && $_POST['TotalAmount']>0 && $_POST['TotalAmount']!=$_POST['TransactionAmount']){
				$errMsg = "Credit card transaction amount : ".$_POST['TransactionAmount']." should be equal to order total amount.";					
				}*/
			 }
			/*************************************/




			 if(empty($errMsg)) {
				
				if(!empty($_POST['OrderID'])) {
					$order_id = $_POST['OrderID'];
					
			
					/***********************************/
					if($_POST['PaymentTerm']=='Credit Card' && $_POST['TransactionAmount']>0 && $_POST['TotalAmount']>0 && $_POST['TotalAmount']!=$_POST['TransactionAmount'] && $_POST['ChargeRefund']=='1'){
						$TransactionDiff = $_POST['TotalAmount'] - $_POST['TransactionAmount'];
						$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($order_id,'Charge',$_POST['PaymentTerm']);
						$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];	
						if(!empty($ProviderID)){
							if($TransactionDiff>0){
								$objCard->ProcessSaleCreditCard($order_id,$ProviderID,$TransactionDiff);	
							}else{
								$TransactionDiff = -$TransactionDiff;
								$objCard->VoidSaleCreditCard($order_id,$TransactionDiff);	
							}						

							$RedirectURL = $EditUrl;
							if(!empty($_SESSION['mess_error_sale'])){
								$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
								unset($_SESSION['mess_error_sale']);
								header("Location:".$RedirectURL);
								exit;
							}

						}
					}
					/***********************************/
					/************ Paypal ********/
					if($_POST['PaymentTerm']=='PayPal'){
						$arrySale = $objSale->GetSale($order_id,'',$module);
						if($arrySale[0]['OrderPaid']!=0){
								$_SESSION['mess_Sale'] = 'sales order already paid.';							
								header("Location:".$RedirectURL);
								exit;						
						}
						
					}
					
						  $responce=array();
					 	 $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
							if(!empty($PaymentProviderData[0]['PaypalToken'])){
									$paypalUsername=$PaymentProviderData[0]['paypalID'];
									$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
									
										$paypalUsername='ravisolanki343-facilitator@gmail.com';
										$PaypalToken='sde6dGXpVp2V31ycZ6WEMbevuyiNQf-mzEquFCLRQRCs3EAeU0h5koXkOEwrkfH3SJPfcPyhxZNZzflBEJD7YWU95E-jHyJCk7JMp5sb33BcW7jHspetxOdJ7IQ';
										$invoiceid=$arrySale[0]['paypalInvoiceId'];
									  require_once($Prefix."admin/includes/html/box/paypalInvoiceUpdate.php");
							}else{
						$_SESSION['mess_Sale'] .= '<br>Invalid Paypal Token. <br>Please setup this under Payment Provider of Finance Settings.';
						header("Location:".$RedirectURL);
								exit;					
				}
				if(!empty($responce['errors'])){				
					$_SESSION['mess_Sale']=$responce['errors'];
					header("Location:".$RedirectURL);
					exit;	
					
				}
					/********End **************/
					

					$objSale->UpdateSale($_POST);
						
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
					/***********************************/
					
					$_SESSION['mess_Sale'] = $ModuleName.UPDATED.'<br>'.$_SESSION['mess_Sale'];
					unset($_SESSION['mess_charge_refund']);
					
				}else{	 
				
					
					  $_POST['Approved'] = $AutomaticApprove;
					  
					
					
							/*  $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
								if(!empty($PaymentProviderData[0]['PaypalToken'])){
										$paypalUsername=$PaymentProviderData[0]['paypalUsername'];
										$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
										$paypalUsername='ravisolanki343-facilitator@gmail.com';
										$PaypalToken='sde6dGXpVp2V31ycZ6WEMbevuyiNQf-mzEquFCLRQRCs3EAeU0h5koXkOEwrkfH3SJPfcPyhxZNZzflBEJD7YWU95E-jHyJCk7JMp5sb33BcW7jHspetxOdJ7IQ';
										
										  require_once($Prefix."admin/includes/html/box/paypalInvoiceSave.php");
								}*/
								
			
									
					  $order_id = $objSale->AddSale($_POST); 
					  $_SESSION['mess_Sale'] = $ModuleName.ADDED;
					  //$objSale->sendSalesEmail($order_id);
					//die('testttt');
					  /*****************/
					   /*****************/
					  if(!empty($_POST['paypalemail']) AND $_POST['PaymentTerm']=='PayPal'){
						  $_POST['OrderID']=$order_id;
						//  $responce=$objpaypalInvoice->CreatePaypalInvoice($_POST);
/**** Paypal Invoice Create*********/
							  $responce=array();
					  $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
							if(!empty($PaymentProviderData[0]['PaypalToken'])){
									$paypalUsername=$PaymentProviderData[0]['paypalID'];
									$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
									
										$paypalUsername='ravisolanki343-facilitator@gmail.com';
										$PaypalToken='sde6dGXpVp2V31ycZ6WEMbevuyiNQf-mzEquFCLRQRCs3EAeU0h5koXkOEwrkfH3SJPfcPyhxZNZzflBEJD7YWU95E-jHyJCk7JMp5sb33BcW7jHspetxOdJ7IQ';
										
									  require_once($Prefix."admin/includes/html/box/paypalInvoiceSave.php");
							}else{
$_SESSION['mess_Sale'] .= '<br>Invalid Paypal Token. <br>Please setup this under Payment Provider of Finance Settings.';
}


						  if($responce['success']==1){						  
						   $sql="Update s_order SET paypalInvoiceId='".$responce['InvoiceID']."' , paypalInvoiceNumber='".$responce['InvoiceNumber']."' WHERE OrderID='".$order_id."'";
						   $objpaypalInvoice->query($sql);
							// save in transaction
							$arryTr['OrderID'] = $order_id;
							$arryTr['ProviderID'] = 1;
							$arryTr['TransactionID'] = $responce['InvoiceID'];
							$arryTr['TransactionType'] = 'Invoice';
							$arryTr['TotalAmount'] = $_POST['TotalAmount'];
							$arryTr['Currency'] = $_POST['CustomerCurrency'];
							$arryTr['PaymentTerm'] = 'PayPal';
							$objCard->SaveCardProcess($arryTr);



							$_SESSION['mess_Sale'] .= '<br>Paypal invoice has been generated and email has been sent to customer.';
						  }else{
							$_SESSION['mess_Sale'] .= '<br>Invalid Paypal Credentials : '.$responce['errors'][0].'<br>Please setup this under Payment Provider of Finance Settings.';
						  }
						//echo '<pre>';print_r($responce['errors']);exit;
					  }
					 /*****************/
					 /*****************/

				}


				$varianttype='SalesQuote';// bysachin
				$_POST['varianttype'] = $varianttype;//if($_GET['v']==1){echo "<pre/>";print_r($_POST);die;}
				$objSale->AddUpdateItem($order_id, $_POST); 
				/***********************************/
				if($_POST['SalesPersonID']>0 && $_POST['OldSalesPersonID']!=$_POST['SalesPersonID']){
					$objSale->sendAssignedEmail($order_id, $_POST['SalesPersonID']); 
				}
				/***********************************/

				$objSale->AddUpdateCreditCard($order_id, $_POST); 

				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		




	/***********************************/
	/***********************************/
	if(!empty($_GET['edit'])){
            	//$objSale->UpdateModuleAutoID($_GET['edit'],'wwe34566');

		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
                 
		$OrderID   = $arrySale[0]['OrderID'];	
                

		/*****************/
		if($Config['vAllRecord']!=1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/





		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);

			/*****************************/
			/*****************************/
			if($arrySale[0]['PaymentTerm']=='Credit Card'){
				$arryCard = $objSale->GetSaleCreditCard($OrderID); 
				if(sizeof($arryCard)>0){
					$arryProvider = $objCard->GetProviderByCard($arryCard[0]['CardType']);
					$ProviderName = $arryProvider[0]['ProviderName'];
					$ProviderID = $arryProvider[0]['ProviderID'];

					$CreditCardFlag = 1;
					$AuthorizeCardUrl = "editSalesQuoteOrder.php?OrderID=".$_GET["edit"]."&Action=PCard&curP=".$_GET["curP"]."&ID=".$arryCard[0]['ID']; 
				}
				$CardProcessed = 0;

				$TotalCharge = $objCard->GetTransactionTotal($OrderID,'Charge',$arrySale[0]['PaymentTerm']);
				$TotalRefund = $objCard->GetTransactionTotal($OrderID,'Void',$arrySale[0]['PaymentTerm']);
				if($TotalCharge>0){
					$CardProcessed = 1;					
					if($TotalCharge<=$TotalRefund){
						$CardVoided = 1;
					}else{
						$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$arrySale[0]['PaymentTerm']);	

						$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
						$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];
						
						$VoidCardUrl = "editSalesQuoteOrder.php?OrderID=".$_GET["edit"]."&Action=VCard&curP=".$_GET["curP"]."&PID=".$ProviderID; 
					}
				}


				/*
				
				$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$arrySale[0]['PaymentTerm']);				
				if(!empty($arrySalesCardTransaction[0]['ProviderID'])){
					$arrySalesCardVoid = $objCard->GetLastSalesTransaction($OrderID,'Void',$arrySale[0]['PaymentTerm']);			
					
					$CardProcessed = 1;					
					if(!empty($arrySalesCardVoid[0]['ProviderID']) && $arrySalesCardVoid[0]['ID']>$arrySalesCardTransaction[0]['ID']){
						$CardVoided = 1;				
					}else{
						$ProviderName = $arrySalesCardTransaction[0]['ProviderName'];
						$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];
						
						$VoidCardUrl = "editSalesQuoteOrder.php?OrderID=".$_GET["edit"]."&Action=VCard&curP=".$_GET["curP"]."&PID=".$ProviderID; 
					}
				}*/
			}

			if(!empty($arrySale[0]['PaymentTerm'])){
				$TransactionExist = $objSale->isSalesTransactionExist($OrderID);
				if($TransactionExist==1){					
					if($arrySale[0]['PaymentTerm']=="PayPal"){
						$HideSubmit = 1;
					}
				}
			}
			/*****************************/
			/*****************************/

		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		$NextModuleID = $objConfigure->GetNextModuleID('s_order',$module);
	}
	/***********************************/
	/***********************************/			

	if(empty($NumLine)) $NumLine = 1;	


 $arrySaleTax = $objTax->GetTaxByLocation('1',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);

	//$arrySaleTax = $objTax->GetTaxRate('1');
	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
	$arryOrderStatus = $objCommon->GetFixedAttribute('OrderStatus','');		
	$arryOrderType = $objCommon->GetFixedAttribute('OrderType','');		
$arryOrderSource = $objCommon->GetFixedAttribute('OrderSource','');	
        $ConditionDrop  =$objCondition-> GetConditionDropValue('');

	//$ErrorMSG = UNDER_CONSTRUCTION; 



	/********************/
	if($_SESSION['AdminType'] == "employee" ) { 
		$NumDeptModules = sizeof($arrayDeptModules);   
		//echo sizeof($arryMainMenu) .'=='. $NumDeptModules;
 		if(sizeof($arryMainMenu) >= $NumDeptModules){
			$Config['FullPermission'] = 1;
		}
	}
	//echo $Config['FullPermission'];
	/********************/
	require_once("../includes/footer.php"); 	 
?>


