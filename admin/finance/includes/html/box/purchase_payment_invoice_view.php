<? $bgcolor="#FFFFFF"; ?>  	
<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" width="5%" align="center">InvoiceID</td>
		<td width="10%" class="heading">Paid From</td>
		<td width="10%" class="heading">Payment Method</td>
		<td width="8%"  class="heading" align="center">Payment Date</td>
		<td width="10%" class="heading">Reference No.</td>
		<td width="16%" class="heading">Comment</td>
		<td width="8%" class="heading" align="right">Amount (<?=$Config['Currency']?>)</td>
    </tr>

	<?php 
//echo '<pre>';print_r($arryPaymentInvoice);exit;
	$TotalAmount = 0;
	if(count($arryPaymentInvoice) > 0)
	{
		foreach($arryPaymentInvoice as $value) {
                    
                    if(!empty($value['CheckBankName'])){
                        
                        $CheckBankName = '<br>['.$value['CheckBankName'].' - '.$value['CheckNumber'].']';
                    }else{
                         $CheckBankName = '';
                    }
                    
		$Amount = 0;
		if($value['CreditAmnt']>0){
			$Amount = $value['CreditAmnt'];
		}else if($value['DebitAmnt']>0){
			$Amount = $value['DebitAmnt'];
		}

                    ?>
		 <tr bgcolor="<?=$bgcolor?>">
			<td align="center"><?=$value['InvoiceID']?></td>
			<td><?=$value['AccountName']?> [<?=$value['AccountNumber']?>]</td>
			<td><?=$value['Method']?><?=$CheckBankName;?></td>
			<td align="center"><?=date($Config['DateFormat'], strtotime($value['PaymentDate']));	?></td>
			<td><?=$value['ReferenceNo']?></td>
			<td><?=$value['Comment']?></td>
			<td align="right"><strong><?=number_format($Amount,2); ?></strong></td>
    </tr>
	<?php 
		$TotalAmount += $Amount;

		
	} ?>
<?php } else {?>
 <tr bgcolor="<?=$bgcolor?>">
        <td colspan="7" align="center" class="redmsg"> Payment details not found. </td>
    </tr>
<?php }?>
	 
     <tr bgcolor="<?=$bgcolor?>">
        <td colspan="7" align="right" style="padding-top: 10px;">
		<?	
		$TotalAmount = number_format($TotalAmount,2);
		echo '<b>';
		echo 'Total Paid Amount: '.$TotalAmount;
		echo '</b>';
		 
			/*if($TotalQtyReceived == $TotalQtyOrdered){
				echo '<div class=redmsg style="float:left">'.ALL_INVOICE_ITEM.'</div>';
			}*/

		?>

        </td>
    </tr>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
