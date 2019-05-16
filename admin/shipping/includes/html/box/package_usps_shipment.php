<?php 

//echo "<pre>";print_r($arryApiACDetails);

$fdAccount = $arryApiACDetails[0]['api_account_number'];

$SourceZipcode = $arryApiACDetails[0]['SourceZipcode'];

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
						<td colspan="4" align="left" class="head">Shipping Carrier Details</td>
					</tr>

			

					<tr>
						<td align="right" class="blackbold" width="20%">Shipping Method :<span
							class="red">*</span></td>
						<td align="left" width="30%"><select name="ShippingMethod" size="1"
							id="ShippingMethod" class="inputbox">
							<option value="">Select</option>
							<?php foreach($arrayUSPSService as $USPSService){?>
							<option value="<?=$USPSService['service_value'];?>"
							<?php if($ShippingMethod== $USPSService['service_value']){ echo "selected='selected'";}?>><?=$USPSService['service_type'];?></option>
							<?php }?>
						</select></td>
					 
						<td align="right" class="blackbold" width="20%">First Class Mail Type:<span
							class="red">*</span></td>
						<td align="left">
						<select name="FirstClassMailType"
							class="inputbox" id="FirstClassMailType">
						<option value="">Select</option>
						<?php foreach($arrayUspsMailType as $MailType){?>
						<option value="<?=$MailType['mail_type_value'];?>"
						<?=($FirstClassMailType==$MailType['mail_type_value'])?('selected'):('')?>><?=$MailType['mail_type'];?>
						</option>
							<?php }?>
							
						</select>
						</td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Package Size:<span
							class="red">*</span></td>
						<td align="left">
							<select name="PackageSize"
								class="inputbox" id="PackageSize">
                                                <option value="">Select</option>
						<?php foreach($arrayUspsPackageSize as $PackageSizeType){?>
						<option value="<?=$PackageSizeType['pack_size_value'];?>"
						<?=($PackageSize==$PackageSizeType['pack_size_value'])?('selected'):('')?>><?=$PackageSizeType['pack_size_type'];?>
						</option>
						<?php }?>
							</select>
							
						</td>
					
<?php if(sizeof($MultilpleShipAccountDetail)>0){?>
		<td align="right" class="blackbold">Shipping Account :</td>
		<td align="left"><select name="ShipAccountNumber" class="inputbox"
			id="ShipAccountNumber">
			 
			<?php foreach ($MultilpleShipAccountDetail as $shipAccount){?>
			
			<option value="<?=$shipAccount['api_account_number'];?>" <?php if($ShipAccountNumber == $shipAccount['api_account_number']){echo "selected";}?>><?=$shipAccount['api_account_number'];?></option>
			
			<?php } ?>
		</select></td>
	 
		<?php } ?>


						
					 
				</tr>

					<tr>

<td align="right" class="blackbold">Account Type :<span
							class="red">*</span></td>
						<td align="left"><select name="AccountType" class="inputbox"
							id="AccountType" onchange="masterDetail()">
							<option value="">Select</option>
							<option value="1"
							<?php if($AccountType=='1'){ echo "selected='selected'";}?>>Customer</option>
							<option value="2"
							<?php if($AccountType=='2'){ echo "selected='selected'";}?>>Shipper</option>
							<option value="3"
							<?php if($AccountType=='3'){ echo "selected='selected'";}?>>Third
							Party</option>
						</select></td>


						<td align="right" class="blackbold">Account Number :<span
							class="red">*</span></td>
						<td align="left">
<input name="AccountNumber" type="text" class="inputbox" id="AccountNumber" value="<?=$AccountNumber?>" maxlength="50"  <?=($AccountType=='1' && !empty($CustAccountNumber) && $CustAccountNumber!='ADD' )?('style="display:none"'):('')?>>

