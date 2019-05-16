<?
if(empty($arryCard[0]['CardType']) && empty($arryCard[0]["CardNumber"])){
	$arryCard = $objConfigure->GetDefaultArrayValue('s_order_card');
}

 
$CardInfoDisplay = 'style="display:none;"';
if(!empty($arryCard[0]['CardType'])){
	$CardInfoDisplay = '';
} 
 

?>
<table id="CreditCardInfo2"  width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" <?=$CardInfoDisplay?> >
 <tr>
	 <td colspan="4" align="left" class="head">Credit Card Information</td>
</tr>
<tr>
				<td align="right" class="blackbold" width="20%">Card Type :
				</td>
				<td align="left" width="30%">
<input type="text" name="CreditCardType2" maxlength="30" readonly class="disabled_inputbox" id="CreditCardType2" value="<?=stripslashes($arryCard[0]['CardType'])?>">
 
			</td>
			 
				<td align="right" class="blackbold" width="20%">Card Number :</td>
				<td align="left">

<?
$CreditCardNumber='';
if(!empty($arryCard[0]["CardNumber"])){	
	/*$arryCardNumber = explode("-",$arryCard[0]["CardNumber"]);

	if($arryCard[0]['CardType']=="Amex"){
		$CreditCardNumber = 'xxxx-xxxxxx-'.$arryCardNumber[2];
	}else{
		$CreditCardNumber = 'xxxx-xxxx-xxxx-'.$arryCardNumber[3];
	}*/

	$CreditCardNumber = CreditCardNoX($arryCard[0]["CardNumber"],$arryCard[0]["CardType"]);
}
?>
<input type="text" name="CreditCardNumberTemp2" maxlength="30" readonly class="disabled_inputbox" id="CreditCardNumberTemp2" value="<?=$CreditCardNumber?>">

<input type="hidden" name="CreditCardNumber2" maxlength="30" readonly class="disabled_inputbox" id="CreditCardNumber2" value="<?=stripslashes($arryCard[0]['CardNumber'])?>">

<input type="hidden" name="CreditCardID2" maxlength="10" readonly id="CreditCardID2" value="<?=stripslashes($arryCard[0]['CardID'])?>">

</td>
	</tr>

	<tr>
				<td align="right" class="blackbold" >Card Expiry :</td>
				<td align="left">
<input type="text" name="CreditExpiryMonth2" maxlength="4" style="width:15px;" readonly class="disabled" id="CreditExpiryMonth2" value="<?=stripslashes($arryCard[0]['ExpiryMonth'])?>"> -
<input type="text" name="CreditExpiryYear2" maxlength="4"  style="width:40px;"  readonly class="disabled" id="CreditExpiryYear2" value="<?=stripslashes($arryCard[0]['ExpiryYear'])?>">

 <?=CheckCardExpiry($arryCard[0]["ExpiryMonth"], $arryCard[0]["ExpiryYear"]);?>
		 </td>
			 
				<td align="right" class="blackbold">Security Code : </td>
                                        <td align="left">
<input type="Password" name="CreditSecurityCode2" maxlength="4" size="2" readonly class="disabled" id="CreditSecurityCode2" value="<?=stripslashes($arryCard[0]['SecurityCode'])?>">

 
                                
                                </td>
			</tr>
			
			<tr>
				<td align="right" class="blackbold">Card Holder Name : </td>
				<td align="left">
<input type="text" name="CreditCardHolderName2" maxlength="30" readonly class="disabled_inputbox" id="CreditCardHolderName2" value="<?=stripslashes($arryCard[0]['CardHolderName'])?>">
				 </td>

				<td align="right" class="blackbold">Address : </td>
				<td align="left">
<input type="text" name="CreditAddress2" maxlength="200" readonly class="disabled_inputbox" id="CreditAddress2" value="<?=stripslashes($arryCard[0]['Address'])?>">
				</td>


			</tr>

			<tr>
				<td align="right" class="blackbold">Country Code : </td>
				<td align="left">
<input type="text" name="CreditCountry2" maxlength="10" readonly class="disabled_inputbox" id="CreditCountry2" value="<?=stripslashes($arryCard[0]['Country'])?>">
				 </td>

				<td align="right" class="blackbold">State : </td>
				<td align="left">
<input type="text" name="CreditState2" maxlength="30" readonly class="disabled_inputbox" id="CreditState2" value="<?=stripslashes($arryCard[0]['State'])?>">
				</td>


			</tr>

		<tr>
				<td align="right" class="blackbold">City : </td>
				<td align="left">
<input type="text" name="CreditCity2" maxlength="30" readonly class="disabled_inputbox" id="CreditCity2" value="<?=stripslashes($arryCard[0]['City'])?>">
				 </td>

				<td align="right" class="blackbold">Zip Code : </td>
				<td align="left">
<input type="text" name="CreditZipCode2" maxlength="30" readonly class="disabled_inputbox" id="CreditZipCode2" value="<?=stripslashes($arryCard[0]['ZipCode'])?>">
				</td>


			</tr>

	 <tr>
	 <td colspan="4" ><? include($BoxPrefix."includes/html/box/sale_card_transaction.php"); ?></td>
</tr>
	
</table>
