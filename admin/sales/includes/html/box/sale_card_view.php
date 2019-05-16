<table id="CreditCardInfo"  width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 <tr>
	 <td colspan="4" align="left" class="head">Credit Card Information</td>
</tr>
<tr>
				<td align="right" class="blackbold" width="20%">Card Type :
				</td>
				<td align="left" width="30%">
<?
echo '<img class="help" title="'.stripslashes($arryCard[0]['CardType']).'" src="../icons/'.strtolower($arryCard[0]['CardType']).'.png">';
?>
 
 
			</td>
			 
				<td align="right" class="blackbold" width="20%">Card Number :</td>
				<td align="left">

<?


if(!empty($arryCard[0]["CardNumber"])){	
	 /*
	$arryCardNumber = explode("-",$arryCard[0]["CardNumber"]);

	if($arryCard[0]['CardType']=="Amex"){
		$CreditCardNumber = 'xxxx-xxxxxx-'.$arryCardNumber[2];
	}else{
		$CreditCardNumber = 'xxxx-xxxx-xxxx-'.$arryCardNumber[3];
	}*/

	$CreditCardNumber = CreditCardNoX($arryCard[0]["CardNumber"],$arryCard[0]["CardType"]);
}

?>
<?=$CreditCardNumber?>


</td>
	</tr>

	<tr>
				<td align="right" class="blackbold" valign="top" >Card Expiry :</td>
				<td align="left" valign="top">
<?=stripslashes($arryCard[0]['ExpiryMonth'])?> - <?=stripslashes($arryCard[0]['ExpiryYear'])?>
 
 <?=CheckCardExpiry($arryCard[0]["ExpiryMonth"], $arryCard[0]["ExpiryYear"]);?>
 
			 </td>
			 
				<td align="right" class="blackbold">Security Code : </td>
                                        <td align="left">
  xxx

 
                                
                                </td>
			</tr>
			
			<tr>
				<td align="right" class="blackbold">Card Holder Name : </td>
				<td align="left">
<?=stripslashes($arryCard[0]['CardHolderName'])?>
				 </td>

				<td align="right" class="blackbold" >Address : </td>
				<td align="left">
<?=stripslashes($arryCard[0]['Address'])?>
				</td>


			</tr>

			<tr>
				<td align="right" class="blackbold">Country Code : </td>
				<td align="left">
<?=stripslashes($arryCard[0]['Country'])?>
				 </td>

				<td align="right" class="blackbold">State : </td>
				<td align="left">
<?=stripslashes($arryCard[0]['State'])?>
				</td>


			</tr>

		<tr>
				<td align="right" class="blackbold">City : </td>
				<td align="left">
<?=stripslashes($arryCard[0]['City'])?>
				 </td>

				<td align="right" class="blackbold">Zip Code : </td>
				<td align="left">
<?=stripslashes($arryCard[0]['ZipCode'])?>
				</td>


			</tr>

 <tr>
	 <td colspan="4" ><? include($BoxPrefix."includes/html/box/sale_card_transaction.php"); ?></td>
</tr>
</table>
