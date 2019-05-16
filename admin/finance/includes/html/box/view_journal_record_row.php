<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td width="25%" class="heading">&nbsp;&nbsp;&nbsp;Account Name</td>
		<td width="10%" class="heading bank_currency_td" <?=$ShowForBT?>>Bank Currency</td>
		<td width="12%" class="heading">Debit </td>
		<td width="12%" class="heading">Credit</td>
		<td  class="heading conversion_td" <?=$ShowForBT?>>Conversion Rate</td>
		<td width="20%" class="heading">Comment</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
 
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		
	?>
     <tr class='itembg'>
		<td>&nbsp;&nbsp;&nbsp;<?=ucwords(stripslashes($arryJournalEntry[$Count]['AccountName']))?>

<? if(substr_count($arryJournalEntry[$Count]['AccountName'],"[") <= 0 ){ ?>
[<?=$arryJournalEntry[$Count]['AccountNumber']?>]
<? } ?>



</td>

	<td  class="bank_currency_td" <?=$ShowForBT?>>
	 	<? echo $arryJournalEntry[$Count]['BankCurrency']; ?>
	</td>

           <td><? if($arryJournalEntry[$Count]['DebitAmnt']>0) echo number_format($arryJournalEntry[$Count]['DebitAmnt'],2); ?></td>
        <td><? if($arryJournalEntry[$Count]['CreditAmnt']>0) echo number_format($arryJournalEntry[$Count]['CreditAmnt'],2); ?></td>
	
		
 	<td  <?=$ShowForBT?> >
	 	<? 
if($arryJournalEntry[$Count]['BankCurrencyRate']>0 && $arryJournalEntry[$Count]['BankCurrencyRate']!='1'){
	echo $arryJournalEntry[$Count]['BankCurrencyRate']; 

	if($Count=='0' && $arryJournalEntry[0]['BankCurrency']!=$arryJournalEntry[1]['BankCurrency'] && $arryJournalEntry[0]['BankCurrency']!=$Config['Currency'] && $arryJournalEntry[1]['BankCurrency']!=$Config['Currency']){
		$BaseCurrencyValue = GetConvertedAmount($arryJournalEntry[0]['BankCurrencyRate'],$arryJournalEntry[0]['CreditAmnt']);  
     		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span  class="red" > '.$BaseCurrencyValue.'  '.$Config['Currency'].'</span>';
	}
}

?>

	
	</td>

  	<td><?=stripslashes($arryJournalEntry[$Count]['Comment'])?>


 
</td>
      
       
    </tr>
	<?php } ?>

 
</tbody>
<tfoot>

    <? if(empty($BankTransfer)){ ?>
	<tr class='itembg'>
	<td  align="right" height="30">	<strong>Total</strong></td>
	<td><b><?=number_format($arryJournal[0]['TotalDebit'],2)?></b></td>
	<td><b><?=number_format($arryJournal[0]['TotalCredit'],2)?></b></td>
	<td>&nbsp;</td>
    </tr>
	<? } ?>
</tfoot>
</table>
<? echo '<script>SetInnerWidth();</script>'; ?>

