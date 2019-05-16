<?
$StateCode = stripslashes($arrySale[0]['ShippingState']);
if(!empty($arrySale[0]['ShippingCountry']) && !empty($arrySale[0]['ShippingState'])){
	$StateCodeTemp = $objShipment->GetStateCodeByCountry($arrySale[0]['ShippingState'],$arrySale[0]['ShippingCountry']);
	if(!empty($StateCodeTemp)){
		$StateCode = $StateCodeTemp;
	}
}

?>
<input name="shippingZipCodeFdx" type="hidden" id="shippingZipCodeFdx" value="<?php echo stripslashes(trim($arrySale[0]['ShippingZipCode']));?>" />

<!--for api data start from here-->
<input name="ShippingCompanyTo" type="hidden" id="ShippingCompanyTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingCompany']));?>" />
<input name="ShippingCountryTo" type="hidden" id="ShippingCountryTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingCountry']));?>" />
<input name="ShippingAddressTo" type="hidden" id="ShippingAddressTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingAddress']));?>" />
<input name="ShippingCityTo" type="hidden" id="ShippingCityTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingCity']));?>" />
<input name="ShippingStateTo" type="hidden" id="ShippingStateTo" value="<?=$StateCode?>" />
<input name="ShippingMobileTo" type="hidden" id="ShippingMobileTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingMobile']));?>" />
<input name="ShippingFaxTo" type="hidden" id="ShippingFaxTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingFax']));?>" />
<input name="ShippingNameTo" type="hidden" id="ShippingNameTo" value="<?php echo stripslashes(trim($arrySale[0]['ShippingName']));?>" />

<input name="ShippingLandlineNumber" type="hidden" id="ShippingLandlineNumber" value="<?php echo stripslashes(trim($arrySale[0]['ShippingLandline']));?>" />
<input type="hidden" name="editVal" id="editVal" value="<?=$_GET['ship']?>" />


<input name="INVNumber" type="hidden" id="INVNumber" value="<?=$NextInvModuleID?>" />
<input name="SALENUMBER" type="hidden" id="SALENUMBER" value="<?=trim($arrySale[0]["SaleID"])?>" />
 

<a href="<?=$RedirectURL?>" class="back">Back</a>
<a href="<?=$DownloadUrl?>&Wstatus=Packed" target="_blank" class="download" style="float:right;margin-left:5px;">Packing Slip</a>
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
	var NumLine = parseInt($("#NumLine").val());		
	var ModuleField = '<?=$ModuleID?>';
	var OrderID = Trim(document.getElementById("OrderID")).value;
	var totalSum = 0;var remainQty=0;var inQty=0; var totRemainqty = 0;
	var evaluationType=''; var DropshipCheck='0'; var OrderQty =0; var received_qty =0;
	var serial_value = '';
	//var ShipStatus = document.getElementById("ShipStatus").value;
	


		for(var i=1;i<=NumLine;i++){


				DropshipCheck = document.getElementById("DropshipCheck"+i).value;
				evaluationType = document.getElementById("evaluationType"+i).value;
			   serial_value = document.getElementById("serial_value"+i).value;
			   var seriallength=0;
			   if(serial_value != ''){
			      var resSerialNo = serial_value.split(",");
			      var seriallength = resSerialNo.length;

			   }
						//if(ShipStatus == 'Shipped'){		                    
				if (!ValidateMandNumField2(document.getElementById("qty" + i), "Quantity", 1, 999999)) {
							//return false;
					}      
//}               
				received_qty = document.getElementById("received_qty"+i).value;
				OrderQty = document.getElementById("ordered_qty"+i).value;
				remainQty = parseInt(OrderQty) - parseInt(received_qty);
				inQty = document.getElementById("qty"+i).value;
				totalSum += inQty;
//if(ShipStatus == 'Shipped'){
if(parseInt(OrderQty) != parseInt(inQty) && inQty>0)
				{
				if(parseInt(OrderQty) < parseInt(inQty) )
				{
					//alert("Return Qty Should be Less Than Or Equal To Invoice Qty.");
					alert("Sorry Qauntity must be be less than or equal to "+OrderQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}
}
//}
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
				  return false;
				}
//if(ShipStatus == 'Shipped'){
				if( (evaluationType == 'Serialized' || evaluationType == 'Serialized Average') && seriallength!=inQty && DropshipCheck!=1 ){
					alert("Please add "+inQty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
				}
//}
			
		}
		//alert(totalSum);return false;
  	    totalSum = parseInt(totalSum, 10);
		if(totalSum == 0)
		{
		  alert("Ship qty should not be blank.");
		  document.getElementById("qty1").focus();
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
	 <td colspan="4" align="left" class="head">Pick Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> Pick No# : </td>
	<td align="left" width="30%" valign="top">



	<?php if(!empty($_GET['Pick']==1)){?>
	 <?=$arrySale[0]['PickID'];?>
	<?php } else {?>
	<input name="PickID" type="text" class="datebox" id="PickID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','PickID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Pick Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['Pick']==1)){
	$arryTime = explode(" ",$Config['TodayDate']);
	$ShippedDate = ($arrySale[0]['PickDate']>0)?($arrySale[0]['PickDate']):($arryTime[0]); 
	echo $ShippedDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#PickDate').datepicker(
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
<style>
.inpad{
padding-left: 5px;

}
</style>
<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ShippedDate = ($arrySale[0]['PickDate']>0)?($arrySale[0]['PickDate']):($arryTime[0]); 
?>
<input id="PickDate" name="PickDate" readonly="" class="datebox" value="<?=$ShippedDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
<tr>
				<td align="right" class="blackbold">Status :</td>
<td align="left">
<? if($arryShip[0]['PickStatus'] == 'Completed' && $_GET['Pick']>0){

echo $arryShip[0]['PickStatus'];

}else{?>
	
				
						<select name="PickStatus" id="PickStatus" 	class="inputbox">
						
							
							<option value="In Picking"
							<?=($arryShip[0]['PickStatus'] == 'In Picking')?("selected"):("")?>>In Picking</option>
							<option value="Completed"
							<?=($arryShip[0]['PickStatus'] == 'Completed')?("selected"):("")?>>Completed</option>
						</select>
<? }?>
			</td>
</tr>
</table>
<tr>
	 <td align="left"><? $module='Order';
			$SpiffSaleID=$SaleID;
			include("../finance/includes/html/box/sales_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?php
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>

<input type="hidden" name="CustomerCurrency" id="CustomerCurrency" value="<?=$Currency?>">	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Picking Items
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
	<td align="left">
	<? if($HideSubmit!=1 || $Config['batchmgmt']==1){ ?>	
	<?php include("includes/html/box/so_item_shipment.php");?>
	<?php } else {?>
	<?php include("includes/html/box/so_item_shipment.php");?>
	<?php }?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1 || !empty($_GET['ship']) || empty($arryInvoice[0]['PostToGL'])){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Save"  />
		<? } ?>

		
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />

<input type="hidden" name="so" id="so" value="<?=$_GET['so']?>" readonly />
<input type="hidden" name="batchId" id="batchId" value="<?=$_GET['batchId']?>" readonly />
<input type="hidden" id="CustCode" name="CustCode" value="<?=$arrySale[0]['CustCode'];?>" readonly>		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



