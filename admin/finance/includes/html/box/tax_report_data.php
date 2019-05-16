<?
 $NewCustCode=$CustomerTotal='';

$content = '<table '.$table_bg.'>
	<tr align="left"  >';
if($_GET['rby']=='L'){
	 $content .= '<td class="head1" width="8%" >Tax Rate</td>';
}
#$content .= '<td class="head1" >Customer</td>';	

$content .= '<td width="9%" class="head1">Invoice#</td>
	<td width="12%" class="head1">Invoice Date</td>
	<td width="10%" class="head1">'.$Module.' Amount</td>
	<td width="12%" class="head1">Taxable '.$Module.'</td>		
	<td width="12%" class="head1">Nontaxable '.$Module.'</td>	
	<td width="12%" class="head1">Taxable Freight</td>		
	<td width="12%" class="head1">Nontaxable Freight</td>	
	<td class="head1" align="right" width="12%">'.$Module.' Tax Amount</td>
	</tr>';

if(is_array($arryData) && $num>0){
	$flag=true;
	$Line=0;
	$SubtotalTax = 0;
	$TotalTax = 0;
	$SubtotalSales = 0;
	$TotalSales = 0;
	$SubtotalTaxableSales = 0;
	$TotalTaxableSales = 0;
	$SubtotalNontaxableSales = 0;
	$TotalNontaxableSales = 0;
	$SubtotalTaxableFreight = 0;
	$TotalTaxableFreight = 0;
	$SubtotalNontaxableFreight = 0;
	$TotalNontaxableFreight = 0;
 
	foreach($arryData as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;
		$freightTxSet = $values['freightTxSet'];
		$taxAmnt = $values['taxAmnt'];
		$Freight = $values['Freight'];
		$ShipFreight = $values['ShipFreight']; //PrepaidAmount
		$AdjustmentAmount = (!empty($values['AdjustmentAmount']))?($values['AdjustmentAmount']):('');  
		$TDiscount = (!empty($values['TDiscount']))?($values['TDiscount']):('');    
		if($values['Module']=='Invoice'){
			$TotalInvoiceAmount = $values["TotalInvoiceAmount"];
		}else{
			$TotalInvoiceAmount = $values["TotalAmount"];
		}	
		$TaxableSalesLine = $values["TaxableSalesLine"];
		$InvoiceCurrency = $values["InvoiceCurrency"];		
		$ConversionRate=1;		
		if($InvoiceCurrency!=$Config['Currency']){
			$ConversionRate = $values['ConversionRate'];			   
		}
		/**********Tax Rate************/
		$TaxRateValue = trim(stripslashes($values['TaxRate']));
		$arrTxs = explode(":",$TaxRateValue);
		$taxPercentage = (!empty($arrTxs[2]))?($arrTxs[2]):('0');
		if(empty($arrTxs[1])) $arrTxs[1] = '';
		$TaxVale = $arrTxs[1].' : '.$taxPercentage.'%';		
		$TaxByCode = ($_GET['rby']=='L')?($TaxVale):($values['CustCode']);					 
		/*********Calculation***********/
		$SalesAmount = round(($TotalInvoiceAmount-$taxAmnt-$Freight-$ShipFreight-$AdjustmentAmount+$TDiscount),2);  //Subtotal 
 
		$TaxableSales=0;
		//if($taxAmnt>0 && $taxPercentage>0){
		if($TaxableSalesLine>0){
			$TaxableSales = $TaxableSalesLine; //round((($taxAmnt*100)/$taxPercentage),2);
		}	
		if($freightTxSet=='Yes'){
			 $TaxableFreight = $Freight;
			 $NontaxableFreight = 0;			 
		}else{
			 $TaxableFreight = 0;
			 $NontaxableFreight = $Freight;
		}
		$NontaxableSales = round(($SalesAmount - $TaxableSales),2);
		/**********Conversion & Total**************/
 	        $SalesTaxAmount = GetConvertedAmount($ConversionRate, $taxAmnt);
		$SalesAmountBS = round(GetConvertedAmount($ConversionRate, $SalesAmount),2);
		$TaxableSalesBS = round(GetConvertedAmount($ConversionRate, $TaxableSales),2);
		$NontaxableSalesBS = round(GetConvertedAmount($ConversionRate, $NontaxableSales),2);
		$TaxableFreightBS = round(GetConvertedAmount($ConversionRate, $TaxableFreight),2);
		$NontaxableFreightBS = round(GetConvertedAmount($ConversionRate, $NontaxableFreight),2);
		
		if($values['Module']=='Credit'){	
			$SalesTaxAmount = -$SalesTaxAmount;
			$SalesAmountBS = -$SalesAmountBS;
			$TaxableSalesBS = -$TaxableSalesBS;
			$NontaxableSalesBS = -$NontaxableSalesBS;
			$TaxableFreightBS = -$TaxableFreightBS;
			$NontaxableFreightBS = -$NontaxableFreightBS;
		}


		$TotalTax +=$SalesTaxAmount;
		$TotalSales +=$SalesAmountBS;
		$TotalTaxableSales +=$TaxableSalesBS;	
		$TotalNontaxableSales +=$NontaxableSalesBS;	
		$TotalTaxableFreight +=$TaxableFreightBS;	
		$TotalNontaxableFreight +=$NontaxableFreightBS;		 
       		/*************************************/
		if(!empty($ExportFile)){
			$CustomerName = stripslashes($values["CustomerName"]);
			if($_GET['rtype']=='P'){
				/******AP********/				
				if($values['Module']=='Credit'){
					$ModuleDate = $values['PostedDate'];
					$ModuleID = $values["CreditID"];
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$ModuleID = $values['InvoiceID'];
				}
				/**************/

			}else{
				/*****AR*********/
				if($values['Module']=='Credit'){
					$ModuleDate = $values['PostedDate'];
					$ModuleID = $values["CreditID"];
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$ModuleID = $values['InvoiceID'];
				}
				/**************/
				
			}
		}else{
			if($_GET['rtype']=='P'){
				/******AP********/
				$CustomerName = '<a class="fancybox fancybox.iframe" href="../suppInfo.php?view='.$values['SuppCode'].'" ><b>'.stripslashes($values["CustomerName"]).'</b></a>';
				if($values['Module']=='Credit'){
					$ModuleDate = $values['PostedDate'];
					$ModuleID = '<a class="fancybox fancybig fancybox.iframe" href="vPoCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$ModuleID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox fancybig fancybox.iframe">'.$values['InvoiceID'].'</a>';
				}
				/**************/

			}else{
				/*****AR*********/
				$CustomerName = '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" ><b>'.stripslashes($values["CustomerName"]).'</b></a>';

				if($values['Module']=='Credit'){
					$ModuleDate = $values['PostedDate'];
					$ModuleID = '<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$ModuleID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox fancybig fancybox.iframe">'.$values['InvoiceID'].'</a>';
				}
				/**************/

			}


		}

		if($_GET['rby']=='L'){
		 	$AddTd = '<td></td>';
			$CustomerNameInner = $CustomerName;
		}else{
			$AddTd = '';
			$CustomerNameInner = '';
		}
		/******************************/


	 if($NewCustCode!='' && $NewCustCode != $TaxByCode){

		if($_GET['rby']=='L'){
			$CustomerTotal = '<tr class="oddbg">
			 '.$AddTd.'	
			<td></td>		 
			<td height="30" ><b> Totals ('.$Config['Currency'].'): </b></td>
			<td><b>'.number_format($SubtotalSales,2).'</b></td>
			<td><b>'.number_format($SubtotalTaxableSales,2).'</b></td>
			<td><b>'.number_format($SubtotalNontaxableSales,2).'</b></td>
			<td><b>'.number_format($SubtotalTaxableFreight,2).'</b></td>
			<td><b>'.number_format($SubtotalNontaxableFreight,2).'</b></td>
			<td align="right" ><b>'.number_format($SubtotalTax,2).'</b></td>

			</tr>';
		}
		$content .=  $CustomerTotal;

		$SubtotalTax=0;
		$SubtotalSales=0;
		$SubtotalTaxableSales=0;
		$SubtotalNontaxableSales=0;
		$SubtotalTaxableFreight=0;
		$SubtotalNontaxableFreight=0;
	 } 

	 if($NewCustCode != $TaxByCode){ 
		if($_GET['rby']=='L'){			
			$content .= '<tr>
				<td colspan="9" height="30" class="head1" align="left">
				<b>'.$TaxVale.'</b>
				</td>			 
			</tr>';
		}
	 } 

	

  	$content .= '<tr align="left" class="'.$bgclass.'">'.$AddTd;
               
	#$content .= '<td>'.$CustomerNameInner.'</td>'; 

	if(!empty($_GET['pk'])){	
		$ModuleID = $ModuleID.' # '. $values['AccountID']. ' # '.$values['TotalAmount'];	
	}


	$content .='<td>'.$ModuleID.'</td>
		<td>'.date($Config['DateFormat'], strtotime($ModuleDate)).'</td>	
		<td>'.number_format($SalesAmountBS,2).'</td>	
		<td>'.number_format($TaxableSalesBS,2).'</td>
		<td>'.number_format($NontaxableSalesBS,2).'</td>
		<td>'. number_format($TaxableFreightBS,2). '</td>
		<td>'.number_format($NontaxableFreightBS,2). '</td>
		<td  align="right" ><b>'.number_format($SalesTaxAmount,2).'</b></td>	
		</tr>';
	 	
	 $NewCustCode = $TaxByCode;
	 $SubtotalTax +=$SalesTaxAmount;
	 $SubtotalSales +=$SalesAmountBS;
	 $SubtotalTaxableSales +=$TaxableSalesBS;
	 $SubtotalNontaxableSales +=$NontaxableSalesBS;
	 $SubtotalTaxableFreight +=$TaxableFreightBS;
	 $SubtotalNontaxableFreight +=$NontaxableFreightBS;
   } 
		
	if($_GET['rby']=='L'){
		$CustomerTotal = '<tr class="oddbg">
		 '.$AddTd.'
		<td></td>	
		<td height="30" ><b> Totals ('.$Config['Currency'].'): </b></td>
		<td><b>'.number_format($SubtotalSales,2).'</b></td>
		<td><b>'.number_format($SubtotalTaxableSales,2).'</b></td>
		<td><b>'.number_format($SubtotalNontaxableSales,2).'</b></td>
		<td><b>'.number_format($SubtotalTaxableFreight,2).'</b></td>
		<td><b>'.number_format($SubtotalNontaxableFreight,2).'</b></td>
		<td align="right" ><b>'.number_format($SubtotalTax,2).'</b></td>
		</tr>';
	}

		
		if($_GET['rby']=='L'){
			 if(empty($_GET['Tax'])){			
			 	$content .=  $CustomerTotal;
			 }
			$AddTd = '<td></td>'; 
		}else{
			 if(empty($_GET['CustCode'])){			
			 	$content .=  $CustomerTotal;
			 } 
			$AddTd = '';
		}
  
		 
	$content .= '<tr class="oddbg">	
			'.$AddTd.'
			<td></td>			 
			<td height="30"><b>Grand Total ('.$Config['Currency'].') : </b></td>
			<td> <b id="GrandTotalSalesID">'.number_format($TotalSales,2).'</b></td>
			<td> <b id="GrandTaxableSalesID">'.number_format($TotalTaxableSales,2).'</b></td>
			<td> <b>'.number_format($TotalNontaxableSales,2).'</b></td>
			<td> <b>'.number_format($TotalTaxableFreight,2).'</b></td>
			<td> <b>'.number_format($TotalNontaxableFreight,2).'</b></td>
			<td align="right" ><b>'.number_format( $TotalTax,2).'</b></td>
		</tr>';

	}else{
		$content .= '<tr align="center" >
		<td  colspan="9" class="no_record">'.NO_RECORD.'</td>
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

