<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<?php //if(!empty($_REQUEST['view']) && $paidAmnt != $InvoiceAmount){?>
	<!--<a class="fancybox add" href="#payInvoice_div" style="float: right;">Pay Vendor</a>-->
	<?php //}?>
	<div class="had">Payment History</div>
	 
  <?

}	



if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


	#include("includes/html/box/invoice_view.php");

?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<!--<tr>
	<td colspan="2" align="left" class="head">Payment History</td>
</tr>-->
<tr>
	<td align="left" colspan="2">
	<? 	include("includes/html/box/purchase_payment_invoice_view.php");?>
	</td>
</tr>
</table>
<br>
<tr>
    <td  align="center" valign="top" >
	
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Invoice Information</td>
</tr>
 <tr>
        <td  align="right" class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["InvoiceID"])?></B></td>
      </tr>
	 <tr>
        <td  align="right" class="blackbold">Invoice Date  : </td>
        <td   align="left" >
 		<?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
       <tr>
        <td  align="right" class="blackbold">Item Received Date  :</td>
        <td  align="left"><?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
        <tr>
                <td  align="right"   class="blackbold"> Comments  : </td>
                <td  align="left">
                         <?=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED)?>

                </td>
        </tr>

 <tr>
        <td  align="right" class="heading">Payment Details</td>
		 <td  align="right" class="heading"></td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';?>
		</td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Invoice Paid  : </td>
        <td   align="left" >
    <?=($arryPurchase[0]['InvoicePaid'] == 1)?('<span class="green">Yes</span>'):('<span class="red">No</span>')?>
           </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" >Payment Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
<tr>
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['InvPaymentMethod']))?(stripslashes($arryPurchase[0]['InvPaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

<tr>
        <td  align="right" class="blackbold">Payment Ref #  :</td>
        <td   align="left">
	<?=(!empty($arryPurchase[0]['PaymentRef']))?(stripslashes($arryPurchase[0]['PaymentRef'])):(NOT_SPECIFIED)?>
	
		</td>
</tr>

</table>
	
	
	</td>
</tr>

<tr>
	 <td  align="left"><? include("../purchasing/includes/html/box/po_order_view.php");?></td>
</tr>

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("../purchasing/includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("../purchasing/includes/html/box/po_warehouse_view.php");?></td>
		</tr>
	</table>

</td>
</tr>

<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td  align="left" class="head" ><?=RECEIVED_ITEM?>
	 <div style="float:right"><a class="fancybox hideprint fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>


	 </td>
</tr>


<tr>
	<td align="left" >
		<? 	include("../purchasing/includes/html/box/po_item_invoice.php");?>
	</td>
</tr>



</table>	
    
	
	</td>
   </tr>

  

  
</table>
	

<?php
include("includes/html/box/purchase_invoice_payment_form.php");
?>

<? } ?>


