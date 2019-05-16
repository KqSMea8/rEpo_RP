<?php 

#echo "<pre>";print_r($arrayService);

if($_GET['sp']=='UPS'){
	$fdAccount = $arryApiACDetails[0]['api_meter_number'];
}else{
	$fdAccount = $arryApiACDetails[0]['api_account_number'];
}

?>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">

	<tbody>
		<tr>
			<td align="center" valign="top">

			<table width="100%" border="0" cellpadding="5" cellspacing="0"
				class="borderall">
				<tbody>

					<tr>
						<td colspan="2" align="left" class="head">Shipping Carrier Details</td>
					</tr>

					<tr>
						<td align="right" class="blackbold">Shipping Method :<span
							class="red">*</span></td>
						<td align="left"><select name="ShippingMethod" size="1"
							id="ShippingMethod" class="inputbox">
							<option value="">--- Select ---</option>
							<?php foreach($arrayService as $Service){?>
							<option value="<?=$Service['service_value'];?>"
							<?php if($_POST['ShippingMethod']== $Service['service_value']){ echo "selected='selected'";}?>><?=$Service['service_type'];?></option>
							<?php }?>
						</select></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Packages Type:<span
							class="red">*</span></td>
						<td align="left"><select name="packageType" size="1"
							id="packageType" class="inputbox" onchange="packType()">
							<option value="">--- Select ---</option>

							<?php foreach($arrayPackage as $Package){?>
							<option value="<?=$Package['package_type_value'];?>"
							<?=($packageType==$Package['package_type_value'])?('selected'):('')?>><?=$Package['package_type'];?></option>
							<?php }?>

						</select></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Account Type :<span
							class="red">*</span></td>
						<td align="left"><select name="AccountType" class="inputbox"
							id="AccountType" onchange="masterDetail()">
							<option value="">--- Select ---</option>
							<option value="1"
							<?php if($_POST['AccountType']=='1'){ echo "selected='selected'";}?>>Customer</option>
							<option value="2"
							<?php if($_POST['AccountType']=='2'){ echo "selected='selected'";}?>>Shipper</option>
							<option value="3"
							<?php if($_POST['AccountType']=='3'){ echo "selected='selected'";}?>>Third
							Party</option>
						</select></td>
					</tr>



					<tr>
						<td align="right" class="blackbold">Account Number :<span
							class="red">*</span></td>
						<td align="left"><input name="AccountNumber" type="text"
							class="inputbox" id="AccountNumber" value="<?=$AccountNumber?>"
							maxlength="50"></td>
					</tr>



					<tr>
						<td align="right" class="blackbold">Master Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="SourceZipcode" type="text"
							id="SourceZipcode" value="<?=$SourceZipcode?>" maxlength="30"
							onkeypress="return isNumberKey(event);" readonly
							class="disabled_inputbox"></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Destination Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="DestinationZipcode" type="text"
							id="DestinationZipcode" class="inputbox"
							value="<?=$DestinationZipcode?>" maxlength="30"
							onkeypress="return isNumberKey(event);"></td>
					</tr>


					<tr>
						<td align="right" width="45%" class="blackbold">No Of Packages:<span
							class="red">*</span></td>
						<td align="left"><select name="NoOfPackages" class="inputbox"
							id="NoOfPackages" onchange="addRows();">
							<option value="">--- Select ---</option>
							<?php
							for($i=1;$i<=25;$i++){?>

							<option value="<?=$i?>"
							<?=($NoOfPackages==$i)?('selected'):('')?>><?=$i?></option>
							<?php } ?>
						</select></td>
					</tr>


				  <tr class="ITN" style="display:none;">
						<td align="right" class="blackbold">AES Number:<span class="red">*</span></td>
						<td align="left">
<input name="AES" type="text"	class="inputbox" size="10" id="AES" value=""  onkeypress="return isUniqueKey(event);"
							maxlength="50"> 
			      	 </td>
				   </tr>


					<tr
					<?php if($_POST['packageType']== "YOUR_PACKAGING"){ echo 'style="display: none;"';}?>
						id="WeightPk">
						<td align="right" class="blackbold">Weight:<span class="red">*</span></td>
						<td align="left"><input name="WPK" type="text" class="textbox"
							size="10" id="WPK" value="<?=$WPK?>" maxlength="10"
							onkeypress="return isDecimalKey(event);"> <select name="WPK_Unit"
							id="WPK_Unit" class="textbox">
							<option value="LB" <?=($WPK_Unit=='LB')?('checked'):('')?>>LB</option>
							<option value="KG" <?=($WPK_Unit=='KG')?('checked'):('')?>>KG</option>
						</select></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Insure The Shipment:</td>
						<td align="left"><input name="InsureAmount" type="text"
							class="textbox" size="10" id="InsureAmount" value="<?=$InsureAmount?>"
							maxlength="10" onkeypress="return isDecimalKey(event);"> 
						
						<input
						type="text" value="<?=$Currency?>" style="width:30px;border:none" maxlenght="10" readonly="" class="textbox"
						id="InsureCurrency" name="InsureCurrency">
					     </td>
					</tr>

