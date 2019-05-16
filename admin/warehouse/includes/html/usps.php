
<script language="JavaScript1.2" type="text/javascript">
$(document).ready(function(){
	document.getElementById('DestinationZipcode').value = window.parent.document.getElementById('shippingZipCodeFdx').value;

	document.getElementById("CompanyTo").value = window.parent.document.getElementById('ShippingCompanyTo').value;
	document.getElementById("Address1To").value = window.parent.document.getElementById('ShippingAddressTo').value;
	document.getElementById("CountryTo").value = window.parent.document.getElementById('ShippingCountryTo').value;
	document.getElementById("CityTo").value = window.parent.document.getElementById('ShippingCityTo').value;
	document.getElementById("StateTo").value = window.parent.document.getElementById('ShippingStateTo').value;
	document.getElementById("PhoneNoTo").value = window.parent.document.getElementById('ShippingMobileTo').value;
	document.getElementById("ZipTo").value = window.parent.document.getElementById('shippingZipCodeFdx').value;
	document.getElementById("FaxNoTo").value = window.parent.document.getElementById('ShippingFaxTo').value;
	document.getElementById("ContactNameTo").value = window.parent.document.getElementById('ShippingNameTo').value;
		
}); 

function validateForm(frm)
{
	    if(ValidateForSimpleBlank(form1.Weight, "Weight")
	    	    && ValidateForSelect(form1.ShippingMethod, "Shipping Method")
			//&& ValidateForSelect(form1.packageType, "Package Type")
			&& ValidateForSelect(form1.AccountType, "Account Type")
			&& ValidateForSimpleBlank(form1.AccountNumber, "Account Number")
			&& ValidateForSimpleBlank(form1.SourceZipcode, "Source Zipcode")
			&& ValidateForSimpleBlank(form1.DestinationZipcode, "Destination Zipcode")
			
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




<script type="text/javascript">

function masterDetail()
{
	var fdval = document.getElementById("fdAccount").value;
	var acVal = document.getElementById("AccountType").value;
	
	if(acVal==2)
	{
		document.getElementById('AccountNumber').value = fdval;
		document.getElementById("AccountNumber").readOnly = true;
		document.getElementById("AccountNumber").className = "disabled_inputbox";
		
	}
	else
	{
		document.getElementById('AccountNumber').value= " " ;
		document.getElementById("AccountNumber").readOnly = false;
		document.getElementById("AccountNumber").className = "inputbox";
		
	}
}


</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#ShippingFromData').change(function(){
		var FromData = $("#ShippingFromData").val();
		var addType='ShippingFrom';
		var dataString = 'action='+ addType + '&adbID='+ FromData;
		$.ajax({
			type: "POST",
			url: "isRecordExists.php",
			data: dataString,
			dataType : "JSON",
			//cache: false,
			success: function(result){
			//alert(result);
			
				 $('#CountryFrom').val(result.Country);
				 $('#CompanyFrom').val(result.Company);
				 $('#FirstnameFrom').val(result.Firstname);
				 $('#LastnameFrom').val(result.Lastname);
				 $('#Contactname').val(result.ContactName);
				 $('#Address1From').val(result.Address1);
				 $('#ZipFrom').val(result.Zip);
				 $('#Address2From').val(result.Address2);
				 $('#CityFrom').val(result.City);
				 $('#StateFrom').val(result.State);
				 $('#PhonenoFrom').val(result.PhoneNo);
				 $('#DepartmentFrom').val(result.Department);
				 $('#FaxnoFrom').val(result.FaxNo);		
			        
			}
			});
		
	});
	});


</script>



<script type="text/javascript">
$(document).ready(function() {
	$('#ShippingToData').change(function(){
		var ToData = $("#ShippingToData").val();
		var addType='ShippingTo';
		var dataString = 'action='+ addType + '&adbID='+ ToData;
		$.ajax({
			type: "POST",
			url: "isRecordExists.php",
			data: dataString,
			dataType : "JSON",
			//cache: false,
			success: function(result){
			//alert(result);
				 $('#CountryTo').val(result.Country);
				 $('#CompanyTo').val(result.Company);
				 $('#FirstnameTo').val(result.Firstname);
				 $('#LastnameTo').val(result.Lastname);
				 $('#Contactname').val(result.ContactName);
				 $('#Address1To').val(result.Address1);
				 $('#ZipTo').val(result.Zip);
				 $('#Address2To').val(result.Address2);
				 $('#CityTo').val(result.City);
				 $('#StateTo').val(result.State);
				 $('#PhonenoTo').val(result.PhoneNo);
				 $('#DepartmentTo').val(result.Department);
				 $('#FaxnoTo').val(result.FaxNo);		
			        
			}
			});
		
	});
	});


</script>


