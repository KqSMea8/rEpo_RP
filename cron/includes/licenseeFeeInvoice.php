

<?php
$objSale = new sale();
$arryPosInvoice = $objSale->GetPosInvoice();

//DefaultCompany
if($values['License'] ==1 &&  $values['LicenseAmtype'] =='Percentage' && $values['DefaultCompany']!=1 ){
if(count($arryPosInvoice)>0 && is_array($arryPosInvoice)){
	    $PosInvoice = array();
	     foreach($arryPosInvoice as $data){
			 		 

					
								$PostLicenseeFee = ($values['LicenseAmt'] / 100) * $data['TotalAmount'];
								$PostLicenseeFee = number_format($PostLicenseeFee, 2, '.', '');
								$data['PostLicenseeFee'] = $PostLicenseeFee;
                $data['CompanyName'] = $values['DisplayName'];
				
					if($data['data']!=''){
					 $arryLoc = unserialize($data['data']);
					$data['LocationName'] = $arryLoc['LocationName'];
					$data['LocationAddress'] = $arryLoc['Address'];
					}

					$data['BillingName']  = $values['CompanyName'];
					$data['CustomerName'] = $values['DisplayName'];
					$data['CustomerCompany'] = $values['CompanyName'];
					$data['Address']  = $values['Address'];
					$data['City']    = $values['City'];
					$data['State']   = $values['State'];
					$data['Country'] = $values['Country'];
					$data['ZipCode'] = $values['ZipCode'];
					$data['Mobile']   =  $values['Mobile'];
					$data['Landline'] = $values['LandlineNumber'];
					$data['Fax']      = $values['Fax'];
					$data['Email']    = $values['Email'];
					$data['ShippingName']= $values['CompanyName'];
					$data['ShippingCompany']= $values['CompanyName'];
					$data['ShippingAddress']= $values['Address'];
					$data['ShippingCity']= $values['City'];
					$data['ShippingState']=$values['State'];
					$data['ShippingCountry']=$values['Country'];
					$data['ShippingZipCode']= $values['ZipCode'];
					$data['ShippingMobile'] =  $values['Mobile'];
					$data['ShippingLandline']= $values['LandlineNumber'];
					$data['ShippingFax']= $values['Fax'];
					$data['ShippingEmail']= $values['Email'];



/*BillingName = '".addslashes($BillingName)."',
																		CustomerName = '".addslashes($CustomerName)."',
																		CustomerCompany = '".addslashes($CustomerCompany)."',
																		Address = '".addslashes(strip_tags($Address))."',
																		City = '".addslashes($City)."',
																		State = '".addslashes($State)."',
																		Country = '".addslashes($Country)."',
																		ZipCode = '".addslashes($ZipCode)."',
																		Mobile = '".$Mobile."', 
																		Landline = '".$Landline."',
																		Fax = '".$Fax."',
																		Email = '".addslashes($Email)."',
																		ShippingName = '".addslashes($ShippingName)."',
																		ShippingCompany = '".addslashes($ShippingCompany)."',
																		ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."',
																		ShippingCity = '".addslashes($ShippingCity)."',
																		ShippingState = '".addslashes($ShippingState)."',
																		ShippingCountry = '".addslashes($ShippingCountry)."',
																		ShippingZipCode = '".addslashes($ShippingZipCode)."',
																		ShippingMobile = '".$ShippingMobile."',
																		ShippingLandline = '".$ShippingLandline."',
																		ShippingFax = '".$ShippingFax."',
																		ShippingEmail = '".addslashes($ShippingEmail)."',

*/


























			       //$arryPosInvoice = $objSale->GetSaleItem($data['OrderID']);
				    
					  /*if(count($arryPosInvoice)>0){
						  foreach($arryPosInvoice as $PosInvoiceitem){ 
							
							   $data['PosInvoiceitem'][]= $PosInvoiceitem;
						  }
						  $PosInvoice[] =  $data;
						    
					  }*/
					
			  $PosInvoice[] =  $data;
			 
		 }
}	

	}

	
		
	echo "<pre>";
print_r($PosInvoice);
	echo "</pre>";



