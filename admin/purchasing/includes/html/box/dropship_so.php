<?

	/*******check duplicay********/
	if($objPurchase->isSaleExistDropshipPO($_GET['SaleID'])){
		$_SESSION['mess_purchase'] = SALE_EXIST_DROPSHIP_PO;
		header('location:'.$EditUrl);
		exit;	
	}	
	/****************/
	$arryPurchase[0]['OrderType'] = 'Dropship';
	$arrySale = $objSale->GetSale('',$_GET['SaleID'],'Order');

	$arryPurchase[0]['PaymentTerm'] = $arrySale[0]['PaymentTerm'];
	$arryPurchase[0]['PaymentMethod'] = $arrySale[0]['PaymentMethod'];
	$arryPurchase[0]['ShippingMethod'] = $arrySale[0]['ShippingMethod'];
	$arryPurchase[0]['ShippingMethodVal'] = $arrySale[0]['ShippingMethodVal'];

	$arryPurchase[0]['OrderDate'] = $arrySale[0]['OrderDate'];
	//$arryPurchase[0]['Currency'] = $arrySale[0]['CustomerCurrency'];


	if($arrySale[0]['OrderID']>0){
			$SaleID   = $_GET['SaleID'];
			$arrySaleItem = $objSale->GetSaleItem($arrySale[0]['OrderID']);
 


		if(!empty($_GET['SuppCode'])){                    
																					
			$arrygetvendor = $objSupplier->GetSupplier('',$_GET['SuppCode'],''); 											
																					
			$arryPurchase[0]['SuppID'] =  $arrygetvendor[0]['SuppID'];
																				
			$arryPurchase[0]['SuppCode'] =  $arrygetvendor[0]['SuppCode'];
																				
			$arryPurchase[0]['SuppCompany'] =  $arrygetvendor[0]['CompanyName'];
																				
			$arryPurchase[0]['SuppContact'] =  $arrygetvendor[0]['UserName'];
																				
			$arryPurchase[0]['PaymentTerm'] =  $arrygetvendor[0]['PaymentTerm'];
																				
			$arryPurchase[0]['Address'] =  $arrygetvendor[0]['Address'];
																						$arryPurchase[0]['ZipCode'] =  $arrygetvendor[0]['ZipCode'];			    
																						$arryPurchase[0]['Mobile'] =  $arrygetvendor[0]['Mobile'];
																						$arryPurchase[0]['Landline'] =  $arrygetvendor[0]['Landline'];
																						$arryPurchase[0]['Email']  = $arrygetvendor[0]['Email'];
																						$arryPurchase[0]['City'] =  $arrygetvendor[0]['City'];
																						$arryPurchase[0]['State'] =  $arrygetvendor[0]['State'];
																						$arryPurchase[0]['Country'] =  $arrygetvendor[0]['Country'];    
	
		if(empty($arrygetvendor[0]['Currency'])) $arrygetvendor[0]['Currency']=$Config['Currency'];																			$arryPurchase[0]['Currency'] =  $arrygetvendor[0]['Currency'];
																						$arryPurchase[0]['tax_auths'] =  $arrygetvendor[0]['Taxable'];
																						$arryPurchase[0]['MainTaxRate'] =  $arrygetvendor[0]['TaxRate']; 
																						 $arryPurchase[0]['EDICompName'] =  $arrygetvendor[0]['EDICompName']; 
							$arryPurchase[0]['EDICompId'] =  $arrygetvendor[0]['EDICompId'];  
						                       
		}

/*******/
$PoConversionRate = 1;
if(!empty($arrySale[0]['CustomerCurrency']) && !empty($arrygetvendor[0]['Currency']) && $arrySale[0]['CustomerCurrency']!=$arrygetvendor[0]['Currency']){
	$PoConversionRate = CurrencyConvertor(1,$arrySale[0]['CustomerCurrency'],$arrygetvendor[0]['Currency'],'AP',$arrySale[0]['OrderDate']);	
}

/*******/

		$NumSaleItem = sizeof($arrySaleItem);
		

		
	
		
		if(!empty($arryPurchase[0]['EDICompId']) && $arryPurchase[0]['EDICompName']!='' && $arryPurchase[0]['EDIRefNo']!=''){
		   #echo "sale-".$NumSaleItem."=>po-".$NumPoItem; exit;
		   if($NumSaleItem!=$NumPoItem){
		   $_SESSION['mess_purchase'] = SALE_EXIST_EDIDROPSHIP_PO;
		      header('location:'.$EditdevUrl);
		      exit;	
		   }
		} 
		
		
		if(!empty($arryPurchase[0]['EDICompId']) && $arryPurchase[0]['EDICompName']!='' && $arryPurchase[0]['EDIRefNo']!=''){

         $arryEdiRef = explode("/",$arryPurchase[0]['EDIRefNo']);
         $EdiDB = 'erp_'.$arryPurchase[0]['EDICompName'].'.';
         $arryEdiSaleInvoice = $objSale->GetInvoiceOrder($arryEdiRef[4],$EdiDB);
         if(!empty($arryEdiSaleInvoice[0]['OrderID'])){
                $EdiSaleInvoice =$arryEdiSaleInvoice[0]['OrderID'];
         }else{
         
           $EdiSaleInvoice =0;
         }
       

   }

		#$NumSaleItem = sizeof($arrySaleItem);
		if($NumSaleItem>0){
				$TotalAmount=0;
				
				if($NumPoItem>0){ // Append Items
					unset($arryPurchaseItem);
					for($i=0;$i<$NumSaleItem;$i++) { 
						//dd
					}
				}
				#else{ // Add Items
					$Count=0;
					for($i=0;$i<$NumSaleItem;$i++) { 
						if(!empty($arryPurchase[0]['EDICompId']) && $arryPurchase[0]['EDICompName']!='' && $arryPurchase[0]['EDIRefNo']!='' ){
		          #echo "sale-".$NumSaleItem."=>po-".$NumPoItem; exit;
				        /*******check duplicay********/
	        if(!$objPurchase->isEdiSaleItemExist($_GET['edit'],$arrySaleItem[$i]['sku'])){
		        $_SESSION['mess_purchase'] = SALE_EXIST_EDIDROPSHIP_PO;
		        header('location:'.$EditdevUrl);
		        exit;	
	        }else{
	        $arryEdiSaleItem = $objSale->GetSaleItemBySku($EdiSaleInvoice,$arrySaleItem[$i]['sku'],$arrySaleItem[$i]['Condition'],$arrySaleItem[$i]['WID'],$EdiDB);
	       
	             $arryPurchaseItem[$Count]['SerialNumbers'] = $arryEdiSaleItem[0]['SerialNumbers'];
	        }
	   
	      }
					    //if($arrySaleItem[$i]['DropshipCheck']==1 && $arrySaleItem[$i]['DropshipUsed']==0){
if($arrySaleItem[$i]['DropshipUsed']==0){
						if(!empty($_GET['edit'])){
                 $objPurchase->RemovePOItem($_GET['edit']);
              }
		$arryPurchaseItem[$Count]['sku'] = $arrySaleItem[$i]['sku'];
		$arryPurchaseItem[$Count]['item_id'] = $arrySaleItem[$i]['item_id'];
		$arryPurchaseItem[$Count]['Condition'] = $arrySaleItem[$i]['Condition'];
		$arryPurchaseItem[$Count]['description'] = $arrySaleItem[$i]['description'];
		$arryPurchaseItem[$Count]['on_hand_qty'] = $arrySaleItem[$i]['on_hand_qty'];
		$arryPurchaseItem[$Count]['qty'] = $arrySaleItem[$i]['qty'];
		$arryPurchaseItem[$Count]['DropshipCheck'] = $arrySaleItem[$i]['DropshipCheck'];

		if($arryPurchaseItem[$Count]['DropshipCheck'] ==1){
			$DropshipCost = $arrySaleItem[$i]['DropshipCost'];
			
			if($DropshipCost>0){
				$DropshipCost = round(GetConvertedAmount($PoConversionRate, $DropshipCost) ,2);
			}


			$arryPurchaseItem[$Count]['DropshipCost'] = $DropshipCost;
			$arryPurchaseItem[$Count]['price'] = $DropshipCost;
		}else{
			$arryPurchaseItem[$Count]['price'] = '0.00';
		}
						

						 //By chetan 22Feb//
		$arryPurchaseItem[$Count]['tax_id'] = $arrySaleItem[$i]['tax_id'];
		$arryPurchaseItem[$Count]['Taxable'] = $arrySaleItem[$i]['purchase_tax_rate'];
		$arryPurchaseItem[$Count]['amount'] =round( ($arryPurchaseItem[$Count]['qty'] * $arryPurchaseItem[$Count]['price']),2);

		$TotalAmount += round($arryPurchaseItem[$Count]['amount'],2);

						$Count++;

					   }
					}

/*if($Count==0){
$errMsg = '<b>'.NO_DROPSHIP_ITEM.'</b>';
}*/
				#}
				
			}
		}


		if($arrySale[0]['Freight']>0){
			$SalesFreight = round(GetConvertedAmount($PoConversionRate, $arrySale[0]['Freight']) ,2);
			$arryPurchase[0]['Freight'] =  $SalesFreight;
			$TotalAmount += round($SalesFreight,2);
		}
		


		$arryPurchase[0]['TotalAmount'] = $TotalAmount;
		$NumLine = sizeof($arryPurchaseItem);
		if($NumLine==0){
			$errMsg = '<b>'.NO_DROPSHIP_ITEM.'</b>';
		}

