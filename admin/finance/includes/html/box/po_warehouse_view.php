<?
if($arryPurchase[0]['OrderType']=="Dropship"){
	$wDisplay = 'style="display:none"';
	$shipTo = 'Customer';
}else{
	$wDisplay = '';
	$shipTo = 'Warehouse';
}
?>

	<table width="100%" border="0" cellpadding="5" cellspacing="0" >	 
		<tr>
		 <td colspan="2" align="left" class="head"><?=SHIP_TO_ADDRESS?></td>
	</tr>	
	<tr>
			<td  align="right"   class="blackbold"> <span id="wCodeTitle" <?=$wDisplay?>>Warehouse Code :</span> </td>
			<td   align="left" >
	<span id="wCodeVal" <?=$wDisplay?>>
	<?=(!empty($arryPurchase[0]['wCode']))?(stripslashes($arryPurchase[0]['wCode'])):(NOT_SPECIFIED)?>
	</span>

			</td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold" > <span id="wNameTitle"><?=$shipTo?></span> Name  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wName']))?(stripslashes($arryPurchase[0]['wName'])):(NOT_SPECIFIED)?>
		</td>
	</tr>


<tr>
			<td  align="right"   class="blackbold" valign="top" width="40%"> Address  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wAddress']))?(nl2br(stripslashes($arryPurchase[0]['wAddress']))):(NOT_SPECIFIED)?>

		</td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold"> City  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wCity']))?(stripslashes($arryPurchase[0]['wCity'])):(NOT_SPECIFIED)?>
		</td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold"> State  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wState']))?(stripslashes($arryPurchase[0]['wState'])):(NOT_SPECIFIED)?>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold"> Country  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wCountry']))?(stripslashes($arryPurchase[0]['wCountry'])):(NOT_SPECIFIED)?>
		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold"> Zip Code  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wZipCode']))?(stripslashes($arryPurchase[0]['wZipCode'])):(NOT_SPECIFIED)?>
		</td>
		  </tr>
	

	<tr>
			<td  align="right"   class="blackbold"> Contact Name  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wContact']))?(stripslashes($arryPurchase[0]['wContact'])):(NOT_SPECIFIED)?>
	</td>
		  </tr>	

 <tr>
			<td align="right"   class="blackbold">Mobile  :</td>
			<td  align="left"  >
	<?php //added by Nisha for phone no pattern
if(!empty($arryPurchase[0]['wMobile'])) {
    $arryPurchase[0]['wMobile'] = PhoneNumberFormat($arryPurchase[0]['wMobile']);
 }

//**********end of phone no pattern ?>
	<?=(!empty($arryPurchase[0]['wMobile']))?(stripslashes($arryPurchase[0]['wMobile'])):(NOT_SPECIFIED)?>
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
<?php //added by Nisha for phone no pattern

if(!empty($arryPurchase[0]['wLandline'])) {
   $arryPurchase[0]['wLandline'] = PhoneNumberFormat($arryPurchase[0]['wLandline']);
 }

//**********end of phone no ?>
	<?=(!empty($arryPurchase[0]['wLandline']))?(stripslashes($arryPurchase[0]['wLandline'])):(NOT_SPECIFIED)?>

				</td>
	 </tr>

<tr>
			<td  align="right"   class="blackbold"> Email  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['wEmail']))?(stripslashes($arryPurchase[0]['wEmail'])):(NOT_SPECIFIED)?>
		</td>
		 </tr>
		
<?php if(empty($TaxableBillingAp)){?>
<tr>
		<td align="right"   class="blackbold">Taxable  : </td>
		<td  align="left"><?=($arryPurchase[0]['tax_auths']=="Yes")?("Yes"):("No")?> </td>
	</tr>


<?
$arrRate = explode(":",$arryPurchase[0]['TaxRate']);
if(!empty($arrRate[0])){
	$TaxVal = $arrRate[2].' %';
	$TaxName = '[ '.$arrRate[1].' ]';
 
	/**set freightTxSet from inv_tax_rates if not yes**/
	if($arryPurchase[0]['freightTxSet']!='Yes' && !empty($arrRate[1]) && $arrRate[2]>0){
		$arryPurchase[0]['freightTxSet'] = $objConfigure->GetFreightTaxVal($arrRate[1],$arrRate[2],'Purchase');
	}
	/*************/

}else{
	$TaxVal = 'None';
	$TaxName = '';
}
?>

	<tr>
	<td align="right"   class="blackbold">Tax Rate  <?=$TaxName?> :</td>
	<td  align="left">  
	<?=$TaxVal?>
<input type="hidden" name="TaxRate" id="TaxRate" value="<?=$arryPurchase[0]['TaxRate']?>">
<input type="hidden" name="freightTxSet" id="freightTxSet" value="<?=$arryPurchase[0]['freightTxSet']?>">
	</td>
	</tr>	
<? } ?>

	</table>	












