<?php //echo "<pre>";print_r($arryPurchase);?>
	<table width="100%" border="0" cellpadding="5" cellspacing="0"  >	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=SUPPLIER_ADDRESS?></td>
	</tr>
	<tr>
			<td  align="right"   class="blackbold" width="30%"> Vendor Code  : </td>
			<td   align="left" >
<?=stripslashes($arryPurchase[0]['SuppCode'])?>

			</td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold" > Company Name  : </td>
			<td   align="left" >
<?=stripslashes($arryPurchase[0]['SuppCompany'])?>		</td>
	</tr>


		
		<tr>
			<td  align="right"   class="blackbold" valign="top" > Address  : </td>
			<td   align="left" ><?=nl2br(stripslashes($arryPurchase[0]['Address']))?></td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold" > City  : </td>
			<td   align="left" ><?=stripslashes($arryPurchase[0]['City'])?></td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold" > State  : </td>
			<td   align="left" ><?=stripslashes($arryPurchase[0]['State'])?></td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Country  : </td>
			<td   align="left" ><?=stripslashes($arryPurchase[0]['Country'])?>		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold" > Zip Code  : </td>
			<td   align="left" ><?=stripslashes($arryPurchase[0]['ZipCode'])?>
		</td>
		  </tr>
	

	<tr>
			<td  align="right"   class="blackbold" width="40%"> Contact Name  : </td>
			<td   align="left" ><?=stripslashes($arryPurchase[0]['SuppContact'])?>         </td>
		  </tr>	

 <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left"  ><?=stripslashes($arryPurchase[0]['Mobile'])?>
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['Landline']))?(stripslashes($arryPurchase[0]['Landline'])):(NOT_SPECIFIED)?>

				</td>
	 </tr>

	<tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><?=stripslashes($arryPurchase[0]['Email'])?></td>
		  </tr>

	<!--tr>
			<td  align="right"   class="blackbold" > Currency  : </td>
			<td   align="left" >
	<B><?=stripslashes($arryPurchase[0]['SuppCurrency'])?></B>

		</td>
		  </tr-->
<?php if(!empty($TaxableBillingAp)){?>
<tr>
		<td align="right"   class="blackbold">Taxable  : </td>
		<td  align="left"><?=($arryPurchase[0]['tax_auths']=="Yes")?("Yes"):("No")?> </td>
	</tr>


<?
$arrRate = explode(":",$arryPurchase[0]['TaxRate']);
if(!empty($arrRate[0])){
	$TaxVal = $arrRate[2].' %';
	$TaxName = '[ '.$arrRate[1].' ]';

}else{
	$TaxVal = 'None';
	$TaxName = '';
}
?>

	<tr>
	<td align="right"   class="blackbold">Tax Rate  <?=$TaxName?> :</td>
	<td  align="left">  
	<?=$TaxVal?>
<input type="hidden" name="TaxRate" id="TaxRate" value="<?=$arryPurchase[0]['TaxRate']?>">
	</td>
	</tr>	
<? } ?>
		</table>
