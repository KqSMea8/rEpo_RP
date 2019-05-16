<?
if($_GET['type']=='UPS'){ //UPS
	$MeterLable = 'Account Number';
	$Username = 'Username';
}else{ //Fedex
	$MeterLable = 'Meter Number';
	$Username = 'Account Number';
}


if($_GET['type']=='DHL'){ //DHL
 	$ApiKeyLable = 'Site ID';
	$HideMeter = 'Style="display:none"';
}else{ //Other
	$ApiKeyLable = 'API Key';
	$HideMeter ='';
}

?>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm)
{
	var editVal =  $('#ProviderID').val();
	var AcNum = $('#api_account_number').val();
	var DataExist=0;
	
	if(ValidateForSimpleBlank(form1.api_account_number, "Account Number Or User Name")
			&& ValidateForSelect(form1.SourceZipcode, "Master Zip Code")
			//&& ValidateForSimpleBlank(form1.api_account_number, "Account Number")
			
	)
		{

		if(AcNum!=''){
			DataExist = CheckExistingData("isRecordExists.php","&AccountNumber="+escape(AcNum)+"&editID="+editVal,"api_account_number","Account Number");
			if(DataExist==1)return false;
		}


		
	

		ShowHideLoader('1','S');
		return true;	

	}
	else
		{
		return false;	
	}	
	
}

function AccountChk(){
	var editVal =  $('#ProviderID').val();
	var AccountNum = $('#api_account_number').val();
	$.ajax({
		type: "GET",
		url: "isRecordExists.php",
		data: "AccountNumber="+ AccountNum+"&editID="+ editVal ,
		success: function(html){

		if(html==1){
			 $("#disp").html('<span class="redmsg">Already exist</span>');
		}else{
			
		  $("#disp").html('<span class="greenmsg">Available!</span>');
			
		}

	}

		
		});
}



</script>


<div class="back"><a class="back" href="javascript:history.go(-1)">Back</a></div>
<div class="had"><?=$MainModuleName;?> &raquo; <span><?=$Action;?></span>
&raquo; <span><?=$ActionType;?></span></div>

<?php if(!empty($_SESSION['mess_ship_msg'])){ ?>
	<div class="message" align="center"><?php if(!empty($_SESSION['mess_ship_msg'])){echo $_SESSION['mess_ship_msg'];unset($_SESSION['mess_ship_msg']);unset($_SESSION['mess_ship_msg']);}?></div>
	
<? }else{?>
<div class="message" align="center"><?php if(!empty($_SESSION['mess_ship_account'])){echo $_SESSION['mess_ship_account'];unset($_SESSION['mess_ship_account']);unset($_SESSION['mess_ship_account']);}?></div>
<? } ?>
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
									<td align="right" valign="top" class="blackbold"><?=$Username?>:<span
										class="red">*</span></td>
									<td valign="top" align="left"><input type="text"
										name="api_account_number" class="inputbox" maxlength="50"
										id="api_account_number"
										value="<?php echo stripslashes($ShipAcoountDetails[0]['api_account_number']);?>"
										onblur="AccountChk()">

									<div id="disp"></div>

									</td>

									<td valign="top" align="right" class="blackbold">Password:</td>
									<td valign="top" align="left"><input type="text"
										name="api_password" class="inputbox" maxlength="50"
										id="api_password"
										value="<?php echo stripslashes($ShipAcoountDetails[0]['api_password']);?>"></td>
								</tr>


								<tr>


									<td align="right" class="blackbold"><?=$ApiKeyLable?>:</td>
									<td valign="top" align="left"><input type="text" name="api_key"
										class="inputbox" maxlength="50" id="api_key"
										value="<?php echo stripslashes($ShipAcoountDetails[0]['api_key']);?>"></td>



 	<td align="right" class="blackbold" <?=$HideMeter?>><?=$MeterLable?>:</td>
	 	<td valign="top" align="left" <?=$HideMeter?>><input type="text"
										name="api_meter_number" class="inputbox" maxlength="50"
										id="api_meter_number"
										value="<?php echo stripslashes($ShipAcoountDetails[0]['api_meter_number']);?>"></td>
								</tr>

								<tr>


									<td align="right" class="blackbold">Master Zipcode:<span
										class="red">*</span></td>
									<td valign="top" align="left"><input type="text"
										name="SourceZipcode" class="inputbox" maxlength="12"
										id="SourceZipcode"
										value="<?php echo stripslashes($ShipAcoountDetails[0]['SourceZipcode']);?>"></td>


									<td class="blackbold" align="right">Default Ship Account:</td>
									<td align="left"><input value="1" id="defaultVal"
										name="defaultVal" type="checkbox"
										<?php if($ShipAcoountDetails[0]['defaultVal']==1){echo 'checked';}?>>

									</td>

								</tr>

								<tr>

									 <td  align="right" class="blackbold">Vendor :</td>
									        <td   align="left">		
										<select name="SuppCode" class="inputbox" id="SuppCode" >
											  	<option value="">--- Select ---</option>
												<? for($i=0;$i<sizeof($arryVendor);$i++) {     ?>
												 <option value="<?=$arryVendor[$i]['SuppCode']?>" <?php if($ShipAcoountDetails[0]['SuppCode'] == $arryVendor[$i]['SuppCode']){echo "selected";}?>>
												 <?=stripslashes($arryVendor[$i]["VendorName"])?></option>
													<? } ?>
											</select> 
									</td>
								
									<td>
									<input type="hidden" name="api_name" class="inputbox" maxlength="50" id="api_name" value="<?=$ActionType;?>">
									<input type="hidden" name="id" class="inputbox" maxlength="50" id="id" value="<?php echo $_GET['edit'];?>"></td>
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
			<td valign="top" align="center"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton"
				value=" <?=$ButtonTitle?> " />   <input name="Check"
				type="submit" class="button" id="SubmitButton" value="Validate" /> <input
				type="hidden" name="ProviderID" id="ProviderID"
				value="<?= $_GET['edit'] ?>" /></td>
		</tr>
		
		
		
		

	</tbody>
	</form>
</table>


