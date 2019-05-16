
<script language="JavaScript1.2" type="text/javascript">
function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}

function validate_personal(frm){
	if(ValidateForSelect(frm.date_of_birth,"Date of Birth")
		){
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_contact(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.PersonalEmail, "Personal Email")
		&& isEmail(frm.PersonalEmail)
		&& ValidateForTextareaMand(frm.Address,"Contact Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		){
		
			if(Trim(frm.Landline1).value == '' && Trim(frm.Landline2).value == '' && Trim(frm.Landline3).value == ''){
						//alert("ok");
			}else if(Trim(frm.Landline1).value == '' || Trim(frm.Landline2).value == '' || Trim(frm.Landline3).value == ''){
				alert("Please Enter Complete Landline Number.");
				return false;
			}		


		if(!ValidateOptionalScan(frm.AddressProof1, "Address Proof 1")){
			return false;
		}

		if(!ValidateOptionalScan(frm.AddressProof2, "Address Proof 2")){
			return false;
		}






			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_education(frm){
	if( ValidateForSelect(frm.UnderGraduate,"Under Graduate")
		&& ValidateForSelect(frm.Graduation,"Graduation")
		){
		
			if(document.getElementById("UnderGraduateSpan").style.display!='none'){
				if(!ValidateForSimpleBlank(frm.OtherUnderGraduate,"Under Graduate")){
					return false;
				}
			}				

			if(document.getElementById("GraduationSpan").style.display!='none'){
				if(!ValidateForSimpleBlank(frm.OtherGraduation,"Graduation")){
					return false;
				}
			}				
		
		
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_job(frm){

	ShowHideLoader('1','S');
	return true;	

}



function validate_account(frm){
	if( ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){
		

			if(document.getElementById("Password").value!=""){
				if(!ValidateForPassword(frm.Password, "Password")){
					return false;
				}
				if(!isPassword(frm.Password)){
					return false;
				}
				if(!ValidateMandRange(frm.Password, "Password",5,15)){
					return false;
				}
				if(!ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)){
					return false;
				}
			}	
							
			var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("EmpID").value+"&Type=Employee";
			SendExistRequest(Url,"Email", "Email Address");
			
			return false;	
		}else{
			return false;	
		}	
}

function validate_supervisor(frm){
	ShowHideLoader('1','S');
}

function validate_role(frm){
	ShowHideLoader('1','S');
}

function validate_resume(frm){
	if(!ValidateMandResume(frm.Resume,"Resume")){
		return false;
	}
	ShowHideLoader('1','S');
}

function validate_id(frm){
	if(!ValidateOptionalScan(frm.IdProof, "Id Proof")){
		return false;
	}

	ShowHideLoader('1','S');
	/*
	if( ValidateForSelect(frm.ImmigrationType,"Immigration Type")
		&& ValidateForSimpleBlank(frm.ImmigrationNo, "Immigration Number")
		){
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}
	*/
}
</script>


<script language="JavaScript1.2" type="text/javascript">
function validate_profile(frm){
	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.PersonalEmail, "Personal Email")
		&& isEmail(frm.PersonalEmail)
		&& ValidateForTextareaMand(frm.Address,"Contact Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		//&& ValidateForSelect(frm.ImmigrationType,"Immigration Type")
		//&& ValidateForSimpleBlank(frm.ImmigrationNo, "Immigration Number")
		){
			if(Trim(frm.Landline1).value == '' && Trim(frm.Landline2).value == '' && Trim(frm.Landline3).value == ''){
						//alert("ok");
			}else if(Trim(frm.Landline1).value == '' || Trim(frm.Landline2).value == '' || Trim(frm.Landline3).value == ''){
				alert("Please Enter Complete Landline Number.");
				return false;
			}	

			
			if(frm.Resume.value!=''){
				if(!ValidateMandResume(frm.Resume,"Resume")){
					return false;
				}
			}

			ShowHideLoader('1','S');


			return true;	
		}else{
			return false;	
		}	
}

</script>
<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$RedirectURL?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_profile'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_profile'])) {echo $_SESSION['mess_profile']; unset($_SESSION['mess_profile']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<? if($_GET["tab"]=="personal"){ ?>
<tr>
	 <td colspan="2" align="left" class="head">Personal Details</td>
</tr>
<tr>
	     <td  align="right"  class="blackbold" width="45%">Employee Code : </td>
	     <td   align="left" >
		 <input name="EmpCode" type="text"  id="EmpCode" value="<?php echo stripslashes($arryEmployee[0]['EmpCode']); ?>"  maxlength="10" readonly="" class="disabled_inputbox"/> 
		 
          		 </td>
	     </tr>
<tr>
	     <td  align="right"  class="blackbold" >Gender : </td>
	     <td   align="left" >
		 <input name="Gender" type="text"  id="Gender" value="<?php echo stripslashes($arryEmployee[0]['Gender']); ?>"  maxlength="10" readonly="" class="disabled_inputbox"/> 
		 
          		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" width="35%"> First Name  :</td>
        <td   align="left" >
<input name="FirstName" type="text"  id="FirstName" value="<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>"  maxlength="50" readonly="" class="disabled_inputbox" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  : </td>
        <td   align="left" >
<input name="LastName" type="text" id="LastName" value="<?php echo stripslashes($arryEmployee[0]['LastName']); ?>"  maxlength="50" readonly="" class="disabled_inputbox"/>            </td>
      </tr>
	   

<? if($arryEmployee[0]['ExistingEmployee']=="1"){ ?>

	   <tr>
        <td  align="right"   > Date of Birth :  <span class="red">*</span></td>
        <td   align="left" >
<? if($arryEmployee[0]['date_of_birth']>0)$date_of_birth = $arryEmployee[0]['date_of_birth'];?>		
<script>
$(function() {
$( "#date_of_birth" ).datepicker({ 
	showOn: "both", yearRange: '1930:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	maxDate: "-1D", 
	changeMonth: true,
	changeYear: true
	});
});
</script>
<input id="date_of_birth" name="date_of_birth" readonly="" class="datebox" value="<?=$date_of_birth?>"  type="text" >         </td>
      </tr>

  <tr>
        <td  align="right"   class="blackbold"> Nationality  : </td>
        <td   align="left" >
		
            <select name="Nationality" class="inputbox" id="Nationality" >
			<option value="">--- Select ---</option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['name']?>" <?  if($arryCountry[$i]['name']==$arryEmployee[0]['Nationality']){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select> </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Marital Status  : </td>
        <td   align="left" >
		
            <select name="MaritalStatus" class="inputbox" id="MaritalStatus" >
			<option value="">--- Select ---</option>
              <option value="Single" <?  if($arryEmployee[0]['MaritalStatus']=="Single"){echo "selected";}?>> Single </option>
              <option value="Married" <?  if($arryEmployee[0]['MaritalStatus']=="Married"){echo "selected";}?>> Married </option>
              <option value="Other" <?  if($arryEmployee[0]['MaritalStatus']=="Other"){echo "selected";}?>> Other </option>
            </select> </td>
      </tr>

<? 	if($arryCurrentLocation[0]['country_id']!=106){?>

<tr>
        <td align="right"   class="blackbold">Social Security Number  : </td>
        <td  align="left" >

		<input name="SSN" type="text" class="inputbox" id="SSN" value="<?=stripslashes($arryEmployee[0]['SSN'])?>"  maxlength="30" /> </td>
      </tr> 
<? } ?>
<!--
<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	
	
	
		</td>
  </tr>	 -->

 <tr>
        <td  align="right"   class="blackbold"> Blood Group  : </td>
        <td   align="left" >

 <select name="BloodGroup" class="textbox" id="BloodGroup" >
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryBloodGroup);$i++) {?>
				<option value="<?=$arryBloodGroup[$i]['attribute_value']?>" <?  if($arryBloodGroup[$i]['attribute_value']==$arryEmployee[0]['BloodGroup']){echo "selected";}?>>
				<?=$arryBloodGroup[$i]['attribute_value']?>
				</option>
				<? } ?>         
            </select>

           </td>
      </tr>
	
	<? } //existing empl?>


<? } ?>

