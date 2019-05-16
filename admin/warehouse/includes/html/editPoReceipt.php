
<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Create ".$ModuleName); ?>
		
		</span>
</div>



<div class="message" align="center"><? if(!empty($_SESSION['mess_Receipt'])) {echo $_SESSION['mess_Receipt']; unset($_SESSION['mess_Receipt']); }?></div>




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
	 ShowHideLoader('1','S');
}

$(document).ready(function(){
	$('#GenrateInvoice').change(function(){
		if(this.checked){
			$('#inv').fadeIn('slow');
			$('#invdate').fadeIn('slow');
		}else{
			$('#inv').fadeOut('slow');
			$('#invdate').fadeOut('slow');
		}

	});

	$("#GenrateInvoice").trigger("change");
});
</script>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Receipt Information</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="20%"> Receipt # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["ReceiptID"])?></B></td>
      
	 
        <td  align="right"   class="blackbold" >Item Received Date  :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReceivedDate55').datepicker(
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
<input id="ReceivedDate" name="ReceivedDate" readonly="" class="datebox disabled" value="<?=$ReceivedDate?>"  type="text" > 


</td>
      </tr>

<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>

<tr>
<? if($arryPurchase[0]['GenrateInvoice']==1 && $arryPurchase[0]['ReceiptStatus']=="Completed" ){?>
 <td  align="right"   class="blackbold" >  Invoice Number #  : </td>
<td   align="left" ><B><?=stripslashes($arryPurchase[0]["RefInvoiceID"])?></B></td>
<? }else{?>

        <td  align="right"   class="blackbold" > Generate Invoice  : </td>
        <td   align="left" >

		<input type="checkbox" name="GenrateInvoice" id="GenrateInvoice"  value="1" <?=($arryPurchase[0]['GenrateInvoice']==1)?("checked"):("")?>> 
   
           </td>
      
<? } ?>
</tr>

<? if($arryPurchase[0]['ReceiptStatus']!="Completed" || $arryPurchase[0]['GenrateInvoice']!=1 ){?>
<tr id="inv" style="display:none">
        <td  align="right"   class="blackbold" > Invoice Number #   : </td>
        <td   align="left" >		 
    <input name="RefInvoiceID" type="text" class="datebox" id="RefInvoiceID" value="<?=$NextInvModuleID?>"  maxlength="20"  onKeyPress="Javascript:return isAlphaKey(event);" oncontextmenu="return false" onBlur="Javascript:RemoveSpecialChars(this);" />
           </td>
      </tr>

 <tr id="invdate" style="display:none">
        <td  align="right"   class="blackbold" > Invoice Date   : </td>
        <td   align="left" >		 



<script type="text/javascript">
$(function() {
	$('#RefInvoiceDate').datepicker(
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
 <? $arryTime = explode(" ",$Config['TodayDate']); ?>
<input id="RefInvoiceDate" name="RefInvoiceDate" readonly="" class="datebox" value="<?=$arryTime[0]?>"  type="text" >

           </td>
      </tr>

<? } ?>

<tr>
        <td  align="right"   class="blackbold" > Receipt Status  : </td>
        <td   align="left" >

<? if($arryPurchase[0]['ReceiptStatus']=="Completed" ){

/*echo '<span class="greenmsg">'.$arryPurchase[0]['ReceiptStatus'].'</span>
<input id="ReceiptStatus" name="ReceiptStatus" readonly=""   value="'.$arryPurchase[0]['ReceiptStatus'].'"  type="hidden" >
';*/
echo '<span class="greenmsg">'.$arryPurchase[0]['ReceiptStatus'].'</span>';

}else{

?>
						<select name="ReceiptStatus" id="ReceiptStatus" class="inputbox">
							<option value="Parked" <?=($arryPurchase[0]['ReceiptStatus']=="Parked")?("selected"):("")?>>Parked</option>
							<option value="Completed" <?=($arryPurchase[0]['ReceiptStatus']=="Completed")?("selected"):("")?>>Completed</option>
						</select>
    <? }?>
           </td>
      </tr>
  	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="InvoiceComment" type="text" class="inputbox" id="InvoiceComment" value="<?php echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"  maxlength="100" />          
		</td>
	</tr> 

<? if( $arryPurchase[0]['ReceiptStatus']!="Completed" || $arryPurchase[0]['GenrateInvoice']!=1){?>
 <tr>
        <td  align="right" ></td>
        <td   align="left" > <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Save " >
        <input type="hidden" name="EdiRefInvoiceID" id="EdiRefInvoiceID" value="<?=$arryPurchase[0]['EdiRefInvoiceID']?>" readonly />
        
        </td>
      </tr>
 <? }?>

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
		<? 	include("includes/html/box/po_item_Receipt.php");?>
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





