<? $bgcolor="#FFFFFF"; ?>	
<table width="100%" id="myTable" class="order-list"  bgcolor="<?=$bgcolor?>" cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" width="15%"  >Invoice/GL #</td>
               <td width="12%"  class="heading" >Payment Date</td>
		<td width="10%" class="heading">Paid To</td>
		<td width="10%" class="heading">Payment Method</td>
		
		<td width="10%" class="heading">Reference No.</td>
		<td width="16%" class="heading">Comment</td>
		<td width="8%" class="heading" align="right">Amount (<?=$Config['Currency']?>)</td>
    </tr>

	<?php 
	$TotalAmount = 0;
	if(count($arryPaymentInvoice) > 0)
	{
		foreach($arryPaymentInvoice as $value) {
                   
                     /*if(!empty($value['CheckBankName'])){
                        
                        $CheckBankName = ' - ('.$value['CheckBankName'].'-'.$value['CheckFormat'].')';
                    }else{
                         $CheckBankName = '';
                    }*/
                    
		    if($value['Method']=='Check' && !empty($value['CheckNumber'])){
                        
                        $CheckNumber = ' - '.$value['CheckNumber'];
                    }else{
                         $CheckNumber = '';
                    }

		


                    ?>
		 <tr bgcolor="#fff">
			<td >

					<? 

//echo $value["TransactionID"];
					 
					if(!empty($value["InvoiceID"])){
						echo $value["InvoiceID"]; 
					}else if(!empty($value["GLID"])){ 
						echo $value["AccountNameNumber"];
					} ?>

</td>
                       <td><?=date($Config['DateFormat'], strtotime($value['PaymentDate']));	?></td>
			<td><?=$value['AccountName']?></td>
			<td><?=$value['Method']?><?=$CheckNumber;?></td>
			
			<td><?=$value['ReferenceNo']?></td>
			<td><?=$value['Comment']?></td>
			<td align="right"><strong><?= number_format($value['DebitAmnt'],2); ?></strong></td>
    </tr>
	<?php 
		$TotalAmount += $value["DebitAmnt"];

		if($value["TransactionID"]>0){
			 $arryPaymentGL = $objBankAccount->GetGLPaymentByTransaction($value["TransactionID"],$CustID);


			 foreach($arryPaymentGL as $value2) {
				$DebitAmnt = $value2['DebitAmnt'];
				if($value2['NegativeFlag']==1){
					$DebitAmnt = -$DebitAmnt;
				}

				echo '<tr bgcolor="#fff">
					<td>'.$value2["AccountNameNumber"].'</td>
					<td>'.date($Config['DateFormat'], strtotime($value2['PaymentDate'])).'</td>
			<td> </td>
			<td>'.$value2['Method'].'</td>
			
			<td></td>
			<td></td>
			<td align="right"><strong>'.number_format($DebitAmnt,2).'</strong></td>
				</tr>';
				
				$TotalAmount += $DebitAmnt;
			 }
		}


		

		
	} ?>
<?php } else {?>
 <tr bgcolor="<?=$bgcolor?>">
        <td colspan="8" align="center" class="redmsg"> Payment details not found. </td>
    </tr>
<?php }?>
	 
     <tr bgcolor="<?=$bgcolor?>">
        <td colspan="8" align="right" style="padding-top: 10px;">
		<?	
		$TotalAmount = number_format($TotalAmount,2);
		echo '<b>';
		echo 'Total Received Amount: '.$TotalAmount;
		echo '</b>';
		 
			/*if($TotalQtyReceived == $TotalQtyOrdered){
				echo '<div class=redmsg style="float:left">'.ALL_INVOICE_ITEM.'</div>';
			}*/

		?>

        </td>
    </tr>
</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
