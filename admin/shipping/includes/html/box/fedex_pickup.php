
	<table width="100%" border="0" cellpadding="5" cellspacing="0"
		class="borderall" id="pickTbl" <?php if($pickEnable != "1"){ echo 'style="display: none;"';}?>>
		<tbody>

			<tr>
				<td align="right" class="blackbold">Pickup Package Location:<span
					class="red">*</span></td>
				<td align="left"><select name="pickLocation" id="pickLocation"
					class="textbox">
						<option value="NONE" <?php if($pickLocation=='NONE'){ echo "selected='selected'";}?>>NONE</option>
						<option value="FRONT" <?php if($pickLocation=='FRONT'){ echo "selected='selected'";}?>>FRONT</option>
						<option value="REAR" <?php if($pickLocation=='REAR'){ echo "selected='selected'";}?>>REAR</option>
						<option value="FRONT" <?php if($pickLocation=='FRONT'){ echo "selected='selected'";}?>>SIDE</option>
				</select>
				</td>

				<td align="right" class="blackbold">Pickup date:<span class="red">*</span>
				</td>
				<td align="left"><?php 
				$arryTime = explode(" ",$Config['TodayDate']);
				$pickDate = $arryTime[0];

				?> <input id="pickDate" name="pickDate" readonly="" class="datebox"
					value="<?=$pickDate?>" type="text">
				</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Ready time:<span class="red">*</span>
				</td>
				<td align="left">
				<input name="pickReadyTime" type="text" class="textbox" size="7" id="pickReadyTime" value="<?=$pickReadyTime?>"  autocomplete="off"/>
				</td>

				<td align="right" class="blackbold">Close time:<span class="red">*</span>
				</td>
				<td align="left">
				<input name="pickCloseTime" type="text" class="textbox" size="7" id="pickCloseTime" value="<?=$pickCloseTime?>"  autocomplete="off"/>
				</td>
			</tr>


			<tr>
				<td align="right" class="blackbold">Courier Description:<span
					class="red">*</span></td>
				<td align="left">
						<input name="CourierRemarks" type="text" id="CourierRemarks" value="<?=$CourierRemarks?>" class="inputbox">

					</td>

				<td align="right" class="blackbold">Total weight<span class="red">*</span>
				</td>
				<td align="left"><input name="pickWeight" type="text"
					id="pickWeight" class="inputbox" value="<?=$pickWeight?>"
					maxlength="30" onkeypress="return isNumberKey(event);"> <select
					name="pickWeightUnit" id="pickWeightUnit" class="textbox">
						<option value="LB" <?php if($pickWeightUnit=='LB'){ echo "selected='selected'";}?>>LB</option>
						<option value="KG" <?php if($pickWeightUnit=='KG'){ echo "selected='selected'";}?>>KG</option>
				</select>
				</td>

			</tr>

		</tbody>
	</table>

