<?
 
$content = '<table '.$table_bg.'>
	<tr align="left"  >
		<td width="7%" class="head1">Invoice#</td>
		<td width="9%" class="head1">Invoice Date</td>
		<td width="10%" class="head1">Invoice Amount</td>
		<td width="9%" class="head1">Invoice Status</td>
		<td width="10%" class="head1"  >Payment Term</td>
		<td  class="head1">Transaction Date</td>
		<td width="12%" class="head1">Payment Provider</td>	
		<td width="9%" class="head1">Transaction ID</td>		
		<td width="13%" class="head1" align="right">Transaction Amount</td>
		<td width="8%" class="head1" align="right">Provider Fee</td>	 
	</tr>';

	if($num>0){
		 
		$Line=0;
		 
		foreach($arrySale as $key=>$values){		 
			 
			$Line++;
			 
			$InvoicePaid = $values['InvoicePaid'];
			if($InvoicePaid == 'Paid') {
				$StatusCls = 'green';
			}else{
				$StatusCls = 'red';
			}
			if($InvoicePaid=='Unpaid' && $values['PaymentTerm']=='Credit Card' && ($values['OrderPaid']==1 || $values['OrderPaid']==3)){
				$StatusCls = 'green';
				$InvoicePaid = 'Credit Card';
			}
			if($values['TransactionType'] == 'Charge') {
				$TrTypeCls = 'green';
			}else{
				$TrTypeCls = 'red';
			}

			//if(empty($values['NoUse'])){

				$content .='<tr>	
				<td><strong>'.$values['InvoiceID'].'</strong></td>	
				<td>'.date($Config['DateFormat'], strtotime($values['InvoiceDate'])).'</td>				
				<td>'.number_format($values['TotalInvoiceAmount'],2).' '.$values['CustomerCurrency'].'</td>
				<td class="' . $StatusCls . '">'.$InvoicePaid.'</td>
				<td>'.$values['PaymentTerm'].'</td>	';
			
				if(!empty($values['TransactionID'])){
					$content .= '<td>'.date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values['TransactionDate'])).'</td>
					<td>'.$values['ProviderName'].' <span class="' . $TrTypeCls . '"> ['.$values['TransactionType'].']</span></td>			
					<td>'.$values['TransactionID'].'</td>
					<td align="right">'.number_format($values['TransactionAmount'],2).' '.$values['TransactionCurrency'].'</td>	
					<td align="right">'.number_format($values['TransactionFee'],2).' '.$values['TransactionCurrency'].'</td>';
				}else{
					$content .= '<td  colspan="7">&nbsp;</td>';
				}
			 
				$content .=  '</tr>';
			//}
			 

  	 	}  
		 
		 
		 $content .= '<tr align="left" >
		<td  colspan="10" id="td_pager"> Total Record(s) : &nbsp;'.$num;

		if (empty($ExportFile) && count($arrySale) > 0) { 
			 $content .= '&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; '. $pagerLink;
		}

		$content .= '</td></tr>';
		 

	}else{
		$content .= '<tr align="center" >
		<td  colspan="10" class="no_record">'.NO_RECORD.'</td>
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

