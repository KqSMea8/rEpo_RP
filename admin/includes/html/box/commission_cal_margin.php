<?
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();	

 
	(empty($OrderID))?($OrderID=""):("");
	(empty($IndividualOrderID))?($IndividualOrderID=""):("");
 


	if($EmpID>0 && @substr_count("5,6,7", $EmpDivision)==0){
		$Config['SalesCommission']=0;
	}
	$ShowSalesReport=1;
	$TotalCommission=0; $TotalSales=0; $TotalSalesComm=0; $TotalSalesSpiff=0;

	$LastMargin = $LastComm = 0;
 
 

	if($Config['SalesCommission']==1 && ($EmpID>0 || $SuppID>0)){			
		$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID,$SuppID);	
 
	 $Margin=0;//temp
 
if(!empty($arrySalesCommission[0]['CommType'])){
	
	$TargetFrom = $arrySalesCommission[0]["TargetFrom"];
	$TargetTo = $arrySalesCommission[0]["TargetTo"];

	//if($_GET['a']==1){echo $TargetFrom;exit;}

/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesComm=$objSale->GetInvPaymentMargin($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);
		$arryLastInvoice = $objSale->GetInvPaymentNonResidualMargin($FromDate,$ToDate,$EmpID,$SuppID,$IndividualOrderID);
		$LastInvoice = $arryLastInvoice[0]["InvoiceID"];

		 
	}else{
		$arryTotalSalesComm=$objSale->GetInvPaymentMargin($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		 
		 		
	}	
#	echo "<pre>"; print_r($arryTotalSalesComm); echo "</pre>";
	foreach($arryTotalSalesComm as $key_cm=>$values_cm){		
		

 		$InvoiceID = $values_cm['InvoiceID'];
		if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
			$TotalCommission=0;
		}
		/*****margin********/
		$TotalSalesItemComm = $values_cm['TotalItemSales'];
		$ConversionRate=1;
		if($values_cm['CustomerCurrency']!=$Config['Currency'] && $values_cm['ConversionRate']>0){
			$ConversionRate = $values_cm['ConversionRate'];			   
		}
 
		$SubTotal = $objSale->GetSubTotal($values_cm['InID']);
		$OrginalSubTotal = GetConvertedAmount($ConversionRate, $SubTotal); 

		$InvoiceAmount = $values_cm['TotalInvoiceAmount'];
		$OrginalAmount = GetConvertedAmount($ConversionRate, $InvoiceAmount); 

		$TotalAvgCost = $objSale->GetTotalAverageCost($values_cm['InID']);
		$OrginalAvgCost = $TotalAvgCost; //GetConvertedAmount($ConversionRate, $TotalAvgCost); 

		$Freight = $values_cm['Freight'];
		$OrginalFreight = GetConvertedAmount($ConversionRate, $Freight); 

		$Fee = $values_cm['Fee'];
		$OrginalFee = GetConvertedAmount($ConversionRate, $Fee); 

		$Discount = $values_cm['TDiscount'];
		$OrginalDiscount = GetConvertedAmount($ConversionRate, $Discount); 

		$Margin = ($OrginalSubTotal+$OrginalFreight)  - $OrginalDiscount  - $OrginalAvgCost - $OrginalFee;

 	 
		 
		/*********************/
		if($TargetFrom>=0 && ($Margin>=$TargetFrom)){ // || $Margin<0

			$TotalSalesComm = $Margin;
			$TotalSales += $TotalSalesComm;	

			$Percentage = $arrySalesCommission[0]['CommPercentage'];
 
			$Percentage = (!empty($values_cm['CommPercentage']) ? $values_cm['CommPercentage'] : $Percentage);
			if($arrySalesCommission[0]['Accelerator']=="Yes" && $Margin>$TargetTo){
				$OriginalComm = ($TargetTo*$Percentage)/100;	
				$Percentage += $arrySalesCommission[0]['AcceleratorPer'];
				$AccComm = (($Margin-$TargetTo)*$Percentage)/100;

				$TotalCommission += $OriginalComm + $AccComm;
			}else{	
 
				$TotalCommission  += ($Margin*$Percentage)/100;	
			}
			

		}


		if($arrySalesCommission[0]['SalesPersonType']=="Non Residual" && $InvoiceID==$LastInvoice){			 
			$LastMargin = $Margin;	
			$LastComm = $TotalCommission;			 
		}


		
	}
} 
/*********************/	


