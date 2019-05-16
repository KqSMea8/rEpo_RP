<?php 
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php'; $EditPage = 1;$SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/card.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/variant.class.php");	
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	/*require_once($Prefix."lib/paypal/invoice/src/angelleye/PayPal/PayPal.php");
	require_once($Prefix."lib/paypal/invoice/src/angelleye/PayPal/Adaptive.php");*/
	require_once($Prefix."classes/paypal.invoice.class.php");
  	require_once($Prefix."classes/function.class.php"); 
	require_once($Prefix."classes/archive.class.php");

	$objFunction=new functions(); 
	$objpaypalInvoice=new paypalInvoice();
	$objCustomer=new Customer();
	$objItem=new items();
	$objvariant=new varient(); 
	$objCommon = new common();
	$objSale = new sale();
	$objPurchase = new purchase();
	$objCard = new card();
	$objTax=new tax();
	$objCondition=new condition();
	$objBankAccount = new BankAccount();
	$objArchive = new archive();

	$_GET["edit"] = (int)$_GET["edit"];
	$_GET["POID"] = (int)$_GET["POID"];
	$_GET['EdiConfirm'] = (int)$_GET["EdiConfirm"];
	$_GET["del_id"] = (int)$_GET["del_id"];
	$_GET["OrderID"] = (int)$_GET["OrderID"];
	if($_GET["edit"]>0)$_GET["OrderID"]=$_GET["edit"];
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sales ".$_GET['module'];


 



$AutomaticApprove = $objConfigure->getSettingVariable('SO_APPROVE');
$ApprovalRequired = $objConfigure->getSettingVariable('SO_APPROVE_REQUIRED');
$TaxableBilling = $objConfigure->getSettingVariable('TaxableBilling');

$RedirectURL = "viewSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];
$EditUrl = "editSalesQuoteOrder.php?edit=".$_GET["OrderID"]."&module=Order&curP=".$_GET["curP"]; 

		if($module=='Quote'){	
				$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixSale = "QT"; 
				$UpdateMSG = SO_QUOTE_UPDATED;  $AddMSG = SO_QUOTE_ADDED; $RemoveMSG = SO_QUOTE_REMOVED; $NotExist = NOT_EXIST_QUOTE; 
		}else{
				$ModuleIDTitle = "Sale Number"; $ModuleID = "SaleID"; $PrefixSale = "SO"; 
				$UpdateMSG = SO_ORDER_UPDATED;  $AddMSG = SO_ORDER_ADDED; $RemoveMSG = SO_ORDER_REMOVED; $NotExist = NOT_EXIST_ORDER;
		}


		/************* Paypal Void ************/
