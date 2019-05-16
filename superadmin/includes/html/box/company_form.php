
<!--Amit Singh-->
<script type="text/javascript" src="js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
        right: 235px !important;
    top: 1461px !important;
    }
</style>
<!--End-->

<script language="JavaScript1.2" type="text/javascript">
function validateCompany(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateForTextareaMand(frm.Description,"Description",10,1000)
		&& ValidateOptionalUpload(frm.Image, "Logo")
		&& ValidateForSimpleBlank(frm.ContactPerson, "Contact Person")
		&& ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& isEmailOpt(frm.AlternateEmail)
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidatePhoneNumber(frm.LandlineNumber,"Landline Number",10,20)
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		&& ValidateMandNumField(frm.MaxUser, "Allowed Number Of Users")
		//&& ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")
		&& ValidateMandRange(frm.DisplayName, "Display Name",3,30)
		&& isDisplayName(frm.DisplayName)
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){  
		
						
					
					if(document.getElementById("CmpID").value<=0){
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
                                                
                                                //****************Amit Singh*******************/
                                                var isvaldd=$('#isvalidate').val();
                                                //alert(isvaldd);
                                                if(isvaldd != '1'){ 
                                                    alert("Please Enter Valid Password.");
                                                    
                                                    return false;	
                                                }
                                                //*********************************************/
					
					}				
					
				

					var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("CmpID").value+"&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

					SendMultipleExistRequest(Url,"Email", "Email Address","DisplayName", "Display Name")

					return false;	
					
			}else{
					return false;	
			}	

		
}
</script>