/***Commision & Spiff*******/	
if($arrySalesCommission[0]['CommType']=="Commision & Spiff"){   
	
	//$arryTotalSalesSpiff = $objSale->GetInvPaymentMargin($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);
	
		/*if($arrySalesCommission[0]['SpiffType']=="one"){
		
		$oneTime =0;
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);	
	
	}else{
		$arryTotalSalesSpiff = $objSale->GetInvPaymentMargin($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);
		
	}*/
	
	if($arrySalesCommission[0]['SpiffType']=="one"){
	$oneTime =0;
	
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);	
	
	}else{
		$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);		
		
	}

if($_GET['ff']==1){

pr($arryTotalSalesSpiff);
}
 
	foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
	
	$TotalSalesSpiff = $values_sp['TotalSales'];
		
	$InvoiceID = $values_sp['InvoiceID'];
		if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
			$TotalCommission=0;
		}
		
		$ConversionRate=1;
		if($values_sp['CustomerCurrency']!=$Config['Currency'] && $values_sp['ConversionRate']>0){
			$ConversionRate = $values_sp['ConversionRate'];			   
		}

		$SubTotal = $objSale->GetSubTotal($values_sp['InID']);
		$OrginalSubTotal = GetConvertedAmount($ConversionRate, $SubTotal); 

		$InvoiceAmount = $values_sp['TotalInvoiceAmount'];
		$OrginalAmount = GetConvertedAmount($ConversionRate, $InvoiceAmount); 

		$TotalAvgCost = $objSale->GetTotalAverageCost($values_sp['InID']);
		$OrginalAvgCost = GetConvertedAmount($ConversionRate, $TotalAvgCost); 

		$Freight = $values_sp['Freight'];
		$OrginalFreight = GetConvertedAmount($ConversionRate, $Freight); 

		$Fee = $values_sp['Fee'];
		$OrginalFee = GetConvertedAmount($ConversionRate, $Fee); 

		$Margin2 = ($OrginalSubTotal+$OrginalFreight) - $OrginalAvgCost - $OrginalFee;	
		
		//$TotalSalesMarComm = $Margin2;
			//$TotalSales += $TotalSalesMarComm;	
		

 
		/*********************/
		/*if($arrySalesCommission[0]["SpiffTarget"]>0 && $Margin>=$arrySalesCommission[0]["SpiffTarget"]){
			$TotalSalesSpiff = $Margin;
			if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
			#$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		}*/
		
		
	if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;

	if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
	
	     $TotalCommission += $values_sp['TotalItemSales'];
	}else{
		   if($arrySalesCommission[0]["amountType"]=='Percentage'){
		     $TotalCommission += ($Margin2*$arrySalesCommission[0]["SpiffEmp"])/100;
		   }else{
		   $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];
		   }
		}


		if($arrySalesCommission[0]['SalesPersonType']=="Non Residual" && $InvoiceID==$LastInvoice){			 
			$LastMargin = $Margin;	
			$LastComm += $TotalCommission;			 
		}

	}


} 
/*********************/
 
/***Spiff Only*******/	
if($arrySalesCommission[0]['CommType']=="Spiff" && empty($arrySalesCommission[0]['SpiffOn'])){   

	//$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);
	if($arrySalesCommission[0]['SpiffType']=="one"){
	$oneTime =0;
	$TotalSales=0;
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);	
	
	}else{
		$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);		
		
	}
 
	foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
			/*********************/
		/*if($arrySalesCommission[0]["SpiffTarget"]>0 && $Margin>=$arrySalesCommission[0]["SpiffTarget"]){
			$TotalSalesSpiff = $Margin;
			if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;

			#$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		}
*/
		
			$TotalSales += $TotalSalesSpiff;
		
    if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
       $TotalCommission += $values_sp['TotalItemSales'];
    }else{
       if($arrySalesCommission[0]["amountType"]=='Percentage'){
          $TotalCommission += ($TotalSalesSpiff*$arrySalesCommission[0]["SpiffEmp"])/100;
       }else{
          $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];
       }
    }
			

 
 
		//}
	}
} 
 
/*********************/

/*********************/
 			
						
		}
	
	}
 
 
 
if($arrySalesCommission[0]['SalesPersonType']=="Non Residual" && $arrySalesCommission[0]['CommType']!="Spiff"){
	//echo $LastMargin.'#'.$LastComm;
	$TotalSales = $LastMargin;	 
	$TotalCommission = $LastComm;
}


?>
