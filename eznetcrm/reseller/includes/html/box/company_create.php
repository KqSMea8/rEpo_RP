<script language="JavaScript1.2" type="text/javascript">
$( document ).ready(function() {
	 
	var TOAM=$("#TotalAmount").val().trim();
	var CR= $("#credit").val();
	
	 if(TOAM>0 && CR=='credit card'){
		//$(".payinfo").hide();
	}else{
		$(".payinfo").hide();
	}
});
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateCompany(frm){
	 var TotalAmt= $("#TotalAmount").val().trim();
	 var credit= $("#credit").val().trim();
	 
	 
	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateMandRange(frm.DisplayName, "User Name",3,30)
		&& isUserName(frm.DisplayName)
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		&& ValidateForSimpleBlank(frm.Password, "Password")
		&& ValidateMandRange(frm.Password, "Password",5,15)
		&& ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)
		){  		
  
			if(TotalAmt>0 && credit=='credit card'){
				
				if(!ValidateForSelect(frm.customer_credit_card_type, "Card Type")){
					return false;	
				}
				if(!ValidateMandRange(frm.customer_credit_card_number, "Card Number",10,20)){
					return false;	
				}

				if(!ValidateMandRange(frm.cc_cvv2_number, "CSV Number",2,5)){
					return false;	
				}

				if(!ValidateForSimpleBlank(frm.customer_address1, "Address")){
					return false;	
				}

				if(!ValidateForSimpleBlank(frm.customer_city, "City")){
					return false;	
				}

				if(!ValidateForSimpleBlank(frm.customer_state, "State")){
					return false;	
				}
				if(!ValidateForSimpleBlank(frm.customer_zip, "Zip Code")){
					return false;	
				}

				if(!isZipCode(frm.customer_zip)){
					return false;	
				}

			}
		
				var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("CmpID").value+"&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

				SendMultipleExistRequest(Url,"Email", "Email Address","DisplayName", "Display Name")

				return false;	
					
			}else{
					return false;	
			}	

		
}
</script>




<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCompany(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Create Account</td>
</tr>

<tr>
        <td  align="right"  width="15%" class="blackbold"> First Name  :<span class="red">*</span> </td>
        <td   align="left" width="30%">
<input name="FirstName" type="text"  class="inputbox" id="FirstName" value="<?php echo stripslashes($arryCompany[0]['FirstName']); ?>"  maxlength="30" />            </td>
     
        <td  align="right"  width="15%" class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text"  class="inputbox" id="LastName" value="<?php echo stripslashes($arryCompany[0]['LastName']); ?>"  maxlength="30" />            </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold"> Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text"  class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryCompany[0]['CompanyName']); ?>"  maxlength="50" />            </td>

        <td  align="right"   class="blackbold"> User Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="DisplayName" type="text" class="inputbox" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_Display','DisplayName','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Display"></span>
</td>
      </tr>
	  

      <tr>
        <td  align="right"   class="blackbold" >Login Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value="<?php echo stripslashes($arryCompany[0]['Password']); ?>"  maxlength="15" />          </td>
     
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value="<?php echo stripslashes($arryCompany[0]['Password']); ?>"  maxlength="15" /> </td>
    
    
      </tr>
	

<tr class="payinfo">
	 <td colspan="4" align="left" class="head">Payment Information</td>
</tr>


<tr class="payinfo">
        <td  align="right"  class="blackbold"> Card Type  :<span class="red">*</span> </td>
        <td   align="left">
<select	class="inputbox" name="customer_credit_card_type"
	id="customer_credit_card_type">
	<option value="Visa">Visa</option>
	<option value="MasterCard"
	<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="MasterCard"){ echo "selected";}?>>MasterCard</option>
	<option value="Discover"
	<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="Discover"){ echo "selected";}?>>Discover</option>
	<option value="Amex"
	<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="Amex"){ echo "selected";}?>>American
	Express</option>
</select>     



      </td>
     
        <td  align="right"   class="blackbold"> Card Number  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="customer_credit_card_number" type="text"  class="inputbox" id="customer_credit_card_number" value="<?php echo stripslashes($arrayOrderInfo[0]['customer_credit_card_number']); ?>"  maxlength="30" onkeypress="return isNumberKey(event);"/>            </td>
      </tr>

<tr class="payinfo">
        <td  align="right"  class="blackbold"> Expiry Month  :<span class="red">*</span> </td>
        <td   align="left">
   <select class="inputbox" name="cc_expiration_month" id="cc_expiration_month">
	<?php
	for($i=1;$i<=12;$i++){?>
	<option value="<?php echo $i;?>"
	<?php if($arrayOrderInfo[0]['cc_expiration_month']==$i){ echo "selected";}?>>
		<?php echo $i;?></option>
	<?php } ?>

</select>
      </td>
     
        <td  align="right"   class="blackbold"> Expiry Year :<span class="red">*</span> </td>
        <td   align="left" >
<select	class="inputbox" name="cc_expiration_year" id="cc-expiration-year">
	<?php
	$startYear=date("Y");

	for($j=$startYear;$j<=$startYear+20;$j++){?>
	<option value="<?php echo $j;?>"
	<?php if($arrayOrderInfo[0]['cc_expiration_year']==$j){ echo "selected";}?>>
		<?php echo $j;?></option>
		<?php } ?>
</select>
        </td>
      </tr>



<tr class="payinfo">
        <td  align="right"  class="blackbold"> CSV Number  :<span class="red">*</span> </td>
        <td   align="left">
<input type="password" class="inputbox" maxlength="5" value="" name="cc_cvv2_number" id="cc-cvv2-number">
      </td>
     
        <td  align="right"   class="blackbold"> Address :<span class="red">*</span> </td>
        <td   align="left" >
<input type="text" class="inputbox" maxlength="200" value="" name="customer_address1" id="customer_address1">
        </td>
      </tr>

<tr class="payinfo">
	
        <td  align="right"  class="blackbold"> City  :<span class="red">*</span> </td>
        <td   align="left">
<input type="text" class="inputbox" maxlength="30" value="" name="customer_city" id="customer_city">
      </td>   
	 <td  align="right"   class="blackbold"> State :<span class="red">*</span> </td>
        <td   align="left" >
<input type="text" class="inputbox" maxlength="30" value="" name="customer_state" id="customer_state">
        </td> 
   </tr>

<tr class="payinfo">
	

    <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryCompany[0]['country_id'] != ''){
		$CountrySelected = $arryCompany[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id">
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>       
             </td>
        <td  align="right"  class="blackbold"> Zip Code  :<span class="red">*</span> </td>
        <td   align="left">
<input type="text" class="inputbox" maxlength="20" value="" name="customer_zip" id="customer_zip">
      </td>    
   </tr>

</table>	
  

	
	  
	
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
      <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"/>

<input type="hidden" name="CouponCode" id="CouponCode" value="<?=$_POST['CouponCode']?>" />
<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="credit" id="credit" value="<?=$PaymentMethodCR?>" />

<?php
		foreach($_POST as $key=>$values){
			echo '<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$values.'">';
		}
			
		?> <input type="hidden" name="PaymentPlan"
	value="<?php echo $arrayPkjName[0]['name'];?>">




</div>

</td>
   </tr>
</form>
</table>


