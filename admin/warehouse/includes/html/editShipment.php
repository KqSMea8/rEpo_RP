<?
$StateCode = stripslashes($arrySale[0]['ShippingState']);
if(!empty($arrySale[0]['ShippingCountry']) && !empty($arrySale[0]['ShippingState'])){
	$StateCodeTemp = $objShipment->GetStateCodeByCountry($arrySale[0]['ShippingState'],$arrySale[0]['ShippingCountry']);
	if(!empty($StateCodeTemp)){
		$StateCode = $StateCodeTemp;
	}
}


 
$arryAtt = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
$shipCareerArr=array();
foreach($arryAtt as $arryAttVal){	 
	$shipCareerArr[]=$arryAttVal['attribute_value'];
	
}
$arrOtherCareer = array_diff($shipCareerArr, array("DHL", "Fedex","UPS","USPS"));

#pr($arr,1);

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
<input name="REFERENCE_NUMBER" type="hidden" id="REFERENCE_NUMBER" value="<?=trim($arrySale[0]["SaleID"])?>" />
 

<a href="<?=$RedirectURL?>" class="back">Back</a>

<? if (empty($ErrorMSG)) {?>
<a href="<?=$DownloadUrl?>&Wstatus=Packed" target="_blank" class="download" style="float:right;margin-left:5px;">Packing Slip</a>
 <? } ?>


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
	
	if(document.getElementById("chooseItem") != null){
		if(!ValidateForSelect(document.getElementById("chooseItem"), "Shipping Career")){
			return false;
		}
	}


	if(document.getElementById("ShippedID") != null){
		var ShippedID = Trim(document.getElementById("ShippedID")).value;
		if(ShippedID!=''){
			var DataExistS=0;
			if(!ValidateMandRange(document.getElementById("ShippedID"), "Shipment Number",3,20)){
				return false;
			}
			DataExistS = CheckExistingData("isRecordExists.php","&ShippedID="+escape(ShippedID), "ShippedID","Shipment Number");
			if(DataExistS==1)return false;
		} 
	}

	