<label for="SaveCustAccount" id="SaveCustAccountLabel" <?=(!empty($CustID) && $AccountType=='1' && $CustAccountNumber=="ADD")?(''):('style="display:none"')?>>&nbsp;&nbsp;<input type="checkbox" name="SaveCustAccount" id="SaveCustAccount" value="1" style="vertical-align: middle;" <?=($AccountType=='1' && $CustAccountNumber=="ADD" && $SaveCustAccount=="1")?('Checked'):('')?>>&nbsp;Save</label>


 
<select name="CustAccountNumber" id="CustAccountNumber" class="inputbox" onchange="SetCustAccount()"  <?=(($AccountType=='1' && !empty($CustAccountNumber) && $CustAccountNumber!='ADD')?(''):('style="display:none"'))?>>
<?php 
$DefaultCustAccount='';
if(!empty($arryCustAccount)){
	foreach($arryCustAccount as $cAccount){ 
		if($cAccount['defaultVal']=="1"){
			$DefaultCustAccount=$cAccount['api_account_number'];
		}
?>
	<option value="<?=$cAccount['api_account_number'];?>" <?php if($CustAccountNumber == $cAccount['api_account_number']){echo "selected";}?>><?=$cAccount['api_account_number'];?></option>
<?php }}else{ echo '<option value="0"></option>';}

	echo '<option value="ADD">Add New</option>';
 ?>
</select>

</td>
					
						
					 
					</tr>



 


					<tr>
<td align="right" class="blackbold">Master Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="SourceZipcode" type="text"
							id="SourceZipcode"
							value="<?=$SourceZipcode?>"
							maxlength="30" onkeypress="return isDecimalKey(event);" 
							class="inputbox"></td>


						<td align="right" class="blackbold">Destination Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="DestinationZipcode" type="text"
							id="DestinationZipcode" class="inputbox"
							value="<?php if(!empty($_POST['DestinationZipcode'])){echo $_POST['DestinationZipcode'];}?>"
							maxlength="30" onkeypress="return isDecimalKey(event);" 
							></td>
					 
						
					</tr>


				  	<tr>
		<td align="right"  class="blackbold">No Of Packages:<span
							class="red">*</span></td>
						<td align="left"><select name="NoOfPackages" class="inputbox"
							id="NoOfPackages" onchange="addRows();">
						
							<?php
							for($i=1;$i<=25;$i++){?>

							<option value="<?=$i?>"
							<?=($NoOfPackages==$i)?('selected'):('')?>><?=$i?></option>
							<?php } ?>
						</select></td>

					<td align="right" class="blackbold">Weight :<span class="red">*</span></td>
					<td align="left"><input type="text" class="inputbox" id="Weight"
						name="Weight" value="<?php if(!empty($_POST['Weight'])){echo $_POST['Weight'];}?>" size="10" maxlength="10"
						onkeypress="return isDecimalKey(event);" placeholder="Weight In Gram"></td>
					</tr>


					<tr
					<?php if($packageType== "YOUR_PACKAGING"){ echo 'style="display: none;"';}?>
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


					<!--tr>

						<td align="right" class="blackbold">Shipmaster Label</td>
						<td align="left"><input type="checkbox" name="uspsLabel"
							value="Yes"<?=($uspsLabel=='Yes')?('checked'):('')?> ></td>
					</tr-->





					<tr id="CODTR">
						<td align="right" class="blackbold"><strong>Generate COD Label:</strong></td>
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
							id="fdAccount"
							value="<?= $arryApiACDetails[0]["api_account_number"];?>"></td>
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

	<input type="hidden" name="DefaultCustAccount" id="DefaultCustAccount" class="inputbox"
		value="<?=$DefaultCustAccount?>" readonly />

	<input type="hidden" name="CustID" id="CustID" class="inputbox"
		value="<?=$CustID?>" readonly />

	<input type="hidden" name="MasterZipcode" id="MasterZipcode" class="inputbox"
		value="<?=$SourceZipcode?>" readonly />
 

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
