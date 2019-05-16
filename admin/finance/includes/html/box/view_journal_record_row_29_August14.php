<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td width="20%" class="heading">&nbsp;&nbsp;&nbsp;Account Name</td>
		<td width="10%" class="heading">Debit (<?=$Config['Currency']?>)</td>
		<td width="10%" class="heading">Credit (<?=$Config['Currency']?>)</td>
		<td width="20%" class="heading">Entity</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		
	?>
     <tr class='itembg'>
		<td><?=$arryJournalEntry[$Count]['AccountName']?></td>
        <td><?=$arryJournalEntry[$Count]['DebitAmnt']?></td>
        <td><?=$arryJournalEntry[$Count]['CreditAmnt']?></td>
        <td> 
<?php if(!empty($arryJournalEntry[$Count]['EntityName'])){?>
		<?=ucwords($arryJournalEntry[$Count]['EntityName'])?>&nbsp;(<?=ucfirst($arryJournalEntry[$Count]['EntityType'])?>)
<?php } else {?>
 -
<?php }?>
		
               </td>
      
       
    </tr>
	<?php } ?>

 
</tbody>
<tfoot>

	<tr class='itembg'>
	<td  align="right" height="30">	<strong>Total</strong></td>
	<td><b><?=$arryJournal[0]['TotalDebit']?></b></td>
	<td><b><?=$arryJournal[0]['TotalCredit']?></b></td>
	<td>&nbsp;</td>
    </tr>
</tfoot>
</table>
<? echo '<script>SetInnerWidth();</script>'; ?>