if(document.getElementById("ShipStatus") != null){
	var ShipStatus = document.getElementById("ShipStatus").value;

	if(ShipStatus == 'Shipped'){	
		var RefInvoiceID = Trim(document.getElementById("RefInvoiceID")).value;
		if(RefInvoiceID!=''){
			var DataExist=0;
			if(!ValidateMandRange(document.getElementById("RefInvoiceID"), "Invoice Number",3,20)){
				return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&SaleInvoiceID="+escape(RefInvoiceID), "RefInvoiceID","Invoice Number");
			if(DataExist==1)return false;
		}
	}
}



		for(var i=1;i<=NumLine;i++){


				DropshipCheck = document.getElementById("DropshipCheck"+i).value;
				evaluationType = document.getElementById("evaluationType"+i).value;
			   serial_value = document.getElementById("serial_value"+i).value;
			   var seriallength=0;
			   if(serial_value != ''){
			      var resSerialNo = serial_value.split(",");
			      var seriallength = resSerialNo.length;

			   }
						if(ShipStatus == 'Shipped'){		                    
				if (!ValidateMandNumField2(document.getElementById("qty" + i), "Quantity", 1, 999999)) {
							//return false;
					}      
}               
				received_qty = document.getElementById("received_qty"+i).value;
				OrderQty = document.getElementById("ordered_qty"+i).value;
				remainQty = parseInt(OrderQty) - parseInt(received_qty);
				inQty = document.getElementById("qty"+i).value;
				totalSum += inQty;
//if(ShipStatus == 'Shipped'){
if(parseInt(OrderQty) != parseInt(inQty))
				{
				if(parseInt(OrderQty) < parseInt(inQty))
				{
					//alert("Return Qty Should be Less Than Or Equal To Invoice Qty.");
					alert("Ship qauntity must be be less than or equal to "+OrderQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}
}
//}
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
				  return false;
				}
if(ShipStatus == 'Shipped'){
				if( (evaluationType == 'Serialized' || evaluationType == 'Serialized Average') && seriallength!=inQty && DropshipCheck!=1 ){
					alert("Please add "+inQty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
				}
}
			
		}
		//alert(totalSum);return false;
  	    totalSum = parseInt(totalSum, 10);

		if(totalSum == 0)
		{
if(ShipStatus == 'Shipped'){
		  alert("Ship qty should not be blank.");
		  document.getElementById("qty1").focus();
		  return false;
}
		}else{
			ShowHideLoader('1','S');
			return true;	
		}
	

	
		
}
function FreightVal(){
	//alert('hello this is a testing');

    var loading = $("#loading");

    var BCountryCode = "<?php if(!empty($BcounrtyCd[0]['code'])){ echo $BcounrtyCd[0]['code']; }?>";
    var BZipCode = "<?php if(!empty($arrySale[0]['ZipCode'])){echo $arrySale[0]['ZipCode'];}?>";

    
    var CustomerCurrency = "<?php if(!empty($arrySale[0]['CustomerCurrency'])){echo $arrySale[0]['CustomerCurrency'];}?>";
    
    var SCountry = "<?php if(!empty($ScountryCd[0]['code'])){echo $ScountryCd[0]['code'];}?>";
    var SZipCode = "<?php if(!empty($arrySale[0]['ShippingZipCode'])){echo $arrySale[0]['ShippingZipCode'];}?>";

	var height = $("#height").val();
	var width = $("#width").val();
	var action = $("#apiVal").val();
	
	var dataString = 'BCountryCode='+BCountryCode+'&BZipCode='+BZipCode+'&CustomerCurrency='+ CustomerCurrency+'&SCountry='+SCountry+'&SZipCode='+SZipCode+'&height='+height+'&width='+width+'&action='+ action;

	loading.show();
	$.ajax({
		 type:"POST",
		url: "api.ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
		
		//alert(html);
		loading.hide();
		if(html!=''){
		$("#Freight").val(html);
		}else{
			alert('No value get!');
		}
	}
		});
	
}

</script>


<script language="JavaScript">

function openFB(url) {

var wcode = document.getElementById("WarehouseCode").value;
var CustID =  $('#CustID').val();

var chkurl = url.toLowerCase();

if(chkurl=='fedex')
{
str='fedex.php?sp='+url+'&wcode='+wcode;	
}
else if(chkurl=='ups')
{
	str='ups.php?sp='+url+'&wcode='+wcode;
}
else if(chkurl=='dhl')
{
	//alert('DHL Api In Process');exit;

       str='dhl.php?sp='+url+'&wcode='+wcode;
}

else if(chkurl=='usps')
{
	//alert('USPS Api In Process');exit;

       str='usps.php?sp='+url+'&wcode='+wcode;
}

else if(chkurl=='customer')
{

	str='customPickup.php?sp='+url+'&wcode='+wcode;
 	
}
else
{
	
	 str='otherPickup.php?sp='+url+'&wcode='+wcode;
	 
}


if(CustID>0){
	str = str + '&CustID='+CustID;
}

 


if(url!=''){
$.fancybox({
 'href' : '../shipping/'+str,
 'type' : 'iframe',
 'width': '950',
 'height': '700'
 });

}
 
}



function setChkSelect(){
   var ddl = document.getElementById('ShipStatus');
   var selectedValue = ddl.options[ddl.selectedIndex].value;

   var chk = document.getElementById('GenrateShipInvoice');
  

   if(selectedValue == 'Picked'){
     chk.value = '';
$('#inv').fadeOut('slow');
     
   }else if(selectedValue == 'Packed'){
     chk.value = '';
$('#inv').fadeOut('slow');
   }else if(selectedValue == 'Shipped'){

			chk.value = 1;
$('#inv').fadeIn('slow');
     
     
   }else{
     chk.value = '';
$('#inv').fadeOut('slow');
     
   }
}