<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCompany(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Company Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="45%"> Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text"  class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryCompany[0]['CompanyName']); ?>"  maxlength="50" />            </td>
      </tr>

 <tr>
          <td align="right"   class="blackbold" valign="top">Description  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Description" type="text" class="bigbox" id="Description"><?=stripslashes($arryCompany[0]['Description'])?></textarea>			          </td>
        </tr>	
	  

<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Logo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

<? if($arryCompany[0]['Image'] !='' && file_exists('../upload/company/'.$arryCompany[0]['Image']) ){ ?>
				
	<div  id="ImageDiv"><a href="../upload/company/<?=$arryCompany[0]['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=stripslashes($arryCompany[0]['CompanyName'])?>"><? echo '<img src="../resizeimage.php?w=150&h=150&img=upload/company/'.$arryCompany[0]['Image'].'" border=0 >';?></a>
	
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('../upload/company/<?=$arryCompany[0]['Image']?>','ImageDiv')"><?=$delete?></a>	</div>
<?	} ?>
	
		</td>
  </tr>	  

   
<tr>
        <td  align="right"   class="blackbold"> Contact Person  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="ContactPerson" type="text" class="inputbox" id="ContactPerson" value="<?php echo stripslashes($arryCompany[0]['ContactPerson']); ?>"  maxlength="30" />            </td>
      </tr>	 
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryCompany[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryCompany[0]['country_id'] != ''){
		$CountrySelected = $arryCompany[0]['country_id']; 
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
        <td align="right"   class="blackbold">Email  : </td>
        <td  align="left" ><input name="AlternateEmail" type="text" class="inputbox" id="AlternateEmail" value="<?php echo $arryCompany[0]['AlternateEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 

       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryCompany[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :<span class="red">*</span></td>
        <td   align="left" >
	 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryCompany[0]['LandlineNumber'])?>"     maxlength="30" />		
	</td>
      </tr>


<tr>
        <td align="right"   class="blackbold" >Fax  :</td>
        <td  align="left"  >
	 <input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arryCompany[0]['Fax'])?>"     maxlength="30" />			</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arryCompany[0]['Website']))?($arryCompany[0]['Website']):("")?>"  maxlength="100" /> <?=$MSG[205]?></td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Allowed MultiSite :</td>
        <td align="left"><input name="MultiSite" type="text" class="inputbox" id="MultiSite" value="<?=(!empty($arryCompany[0]['MultiSite']))?($arryCompany[0]['MultiSite']):("")?>"  maxlength="100" /> </td>
      </tr>

<tr>
	 <td colspan="2" align="left" class="head">Permission Details</td>

</tr>
<tr>
	<td align="right"   class="blackbold" valign="top">Allowed Number Of Users  :<span class="red">*</span></td>
	<td  align="left"  >
	<input name="MaxUser" type="text" class="textbox" size="7" id="MaxUser" value="<?=stripslashes($arryCompany[0]['MaxUser'])?>" maxlength="15" onkeypress="return isNumberKey(event);"/>	
 
 
 </td>
  </tr>


<tr>
	<td align="right"   class="blackbold" valign="top">Data Storage Limit   :</td>
	<td  align="left"  >
	
 <select name="StorageLimit" id="StorageLimit" class="textbox" onChange="Javascript: StorageUnit();">
	<?
	echo '<option value=""> Unlimited </option>';
	for($i=0;$i<=100;$i=$i+5){	
		$val = $i;	
		if($val==0) $val=1;
		$sel = ($arryCompany[0]['StorageLimit']==$val)?('selected'):('');
		echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
	}
	?>
</select> 


<select name="StorageLimitUnit" id="StorageLimitUnit" class="textbox">
<option value="GB" <?=($arryCompany[0]['StorageLimitUnit']=="GB")?('selected'):('')?>> GB </option>
<option value="TB" <?=($arryCompany[0]['StorageLimitUnit']=="TB")?('selected'):('')?>> TB </option>
</select>


<SCRIPT LANGUAGE=JAVASCRIPT>
StorageUnit();
</SCRIPT>

 
 </td>
  </tr>



<tr>
        <td  align="right"   class="blackbold"  valign="top" > Allowed Module  : </td>
        <td   align="left" style="line-height:26px;" >
		
		
<?
$arrCmpDept =  array();
if(!empty($arryCompany[0]['Department'])){
	$arrCmpDept = explode("," , $arryCompany[0]['Department']);
}
?>


<label><input type="checkbox" name="Department[]" id="Department0" value="" <?=($arryCompany[0]['Department']=="")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_ERP?> <br></label>

<label><input type="checkbox" name="Department[]" id="Department1" value="1" <?=in_array("1",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_HRMS?> <br></label>
		
<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department2" value="5" <?=in_array("5",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_CRM?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department3" value="2" <?=in_array("2",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_ECOMMERCE?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department4" value="3,4,6,7,8" <?=in_array("6",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_INVENTORY?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department5" value="9" <?=in_array("9",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff(); SetDomain();" /> <?=MOD_WEBSITE?> <br></label>
		
<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department6" value="12" <?=in_array("12",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff(); SetDomain();" /> <?=MOD_POS?> <br></label>
<!-- EDI  -->
	<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department7" value="13" <?=(in_array("13", $arrCmpDept))?("checked"):("");?> onclick="Javascript:SetModuleOff(); SetDomain();" /> <?=MOD_EDI?> <br> </label>  <!-- End EDI  -->

</td>
 </tr>
<tr id="trtext" style="display:none;">
	<td     > </td>	
	<td align="left"   class="blackbold" valign="top" ><?=DEFAULT_DOMAIN_MSG?></td>
	
  </tr>
<tr id="trErpDomain" style="display:none;">
	<td align="right"   class="blackbold" valign="top" width="45%">ERP Domain Name / IP :</td>
	<td  align="left"  >
	<input name="ErpDomain" type="text" class="inputbox" size="7" id="ErpDomain" value="<?=stripslashes($arryCompany[0]['ErpDomain'])?>" />	
	
 
 
 </td>
  </tr>
<tr id="trWebDomain" style="display:none;">
	<td align="right"   class="blackbold" valign="top" width="45%">Website Domain Name / IP :</td>
	<td  align="left"  >
	<input name="WebDomain" type="text" class="inputbox" size="7" id="WebDomain" value="<?=stripslashes($arryCompany[0]['WebDomain'])?>" />	
	
 
 
 </td>
  </tr>


<tr style="display:none">
        <td  align="right"   class="blackbold" 
		>Track Inventory  : </td>
        <td   align="left"  >
          <? 
		$TrackChecked = '';
		$InTrackChecked = ' checked';
		
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
        <td  align="right"   class="blackbold"> Currency  :</td>
        <td   align="left" >
		<?
		if($arryCompany[0]['currency_id'] != ''){
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
  <!--tr>
        <td align="right"   class="blackbold" valign="top" >Timezone  :<span class="red">*</span></td>
        <td  align="left"  valign="top" >
<script>
  $(function() {
	$('#Timezone').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<?=getTimeZone($arryCompany[0]['Timezone'])?>

		</td>
      </tr-->
	  		
	  <tr>
        <td align="right"   class="blackbold" valign="top" >Date Format  :<span class="red">*</span></td>
        <td  align="left"  valign="top" > 
		
<?
	$Today = date("Y-m-d");
	if(empty($arryCompany[0]['DateFormat'])) $arryCompany[0]['DateFormat'] = "Y-m-d";
	for($i=0;$i<sizeof($arrayDateFormat);$i++) {?>
<div style="float:left; width:250px; height:30px;">
 <label><input type="radio" name="DateFormat" value="<?=$arrayDateFormat[$i]['DateFormat']?>" <?  if($arrayDateFormat[$i]['DateFormat']==$arryCompany[0]['DateFormat']){echo "checked";}?>/> <?=date($arrayDateFormat[$i]['DateFormat'], strtotime($Today))?></label>
</div>
<? } ?>	
		



	  	</td>
      </tr>
	
 <tr>
        <td align="right"   class="blackbold"  >Time Format  :</td>
        <td  align="left"   > 
<select name="TimeFormat" id="TimeFormat" class="textbox">
<option value="H:i:s" <?=($arryCompany[0]['TimeFormat']=='H:i:s')?('selected'):('')?> > 24 Hour </option>
<option value="h:i:s a" <?=($arryCompany[0]['TimeFormat']=='h:i:s a')?('selected'):('')?> > am / pm </option>
</select> 
	  	</td>
      </tr>

	<tr>
       		 <td colspan="2" align="left" class="head">Account Details</td>
        </tr>
		
   <tr>
        <td  align="right"   class="blackbold" valign="top"> Display Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="DisplayName" type="text" class="inputbox" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_Display','DisplayName','<?=$_GET['edit']?>');"/>
  <span class="passmsg"><?=DISPLAY_MSG?></span>
<div id="MsgSpan_Display"></div>
</td>
      </tr>
	  

      <tr>
        <td  align="right"   class="blackbold" width="35%">Login Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	  <? if(empty($_GET['edit'])){ ?>
        <tr>
        <td  align="right"   class="blackbold">New Password :<span class="red">*</span> </td>
        <td   align="left" class="blacknormal">
            <input name="Password" type="Password" class="inputbox" id="Password" value="<?php echo stripslashes($arryCompany[0]['Password']); ?>"  maxlength="15" />
            <span class="passmsg"><?=PASSWORD_LIMIT?></span>
            <?php require_once("password_strength_html.php"); ?>
        </td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value="<?php echo stripslashes($arryCompany[0]['Password']); ?>"  maxlength="15" /> </td>
      </tr>	
	 <? } ?>
	 
      
	  
	<? if(!empty($arryCompany[0]['CmpID'])){ ?>
      <tr>
        <td  align="right"   class="blackbold">
    Company ID :</td>
        <td   align="left" ><?=stripslashes($arryCompany[0]['CmpID'])?>	</td>
      </tr>
	  <? } ?>
	
 <? if($arryCompany[0]['JoiningDate'] > 0){?>

<tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		
<?=$arryCompany[0]['JoiningDate']?>

</td>
      </tr>
   
	 <!--
	 <tr>
        <td align="right"   class="blackbold">Expiry Date  :</td>
        <td  align="left">
	<? if($arryCompany[0]['ExpiryDate']<=0) $arryCompany[0]['ExpiryDate']=''; ?>	
		
<script type="text/javascript">
$(function() {
	$('#ExpiryDate').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$arryCompany[0]['ExpiryDate']?>'
		}
	);
});
</script>
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="disabled" size="10" value="<?=$arryCompany[0]['ExpiryDate']?>"  type="text" >						</td>
      </tr>

	  -->
<? } ?>	  	  
	  
	  

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	$InActiveChecked =''; $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryCompany[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryCompany[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
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


<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryCompany[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCompany[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	ShowPermission();
</SCRIPT>