<? if($_GET["tab"]=="contact"){ ?>



<tr>
       		 <td colspan="2" align="left"   class="head">Contact Details</td>
        </tr>
  
	    <tr>
        <td align="right"   class="blackbold" width="45%">Personal Email  :<span class="red">*</span> </td>
        <td  align="left" ><input name="PersonalEmail" type="text" class="inputbox" id="PersonalEmail" value="<?php echo $arryEmployee[0]['PersonalEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 

	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Contact Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryEmployee[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >

		<? 

	if(!empty($arryEmployee[0]['country_id'])){
		$CountrySelected = $arryEmployee[0]['country_id']; 
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
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryEmployee[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryEmployee[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryEmployee[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryEmployee[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);" />			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
		<?  $LandArray[0]='';$LandArray[1]='';$LandArray[2]='';
		if(!empty($arryEmployee[0]['LandlineNumber'])){
			$LandArray = explode(" ",$arryEmployee[0]['LandlineNumber']);
	    }
		?>
		<input name="Landline1" type="text" class="textbox" id="Landline1" value="<?=$LandArray[0]?>" size="3" maxlength="4" onkeypress="return isNumberKey(event);" />&nbsp;&nbsp;
		<input name="Landline2" type="text" class="textbox" id="Landline2" value="<?=$LandArray[1]?>" size="3" maxlength="4" onkeypress="return isNumberKey(event);" />&nbsp;&nbsp;
		<input name="Landline3" type="text" class="textbox" id="Landline3" value="<?=$LandArray[2]?>" size="8" maxlength="8" onkeypress="return isNumberKey(event);" />		</td>
      </tr>


<tr>
       		 <td colspan="2" align="left"   class="head">Address Proof</td>
        </tr>

<tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Attach Address Proof 1 :</td>
    <td  align="left" valign="top" >
		
	<input name="AddressProof1" type="file" class="inputbox" id="AddressProof1" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	

	<? 
           if(IsFileExist($Config['AddressProofDir'],$arryEmployee[0]['AddressProof1'])){ 
		$OldAddressProof1 =  $arryEmployee[0]['AddressProof1'];
	?><br><br>
	<input type="hidden" name="OldAddressProof1" value="<?=$OldAddressProof1?>">
	<div id="AddressProof1Div">
	<?=$arryEmployee[0]['AddressProof1']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryEmployee[0]['AddressProof1']?>&folder=<?=$Config['AddressProofDir']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['AddressProofDir']?>','<?=$arryEmployee[0]['AddressProof1']?>','AddressProof1Div')"><?=$delete?></a>
	</div>
	<? } ?>	



	
	
	</td>
  </tr>	

<tr>
    <td align="right" valign="top"   class="blackbold" > </td>
    <td  align="right" valign="top" >&nbsp;
</td>
  </tr>

<tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Attach Address Proof 2 :</td>
    <td  align="left" valign="top" >
		
	<input name="AddressProof2" type="file" class="inputbox" id="AddressProof2" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	
	<? 
       
        if(IsFileExist($Config['AddressProofDir'],$arryEmployee[0]['AddressProof2'])){ 		
	  	$OldAddressProof2 =  $arryEmployee[0]['AddressProof2'];
	?><br><br>
	<input type="hidden" name="OldAddressProof2" value="<?=$OldAddressProof2?>">
	<div id="AddressProof1Div">
	<?=$arryEmployee[0]['AddressProof2']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryEmployee[0]['AddressProof2']?>&folder=<?=$Config['AddressProofDir']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['AddressProofDir']?>','<?=$arryEmployee[0]['AddressProof2']?>','AddressProof2Div')"><?=$delete?></a>
	</div>
	<? } ?>	
		
	
	</td>
  </tr>	
<tr>
    <td align="right" valign="top"   class="blackbold" > </td>
    <td  align="right" valign="top" > <?=SUPPORTED_SCAN_DOC?>
</td>
  </tr>	

<? } ?>

<? if($_GET["tab"]=="education"){ ?>
<tr>
       		 <td colspan="2" align="left"   class="head">Education Details</td>
        </tr>	
	
	<tr>
          <td align="right"   class="blackbold" valign="top" width="45%"> Under Graduate  :<span class="red">*</span></td>
          <td height="30" align="left" >
		<select name="UnderGraduate" class="inputbox" id="UnderGraduate"  onchange="Javascript:ShowOther('UnderGraduate');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryUnderGraduate);$i++) {?>
			<option value="<?=$arryUnderGraduate[$i]['attribute_value']?>" <?  if($arryUnderGraduate[$i]['attribute_value']==$arryEmployee[0]['UnderGraduate']){echo "selected";}?>>
			<?=$arryUnderGraduate[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['UnderGraduate']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="UnderGraduateSpan">&nbsp;&nbsp;<input  name="OtherUnderGraduate" id="OtherUnderGraduate" value="<?=stripslashes($arryEmployee[0]['OtherUnderGraduate'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('UnderGraduate');</script>
		  
		  
		  </td>
  </tr>  
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top" width="35%"> Graduation  :<span class="red">*</span></td>
          <td height="30" align="left" >
		<select name="Graduation" class="inputbox" id="Graduation"  onchange="Javascript:ShowOther('Graduation');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryGraduation);$i++) {?>
			<option value="<?=$arryGraduation[$i]['attribute_value']?>" <?  if($arryGraduation[$i]['attribute_value']==$arryEmployee[0]['Graduation']){echo "selected";}?>>
			<?=$arryGraduation[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['Graduation']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="GraduationSpan">&nbsp;&nbsp;<input  name="OtherGraduation" id="OtherGraduation" value="<?=stripslashes($arryEmployee[0]['OtherGraduation'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('Graduation');</script>
		  
		  
		  </td>
  </tr>  
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top">Post Graduation  :</td>
          <td height="30" align="left" >
		  
			<select name="PostGraduation" class="inputbox" id="PostGraduation"  onchange="Javascript:ShowOther('PostGraduation');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryPostGraduation);$i++) {?>
			<option value="<?=$arryPostGraduation[$i]['attribute_value']?>" <?  if($arryPostGraduation[$i]['attribute_value']==$arryEmployee[0]['PostGraduation']){echo "selected";}?>>
			<?=$arryPostGraduation[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['PostGraduation']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="PostGraduationSpan">&nbsp;&nbsp;<input  name="OtherPostGraduation" id="OtherPostGraduation" value="<?=stripslashes($arryEmployee[0]['OtherPostGraduation'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('PostGraduation');</script>
		  
		  </td>
  </tr>  
	  
	
	
	    	
     <tr>
       <td height="30" align="right" valign="top"   class="blackbold" > Doctorate/Phd  : </td>
       <td  align="left" valign="top" >
		<select name="Doctorate" class="inputbox" id="Doctorate"  onchange="Javascript:ShowOther('Doctorate');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryDoctorate);$i++) {?>
			<option value="<?=$arryDoctorate[$i]['attribute_value']?>" <?  if($arryDoctorate[$i]['attribute_value']==$arryEmployee[0]['Doctorate']){echo "selected";}?>>
			<?=$arryDoctorate[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['Doctorate']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="DoctorateSpan">&nbsp;&nbsp;<input  name="OtherDoctorate" id="OtherDoctorate" value="<?=stripslashes($arryEmployee[0]['OtherDoctorate'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('Doctorate');</script>
	   </td>
     </tr>
	 
		 <tr>
          <td align="right"   class="blackbold" valign="top">Professional Course  :</td>
          <td height="30" align="left" >
		  
			<select name="ProfessionalCourse" class="inputbox" id="ProfessionalCourse"  onchange="Javascript:ShowOther('ProfessionalCourse');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryProfessionalCourse);$i++) {?>
			<option value="<?=$arryProfessionalCourse[$i]['attribute_value']?>" <?  if($arryProfessionalCourse[$i]['attribute_value']==$arryEmployee[0]['ProfessionalCourse']){echo "selected";}?>>
			<?=$arryProfessionalCourse[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['ProfessionalCourse']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="ProfessionalCourseSpan">&nbsp;&nbsp;<input  name="OtherProfessionalCourse" id="OtherProfessionalCourse" value="<?=stripslashes($arryEmployee[0]['OtherProfessionalCourse'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('ProfessionalCourse');</script>
		  
		  </td>
  </tr>  
	 
	 
	<tr>
        <td align="right"   class="blackbold" valign="top">
		Certification Course  :</td>
    <td height="30" align="left" valign="top" >
	
	 <textarea name="Certification" type="text" class="textarea" id="Certification"><?=stripslashes($arryEmployee[0]['Certification'])?></textarea>
	
	</td>
  </tr>	 
 



 <? } ?>
  <? if($_GET["tab"]=="job"){ ?>

	<tr>
       		 <td colspan="2" align="left" class="head">Job Details</td>
        </tr>
		<? if(!empty($arryEmployee[0]['EmpCode'])){ ?>
      <tr>
        <td  align="right"   class="blackbold" width="45%">
    Employee Code :</td>
        <td   align="left" ><B><?=stripslashes($arryEmployee[0]['EmpCode'])?></B>	</td>
      </tr>
	  <? } ?>
	  
<tr>
        <td align="right"   class="blackbold" width="45%">Joining Date  :</td>
        <td  align="left" >		
		<? if($arryEmployee[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); ?>

	</td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Category  : </td>
        <td   align="left" >
		<?=$arryEmployee[0]['catName']?>
		</td>
      </tr>
	  
<!--tr>
        <td  align="right"   class="blackbold"> Division  : </td>
        <td   align="left" >

<?=stripslashes($arryEmployee[0]['DivisionName'])?>

</td>
      </tr-->

	     <tr>
        <td  align="right"   class="blackbold"> Department  : </td>
        <td   align="left" >
<?=$arryEmployee[0]['DepartmentName']?>
<?  //if($arryEmployee[0]['DeptHead']>0){echo "&nbsp;&nbsp;<b>[Departmental Head]</b>";}?>
</td>
      </tr>
	   
	<tr>
        <td  align="right"   class="blackbold"> Designation   : </td>
        <td   align="left" >
			<?=stripslashes($arryEmployee[0]['JobTitle'])?>
		
		</td>
      </tr>
	
	<tr >
    <td  align="right"   class="blackbold">Job Type :</td>
    <td align="left">
			<?=stripslashes($arryEmployee[0]['JobType'])?>

		</td>
  </tr>
<? if(!empty($arryEmployee[0]['shiftName'])){?>
<tr>
    <td  align="right"   class="blackbold">Work Shift :</td>
    <td align="left">
			<?=stripslashes($arryEmployee[0]['shiftName'])?> [<?=$arryEmployee[0]['WorkingHourStart']?> - <?=$arryEmployee[0]['WorkingHourEnd']?>]
		</td>
  </tr>
 <? } ?> 	
<tr>
        <td align="right"   class="blackbold" >
		Total Experience  :</td>
        <td align="left" >
		
	<?=$arryEmployee[0]['ExperienceYear']?> Years &nbsp;&nbsp; 	
		<?=$arryEmployee[0]['ExperienceMonth']?> Months	
		
		</td>
	  </tr>	
	
	<? if(sizeof($arrySkill)>0){ ?>
	 <tr>
        <td align="right" class="blackbold" valign="top">Skill  :</td>
        <td  align="left" >
	 <!--input name="Skill" type="text" class="inputbox" id="Skill" value="<?=stripslashes($arryEmployee[0]['Skill'])?>" maxlength="50" -->			
	<?  if(!empty($arryEmployee[0]['Skill'])){
			$SkillArray = explode(", ", $arryEmployee[0]['Skill']);
		}else{
			$SkillArray[] = '';
		}
		
	?>
	<select name="Skill[]" class="inputbox" id="Skill" multiple style="height:120px;" >
		<option value="">--- None ---</option>
		<? for($i=0;$i<sizeof($arrySkill);$i++) {?>
			<option value="<?=$arrySkill[$i]['attribute_value']?>" <?  if(in_array($arrySkill[$i]['attribute_value'],$SkillArray)){echo "selected";}?>>
			<?=$arrySkill[$i]['attribute_value']?>
			</option>
		<? } ?>
	</select>	 
	 </td>
     </tr>  
	 <? } ?>
	  
	 <tr>
        <td  align="right"   class="blackbold"> Probation Period : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['ProbationPeriod']))?(stripslashes($arryEmployee[0]['ProbationPeriod']).' '.$arryEmployee[0]['ProbationUnit']):(NOT_SPECIFIED)?>
			 </td>
      </tr>

		
		
<tr>
        <td  align="right"   class="blackbold"> Leave Allowed : </td>
        <td   align="left" >
	<?=($arryEmployee[0]['LeaveAccrual']==1)?('Accrual'):('Fixed')?>
			 </td>
      </tr>	

 <tr>
        <td  align="right"   class="blackbold">  Exempt : </td>
        <td   align="left" >
	<?=($arryEmployee[0]['Exempt']==1)?('Yes'):('No')?>
			 </td>
      </tr>




     <tr>
        <td  align="right"   class="blackbold" >  Yearly Review Allowed : </td>
        <td   align="left" valign="bottom" >
	<?=($arryEmployee[0]['YearlyReview']==1)?('Yes'):('No')?>	
	
	 </td>
      </tr>

<? if($arryEmployee[0]['YearlyReview']==1){ ?>
  <tr>
        <td  align="right"   class="blackbold">Yearly Review Period : </td>
        <td   align="left" >
<? $YearlyReviewArry = explode('-',$arryEmployee[0]['YearlyReviewPeriod']); 

   if($YearlyReviewArry[0]!='')$YearlyReviewPeriod = $YearlyReviewArry[0].' Years &nbsp;&nbsp;';
   if($YearlyReviewArry[1]!='')$YearlyReviewPeriod .= $YearlyReviewArry[1].' Months  &nbsp;&nbsp;';
   if($YearlyReviewArry[2]!='')$YearlyReviewPeriod .= $YearlyReviewArry[2].' Days';

   echo (!empty($YearlyReviewPeriod))?($YearlyReviewPeriod):(NOT_SPECIFIED);
?>
			 </td>
      </tr>
<? } ?>




   <tr>
        <td  align="right"   class="blackbold" >  Benefit Allowed : </td>
        <td   align="left" valign="bottom" >
	<?=($arryEmployee[0]['Benefit']==1)?('Yes'):('No')?>	
			
	 </td>
      </tr>

<? if($arryEmployee[0]['Benefit']==1){ ?>
  <tr>
        <td  align="right"   class="blackbold">Benefit Eligibility Period : </td>
        <td   align="left" >
<? $EligibilityPeriodArry = explode('-',$arryEmployee[0]['EligibilityPeriod']);

   if($EligibilityPeriodArry[0]!='')$EligibilityPeriod = $EligibilityPeriodArry[0].' Years &nbsp;&nbsp;';
   if($EligibilityPeriodArry[1]!='')$EligibilityPeriod .= $EligibilityPeriodArry[1].' Months &nbsp;&nbsp;';
   if($EligibilityPeriodArry[2]!='')$EligibilityPeriod .= $EligibilityPeriodArry[2].' Days';
   echo (!empty($EligibilityPeriod))?($EligibilityPeriod):(NOT_SPECIFIED);
?>
			 </td>
      </tr>
<? } ?>



   <tr>
        <td  align="right"   class="blackbold" >  Overtime Allowed : </td>
        <td   align="left" valign="bottom" >
	<?=($arryEmployee[0]['Overtime']==1)?('Yes'):('No')?>	
			
	 </td>
      </tr>


 
	<?  } ?>

 <? if($_GET["tab"]=="supervisor"){ 
	 
	 $HideSubmit = 1;
	 
	 ?>  
	


 
	 <tr>
       		 <td colspan="2" align="left" class="head">Supervisor</td>
        </tr>
		
	 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>		
	<tr>
        <td  align="right"   class="blackbold" width="45%"> Supervisor : </td>
        <td   align="left" >

		<? if($arryEmployee[0]['Supervisor']>0){ ?>
			<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryEmployee[0]['Supervisor']?>" ><?=$arrySupervisor[0]['UserName']?> (<?=$arrySupervisor[0]['Department']?>)</a>	 
		  <? } else echo NOT_SPECIFIED;?>


            </td>
      </tr>	
	  
	  <tr>
        <td  align="right"   class="blackbold"> Reporting Method : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['ReportingMethod']))?(stripslashes($arryEmployee[0]['ReportingMethod'])):(NOT_SPECIFIED)?>
			 </td>
      </tr>	
 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	

<? } ?>

  <? if($_GET["tab"]=="id"){ ?>  

	 <tr>
       		 <td colspan="2" align="left" class="head">ID Proof</td>
        </tr>
 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>
	<tr>
        <td  align="right"   class="blackbold" width="45%"> ID Type :</td>
        <td   align="left" >
		
            <select name="ImmigrationType" class="inputbox" id="ImmigrationType" >
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryImmigrationType);$i++) {?>
				<option value="<?=$arryImmigrationType[$i]['attribute_value']?>" <?  if($arryImmigrationType[$i]['attribute_value']==$arryEmployee[0]['ImmigrationType']){echo "selected";}?>>
				<?=$arryImmigrationType[$i]['attribute_value']?>
				</option>
				<? } ?>         
            </select> </td>
      </tr>	
	  
	  <tr>
        <td  align="right"   class="blackbold"> Number  : </td>
        <td   align="left" >
            <input type="text" name="ImmigrationNo" maxlength="30" class="inputbox" id="ImmigrationNo" value="<?=stripslashes($arryEmployee[0]['ImmigrationNo'])?>">
			 </td>
      </tr>	
	  
	    <tr>
        <td  align="right"   class="blackbold"> Expiry Date : </td>
        <td   align="left" >
 <script>
$(function() {
$( "#ImmigrationExp" ).datepicker({ 
	showOn: "both", yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
	dateFormat: 'dd-mm-yy', 
	changeMonth: true,
	changeYear: true
	});

	$("#ImmigrationExp").on("click", function () { 
			$(this).val("");
		}
	);



});
</script>

<input id="ImmigrationExp" name="ImmigrationExp" readonly="" class="datebox" value="<?=$arryEmployee[0]['ImmigrationExp']?>"  type="text" >			
			
			
			 </td>
      </tr>	

<tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Attach ID Proof  :</td>
    <td  align="left" valign="top" >
	

	
	<input name="IdProof" type="file" class="inputbox" id="IdProof" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	<?=SUPPORTED_SCAN_DOC?>
	<? 
        $MainDir = $Config['FileUploadDir'].$Config['IdDir'];
        if($arryEmployee[0]['IdProof'] !='' && file_exists($MainDir.$arryEmployee[0]['IdProof']) ){ 
	
	$OldIdProof = $MainDir.$arryEmployee[0]['IdProof'];
?><br><br>
	<input type="hidden" name="OldIdProof" value="<?=$OldIdProof?>">
	<div id="IdProofDiv">
	<?=$arryEmployee[0]['IdProof']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['IdProof']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['IdProof']?>','IdProofDiv')"><?=$delete?></a>
	</div>
<?	} ?>		
	
	</td>
  </tr>	


 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>

  <? } ?>
<? if($_GET["tab"]=="resume"){ ?>  

	 <tr>
       		 <td colspan="2" align="left" class="head">Resume</td>
        </tr>
	 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
	<tr>
    <td height="30" align="right" valign="top"   class="blackbold" width="46%"> Attach Resume   :</td>
    <td  align="left" valign="top" >
	

	
	<input name="Resume" type="file" class="inputbox" id="Resume" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">

<?     if(IsFileExist($Config['EmpResumeDir'],$arryEmployee[0]['Resume'])){		 
	  	$OldResume =  $arryEmployee[0]['Resume'];
	?><br><br>
	<input type="hidden" name="OldResume" value="<?=$OldResume?>">
	<div id="ResumeDiv">
	<?=$arryEmployee[0]['Resume']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryEmployee[0]['Resume']?>&folder=<?=$Config['EmpResumeDir']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['EmpResumeDir']?>','<?=$arryEmployee[0]['Resume']?>','ResumeDiv')"><?=$delete?></a>
	</div>
	<? } ?>	
		
	
	</td>
  </tr>	
   <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
  <? } ?>

<? if($_GET["tab"]=="account"){ 
	
	$HideSubmit = 1;
	?>

	
	<tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>
		 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
      <tr>
        <td  align="right"   class="blackbold" width="45%">Login Email : </td>
        <td   align="left" ><B><?php echo $arryEmployee[0]['Email']; ?></B>
		
		 <span id="MsgSpan_Email"></span>	
		 </td>
      </tr>
	 <tr>
        <td  align="right"   class="blackbold">Password : </td>
        <td   align="left" >*****************
		
	
		 </td>
      </tr>
	  
	   <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
  <? } ?>
	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   
<? if($HideSubmit!=1){ ?>
   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	

      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "  />


<input type="hidden" name="EmpID" id="EmpID" value="<?=$EmpID?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   <? } ?>
   </form>
</table>
</div>





  
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>