/*$(document).ready(function(){
$('#ShipStatus').change(function(){
if(this.value =='Shipped')
$('#inv').fadeIn('slow');
else
$('#inv').fadeOut('slow');

});
});*/



$(document).ready(function() {
    $(document).on("click", ".gene", function(e) {

//alert("aaaaaaaaaaa");
       var checked = $(this).is(":checked");
       if (checked) {
           $('#inv').fadeIn('slow');
       } else {
           $('#inv').fadeOut('slow');
       }
    });
});

/* multiple shipment */

$(document).ready(function() {
    $('#multiplelink').click(function(e) {  
    		var CustCode = $('#CustCode').val();
		var batchId = $('#batchId').val();
		var OrderID = $('#OrderID').val();
		 
		if(CustCode!=''){
		    	$.fancybox({
	    		 'href' : '../shipping/multipleShipment.php?CustCode='+CustCode+'&batchId='+batchId+'&OrderID='+OrderID,
	    		 'type' : 'iframe',
	    		 'width': '950',
	    		 'height': '900'
	    		 });
		}    	
		    	
      });
	 
});

$(document).ready(function () {
	$('#FillAllQty').change(function () {
		var NumLine = parseInt($("#NumLine").val());
		for(var i=1;i<=NumLine;i++){
			var ordered_qty = $("#ordered_qty"+i).val();
			var total_received = $("#received_qty"+i).val();
			if (!this.checked) {
			
					$("#qty"+i).val('0');
					$("#qty"+i).trigger("blur");
			}else{ 
					var totOrderQty = ordered_qty - total_received;
					$("#qty"+i).val(totOrderQty) ;
					//$("#qty"+i).focus();
					$("#qty"+i).trigger("blur");
			 }

		}
	});

});

</script>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">




<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Shipment Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> Shipment No# : </td>
	<td align="left" width="30%" valign="top">



	<?php if(!empty($_GET['ship'])){?>
	 <?=$arrySale[0]['ShippedID'];?>
	<?php } else {?>
	<input name="ShippedID" type="text" class="datebox" id="ShippedID" value="<?=$NextModuleID?>"  maxlength="20" oncontextmenu="return false" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','ShippedID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"  />
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Shipment Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['ship'])){
	$arryTime = explode(" ",$Config['TodayDate']);
	$ShippedDate = ($arrySale[0]['ShippedDate']>0)?($arrySale[0]['ShippedDate']):($arryTime[0]); 
	echo $ShippedDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#ShippedDate').datepicker(
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
$ShippedDate = ($arrySale[0]['ShippedDate']>0)?($arrySale[0]['ShippedDate']):($arryTime[0]); 
?>
<input id="ShippedDate" name="ShippedDate" readonly="" class="datebox" value="<?=$ShippedDate?>"  type="text" > 
<?php }?>

</td>
      </tr>



	<? if($arrySale[0]['CreatedDate']>0){ ?>
		<tr>
		<td  align="right"   class="blackbold" > Created Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['CreatedDate'])); ?>
		</td>
		<td  align="right"   class="blackbold" >  Updated Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['UpdatedDate'])); ?>
		</td>
		</tr>
	<? } ?>


<tr>
				<td align="right" class="blackbold">Status :</td>
<td align="left">
<? if($arryShip[0]['ShipmentStatus'] == 'Shipped' && $_GET['edit']>0){

echo $arryShip[0]['ShipmentStatus'];

}else{?>
	
				
						<select name="ShipStatus" id="ShipStatus" onchange="setChkSelect();"	class="inputbox">
							<option value="Picked"
							<?=($arryShip[0]['ShipmentStatus'] == 'Picked')?("selected"):("")?>>Picked</option>
							<option value="Packed"
							<?=($arryShip[0]['ShipmentStatus'] == 'Packed')?("selected"):("")?>>Packed</option>
							<option value="Shipped"
							<?=($arryShip[0]['ShipmentStatus'] == 'Shipped')?("selected"):("")?>>Shipped</option>
						</select>
<? }?>
			</td>

				<td align="right" class="blackbold">Comments :</td>
				<td align="left"><input name="ShipmentComment" type="text"
					class="inputbox" id="ShipmentComment"
					value="<?php echo stripslashes($arryShip[0]['ShipComment']); ?>"
					maxlength="100" /></td>
			</tr>
