<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<div class="had">AP Aging Report  <span> &raquo; </span> Invoices</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td  valign="top">
	<strong>[ Vendor : <?=stripslashes($arrySupplier[0]['CompanyName'])?> ]</strong>
	</td>
	</tr>
	<tr>
	  <td  valign="top" height="500">
	

<form action="" method="post" name="form1">

<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td width="13%"  class="head1" >Invoice Number</td>
		<td width="10%" class="head1" >Invoice Date</td>
		<td width="10%"  class="head1" >PO Number</td>
		<td width="10%" class="head1" >Order Date</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="8%" align="center" class="head1" >Currency</td>
		<td width="10%"  align="center" class="head1" >Invoice Paid</td>
    </tr>
   
    <?php 
  if(is_array($arryInvoice) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left">
       <td>

<?php if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { ?>
	<a href="vOtherExpense.php?pop=1&amp;Flag=<?= $Flag; ?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe"><?=$values["InvoiceID"]?></a>
<?php } else { ?>
<a class="fancybox fancybig fancybox.iframe" href="vPoInvoice.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["InvoiceID"]?></a>
<?php } ?>


</td>
      <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
       <td><a class="fancybox fancybig fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
    
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


    <td align="center"><? 
		 if($values['InvoicePaid'] ==1){
			  $Paid = 'Paid';  $PaidCls = 'green';
		 }elseif($values['InvoicePaid'] == 2){
			  $Paid = 'Partially Paid';  $PaidCls = 'red';
		 }else{
			  $Paid = 'Unpaid';  $PaidCls = 'red';
		 }

		echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
		
	 ?></td>
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_INVOICE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>     </td>
  </tr>
  </table>


  </div> 

  
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>

<? } ?>
