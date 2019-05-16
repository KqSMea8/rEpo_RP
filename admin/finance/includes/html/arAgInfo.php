<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<div class="had">AR Aging Report  <span> &raquo; </span> Invoices</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td  valign="top">
	<strong>[ Customer : <?=stripslashes($arryCustomer[0]['FullName'])?> ]</strong>
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
		<td width="10%"  class="head1" >SO/Reference #</td>
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

 <a class="fancybox po fancybox.iframe" href="vInvoice.php?view=<?=$values['OrderID']?>&IE=<?=$values['InvoiceEntry']?>&pop=1" ><?=$values["InvoiceID"]?></a>




</td>
      <td height="20">
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>
	   
	   </td>
   <td align="center">
            <?php if ($values['InvoiceEntry'] == "1") { ?>
                <a href="vInvoice.php?pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry']; ?>" class="fancybox po fancybox.iframe"><?= $values['SaleID'] ?></a>
<?php } else { ?>
                <a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?= $values['SaleID'] ?>" class="fancybox po fancybox.iframe"><?= $values['SaleID'] ?></a>
<?php } ?>
        </td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
    
       <td align="center"><?= $values['TotalInvoiceAmount'] ?></td>
      <td align="center"><?= $values['CustomerCurrency'] ?></td>


   <td align="center">
                                            <?
                                            if ($values['InvoicePaid'] == 'Paid') {
                                                $StatusCls = 'green';
                                            } else {
                                                $StatusCls = 'red';
                                            }

                                            echo '<span class="' . $StatusCls . '">' . $values['InvoicePaid'] . '</span>';
                                            ?>

                                        </td>
    
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