<tr>
        <td align="right" class="blackbold">Invoice</td>
        <td   align="left"  >



<? if($arryShip[0]['RefID']!='' && $arryShip[0]['ShipmentStatus'] == 'Shipped'){?>


<a class="fancybox po fancybox.iframe" href="../finance/vInvoice.php?pop=1&inv=<?=$arryShip[0]['RefID']?>" ><?=$arryShip[0]['RefID']?></a>

 <?}else if($arryShip[0]['RefID']=='' && $arryShip[0]['ShipmentStatus'] == 'Shipped'){?>


<input type="checkbox" name="GenrateShipInvoice" class="gene"  id="GenrateShipInvoice" value="<?=$arrySale[0]['GenrateShipInvoice']?>" >
 <span id="inv"  style="display: none;"><input name="RefInvoiceID" type="text" class="datebox" id="RefInvoiceID" value="<?=$NextInvModuleID?>"  maxlength="20"  oncontextmenu="return false" onKeyPress="Javascript:return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);" /></span>
<input type="hidden" name="ShipStatus"  id="ShipStatus" value="<?=$arryShip[0]['ShipmentStatus']?>" >

<? } else{?>


		<input type="hidden" name="GenrateShipInvoice"  id="GenrateShipInvoice" value="<?=(!empty($arrySale[0]['GenrateShipInvoice']))?($arrySale[0]['GenrateShipInvoice']):('')?>" >
 <span id="inv"  style="display: none;"><input name="RefInvoiceID" type="text" class="datebox" id="RefInvoiceID" value="<?=$NextInvModuleID?>"  maxlength="20"  oncontextmenu="return false" onKeyPress="Javascript:return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);" /></span>
 <?  }?>

           </td>
      </tr>
			<tr>
				<td align="right" class="blackbold">Ship From :</td>
				<td align="left"><input name="WarehouseCode" type="text"
					class="disabled" style="width: 90px;" id="WarehouseCode"
					value="<?php echo stripslashes($arryShip[0]['WarehouseCode']); ?>"
					maxlength="40" readonly /> <a class="fancybox fancybox.iframe"
					href="wList.php"><?=$search?></a></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Ship From(Warehouse) :</td>
				<td align="left"><input name="WarehouseName" type="text"
					class="disabled" id="WarehouseName"
					value="<?php echo stripslashes($arryShip[0]['WarehouseName']); ?>"
					maxlength="50" onkeypress="return isCharKey(event);" readonly /> <input
					name="WID" type="hidden" class="inputbox" id="WID"
					value="<?php echo stripslashes($arryShip[0]['WID']); ?>"></td>

