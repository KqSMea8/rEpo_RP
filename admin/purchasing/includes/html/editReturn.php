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

function validateEditForm(frm){
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







function validateForm(frm){


	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0; 
	var total_received=0; var total_qty_received=0;
	var to_return=0; var total_to_return=0;
	var total_returned=0; 

	var EditReturnID = Trim(document.getElementById("OrderID")).value;

	if(EditReturnID>0){
		ShowHideLoader('1','S');
		return true;	
	}




	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleVal = Trim(document.getElementById("ReturnID")).value;

	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById("ReturnID"), "Return No",3,20)){
			return false;
		}
	}
	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("item_id"+i) != null){
			qty_left = 0; qty = document.getElementById("qty"+i).value;
			total_received = document.getElementById("total_received"+i).value;
			total_returned = document.getElementById("total_returned"+i).value;
			
			to_return = total_received - total_returned;
		
			if(to_return > 0){

				if(!ValidateOptNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}			
				if(qty > to_return){
					alert("Qauntity must be be less than or equal to "+to_return+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}else{
					total_qty += +$("#qty"+i).val();
				}

				total_to_return += +to_return;
				
			}

			total_qty_received += +total_received;


		}
	}


	
	if(total_qty_received<=0){
		alert("No qauntities has been received for this order.");
		return false;
	}else if(total_to_return<=0){
		alert("No qauntities left to return for this order.");
		return false;
	}else if(total_qty<=0){
		alert("Please enter qauntity to return for any item.");
		return false;
	}




	if(ModuleVal!=''){
		var Url = "isRecordExists.php?ReturnID="+escape(ModuleVal)+"&editID=";
		SendExistRequest(Url,"ReturnID", "Return No");
		return false;	
	}else{
		ShowHideLoader('1','S');
		return true;	
	}
	
		
}
</script>

<? if(!empty($_GET['edit'])){ ?>
<form name="form1" action=""  method="post" onSubmit="return validateEditForm(this);" enctype="multipart/form-data">
<? }else{ ?>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<? } ?>



<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Return Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" valign="top" width="20%"> Return No# : </td>
        <td   align="left" valign="top" width="30%">
<? if(!empty($_GET['edit'])){ ?>
     <B><?=stripslashes($arryPurchase[0]["ReturnID"])?></B>

<? }else{ ?>
	<input name="ReturnID" type="text" class="datebox" id="ReturnID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ReturnID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
<? } ?>
</td>
     
        <td  align="right"   class="blackbold" width="20%">Return Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
 <tr>
        <td  align="right"   class="blackbold" >Item Returned Date  :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReceivedDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
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
     
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="InvoiceComment" type="text" class="inputbox" id="InvoiceComment" value="<?php echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"  maxlength="100" />          
		</td>
	</tr>

<? if(!empty($_GET['edit'])){ ?>


 <tr>
        <td  align="right" class="heading" >Payment Details</td>
		 <td  align="right" class="heading" colspan="3"></td>
      </tr>
	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';?>
		</td>
     
        <td  align="right"   class="blackbold" > Return Amount Paid  : </td>
        <td   align="left" >
		<? if($arryPurchase[0]['InvoicePaid']!=1){ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" <?=($arryPurchase[0]['InvoicePaid']==1)?("checked"):("")?>> 
		<? }else{ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" style="display:none" checked> <span class="green">Yes</span>
		<? } ?>
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
<? } ?>

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
	 <td  align="left" class="head" ><?=RETURN_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="vPO.php?module=Order&pop=1&po=<?=$po?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
		<? 	
	if(!empty($_GET['edit'])){
		include("includes/html/box/po_item_return_view.php");
	}else{
		include("includes/html/box/po_item_return.php");
	}

?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? if($HideSubmit!=1){ ?>	
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Process "  />
<? } ?>


<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['po']?>" readonly />
<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />


</td>
   </tr>
  
</table>

 </form>








<? } ?>



