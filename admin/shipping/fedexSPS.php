<?

		/*************LABEL***************/
		/************************************/
 
		
		$objShip = new fedexShipment();				
		$objShip->requestType("shipment");
		if($Config['live']==1){  
			$objShip->wsdl_root_path = "wsdl-live/";
		}else{
			$objShip->wsdl_root_path = "wsdl-test/";
		}


		$order_id = $_POST['INVOICENO'];


		$client = new SoapClient($objShip->wsdl_root_path . $objShip->wsdl_path, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information



		$realTotalPackages = $total_packages;
		$est_amount = $totalFreight; //1100.00;

		//$est_amount += $freigh;

		$tracking_id = "";
		$form_id = "";
		
		

                for($main_loop = 0;$main_loop<$realTotalPackages;$main_loop++)
                {
                	$packages = array();
                	$aryPackage = array();

                	$package_amount = round($est_amount/$realTotalPackages,2);
                	$item_amount = $package_amount/4;

			/******************/
			$lineItemCount=$main_loop+1;
			if($_POST['packageType'] == 'YOUR_PACKAGING'){
				$Weight = $_POST['Weight'.$lineItemCount];
				$wtUnit = $_POST['wtUnit'.$lineItemCount];
				$htUnit = $_POST['htUnit'.$lineItemCount];
				$Length = $_POST['Length'.$lineItemCount];
				$Width =  $_POST['Width'.$lineItemCount];
				$Height = $_POST['Height'.$lineItemCount];
				if(empty($Length)) $Length=1;
				if(empty($Width)) $Width=1;
				if(empty($Height)) $Height=1;
			}else{
				$Weight=$_POST['WPK'];
				$wtUnit = $_POST['WPK_Unit'];
				$Length="";
				$Width="";
				$Height="";
				$htUnit="IN";
			}
			/******************/




                	$package_weight = $Weight; //50.0;

                	$packages[0] = new Package("FEDEX Package # $main_loop for order ".$order_id, 1, 1);
                	 

			$packages[0]->setPackageWeight($Weight,$wtUnit);     //Package Actual Weight
		 
		    	$packages[0]->setPackageDimensions($Length, $Width, $Height,$htUnit); //Package (Length x Width x Height)



                	$aryPackage[0] = $packages[0]->getObjectArray();

                	$item_weight = $package_weight/4;


                	$aryPackageItems = array();
                	for($cnt=0;$cnt<4;$cnt++)
                	{
                		$aryPackageItems[$cnt]['item_qty'] = $cnt+10+1;
                		$aryPackageItems[$cnt]['item_price'] = $item_amount;
                		$aryPackageItems[$cnt]['item_name'] = "Item Name - ".($cnt+1)." of Package ".($main_loop+1);
                		$aryPackageItems[$cnt]['item_weight'] = $item_weight;
                	}

                	$aryCustomClearance = $objShip->addCustomClearanceDetail($aryPackageItems, $package_amount);

                	if($main_loop>0)
                	{
                		$is_first_package['master_tracking_id'] = $tracking_id;
                		$is_first_package['form_id'] = $form_id;
                		$request = $objShip->requestShipment($aryRecipient, $aryOrder, $aryPackage, $aryCustomClearance, $is_first_package);
                	}
                	else
                	$request = $objShip->requestShipment($aryRecipient, $aryOrder, $aryPackage, $aryCustomClearance);

              //echo 'test<pre>'; print_r($request);exit;
		
                	try
                	{
                		if ($objShip->setEndpoint('changeEndpoint'))
                		{
                			$newLocation = $client->__setLocation(setEndpoint('endpoint'));
                		}

                		$response = $client->processShipment($request); // FedEx web service invocation

				 	
				//echo 'test<pre>'; print_r($response);exit;

                		if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR')
                		{
					$DeliveryDate=$response->CompletedShipmentDetail->OperationalDetail->DeliveryDate;

                			$success = $objShip->showResponseMessage($response);
                			$TrackingID = $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber;

                			$file_name = 'FedEX000_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.pdf';
                			$fp = fopen($MainDir.$file_name, 'wb');
                			fwrite($fp, ($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image));
                			fclose($fp);

					/*****************/
					if($Config['ObjectStorage']=="1"){						$ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name);
						if($ResponseArray['Success']=="1"){
							unlink($MainDir.$file_name);  	
						}
					}
					/*****************/
					
					/**********COD Label*********/
					if($_POST['COD']=='1' && $_POST['CODAmount']>0 && !empty($response->CompletedShipmentDetail->CodReturnDetail->Label->Parts->Image)){
						$file_name1 = 'FedEXCOD_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.pdf';
		        			$fp1 = fopen($MainDir.$file_name1, 'wb');

		        			fwrite($fp1, ($response->CompletedShipmentDetail->CodReturnDetail->Label->Parts->Image));
		        			fclose($fp1);


					/*****************/
					if($Config['ObjectStorage']=="1"){
						$ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name1);
						if($ResponseArray['Success']=="1"){
							unlink($MainDir.$file_name1);  	
						}
					}
					/*****************/


					}
					/***************************/

                			if($main_loop == 0)
                			{
                				$tracking_id = $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber;
                				$form_id = $response->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->FormId;
                			}
					

                		}
                		else
                		{
					$error = $response->Notifications->Message; 
					if(empty($error)){
                				$error = $response->Notifications[0]->Message; 
					}
                			
                		}



                	}
                	catch (SoapFault $exception)
                	{
                		echo $objShip->requestError($exception, $client);
                	}
                }


		
?>
