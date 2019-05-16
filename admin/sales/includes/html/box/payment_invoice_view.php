<? $bgcolor="#FFFFFF"; ?>	
<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" width="5%" align="center">InvoiceID</td>
		<td width="5%" class="heading" align="center">Cust Code</td>
		<td width="8%" class="heading" align="center">Payment Method</td>
		<td width="5%"  class="heading" align="center">Payment Date</td>
		<td width="10%" class="heading">Reference No.</td>
		<td width="20%" class="heading">Comment</td>
		<td width="5%" class="heading" align="center">Paid Amount </td>
    </tr>

	<?php 
	$TotalAmount = 0;
	if(count($arryPaymentInvoice) > 0)
	{
		foreach($arryPaymentInvoice as $value) { ?>
		 <tr bgcolor="<?=$bgcolor?>">
			<td align="center"><?=$value['InvoiceID']?></td>
			<td align="center"><?=$value['CustCode']?></td>
			<td align="center"><?=$value['PaidMethod']?></td>
			<td align="center"><?=$value['PaidDate']?></td>
			<td><?=$value['PaidReferenceNo']?></td>
			<td><?=$value['PaidComment']?></td>
			<td align="right"><?=$value['PaidAmount']?></td>
    </tr>
	<?php 
		$TotalAmount += $value["PaidAmount"];

		
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
