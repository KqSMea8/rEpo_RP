	
	<table width="100%" border="0" cellpadding="5" cellspacing="0" >	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=SUPPLIER_ADDRESS?></td>
	</tr>



		
		<tr>
			<td  align="right"   class="blackbold" valign="top" > Address  :  </td>
			<td   align="left" >
	 <textarea name="Address" type="text" class="textarea" id="Address" maxlength="200"><?=stripslashes($arryPurchase[0]['Address'])?></textarea>	
		</td>
	 </tr>

	<tr>
			<td  align="right"   class="blackbold" > City  :  </td>
			<td   align="left" >
	<input name="City" type="text" class="inputbox" id="City" value="<?php echo stripslashes($arryPurchase[0]['City']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
		</td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold" > State  :  </td>
			<td   align="left" >
	<input name="State" type="text" class="inputbox" id="State" value="<?php echo stripslashes($arryPurchase[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" onblur="Javascript:SetTaxable(1);"/>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Country  :  </td>
			<td   align="left" >
	<input name="Country" type="text" class="inputbox" id="Country" value="<?php echo stripslashes($arryPurchase[0]['Country']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" onblur="Javascript:SetTaxable(1);"/>
		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold" > Zip Code  :  </td>
			<td   align="left" >
	<input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?php echo stripslashes($arryPurchase[0]['ZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
		</td>
		  </tr>
	

	<tr>
			<td  align="right"   class="blackbold" width="40%"> Contact Name  : </td>
			<td   align="left" >
	<input name="SuppContact" type="text" class="inputbox" id="SuppContact" value="<?php echo stripslashes($arryPurchase[0]['SuppContact']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>            </td>
		  </tr>	

 <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left"  >
<?php  
				if(!empty($arryPurchase[0]['Mobile'])) {
	         $arryPurchase[0]['Mobile'] = PhoneNumberFormat($arryPurchase[0]['Mobile']);
               }
				
				?>
		 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryPurchase[0]['Mobile'])?>"     maxlength="20" />	
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
<?php  
				if(!empty($arryPurchase[0]['Landline'])) {
	         $arryPurchase[0]['Landline'] = PhoneNumberFormat($arryPurchase[0]['Landline']);
               }
				
				?>
		 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arryPurchase[0]['Landline'])?>"  maxlength="20" />	

				</td>
	 </tr>

	
	<tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=stripslashes($arryPurchase[0]['Email'])?>"  maxlength="80" /> </td>
		  </tr>

	<tr style="display:none">
			<td  align="right"   class="blackbold" > Currency  : </td>
			<td   align="left" >
	<input name="SuppCurrency" type="text" class="disabled" readonly style="width:90px;" id="SuppCurrency" value="<?=stripslashes($arryPurchase[0]['SuppCurrency'])?>"/> 

		</td>
		  </tr>

<?php if(!empty($TaxableBillingAp)){?>
<tr>
			<td align="right"   class="blackbold">Taxable  : </td>
			<td  align="left">
                            
                        <select style="width:100px;" id="tax_auths" class="textbox" name="tax_auths" onchange="Javascript:SetTaxable(1);">
                            <option value="No" <?php if($arryPurchase[0]['tax_auths']=="No"){echo "selected";}?>>No</option>
                            <option value="Yes" <?php if($arryPurchase[0]['tax_auths']=="Yes"){echo "selected";}?>>Yes</option>
                             </select>
                        </td>
		  </tr>


		<tr>
			<td align="right"   class="blackbold">Tax Rate  :</td>
			<td  align="left">  

                         
                      		<div id="TaxRateVal">None</div>
<input type="hidden" name="MainTaxRate" id="MainTaxRate" value="<?=$arryPurchase[0]['TaxRate']?>">
<input type="hidden" name="freightTxSet" id="freightTxSet" value="<?=$arryPurchase[0]['freightTxSet']?>">


                        </td>
		  </tr>	
<? } ?>


		</table>
