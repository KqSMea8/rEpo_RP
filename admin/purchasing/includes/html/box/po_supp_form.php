	
	<table width="100%" border="0" cellpadding="5" cellspacing="0" >	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=SUPPLIER_ADDRESS?></td>
	</tr>
	<!--tr>
			<td  align="right"   class="blackbold" width="30%"> Vendor Code  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="SuppCode" type="text" class="disabled" style="width:90px;" id="SuppCode" value="<?php echo stripslashes($arryPurchase[0]['SuppCode']); ?>"  maxlength="40" readonly />
	<a class="fancybox fancybox.iframe" href="SupplierList.php" ><?=$search?></a>

			</td>
	 </tr-->

<!----------- By Rajan 09 Dec ------------->
<tr id="shipTR" style="display:none;">
			<td  align="right"  class="blackbold" valign="top" >Ship To: </td>
			<td  align="left" id="shipTD">
			<select name="shipto" id="shipto" onchange="ChangeVanaddress(this.value)">
		<?php 
		/*for($count=0;$count<count($arryContact);$count++){
			$address=$arryContact[$count]['Name'].',';
			if($arryContact[$count]['Address']!='') $address .=$arryContact[$count]['Address'].',';
			if($arryContact[$count]['City']!='') $address .=$arryContact[$count]['City'].',';
			if($arryContact[$count]['State']!='') $address .=$arryContact[$count]['State'].',';
			if($arryContact[$count]['Country']!='') $address .=$arryContact[$count]['Country'].',';
			echo '<option value="'.$arryContact[$count]['AddID'].'">'.substr($address,0,-1).'</option>';
		}*/
		?>
			</select>
		</td>
	  </tr>
<!------------ End   ------------------->

	<tr>
			<td  align="right"   class="blackbold" > Company Name  :  </td>
			<td   align="left" >
	<input name="SuppCompany" type="text" class="inputbox" id="SuppCompany" value="<?php echo stripslashes($arryPurchase[0]['SuppCompany']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		</td>
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
		   <td  align="right"   class="blackbold" > State  : </td>
			<td   align="left" >
	<input name="State" type="text" class="inputbox" id="State" value="<?php echo stripslashes($arryPurchase[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" onblur="Javascript:SetTaxable(1);"/>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Country  : </td>
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
		 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryPurchase[0]['Mobile'])?>"     maxlength="20" />	
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
		 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arryPurchase[0]['Landline'])?>"  maxlength="20" />	

				</td>
	 </tr>

	
	<tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=stripslashes($arryPurchase[0]['Email'])?>"  maxlength="80" />



<input name="EDICompId" type="hidden" class="inputbox" id="EDICompId" value="<?=stripslashes($arryPurchase[0]['EDICompId'])?>"  /> 
<input name="EDISalesCompName" type="hidden" class="inputbox" id="EDISalesCompName" value="<?=stripslashes($arryPurchase[0]['EDICompName'])?>"  />


 </td>
		  </tr>

	<!--tr>
			<td  align="right"   class="blackbold" > Currency  : </td>
			<td   align="left" >
	<input name="SuppCurrency" type="text" class="disabled" readonly style="width:90px;" id="SuppCurrency" value="<?=stripslashes($arryPurchase[0]['SuppCurrency'])?>"/> 

		</td>
		  </tr-->
<?php if(!empty($TaxableBillingAp)){?>
	<tr>
			<td align="right"   class="blackbold">Taxable  : </td>
			<td  align="left">
 
                        <select style="width:100px;" id="tax_auths" class="textbox" name="tax_auths" onchange="Javascript:SetTaxable(1);">
                            <option value="No" <?php if($arryPurchase[0]['tax_auths']=="No" || $arryPurchase[0]['tax_auths']==" "){echo "selected";}?>>No</option>
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

 

<script language="JavaScript1.2" type="text/javascript">		
		
function ChangeVanaddress(ShipId,SuppID){ 
		var SendUrl = "&action=VendorAddress&ShipId="+ShipId+"&SuppID="+SuppID;
		
		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			dataType : "JSON",
			success: function (responseText) {
			//console.log(responseText);
			  $("#SuppCompany").val(responseText["CompanyName"]);
			  $("#Address").val(responseText["Address"]);
			  
			  $("#City").val(responseText["City"] );
			  $("#State").val(responseText["State"] );
			  $("#Country").val(responseText["Country"] );
			  $("#ZipCode").val(responseText["ZipCode"]);
			  
			  $("#SuppContact").val(responseText["Name"]);
			  $("#Mobile").val(responseText["Mobile"] );
			  $("#Landline").val(responseText["Landline"] );
			  $("#Email").val(responseText["Email"]);
			}

		   });
		
	}
</script>

<!--------------  End ---------->