if($values['DisplayName']=="bhoodev"){


if(sizeof($PosInvoice)>0){
foreach($PosInvoice as $invoiceData){

$PosExitInvoice = $objSale->GetPosRefInvoice($invoiceData['order_id']);

$LocationName = substr($invoiceData['LocationName'], 0, -4);

 																									//$responce['order']['InvoiceID']= '';

																									//$responce['order']['InvoiceID'] = 'INV'.;
												  										  	$responce['order']['paypalInvoiceId']=$invoiceData['paypalInvoiceId'];
                                                  $responce['order']['paypalInvoiceNumber']=$invoiceData['paypalInvoiceNumber'];
                                                  $responce['order']['TotalAmount']=$invoiceData['PostLicenseeFee'];
                                                  $responce['order']['TotalInvoiceAmount']=$invoiceData['PostLicenseeFee'];
                                                  $responce['order']['Module']='Invoice';
                                                  $responce['order']['CustomerCurrency']=$invoiceData['CustomerCurrency'];
                                                  $responce['order']['Status']='Completed';
                                                  $responce['order']['InvoicePaid']='Unpaid';
                                                  $responce['order']['OrderSource']='POS-Licensee';
                                                  //$responce['order']['paypalEmail']=$invoiceData['paypalEmail'];
                                                  $responce['order']['OrderPaid']=0;
                                                  $responce['order']['OrderType']='Standard';
                                                  $responce['order']['PaymentTerm']='PayPal';
                                                  //$responce['order']['AutoID']=$invoiceData['AutoID'];
                                                  $responce['order']['OrderDate']=date('Y-m-d');
                                                  $responce['order']['InvoiceDate']=date('Y-m-d');
                                                  $responce['order']['DeliveryDate']=date('Y-m-d');
                                                  $responce['order']['ClosedDate']=date('Y-m-d');
                                                  $responce['order']['PaymentDate']=date('Y-m-d');
                                                  $responce['order']['CustomerPO']=$invoiceData['CompanyName']."-".$LocationName."-".$invoiceData['order_id'];
                                                  $responce['order']['taxAmnt']=$invoiceData['taxAmnt'];
                                                  //$responce['order']['Fee']=$invoiceData['paypalInvoiceNumber'];
                                                  $responce['order']['VendorID']=$invoiceData['VendorID'];
																									$responce['order']['SaleID']=$invoiceData['order_id'];
																										
																									$responce['order']['BillingName']  = $invoiceData['CompanyName'];
																									$responce['order']['CustomerName'] = $invoiceData['CustomerName'];
																									$responce['order']['CustomerCompany'] = $invoiceData['CustomerCompany'];
																									$responce['order']['Address']  = $invoiceData['Address'];
																									$responce['order']['City']    = $invoiceData['City'];
																									$responce['order']['State']   = $invoiceData['State'];
																									$responce['order']['Country'] = $invoiceData['Country'];
																									$responce['order']['ZipCode'] = $invoiceData['ZipCode'];
																									$responce['order']['Mobile']   =  $invoiceData['Mobile'];
																									$responce['order']['Landline'] = $invoiceData['Landline'];
																									$responce['order']['Fax']      = $invoiceData['Fax'];
																									$responce['order']['Email']    = $invoiceData['Email'];
																									$responce['order']['ShippingName']= $invoiceData['ShippingName'];
																									$responce['order']['ShippingCompany']= $invoiceData['ShippingCompany'];
																									$responce['order']['ShippingAddress']= $invoiceData['ShippingAddress'];
																									$responce['order']['ShippingCity']= $invoiceData['ShippingCity'];
																									$responce['order']['ShippingState']=$invoiceData['ShippingState'];
																									$responce['order']['ShippingCountry']=$invoiceData['ShippingCountry'];
																									$responce['order']['ShippingZipCode']= $invoiceData['ShippingZipCode'];
																									$responce['order']['ShippingMobile'] =  $invoiceData['ShippingMobile'];
																									$responce['order']['ShippingLandline']= $invoiceData['ShippingLandline'];
																									$responce['order']['ShippingFax']= $invoiceData['ShippingFax'];
																									$responce['order']['ShippingEmail']= $invoiceData['ShippingEmail'];



																						if($PosExitInvoice!=1){

																										$s_orderLastId =   $db->insert('s_order',$responce['order']);


																										$objConfigure = new configure();
																										$objConfigure->UpdateModuleAutoID('s_order','Invoice',$s_orderLastId,$InvoiceID); 
																										$responce['s_order_item']['OrderID']=  $s_orderLastId;   
																										$responce['s_order_item']['sku']=  'miscellaneous';   
																										$responce['s_order_item']['qty']=  1;   
																										$responce['s_order_item']['qty_invoiced']=  1;   
																										$responce['s_order_item']['price']=  $invoiceData['PostLicenseeFee'];   
																										$responce['s_order_item']['amount']=  $invoiceData['PostLicenseeFee'];   
																										 
																										$responce['s_order_item']['description']= 'miscellaneous';;   
																										$db->insert('s_order_item',$responce['s_order_item']); 
																						

																						}	   
																 






}






}

}

































