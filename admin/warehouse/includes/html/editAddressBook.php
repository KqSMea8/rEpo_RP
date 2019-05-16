
<div class="back"><a class="back" href="javascript: window.history.go(-1)">Back</a></div>

<div class="had"><?=$MainModuleName;?> &raquo; <span>Edit <?=$Type?> Address</span></div>

<form name="form1" action="" method="post"
	onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table cellspacing="0" cellpadding="5" border="0" class="borderall"
	width="100%">
	<tbody>
		<tr>
			<td align="left" colspan="4" class="head"><?//=$MainModuleName;?> &nbsp;<?=$Type?></td>
		</tr>
		<tr>
			<td align="right" class="blackbold">Country :</td>		
				
			<td align="left">
			<select id="Country" class="inputbox" name="Country">
			<?
			foreach($arryCountry as $arryCountrys){ ?>
			<option value="<?=$arryCountrys['name'];?>" <?php if($arryaddBook[0]['Country']==$arryCountrys['name']){echo "selected='selected'";}?>><?=$arryCountrys['name'];?></option>
			<? } ?>
			</select>
			</td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['Company'];?>" id="Company"
				class="inputbox" name="Company"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">First name:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['Firstname'];?>" id="Firstname"
				class="inputbox" name="Firstname"></td>

			<td align="right" class="blackbold">Last name:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['Lastname'];?>" id="Lastname"
				class="inputbox" name="Lastname"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact name:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['ContactName'];?>"
				id="ContactName" class="inputbox" name="ContactName"></td>

			<td align="right" class="blackbold">Address1:</td>
			<td align="left"><textarea name="Address1" type="text"
				class="textarea" id="Address1" style="height: 30px;"><?php echo $arryaddBook[0]['Address1'];?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['Zip'];?>" id="Zip"
				class="inputbox" name="Zip"></td>

			<td align="right" class="blackbold">Address2:</td>
			<td align="left"><textarea name="Address2" type="text"
				class="textarea" id="Address2" style="height: 30px;"><?php echo $arryaddBook[0]['Address2'];?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['City'];?>" id="City"
				class="inputbox" name="City"></td>

			<td align="right" class="blackbold">State:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['State'];?>" id="State"
				class="inputbox" name="State"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone no:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['PhoneNo'];?>" id="PhoneNo"
				class="inputbox" name="PhoneNo"></td>

			<td align="right" class="blackbold">Department:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['Department'];?>" id="Department"
				class="inputbox" name="Department"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Fax no:</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?php echo $arryaddBook[0]['FaxNo'];?>" id="FaxNo"
				class="inputbox" name="FaxNo"></td>
		</tr>


		<tr>

			<td align="left"><input type="hidden" maxlength="15"
				value="<?php echo $arryaddBook[0]['addType'];?>" id="addType"
				class="inputbox" name="addType"></td>

			<td align="left"><input type="hidden" maxlength="15"
				value="<?php echo $_GET['edit'];?>" id="adbID" class="inputbox"
				name="adbID"></td>
		</tr>



<tr>
 <td align="right" class="blackbold"> Default Address: </td>
<td align="left">
<input type="checkbox" value="1" id="defaultAddress" name="defaultAddress" <?=($arryaddBook[0]['defaultAddress']=='1')?('checked'):('')?>>
    
 </td>
</tr>


	</tbody>
</table>
<br>
<table>

	<tr>
		<td align="center"><input name="Submit" type="submit" class="button"
			id="SubmitButton" value="Submit"></td>
	</tr>

</table>


</form>

