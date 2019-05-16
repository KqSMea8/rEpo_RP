<a href="<?=$ThisPageName?>" class="back">Back</a>
<div class="had">Adjustment History</div>
<br>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="left" >
<div class="borderall" style="padding:5px;width:180px;">
	Invoice Number # : 

     <?php if($arryInvoice[0]['InvoiceEntry'] == "2" || $arryInvoice[0]['InvoiceEntry'] == "3"){?>
             <a href="vOtherExpense.php?view=<?=$arryInvoice[0]['ExpenseID']?>&IE=2&pop=1" class="fancybox fancybig fancybox.iframe"><strong><?=$InvoiceID?></strong> </a>
         <?php } else {?>
          <a href="vPoInvoice.php?module=Invoice&view=<?=$arryInvoice[0]['OrderID']?>&pop=1" class="fancybox fancybig fancybox.iframe"><strong><?=$InvoiceID?></strong> </a>
      <?php }?>
</div>

		</td>
      </tr>

	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table id="myTable" cellspacing="1" cellpadding="3" width="100%" align="center">
    <tr align="left"  >
	<td width="12%"  class="head1">Adjustment Date</td>
	<td width="12%" class="head1">Adjustment Amount</td>
	<td width="5%" class="head1">Currency</td>
	<td width="12%" class="head1">Vendor</td>
	<!--td width="12%" class="head1">Paid From A/C</td-->
	<td width="8%" class="head1">GL Entry Type</td>
	<td  class="head1">GL Account</td>
	

    </tr>
   
    <?php 

  if(is_array($arryAdjustment) && $num>0){
  	$flag = true;
	$Line = 0;

  	foreach($arryAdjustment as $key=>$values){
	$flag=!$flag;
	$cls=($flag)?("evenbg"):("oddbg");
	$Line++;
	
	$SuppCompany=(!empty($values['CompanyName']))?($values['CompanyName']):($values['SuppCompany']); 
	
  ?>
    <tr align="left"  class="<?=$cls?>" valign="top">
	<td ><?=date($Config['DateFormat'], strtotime($values['PaymentDate']));	?></td>
	<td><strong><?=number_format($values['AdjustmentAmount'],2)?></strong></td>
	<td><?=$values['Currency']?></td>
	<td><? 
       echo '<a class="fancybox supp fancybox.iframe" href="suppInfo.php?view='.$values['PaidTo'].'">'.stripslashes($SuppCompany).'</a>';  
	?></td>
        <!--td><?=$values['PaidFromAC']?> </td-->
	<td><?=$values['GlEntryType']?></td>
	<td>
<?

if($values['GlEntryType']=='Single'){

	if(!empty($values['ExpenseTypeID'])){
		$arryBankAccount = $objBankAccount->getBankAccountById($values['ExpenseTypeID']);
		echo $arryBankAccount[0]['AccountName'].' ['.$arryBankAccount[0]['AccountNumber'].']';
	}

}else if($values['GlEntryType']=='Multiple'){
	
	$arryMultiAccount=$objBankAccount->getMultiAdjustment($values['AdjID']);
	if(sizeof($arryMultiAccount)>0){
		echo '<table width="100%" id="myTable"  class="order-list"   cellpadding="0" cellspacing="1">
			<tr ><td width="50%" class="heading">Account</td><td width="20%" class="heading">Amount</td>
			<td class="heading">Notes</td></tr>';
		foreach($arryMultiAccount as $keym=>$valuesm){
			echo '<tr class="itembg">';
			echo '<td>'.$valuesm['AccountNameNumber'].'</td>';
			echo '<td>'.number_format($valuesm['Amount'],2).'</td>';
			echo '<td>'.stripslashes($valuesm['Notes']).'</td>';
			echo '</tr>';
		} 

		echo '</table>';
	}

}


?>

</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  


<? if($num>$RecordsPerPage){ ?>
<tr >  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAdjustment)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
<? } ?>

  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
	$(".fancybig").fancybox({
		'width'  : 900
	 });


});

</script>

<? echo '<script>SetInnerWidth();</script>'; ?>
