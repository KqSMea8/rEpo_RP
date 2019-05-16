<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=CUSTOMER_SHIPPING_ADDRESS?></td>
	</tr>
   

 <tr>
			<td  align="right"   class="blackbold" valign="top" ><input type="checkbox" name="sameBilling" id="sameBilling"> </td>
			<td   align="left">
			 Same as billing address
		</td>
	  </tr>

<!----------- By Rajan 03 Dec ------------->
<tr id="shipTR" style="<?=$nne?>">
			<td  align="right"  class="blackbold" valign="top" >
			Ship To </td>
			<td  align="left" id="shipTD">

<?=$shipList?>
			
		</td>
	  </tr>
<!------------ End   ------------------->
     <tr style="display:none">
			<td  align="right"   class="blackbold" > Shipping Name  :<span class="red">*</span> </td>
			<td   align="left">
	        <input name="ShippingName" type="text" class="inputbox" id="ShippingName" value="<?php echo stripslashes($arrySale[0]['ShippingName']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>            </td>
		  </tr>	
	   <tr>
			<td  align="right"   class="blackbold" width="40%"> Company Name  : </td>
			<td   align="left">
	        <input name="ShippingCompany" type="text" class="inputbox" id="ShippingCompany" value="<?php echo stripslashes($arrySale[0]['ShippingCompany']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		</td>
	  </tr>
	  <tr>
			<td  align="right"   class="blackbold" valign="top" > Address  :<span id="mand_ship_add" class="red">*</span> </td>
			<td   align="left">
			  <textarea id="ShippingAddress" class="textarea" type="text" name="ShippingAddress"><?=stripslashes($arrySale[0]['ShippingAddress'])?></textarea>
		</td>
	  </tr>
	  
		<!-- modified by nisha for country dropdown -->
 <?php if ($arrySale[0]['ShippingCountryID']>0) {
 $CountrySelected = $arrySale[0]['ShippingCountryID'];
 }   
 else {
 //$CountrySelected = $arryCurrentLocation[0]['country_id'];
 $CountrySelected = '';
 } ?>

		

<script>
	 