if(!empty($_GET['OrderID']) && $_GET['Action']=='VPaypal'){	
		
		$PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);

		$module = $_GET['module'];
		$paypalUsername=$PaymentProviderData[0]['paypalID'];
		$PaypalToken=$PaymentProviderData[0]['PaypalToken'];
		$arrySale = $objSale->GetSale($_GET['OrderID'],'',$module);

		$invoiceid=$arrySale [0]['paypalInvoiceId'];
		$orderDetail=array();
		$orderDetail=$arrySale[0];

		$sendarray=array();
		$sendarray['PayPalTransactionID']=$arrySale[0]['PayPalTransactionID'];
	//if($_SESSION['AdminID']==37 || 1==1){
		require_once($Prefix."admin/includes/html/box/paypalInvoiceTest.php");
		//}
		header("Location:".$EditUrl);
		exit;
}
		/***************************************/


	 include("includes/html/box/card_process_void.php");

	
	if(!empty($_GET['del_id'])){		
		include("includes/html/box/paypal_process_remove.php");	

		$_SESSION['mess_Sale'] = $ModuleName.REMOVED.'<br>'.$responce['errors'][0];

		$objArchive->AddToArchiveSO($_GET['del_id']);
		$objSale->RemoveSale($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
 
	/*********************/
	if(!empty($_GET['POID'])){ 
	  	include("includes/html/box/so_from_po.php");  
	}
	/*********************/

	 if ($_POST){
			
			CleanPost();	

/******************************************/					
/******************************************/					
if($_GET['ravi']==5){
	include("includes/html/box/paypal_process_test.php"); 
}
/******************************************/					
/******************************************/	
 	
			 
      			$_POST['TrackingNo'] = implode(':',$_POST['TrackingNo']);


			if(!empty($_POST['PayPalPaid']) && !empty($_POST['OrderID'])) {
							
						$arrySale = $objSale->GetSale($_POST['OrderID'],'',$module);
						//pr($arrySale,1);
						$response=$objpaypalInvoice->updatePaypalOrderitem($_POST,$arrySale[0]);
						if(!empty($response['refundAmount'])){
							$PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);
							$paypalUsername=$PaymentProviderData[0]['paypalID'];
							$PaypalToken=$PaymentProviderData[0]['PaypalToken'];

							$refundamount=$response['refundAmount'];
							$invoiceid=$arrySale [0]['paypalInvoiceId'];
							$orderDetail=array();
							$orderDetail=$arrySale[0];
							require_once($Prefix."admin/includes/html/box/paypalInvoiceTest.php");
						}	
					
					
				$objSale->UpdateSaleDropshipItem($_POST);


				$_SESSION['mess_Sale'] = SO_ORDER_UPDATED;				
				header("Location:".$EditUrl);
				exit;
			}
		
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
			}else if(!empty($_POST['SaleID']) && $module=='Order'){
				if($objSale->isSaleExists($_POST['SaleID'],$_POST['OrderID'])){
					//$errMsg = str_replace("[MODULE]","Sale Number", ALREADY_EXIST);
					$OtherMsg = str_replace("[MODULE]","Sale Number", ALREADY_EXIST_ASSIGNED);
					$_POST['SaleID'] = $objConfigure->GetNextModuleID('s_order',$module);
				}
			}else if(!empty($_POST['QuoteID']) && $module=='Quote'){
				if($objSale->isQuoteExists($_POST['QuoteID'],$_POST['OrderID'])){
					//$errMsg = str_replace("[MODULE]","Quote Number", ALREADY_EXIST);
					$OtherMsg = str_replace("[MODULE]","Quote Number", ALREADY_EXIST_ASSIGNED);
					$_POST['QuoteID'] = $objConfigure->GetNextModuleID('s_order',$module);
				}
			}
			/*************************************/




			 if(empty($errMsg)) {
				if(strtolower(trim($_POST['PaymentTerm']))=='prepayment'){
					$_POST["AccountID"] = $_POST["BankAccount"] ;
				}			
			

				/*****************/ 		 
				if($_POST['ShippingAccNO']=="Add New"){
				    $_POST['ShippingAccNO']=$_POST['AddNewAcc'];
				}
				if(!empty($_POST['AddNewAcc']) && !empty($_POST['ShippingAccountAdjust']) && !empty($_POST['ShippingAccountCustomer'])){
					$addshippingaccount['CustID']=$_POST['CustID'];
					$addshippingaccount['api_account_number']=$_POST['AddNewAcc'];
					$addshippingaccount['api_name']=$_POST['ShippingMethod'];
					$objCustomer->AddCustShipAcount($addshippingaccount,1);
				}		
				/*****************/ 



				if(!empty($_POST['OrderID'])) {
					if(!empty($_GET['testmode'])){
						echo 'Paypal';
						pr($_POST,1);
					}

					$order_id = $_POST['OrderID'];
					 
					include("includes/html/box/card_process_line.php");

					include("includes/html/box/paypal_process_update.php");

					$objSale->UpdateSale($_POST);
					#$objSale->UpdateEdiPO($_POST);

					/***code for add document by sachin***/
					//PR($_FILES['FileName']);
					$i=0;
					
					$errorFileDoc='';
                    foreach($_FILES['FileName']['name'] as $val){
                    
                       if($val!= ''){


				/***********/
				$ArryFileName['name'] = $_FILES['FileName']['name'][$i];
				$ArryFileName['tmp_name'] = $_FILES['FileName']['tmp_name'][$i];
				$OldFile = $_POST['OldFile'][$i]; 


				$heading = "Sales".$module."_".$order_id."_".$i;

				$FileInfoArray['FileType'] = "Document";
				$FileInfoArray['FileDir'] = $Config['S_DocomentDir'];
				$FileInfoArray['FileID'] =  $heading;
				$FileInfoArray['OldFile'] = $OldFile;
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($ArryFileName, $FileInfoArray); 
				if($ResponseArray['Success']=="1"){
					$documentArry=array('OrderID'=>$order_id,'ModuleName'=>'Sales','Module'=>'Sales'.$module,'FileName'=>$ResponseArray['FileName']);
					$objConfig->UpdateDoc($documentArry);
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}
				/***********/
 
					  	 
						 
			  }
			  $i++;
			}//end foreach
			//die('check');
                       /***End code for add document by sachin ****/
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
					$_SESSION['mess_Sale']=(!empty($_SESSION['mess_Sale']))?('<br>'.$_SESSION['mess_Sale']):('');//by sachin
					$_SESSION['mess_Sale'] = $ModuleName.UPDATED.$_SESSION['mess_Sale'].$OtherMsg.'<br>'.$errorFileDoc;
					//$_SESSION['mess_Sale'] = $ModuleName.UPDATED.'<br>'.$_SESSION['mess_Sale'].$OtherMsg;
					unset($_SESSION['mess_charge_refund']);
					
				}else{	 
				

					  

/******** Automatic Approve****************/
/*****************************************/				
if($AutomaticApprove==1){
	if($ApprovalRequired==1){
		$PaymentTerm = strtolower(trim($_POST['PaymentTerm']));
		if(!empty($PaymentTerm)){
			$arryTerm = explode("-",$PaymentTerm);

			if($arryTerm[1]>0 || $PaymentTerm=='credit card'){ //Net Term & credit card
				 $arryCustomerInfo = $objCustomer->GetCustomerBrief($_POST['CustID'],'','');
				 $CustCode = $arryCustomerInfo[0]['CustCode'];
				 $CustomerLimit = (!empty($arryCustomerInfo[0]['CreditLimitCurrency']) && !empty($arryCustomerInfo[0]['CustCurrency']) && $arryCustomerInfo[0]['CustCurrency']!=$Config['Currency'])?($arryCustomerInfo[0]['CreditLimitCurrency']):($arryCustomerInfo[0]['CreditLimit']);

				$CustomerTotal = $objCustomer->GetCustomerBalance($CustCode) + $_POST['TotalAmount'];
				
				 $Approved = 1;
				 if($CustomerLimit>0 && $CustomerTotal>$CustomerLimit){
					$Approved = 0;
				 }else if(empty($CustomerLimit)){
					$Approved = 0;
				 }


			}
		}
	}else{
		$Approved = 1;
	}

	if(!empty($_GET['pkk'])){
		echo $CustomerLimit.'#'.$CustomerTotal.'#'.$Approved;	exit; 
	}
	$_POST['Approved'] = $Approved;
}


         $order_id = $objSale->AddSale($_POST);
         $_POST['OrdID'] = $order_id;
         $objSale->AddEDISale($_POST);
         //unset($_POST['order_id']);
    /***code for add document by sachin***/
					//PR($_FILES['FileName']);
					$i=0;
					
					$errorFileDoc='';
                    foreach($_FILES['FileName']['name'] as $val){
                          //echo $val;
                    
                       if($val!= ''){


				/***********/
				$ArryFileName['name'] = $_FILES['FileName']['name'][$i];
				$ArryFileName['tmp_name'] = $_FILES['FileName']['tmp_name'][$i];
				$OldFile = $_POST['OldFile'][$i]; 


				$heading = "Sales".$module."_".$order_id."_".$i;

				$FileInfoArray['FileType'] = "Document";
				$FileInfoArray['FileDir'] = $Config['S_DocomentDir'];
				$FileInfoArray['FileID'] =  $heading;
				$FileInfoArray['OldFile'] = $OldFile;
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($ArryFileName, $FileInfoArray); 
				if($ResponseArray['Success']=="1"){
					$documentArry=array('OrderID'=>$order_id,'ModuleName'=>'Sales','Module'=>'Sales'.$module,'FileName'=>$ResponseArray['FileName']);
					$objConfig->UpdateDoc($documentArry);
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}
				/***********/

 
						 
			  }
			  $i++;
			}//end foreach
					 
                       /***End code for add document by sachin ****/
					  $_SESSION['mess_Sale'] = $ModuleName.ADDED.$OtherMsg.'<br>'.$errorFileDoc;
					  $objSale->sendSalesEmail($order_id);

					/*****************/
					include("includes/html/box/paypal_process_add.php"); 
					/*****************/

				} 

				$varianttype='SalesQuote';
				$_POST['varianttype'] = $varianttype;

 				/**********
				if(!empty($_POST['DelItem'])){
					$strSQL = "select sku from s_order_item where id in(".$_POST['DelItem'].")"; 
					$arryDelItem = $objPurchase->query($strSQL, 1);
					foreach($arryDelItem as $key=>$values){ 
						$arrayDelSku[] =  $values['sku'];
					}	

				}
				/**********/	

				$objSale->AddUpdateItem($order_id, $_POST); 


				/**************/
				if(!empty($order_id)){	 			
			     		 $objSale->AddUpdateSpiffInfo($order_id, $_POST);   
				}
				/**************/


				if(!empty($_POST['PONumber']) && $_POST['OrderType']=='PO' && $module=='Order')  {
					
					$objPurchase->AlterPurchaseForDropship($order_id, $_POST); 
				}


				if(!empty($_POST['OrderID']) && $_POST['EDIRefNo']!='' ) {
				   $objSale->UpdateEdiPO($_POST);
				}
				/***********************************/
				if($_POST['SalesPersonID']>0 && $_POST['OldSalesPersonID']!=$_POST['SalesPersonID']){
					$objSale->sendAssignedEmail($order_id, $_POST['SalesPersonID']); 
				}
				/***********************************/
					/****************Invoice gen********************/
				 if(!empty($_POST['EdiConfirm']) && !empty($_POST['InvPOId'])){
     $_POST['InvoiceID'] = $objConfigure->GetNextModuleID('s_order','Invoice');
     $invid_id = $objSale->GenerateInVoice($_POST);
     //$objSale->AddInvoiceItem($invid_id, $_POST);
     $_POST['OID']=$order_id;
     	$objSale->AddShipmentInvoiceItem($invid_id, $_POST);
					$objSale->UpdateInvoiceIDInShip($_POST,$invid_id,$OrderID);
     

    }
/**************************************************/
				
				
					/***********************************/
					$client  = @$_SERVER['HTTP_CLIENT_IP'];
					$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
					$remote  = $_SERVER['REMOTE_ADDR'];

					if(filter_var($client, FILTER_VALIDATE_IP))
					{
					   $ip = $client;
					}
					elseif(filter_var($forward, FILTER_VALIDATE_IP))
					{
					  $ip = $forward;
					}
					else
					{
					$ip = $remote;
					}


					/***********************************/
					$_POST['ModuleType'] ='Sales'.$module;
					$objConfig->AddUpdateLogs($order_id, $_POST); 
					/***********************************/

				$objSale->AddUpdateCreditCard($order_id, $_POST); 

				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "Sales";
				$PdfArray['Module'] = $module;
				$PdfArray['ModuleID'] = $ModuleID;
				$PdfArray['TableName'] =  "s_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $order_id;		 	
				$objConfigure->GeneratePDF($PdfArray);
				/*******************************/ 

				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		




	/***********************************/
	/***********************************/
	if(!empty($_GET['edit'])){
            	//$objSale->UpdateModuleAutoID($_GET['edit'],'wwe34566');

		$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
          //added by nisha
          
          
	$SalesPerson=$venSalesPersonName='';
	if(!empty($arrySale[0]['SalesPersonID'])){
	$empSalesPersonName = $objConfig->getSalesPersonName($arrySale[0]['SalesPersonID'],0);
	$SalesPerson = $empSalesPersonName;
	}
	if(!empty($arrySale[0]['VendorSalesPerson'])){
	$venSalesPersonName = $objConfig->getSalesPersonName($arrySale[0]['VendorSalesPerson'],1);
	$SalesPerson = $venSalesPersonName;
	}
	if((!empty($empSalesPersonName)) && (!empty($venSalesPersonName))){
	$SalesPerson = $empSalesPersonName.",".$venSalesPersonName;
	}
	$arrySale[0]['SalesPerson'] = $SalesPerson;

	

				/*****ADD COUNTRY/STATE/CITY NAME****/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				    /***********************************/

//Billing
//pr($arrySale,1);
if(empty($arrySale[0]['CountryId'])){
	$arryBillCountryID = $objRegion->GetCountryByIDCode($arrySale[0]['Country']);
//pr($arryBillCountryID,1);
	$arrySale[0]['CountryId'] = (!empty($arryBillCountryID[0]['country_id']))?($arryBillCountryID[0]['country_id']):("");
	if(empty($arrySale[0]['CountryId'])) $displayCountryBlock = 1;
}
 
if(empty($arrySale[0]['StateID'])){
	$arryBillStateID = $objRegion->GetStateID($arrySale[0]['State'],$arrySale[0]['CountryId']);
	$arrySale[0]['StateID'] = (!empty($arryBillStateID[0]['state_id']))?($arryBillStateID[0]['state_id']):(""); 
	if(empty($arrySale[0]['StateID'])) $displayStateBlock = 1;
}
if(empty($arrySale[0]['CityID'])){
	$arryBillCityID = $objRegion->GetCityIDSt($arrySale[0]['City'],$arrySale[0]['StateID'],$arrySale[0]['CountryId']);
	$arrySale[0]['CityID'] = (!empty($arryBillCityID[0]['city_id']))?($arryBillCityID[0]['city_id']):("");  

	if(empty($arrySale[0]['CityID'])) $displayCityBlock = 1;
}
//END

 //Shipping
if(empty($arrySale[0]['ShippingCountryID'])){
	$arryshippCountryID = $objRegion->GetCountryByIDCode($arrySale[0]['ShippingCountry']);
	$arrySale[0]['ShippingCountryID'] = (!empty($arryshippCountryID[0]['country_id']))?($arryshippCountryID[0]['country_id']):("");   
	if(empty($arrySale[0]['ShippingCountryID'])) $displayShipCountryBlock = 1;
}
if(empty($arrySale[0]['ShippingStateID'])){
$arryshippStateID = $objRegion->GetStateID($arrySale[0]['ShippingState'],$arrySale[0]['ShippingCountryID']);
$arrySale[0]['ShippingStateID'] = (!empty($arryshippStateID[0]['state_id']))?($arryshippStateID[0]['state_id']):("");   
if(empty($arrySale[0]['ShippingStateID'])) $displayShipStateBlock = 1;
#if($arrySale[0]['ShippingStateID']=='' || empty($arrySale[0]['ShippingStateID'])) {
}
if(empty($arrySale[0]['ShippingCityID'])){
$arryshippCityID = $objRegion->GetCityIDSt($arrySale[0]['ShippingCity'],$arrySale[0]['ShippingStateID'],$arrySale[0]['ShippingCountryID']);
$arrySale[0]['ShippingCityID'] = (!empty($arryshippCityID[0]['city_id']))?($arryshippCityID[0]['city_id']):("");   
if(empty($arrySale[0]['ShippingCityID'])) $displayShipCityBlock = 1;
}
 
 

				if(!empty($arrySale[0]['CountryId'])){
				$arryState = $objRegion->getStateByCountry($arrySale[0]['CountryId']);
				$arryCity = $objRegion->getCityList($arrySale[0]['StateID'],$arrySale[0]['CountryId']);   
				}

		if(!empty($arrySale[0]['ShippingCountryID'])){

		$arryShippingState = $objRegion->getStateByCountry($arrySale[0]['ShippingCountryID']);
		$arryShippingCity = $objRegion->getCityList($arrySale[0]['ShippingStateID'],$arrySale[0]['ShippingCountryID']);

		}
						/***********************************/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

				/**************END COUNTRY NAME*********************/         
   $OrderID   = $arrySale[0]['OrderID'];	
   $SaleID   = $arrySale[0]['SaleID'];

		/*****************/
		if($Config['vAllRecord']!=1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/

               /****GET Document by sachin****/
       $_GET['OrderID']=$_GET['edit'];
       $_GET['Module']='Sales'.$module;
       $_GET['ModuleName']='Sales';
       $getDocumentArry=$objConfig->GetOrderDocument($_GET);
       //PR($getDocumentArry);
       /****GET Document by sachin****/



		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);

				 

			if(!empty($arrySale[0]['PaymentTerm'])){
				$TransactionExist = $objSale->isSalesTransactionExist($OrderID);
				if($arrySale[0]['PaymentTerm']=="PayPal"){
					if($arrySale[0]['OrderPaid']!=0 && !empty($arrySale[0]['paypalInvoiceId'])){ //paid/refunded
						$PayPalPaid=1;
					}					
				}			
			}


            $arryContact = $objCustomer->GetCustomerShippingContact($arrySale[0]['CustID']);

            $shipList='<select name="shipto" id="shipto"  class="inputbox" onchange="ChangeShipaddress(this.value,\''.$arrySale[0]['CustID'].'\')">';

            for($count=0;$count<count($arryContact);$count++){
                  
                    $shipList .='<option value="'.$arryContact[$count]['AddID'].'">'.$arryContact[$count]['Company'].'</option>';
            }

            $shipList .='</select>';
$nne = '';
			
			/*****************************/
 

			/*******Setting Default Shipping Account*********/
			$arryShipAccount=$objCustomer->ListCustShipAccount($arrySale[0]['ShippingMethod'],$arrySale[0]['CustID']);
			if(!empty($arrySale[0]['ShippingAccountNumber'])){
				if(!empty($arryShipAccount)){ 					 
					foreach($arryShipAccount as $vals) {
						if($vals['api_account_number']==$arrySale[0]['ShippingAccountNumber']){
						 $ShipAccExist=1;break;
						}
					}
				}
				if(empty($ShipAccExist)) 
					$arryShipAccount[]['api_account_number'] = $arrySale[0]['ShippingAccountNumber'];		 
			 
			}
			/**********************/




		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		 $NextModuleID= $objConfigure->GetNextModuleID('s_order',$module);
$nne = 'display:none;';

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
 $WarehouseDrop  =$objCondition-> GetWarehouseDropValue('');
	$arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();

	$arryCustomer=$objCustomer->GetCustomerList();
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
if($_GET['module']=='Quote'){
 $NextSalesModuleID= $objConfigure->GetNextModuleID('s_order','Order'); 
}





	require_once("../includes/footer.php"); 	 
?>