<tr>
	<td align="right" class="blackbold">Delivery Signature:</td>
	<td align="left"><input type="checkbox" name="DeliverySignature" id="DeliverySignature"
		value="1" <?=($DeliverySignature=='1')?('checked'):('')?>></td>
</tr>


<tr id="DSOptions"
<?php if($DeliverySignature != "1"){ echo 'style="display: none;"';}?>>
	<td align="right" class="blackbold">Delivery Signature Options:<span class="red">*</span></td>
	<td align="left">
	<select name="DSOptionsType" class="inputbox" id="DSOptionsType">
		<option value="1"<?php if($_POST['DSOptionsType']==1){ echo "selected='selected'";}?>>Delivery Confirmation</option>
		<option value="2"<?php if($_POST['DSOptionsType']==2){ echo "selected='selected'";}?>>Signature Required</option>
		<option value="3"<?php if($_POST['DSOptionsType']==3){ echo "selected='selected'";}?>>Adult Signature Required</option>
	</select>

	</td>
</tr>




					<tr>

						<td align="right" class="blackbold">Shipmaster Label:</td>
						<td align="left"><input type="checkbox" name="fedexLabel"
							value="Yes" <?=($fedexLabel=='Yes')?('checked'):('')?>></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">COD Label:</td>
						<td align="left"><input type="checkbox" name="COD" id="COD"
							value="1" <?=($COD=='1')?('checked'):('')?>></td>
					</tr>

					<tr id="CODAmountTR"
					<?php if($COD != "1"){ echo 'style="display: none;"';}?>>
						<td align="right" class="blackbold">COD Amount:<span class="red">*</span></td>
						<td align="left"><input type="text" class="textbox" size="10"
							maxlenght="10" name="CODAmount" id="CODAmount"
							value="<?=$CODAmount?>" onkeypress="return isDecimalKey(event);">
						<input type="text" name="Currency" id="Currency" class="textbox"
							readonly style="width: 30px; border: none" maxlenght="3"
							value="<?=$Currency?>" /></td>
					</tr>

					<tr id="CollectionTypeTR"
					<?php if($COD != "1"){ echo 'style="display: none;"';}?>>
						<td align="right" class="blackbold">COD Collection Type:</td>
						<td align="left"><select name="CollectionType" id="CollectionType"
							class="textbox">
							<option value="GUARANTEED_FUNDS"
							<?php if($CollectionType=='GUARANTEED_FUNDS'){ echo "selected='selected'";}?>>Secured</option>
							<option value="ANY"
							<?php if($CollectionType=='ANY'){ echo "selected='selected'";}?>>Unsecured</option>

						</select></td>
					</tr>


					<tr>

						<td align="right" class="blackbold"></td>
						<td align="left"><input name="fdAccount" type="hidden"
							id="fdAccount" readonly
							value="<?=$fdAccount?>"></td>
					</tr>

				</tbody>
			</table>


			</td>
		</tr>

		<input name="Action" type="hidden" id="Action"
			value="<?php echo $_GET['sp'];?>">

	</tbody>


</table>


<table width="86%" cellpadding="0" cellspacing="1" id="wline"
	style="display: none">

	<thead>
		<tr align="left">
			<td class="heading" style="padding-left: 33px;">Weight</td>
			<td class="heading" style="padding-left: 33px;">WUnit</td>
			<td class="heading" style="padding-left: 33px;">Length</td>
			<td class="heading" style="padding-left: 33px;">Width</td>
			<td class="heading" style="padding-left: 33px;">Height</td>
			<td class="heading" style="padding-left: 33px;">DUnit</td>

		</tr>


	</thead>
	<input type="hidden" name="NumLine" id="NumLine" value=""
		maxlength="20" />

	<input type="hidden" name="INVOICENO" id="INVOICENO" class="inputbox"
		value="<?=$INVOICENO?>" />
	<input type="hidden" name="PONUMBER" id="PONUMBER" class="inputbox"
		value="<?=$PONUMBER?>" />


<input type="hidden" value="<?=$TotalAmountSED?>" class="textbox" id="TotalAmountSED" name="TotalAmountSED">

</table>

<table width="41%" id="myTable" class="order-list" cellpadding="0"
	cellspacing="1" style="display: none">


	<tbody>

	</tbody>
	<tfoot>

		<tr class='itembg'>
			<td colspan="11" align="right"></td>
		</tr>
	</tfoot>

</table>


<table>

	<tr>
		<td align="center"><input name="Submit" type="submit" class="button"
			id="SubmitButton" value="Submit"></td>

		<td align="center"><input name="Preview" type="submit" class="button"
			id="Preview" value="Rate Quote"></td>

	</tr>

</table>
