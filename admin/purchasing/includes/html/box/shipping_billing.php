
<script language="JavaScript1.2" type="text/javascript">
function validate_billing(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(	ValidateForSimpleBlank(frm.Name, "Billing Name")
		&& ValidateForTextareaMand(frm.Address,"Billing Address",10,200)
		&& ValidateForSelect(frm.country_id,"Country")
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isEmailOpt(frm.Email)
		){
		
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_shipping(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(	ValidateForSimpleBlank(frm.Name, "Shipping Name")
		&& ValidateForTextareaMand(frm.Address,"Shipping Address",10,200)
		&& ValidateForSelect(frm.country_id,"Country")
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isEmailOpt(frm.Email)
		){
		
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}
</script>
<?
$arryBillShipp = $objSupplier->GetShippingBilling($_GET['edit'],$_GET['tab']);
$BillShipp = ucfirst($_GET["tab"]);

?>
<tr>
       		 <td colspan="2" align="left"   class="head"><?=$BillShipp?> Address</td>
        </tr>
   
<tr>
        <td  align="right"   class="blackbold" ><?=$BillShipp?> Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="Name" type="text" class="inputbox" id="Name" value="<?php echo stripslashes($arryBillShipp[0]['Name']); ?>"  maxlength="40" onkeypress="return isCharKey(event);" />            </td>
      </tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryBillShipp[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?
	if(!empty($arryBillShipp[0]['country_id'])){
		$CountrySelected = $arryBillShipp[0]['country_id']; 
	}else{
		$CountrySelected = $arryCurrentLocation[0]['country_id'];
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryBillShipp[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryBillShipp[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryBillShipp[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryBillShipp[0]['Mobile'])?>"     maxlength="20" />	
	 
	 </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
	 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arryBillShipp[0]['Landline'])?>"  maxlength="20" />	

			</td>
      </tr>

	  <tr>
        <td align="right"   class="blackbold">Fax  : </td>
        <td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arryBillShipp[0]['Fax'])?>"  maxlength="20" /> </td>
      </tr> 

	  <tr>
        <td align="right"   class="blackbold">Email  : </td>
        <td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=stripslashes($arryBillShipp[0]['Email'])?>"  maxlength="80" /> </td>
      </tr> 
<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryBillShipp[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryBillShipp[0]['city_id']; ?>" />



