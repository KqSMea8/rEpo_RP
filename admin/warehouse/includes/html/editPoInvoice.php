
<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Create ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_invoice_form.php");

?>



<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	 if(document.getElementById("InvoicePaid").checked == true){
		 if(!ValidateForSelect(frm.PaymentDate, "Payment Date")){
			return false;
		}
		 if(!ValidateForSelect(frm.InvPaymentMethod, "Payment Method")){
			return false;
		}
	 }	
	 
	 ShowHideLoader('1','S');
}
</script>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Invoice Information</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["InvoiceID"])?></B></td>
      </tr>
	 <tr>
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr> 
 <tr>
        <td  align="right"   class="blackbold" >Item Received Date  :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReceivedDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?($arryPurchase[0]['ReceivedDate']):($arryTime[0]); 
?>
<input id="ReceivedDate" name="ReceivedDate" readonly="" class="datebox" value="<?=$ReceivedDate?>"  type="text" > 


</td>
      </tr>

  	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="InvoiceComment" type="text" class="inputbox" id="InvoiceComment" value="<?php echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"  maxlength="100" />          
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
		<? if($arryPurchase[0]['InvoicePaid']!=1){ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" <?=($arryPurchase[0]['InvoicePaid']==1)?("checked"):("")?>> 
		<? }else{ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" style="display:none" checked> <span class="green">Yes</span>
		<? } ?>

	<input type="hidden" name="OldInvoicePaid" id="OldInvoicePaid" value="<?=$arryPurchase[0]['InvoicePaid']?>" readonly >	
           </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Payment Date :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#PaymentDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?($arryPurchase[0]['PaymentDate']):(""); 
?>
<input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$PaymentDate?>"  type="text" > 


</td>
      </tr>

<tr>
        <td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		  <select name="InvPaymentMethod" class="inputbox" id="InvPaymentMethod">
		  	<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryPurchase[0]['InvPaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>

<tr>
        <td  align="right" class="blackbold">Payment Ref #  :</td>
        <td   align="left">
	<input name="PaymentRef" type="text" class="inputbox" id="PaymentRef" value="<?php echo stripslashes($arryPurchase[0]['PaymentRef']); ?>"  maxlength="30" onKeyPress="Javascript:return isAlphaKey(event);"/>          
	
		</td>
</tr>

 <tr>
        <td  align="right" ></td>
        <td   align="left" > <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Save " ></td>
      </tr>
 

</table>

	 </td>
</tr>

<tr>
	 <td  align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>


<tr>
    <td >

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_view.php");?></td>
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
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
		<? 	include("includes/html/box/po_item_invoice.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? if($TotalQtyLeft>0){ ?>	
<!--input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "  -->
<? } ?>

<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />



</td>
   </tr>
  
</table>

 </form>


<? } ?>





