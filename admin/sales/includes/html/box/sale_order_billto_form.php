	
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
	<input name="CustomerCompany" type="text" class="inputbox disabled"  readonly  id="CustomerCompany" value="<?php echo stripslashes($arrySale[0]['CustomerCompany']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		</td>
	</tr>


		
		<tr>
			<td  align="right"   class="blackbold" valign="top" > Address :<span id="mand_bill_add" class="red">*</span> </td>
			<td   align="left" >
	    <textarea id="Address" class="textarea disabled"  readonly type="text" name="Address"><?=stripslashes($arrySale[0]['Address'])?></textarea>
		</td>
	 </tr>
	  
	          <?php 
             if ($arrySale[0]['CountryId']>0) {
                            $CountrySelected = $arrySale[0]['CountryId'];
                    }   else {
                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
            } ?>

	<!--<tr>
			<td  align="right"   class="blackbold" > Country  :<span id="mand_bill_country" class="red">*</span> </td>
			<td   align="left" >
		
            <?php 
             if ($arrySale[0]['CountryId']>0) {
                            $CountrySelected = $arrySale[0]['CountryId'];
                    }   else {
                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
                        } ?>
			<select id="CountryName" name="CountryId" class="inputbox disabled" disabled>
			<?php  if (!empty($arryCountry) && !empty($arrySale[0]['CountryId']))
{ foreach($arryCountry as $Country) { ?>
			<option value="<?php echo $Country['country_id']?>" <?php if ($Country['country_id'] == $CountrySelected) {
                  echo "selected"; } ?>><?php echo $Country['name'];?></option>
			<?php }  }?>
            <option value="0" <?php if(!empty($displayCountryBlock)){ echo "selected"; }?>>Other</option>
            </select>
	<input name="Country" type="hidden" class="inputbox"  value="<?php echo stripslashes($arrySale[0]['Country']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="Country"/>
		</td>
		 </tr>


<? if(!empty($displayCountryBlock)){?>

<tr>
			<td  align="right"   class="blackbold" > Other Country  :<span id="mand_bill_country" class="red">*</span> </td>
			<td   align="left" >
		
	<input name="DisCountry" type="text" class="disabled" readonly  value="<?php echo stripslashes($arrySale[0]['Country']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="DisCountry"/>
		</td>
		 </tr>



<? }?>







		 	<tr>
		   <td  align="right"   class="blackbold" > State  :<span id="mand_bill_state" class="red">*</span> </td>
			<td   align="left" >
			
			<select name="StateID" id="StateName" class="inputbox disabled" disabled>
			<option value="">---Select---</option>
			<?php


if (!empty($arryState) )
{
 foreach($arryState as $StateValue) {
				?>
			<option value ="<?php echo $StateValue['state_id']?>" <?php if($arrySale[0]['StateID'] == $StateValue['state_id']) { echo "selected"; } ?>><?php echo $StateValue['name']?></option>
			<?php }  }?>
<option value="0" <?php if(!empty($displayStateBlock)){ echo "selected"; }?>>Other</option>
			</select>
	<input name="State" type="hidden" class="inputbox"  value="<?php echo stripslashes($arrySale[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="State"/>

		</td>
	 </tr>

<? if(!empty($displayStateBlock)){?>

<tr>
			<td  align="right"   class="blackbold" > Other State  : </td>
			<td   align="left" >
		
	<input name="DisState" type="text" class="disabled" readonly  value="<?php echo stripslashes($arrySale[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="DisState"/>
		</td>
		 </tr>



<? }?>




	<tr>
			<td  align="right"   class="blackbold" > City  :<span id="mand_bill_city" class="red">*</span> </td>
			<td   align="left" >
		
			<select name="CityID" id="CityName" class="inputbox disabled" disabled>
			<option value="">---Select---</option>
			<?php  if (!empty($arryCity))
{ foreach($arryCity as $City) {
				?>
			<option value ="<?php echo $City['city_id']?>" <?php if($arrySale[0]['CityID'] == $City['city_id']) { echo "selected"; } ?>><?php echo $City['name']?></option>
			<?php }  }?>
<option value="0" <?php if(!empty($displayCityBlock)){ echo "selected"; }?>>Other</option>
			</select>
	<input name="City" type="hidden" class="inputbox disabled" value="<?php echo stripslashes($arrySale[0]['City']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="City"/>
		</td>
		 </tr>
<? if(!empty($displayCityBlock)){?>

<tr>
			<td  align="right"   class="blackbold" > Other City  : </td>
			<td   align="left" >
		
	<input name="DisCity" type="text" class="disabled" readonly  value="<?php echo stripslashes($arrySale[0]['City']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="DisCity"/>
		</td>
		 </tr>



<? }?>
-->

<tr>
			<td  align="right"   class="blackbold" > Country  : </td>
			<td   align="left" >
		
	<input name="Country" type="text"  class="inputbox disabled" readonly id="Country" value="<?php echo stripslashes($arrySale[0]['ShippingCountry']); ?>"   maxlength="60"  />
	
	<input name="CountryId" type="hidden" class="inputbox"   value="<?php echo stripslashes($CountrySelected); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="CountryName"/>
	
	
	
		</td>
		 </tr>
		 
			<?php 
		
		$Billstatedis='';
		//$UsedState =0;
		if(!empty($_GET['edit'])){ if(!empty($arrySale[0]['StateID']) && $arrySale[0]['State']!=''){
		 
		 $Billstatedis = '';
		 //$UsedState =1;
		 }else{
		 
		 $Billstatedis = 'style="display:none;"';
		 }  }?>
		 
		 

	<tr id="billstate_tr" <?=$Billstatedis?>>
			<td  align="right"   class="blackbold" > State  : </td>
			<td   align="left" >
		
	<input name="State" type="text"  class="inputbox disabled" readonly  id="State" value="<?php echo stripslashes($arrySale[0]['State']); ?>"   maxlength="60"    />
	
		<input name="StateID" type="hidden" class="inputbox"   value="<?php echo stripslashes($arrySale[0]['StateID']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="StateName"/>
	
		</td>
		 </tr>
		 	<tr>
			<td  align="right"   class="blackbold" > City  : </td>
			<td   align="left" >
		
	<input name="City" type="text"  class="inputbox disabled" readonly  id="City" value="<?php echo stripslashes($arrySale[0]['City']); ?>"   maxlength="60"  />
	
	<input name="CityID" type="hidden" class="inputbox"   value="<?php echo stripslashes($arrySale[0]['ShippingCityID']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="CityName"/>
	
	 
	
		</td>
		 </tr>





	<tr>
			<td  align="right"   class="blackbold" > Zip Code  :<span id="mand_bill_code" class="red">*</span> </td>
			<td   align="left" >
	<input name="ZipCode" type="text" class="inputbox disabled"  readonly id="ZipCode" value="<?php echo stripslashes($arrySale[0]['ZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
		</td>
		  </tr>
	

	

 <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left"  >
<?php  
				if(!empty($arrySale[0]['Mobile'])) {
	         $arrySale[0]['Mobile'] = PhoneNumberFormat($arrySale[0]['Mobile']);
               }
				
				?>
		 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySale[0]['Mobile'])?>"     maxlength="20" />	
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
<?php  
				if(!empty($arrySale[0]['Landline'])) {
	         $arrySale[0]['Landline'] = PhoneNumberFormat($arrySale[0]['Landline']);
               }
				
				?>
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
