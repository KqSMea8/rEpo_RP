<h3>From</h3>
<div>
<p>
<table cellspacing="0" cellpadding="5" border="0">
	<tbody>


		<tr>
			<td width="20%"  align="right" class="blackbold">Saved Senders :</td>
			<td width="33%" align="left"><select class="textbox" name="ShippingFromData"
				id="ShippingFromData">
				<option value="">--- Select ---</option>
				<?php

				foreach($arryAddBookShFrom as $addshipFromValue){?>

				<option value="<?php echo $addshipFromValue['adbID'];?>"
				<?php if($ShippingFromData== $addshipFromValue['adbID']){ echo "selected = 'selected'";}?>><?php echo $addshipFromValue['ContactName'];?>,<?php echo $addshipFromValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td width="20%"  align="right" class="blackbold">Country :</td>
			<td align="left"><select name="CountryCgFrom" class="inputbox"
				id="CountryCgFrom">
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
				<option value="<?=$arryCountry[$i]['code']?>"
				<?php if(!empty($CountryCgFrom) && $CountryCgFrom == $arryCountry[$i]['code']){ echo "selected = 'selected'";}?>><?=$arryCountry[$i]['name']?></option>
				<? } ?>
			</select></td>
		</tr>


		<tr>
			<td align="right" class="blackbold" style="display: none">Country :</td>
			<td align="left" style="display: none"><input type="text"
				maxlength="15" value="<?=$CountryFrom?>" id="CountryFrom"
				class="inputbox" name="CountryFrom"></td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="40"
				value="<?=$CompanyFrom?>" id="CompanyFrom" class="inputbox"
				name="CompanyFrom"></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">First Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$FirstnameFrom?>" id="FirstnameFrom" class="inputbox"
				name="FirstnameFrom"></td>

			<td align="right" class="blackbold">Last Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$LastnameFrom?>" id="LastnameFrom" class="inputbox"
				name="LastnameFrom"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact Name :</td>
			<td align="left"><input type="text" maxlength="50"
				value="<?=$Contactname?>" id="Contactname" class="inputbox"
				name="Contactname"></td>

			<td align="right" class="blackbold">Address1 :</td>
			<td align="left"><textarea name="Address1From" type="text"
				maxlength="200" class="textarea" id="Address1From"
				style="height: 30px;"><?=$Address1From?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$ZipFrom?>" id="ZipFrom" class="inputbox" name="ZipFrom"></td>

			<td align="right" class="blackbold">Address2 :</td>
			<td align="left"><textarea name="Address2From" type="text"
				maxlength="200" class="textarea" id="Address2From"
				style="height: 30px;"><?=$Address2From?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$CityFrom?>" id="CityFrom" class="inputbox"
				name="CityFrom"></td>

			<td align="right" class="blackbold">State :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$StateFrom?>" id="StateFrom" class="inputbox"
				name="StateFrom"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone No :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$PhonenoFrom?>" id="PhonenoFrom" class="inputbox"
				name="PhonenoFrom"></td>

			<td align="right" class="blackbold">Department :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$DepartmentFrom?>" id="DepartmentFrom" class="inputbox"
				name="DepartmentFrom"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Save in Address Book :</td>
			<td align="left"><input type="checkbox" maxlength="10" value="Yes"
				id="SaveinAddressbookFrom" class="inputbox"
				name="SaveinAddressbookFrom" style="width: 10%;"></td>

			<td align="right" class="blackbold">Fax No :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$FaxnoFrom?>" id="FaxnoFrom" class="inputbox"
				name="FaxnoFrom"></td>
		</tr>



	</tbody>
</table>
</p>
</div>
