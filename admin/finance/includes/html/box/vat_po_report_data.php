<?
 
$content = '<table '.$table_bg.'>
	<tr align="left"  >
		<td width="12%" class="head1" align="left" >SKU</td>
		<td width="17%" class="head1" align="left" >Sales Invoice#</td>
		<td width="12%" class="head1" align="left" >Purchase Invoice#</td>
		<td width="12%" class="head1" align="right">Unit VAT on Sales</td>
		<td width="12%" class="head1" align="right">Unit VAT on Purchase</td>
		<td width="12%" class="head1" align="center"> Qty</td>
		<td width="12%" class="head1" align="right">VAT Collection</td>	
		 
	</tr>';

	if(is_array($arryVat) && $num>0){ 
		$flag=true;
		$Line=0;
		$TotalsoAmnt ='0';$TotalCollection ='0';$TotalpoAmnt ='0'; 
		foreach($arryVat as $key=>$values){ 
			$flag=!$flag;
			$bgclass = (!$flag)?("oddbg"):("evenbg");
			$Line++;

				$SoConversionRate=1;		
				if($values['SalesCurrency']!=$Config['Currency']){ 
					$SoConversionRate = $values['SalesConversionRate'];			   
				}
				$PoConversionRate=1;
				 if($values['PurchaseCurrency']!=$Config['Currency']){  
					$PoConversionRate = $values['PurchaseConversionRate'];			   
				}

				

	
				 $PurchaseAmnt = $values['Purchaseprice'];
                    		 $SalesAmnt = $values['Saleprice'];
                    		 
                    		 
                    		 if($values['PurchaseQty'] >0){                		
                    			  $SalesQty = $values['PurchaseQty'];
                    		 }
                    		 else if($values['SaleQty'] >0){
                    			$SalesQty = $values['SaleQty'];
                    		 }
                    		
                    		 if(!empty($values['PurchaseSku'])){                    		
                    			$Sku = $values['PurchaseSku'];
                    		 }
                    		 else if(!empty($values['SalesSku'])){
                    			$Sku = $values['SalesSku'];
                    		 }
                    		                    		
                    		
                    		$TaxRatepurchase = explode(":",$values['PurchaseTax']);
                    		$TaxRatesales = explode(":",$values['SalesTax']);
                    		$PurchaseTax = (!empty($TaxRatepurchase[2])) ? ($TaxRatepurchase[2]) :(""); 
                    		$SalesTax = (!empty($TaxRatesales[2])) ? ($TaxRatesales[2]) :("");
                    		
                    		//$SalesVatAmnt = ($SalesAmnt*$SalesTax)/100; 
                    		
                    	        //$PurchaseVatAmnt = ($PurchaseAmnt*$PurchaseTax)/100; 

                    		$SalesVAmnt = ($SalesAmnt*$SalesTax)/100; 

                    		$SalesVatAmnt = GetConvertedAmount($SoConversionRate, $SalesVAmnt);
                    		 
                    	        $PurchaseVAmnt = ($PurchaseAmnt*$PurchaseTax)/100; 
				$PurchaseVatAmnt = GetConvertedAmount($PoConversionRate, $PurchaseVAmnt);      	              


				$TotalsalesVatAmnt ='';
            			$SalesunitvatAmnt ='';	
				$TotalpurchaseVatAmnt ='';
                    		$PurchaseunitvatAmnt ='';
	
                    		if($SalesVatAmnt > 0){     
                    			 $SalesunitvatAmnt =$SalesVatAmnt;               		 
                    			 $TotalsalesVatAmnt = $SalesunitvatAmnt  ; 
                    			 $Totalso = ($TotalsalesVatAmnt*$SalesQty);
                    			  $TotalsoAmnt +=$Totalso;

                    		} 
                    		

                    		if($PurchaseVatAmnt > 0){
                    			$PurchaseunitvatAmnt = $PurchaseVatAmnt;  
                    			 $TotalpurchaseVatAmnt = $PurchaseunitvatAmnt ; 
                    			 $Totalpo = ($TotalpurchaseVatAmnt*$SalesQty);
                    			 $TotalpoAmnt +=$Totalpo ;

                    		}
                    		
                    		 $CalculateAmnt =  ($TotalsalesVatAmnt - $TotalpurchaseVatAmnt) *$SalesQty ;      		 
                    		 $TotalCollection +=$CalculateAmnt;
                    		 $TotalOtherCollection =$TotalsoAmnt - $TotalpoAmnt ;
                    		
 
                    	if(!empty($SalesunitvatAmnt)){
				$SalesunitvatAmnt = number_format($SalesunitvatAmnt,2);
			} 

			if(!empty($PurchaseunitvatAmnt)){
				$PurchaseunitvatAmnt = number_format($PurchaseunitvatAmnt,2);
			} 

			if(!empty($CalculateAmnt)){
				$CalculateAmnt = number_format($CalculateAmnt,2);
			} 	 
		
			$content .='<tr class="'.$bgclass.'">	
			<td>'.$Sku.'</td>	
			<td>'.$values['SalesInvoice'].'</td>	
			<td>'.$values['PurchaseInvoice'].'</td>			
			<td align="right">'.$SalesunitvatAmnt.'</td>
			<td align="right">'.$PurchaseunitvatAmnt.'</td>
			<td align="center">'.$SalesQty.'</td>
			<td align="right">'.$CalculateAmnt. '</td>
					 
			</tr>';
			
  	 	}  

		$content .= '<tr class="oddbg">							 
			<td height="20" colspan="6" align="right"><b>Total VAT Collection  : </b></td>			
			<td align="right"> <b>'.number_format($TotalCollection,2).'</b></td>					 
		</tr>';

	}else{
		$content .= '<tr align="center" >
		<td  colspan="7" class="no_record">'.NO_RECORD.'</td>
		</tr>';
	} 
		
		
	  
	$content .= '</table>';
	
		 
	if(!empty($ExportFile)){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$ExportFile);
		echo $content;exit;
	}else{
	
	
		 echo $content;
	}


?>

