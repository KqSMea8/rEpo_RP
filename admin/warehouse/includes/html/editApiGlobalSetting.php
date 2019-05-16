<?

if($_GET['edit']==2){ //UPS
 	$MeterLable = 'Account Number';
	$Username = 'Username';
}else{ //Fedex
	$MeterLable = 'Meter Number';
	$Username = 'Account Number';
}


if($_GET['edit']==4){ //DHL
 	$ApiKeyLable = 'Site ID';
	$HideMeter = 'Style="display:none"';
}else{ //Other
	$ApiKeyLable = 'API Key';
}



?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm)
{
	if(ValidateForSimpleBlank(form1.SourceZipcode, "Master Zip Code")
			//&& ValidateForSimpleBlank(form1.api_account_number, "Account Number")

	)
		{ 
			return true;	

	}
	else
		{
		return false;	
	}	
	
}

</script>

<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>

<div class="had"><?=$MainModuleName;?> &raquo; <span>Edit</span></div>

<div class="message" align="center"><?php if(!empty($_SESSION['mess_ship_msg'])){echo $_SESSION['mess_ship_msg'];unset($_SESSION['mess_ship']);unset($_SESSION['mess_ship_msg']);}?></div>

<table cellspacing="0" cellpadding="0" width="100%" border="0"
	align="center">
	<form enctype="multipart/form-data" method="post" action=""
		name="form1" onSubmit="return validateForm(this);">
	<tbody>
		<tr>
			<td align="center">
			<table cellspacing="0" cellpadding="0" width="100%" border="0">

				<tbody>
					<tr>
						<td valign="top" align="center">

						<table cellspacing="0" cellpadding="5" width="100%" border="0"
							class="borderall">
							<tbody>
								<tr>
									<td align="left" class="head" colspan="4">Shipment Profiles</td>
								</tr>

								<tr>
									<td align="right" class="blackbold"><?=$Username?>: </td>
									<td valign="top" align="left"><input type="text"
										name="api_account_number" class="inputbox" maxlength="50"
										id="api_account_number"
										value="<?php echo stripslashes($arryShipmentProfile[0]['api_account_number']);?>"></td>

									<td align="right" class="blackbold">Password:</td>
									<td valign="top" align="left"><input type="text"
										name="api_password" class="inputbox" maxlength="50"
										id="api_password"
										value="<?php echo stripslashes($arryShipmentProfile[0]['api_password']);?>"></td>
								</tr>


								<tr>


<td align="right" class="blackbold"><?=$ApiKeyLable?>:</td>
									<td valign="top" align="left"><input type="text" name="api_key"
										class="inputbox" maxlength="50" id="api_key"
										value="<?php echo stripslashes($arryShipmentProfile[0]['api_key']);?>"></td>


									

			<td align="right" class="blackbold" <?=$HideMeter?>>


<?=$MeterLable?>:</td>
			<td valign="top" align="left" <?=$HideMeter?>><input type="text"
				name="api_meter_number" class="inputbox" maxlength="50"
				id="api_meter_number"
				value="<?php echo stripslashes($arryShipmentProfile[0]['api_meter_number']);?>"></td>
								</tr>


								<tr>
									<td align="right" class="blackbold">API Name:</td>
									<td valign="top" align="left"><input type="text"
										name="api_name" class="disabled" maxlength="50" id="api_name"
										value="<?php echo stripslashes($arryShipmentProfile[0]['api_name']);?>"
										readonly=''></td>



									<td align="right" class="blackbold">Master Zipcode:<span
										class="red">*</span></td>
									<td valign="top" align="left"><input type="text"
										name="SourceZipcode" class="inputbox" maxlength="12"
										id="SourceZipcode"
										value="<?php echo stripslashes($arryShipmentProfile[0]['SourceZipcode']);?>"></td>

								</tr>


								<tr>

									<td><input type="hidden" name="id" class="inputbox"
										maxlength="50" id="id" value="<?php echo $_GET['edit'];?>"></td>
								</tr>



							</tbody>
						</table>

						</td>
					</tr>

				</tbody>
			</table>

			</td>
		</tr>
		<tr>
			<td valign="top" align="center"><input type="submit" value="Update"
				id="SubmitButton" class="button" name="Submit"> <input name="Check"
				type="submit" class="button" id="SubmitButton" value="Validate" /> <input
				type="hidden" name="ProviderID" id="ProviderID"
				value="<?= $_GET['edit'] ?>" /></td>
		</tr>

	</tbody>
	</form>
</table>


