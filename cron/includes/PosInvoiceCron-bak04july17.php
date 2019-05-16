<?php 

require_once($Prefix."lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrappos.php");	
use PayPal\Api\BillingInfo;
use PayPal\Api\Currency;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\InvoiceItem;
use PayPal\Api\MerchantInfo;
use PayPal\Api\PaymentTerm;
use PayPal\Api\ShippingInfo;
use PayPal\Api\PaymentDetail;
use PayPal\Api\Payment;
use PayPal\Api\Sale;



$dbname  =  $Config['DbName'];

if($dbname=="erp_LazizaInc" || $dbname=="erp_LaCarraiaAdmin" ){

//$pos_order =   $objPosUser->getResult('pos_order',array('is_invoice_created'=>'No','order_status'=>'completed'));
 $pos_order =   $objPosUser->getInvoiceCompleteOrder();




if(count($pos_order)>0 && is_array($pos_order)){
$openOrder = array();
foreach($pos_order as $data){
	
	
	
	/*
	// get setting
	$pos_setting =   $objPosUser->getResult('pos_settings',array('vendor_id'=>$data['vendor_id']));
	
	
	if(count($pos_setting)>0){
		foreach($pos_setting as $setiing){
			   if($setiing['action']=="paypal_account_sttings"){
				   $paypalData = unserialize($setiing['data']);   
				   if($paypalData['PaypalMode']=="live"){
					    $paypalUsername  =  $paypalData['PaypalUserName'];	
				   }
				   
			   }else if($setiing['action']=="company_settings"){
				     $companyData = unserialize($setiing['data']);
					 
					 
				     $arryCompanyCompanyName = $companyData['CompanyName'];
				     $arryCompanyContactPerson  = $companyData['PrimaryContactName']; 
				     $BusinessAddress  = $companyData['BusinessAddress']; 
				     $BusinessCity  = $companyData['BusinessCity']; 
				     $BusinessState  = $companyData['BusinessState']; 
				     $BusinessPostal  = $companyData['BusinessPostal']; 
				     $BusinessCountry  = $companyData['BusinessCountry']; 
					 
			    }else if($setiing['action']=="basic_location_sttings"){
				   $locationData = unserialize($setiing['data']);
				    $LocationName =   $locationData['LocationName'];
			   }
			
		}
		
		
	}
	*/
	 
	 $locationData = unserialize($data['LocationName']);
     $result_item = $objPosUser->getResult('pos_order_item',array('order_id'=>$data['order_id']));
    $e_customers = $objPosUser->getResult('e_customers',array('Cid'=>$data['server_id']));
	$data['server'] = $e_customers[0]['FirstName']." ".$e_customers[0]['LastName'];
	$data['customer_name'] ="";
	if(!empty($data['customer_guest_id'])){
    $e_customers_guest = $objPosUser->getResult('e_customers',array('Cid'=>$data['customer_guest_id']));
	
	$data['customer_name'] = $e_customers_guest[0]['FirstName']." ".$e_customers_guest[0]['LastName'];
	}
	
    $result_item = $objPosUser->getProductItem($data['order_id']);
	
	
	  if(count($result_item)>0){
		  foreach($result_item as $item){ 
			  $result_item = $objPosUser->getProductModiItem($item['order_item_id']);
			  
			   $item['forceAndOptionalArrayItems']  =$result_item;
			   $data['items'][]= $item;
		  }
		  $openOrder[] =  $data;
		    
	  }
	


}
}	



if(count($openOrder)>0){




//echo  "<pre>";print_r($pos_order);die;

foreach($openOrder as $val){     // main order array
	
   $vendor_id   = $val['vendor_id'];
   $order_id   =  "INVP-".$vendor_id."-".$val['order_id'];
  
    $orderid=$val['order_id'];	
	$biiingAddress= true;
    $payment_id   = $val['payment_transaction_id'];
    $payment_type   = $val['payment_type'];
	$transaction_fee  =0;
		
			
    
			
			 $totalOrderPrice  = 0;
			 $totalOrderPrice =  $totalOrderPrice+$val['order_total_tax_price'];
			 
			$payment_date = date('Y-m-d h:i:s',strtotime($val['open_order_date']));    // 2014-07-06 03:30:00 PST
			
			$itemsArray = array();
			
                  $customer_name   = $val['customer_name'];
                  $orderAmount  = $val['order_total_include_tax_price'];
					if(count($val['items'])>0){
						    $itemKey = 0;
							$items= array();
							$itemsArray =  $val['items'];
						 
						     try {
								
								$UpdateOrderdata =array();
								$UpdateOrderdata['is_invoice_created'] = 'Yes';
								$db->update('pos_order',$UpdateOrderdata,array('order_id'=>$orderid));
								 
                  
                    // add s_order  
					// $responce['order']['InvoiceID']="INV".$vendor_id."-".$orderid;
				  $responce['order']['paypalInvoiceId']="";
                  $responce['order']['paypalInvoiceNumber']="";
                 // $responce['order']['TotalAmount']=$orderAmount;
                 // $responce['order']['TotalInvoiceAmount']=$orderAmount;
                  $responce['order']['Module']='Invoice';
                  $responce['order']['CustomerCurrency']="USD";
                  $responce['order']['Status']='Completed';
                  $responce['order']['InvoicePaid']='Unpaid';
                  $responce['order']['OrderSource']='POS';
                  $responce['order']['paypalEmail']="";
                  $responce['order']['OrderPaid']=0;
                  $responce['order']['OrderType']='Standard';
				  
				  if($payment_type=="paypal"){
                  $responce['order']['PaymentTerm']='PayPal';
				  }else{
				   $responce['order']['PaymentTerm']='CASH';  
				  }
				  
                  $responce['order']['AutoID']=$orderid;
                  $responce['order']['OrderDate']=date('Y-m-d');
                  $responce['order']['InvoiceDate']=date('Y-m-d');
                  $responce['order']['DeliveryDate']=date('Y-m-d');
                  $responce['order']['ClosedDate']=date('Y-m-d');
                  $responce['order']['PaymentDate']=date('Y-m-d');
                  $LocationNamesbstr  = substr($locationData['LocationName'],0,5);
				  
                  $responce['order']['CustomerPO']=$LocationNamesbstr."-".$orderid;
                  $responce['order']['taxAmnt']=$val['order_total_tax_price'];
                  $responce['order']['Fee']=$transaction_fee;
                  $responce['order']['VendorID']=$vendor_id;
                  $responce['order']['EntryBy']='C';
				  
			
			if($biiingAddress){
				 $responce['order']['CustomerCompany'] = $arryCompanyCompanyName;
				 $responce['order']['ShippingName']=$locationData['LocationName'];
				 $responce['order']['ShippingAddress']=$locationData['Address'];
				 $responce['order']['ShippingCity']=$locationData['City'];
				 $responce['order']['ShippingState']=$locationData['State'];
				 $responce['order']['ShippingCountry']=$locationData['Country'];
				 $responce['order']['ShippingZipCode']=$locationData['PostalCode'];
				 
				 $responce['order']['ShippingCompany']= $arryCompanyCompanyName;
				 $responce['order']['BillingName']=$locationData['LocationName'];
				 $responce['order']['Address']=$locationData['Address'];
				 $responce['order']['City']=$locationData['City'];
				 $responce['order']['State']=$locationData['State'];
				 $responce['order']['Country']=$locationData['Country'];
				 $responce['order']['ZipCode']=$locationData['PostalCode'];
				
			}
				  
				  			  
                  $s_orderLastId =   $db->insert('s_order',$responce['order']);
				  
					$objConfigure = new configure();
					$objConfigure->UpdateModuleAutoID('s_order','Invoice',$s_orderLastId,'');
					
								  // start item product entry
								  
								  
								   foreach($itemsArray as $key=>$item){   // item array
											 // check modifier is avilable or note
											 if(count($item['forceAndOptionalArrayItems'])>0){
												   foreach($item['forceAndOptionalArrayItems'] as $forcedate){
													       
														        $totalOrderPrice = $totalOrderPrice+$forcedate['modifiers_product_price'];
																$responce['s_order_item']['OrderID']=  $s_orderLastId;   
																$responce['s_order_item']['item_id']=  $forcedate['ItemID'];   
																$responce['s_order_item']['sku']=  $forcedate['Sku'];   
																$responce['s_order_item']['qty']=  1;   
																$responce['s_order_item']['qty_invoiced']=  1;   
																$responce['s_order_item']['price']=  $forcedate['modifiers_product_price'];   
																$responce['s_order_item']['amount']=  $forcedate['modifiers_product_price'];   
																$responce['s_order_item']['ref_id']=  $forcedate['modifiers_id'];   
																$responce['s_order_item']['description']= $forcedate['modifiers_product_name'];   
																$db->insert('s_order_item',$responce['s_order_item']); 
																$responce=array();
															 }
													   
													   
												   }
                                    $totalOrderPrice = $totalOrderPrice+$item['product_price'];
							        $responce['s_order_item']['OrderID']=  $s_orderLastId;   
							        $responce['s_order_item']['item_id']=  $item['ItemID'];   
							        $responce['s_order_item']['sku']=  $item['Sku'];   
							        $responce['s_order_item']['qty']=  (empty($item['quantity'])?1:$item['quantity']);   
							        $responce['s_order_item']['qty_invoiced']=  (empty($item['quantity'])?1:$item['quantity']);   
							        $responce['s_order_item']['price']=  $item['product_price'];   
							        $responce['s_order_item']['amount']=  $item['product_price'];   
							        $responce['s_order_item']['ref_id']=  $item['order_item_id'];   
							        $responce['s_order_item']['description']= $item['product_name'];   
									 $db->insert('s_order_item',$responce['s_order_item']);
						             $responce =array();
											 
									}
								  // end product entry
								
								  $db->update('s_order',array('TotalAmount'=>$totalOrderPrice,'TotalInvoiceAmount'=>$totalOrderPrice),array('OrderID'=>$s_orderLastId)); 
								
								  
								//exit('Done');
								} catch (Exception $ex) {
									//print_r($ex);
							       $errors=json_decode($ex->getData());
									echo "<pre>";print_r($errors);die;
									//exit('error');
									// the message
										$msg = $errors;
										mail("pankaj.mca13@gmail.com","POS Invoice Order Error",$msg);
									
									
								}
				  

				  
		            }

}

}
}else{
	//$msg = 'testing';
							//			mail("pankaj.mca13@gmail.com","POS Invoice Order Error",$msg);
}




?>
