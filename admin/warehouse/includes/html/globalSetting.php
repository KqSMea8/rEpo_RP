<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm)
{
	if(//ValidateForSimpleBlank(form1.FedExAccount, "FedEx Account Number")
			//&& ValidateForSimpleBlank(form1.UPSAccount, "UPS Account No")
			//&& ValidateForSimpleBlank(form1.DHLAccount, "DHL Account No")
			//&& ValidateForSimpleBlank(form1.USPSAccount, "USPS Account No")
			ValidateForSimpleBlank(form1.SourceZipcode, "Master Zipcode")
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

<div class="had">Shipping Accounts</div>
<table cellspacing="0" cellpadding="0" width="100%" border="0"
	align="center">
	<tbody>
		<tr>
			<td valign="top" align="center">
			<form enctype="multipart/form-data" method="post" action=""
				name="form1" onSubmit="return validateForm(this);">
			<table cellspacing="0" cellpadding="0" width="100%" border="0">
				<tbody>
                   <tr>
                        <td align="center" class="message">
                            <?php if ($_SESSION['mess_warehouse_global_setting'] != "") { ?><?= $_SESSION['mess_warehouse_global_setting'];
                               unset($_SESSION['mess_warehouse_global_setting']); ?><?php } ?>
                        </td>
                    </tr>
                    
					<tr>
						<td valign="middle" align="center">

						<table cellspacing="0" cellpadding="0" width="100%" border="0"
							class="borderall">

							<tbody>
								<tr>
									<td valign="top" align="center">

									<table cellspacing="1" cellpadding="5" width="100%" border="0">
										<tbody>

											<tr>
												<td width="30%" valign="top" align="right" class="blackbold">
												FedEx Account No: </td>

												<td width="56%" valign="top" align="left"><input type="text"
													value="<?= $arryApiACDetail[0]["FedExAccount"];?>" class="inputbox" id="FedExAccount"
													name="FedExAccount"
													onkeypress="return isDecimalKey(event);" maxlength="10"></td>
											</tr>



											<tr>
												<td width="30%" valign="top" align="right" class="blackbold">
												UPS Account No: </td>

												<td width="56%" valign="top" align="left"><input type="text"
													value="<?= $arryApiACDetail[0]["UPSAccount"];?>" class="inputbox" id="UPSAccount" name="UPSAccount"
													 maxlength="6"></td>
											</tr>


											<tr>
												<td width="30%" valign="top" align="right" class="blackbold">
												DHL Account No: </td>

												<td width="56%" valign="top" align="left"><input type="text"
													value="<?= $arryApiACDetail[0]["DHLAccount"];?>" class="inputbox" id="DHLAccount"
													name="DHLAccount" onkeypress="return isDecimalKey(event);"
													maxlength="10"></td>
											</tr>


											<tr>
												<td width="30%" valign="top" align="right" class="blackbold">
												USPS Account No: </td>

												<td width="56%" valign="top" align="left"><input type="text"
													value="<?= $arryApiACDetail[0]["USPSAccount"];?>" class="inputbox" id="USPSAccount"
													name="USPSAccount" onkeypress="return isDecimalKey(event);"
													maxlength="10"></td>
											</tr>

											<tr>
												<td width="30%" valign="top" align="right" class="blackbold">
												Master Zipcode:<span class="red">*</span></td>

												<td width="56%" valign="top" align="left"><input type="text"
													value="<?= $arryApiACDetail[0]["SourceZipcode"];?>" class="inputbox" id="SourceZipcode"
													name="SourceZipcode"
													onkeypress="return isDecimalKey(event);" maxlength="10"></td>
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
						<td valign="top" height="135" align="center"><br>
						<input type="submit" value="Save" id="Submit"
							class="button" name="Submit"></td>
					</tr>

				</tbody>
			</table>
			</form>
			</td>
		</tr>

	</tbody>
</table>
