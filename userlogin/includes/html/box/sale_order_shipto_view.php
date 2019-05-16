<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=CUSTOMER_SHIPPING_ADDRESS?></td>
	</tr>

        <tr style="display:none">
			<td  align="right"   class="blackbold" > Shipping Name  : </td>
			<td   align="left">
	        <?php echo stripslashes($arrySale[0]['ShippingName']); ?></td>
		  </tr>	
	   <tr>
			<td  align="right"   class="blackbold" width="40%"> Company Name  : </td>
			<td   align="left">
	        <?php echo stripslashes($arrySale[0]['ShippingCompany']); ?>          
		</td>
	  </tr>
	  <tr>
			<td  align="right"   class="blackbold" valign="top" > Address   : </td>
			<td   align="left">
	      <?=stripslashes($arrySale[0]['ShippingAddress'])?>
		</td>
	  </tr>
	 

	<tr>
			<td  align="right"   class="blackbold" > City  : </td>
			<td   align="left">
	      <?php echo stripslashes($arrySale[0]['ShippingCity']); ?>
		</td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold" > State  : </td>
			<td   align="left">
	       <?php echo stripslashes($arrySale[0]['ShippingState']); ?>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Country  : </td>
			<td   align="left">
	        <?php echo stripslashes($arrySale[0]['ShippingCountry']); ?>
		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold" > Zip Code  : </td>
			<td   align="left">
	      <?php echo stripslashes($arrySale[0]['ShippingZipCode']); ?>
		 </td>
		  </tr>
	

        <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left">
		   <?=stripslashes($arrySale[0]['ShippingMobile'])?>
		 </td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left">
		      <?=stripslashes($arrySale[0]['ShippingLandline'])?>
			</td>
	 </tr>

	   <tr>
			<td align="right"   class="blackbold">Fax  : </td>
			<td  align="left"><?=stripslashes($arrySale[0]['ShippingFax'])?> </td>
		  </tr>

	     <tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><?=stripslashes($arrySale[0]['ShippingEmail'])?></td>
		  </tr>
	<? if($arrySale[0]['Reseller']=='Yes' && !empty($arrySale[0]['ResellerNo'])){ ?>
	 <tr>
			<td align="right"   class="blackbold">Reseller No  : </td>
			<td  align="left" ><?=stripslashes($arrySale[0]['ResellerNo'])?></td>
		  </tr>
	<? } ?>

	<tr>
		<td align="right"   class="blackbold">Taxable  : </td>
		<td  align="left"><?=($arrySale[0]['tax_auths']=="Yes")?("Yes"):("No")?> </td>
	</tr>



<?
$arrRate = explode(":",$arrySale[0]['TaxRate']);
if(!empty($arrRate[0])){
	$TaxVal = $arrRate[2].' %';
	$TaxName = '[ '.$arrRate[1].' ]';

}else{
	$TaxVal = 'None';
}
?>

	<tr>
	<td align="right"   class="blackbold">Tax Rate  <?=$TaxName?> :</td>
	<td  align="left">  
	<?=$TaxVal?>
<input type="hidden" name="TaxRate" id="TaxRate" value="<?=$arrySale[0]['TaxRate']?>">
	</td>
	</tr>	




		</table>

	










