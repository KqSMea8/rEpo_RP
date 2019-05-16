<?
	 // *******************Mark up SetUP************//
	if(!empty($_GET['CustCode'])){
		$arryCust = $objCustomer->GetCustomerAllInformation('',$_GET['CustCode'],1);

		$arrySale[0]['CustomerName'] = $arryCust[0]['CustomerName'];
		$arrySale[0]['CustCode'] = $arryCust[0]['CustCode'];
		$arrySale[0]['CustID'] = $arryCust[0]['Cid'];
		$arrySale[0]['Taxable'] = $arryCust[0]['Taxable'];
 
 
	}
   // *******************End Mark up SetUP************//
   
   if($_GET['EdiConfirm']==1 && $_GET['InvID']!=''){
	$arryP = $objPurchase->GetPurchase('',$_GET['po'],'Invoice');
	$InvPOId =$arryP[0]['OrderID'];
	$arrySale[0]['OrderDate'] =$arryP[0]['PostedDate'];
	$arrySaleItem = $objPurchase->GetPurchaseItem($InvPOId);
   }else if(!empty($_GET['po'])){
	/*******check duplicay********/
	if($objPurchase->isPoExistForSO($_GET['po'])){
		$_SESSION['mess_Sale'] = PO_EXIST_FOR_SO;				
		header('location:'.$EditUrl);
		exit;	
	}	
	/****************/

	$arryP = $objPurchase->GetPurchase($_GET['POID'],$_GET['po'],'Order');	
 
	$arrySale[0]['PONumber'] = $_GET['po'];
	//$arrySale[0]['FromPOId'] = $_GET['POID'];
	$arrySale[0]['OrderDate'] =$arryP[0]['OrderDate'];
	$arrySaleItem = $objPurchase->GetPurchaseItem($_GET['POID']);    
   }
   $NumLine = sizeof($arrySaleItem);
     
 	$arrySale[0]['OrderType'] = 'PO';
	$arrySale[0]['Freight'] =$arryP[0]['Freight'];

 


	/**PK*****/
	if(empty($arryCust[0]['Currency'])) $arryCust[0]['Currency']=$Config['Currency'];
	$arrySale[0]['CustomerCurrency'] = $arryCust[0]['Currency'];
     
       if($NumLine>0){
		$PoConversionRate = 1;
		if(!empty($arrySale[0]['CustomerCurrency']) && !empty($arryP[0]['Currency']) && $arrySale[0]['CustomerCurrency']!=$arryP[0]['Currency']){
			$PoConversionRate = CurrencyConvertor(1,$arryP[0]['Currency'],$arrySale[0]['CustomerCurrency'],'AR',$arrySale[0]['OrderDate']);	
		}

		if(!empty($_GET['PK'])){
			echo $PoConversionRate;
		}
	 
		$Count=0;
		$TotalAmount=0;
		for($i=0;$i<$NumLine;$i++) { 

			$arrySaleItem[$Count]['Taxable'] = $arrySaleItem[$Count]['sale_tax_rate'];

			if($arryP[0]['OrderType']=="Dropship"){
				$arrySaleItem[$Count]['DropshipCheck'] = 1;
			}
 			
			if($arrySaleItem[$Count]['DropshipCost']>0){
				$arrySaleItem[$Count]['DropshipCost'] = round(GetConvertedAmount($PoConversionRate, $arrySaleItem[$Count]['DropshipCost']) ,2);
			}

			if($arrySaleItem[$Count]['avgCost']>0){
				$arrySaleItem[$Count]['avgCost'] = round(GetConvertedAmount($PoConversionRate, $arrySaleItem[$Count]['avgCost']) ,2);
			}

			$unitprice = $arrySaleItem[$Count]['price'];
			if($unitprice>0){
				$unitprice = round(GetConvertedAmount($PoConversionRate, $unitprice) ,2);
				$arrySaleItem[$Count]['price'] = $unitprice;
			}
 
			if($arryCust[0]['MDType']=='Markup'){ //calulating total only
				$totDiscountCal = $unitprice*$arryCust[0]['MDAmount']/100;
		 		$price = $unitprice+ $totDiscountCal;
				$unitprice = round($price,2);

				$amount =  round($unitprice*$arrySaleItem[$Count]['qty'],2);
				$arrySaleItem[$Count]['amount'] = $amount;
				$TotalAmount += $amount;
			}
			
			$Count++;

		}

		if($arrySale[0]['Freight']>0){  
			$PoFreight = round(GetConvertedAmount($PoConversionRate, $arrySale[0]['Freight']) ,2);
			$arrySale[0]['Freight'] =  $PoFreight;
			$TotalAmount += round($PoFreight,2);
		}
				 
		$arrySale[0]['TotalAmount'] = $TotalAmount;
	}
	/*******/
	 

?>
