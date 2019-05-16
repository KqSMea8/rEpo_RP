<script language="JavaScript1.2" type="text/javascript">
function validate_company(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateForTextareaMand(frm.Description,"Description",10,1000)
		&& ValidateOptionalUpload(frm.Image, "Image")
		&& ValidateForSimpleBlank(frm.ContactPerson, "Contact Person")
		&& ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& isEmailOpt(frm.AlternateEmail)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.LandlineNumber,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		){
			ShowHideLoader(1,'S');
			return true;	
		}else{
			return false;	
		}	
}

function validate_global(frm){
	if( ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")
		){
			ShowHideLoader(1,'S');
			return true;	
		}else{
			return false;	
		}	
}



function validate_DateTime(frm){
	if( ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")
		){
			ShowHideLoader(1,'S');
			return true;	
		}else{
			return false;	
		}	
}

function validate_currency(frm){
	ShowHideLoader(1,'S');
}

function validate_account(frm){
	if( //ValidateMandRange(frm.DisplayName, "Display Name",3,30)
		//&& isDisplayName(frm.DisplayName)
		ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){
		

			if(document.getElementById("Password").value!=""){
				if(!ValidateForSimpleBlank(frm.Password, "Password")){
					return false;
				}
				/*if(!isPassword(frm.Password)){
					return false;
				}*/
				if(!ValidateMandRange(frm.Password, "Password",5,15)){
					return false;
				}
				if(!ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)){
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





<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_company'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >




  

<? if($_GET["tab"]=="company"){ ?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Company Details</td>
</tr>
 <tr>
          <td align="right"  class="blackbold" valign="top">Users Limit  :</td>
          <td  align="left" > <strong><?=$arryCompany[0]['MaxUser']?></strong> </td>
        </tr>	


<tr>
          <td align="right"   class="blackbold" valign="top">Total Storage :</td>
          <td  align="left" > <strong>
<? echo ($arryCompany[0]['StorageLimit']!='')?($arryCompany[0]['StorageLimit'].' '.$arryCompany[0]['StorageLimitUnit']):('Unlimited'); ?> 
</strong></td>
    </tr>

<? if($arryCompany[0]['StorageLimit']>0){ ?>
<tr>
          <td align="right"   class="blackbold" valign="top">Storage Used :</td>
          <td  align="left" > <strong>
<?  
$UsedStorage = $arryCompany[0]['Storage']; //kb
if($UsedStorage>0){
	if($UsedStorage<1024){
		echo $UsedStorage.' KB';
	}else if($UsedStorage<1024*1024){
		echo round($UsedStorage/1024,2).' MB';
	}else if($UsedStorage<1024*1024*1024){
		echo round(($UsedStorage/(1024*1024)),8).' GB';
	}else{
		echo round(($UsedStorage/(1024*1024*1024)),8).' TB';
	}
}else{
	echo '0';
}
?> 
</strong>
</td>
    </tr>
<? } ?>


<tr>
        <td  align="right"   class="blackbold" width="35%"> Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryCompany[0]['CompanyName']); ?>"  maxlength="50" />            </td>
      </tr>

	
 <tr>
          <td align="right"   class="blackbold" valign="top">Description  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Description" type="text" class="bigbox" id="Description" maxlength="500"><?=stripslashes($arryCompany[0]['Description'])?></textarea>			          </td>
        </tr>		  
	   


<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Logo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	
	
	
		</td>
  </tr>	  

	
	<tr>
        <td  align="right"   class="blackbold"> Contact Person  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="ContactPerson" type="text" class="inputbox" id="ContactPerson" value="<?php echo stripslashes($arryCompany[0]['ContactPerson']); ?>"  maxlength="30" />            </td>
      </tr>	 
  
        <tr>
          <td align="right"   class="blackbold" valign="top"> Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address" maxlength="200"><?=stripslashes($arryCompany[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?
	if($arryCompany[0]['country_id'] != ''){
		$CountrySelected = $arryCompany[0]['country_id']; 
	}else{
		$CountrySelected = 106;
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
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCompany[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCompany[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryCompany[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
 <tr>
        <td align="right"   class="blackbold" width="35%">Alternate Email  : </td>
        <td  align="left" ><input name="AlternateEmail" type="text" class="inputbox" id="AlternateEmail" value="<?php echo $arryCompany[0]['AlternateEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 

       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryCompany[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
	 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryCompany[0]['LandlineNumber'])?>"     maxlength="30" />			</td>

      </tr>


<tr>
        <td align="right"   class="blackbold" >Fax  :</td>
        <td  align="left"  >
	 <input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arryCompany[0]['Fax'])?>"     maxlength="30" />			</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arryCompany[0]['Website']))?($arryCompany[0]['Website']):("")?>"  maxlength="100" /> <?=WEBSITE_FORMAT?></td>
      </tr>


  
</table>
<? } ?>
 


<? if($_GET["tab"]=="global"){ ?>


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
       		 <td colspan="2" align="left" class="head">Inventory Settings</td>
        </tr>
<tr>
        <td  align="right"   class="blackbold" 
		>Track Inventory  : </td>
        <td   align="left"  >
          <? 
		
		 if(empty($arryCompany[0]['TrackInventory'])) {$TrackChecked = ''; $InTrackChecked = ' checked'; }else {$TrackChecked = ' checked'; $InTrackChecked ='';
		}
	  ?>
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="1" <?=$TrackChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="0" <?=$InTrackChecked?> />
          No</label> </td>
      </tr>



<tr>
       		 <td colspan="2" align="left" class="head">Currency Details</td>
        </tr>
		<tr>
       		 <td colspan="2" height="10"></td>
        </tr>
	  <tr>
        <td  align="right"   class="blackbold" width="45%"> Currency  :</td>
        <td   align="left" >
		<?
		if($arryCompany[0]['currency_id'] > 0 ){
			$CurrencySelected = $arryCompany[0]['currency_id']; 
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
       		 <td colspan="2" height="10"></td>
        </tr>




		<tr>
       		 <td colspan="2" align="left" class="head">DateTime Settings</td>
        </tr>
  <tr>
        <td align="right"   class="blackbold" valign="top" width="45%">Timezone  :<span class="red">*</span></td>
        <td  align="left"  valign="top" >


<div style="position:relative;"><?  
$arryCurrentLocation[0]['Timezone'] = $arryCompany[0]['Timezone'];
include("includes/html/box/clock.php"); ?></div>





<script>
  $(function() {
	$('#Timezone').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<?=getTimeZone($arryCompany[0]['Timezone'])?>

<script>
GetLocalTime();
</script>
		</td>
      </tr>
	<tr>
       		 <td colspan="2" height="20"></td>
        </tr>

 <tr>
        <td align="right"   class="blackbold"  >Session Timeout  :</td>
        <td  align="left"   > 
<select name="SessionTimeout" id="SessionTimeout" class="textbox">
	<?
	echo '<option value=""> None </option>';
	for($i=5;$i<=60;$i=$i+5){
		$val = $i*60;
		$sel = ($arryCompany[0]['SessionTimeout']==$val)?('selected'):('');
		echo '<option value="'.$val.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select> &nbsp;Minutes
	  	</td>
      </tr>
<tr>
       		 <td colspan="2" height="20"></td>
        </tr>
	
 <tr>
        <td align="right"   class="blackbold" valign="top" >Date Format  :<span class="red">*</span></td>
        <td  align="left"  valign="top" > 
		
<?
	$Today = date("Y-m-d");
	if(empty($arryCompany[0]['DateFormat'])) $arryCompany[0]['DateFormat'] = "Y-m-d";
	for($i=0;$i<sizeof($arrayDateFormat);$i++) {?>
<div style="float:left; width:250px; height:30px;">
 <input type="radio" name="DateFormat" value="<?=$arrayDateFormat[$i]['DateFormat']?>" <?  if($arrayDateFormat[$i]['DateFormat']==$arryCompany[0]['DateFormat']){echo "checked";}?>/> <?=date($arrayDateFormat[$i]['DateFormat'], strtotime($Today))?>
</div>
<? } ?>	
		



	  	</td>
      </tr>



<tr>
       		 <td colspan="2" align="left" class="head">Records Per Page</td>
        </tr>
		<tr>
       		 <td colspan="2" height="10"></td>
        </tr>
	  <tr>
        <td  align="right"   class="blackbold" width="45%"> Records Per Page  :</td>
        <td   align="left" >
	<? if(empty($arryCompany[0]['RecordsPerPage'])) $arryCompany[0]['RecordsPerPage']=20; ?>	
<select name="RecordsPerPage" id="RecordsPerPage" class="textbox">
       <option value="5" <? if($arryCompany[0]['RecordsPerPage'] == 5) echo 'selected';?>> 5 </option>
        <option value="10" <? if($arryCompany[0]['RecordsPerPage'] == 10) echo 'selected';?>> 10 </option>
        <option value="15" <? if($arryCompany[0]['RecordsPerPage'] == 15) echo 'selected';?>> 15 </option>
        <option value="20" <? if($arryCompany[0]['RecordsPerPage'] == 20) echo 'selected';?>> 20 </option>
        <option value="25" <? if($arryCompany[0]['RecordsPerPage'] == 25) echo 'selected';?>> 25 </option>
        <option value="30" <? if($arryCompany[0]['RecordsPerPage'] == 30) echo 'selected';?>> 30 </option>
        <option value="40" <? if($arryCompany[0]['RecordsPerPage'] == 40) echo 'selected';?>> 40 </option>
        <option value="50" <? if($arryCompany[0]['RecordsPerPage'] == 50) echo 'selected';?>> 50 </option>
        <option value="75" <? if($arryCompany[0]['RecordsPerPage'] == 75) echo 'selected';?>> 75 </option>
        <option value="100" <? if($arryCompany[0]['RecordsPerPage'] == 100) echo 'selected';?>> 100 </option>
        <option value="150" <? if($arryCompany[0]['RecordsPerPage'] == 150) echo 'selected';?>> 150 </option>
        <option value="200" <? if($arryCompany[0]['RecordsPerPage'] == 200) echo 'selected';?>> 200 </option>
     </select> 		   
			   
			   
			   </td>
      </tr>
	  
	  
	<tr>
       		 <td colspan="2" height="10"></td>
        </tr>

 </table>

<? } ?>
	  
<? if($_GET["tab"]=="account"){ ?>
	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
       		 <td colspan="2" align="left" class="head">Account Details</td>
        </tr>
		
   <tr>
        <td  align="right"   class="blackbold"> Display Name  : </td>
        <td   align="left" >
<!--
<input name="DisplayName" type="text" class="inputbox" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');" onBlur="Javascript:CheckAvailField('MsgSpan_Display','DisplayName','<?=$_SESSION['CmpID']?>');"/>

<span id="MsgSpan_Display"></span>
-->
<?=stripslashes($arryCompany[0]['DisplayName'])?>
<input name="DisplayName" type="hidden" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  />



</td>
      </tr>

      <tr>
        <td  align="right"   class="blackbold" width="35%"> Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_SESSION['CmpID']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	 
        <tr>
        <td  align="right"   class="blackbold">New Password : </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value=""  maxlength="15" /> 
		<span>(Leave it blank, if do not want to change password.)</span>
		

		
		</td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password : </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value=""  maxlength="15" /> </td>
      </tr>	
	
 <? if($arryCompany[0]['JoiningDate'] > 0){?>

   <tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		

<?=date("jS F, Y",strtotime($arryCompany[0]['JoiningDate']))?>

</td>
      </tr>
 
<? } ?>	  
	     
	  
	

</table>

	
 <? } ?>	
	
	
	
  





	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	

      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "  />


<input type="hidden" name="CmpID" id="CmpID" value="<?=$_SESSION['CmpID']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryCompany[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCompany[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="company"){ ?>
	StateListSend();
<? } ?>

</SCRIPT>



