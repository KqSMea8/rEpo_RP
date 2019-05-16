<?

$TransactionID = $objBankAccount->GetTransferTransactionID($OrderID);
if($TransactionID>0){
	$arryTransaction = $objTransaction->GetTransactionDataByID('AP',$TransactionID ,'');
?>
<br>
<div class="had2">Vendor Transfer Details</div>
<table width="100%" id="myTable" class="order-list-gl"  cellpadding="0" cellspacing="1">
<thead>
   <tr align="left">  
				
		<td width="5%"  class="head1">Type</td>
		<td width="15%"  class="head1">Vendor</td>
		 
		<td width="11%"  class="head1">Invoice Date</td>   
		<td width="11%" class="head1">Invoice # </td>					
		<td width="11%" class="head1">Reference # </td>
		<td   class="head1">GL Account</td>	
		<td width="10%" class="head1">Credit Memo #</td>				
		 <td width="10%" class="head1">Description</td>	
		 
		<!--td width="10%" class="head1" align="right">Amount </td-->					
		<td  class="head1" align="right" width="12%"> Amount  (
<?php echo $Config['Currency'];?>)</td>
	</tr>
</thead>
<tbody>
	<?php

  				
			$sumPayAmount=0;
			$Line=0;
			$flag='';
			foreach($arryTransaction as $key=>$values){
				 
				$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
				$sumPayAmount += $values['Amount'];
				$Line++;
				
				 

				if(!empty($values['VendorName'])){
					$VendorName = stripslashes($values['VendorName']);
				}else{
					$VendorName = '';
				}

				$InvoiceDate ='';$InvoiceID='';	$InvoiceDate='';$CredetID='';

				if($values['PaymentType']=='Invoice'){				 
					$InvoiceDate = $values['PostedDate'];
					$InvoiceID = $values['InvoiceID'];

				}else if($values['PaymentType']=='Contra Invoice'){					 
					$InvoiceDate = $values['InvoiceDate'];
					$InvoiceID = $values['InvoiceID'];
					
				}else if($values['PaymentType']=='Credit'){					 
					$CredetID = $values['CreditID'];
					$InvoiceDate = $values['PostedDate'];
				}

				echo '<tr align="left" bgcolor="'.$bgcolor.'"> 
					         
				         <td>'.$values['PaymentType'].'</td>
					  <td>'.$VendorName.'</td>
					 
				         <td>'.$InvoiceDate.'</td>
				         <td>'.$InvoiceID.'</td>
				         <td>'.$values['PurchaseID'].'</td>
					   <td>'.$values['AccountNameNumber'].'</td>	
					 <td>'.$CredetID.'</td>		
					  <td>'.stripslashes($values['Description']).'</td>	
					 
					<!--td align="right">'.number_format($values['OriginalAmount'],2).' '.$values['ModuleCurrency'].'</td-->	
					<td align="right">'.number_format($values['Amount'],2).'</td>		      
				        
				 </tr>';
			}

			$sumPayAmount = round($sumPayAmount,2);			
			if($sumPayAmount=='-0'){
				$sumPayAmount = '0';
			}

			echo '<tr align="left" bgcolor="'.$bgcolor.'" > 						
					 <td colspan="8" align="right"><b>Total Amount :</b> </td>	
					<td align="right"><b>'.number_format($sumPayAmount,2).'</b></td>		      
				        
				 </tr>';

		 
			
?>




 
</tbody>

</table>

<? } ?>
