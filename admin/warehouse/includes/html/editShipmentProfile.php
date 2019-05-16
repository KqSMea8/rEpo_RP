<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm)
{
	if(ValidateForSimpleBlank(form1.Nickname, "Nickname")
			&& ValidateForSimpleBlank(form1.Company, "Company")
			&& ValidateForSimpleBlank(form1.ContactName, "Contact Name")
			&& ValidateForSelect(form1.ServiceType, "Service Type")
			&& ValidateForSelect(form1.Weight, "Weight")
			&& ValidateForSelect(form1.PackagingType, "Packaging Type")

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


<div class="had">Shipment Profiles Management</div>

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
									<td align="right" class="blackbold">Nickname:<span class="red">*</span></td>
									<td valign="top" align="left"><input type="text"
										name="Nickname" class="inputbox" maxlength="50" id="Nickname"
										value="<?php echo stripslashes($arryShipmentProfile[0]['Nickname']);?>"></td>

									<td align="right" class="blackbold">Company:<span class="red">*</span>

									</td>
									<td valign="top" align="left"><input type="text" name="Company"
										class="inputbox" maxlength="50" id="Company"
										value="<?php echo stripslashes($arryShipmentProfile[0]['Company']);?>"></td>
								</tr>

								<tr>
									<td align="right" class="blackbold">Contact name :<span
										class="red">*</span></td>
									<td valign="top" align="left"><input type="text"
										name="ContactName" class="inputbox" maxlength="50"
										id="ContactName"
										value="<?php echo stripslashes($arryShipmentProfile[0]['ContactName']);?>"></td>

									<td align="right" class="blackbold">Service type:<span
										class="red">*</span></td>
									<td valign="top" align="left"><select class="inputbox"
										id="ServiceType" size="1" name="ServiceType">
										<option value="">------------- Select -------------</option>
										<option value="">----------------------------------</option>
										<option value="FIRST_OVERNIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='FIRST_OVERNIGHT'){echo "selected";}?>>First
										Overnight</option>
										<option value="PRIORITY_OVERNIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='PRIORITY_OVERNIGHT'){echo "selected";}?>>Priority
										Overnight</option>
										<option value="STANDARD_OVERNIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='STANDARD_OVERNIGHT'){echo "selected";}?>>FedEx
										Standard Overnight</option>

										<option value="FEDEX_2_DAY_AM"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_2_DAY_AM'){echo "selected";}?>>FedEx
										2Day AM</option>
										<option value="FEDEX_2_DAY"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_2_DAY'){echo "selected";}?>>FedEx
										2Day</option>

										<option value="FEDEX_EXPRESS_SAVER"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_EXPRESS_SAVER'){echo "selected";}?>>FedEx
										Express Saver</option>

										<option value="">----------------------------------</option>
										<option value="FEDEX_GROUND"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_GROUND'){echo "selected";}?>>FedEx
										Ground</option>
										<option value="">----------------------------------</option>
										<!--  <option value="First Overnight Freight">FedEx First Overnight Freight</option>-->

										<option value="FEDEX_FIRST_OVERNIGHT_FREIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_FIRST_OVERNIGHT_FREIGHT'){echo "selected";}?>>FedEx
										First Overnight</option>
										<option value="FEDEX_1_DAY_FREIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_1_DAY_FREIGHT'){echo "selected";}?>>FedEx
										1Day Freight</option>
										<option value="FEDEX_2_DAY_FREIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_2_DAY_FREIGHT'){echo "selected";}?>>FedEx
										2 Day Freight</option>
										<option value="FEDEX_3_DAY_FREIGHT"
										<? if($arryShipmentProfile[0]['ServiceType']=='FEDEX_3_DAY_FREIGHT'){echo "selected";}?>>FedEx
										3 Day Freight</option>

									</select></td>
								</tr>

								<tr>
									<td align="right" class="blackbold">Weight:<span class="red">*</span></td>
									<td valign="top" align="left"><select name="Weight" id="Weight"
										class="textbox">
										<option value="">---------- Select ----------</option>
										<?php
										for($i=1;$i<=20;$i++){?>

										<option value="<?=$i;?>"
										<? if($arryShipmentProfile[0]['Weight']== $i){echo "selected";}?>><?=$i;?></option>

										<?php } ?>
									</select> <select class="textbox" id="wtUnit" name="wtUnit">
										<option value="LB"
										<? if($arryShipmentProfile[0]['wtUnit']=='LB'){echo "selected";}?>>Lbs</option>
										<option value="KG"
										<? if($arryShipmentProfile[0]['wtUnit']=='KG'){echo "selected";}?>>Kg</option>
									</select></td>



									<td align="right" class="blackbold">Packaging :<span
										class="red">*</span></td>
									<td valign="top" align="left"><select class="textbox"
										id="PackagingType" size="1" name="PackagingType">
										<option value="">--------------Select--------------------</option>
										<!--  <option value="FEDEX_ENVELOPE">FedEx Envelope</option>-->
										<option value="FEDEX_PAK"
										<? if($arryShipmentProfile[0]['PackagingType']== 'FEDEX_PAK'){echo "selected";}?>>FedEx
										Pak</option>
										<option value="FEDEX_BOX"
										<? if($arryShipmentProfile[0]['PackagingType']== 'FEDEX_BOX'){echo "selected";}?>>FedEx
										Box</option>
										<option value="FEDEX_TUBE"
										<? if($arryShipmentProfile[0]['PackagingType']== 'FEDEX_TUBE'){echo "selected";}?>>FedEx
										Tube</option>
										<option value="YOUR_PACKAGING"
										<? if($arryShipmentProfile[0]['PackagingType']== 'YOUR_PACKAGING'){echo "selected";}?>>Your
										Packaging</option>
									</select></td>
								</tr>

								<tr>
									<td width="20%" align="right" class="blackbold" valign="top">Package
									Discriptions:</td>
									<td width="25%" valign="top" align="left"><textarea
										name="PackageDiscriptions" type="text" class="textarea"
										id="PackageDiscriptions"><?php echo stripslashes($arryShipmentProfile[0]['PackageDiscriptions']);?></textarea></td>

									<td width="25%"></td>
									<td></td>
								</tr>


								<tr>

									<td><input type="hidden" name="profileID" class="inputbox"
										maxlength="50" id="profileID"
										value="<?php echo $_GET['edit'];?>"></td>
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
			<td valign="top" align="center"><input type="submit" value=" <?php if(empty($_GET['edit'])){echo "Submit";} else { echo "Update"; }?> "
				id="SubmitButton" class="button" name="Submit"></td>
		</tr>

	</tbody>
	</form>
</table>


