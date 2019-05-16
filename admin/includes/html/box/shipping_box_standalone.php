 <script language="JavaScript1.2" type="text/javascript">

function openShippingUrl(url) {

	var CustID =  $('#ShippingCustID').val();
	var ShippingModuleType =  $('#ShippingModuleType').val();
	var str='';

	if(url=='Fedex')
	{
	str='../shipping/fedex.php?sp='+url;	
	}
	else if(url=='UPS')
	{
		str='../shipping/ups.php?sp='+url;
	}
	else if(url=='DHL')
	{

	       str='../shipping/dhl.php?sp='+url;
	}

	else if(url=='USPS')
	{

	       str='../shipping/usps.php?sp='+url;
	}

	if(CustID!=''){
		str += '&CustID='+CustID;
	}
	if(ShippingModuleType!=''){
		str += '&ModuleType='+ShippingModuleType;
	}

	if(url!=''){
	$.fancybox({
	 'href' :str,
	 'type' : 'iframe',
	 'width': '950',
	 'height': '700'
	 });

	}
	 
}
</script>

<?
if(empty($arryShipStand['ShippingState'])) $arryShipStand['ShippingState']=''; 
if(empty($arryShipStand['ShippingZipCode'])) $arryShipStand['ShippingZipCode']=''; 
if(empty($arryShipStand['ShippingCompany'])) $arryShipStand['ShippingCompany']=''; 
if(empty($arryShipStand['ShippingCountry'])) $arryShipStand['ShippingCountry']=''; 
if(empty($arryShipStand['ShippingAddress'])) $arryShipStand['ShippingAddress']=''; 
if(empty($arryShipStand['ShippingCity'])) $arryShipStand['ShippingCity']=''; 
if(empty($arryShipStand['ShippingMobile'])) $arryShipStand['ShippingMobile']=''; 
if(empty($arryShipStand['ShippingFax'])) $arryShipStand['ShippingFax']=''; 
if(empty($arryShipStand['ShippingName'])) $arryShipStand['ShippingName']=''; 
if(empty($arryShipStand['ShippingLandline'])) $arryShipStand['ShippingLandline']=''; 
if(empty($arryShipStand['INVNumber'])) $arryShipStand['INVNumber']=''; 
if(empty($arryShipStand['SALENUMBER'])) $arryShipStand['SALENUMBER']=''; 
if(empty($arryShipStand['REFERENCE_NUMBER'])) $arryShipStand['REFERENCE_NUMBER']=''; 
if(empty($arryShipStand['CustID'])) $arryShipStand['CustID']=''; 

$StateCode = stripslashes($arryShipStand['ShippingState']);
if(!empty($arryShipStand['ShippingCountry']) && !empty($arryShipStand['ShippingState'])){
	$StateCodeTemp = $objConfig->GetStateCodeByCountryName($arryShipStand['ShippingState'],$arryShipStand['ShippingCountry']);
	if(!empty($StateCodeTemp)){
		$StateCode = $StateCodeTemp;
	}
}
  if(empty($arryShipStand['ConversionRate'])) $arryShipStand['ConversionRate']=1; 

?>
<input name="shippingZipCodeFdx" type="hidden" id="shippingZipCodeFdx" value="<?php echo stripslashes(trim($arryShipStand['ShippingZipCode']));?>" />
<input name="ShippingCompanyTo" type="hidden" id="ShippingCompanyTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingCompany']));?>" />
<input name="ShippingCountryTo" type="hidden" id="ShippingCountryTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingCountry']));?>" />
<input name="ShippingAddressTo" type="hidden" id="ShippingAddressTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingAddress']));?>" />
<input name="ShippingCityTo" type="hidden" id="ShippingCityTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingCity']));?>" />
<input name="ShippingStateTo" type="hidden" id="ShippingStateTo" value="<?=$StateCode?>" />
<input name="ShippingMobileTo" type="hidden" id="ShippingMobileTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingMobile']));?>" />
<input name="ShippingFaxTo" type="hidden" id="ShippingFaxTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingFax']));?>" />
<input name="ShippingNameTo" type="hidden" id="ShippingNameTo" value="<?php echo stripslashes(trim($arryShipStand['ShippingName']));?>" />

<input name="ShippingLandlineNumber" type="hidden" id="ShippingLandlineNumber" value="<?php echo stripslashes(trim($arryShipStand['ShippingLandline']));?>" />
 


<input name="INVNumber" type="hidden" id="INVNumber" value="<?=$arryShipStand["INVNumber"]?>" />
<input name="SALENUMBER" type="hidden" id="SALENUMBER" value="<?=trim($arryShipStand["SALENUMBER"])?>" />
<input name="REFERENCE_NUMBER" type="hidden" id="REFERENCE_NUMBER" value="<?=trim($arryShipStand["REFERENCE_NUMBER"])?>" />
<input type="hidden" name="ConversionRate" id="ConversionRate" value="<?=$arryShipStand["ConversionRate"]?>" >

<input type="hidden" name="CustomerCurrency" id="CustomerCurrency" value="<?=$Currency?>" >
<input type="hidden" name="BaseCurrency" id="BaseCurrency" value="<?=$Config['Currency']?>" >

<input name="InsureAmount" type="hidden" class="disabled" id="InsureAmount" value="" maxlength="30" onkeypress="return isDecimalKey(event);" readonly />

<input name="InsureValue" type="hidden" class="disabled" id="InsureValue" value="" maxlength="30" onkeypress="return isDecimalKey(event);" readonly />

<input type="hidden" name="ShippingCustID" id="ShippingCustID" value="<?=$arryShipStand["CustID"]?>" >
<input type="hidden" name="ShippingModuleType" id="ShippingModuleType" value="<?=$arryShipStand["ModuleType"]?>" >

 <?php if($arryCompany[0]['ShippingCareer']==1 && $arryCompany[0]['ShippingCareerVal']!=''){?>
	 	
	<td align="right" class="blackbold">Shipping Carrier:</td>
	
	<td align="left"><select class="inputbox" name="chooseItem"
	id="chooseItem"
	onchange="var goURL=document.getElementById('chooseItem').options[document.getElementById('chooseItem').selectedIndex].value;openShippingUrl(goURL);">
	<option value="">--Select--</option>
	
	<?php
	$ShipCareers = explode(',', $arryCompany[0]['ShippingCareerVal']);
	foreach($ShipCareers as $ShipCareer){
	
	echo '<option value='.$ShipCareer.'>'.$ShipCareer.'</option>';	
	}
	?>
	
	</select>
	
	</td>
		
<?php } ?>
