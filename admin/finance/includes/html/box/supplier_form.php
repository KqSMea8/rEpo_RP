<script language="JavaScript1.2" type="text/javascript">
function validateSupplier(frm){

	var DataExist=0;
	var SuppType = Trim(document.getElementById("SuppType")).value;
	/**********************/
	var SuppCode = Trim(document.getElementById("SuppCode")).value;
	if(SuppCode!=''){
		if(!ValidateMandRange(document.getElementById("SuppCode"), "Vendor Code",3,20)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php","&SuppCode="+escape(SuppCode), "SuppCode","Vendor Code");
		if(DataExist==1)return false;

	}
	/**********************/
	if(document.getElementById("SSN") != null){
		if(document.getElementById("SuppType").value=='Individual'){
			if(!isSSN(frm.SSN)){
				return false;
			}
		}
	}
	/**********************
	if(document.getElementById("EIN") != null){
		if(document.getElementById("SuppType").value!='Individual'){
			if(!isEIN(frm.EIN)){
				return false;
			}		
		}
	}
	/**********************/

	var CompanyName = Trim(document.getElementById("CompanyName")).value;
	if(CompanyName!='' || SuppType!='Individual'){
		if(!ValidateMandRange(frm.CompanyName, "Company Name",3,30)){
			return false;
		}
	
		DataExist = CheckExistingData("isRecordExists.php","&CompanyName="+escape(document.getElementById("CompanyName").value), "CompanyName","Company Name");
		if(DataExist==1)return false;
	}
	/**********************/
	if(!ValidateOptionalUpload(frm.Image, "Image")){
		return false;
	}
	if(SuppType=='Individual'){
		if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
			return false;
		}
	}	
	/**********************/
	/*if(!ValidateForSimpleBlank(frm.Email, "Email Address")){
		return false;
	}*/
	if(document.getElementById("Email").value!=''){
		if(!isEmailOpt(frm.Email)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php", "&Type=Supplier&Email="+escape(document.getElementById("Email").value), "Email","Email Address");
		if(DataExist==1)return false;
	}
	/**********************/


	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		//&& isValidLinkOpt(frm.Website,"Website URL")
		){

				ShowHideLoader('1','S');
				
				/*	var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value+"&CompanyName="+escape(document.getElementById("CompanyName").value)+"&Type=Supplier";
				SendMultipleExistRequest(Url,"Email", "Email Address","CompanyName", "Company Name")
				return false;	
				*/

				return true;
					
		}else{
				return false;	
		}	

	






	
}



</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateSupplier(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">General Information</td>
</tr>

 <tr>
        <td  align="right"   class="blackbold"> Vendor Code : </td>
        <td   align="left" colspan="3">

	<input name="SuppCode" type="text" class="datebox" id="SuppCode" value=""  maxlength="20" oncontextmenu="return false" onKeyPress="Javascript:ClearAvail('MsgSpan_SuppCode');return isUniqueKey(event);" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_SuppCode','SuppCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_SuppCode"></span>

</td>

       
</tr>
 <tr>
 <td  align="right" class="blackbold"  width="15%" >Vendor Type  :<span class="red">*</span></td>
        <td   align="left"  width="35%"> <!--updated by chetan on 2Mar2017--->
		  <select name="SuppType" class="inputbox" id="SuppType" onchange="Javascript:SetSuppType();">
		  	<option value="Business" <?  if($arrySupplier[0]['SuppType']=="Business" || $arrySupplier[0]['SuppType'] == ''){echo "selected";}?>>Business</option>
			<option value="Individual" <?  if($arrySupplier[0]['SuppType']=="Individual"){echo "selected";}?>>Individual</option>				
		</select> 
	</td>

 <td  align="right" class="blackbold" width="20%">1099  :</td>
        <td   align="left">
		  <select name="TenNine" class="textbox" style="width:50px;" id="TenNine">
		  	<option value="0" <?  if($arrySupplier[0]['TenNine']=="0"){echo "selected";}?>>No</option>
			<option value="1" <?  if($arrySupplier[0]['TenNine']=="1"){echo "selected";}?>>Yes</option>				
		</select> 
	</td>
</tr>

<? if($arryCurrentLocation[0]['country_id']!=106){?>
<tr id="ssntr" style="display:none">
        <td align="right"   class="blackbold">Social Security Number  :<span class="red">*</span> </td>
        <td  align="left" colspan="3">
		<input name="SSN" autocomplete="off" type="text" class="inputbox" id="SSN" value="<?=stripslashes($arrySupplier[0]['SSN'])?>"  maxlength="11"  /> <?=SSN_FORMAT?> </td>
       
</tr>

<tr id="eintr" style="display:none5">
        <td align="right"   class="blackbold">EIN  :  </td>
        <td  align="left" colspan="3">
		<input name="EIN" autocomplete="off" type="text" class="inputbox" id="EIN" value="<?=stripslashes($arrySupplier[0]['EIN'])?>"  maxlength="10" /> <?=EIN_FORMAT?> </td>
       
</tr>

<? } ?>

   <tr>
        <td  align="right"   class="blackbold" > Company Name  :<span class="red" id="cmpred">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arrySupplier[0]['CompanyName']); ?>"  maxlength="40" onKeyPress="Javascript:ClearAvail('MsgSpan_Company');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_Company','CompanyName','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Company"></span>