function AutoCompleteCountry(elm){		
	$(elm).autocomplete({
		source: "../jsonCountry.php",
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#ShippingCountryName').val(ui.item.id);
					 jQuery('#ShippingCountry').val(ui.item.label);
					  jQuery('#ShippingStateName').val('');
					 jQuery('#ShippingState').val('');
					 	jQuery('#ShippingCityName').val('');
					 jQuery('#ShippingCity').val('');
					 
					 //alert(ui.item.used_state);
					 if(ui.item.used_state=='1'){
					 jQuery('#UsedState').val(1);
					 document.getElementById("state_tr").style.display = ''; 
					 
					 }else{
					 
					  jQuery('#ShippingStateName').val('');
					 jQuery('#ShippingState').val('');
					 jQuery('#UsedState').val(0);
					 document.getElementById("state_tr").style.display = 'none';
					 
					 }
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
function AutoCompleteCity(elm){		
var country_id = jQuery('#ShippingCountryName').val();
var state_id = jQuery('#ShippingStateName').val();
	$(elm).autocomplete({
		source: "../jsonCity.php?country_id="+country_id+"&state_id="+state_id,
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#ShippingCityName').val(ui.item.id);
					 jQuery('#ShippingCity').val(ui.item.label);
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
function AutoCompleteState(elm){		
var country_id = jQuery('#ShippingCountryName').val();
	$(elm).autocomplete({
		source: "../jsonState.php?country_id="+country_id,
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#ShippingStateName').val(ui.item.id);
					 jQuery('#ShippingState').val(ui.item.label);
					//alert(ui.item.id);
					jQuery('#ShippingCityName').val('');
					 jQuery('#ShippingCity').val('');
					
					//return false;
					//
					}
		}
	});

}
    </script>
	
	<tr>
			<td  align="right"   class="blackbold" > Country  : </td>
			<td   align="left" >
		
	<input name="ShippingCountry" type="text"  class="inputbox"  id="ShippingCountry" value="<?php echo stripslashes($arrySale[0]['ShippingCountry']); ?>" onblur="SetCountryInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCountry(this);"/>
	
	<input name="ShippingCountryName" type="hidden" class="inputbox"   value="<?php echo stripslashes($CountrySelected); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="ShippingCountryName"/>
	
	
	
		</td>
		 </tr>
		 
		<?php 
		
		$Shipstatedis='';
		$UsedState =0;
		if(!empty($_GET['edit'])){ if(!empty($arrySale[0]['ShippingStateID']) && $arrySale[0]['ShippingState']!=''){
		 
		 $Shipstatedis = '';
		 $UsedState =1;
		 }else{
		 
		 $Shipstatedis = 'style="display:none;"';
		 }  }
		 
		 #pr($arrySale);
		 
		 ?>
		 
		 

	<tr id="state_tr" <?=$Shipstatedis?>>
			<td  align="right"   class="blackbold" > State  : </td>
			<td   align="left" >
		
	<input name="ShippingState" type="text"  class="inputbox"  id="ShippingState" value="<?php echo stripslashes($arrySale[0]['ShippingState']); ?>" onblur="SetSateInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteState(this);"/>
	
		<input name="ShippingStateName" type="hidden" class="inputbox"   value="<?php echo stripslashes($arrySale[0]['ShippingStateID']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="ShippingStateName"/>
	
		</td>
		 </tr>
		 	<tr>
			<td  align="right"   class="blackbold" > City  : </td>
			<td   align="left" >
		
	<input name="ShippingCity" type="text"  class="inputbox"  id="ShippingCity" value="<?php echo stripslashes($arrySale[0]['ShippingCity']); ?>" onblur="SetCityInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCity(this);"/>
	
	<input name="ShippingCityName" type="hidden" class="inputbox"   value="<?php echo stripslashes($arrySale[0]['ShippingCityID']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="ShippingCityName"/>
	
	 
	
		</td>
		 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Zip Code  :<span id="mand_ship_code" class="red">*</span> </td>
			<td   align="left">
	      <input name="ShippingZipCode" type="text" class="inputbox" id="ShippingZipCode" value="<?php echo stripslashes($arrySale[0]['ShippingZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
		</td>
		  </tr>
	

        <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left">
<?php  
				if(!empty($arrySale[0]['ShippingMobile'])) {
	         $arrySale[0]['ShippingMobile'] = PhoneNumberFormat($arrySale[0]['ShippingMobile']);
               }
				
				?>
		   <input name="ShippingMobile" type="text" class="inputbox" id="ShippingMobile" value="<?=stripslashes($arrySale[0]['ShippingMobile'])?>"     maxlength="20" />	
		 </td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left">
<?php  
				if(!empty($arrySale[0]['ShippingLandline'])) {
	         $arrySale[0]['ShippingLandline'] = PhoneNumberFormat($arrySale[0]['ShippingLandline']);
               }
				
				?>
		       <input name="ShippingLandline" type="text" class="inputbox" id="ShippingLandline" value="<?=stripslashes($arrySale[0]['ShippingLandline'])?>"  maxlength="20" />	
			</td>
	 </tr>

	   <tr>
			<td align="right"   class="blackbold">Fax  : </td>
			<td  align="left"><input name="ShippingFax" type="text" class="inputbox" id="ShippingFax" value="<?=stripslashes($arrySale[0]['ShippingFax'])?>"  maxlength="20" /> </td>
		  </tr>

	     <tr>
			<td align="right"   class="blackbold">Email  : </td>
			<td  align="left" ><input name="ShippingEmail" type="text" class="inputbox" id="ShippingEmail" value="<?=stripslashes($arrySale[0]['ShippingEmail'])?>"  maxlength="80" /> </td>
		  </tr>
<?php if($_SESSION['SelectOneItem'] != 1){?>
		<tr>
			<td align="right"   class="blackbold">Reseller  : </td>
			<td  align="left" >
 <label><input name="Reseller" type="radio" id="Reseller1" value="Yes" <?=($arrySale[0]['Reseller']=="Yes")?("checked"):("")?> onclick="Javascript:SetReseller(1);" />&nbsp;Yes</label>
&nbsp;&nbsp;&nbsp;&nbsp;
 <label><input name="Reseller" type="radio" id="Reseller2" value="No" <?=($arrySale[0]['Reseller']!="Yes")?("checked"):("")?> onclick="Javascript:SetReseller(1);" />&nbsp;No </label>

 </td>
		  </tr>
	 <tr>
			<td align="right"   class="blackbold"><div id="ResellerTitleDiv">Reseller No  :</div> </td>
			<td  align="left" ><div id="ResellerValDiv"><input name="ResellerNo" type="text" class="inputbox" id="ResellerNo" value="<?=stripslashes($arrySale[0]['ResellerNo'])?>"  maxlength="30" /></div> </td>
		  </tr>
<? }?>


<?php if(empty($TaxableBilling)){?>
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
<input type="hidden" name="TaxableBilling" id="TaxableBilling" class="inputbox" readonly value="<?=$TaxableBilling?>" /> 

<script language="JavaScript1.2" type="text/javascript">

SetTaxable(1);
ProcessTotal();

<?php if($_SESSION['SelectOneItem'] != 1){?>
SetReseller();
SetTaxable();
function SetReseller(ProcessCal){
	if(document.getElementById("Reseller2").checked){
		$("#ResellerTitleDiv").hide();
		$("#ResellerValDiv").hide();
	}else{
		$("#ResellerTitleDiv").show();
		$("#ResellerValDiv").show();
	}
	/*if(ProcessCal==1){
		ProcessTotal();
	}*/
}

<? }?>
function SetTaxable(ProcessCal){console.log('in');

	var TaxableBilling = document.getElementById("TaxableBilling").value;  
	if(TaxableBilling =='1'){  
	   var TaxCountry = document.getElementById("Country").value;
	   var TaxState = document.getElementById("State").value;
	}else{  
	   var TaxCountry = document.getElementById("ShippingCountry").value;
	   var TaxState = document.getElementById("ShippingState").value;
	}
 

	if(document.getElementById("tax_auths").value=='Yes' && TaxCountry!=''){
		$("#TaxRateVal").html('<img src="../images/loading.gif">');
		var SendUrl = "&action=TaxRateAddress&State="+escape(TaxState)+"&Country="+escape(TaxCountry)+"&OldTaxRate="+escape(document.getElementById("MainTaxRate").value)+"&r="+Math.random();
 
	   	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {			
			if(responseText!=''){		
				$("#TaxRateVal").html(responseText);
			}else{
				$("#TaxRateVal").html("No tax class.");
			}
		   
		}

	   	});
	}else{
		$("#TaxRateVal").html("None");
	}


	if(ProcessCal==1){
		ProcessTotal();
	}
}

// By Rajan 04 dec //
function ChangeShipaddress(ShipId,CustID){
		var SendUrl = "&action=shippAddress&ShipId="+ShipId+"&CustID="+CustID;
		
		$.ajax({
			type: "GET",
			url: "../sales/ajax.php",
			data: SendUrl,
			dataType : "JSON",
			success: function (responseText) {

				$("#ShippingCompany").val(responseText["Company"]);
				//$("#ShippingCompany").val(responseText["Company"]);
				$("#ShippingAddress").val(responseText["Address"]);
				$("#ShippingCountryName").val(responseText["country_id"] );
				$("#ShippingCountry").val(responseText["CountryName"] );
				loadState(responseText["country_id"],responseText["state_id"]);
				//$("#ShippingStateName").val(responseText["state_id"] );
				$("#ShippingState").val(responseText["StateName"] );
				loadCity(responseText["state_id"],responseText["city_id"]);
				//$("#ShippingCityName").val(responseText["city_id"] );
				$("#ShippingCity").val(responseText["CityName"] );
				$("#ShippingZipCode").val( responseText["ZipCode"]);
				$("#ShippingMobile").val(responseText["Mobile"] );
				$("#ShippingLandline").val(responseText["Landline"] );
				$("#ShippingFax").val(responseText["Fax"] );
				$("#ShippingEmail").val(responseText["Email"]);
			}

		   });
		
	}

//   End  //







function freightSett(taxid){	 
	$("#freightTxSet").val($("#TaxRate :selected").attr("freight_tax"));
	ProcessTotal();
	/*
	$("#freightTxSet").val('');
	var colen = ':';
	if(taxid!=''){
		var taxvalue =  taxid.split(':', 3);
		console.log(taxvalue[0]);
		var selectedValue = taxvalue[0];

		var SendUrl = "&action=FreightTaxSet&taxidval="+selectedValue;
		console.log(SendUrl);
		//make the ajax call

		$.ajax({
		type: "GET",
		url: "../sales/ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {		 
			$("#freightTxSet").val(responseText["FreightTax"]);
			console.log(responseText['FreightTax']);
			ProcessTotal();
		}
		});
	}
	ProcessTotal();
	*/
}






</script>	
