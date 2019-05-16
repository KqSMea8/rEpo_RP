<script language="JavaScript1.2" type="text/javascript">
function validateReseller(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")		
		&& ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidatePhoneNumber(frm.LandlineNumber,"Landline Number",10,20)
		&& ValidateOptionalUpload(frm.Image, "Image")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		&& ValidateForSimpleBlank(frm.Password, "Password")
		&& ValidateMandRange(frm.Password, "Password",5,15)
		&& ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)
		){  	
			var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+escape(document.getElementById("RsID").value)+"&Type=Reseller";

			SendExistRequest(Url,"Email", "Email Address");

			return false;	
					
		}else{
				return false;	
		}	

		
}
</script>

<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateReseller(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Reseller Details</td>
</tr>

<tr>
        <td  align="right"   class="blackbold"> First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text"  class="inputbox" id="FirstName" value="<?php echo stripslashes($arryReseller[0]['FirstName']); ?>"  maxlength="30" />            </td>
 </tr>

<tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text"  class="inputbox" id="LastName" value="<?php echo stripslashes($arryReseller[0]['LastName']); ?>"  maxlength="30" />            </td>
 </tr>

<tr>
        <td  align="right"   class="blackbold"> Company Name  : </td>
        <td   align="left" >
<input name="CompanyName" type="text"  class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryReseller[0]['CompanyName']); ?>"  maxlength="50" />            </td>
 </tr>

	  

 

 
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryReseller[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryReseller[0]['country_id'] != ''){
		$CountrySelected = $arryReseller[0]['country_id']; 
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
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryReseller[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryReseller[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryReseller[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  

	 

       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryReseller[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :<span class="red">*</span></td>
        <td   align="left" >
	 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryReseller[0]['LandlineNumber'])?>"     maxlength="30" />		
	</td>
      </tr>

<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Image  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

	
		</td>
  </tr>	 


	<tr>
       		 <td colspan="2" align="left" class="head">Login Details</td>
        </tr>
	  

      <tr>
        <td  align="right"   class="blackbold" width="40%">Login Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryReseller[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Reseller','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  

        <tr>
        <td  align="right"   class="blackbold">New Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value="<?php echo stripslashes($arryReseller[0]['Password']); ?>"  maxlength="15" />          <span><?=$MSG[150]?></span></td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value="<?php echo stripslashes($arryReseller[0]['Password']); ?>"  maxlength="15" /> </td>
      </tr>	
	

	  

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryReseller[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryReseller[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <label><input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive</label> </td>
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
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="RsID" id="RsID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryReseller[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryReseller[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
