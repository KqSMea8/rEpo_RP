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

	ShowHideLoader('1','S');

	/*
	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateMandRange(frm.CompanyName, "Company Name",3,30)
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmail(frm.Email)
		){
			var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value+"&CompanyName="+escape(document.getElementById("CompanyName").value)+"&Type=Supplier";
			SendMultipleExistRequest(Url,"Email", "Email Address","CompanyName", "Company Name")
			return false;	
			
		}else{
			return false;	
		}*/	
}

function validate_bank(frm){
	if( ValidateForSimpleBlank(frm.BankName, "Bank Name")
		&& ValidateForSimpleBlank(frm.AccountName, "Account Name")
		&& ValidateAccountNumber(frm.AccountNumber,"Account Number",10,20)
		&& ValidateForSimpleBlank(frm.IFSCCode,"IFSC Code")
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
function validateCargo(frm){
	
	var DataExist=0;
	/**********************/
	//var SuppCode = Trim(document.getElementById("SuppCode")).value;

	/**********************/
	
	
	/**********************/
	
	if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
		return false;
	}

	if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
		return false;
	}
	
	if( ValidateForTextareaMand(frm.Address,"Address",10,200)
		){
				
				ShowHideLoader('1','S');
				
				/*	var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value+"&CompanyName="+escape(document.getElementById("CompanyName").value)+"&Type=Supplier";
				SendMultipleExistRequest(Url,"Email", "Email Address","CompanyName", "Company Name")
				return false;	
				*/
				return true;
					
		}
		
	if(ValidateOptPhoneNumber(frm.Mobile, "Mobile No")){
		return false;
	}
	
	if(!ValidateForSimpleBlank(frm.Mobile, "Mobile No")){
		return false;
	}
	
	else{
				return false;	
		}	
		
}





</script>



	




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateCargo(this);" enctype="multipart/form-data">
  
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
	 <td colspan="4" align="left" class="head">General Information</td>
</tr>
<tr>
        <td  align="right" width="25%"   class="blackbold"> Release Number  : </td>
        <td   align="left" ><strong><?php echo stripslashes($arryCargo[0]['SuppCode']); ?></strong>
	</td>

        <td  align="right"   class="blackbold" >Release Date :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReleaseDate').datepicker(
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
$ReleaseDate = ($arryCargo[0]['ReleaseDate']>0)?($arryCargo[0]['ReleaseDate']):(""); 
?>
<input id="ReleaseDate" name="ReleaseDate" readonly="" class="datebox" value="<?=$ReleaseDate?>"  type="text" > 


</td>
      </tr>


<tr>
        <td  align="right" class="blackbold">Released By  :</td>
			<td   align="left" width="30%">
				<input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arryCargo[0]['ReleaseBy']); ?>"  maxlength="40" readonly />
				<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arryCargo[0]['SalesPersonID']); ?>" type="hidden">
		
				<a class="fancybox fancybox.iframe" href="EmpList.php?dv=7"  ><?=$search?></a>
				

			</td>
 

        <td  align="right" class="blackbold">Release To  :</td>
             <td   align="left" >
		<input name="CustomerName" type="text" class="disabled_inputbox"  id="CustomerName" value="<?php echo stripslashes($arryCargo[0]['ReleaseTo']); ?>"  maxlength="60" readonly />
		<input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arryCargo[0]['CustCode']); ?>">
		<input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arryCargo[0]['CustID']); ?>">


	<a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>

	</td>
</tr>

<tr>
        <td  align="right" class="blackbold">Carrier Name  :</td>
        <td   align="left">
		  <select name="CarrierName" class="inputbox" id="CarrierName">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryCargo[0]['CarrierName']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>

<tr>
       		 <td colspan="4" align="left"   class="head">Package Information</td>
        </tr>
   
	   <tr>
        <td  align="right"   class="blackbold"> Shipment Number  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryCargo[0]['ShipmentNo']); ?></strong></td>
     
        <td  align="right"   class="blackbold"> Package Load  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="PackageLoad" type="text" class="inputbox" id="PackageLoad" value="<?php echo stripslashes($arryCargo[0]['PackageLoad']); ?>" size="5" width="12"  maxlength="30" />  </td>
      </tr>

	<tr>
       		 <td colspan="4" align="left"   class="head">Driver Information</td>
        </tr>
   
	  
<tr>
        <td  align="right"   class="blackbold"  > First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryCargo[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryCargo[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   
 <tr>
        <td  align="right"   class="blackbold"> Licence Number :<span class="red">*</span> </td>
        <td   align="left" ><strong><?php echo $arryCargo[0]['LicenseNo']; ?></strong>
		
	 <span id="MsgSpan_Email"></span>		</td>
     
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryCargo[0]['Address'])?></textarea>			          </td>
        </tr>
         
	
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryCargo[0]['Mobile'])?>"     maxlength="20" />			</td>
     

	<? 
	//$arryExisting = $arryCargo;
	//include("includes/html/box/custom_field_form.php");
	?>


        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryCargo[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryCargo[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
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
		$CountrySelected = 1;
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
        <td  align="right"   class="blackbold"> IFSC Code  :<span class="red">*</span> </td>
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
   </form>
</table>
</div>


<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact" || $_GET["tab"]=="billing" || $_GET["tab"]=="shipping"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>