</td>
 
        <td  align="right"   class="blackbold"> Currency  :</td>
        <td   align="left" >
 <?				
if(empty($arrySupplier[0]['Currency']))$arrySupplier[0]['Currency']= $Config['Currency'];

$arrySelCurrency=array();
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySupplier[0]['Currency']) && !in_array($arrySupplier[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySupplier[0]['Currency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);	 
 
 ?>
<select name="Currency" class="inputbox" id="Currency">
 
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arrySupplier[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>   
		</td>
</tr>


 


<tr>
        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
					if($arryPaymentTerm[$i]['termType']==1){
						$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
					}else{
						$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
					}
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySupplier[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		</td>

       
<td align="right" class="blackbold">Default Account :</td>
	<td align="left">

		<select name="AccountID" class="inputbox" id="AccountID">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arrySupplier[0]['AccountID']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select> 
<script>
$("#AccountID").select2();
</script>
	</td>

</tr>

<tr>
        <!--td  align="right" class="blackbold">Shipping Method  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arrySupplier[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td-->

	<td align="right"   class="blackbold" >Credit Limit  :</td>
	<td  align="left" >
	<?  
	$CreditLimit = (!empty($arrySupplier[0]['CreditLimit'])?($arrySupplier[0]['CreditLimit']):("")); 

	?>

	<input name="CreditLimit" type="text" class="textbox" size="10" id="CreditLimit" value="<?=$CreditLimit?>" maxlength="10" onkeypress="return isDecimalKey(event);" />	 <?=$Config['Currency']?>
		  
	  </td>



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





<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

<?
 $MainDir = "upload/supplier/".$_SESSION['CmpID']."/";
      if($arrySupplier[0]['Image'] !='' && file_exists($MainDir.$arrySupplier[0]['Image']) ){ 

?>
				
	<div  id="ImageDiv"><a href="<?=$MainDir.$arrySupplier[0]['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=$arrySupplier[0]['UserName']?>"><? echo '<img src="'.$Prefix.'resizeimage.php?w=150&h=150&img='.$MainDir.$arrySupplier[0]['Image'].'" border=0 >';?></a>
	
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arrySupplier[0]['Image']?>','ImageDiv')"><?=$delete?></a>	</div>
<?	} ?>
	
		</td>
 	  
 

	<? 
	//$arryExisting = $arrySupplier;
	//include("includes/html/box/custom_field_form.php");
	?>



        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arrySupplier[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arrySupplier[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>

 <tr>

    <td  align="right" class="blackbold" > Primary Vendor:</td>
    <td  align="left">
	<input type="checkbox" class="" name="primaryVendor" id="primaryVendor" value = "1"> </td>

	<td  align="right" class="blackbold" > Default Vendor:</td>
    <td  align="left">
	<input type="checkbox" class="" name="defaultVendor" id="defaultVendor" value = "1"> </td>

 </tr>
 
 
 
<? 
/*********  ***********/
if($arryCurrentLocation[0]['country_id']=='106' || $arryCurrentLocation[0]['country_id']=='234'){?>
 <tr>
		<td  align="right" class="blackbold">VAT No :</td>
               <td  align="left" >
		<input name="VAT"  type="text" class="inputbox" id="VAT" value="<?=stripslashes($arrySupplier[0]['VAT'])?>"  maxlength="20" onkeypress="return isUniqueKey(event);"/>  </td>
	
		<td  align="right"   class="blackbold">CST No :</td>
                <td  align="left" >
		<input name="CST"  type="text" class="inputbox" id="CST" value="<?=stripslashes($arrySupplier[0]['CST'])?>"  maxlength="20" onkeypress="return isUniqueKey(event);"/>  </td>
	</tr>

<tr>
		<td  align="right" class="blackbold">TRN No :</td>
               <td  align="left" >
		<input name="TRN"  type="text" class="inputbox" id="TRN" value="<?=stripslashes($arrySupplier[0]['TRN'])?>"  maxlength="20" onkeypress="return isUniqueKey(event);"/>  </td>
	
		 
	</tr>

<?php } 
/********* End Abid ***********/
?>
 <tr>
	 

        <td  align="right"   class="blackbold" 
		>Taxable  : </td>
        <td   align="left"  >
          <? 
		  	 $TaxChecked = 'checked';
			 if($_GET['edit'] > 0){
				 if($arrySupplier[0]['Taxable'] == 1) {$TaxChecked = ' checked';}else{$TaxChecked = 'checked';}
				 if($arrySupplier[0]['Taxable'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Taxable" id="TaxableYes" value="Yes" <?=$TaxChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Taxable" id="TaxableNo" value="No" <?=$TaxChecked?> />
          No </td>
	<td  align="right"   class="blackbold" >Credit Card Vendor  : </td>
        <td   align="left"  >
         <input type="checkbox" name="CreditCard" value="1" <?  if($arrySupplier[0]['CreditCard']=="1"){echo "checked";}?>>
      </tr>

<tr id="TaxRateSh" style="display:none;">
        <td  align="right"   class="blackbold"> Tax Rate  : </td>
        <td   align="left" >
	
    <select name="TaxRate" class="inputbox" id="TaxRate" >
			 <option value="">--- None ---</option>
              <? for($i=0;$i<sizeof($arryPurchaseTax);$i++) {
								$taxRateVal = "".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['RateDescription'].":".$arryPurchaseTax[$i]['TaxRate']."";
								$taxRateName = "".$arryPurchaseTax[$i]['RateDescription'].":".$arryPurchaseTax[$i]['TaxRate']."";
								?>              
								<option value="<?=$taxRateVal?>" > <?=$taxRateName?> </option>
              <? } ?>
     </select>       

			 </td>
      </tr>
	<tr>
       		 <td colspan="4" align="left"   class="head">Contact Information</td>
        </tr>
   
	  
<tr>
        <td  align="right"   class="blackbold"  > First Name  :<span class="red" id="fred">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
  
        <td  align="right"   class="blackbold"> Last Name  :</td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   
 <tr>
        <td  align="right" valign="top"  class="blackbold"> Email :  </td>
        <td   align="left" valign="top"><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arrySupplier[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Supplier','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
     
          <td align="right"   class="blackbold" valign="top">Address  : </td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arrySupplier[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  : </td>
        <td   align="left" >
		<?

	if($arrySupplier[0]['country_id'] != ''){
		$CountrySelected = $arrySupplier[0]['country_id']; 
	}else{
		$CountrySelected = $arryCurrentLocation[0]['country_id'];

	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
			 <!--option value="">--- Select ---</option-->
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
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
        <td align="right"   class="blackbold" >Zip Code  : </td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arrySupplier[0]['ZipCode'])?>" maxlength="15" />			</td>
     
        <td align="right"   class="blackbold" >Mobile  : </td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);"/>			</td>
      </tr>

	  <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
	 <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arrySupplier[0]['Landline'])?>"  maxlength="20" onkeypress="return isNumberKey(event);"/>	

			</td>
    
        <td align="right"   class="blackbold">Fax  : </td>
        <td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arrySupplier[0]['Fax'])?>"  maxlength="20" /> </td>
      </tr> 
	 
 <tr>
        <td align="right" valign="top"   class="blackbold" >Website URL :</td>
        <td align="left" colspan="3"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arrySupplier[0]['Website']))?($arrySupplier[0]['Website']):("http://")?>"  maxlength="100" /> <br> <?=WEBSITE_FORMAT?></td>
      </tr>

	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="SuppID" id="SuppID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arrySupplier[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arrySupplier[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	SetSuppType();
	StateListSend();
</SCRIPT>