//$arryWarehouseCus = $objWarehouse->GetDefaultWarehouseBrief(1);

//$arryPurchase[0]['wName'] =  $arryWarehouseCus[0]['warehouse_name'];
		//$arryPurchase[0]['wName'] =  $arrySale[0]['CustomerName'];


		$arryPurchase[0]['wName'] =  $arrySale[0]['ShippingCompany'];
		$arryPurchase[0]['wAddress'] =  $arrySale[0]['ShippingAddress'];
		$arryPurchase[0]['wCity'] =  $arrySale[0]['ShippingCity'];
		$arryPurchase[0]['wState'] =  $arrySale[0]['ShippingState'];
		$arryPurchase[0]['wCountry'] =  $arrySale[0]['ShippingCountry'];
		$arryPurchase[0]['wZipCode'] =  $arrySale[0]['ShippingZipCode'];
		$arryPurchase[0]['wContact'] =  $arrySale[0]['CustomerName'];
		$arryPurchase[0]['wMobile'] =  $arrySale[0]['ShippingMobile'];
		$arryPurchase[0]['wLandline'] =  $arrySale[0]['ShippingLandline'];
		$arryPurchase[0]['wEmail'] =  $arrySale[0]['ShippingEmail'];
		//if(empty($_GET['EDISalesCompName'])){ $_GET['EDISalesCompName']='';}
		//if(empty($_GET['EDICompId'])){ $_GET['EDICompId']='';}
  



?>
