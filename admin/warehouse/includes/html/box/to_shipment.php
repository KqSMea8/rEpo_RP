<h3>To</h3>
<div>
<p>

<table cellspacing="0" cellpadding="5" border="0">
	<tbody>



		<tr>
			<td align="right" class="blackbold">Saved Receiver :</td>
			<td align="left"><select class="textbox" name="ShippingToData"
				id="ShippingToData">
				<option value="">--- Select ---</option>
				<?php

				foreach($arryAddBookShTo as $addshipToValue){?>

				<option value="<?php echo $addshipToValue['adbID'];?>"
				<?php if($ShippingToData== $addshipToValue['adbID']){ echo "selected = 'selected'";}?>><?php echo $addshipToValue['ContactName'];?>,<?php echo $addshipToValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td align="right" class="blackbold">Country :</td>
			<td align="left"><select name="CountryCgTo" class="inputbox"
				id="CountryCgTo">
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
				<option value="<?=$arryCountry[$i]['code']?>"
				<?php if(!empty($CountryCgTo) &&  $CountryCgTo== $arryCountry[$i]['code']){ echo "selected = 'selected'";}?>><?=$arryCountry[$i]['name']?></option>
				<? } ?>
			</select></td>
		</tr>




		<tr>
			<td align="right" class="blackbold" style="display: none">Country :</td>
			<td align="left" style="display: none"><input type="text"
				maxlength="30" value="<?=$CountryTo?>" id="CountryTo"
				class="inputbox" name="CountryTo"></td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="40"
				value="<?=$CompanyTo?>" id="CompanyTo" class="inputbox"
				name="CompanyTo"></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">First Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$FirstnameTo?>" id="FirstnameTo" class="inputbox"
				name="FirstnameTo"></td>

			<td align="right" class="blackbold">Last Name :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$LastnameTo?>" id="LastnameTo" class="inputbox"
				name="LastnameTo"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$ContactNameTo?>" id="ContactNameTo" class="inputbox"
				name="ContactNameTo"></td>

			<td align="right" class="blackbold">Address1 :</td>
			<td align="left"><textarea name="Address1To" type="text"
				maxlength="200" class="textarea" id="Address1To"
				style="height: 30px;"><?=$Address1To?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$ZipTo?>" id="ZipTo" class="inputbox" name="ZipTo"></td>

			<td align="right" class="blackbold">Address2 :</td>
			<td align="left"><textarea name="Address2To" type="text"
				maxlength="200" class="textarea" id="Address2To"
				style="height: 30px;"><?=$Address2To?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$CityTo?>" id="CityTo" class="inputbox" name="CityTo"></td>

			<td align="right" class="blackbold">State :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$StateTo?>" id="StateTo" class="inputbox" name="StateTo"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone No :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$PhoneNoTo?>" id="PhoneNoTo" class="inputbox"
				name="PhoneNoTo"></td>

			<td align="right" class="blackbold">Department :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$DepartmentTo?>" id="DepartmentTo" class="inputbox"
				name="DepartmentTo"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Save in Address Book :</td>
			<td align="left"><input type="checkbox" maxlength="10" value="Yes"
				id="SaveinAddressbookTo" class="inputbox" name="SaveinAddressbookTo"
				style="width: 10%;"></td>

			<td align="right" class="blackbold">Fax No :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$FaxNoTo?>" id="FaxNoTo" class="inputbox" name="FaxNoTo"></td>
		</tr>



	</tbody>
</table>

</p>
</div>