<script language="JavaScript1.2" type="text/javascript">
function validate_general(frm){

	var DataExist=0;
	/**********************/
	if(!ValidateMandRange(frm.CompanyName, "Company Name",3,30)){
		return false;
	}
	
	DataExist = CheckExistingData("isRecordExists.php","&CompanyName="+escape(document.getElementById("CompanyName").value)+"&editID="+document.getElementById("SuppID").value, "CompanyName","Company Name");
	if(DataExist==1)return false;
	/**********************/

	var DataExist=0;
	/**********************/
	if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
		return false;
	}
	if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
		return false;
	}
	/**********************/
	if(!ValidateForSimpleBlank(frm.Email, "Email Address")){
		return false;
	}
	if(!isEmail(frm.Email)){
		return false;
	}
	DataExist = CheckExistingData("isRecordExists.php", "&Type=Supplier&Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value, "Email","Email Address");
	if(DataExist==1)return false;
	/**********************/


	if( ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		){
		
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}

	
}

function validate_bank(frm){
	if( ValidateForSimpleBlank(frm.BankName, "Bank Name")
		&& ValidateForSimpleBlank(frm.AccountName, "Account Name")
		&& ValidateAccountNumber(frm.AccountNumber,"Account Number",10,20)
		&& ValidateForSimpleBlank(frm.IFSCCode,"Routing Number")
		){
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_contact(frm){

	var DataExist=0;
	/**********************/
	if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
		return false;
	}
	if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
		return false;
	}
	/**********************/
	if(!ValidateForSimpleBlank(frm.Email, "Email Address")){
		return false;
	}
	if(!isEmail(frm.Email)){
		return false;
	}
	DataExist = CheckExistingData("isRecordExists.php", "&Type=Supplier&Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value, "Email","Email Address");
	if(DataExist==1)return false;
	/**********************/


	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(	ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& ValidateForSelect(frm.country_id,"Country")
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		){
		
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}






</script>



	




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_supplier'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_supplier'])) {echo $_SESSION['mess_supplier']; unset($_SESSION['mess_supplier']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<? if($_GET["tab"]=="general"){ ?>
<tr>
	 <td colspan="2" align="left" class="head">General Information</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Vendor Code  : </td>
        <td   align="left" ><?php echo stripslashes($arrySupplier[0]['SuppCode']); ?>
	</td>
</tr>
   <tr>
        <td  align="right"   class="blackbold" width="40%"> Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arrySupplier[0]['CompanyName']); ?>"  maxlength="40" onKeyPress="Javascript:ClearAvail('MsgSpan_Company');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_Company','CompanyName','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Company"></span>
</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" > First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	  
 <tr>
        <td  align="right"   class="blackbold" > Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arrySupplier[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Supplier','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"     maxlength="20" />	
	 
	 </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
	 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arrySupplier[0]['Landline'])?>"  maxlength="20" />	

			</td>
      </tr>

	  <tr>
        <td align="right"   class="blackbold">Fax  : </td>
        <td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arrySupplier[0]['Fax'])?>"  maxlength="20" /> </td>
      </tr> 
	 
 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arrySupplier[0]['Website']))?($arrySupplier[0]['Website']):("")?>"  maxlength="100" /> <?=WEBSITE_FORMAT?></td>
      </tr>


 <tr>
        <td  align="right"   class="blackbold"> Currency  :</td>
        <td   align="left" >
		<?
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		$arryCurrency = $objRegion->getCurrency('',1);

		if(!empty($arrySupplier[0]['Currency'])){
			$CurrencySelected = $arrySupplier[0]['Currency']; 
		}else{
			$CurrencySelected = 'USD';
		}
		
		?>
            <select name="Currency" class="inputbox" id="Currency">
              <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
              <option value="<?=$arryCurrency[$i]['code']?>" <?  if($arryCurrency[$i]['code']==$CurrencySelected){echo "selected";}?>>
              <?=$arryCurrency[$i]['name']?>
              </option>
              <? } ?>
            </select>       
		</td>
      </tr>

  <tr>
        <td  align="right"   class="blackbold" >Vendor Since :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#SupplierSince').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-50?>:<?=date("Y")?>', 
		maxDate: "-1D", 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$SupplierSince = ($arrySupplier[0]['SupplierSince']>0)?($arrySupplier[0]['SupplierSince']):(""); 
?>
<input id="SupplierSince" name="SupplierSince" readonly="" class="datebox" value="<?=$SupplierSince?>"  type="text" > 


</td>
      </tr>