<?php 
if($arryCompany[0]['ShippingCareer']==1 && $arryCompany[0]['ShippingCareerVal']!=''){?>

	<td align="right" class="blackbold">Shipping Carrier: <span class="red">*</span> </td>
	
	<td align="left">
 
<select class="inputbox" name="chooseItem"
	id="chooseItem"
	onchange="var goURL=document.getElementById('chooseItem').options[document.getElementById('chooseItem').selectedIndex].value;openFB(goURL);">
	<option value="">--Select--</option>
	
	<?php

	$ShipCareers = explode(',', $arryCompany[0]['ShippingCareerVal']);
	$ShipCareersOther = array_merge($ShipCareers,$arrOtherCareer);
 	$ShipCareers = $ShipCareersOther;
	 
	foreach($ShipCareers as $ShipCareer){	
		$sel = (strtolower($arryShippInfo[0]['ShipType'])==strtolower($ShipCareer))?("selected"):("");
		echo '<option value='.$ShipCareer.' '.$sel.'>'.$ShipCareer.'</option>';	
	}
	?>
	
	</select>
	
	</td>

<?php } ?>


			</tr>
	<?php if(!empty($_GET['ship'])){?>
		<tr>
			<td align="right"></td>
			<td align="left"> 
			<input type="hidden" name="shipID" id="shipID" value="<?=$arryShip[0]['ShipmentID']?>" readonly />
			<!--input name="Submit" type="submit" class="button" id="SubmitButton" value="Save"-->
			
			</td>
		</tr>
	<?php }?>


 	<tr id="ShippingRateTr" style="display:none">
	 
        <td align="right" class="blackbold">Shipping Rate : </td>
        <td   align="left" >
<input name="ShippingRateVal" type="text" class="disabled" id="ShippingRateVal" value="" maxlength="30" onkeypress="return isDecimalKey(event);" readonly /> 

<input name="InsureAmount" type="hidden" class="disabled" id="InsureAmount" value="" maxlength="30" onkeypress="return isDecimalKey(event);" readonly /> 

<input name="InsureValue" type="hidden" class="disabled" id="InsureValue" value="" maxlength="30" onkeypress="return isDecimalKey(event);" readonly /> 




           </td>
      </tr>

</table>


<?     
//if(!empty($_GET['edit']) && !empty($_GET['SaleID'])){
if(empty($arryShippInfo[0]['ShipType']) ){
 include("includes/html/box/multiple_shipment.php");
}
	
?>

	 </td>
</tr>



<tr>
	<td align="left">
	<? include("../includes/html/box/shipping_info.php");?>
	</td>
</tr>
<tr>
	 <td align="left"><? 
 $SpiffSaleID = $SaleID;
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
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" ></td>
		</tr>
		<tr>
	<td align="left" >
			 <input type="checkbox" name="FillAllQty" id="FillAllQty" class="textbox" value="1"/> <span class="heading">Fill All Quantity</span>
			</td>
			
			<td align="right" >
<?php
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>

<input type="hidden" name="CustomerCurrency" id="CustomerCurrency" value="<?=$Currency?>">	 
<input type="hidden" name="BaseCurrency" id="BaseCurrency" value="<?=$Config['Currency']?>">	 

<? if(empty($arrySale[0]['ConversionRate'])) $arrySale[0]['ConversionRate']=1; ?>
<input type="hidden" name="ConversionRate" id="ConversionRate" value="<?=$arrySale[0]['ConversionRate']?>">	 
</td>
</tr>
</table>
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Shipment Items
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
	<? if($HideSubmit!=1 || $Config['batchmgmt']==1 || $Config['TrackInventory']==1){ ?>	
	<?php include("includes/html/box/so_item_shipment.php");?>
	<?php } else {?>
	<?php include("includes/html/box/so_item_shipment_view.php");?>
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

		<?php if(empty($_GET['ship'])){?>
		<input type="hidden" name="ShippedOrderID" id="ShippedOrderID" value="<?=$_GET['edit']?>" readonly />
		<?php }?>
<input type="hidden" name="OrderID" id="OrderID" value="<?=$OrderID?>" readonly />
<input type="hidden" name="batchId" id="batchId" value="<?=$_GET['batch']?>" readonly />
<input type="hidden" id="CustCode" name="CustCode" value="<?=$arrySale[0]['CustCode'];?>" readonly>
<input type="hidden" id="CustID" name="CustID" value="<?=$arrySale[0]['CustID'];?>" readonly>	
<input type="hidden" id="ShipAccountNumber" name="ShipAccountNumber" value="<?=$arrySale[0]['ShipAccountNumber'];?>" readonly>			

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



