<?
if($arryPurchase[0]['OrderType']=="Dropship"){
	$wDisplay = 'style="display:none"';
	$shipTo = 'Customer';
}else{
	$wDisplay = '';
	$shipTo = 'Warehouse';
}
?>

	<table width="100%" border="0" cellpadding="5" cellspacing="0" >	 
		<tr>
		 <td colspan="2" align="left" class="head"><?=SHIP_TO_ADDRESS?></td>
	</tr>	
	<tr>
			<td  align="right"   class="blackbold"> <span id="wCodeTitle" <?=$wDisplay?>>Warehouse Code :</span> </td>
			<td   align="left" >
<span id="wCodeVal" <?=$wDisplay?>>
	<input name="wCode" type="text" class="disabled" style="width:90px;" id="wCode" value="<?php echo stripslashes($arryPurchase[0]['wCode']); ?>"  maxlength="40" readonly />
	<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?=$search?></a>
</span>
			</td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold" > <span id="wNameTitle"><?=$shipTo?></span> Name  : </td>
			<td   align="left" >
	<input name="wName" type="text" class="inputbox" id="wName" value="<?php echo stripslashes($arryPurchase[0]['wName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		</td>
	</tr>


<tr>
			<td  align="right"   class="blackbold" valign="top" width="40%"> Address  : </td>
			<td   align="left" >
	 <textarea name="wAddress" type="text" class="textarea" id="wAddress" maxlength="200"><?=stripslashes($arryPurchase[0]['wAddress'])?></textarea>	
		</td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold"> City  : </td>
			<td   align="left" >
	<input name="wCity" type="text" class="inputbox" id="wCity" value="<?php echo stripslashes($arryPurchase[0]['wCity']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
		</td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold"> State  : </td>
			<td   align="left" >
	<input name="wState" type="text" class="inputbox" id="wState" value="<?php echo stripslashes($arryPurchase[0]['wState']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold"> Country  : </td>
			<td   align="left" >
	<input name="wCountry" type="text" class="inputbox" id="wCountry" value="<?php echo stripslashes($arryPurchase[0]['wCountry']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" />
		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold"> Zip Code  : </td>
			<td   align="left" >
	<input name="wZipCode" type="text" class="inputbox" id="wZipCode" value="<?php echo stripslashes($arryPurchase[0]['wZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
		</td>
		  </tr>
	

	<tr>
			<td  align="right"   class="blackbold"> Contact Name  : </td>
			<td   align="left" >
	<input name="wContact" type="text" class="inputbox" id="wContact" value="<?php echo stripslashes($arryPurchase[0]['wContact']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>            </td>
		  </tr>	

 <tr>
			<td align="right"   class="blackbold">Mobile  :</td>
			<td  align="left"  >
		 <input name="wMobile" type="text" class="inputbox" id="wMobile" value="<?=stripslashes($arryPurchase[0]['wMobile'])?>"     maxlength="20" />	
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
		 <input name="wLandline" type="text" class="inputbox" id="wLandline" value="<?=stripslashes($arryPurchase[0]['wLandline'])?>"  maxlength="20" />	

				</td>
	 </tr>

<tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><input name="wEmail" type="text" class="inputbox" id="wEmail" value="<?=stripslashes($arryPurchase[0]['wEmail'])?>"  maxlength="80" /> </td>
		  </tr>


	</table>	

	










