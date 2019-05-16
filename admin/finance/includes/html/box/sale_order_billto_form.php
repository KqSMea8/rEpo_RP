	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=CUSTOMER_BILLING_ADDRESS?></td>
	</tr>
	
       <tr style="display:none">
			<td  align="right"   class="blackbold" > Billing Name  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="BillingName" type="text" class="inputbox" id="BillingName" value="<?php echo stripslashes($arrySale[0]['BillingName']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>            </td>
		  </tr>	
	<tr>
			<td  align="right"   class="blackbold" width="40%"> Company Name  : </td>
			<td   align="left" >
	<input name="CustomerCompany" type="text" class="inputbox" id="CustomerCompany" value="<?php echo stripslashes($arrySale[0]['CustomerCompany']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		</td>
	</tr>


		
		<tr>
			<td  align="right"   class="blackbold" valign="top" > Address :<span class="red">*</span> </td>
			<td   align="left" >
	    <textarea id="Address" class="textarea" type="text" name="Address"><?=stripslashes($arrySale[0]['Address'])?></textarea>
		</td>
	 </tr>
	  

	<tr>
			<td  align="right"   class="blackbold" > City  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="City" type="text" class="inputbox" id="City" value="<?php echo stripslashes($arrySale[0]['City']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
		</td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold" > State  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="State" type="text" class="inputbox" id="State" value="<?php echo stripslashes($arrySale[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" onblur="Javascript:SetTaxable(1);"/>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Country  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="Country" type="text" class="inputbox" id="Country" value="<?php echo stripslashes($arrySale[0]['Country']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" onblur="Javascript:SetTaxable(1);" />
		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold" > Zip Code  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?php echo stripslashes($arrySale[0]['ZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
		</td>
		  </tr>
	

	

 <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left"  >
		 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySale[0]['Mobile'])?>"     maxlength="20" />	
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
		 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arrySale[0]['Landline'])?>"  maxlength="20" />	

				</td>
	 </tr>

	<tr>
			<td align="right"   class="blackbold">Fax  : </td>
			<td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arrySale[0]['Fax'])?>"  maxlength="20" /> </td>
		  </tr>

	    <tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=stripslashes($arrySale[0]['Email'])?>"  maxlength="80" /> </td>
		  </tr>

<?php if(!empty($TaxableBilling)){?>

	  <tr>
			<td align="right"   class="blackbold">Taxable  : </td>
			<td  align="left">
                            
                        <select style="width:100px;" id="tax_auths" class="textbox" name="tax_auths" onchange="Javascript:SetTaxable(1);">
                            <option value="No" <?php if($arrySale[0]['tax_auths']=="No"){echo "selected";}?>>No</option>
                            <option value="Yes" <?php if($arrySale[0]['tax_auths']=="Yes"){echo "selected";}?>>Yes</option>
                             </select>
                        </td>
		  </tr>

	<tr>
			<td align="right"   class="blackbold">Tax Rate  :</td>
			<td  align="left">  

                         
                      		<div id="TaxRateVal">None</div>
<input type="hidden" name="MainTaxRate" id="MainTaxRate" value="<?=$arrySale[0]['TaxRate']?>">
<input type="hidden" name="freightTxSet" id="freightTxSet" value="<?=$arrySale[0]['freightTxSet']?>">

                        </td>
		  </tr>	

<? } ?>
	
		</table>