<style>
.ui-accordion-content.ui-helper-reset.ui-widget-content.ui-corner-bottom.ui-accordion-content-active
	{
	height: auto !important;
}
</style>


<link
	rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script
	src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script language="JavaScript1.2" type="text/javascript">
  $(function() {
    $("#accordion").accordion();
  });
 </script>


<form name="form1" action="" method="post"
	onSubmit="return validateForm(this);" enctype="multipart/form-data">

<div id="accordion">
<h3>From</h3>
<div>
<p><input type="hidden" name="accessNumber"
	value="<?php echo $accessNumber; ?>" /> <input type="hidden"
	name="username" value="<?php echo $username; ?>" /> <input
	type="hidden" name="password" value="<?php echo $password; ?>" />


<table cellspacing="0" cellpadding="5" border="0">
	<tbody>


		<tr>
			<td align="right" class="blackbold">Saved senders</td>
			<td align="left"><select class="textbox" id="ShippingFromData">
				<option value="">-----select----</option>
				<?php

				foreach($arryAddBookShFrom as $addshipFromValue){?>

				<option value="<?php echo $addshipFromValue['adbID'];?>"><?php echo $addshipFromValue['ContactName'];?>,<?php echo $addshipFromValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td align="right" class="blackbold">Country</td>
			<td align="left"><select name="CountryCgFrom" class="inputbox"
				id="CountryCgFrom">
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
				<option value="<?=$arryCountry[$i]['code']?>"><?=$arryCountry[$i]['name']?></option>
				<? } ?>
			</select></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">Country :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryListWareh[0]['Country'];?>" id="CountryFrom"
				class="inputbox" name="CountryFrom"></td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="CompanyFrom" class="inputbox" name="CompanyFrom"></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">First name:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="FirstnameFrom" class="inputbox" name="FirstnameFrom"></td>

			<td align="right" class="blackbold">Last name:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="LastnameFrom" class="inputbox" name="LastnameFrom"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact name:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryListWareh[0]['ContactName'];?>"
				id="Contactname" class="inputbox" name="Contactname"></td>

			<td align="right" class="blackbold">Address1:</td>
			<td align="left"><textarea name="Address1From" type="text"
				class="textarea" id="Address1From" style="height: 30px;"><?php echo $arryListWareh[0]['Address'];?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryListWareh[0]['ZipCode'];?>" id="ZipFrom"
				class="inputbox" name="ZipFrom"></td>

			<td align="right" class="blackbold">Address2:</td>
			<td align="left"><textarea name="Address2From" type="text"
				class="textarea" id="Address2From" style="height: 30px;"></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryListWareh[0]['City'];?>" id="CityFrom"
				class="inputbox" name="CityFrom"></td>

			<td align="right" class="blackbold">State:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryListWareh[0]['State'];?>" id="StateFrom"
				class="inputbox" name="StateFrom"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone no:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryListWareh[0]['phone_number'];?>"
				id="PhonenoFrom" class="inputbox" name="PhonenoFrom"></td>

			<td align="right" class="blackbold">Department:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="DepartmentFrom" class="inputbox" name="DepartmentFrom"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Save in Address book:</td>
			<td align="left"><input type="checkbox" maxlength="80" value="Yes"
				id="SaveinAddressbookFrom" class="inputbox"
				name="SaveinAddressbookFrom" style="width: 10%;"></td>

			<td align="right" class="blackbold">Fax no:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="FaxnoFrom" class="inputbox" name="FaxnoFrom"></td>
		</tr>



	</tbody>
</table>


</p>
</div>



<h3>To</h3>
<div>
<p>


