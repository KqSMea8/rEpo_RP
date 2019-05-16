<? 
$content = '<table '.$table_bg.'>
	<tr align="left"  >';
if($_GET['rby']=='L'){
	 $content .= '<td class="head1" width="8%" >Tax Rate</td>';
}
 

$content .= '<td width="9%" class="head1">Customer Code</td>	
		<td width="10%" class="head1">Customer Name</td>
		<td width="9%" class="head1" align="right">Sales ['.$Config['Currency'].']</td>	
	</tr>';
/*
<td width="9%" class="head1">SKU#</td>	
		<td   class="head1">Item Description</td>		
		<td width="9%" class="head1">Invoice#</td>
		 <td width="11%" class="head1">Invoice Date</td>
		<td width="10%" class="head1">VAT</td>
		<td width="11%" class="head1">Tax Rate</td>
		<td width="8%" class="head1">Amount</td>
		<td width="9%" class="head1" align="right">Sales Tax ['.$Config['Currency'].']</td>
*/


if(is_array($arryData) && $num>0){
	$flag=true;
	$Line=0;
	$TotalSales = 0;
	foreach($arryData as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;
			
		$ConversionRate=1;		
		if($values["CustomerCurrency"]!= $Config['Currency']){
			$ConversionRate = $values['ConversionRate'];			   
		}
		$taxAmnt = $values['taxAmnt'];
		$amount = $values['amount'];
		/**********Tax Rate************/
		$TaxRateValue = trim(stripslashes($values['TaxRate']));
		$arrTxs = explode(":",$TaxRateValue);
		$taxPercentage = $arrTxs[2];
		$TaxVale = $arrTxs[1].' : '.$taxPercentage.'%';				 					 
		/*********Calculation***********/
		$Tax=0;
	 	if($taxAmnt>0 && $taxPercentage>0){		 
			$Tax = round((($amount*$taxPercentage)/100),2);
		}
		



		$SalesTaxAmount = GetConvertedAmount($ConversionRate, $taxAmnt);
		$LineAmount = GetConvertedAmount($ConversionRate, $amount);
		$LineTax = GetConvertedAmount($ConversionRate, $Tax);
       		/*************************************/
		if(!empty($ExportFile)){
			$CustomerName = stripslashes($values["CustomerName"]);
			$CustomerCode = stripslashes($values["CustCode"]);
			if($_GET['rtype']=='P'){
				/******AP********				
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
					$LineAmount = -$LineAmount;
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$ModuleID = $values['InvoiceID'];
				}
				/**************/
				
			}
		}else{
			if($_GET['rtype']=='P'){
				/******AP********/
				#$CustomerCode = '<a class="fancybox fancybox.iframe" href="../suppInfo.php?view='.$values['SuppCode'].'" ><b>'.stripslashes($values["CustomerName"]).'</b></a>';
				
				/**************/

			}else{
				/*****AR*********/
				$CustomerCode = '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" ><b>'.stripslashes($values["CustCode"]).'</b></a>';				
				
				if($values['Module']=='Credit'){
					$ModuleDate = $values['PostedDate'];
					$ModuleID = '<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
					$LineAmount = -$LineAmount;
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$ModuleID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox fancybig fancybox.iframe">'.$values['InvoiceID'].'</a>';
				}

			}
		}
			
		/******************************/	

  	$content .= '<tr align="left" class="'.$bgclass.'">';               

	if(!empty($_GET['pk'])){	
		$ModuleID = $ModuleID.' # '. $values['AccountID']. ' # '.$values['TotalAmount'];	
	}

 	/*
	<td>'.stripslashes($values['sku']).'</td>
		<td>'.stripslashes($values['description']).'</td>					
		 <td>'.$ModuleID.'</td>
		<td>'.date($Config['DateFormat'], strtotime($ModuleDate)).'</td>	
		<td>'.$values['VAT'].'</td>
		<td>'.$TaxVale.'</td>	
		<td>'.number_format($amount,2).' '.$values['CustomerCurrency'].'</td>	
		<td align="right"><b>'.number_format($LineTax,2).'</b></td>
	*/
	 
	$content .='<td>'.$CustomerCode.'</td>		
		<td>'.$values['CustomerName'].'</td>
		<td align="right">'.number_format($LineAmount,2).'</td>	
		</tr>';	 
	
	$TotalSales += $LineAmount;
   } 

	$content .='<td> </td>		
		<td></td>
		<td align="right"><strong>Total Sales : '.number_format($TotalSales,2).'</strong></td>	
		</tr>';	 
		

	}else{
		$content .= '<tr align="center" >
		<td  colspan="12" class="no_record">'.NO_RECORD.'</td>
		</tr>';
	} 


	if(empty($ExportFile)){

			if($num>0){ $PageLink = '&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp;  '.$pagerLink; 
				$content .= '<tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;'.$num.'	'.$PageLink.'	
				</td>
				</tr>';
			}
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

