<script language="JavaScript1.2" type="text/javascript">
function validateCompany(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
	&& ValidateForSimpleBlank(frm.Address,"Address")
	&& isZipCode(frm.ZipCode)		
	&& ValidateForSimpleBlank(frm.Email, "Email")
	&& isEmail(frm.Email)
	&& ValidateForSimpleBlank(frm.Password, "Password")
	&& ValidateMandRange(frm.Password, "Password",5,15)
	&& ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)
	){  
		ShowHideLoader(1,'P');
		return true;				
	}else{
		return false;	
	}	

		
}
</script>



<? if(!empty($_SESSION['mess_installed'])) { ?>

	<? 
	$Step4 = 'class=active';
	require_once("includes/nav.php");
	?>
	<div class="success" align="center"><br><br><br><br><? echo $_SESSION['mess_installed']; unset($_SESSION['LicenseKey']);
	unset($_SESSION['DisplayName']); ?></div>
<? }else{ ?>


	<? 
	$Step3 = 'class=active';
	require_once("includes/nav.php");
	?>
<br><br><br>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCompany(this);" enctype="multipart/form-data">
   <tr>
    <td align="left" class="success">	
		<?=DB_CREATED_SUCCESS?>
	</td>
   </tr>
<tr>
    <td align="center" class="redmsg">	
		<? echo $_SESSION['mess_cmp']; unset($_SESSION['mess_cmp']); ?>
	</td>
   </tr>
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Company Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text"  class="inputbox" id="CompanyName" value="<?php echo stripslashes($_POST['CompanyName']); ?>"  maxlength="50" />            </td>
      </tr>
 
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <input name="Address" type="text" class="inputbox" id="Address" value="<?php echo stripslashes($_POST['Address']); ?>" maxlength="100">       </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($_POST['country_id'] != ''){
		$CountrySelected = $_POST['country_id']; 
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
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $_POST['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $_POST['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" valign="top">Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($_POST['ZipCode'])?>" maxlength="15" autocomplete="off"  />			


</td>
      </tr>


		  

      <tr>
        <td  align="right"   class="blackbold" width="46%">Login Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $_POST['Email']; ?>"  maxlength="80" />
		
		</td>
      </tr>
	  
	
        <tr>
        <td  align="right"   class="blackbold">New Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value=""  maxlength="15" />          </td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value=""  maxlength="15" /> </td>
      </tr>	

	 

	
</table>	
  

	
	  
	
	</td>
   </tr>

   

<tr>
<td  align="center">
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit "  />
	<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $_POST['state_id']; ?>" />	
	<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $_POST['city_id']; ?>" />
</td>
</tr>

   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();	
</SCRIPT>
<? } ?>