<table cellspacing="0" cellpadding="5" border="0">
	<tbody>



		<tr>
			<td align="right" class="blackbold">Saved Reciver</td>
			<td align="left"><select class="textbox" id="ShippingToData">
				<option value="">-----select----</option>
				<?php

				foreach($arryAddBookShTo as $addshipToValue){?>

				<option value="<?php echo $addshipToValue['adbID'];?>"><?php echo $addshipToValue['ContactName'];?>,<?php echo $addshipToValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td align="right" class="blackbold">Country</td>
			<td align="left"><select name="CountryCgTo" class="inputbox"
				id="CountryCgTo">
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
				<option value="<?=$arryCountry[$i]['code']?>"><?=$arryCountry[$i]['name']?></option>
				<? } ?>
			</select></td>
		</tr>




		<tr>
			<td align="right" class="blackbold">Country :</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="CountryTo" class="inputbox" name="CountryTo"></td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="CompanyTo" class="inputbox" name="CompanyTo"></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">First name:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="FirstnameTo" class="inputbox" name="FirstnameTo"></td>

			<td align="right" class="blackbold">Last name:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="LastnameTo" class="inputbox" name="LastnameTo"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact name:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="ContactNameTo" class="inputbox" name="ContactNameTo"></td>

			<td align="right" class="blackbold">Address1:</td>
			<td align="left"><textarea name="Address1To" type="text"
				class="textarea" id="Address1To" style="height: 30px;"></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="ZipTo" class="inputbox" name="ZipTo"></td>

			<td align="right" class="blackbold">Address2:</td>
			<td align="left"><textarea name="Address2To" type="text"
				class="textarea" id="Address2To" style="height: 30px;"></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="CityTo" class="inputbox" name="CityTo"></td>

			<td align="right" class="blackbold">State:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="StateTo" class="inputbox" name="StateTo"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone no:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="PhoneNoTo" class="inputbox" name="PhoneNoTo"></td>

			<td align="right" class="blackbold">Department:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="DepartmentTo" class="inputbox" name="DepartmentTo"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Save in Address book:</td>
			<td align="left"><input type="checkbox" maxlength="80" value="Yes"
				id="SaveinAddressbookTo" class="inputbox" name="SaveinAddressbookTo"
				style="width: 10%;"></td>

			<td align="right" class="blackbold">Fax no:</td>
			<td align="left"><input type="text" maxlength="15" value=""
				id="FaxNoTo" class="inputbox" name="FaxNoTo"></td>
		</tr>



	</tbody>
</table>



</p>
</div>
</div>









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
						<td align="right" class="blackbold">Weight :<span class="red">*</span></td>
						<td align="left"><input type="text" class="inputbox" id="Weight"
							name="Weight" value="" size="10" maxlength="10"
							onkeypress="return isDecimalKey(event);" placeholder="Weight In Gram"></td>
					</tr>

					<tr>
						<td align="right" class="blackbold">Shipping Method :<span
							class="red">*</span></td>
						<td align="left"><select name="ShippingMethod" size="1"
							id="ShippingMethod" class="inputbox">
							<option value="">Select</option>
							<?php foreach($arrayUSPSService as $USPSService){?>
							<option value="<?=$USPSService['service_value'];?>"
							<?php if($_POST['ShippingMethod']== $USPSService['service_value']){ echo "selected='selected'";}?>><?=$USPSService['service_type'];?></option>
							<?php }?>
						</select></td>
					</tr>

					<tr>
						<td align="right" class="blackbold">First class mail type:<span
							class="red">*</span></td>
						<td align="left"><select name="FirstClassMailType"
							class="inputbox" id="FirstClassMailType">
							<option value="">Select</option>
							<option value="LETTER">LETTER</option>
							<option value="FLAT">FLAT</option>
							<option value="PARCEL">PARCEL</option>
							<option value="POSTCARD">POSTCARD</option>
							<option value="PACKAGE SERVICE">PACKAGE SERVICE</option>

						</select></td>
					</tr>
					
					
					
					<tr>
						<td align="right" class="blackbold">Package Size:<span
							class="red">*</span></td>
						<td align="left"><select name="PackageSize"
							class="inputbox" id="PackageSize">
							<option value="">Select</option>
							<option value="LARGE">LARGE</option>
							<option value="REGULAR">REGULAR</option>

						</select></td>
					</tr>
					

					<tr>
						<td align="right" class="blackbold">Account Type :<span
							class="red">*</span></td>
						<td align="left"><select name="AccountType" class="inputbox"
							id="AccountType" onchange="masterDetail()">
							<option value="">Select</option>
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
							class="inputbox" id="AccountNumber"
							value="<?php if(!empty($_POST['AccountNumber'])){echo $_POST['AccountNumber'];}?>"
							maxlength="30" onkeypress="return isDecimalKey(event);"></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Master Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="SourceZipcode" type="text"
							id="SourceZipcode"
							value="<?= $arryApiACDetails[0]["SourceZipcode"];?>"
							maxlength="30" onkeypress="return isDecimalKey(event);" 
							class="disabled_inputbox"></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Destination Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="DestinationZipcode" type="text"
							id="DestinationZipcode" class="inputbox"
							value="<?php if(!empty($_POST['DestinationZipcode'])){echo $_POST['DestinationZipcode'];}?>"
							maxlength="30" onkeypress="return isDecimalKey(event);" 
							></td>
					</tr>




					<tr>

						<td align="right" class="blackbold">Shipmaster Label</td>
						<td align="left"><input type="checkbox" name="fedexLabel"
							value="Yes"></td>
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

		<input name="Action" type="hidden"
			id="Action" value="<?php echo $_GET['sp'];?>">

	</tbody>


</table>



<table>

	<tr>
		<td align="center"><input name="Submit" type="submit" class="button"
			id="SubmitButton" value="Submit"></td>
			
			<td align="center"><input name="Preview" type="submit" class="button"
			id="Preview" value="Preview"></td>
	</tr>

</table>


</form>

