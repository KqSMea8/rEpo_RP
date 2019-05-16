<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; Stock Out</span>
</div>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">Please go back and select Purchase order first.</div>';
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
	var NumLine = parseInt($("#NumLine").val());	
	
	//alert(ModuleField);return false;
	
	if($("#MsgSpan_ModuleID span").hasClass('redmsg')){		
		alert("Receipt Number Already Exist In Database.");		
		return false;
	}

var totalSum = 0;var remainQty=0;var inQty=0;
		for(var i=1;i<=NumLine;i++){	
			if(document.getElementById("qty"+i) != null){						 
				remainQty = document.getElementById("remainQty"+i).value;
				inQty = document.getElementById("qty"+i).value;
				totalSum += inQty;
			//alert(parseInt(remainQty)+'-'+parseInt(inQty));return false;
				 
				if(parseInt(remainQty) < parseInt(inQty)) {
					//alert("Return Qty Should be Less Than Or Equal To Invoice Qty.");
					alert("Returned qauntity must be be less than or equal to "+remainQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				 }
			}			
			
		}
		//alert(totalSum);return false;
  	    totalSum = parseInt(totalSum, 10);
		if(totalSum == 0)
		{
		  alert("Returned qauntity should not be blank.");
		 
		  return false;
		}else{
			ShowHideLoader('1','S');
			return true;	
		}
	

	
		
}
</script>

<? if(!empty($_GET['edit'])){ ?>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<? }else{ ?>
<form name="form1" action=""  method="post" onSubmit="return validateEditForm(this);" enctype="multipart/form-data">

<? } ?>

<?php //print_r($arryRMA);?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" valign="top" width="20%"> RMA No# : </td>
        <td align="left" width="30%" valign="top">         
	<?php if(!empty($_GET['rcpt'])){?>
	 <b><?=$arryRMA[0]['ReturnID'];?></b>
	<?php } else {?>
	<input name="VReceiptNo" type="text" class="datebox" id="VReceiptNo" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','VReceiptNo','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
     
        <td  align="right"   class="blackbold" width="20%">Receipt Date  : </td>
        
        <td   align="left" >
 <? 	
$arryTime = explode(" ",$Config['TodayDate']);
$RmaDate = $arryTime[0]; 
?>

 <?=date($Config['DateFormat'], strtotime($RmaDate))?>
		</td>
      </tr>  
 <tr>
        <td  align="right"   class="blackbold" >Item RMA Date  :</td>
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
$ReceivedDate = ($arryRMA[0]['ReceivedDate']>0)?($arryRMA[0]['ReceivedDate']):($arryTime[0]); 
?>
<input id="ReceivedDate" name="ReceivedDate" readonly="" class="datebox" value="<?=$ReceivedDate?>"  type="text" > 


</td>
     
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="ReceiptComment" type="text" class="inputbox" id="ReceiptComment" value="<?php echo stripslashes($arryRMA[0]['InvoiceComment']); ?>"  maxlength="100" />          
		</td>
		
	
		
	</tr>
	
	<tr>
	<td  align="right"   class="blackbold"> Status : </td>
		 <td   align="left" >
                     <select name="ReceiptStatus" id="ReceiptStatus" class="inputbox">
                         <option value="Parked" <?=($arryRMA[0]['ReceiptStatus']=="Parked")?("Selected"):("")?>>Parked</option>     
                         <option value="Completed"  <?=($arryRMA[0]['ReceiptStatus']=="Completed")?("Selected"):("")?>>Completed</option>   
                     </select>   
                 </td>
	            
       <td align="right">Re-Stocking :</td>
     <td   align="left">
	<?=($arryRMA[0]["Restocking"] == 1)?('Yes'):('No')?>
<input name="Restocking" type="hidden" class="inputbox" id="Restocking" value="<?php echo stripslashes($arryRMA[0]['Restocking']); ?>"  />  
	      </td> 
	</tr>
	
	

<? if(!empty($_GET['edit'])){ ?>


 <!--tr>
        <td  align="right" class="heading" >Payment Details</td>
		 <td  align="right" class="heading" colspan="3"></td>
      </tr>
	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	echo '<B>'.$arryRMA[0]['TotalAmount'].' '.$arryRMA[0]['Currency'].'</B>';?>
		</td>
     
        <td  align="right"   class="blackbold" > Return Amount Paid  : </td>
        <td   align="left" >
		<? if($arryRMA[0]['InvoicePaid']!=1){ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" <?=($arryRMA[0]['InvoicePaid']==1)?("checked"):("")?>> 
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
$PaymentDate = ($arryRMA[0]['PaymentDate']>0)?($arryRMA[0]['PaymentDate']):(""); 
?>
<input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$PaymentDate?>"  type="text" > 


</td>
     
        <td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		  <select name="InvPaymentMethod" class="inputbox" id="InvPaymentMethod">
		  	<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) { //print_r($arryPaymentMethod);?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryRMA[0]['InvPaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>

<tr>
        <td  align="right" class="blackbold">Payment Ref #  :</td>
        <td   align="left">
	<input name="PaymentRef" type="text" class="inputbox" id="PaymentRef" value="<?php echo stripslashes($arryRMA[0]['PaymentRef']); ?>"  maxlength="30" onKeyPress="Javascript:return isAlphaKey(event);"/>          
	
		</td>
</tr>



 <tr>
        <td  align="right" ></td>
        <td   align="left" > <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Save " ></td>
      </tr-->
<? } ?>

</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/rma_invoice_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_warehouse_supp_purchase_rma_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_purchase_rma_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryRMA[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Line Item 
	 <?php /*?><div style="float:right"><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$po?>" ><?=VIEW_ORDER_DETAIL?></a></div><?php */?>

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
		
		include("includes/html/box/warehouse_po_item_purchase_rma.php");
		
	}else{
		
		include("includes/html/box/warehouse_po_item_purchase_return_rma.php");
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
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Process "/>
<? } ?>

<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['edit']?>" readonly />
<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
 <input type="hidden" name="Recipt_ID" id="Recipt_ID" value="<?=$Receipt_id?>" readonly />


</td>
   </tr>
  
</table>

 </form>








<? } ?>



