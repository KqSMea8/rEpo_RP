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


?>


<script language="JavaScript1.2" type="text/javascript">
 

function validateForm(frm){
 

	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0; 
	var total_received=0; var total_qty_received=0;
	var to_return=0; var total_to_return=0;
	var total_returned=0; 

	var EditReturnID = Trim(document.getElementById("OrderID")).value;


	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleVal = Trim(document.getElementById("ReturnID")).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
	if(ModuleVal!='' || OrderID>0){
		if(!ValidateMandRange(document.getElementById("ReturnID"), "RMA Number",3,20)){
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


if(document.getElementById("serial_value"+i).value == '' && document.getElementById("qty"+i).value!=''){
		if((document.getElementById("evaluationType"+i).value == 'Serialized' || document.getElementById("evaluationType"+i).value == 'Serialized Average') && document.getElementById("DropshipCheck"+i).value != 1){

		alert("Please select serial number");
		return false;
		}

}

				if(qty > to_return){
					alert("RMA Quantity Should not be more than "+to_return+"");
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
		
		var Url = "isRecordExists.php?ReturnID="+escape(ModuleVal)+"&editID="+OrderID;
		SendExistRequest(Url,"ReturnID", "RMA Number");
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
	 <td colspan="4" align="left" class="head">RMA Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" valign="top" width="20%"> RMA No# : </td>
        <td   align="left" valign="top" width="30%">
<? if(!empty($_GET['edit'])){ ?>
      
<input name="ReturnID" type="text" class="datebox" id="ReturnID" value="<?=$arryPurchase[0]['ReturnID']?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ReturnID','<?=$_GET['edit']?>');"  />
	<div id="MsgSpan_ModuleID"></div>
<? }else{ 

		$NextModuleID = $objConfigure->GetNextModuleID('p_order','RMA');
?>
	<input name="ReturnID" type="text" class="datebox" id="ReturnID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ReturnID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
<? } ?>
</td>
     
        <td  align="right"   class="blackbold" width="20%">RMA Date  : </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#PostedDate').datepicker(
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
$PostedDate = ($arryPurchase[0]['PostedDate']>0)?($arryPurchase[0]['PostedDate']):($arryTime[0]); 
?>
<input id="PostedDate" name="PostedDate" readonly="" class="datebox" value="<?=$PostedDate?>"  type="text" > 

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
<td  align="right"   class="blackbold" > RMA Expiry Date :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ExpiryDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		minDate: "-0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$ExpiryDate = ($arryPurchase[0]['ExpiryDate']>0)?($arryPurchase[0]['ExpiryDate']):(''); 
?>
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$ExpiryDate?>"  type="text" > 



</td>     




			
	</tr>
	
	<tr>
        <td  align="right"   class="blackbold"> RMA Status : </td>
	<td   align="left" >
		<select name="Status" id="Status" class="textbox" style="width:100px;">
		<option value="Parked" <?=($arryPurchase[0]['Status']=="Parked")?("Selected"):("")?>>Parked</option>     
		<option value="Completed"  <?=($arryPurchase[0]['Status']=="Completed")?("Selected"):("")?>>Completed</option>   
		</select>  
 
	</td>
	
        <td align="right">Re-Stocking :</td>
		 <td>
 
		 <select id="Restocking" class="inputbox" name="Restocking" onchange="RestockingTo();" style="width:100px;">
		       <option value="0" <?=($arryPurchase[0]['Restocking']=='0')?('selected'):('')?>>No</option>
			<option value="1" <?=($arryPurchase[0]['Restocking']=='1')?('selected'):('')?>>Yes</option>
		  </select>
		
		 </td>

	
      </tr>
    <tr>
<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="InvoiceComment" type="text" class="inputbox" id="InvoiceComment" value="<?php echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"  maxlength="100" />          
		</td>
    </tr>
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
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_rma_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_rma_view.php");?></td>
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
	 <td  align="left" class="head" ><?=RMA_ITEM?>
	<?php /*?> <div style="float:right"><a class="fancybox fancybox.iframe" href="vPO.php?module=Order&pop=1&po=<?=$po?>" ><?=VIEW_ORDER_DETAIL?></a></div><?php */?>

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
		
	<? include("includes/html/box/po_item_rma.php");

?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? if($HideSubmit!=1){ ?>	
<input name="Submit" type="submit" class="button" id="SubmitButton" value="<?=$ButtonTitle?>"  />
<? } ?>

<?php if(empty($_GET['edit'])){?>
<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['Inv']?>" readonly />
<?php }?>
<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />


</td>
   </tr>
  
</table>

 </form>








<? } ?>



