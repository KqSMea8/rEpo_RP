<tr>
	<td colspan="2"  align="left" class="head">Vendor Information</td>
	</tr>

	<tr>
	<td align="right" width="45%" class="blackbold" > Vendor Code : </td>
	<td align="left" >
	<input name="SuppCode" type="text" readonly class="disabled" style="width:90px;" id="SuppCode" value="<?php if(isset($arrySupplier[0]['SuppCode'])) echo stripslashes($arrySupplier[0]['SuppCode']); ?>" maxlength="40" readonly />
	<a class="fancybox fancybox.iframe" href="SuppList.php" ><?= $search ?></a>
	</td>
	</tr>


	<tr>
	<td align="right" class="blackbold" > Company Name : </td>
	<td align="left" >
	<input name="SuppCompany" type="text" readonly class="disabled"  id="SuppCompany" value="<?php if(isset($arrySupplier[0]['CompanyName'])) echo stripslashes($arrySupplier[0]['CompanyName']); ?>" maxlength="50" onkeypress="return isCharKey(event);"/> </td>
	</tr>
	<tr style="display: none;">
	<td align="right" class="blackbold" > Contact Name : </td>
	<td align="left" >
	<input name="SuppContact" type="text" readonly  class="inputbox" id="SuppContact" value="<?php if(isset($arrySupplier[0]['SuppContact'])) echo stripslashes($arrySupplier[0]['SuppContact']); ?>" maxlength="30" onkeypress="return isCharKey(event);"/> </td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > City  : </td>
	<td   align="left" >
	<input name="City" type="text" readonly class="disabled"  id="City" value="<?php if(isset($arrySupplier[0]['City'])) echo stripslashes($arrySupplier[0]['City']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > State  : </td>
	<td   align="left" >
	<input name="State" type="text" readonly class="disabled"  id="State" value="<?php if(isset($arrySupplier[0]['State'])) echo stripslashes($arrySupplier[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > Country  : </td>
	<td   align="left" >
	<input name="Country" type="text"  readonly class="disabled" id="Country" value="<?php if(isset($arrySupplier[0]['Country'])) echo stripslashes($arrySupplier[0]['Country']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > Zip Code  : </td>
	<td   align="left" >
	<input name="ZipCode" type="text" readonly class="disabled" id="ZipCode" value="<?php if(isset($arrySupplier[0]['ZipCode']))  echo stripslashes($arrySupplier[0]['ZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
	</td>
	</tr>
