<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
</div>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
#include("includes/html/box/po_recieve.php");

?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0;
	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleVal = Trim(document.getElementById("PoInvoiceID")).value;

	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById("PoInvoiceID"), "Invoice Number",3,20)){
			return false;
		}
	}
	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("item_id"+i) != null){
			qty_left = 0; qty = document.getElementById("qty"+i).value;
			qty_left = document.getElementById("ordered_qty"+i).value - document.getElementById("total_received"+i).value;

			if(qty_left > 0){

				if(!ValidateOptNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}			
				if(qty > qty_left){
					alert("Qauntity must be be less than or equal to "+qty_left+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}else{
					total_qty += +$("#qty"+i).val();
				}
				total_qty_left += +qty_left;
			}


		}
	}


	
	if(total_qty_left<=0){
		alert("All qauntities has been received this order.");
		return false;
	}else if(total_qty<=0){
		alert("Please enter qauntity received for any item.");
		return false;
	}





	if(ModuleVal!=''){
		var Url = "isRecordExists.php?PoInvoiceID="+escape(ModuleVal)+"&editID=";
		SendExistRequest(Url,"PoInvoiceID", "Invoice Number");
		return false;	
	}else{
		ShowHideLoader('1','S');
		return true;	
	}
	
		
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
        <td   align="left" >

	<input name="PoInvoiceID" type="text" class="datebox" id="PoInvoiceID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','PoInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>

</td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
<? 	
$arryTime = explode(" ",$Config['TodayDate']);
echo date($Config['DateFormat'], strtotime($arryTime[0]));
?>

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
 <!--tr>
        <td  align="right"   class="blackbold" > Invoice Paid  : </td>
        <td   align="left" >
		<input type="checkbox" name="InvoicePaid" value="1" <?=($arryPurchase[0]['InvoicePaid']==1)?("checked"):("")?>> 
    
           </td>
      </tr-->
</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>
<tr>
    <td>

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
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="vPO.php?module=Order&pop=1&view=<?=$_GET['po']?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
		<? 	include("includes/html/box/po_item_receive.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? if($TotalQtyLeft>0){ ?>	
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Process "  />
<? } ?>


<input type="hidden" name="ReceiveOrderID" id="ReceiveOrderID" value="<?=$_GET['po']?>" readonly />
<input type="hidden" name="PurchaseID" id="PurchaseID" value="<?=$arryPurchase[0]['PurchaseID']?>" readonly />


</td>
   </tr>
  
</table>

 </form>








<? } ?>



