<script language="JavaScript1.2" type="text/javascript">




function validate_general(frm){

	var DataExist=0;
	var SuppType = Trim(document.getElementById("SuppType")).value;
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
	
		DataExist = CheckExistingData("isRecordExists.php","&CompanyName="+escape(document.getElementById("CompanyName").value)+"&editID="+document.getElementById("SuppID").value, "CompanyName","Company Name");
		if(DataExist==1)return false;
	}
	/**********************/

	var DataExist=0;
	/**********************/
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
		if(!isEmail(frm.Email)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php", "&Type=Supplier&Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value, "Email","Email Address");
		if(DataExist==1)return false;
	}
	/**********************/


	if( ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		//&& isValidLinkOpt(frm.Website,"Website URL")
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


function validate_linkcustomer(frm){
	var SuppID = $("#SuppID").val();
	var CustID = $("#CustID").val();
	$(".message").html("Processing.....");
	if(CustID!=''){
		var sendParam='&action=CustomerLinked&SuppID='+SuppID+'&CustID='+CustID+'&r='+Math.random();  
	
		$.ajax({
			type: "GET",
			async:false,
			url: '../isRecordExists.php',
			data: sendParam,
			success: function (responseText) { 
			   if(responseText==1){
				$(".message").html("This customer is already linked with other vendor.");
				
			   	return false;
			   }else{
				document.forms[0].submit();
				ShowHideLoader('1','S');
				
			   }
			}
		});
		return false;
	}else{			
  		ShowHideLoader('1','S');
		return true;
	}
}




function validate_merge(frm){
	var msg = $("#mergemsg").html() + "Are you sure, you want to continue?";
	
	if(ValidateForSelect(frm.SuppIDMerge,"Vendor")
	){
		
		if(confirm(msg)){
			ShowHideLoader('1','P');
			return true;
		}else{
			return false;
		}
		return false;
	
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
	/**********************/
	/*if(!ValidateForSimpleBlank(frm.Email, "Email Address")){
		return false;
	}*/
	if(document.getElementById("Email").value!=''){
		if(!isEmailOpt(frm.Email)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php", "&Type=Supplier&Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value, "Email","Email Address");
		if(DataExist==1)return false;
	}
	/**********************/


	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(	ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
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
<?php 
	$depids=array();
 	if(!empty($arryDepartment)){
 		foreach($arryDepartment as $arryDepartm){
 			$depids[]=$arryDepartm['depID'];
 			
 		}
 	}
?>


<div class="right_box">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" action="<?=$ActionUrl?>" method="post"
		onSubmit="return validate_<?=$_GET['tab']?>(this);"
		enctype="multipart/form-data">
	<tr>
		<td align="center" class="message"><? if(!empty($_SESSION['mess_supplier'])) {echo $_SESSION['mess_supplier']; unset($_SESSION['mess_supplier']); }?>
		</td>
	</tr>


	<tr>
		<td align="center" valign="top">


		<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">




			<? if($_GET["tab"]=="general"){ ?>
			<tr>
				<td colspan="4" align="left" class="head">General Information</td>
			</tr>
			<tr>
				<td align="right" class="blackbold" width="13%">Vendor Code :</td>
				<td align="left" width="45%"><?php echo stripslashes($arrySupplier[0]['SuppCode']); ?>
				</td>
			
        <td  align="right" class="blackbold" width="15%">Vendor Type  :<span
					class="red">*</span></td>
        <td   align="left">
		  <select name="SuppType" class="inputbox" id="SuppType" onchange="Javascript:SetSuppType();">
		  	<option value="Business" <?  if($arrySupplier[0]['SuppType']=="Business"){echo "selected";}?>>Business</option>
			<option value="Individual" <?  if($arrySupplier[0]['SuppType']=="Individual"){echo "selected";}?>>Individual</option>				
		</select> 
	</td>
</tr>



<? if($arryCurrentLocation[0]['country_id']!=106){?>
<tr id="ssntr" <? if($arrySupplier[0]['SuppType']!='Individual'){ echo 'style="display:none"'; } ?>>
        <td align="right"   class="blackbold">Social Security Number  :<span
					class="red">*</span> </td>
        <td  align="left" colspan="3">
		<input name="SSN" type="text" class="inputbox" id="SSN" value="<?=stripslashes($arrySupplier[0]['SSN'])?>"  maxlength="11"  /> <?=SSN_FORMAT?></td>

       
</tr>

<tr id="eintr" <? if($arrySupplier[0]['SuppType']=='Individual'){ echo 'style="display:none"'; } ?>>
        <td align="right"   class="blackbold">EIN  :  </td>
        <td  align="left" colspan="3">
		<input name="EIN" type="text" class="inputbox" id="EIN" value="<?=stripslashes($arrySupplier[0]['EIN'])?>" placeholder="Format : XX-XXXXXXX "  maxlength="10"  /> <?/*=EIN_FORMAT*/?> </td>
       
</tr>
 
<? } ?>



			<tr>
 <td  align="right" class="blackbold">1099  :</td>
        <td   align="left">
		  <select name="TenNine" class="textbox" style="width:50px;" id="TenNine">
		  	<option value="0" <?  if($arrySupplier[0]['TenNine']=="0"){echo "selected";}?>>No</option>
			<option value="1" <?  if($arrySupplier[0]['TenNine']=="1"){echo "selected";}?>>Yes</option>				
		</select> 
	</td>
				<td align="right" class="blackbold"  >Company Name :<span
					class="red" id="cmpred">*</span></td>
				<td align="left"><input name="CompanyName" type="text"
					class="inputbox" id="CompanyName"
					value="<?php echo stripslashes($arrySupplier[0]['CompanyName']); ?>"
					maxlength="40"
					onKeyPress="Javascript:ClearAvail('MsgSpan_Company');return isAlphaKey(event);"
					onBlur="Javascript:CheckAvailField('MsgSpan_Company','CompanyName','<?=$_GET['edit']?>');" />

				<span id="MsgSpan_Company"></span></td>
			</tr>



			<tr>
				<td align="right" class="blackbold">First Name :<span class="red" id="fred">*</span>
				</td>
				<td align="left"><input name="FirstName" type="text"
					class="inputbox" id="FirstName"
					value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"
					maxlength="50" onkeypress="return isCharKey(event);" /></td>
			
				<td align="right" class="blackbold">Last Name :
				</td>
				<td align="left"><input name="LastName" type="text" class="inputbox"
					id="LastName"
					value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"
					maxlength="50" onkeypress="return isCharKey(event);" /></td>
			</tr>
<SCRIPT LANGUAGE=JAVASCRIPT>
	SetSuppType();
</SCRIPT>
			<tr>
				<td align="right" class="blackbold">Email :
				</td>
				<td align="left"><input name="Email" type="text" class="inputbox"
					id="Email" value="<?php echo $arrySupplier[0]['Email']; ?>"
					maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');"
					onBlur="Javascript:CheckAvail('MsgSpan_Email','Supplier','<?=$_GET['edit']?>');" />

				<span id="MsgSpan_Email"></span></td>
			
				<td align="right" class="blackbold">Mobile : </td>
				<td align="left"><input name="Mobile" type="text" class="inputbox"
					id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"
					maxlength="20" onkeypress="return isNumberKey(event);"/></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Landline :</td>
				<td align="left"><input name="Landline" type="text" class="inputbox"
					id="Landline"
					value="<?=stripslashes($arrySupplier[0]['Landline'])?>"
					maxlength="20" onkeypress="return isNumberKey(event);"/></td>
			
				<td align="right" class="blackbold">Fax :</td>
				<td align="left"><input name="Fax" type="text" class="inputbox"
					id="Fax" value="<?=stripslashes($arrySupplier[0]['Fax'])?>"
					maxlength="20" /></td>
			</tr>

			


			<tr>
				<td align="right" class="blackbold">Currency :</td>
				<td align="left">
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
</select></td>
			
				<td align="right" class="blackbold">Vendor Since :</td>
				<td align="left"><script type="text/javascript">
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
</script> <? 	
$SupplierSince = ($arrySupplier[0]['SupplierSince']>0)?($arrySupplier[0]['SupplierSince']):("");
?> <input id="SupplierSince" name="SupplierSince" readonly=""
					class="datebox" value="<?=$SupplierSince?>" type="text"></td>
			</tr>

		
			<tr>
				<td align="right" class="blackbold">Payment Term :</td>
				<td align="left"><select name="PaymentTerm" class="inputbox"
					id="PaymentTerm">
					<option value="">--- None ---</option>
					<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						if($arryPaymentTerm[$i]['termType']==1){
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
						}else{
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
						}
						?>
					<option value="<?=$PaymentTerm?>"
					<?  if($PaymentTerm==$arrySupplier[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
					<? } ?>
				</select></td>
			
				<!--td align="right" class="blackbold">Payment Method :</td>
				<td align="left"><select name="PaymentMethod" class="inputbox"
					id="PaymentMethod">
					<option value="">--- None ---</option>
					<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>"
					<?  if($arryPaymentMethod[$i]['attribute_value']==$arrySupplier[0]['PaymentMethod']){echo "selected";}?>>
						<?=$arryPaymentMethod[$i]['attribute_value']?></option>
						<? } ?>
				</select></td-->
				
							
<td align="right"   class="blackbold" >Credit Limit  :</td>
	<td  align="left" >
	<?  
	$CreditLimit = (!empty($arrySupplier[0]['CreditLimit'])?($arrySupplier[0]['CreditLimit']):("")); 

	?>


	<input name="CreditLimit" type="text" class="textbox" size="10" id="CreditLimit" value="<?=$CreditLimit?>" maxlength="10" onkeypress="return isDecimalKey(event);" />	 <?=$Config['Currency']?>
		  
	  </td>

<? if($arrySupplier[0]['CreditLimit']>0){ ?> 
<td align="right"   class="blackbold" >Current Credit Balance  :</td>
	<td  align="left" style="font-weight:bold" >

<span name="CreditBalance" id="CreditBalance" /><?=$CreditBalance?></span>	 <span name="CreditBalanceCurrency" id="CreditBalanceCurrency" /><?=$Config['Currency']?></span>
		  
	  </td>
<? } ?>
				
			</tr>

	


<?
/*if($arrySupplier[0]['CreditAmount']>0){
		echo '<tr>
			<td align="right" >Vendor Credit : </td>
			<td align="left" colspan="3" style="font-weight:bold">	 
	 '.$arrySupplier[0]['CreditAmount'].' '.$Config['Currency'].'</td>
		</tr>';
	}*/

?>




<tr>
				<td align="right" class="blackbold">Website URL :</td>
				<td align="left"  >
<input name="Website" type="text" class="inputbox" id="Website"
value="<?=(!empty($arrySupplier[0]['Website']))?($arrySupplier[0]['Website']):('http://')?>" maxlength="100" /> <br><?=WEBSITE_FORMAT?></td>

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
<?
/********** Abid *************/
if($arryCurrentLocation[0]['country_id']=='106' || $arryCurrentLocation[0]['country_id']=='234'){ ?>
 <tr>
		<td  align="right" class="blackbold">VAT No :</td>
               <td  align="left" >
		<input name="VAT"  type="text" class="inputbox" id="VAT" value="<?=stripslashes($arrySupplier[0]['VAT'])?>"  maxlength="20" onkeypress="return isUniqueKey(event);" />  </td>
	
		<td  align="right"   class="blackbold">CST No :</td>
                <td  align="left" >
		<input name="CST"  type="text" class="inputbox" id="CST" value="<?=stripslashes($arrySupplier[0]['CST'])?>"  maxlength="20" onkeypress="return isUniqueKey(event);" />  </td>
	</tr>

<tr>
		<td  align="right" class="blackbold">TRN No :</td>
               <td  align="left" >
		<input name="TRN"  type="text" class="inputbox" id="TRN" value="<?=stripslashes($arrySupplier[0]['TRN'])?>"  maxlength="20" onkeypress="return isUniqueKey(event);"/>  </td>
	
		 
	</tr>

<?php 
} 
/********* End Abid *********/
?>

<tr>
        <td  align="right"   class="blackbold" >Credit Card Vendor  : </td>
        <td   align="left"  >
         <input type="checkbox" name="CreditCard" value="1" <?  if($arrySupplier[0]['CreditCard']=="1"){echo "checked";}?>>

 </td>
    
        <td  align="right"   class="blackbold" >Hold Payment   : </td>
        <td   align="left"  >
         <input type="checkbox" name="HoldPayment" value="1" <?  if($arrySupplier[0]['HoldPayment']=="1"){echo "checked";}?>>

 </td>
      </tr>





			<tr>
				<td align="right" class="blackbold">Status :</td>
				<td align="left"><? 
				$ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arrySupplier[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arrySupplier[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			 }
		  ?> <input type="radio" name="Status" id="Status" value="1"
		  <?=$ActiveChecked?> /> Active&nbsp;&nbsp;&nbsp;&nbsp; <input
					type="radio" name="Status" id="Status" value="0"
					<?=$InActiveChecked?> /> InActive</td>


			<!----Added by chetan Mar16--->
    <td  align="right"    class="blackbold" > Primary Vendor :</td>
    <td  align="left">
	<input type="checkbox" <?php if($arrySupplier[0]['primaryVendor'] == 1){ echo "checked";} ?> name="primaryVendor" id="primaryVendor" value = "1"> </td>

<!----End--->


			</tr>
			
			
 

<tr>
        <td  align="right"   class="blackbold" 
		>Taxable  : </td>
        <td   align="left"  >
          <? 
		  	 $NoChecked = 'checked';$YesChecked = '';
				$DisplayYes = 'Display:none;';
 if($_GET['edit'] > 0){
				 if($arrySupplier[0]['Taxable'] == 'Yes') {$YesChecked = ' checked'; $NoChecked =''; $DisplayYes = '';}
				 if($arrySupplier[0]['Taxable'] == 'No') {$YesChecked = ''; $NoChecked = ' checked'; $DisplayYes = 'Display:none;';}
			 }

			
		  ?>
          <input type="radio" name="Taxable" id="TaxableYes" value="Yes" <?=$YesChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Taxable" id="TaxableNo" value="No" <?=$NoChecked?> />
          No </td>
          
          <td  align="right" class="blackbold" > Default Vendor:</td>
    <td  align="left">
	
	
	<input type="checkbox" <?php if($arrySupplier[0]['defaultVendor'] == 1){ echo "checked";} ?> name="defaultVendor" id="defaultVendor" value = "1"> 
	 </td>
<!---End---->
      </tr>

<tr id="TaxRateSh" style="<?=$DisplayYes?>">
        <td  align="right"   class="blackbold"> Tax Rate  : </td>
        <td   align="left" >
	
    <select name="TaxRate" class="inputbox" id="TaxRate" >
			 <option value="">--- None ---</option>
              <?
$arrRate[0]=$arrRate[1]=$arrRate[2]='';
if($arrySupplier[0]['TaxRate']!=''){
	$arrRate = explode(":",$arrySupplier[0]['TaxRate']);
}

 for($i=0;$i<sizeof($arryPurchaseTax);$i++) {

								$Selected = ($arrRate[0] == $arryPurchaseTax[$i]['RateId'] && $arrRate[2] == $arryPurchaseTax[$i]['TaxRate'])?(" Selected"):("");		

								$taxRateVal = "".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['RateDescription'].":".$arryPurchaseTax[$i]['TaxRate']."";
								$taxRateName = "".$arryPurchaseTax[$i]['RateDescription'].":".$arryPurchaseTax[$i]['TaxRate']."";
								?>              
								<option value="<?=$taxRateVal?>" <?=$Selected?>> <?=$taxRateName?> </option>
              <? } ?>
     </select>       

			 </td>
      </tr>
			<? } 


?>

			<? if($_GET['tab'] == "contacts"){ ?>
			<tr>
				<td colspan="2" align="left" class="head">Contacts</td>
			</tr>
			<tr>
				<td colspan="2" align="left"><? 
				$SuppID = $_GET['edit'];
				include("includes/html/box/supplier_contacts.php");
				?></td>
			</tr>
			<? } ?>


			<? if($_GET["tab"]=="contact"){ ?>

			<tr>
				<td colspan="2" align="left" class="head">Contact Information</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">First Name :<span class="red">*</span>
				</td>
				<td align="left"><input name="FirstName" type="text"
					class="inputbox" id="FirstName"
					value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"
					maxlength="50" onkeypress="return isCharKey(event);" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Last Name :
				</td>
				<td align="left"><input name="LastName" type="text" class="inputbox"
					id="LastName"
					value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"
					maxlength="50" onkeypress="return isCharKey(event);" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Email :<span class="red">*</span>
				</td>
				<td align="left"><input name="Email" type="text" class="inputbox"
					id="Email" value="<?php echo $arrySupplier[0]['Email']; ?>"
					maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');"
					onBlur="Javascript:CheckAvail('MsgSpan_Email','Supplier','<?=$_GET['edit']?>');" />

				<span id="MsgSpan_Email"></span></td>
			</tr>
			<tr>
				<td align="right" class="blackbold" valign="top" width="45%">Address
				:<span class="red">*</span></td>
				<td align="left"><textarea name="Address" type="text"
					class="textarea" id="Address" maxlength="200"><?=stripslashes($arrySupplier[0]['Address'])?></textarea>
				</td>
			</tr>

			<tr <?=$Config['CountryDisplay']?>>
				<td align="right" class="blackbold">Country :</td>
				<td align="left"><?
				if(!empty($arrySupplier[0]['country_id'])){
					$CountrySelected = $arrySupplier[0]['country_id'];
				}else{
					$CountrySelected = $arryCurrentLocation[0]['country_id'];
				}
				?> <select name="country_id" class="inputbox" id="country_id"
					onChange="Javascript: StateListSend();">
					<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
					<option value="<?=$arryCountry[$i]['country_id']?>"
					<?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
						<?=$arryCountry[$i]['name']?></option>
						<? } ?>
				</select></td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="blackbold">State :</td>
				<td align="left" id="state_td" class="blacknormal">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" class="blackbold">
				<div id="StateTitleDiv">Other State :</div>
				</td>
				<td align="left">
				<div id="StateValueDiv"><input name="OtherState" type="text"
					class="inputbox" id="OtherState"
					value="<?php echo $arrySupplier[0]['OtherState']; ?>"
					maxlength="30" /></div>
				</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">
				<div id="MainCityTitleDiv">City :</div>
				</td>
				<td align="left">
				<div id="city_td"></div>
				</td>
			</tr>
			<tr>
				<td align="right" class="blackbold">
				<div id="CityTitleDiv">Other City :</div>
				</td>
				<td align="left">
				<div id="CityValueDiv"><input name="OtherCity" type="text"
					class="inputbox" id="OtherCity"
					value="<?php echo $arrySupplier[0]['OtherCity']; ?>" maxlength="30" />
				</div>
				</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Zip Code :<span class="red">*</span></td>
				<td align="left"><input name="ZipCode" type="text" class="inputbox"
					id="ZipCode" value="<?=stripslashes($arrySupplier[0]['ZipCode'])?>"
					maxlength="15" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Mobile :<span class="red">*</span></td>
				<td align="left"><input name="Mobile" type="text" class="inputbox"
					id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"
					maxlength="20" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Landline :</td>
				<td align="left"><input name="Landline" type="text" class="inputbox"
					id="Landline"
					value="<?=stripslashes($arrySupplier[0]['Landline'])?>"
					maxlength="20" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Fax :</td>
				<td align="left"><input name="Fax" type="text" class="inputbox"
					id="Fax" value="<?=stripslashes($arrySupplier[0]['Fax'])?>"
					maxlength="20" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Website URL :</td>
				<td align="left"><input name="Website" type="text" class="inputbox"
					id="Website"
					value="<?=(!empty($arrySupplier[0]['Website']))?($arrySupplier[0]['Website']):("")?>"
					maxlength="100" /> <?=WEBSITE_FORMAT?></td>
			</tr>

			<input type="hidden" name="main_state_id" id="main_state_id"
				value="<?php echo $arrySupplier[0]['state_id']; ?>" />
			<input type="hidden" name="main_city_id" id="main_city_id"
				value="<?php echo $arrySupplier[0]['city_id']; ?>" />


				<? } ?>





				<? if($_GET["tab"]=="bank"){ ?>


			<tr>
				<td colspan="2" align="left" class="head">Bank Details</td>
			</tr>

			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>


			<tr>
				<td colspan="2" align="left"><? 
				$SuppID = $_GET['edit'];
				include("includes/html/box/supplier_bank.php");
				?></td>
			</tr>


			<!--tr>
				<td align="right" class="blackbold" width="45%">Bank Name :<span
					class="red">*</span></td>
				<td align="left"><input type="text" name="BankName" maxlength="40"
					class="inputbox" id="BankName"
					value="<?=stripslashes($arrySupplier[0]['BankName'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Account Name :<span class="red">*</span>
				</td>
				<td align="left"><input type="text" name="AccountName"
					maxlength="30" class="inputbox" id="AccountName"
					value="<?=stripslashes($arrySupplier[0]['AccountName'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Account Number :<span
					class="red">*</span></td>
				<td align="left"><input type="text" name="AccountNumber"
					maxlength="30" class="inputbox" id="AccountNumber"
					value="<?=stripslashes($arrySupplier[0]['AccountNumber'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Routing Number :<span
					class="red">*</span></td>
				<td align="left"><input type="text" name="IFSCCode" maxlength="30"
					class="inputbox" id="IFSCCode"
					value="<?=stripslashes($arrySupplier[0]['IFSCCode'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr-->


			<? } ?>




<? if($_GET["tab"]=="linkcustomer"){
	$arryLinkCustVen = $objBankAccount->GetCustomerVendor('',$SuppID);
	
	if(!empty($arryLinkCustVen[0]['CustID'])){
		$CustID = $arryLinkCustVen[0]['CustID'];
		$arryCustomer = $objBankAccount->GetCustomer($CustID,'','');
	}else{
		$CustID='';
		$arryCustomer[0]['CustCode']=$arryCustomer[0]['CustomerName']='';
	}

	$clear = '<img src="'.$Config['Url'].'admin/images/clear.gif" border="0"  onMouseover="ddrivetip(\'<center>Clear</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';

 ?>
 			
	<tr>
       		<td colspan="2" align="left" class="head">Link Customer</td>
        </tr>
		
	  <tr>
       		 <td colspan="2">&nbsp;</td>
          </tr>	

	
	<tr>
	<td align="right" width="45%" class="blackbold" > Customer Code : </td>
	<td align="left" >
	<input name="CustCode" type="text" readonly class="disabled" style="width:90px;" id="CustCode" value="<?php echo stripslashes($arryCustomer[0]['CustCode']); ?>" maxlength="40" readonly />
<input name="CustID" type="hidden" readonly class="disabled" id="CustID" value="<?=$CustID?>" maxlength="40" readonly />
	<a class="fancybox fancycust fancybox.iframe" href="../CustomerList.php" ><?=$search?></a>
<a href="Javascript:ClearCustomer();" ><?=$clear?></a>  
	</td>
	</tr>


	<tr>
	<td align="right" class="blackbold" > Customer Name : </td>
	<td align="left" >
	<input name="CustomerName" type="text" readonly class="disabled"  id="CustomerName" value="<?php echo stripslashes($arryCustomer[0]['CustomerName']); ?>" maxlength="50" onkeypress="return isCharKey(event);"/> </td>
	</tr>


	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
<SCRIPT LANGUAGE=JAVASCRIPT>
function ClearCustomer(){
	document.getElementById("CustCode").value='';
	document.getElementById("CustID").value='';
	document.getElementById("CustomerName").value='';
}


$(document).ready(function() {
		$(".fancycust").fancybox({
			'width'         : 1000
		 });

});
</SCRIPT>


  <? } ?>


	<? if($_GET["tab"]=="merge"){ 

	 $arryVendor = $objSupplier->GetSupplierBrief('');

?>
			
		<tr>
       		 <td colspan="2" align="left" class="head">Merge Vendor</td>
        </tr>
		
	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
	 <tr>
        <td  align="right"   class="blackbold" width="45%" valign="top"> Select Vendor  :</td>
        <td   align="left" >
		
<select name="SuppIDMerge" id="SuppIDMerge" class="inputbox"  >
	<option value="">--- Select ---</option>
	<?php foreach($arryVendor as $values){
	if($values['SuppID']!=$SuppID){
	?>
	<option value="<?=$values['SuppID']?>"> <?=stripslashes($values['CompanyName'])?></option>
	<?php }}?>
</select>

   </td>
      </tr>
 <tr>
		 <td>&nbsp;</td>
       		 <td class=redmsg>Note: <span id="mergemsg" ><?=MERGE_VENDOR_MSG?></span></td>
        </tr>

	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
              <? } ?>

              <?
              if($_GET["tab"]=="shipping" || $_GET["tab"]=="billing"){
              	include("includes/html/box/shipping_billing.php");
              }
              ?>
              <?
              /************************* For Login Permission tab ***************************/

              if($_GET["tab"]=="LoginPermission"){              	
              			$permissionmenu=array(	)	;	
							if(in_array(5,$depids)){															
							//	$permissionmenu['quote']='Quotes';
							//$permissionmenu['document']='Documents';
							$permissionmenu['contact']='Contacts';
							$permissionmenu['bank']='Bank Details';
								}		
							if(in_array(6,$depids)){
								$permissionmenu['invoice']='Invoice';
								$permissionmenu['purchaseorder']='Purchase Order';
								$permissionmenu['salesorder']='Sales Orders';
								$permissionmenu['shipping']='Shipping Address';
								$permissionmenu['billing']='Billing Address';																
														}
              	
              	
              	
              	if(!empty($userlogindetail)){?>
			<tr>
				<td colspan="4" align="left" class="head">Login / Permission Detail</td>
			</tr>

			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>

			<tr>
				<td align="right" class="blackbold" width="45%">User Name :<span
					class="red">*</span></td>
				<td align="left"><?php echo $userlogindetail->user_name;?></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Password :</td>
				<td align="left"><a
					href="../chCustomerVendorPass.php?custId=<?php echo $userlogindetail->ref_id;?>&custloginId=<?php echo $userlogindetail->id;?>"
					class="fancybox fancybox.iframe punch">Change Password</a></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Permission :<span class="red">*</span>
				</td>
				<td align="left"><?php
				$mypermision=array();
				if(!empty($userlogindetail->permission))
				$mypermision=unserialize($userlogindetail->permission);
				if(!empty($permissionmenu)){
					foreach($permissionmenu as $k=>$permission){
						$chek='';
						if(in_array($k,$mypermision))
						$chek='checked="checked"';
						echo '<div class="permission-box"><span class="input check"><input type="checkbox" '.$chek.' value="'.$k.'" name="permission[]"/></span><label>'.$permission.'</label></div>';
					}
				}?> <input type="hidden" name="company_userid"
					value="<?php echo $userlogindetail->id?>">
					<input type='hidden' name='AddType' value='LoginPermission'></td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>

			<? }else{

				echo _("<div style='font-size:15px'>Vendor has no login account.</div> <div><input name='Email' type='hidden' value='".$arrySupplier[0]['Email']."' /><input type='hidden' name='ganeratelogin' value='ganerate'><input type='hidden' name='AddType' value='LoginPermission'>  <input type='hidden' name='SuppID' id='SuppID' value='".$_GET['edit']."' /><input type='submit' name='ganerate' value='Generate' class='button'></div>");
				$HideSubmit=1;
			}
              } ?>



		</table>








		</td>
	</tr>


	<? if($HideSubmit!=1){ ?>
	<tr>
		<td align="center"><br />
		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton"	value=" <?=$ButtonTitle?> " />
      <input type="hidden" name="SuppID"	id="SuppID" value="<?=$_GET['edit']?>" /> 
			<input type="hidden"	name="UserID" id="UserID" value="<?=$arrySupplier[0]['UserID']?>" />


		</div>

		</td>
	</tr>
	<? } ?></form>
</table>
</div>


<? 
if($_GET["tab"]=="general"){  
	include("includes/html/box/vendor_aging.php");
}else if($_GET["tab"]=="invoice"){   
   include("includes/html/box/vendor_invoice.php");
}else if($_GET["tab"]=="payment"){   
   include("includes/html/box/vendor_payment.php");
}else if($_GET["tab"]=="deposit"){   
   include("includes/html/box/vendor_deposit.php");
}else if($_GET["tab"]=="purchase"){   
   include("includes/html/box/vendor_purchase_history.php");
}else if($_GET["tab"]=="purchasehistory"){  //added by Nisha for purchase history tab. 
   include("includes/html/box/vendor_purchasehistory.php");
}
else if($_GET["tab"]=="sales"){  //added by Nisha for Sales Commision tab. 
$SuppID = $_GET['edit'];
  include("../includes/html/box/commission_form.php");
}   


?>


<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact" || $_GET["tab"]=="billing" || $_GET["tab"]=="shipping"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>