<? if(sizeof($arryPaymentTerm)>0){ ?>
<tr>
        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySupplier[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		</td>
</tr>
<? } ?>


<tr>
        <td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arrySupplier[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>

<tr>
        <td  align="right" class="blackbold">Shipping Method  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arrySupplier[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>



	<? 
	$arryExisting = $arrySupplier;
	include("includes/html/box/custom_field_form.php");
	?>

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arrySupplier[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arrySupplier[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>
<? } ?>

<? if($_GET['tab'] == "contacts"){ ?>
<tr>
	<td colspan="2" align="left" class="head">Contacts </td>
</tr>	
<tr>
	<td colspan="2" align="left">
<? 
$SuppID = $_GET['edit'];
include("includes/html/box/supplier_contacts.php");
?>
</td>
</tr>	
<? } ?> 


<? if($_GET["tab"]=="contact"){ ?>
	
	<tr>
       		 <td colspan="2" align="left"   class="head">Contact Information</td>
        </tr>
   
<tr>
        <td  align="right"   class="blackbold" > First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	  
 <tr>
        <td  align="right"   class="blackbold" > Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arrySupplier[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Supplier','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>		  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address" maxlength="200"><?=stripslashes($arrySupplier[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?
	if(!empty($arrySupplier[0]['country_id'])){
		$CountrySelected = $arrySupplier[0]['country_id']; 
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
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arrySupplier[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arrySupplier[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arrySupplier[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"     maxlength="20" />	
	 
	 </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
	 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arrySupplier[0]['Landline'])?>"  maxlength="20" />	

			</td>
      </tr>

	  <tr>
        <td align="right"   class="blackbold">Fax  : </td>
        <td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arrySupplier[0]['Fax'])?>"  maxlength="20" /> </td>
      </tr> 
	 
 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arrySupplier[0]['Website']))?($arrySupplier[0]['Website']):("")?>"  maxlength="100" /> <?=WEBSITE_FORMAT?></td>
      </tr>

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arrySupplier[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arrySupplier[0]['city_id']; ?>" />


<? } ?>




 
  <? if($_GET["tab"]=="bank"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Bank Details</td>
        </tr>
		
	 <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold"  width="45%"> Bank Name :<span class="red">*</span> </td>
        <td   align="left" >
		 <input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="<?=stripslashes($arrySupplier[0]['BankName'])?>" onKeyPress="Javascript:return isAlphaKey(event);">
            </td>
      </tr>	
	 <tr>
        <td  align="right"   class="blackbold"> Account Name  :<span class="red">*</span> </td>
        <td   align="left" >
            <input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="<?=stripslashes($arrySupplier[0]['AccountName'])?>" onKeyPress="Javascript:return isAlphaKey(event);">
			 </td>
      </tr>	  
	  <tr>
        <td  align="right"   class="blackbold"> Account Number  :<span class="red">*</span> </td>
        <td   align="left" >
            <input type="text" name="AccountNumber" maxlength="30" class="inputbox" id="AccountNumber" value="<?=stripslashes($arrySupplier[0]['AccountNumber'])?>" onKeyPress="Javascript:return isAlphaKey(event);">
			 </td>
      </tr>	
	   <tr>
        <td  align="right"   class="blackbold"> Routing Number  :<span class="red">*</span> </td>
        <td   align="left" >
            <input type="text" name="IFSCCode" maxlength="30"  class="inputbox" id="IFSCCode" value="<?=stripslashes($arrySupplier[0]['IFSCCode'])?>" onKeyPress="Javascript:return isAlphaKey(event);">
			 </td>
      </tr>	
	  
	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
  <? } ?>

	
	  

 <? if($_GET["tab"]=="currency"){ ?>  
	<!--
		<tr>
       		 <td colspan="2" align="left" class="head">Currency</td>
        </tr>
		
	 <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
	 <tr>
        <td  align="right"   class="blackbold" width="45%"> Currency  :</td>
        <td   align="left" >
		<?
		if($arrySupplier[0]['currency_id'] > 0 ){
			$CurrencySelected = $arrySupplier[0]['currency_id']; 
		}else{
			$CurrencySelected = 9;
		}
		?>
            <select name="currency_id" class="inputbox" id="currency_id">
              <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
              <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>>
              <?=$arryCurrency[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>


	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		-->
  <? } ?>










<? 
if($_GET["tab"]=="shipping" || $_GET["tab"]=="billing"){ 
	include("includes/html/box/shipping_billing.php");
} 
?>

	
	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   
 <? if($HideSubmit!=1){ ?>
   <tr>
    <td  align="center" >



	<br />
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="SuppID" id="SuppID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="UserID" id="UserID"  value="<?=$arrySupplier[0]['UserID']?>" />	


</div>

</td>
   </tr>
<? } ?>
   </form>
</table>
</div>


<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact" || $_GET["tab"]=="billing" || $_GET["tab"]=="shipping"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>





