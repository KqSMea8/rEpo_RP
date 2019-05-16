<script language="JavaScript1.2" type="text/javascript">
function EmployeeShow(){
	if(document.getElementById('ExistingEmployee').value == 0){
		$(".unfixedtr").hide();
	}else{
		$(".unfixedtr").show();
		
	}
}

function validate_personal(frm){

	var DataExist=0;
	/**********************/
	var EmpCode = Trim(document.getElementById("EmpCode")).value;
	if(EmpCode!=''){
		if(!ValidateMandRange(document.getElementById("EmpCode"), "Employee Code",3,20)){
			return false;
		}
	}
	/**********************/



	if( ValidateRadioButtons(frm.Gender, "Gender")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		){

			if(document.getElementById('ExistingEmployee').value == 1){
				if(!ValidateForSelect(frm.date_of_birth,"Date of Birth")){
					return false;
				}
			}


			if(EmpCode!=''){
				DataExist = CheckExistingData("isRecordExists.php","&EmpCode="+escape(EmpCode)+"&editID="+document.getElementById("EmpID").value, "EmpCode","Employee Code");
				if(DataExist==1)return false;
			}



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

function validate_exit(frm){
		if(frm.ExitDate.value !='' && frm.ExitDate.value < frm.JoiningDate.value ){
			alert("Resignation Date should not be less than Joining Date.");
			return false;
		}
		ShowHideLoader('1','S');
		return true;	
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

	/*if(document.getElementById("depID") != null){
		document.getElementById("Department").value = document.getElementById("depID").value;
	}*/

	if( ValidateForSelect(frm.JoiningDate,"Joining Date")
		&& ValidateForSelect(frm.catID,"Category")
		//&& ValidateForSelect(frm.Division,"Division")
		&& ValidateForSelect(frm.Department,"Department")
		&& ValidateForSelect(frm.JobTitle,"Designation")
		&& ValidateForSelect(frm.JobType,"Job Type")
		&& ValidateForSelect(frm.ExperienceYear,"Total Years of Experience")
		&& ValidateForSelect(frm.ExperienceMonth,"Total Months of Experience")
		){
			

			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}












function validate_account(frm){
	if( ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){
		

			if(document.getElementById("Password").value!=""){
				if(!ValidateForSimpleBlank(frm.Password, "Password")){
					return false;
				}
				/*
				if(!isPassword(frm.Password)){
					return false;
				}*/
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

function ShowHideRow(){
	if(document.getElementById("LeaveAccrual").value=="1"){
		$("#leaveruletr").show();
	}else{
		$("#leaveruletr").hide();
	}

	
	if(document.getElementById("Benefit").value=="1"){
		$("#benefittr").show();
	}else{
		$("#benefittr").hide();
	}



	if(document.getElementById("YearlyReview").value=="1"){
		$("#yearlyreviewtr").show();
	}else{
		$("#yearlyreviewtr").hide();
	}

}




</script>



	




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_employee'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<? if($_GET["tab"]=="chat"){	  
	  		$chatpermission=$serailchatpermission=array();
	  			 	  
	  		$serailchatpermission=$objchat->getPermissionByUser($_GET['edit']);
	  				  
	  	 	if(!empty($serailchatpermission[0]->permission)){
	  	 	
	  	 		$chatpermission=unserialize($serailchatpermission[0]->permission);
	  	 	
	  	 	}
	  	?>
			<tr>
				<td colspan="2" align="left" class="head">Chat Permission <input
					type="hidden" value="<?php echo $arryEmployee[0]['Email']; ?>"
					name="Email"></td>
			</tr>
			<tr>
				<td align="" class="blackbold">Internal Chat :</td>
				<td align="" class="blackbold"><input type ="checkbox" name="chatpermission[]" value="internal" <?php if(in_array("internal",$chatpermission)) echo "checked";?>/></td>				
			</tr>
			<tr>
				<td align="" class="blackbold">External Chat :</td>
				<td align="" class="blackbold"><input type ="checkbox" name="chatpermission[]" value="external" <?php if(in_array("external",$chatpermission)) echo "checked";?>/></td>				
			
			</tr>
			<?php }?>
	<!------------------------ End Code------------------------->
  <? if($_GET["tab"]=="quota"){ 
       $quotadetailByserver=array();
       
       		 $getcallsetting=$objphone->GetcallSetting();
		 	 $Config['DbName'] = $Config['DbMain'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 $server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
			 $server_id	= $getcallsetting[0]->server_id;
			 $objphone->server_id	= $server_data[0]->server_ip;
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
       
       
       
       
       
   $serverdetail=array(array('server_id'=>$server_id,'server_name'=>$server_data[0]->server_name));
   
   
   $allquotadetail=$objphone->getEmpQuota('',$_GET['edit']);
     if(!empty($allquotadetail)){
         foreach($allquotadetail as $allquot){
             $quotadetailByserver[$allquot->server_id]=$allquot;
         }
     }
       ?>  
         <tr>
                <td colspan="2" align="left" class="head">Call Quota</td>
        </tr>
        <tr>
        <td  align="right"   class="blackbold"> 
                <table width="100%">
                      <tr>
                          <td class="head">Server Name</td>
                          <td class="head">Duration</td>
                          <td class="head">Call Quota</td>
                          <td class="head">Action</td>
                      </tr>
                       <?php if(!empty($serverdetail)){
                          foreach($serverdetail as $server){?>
                          <tr>
                              <td ><?php echo $server['server_name'] ?></td>
                              <td ><?php echo !empty($quotadetailByserver[$server['server_id']]->duration)?$quotadetailByserver[$server['server_id']]->duration:'';?></td>
                              <td ><?php echo !empty($quotadetailByserver[$server['server_id']]->q_time)?$quotadetailByserver[$server['server_id']]->q_time:'';?></td>
                              <td ><a href="save_employeeQuota.php?id=<?php echo base64_encode($_GET['edit']);?>&serverid=<?php echo $server['server_id']?>" class="Blue fancybox fancybox.iframe">Add Quota</a></td>
                          </tr>
                      <?php }}?>
                  </table>
         </td>       
      </tr>    
    
       <tr>
                <td colspan="2" height="50">&nbsp;</td>
        </tr>
        
  <? } ?>

  

<? if($_GET["tab"]=="personal"){ ?>
<tr>
	 <td colspan="2" align="left" class="head">Personal Details</td>
</tr>

<tr class="fixedtr" >
		<td  align="right" valign="center"  class="blackbold" >Existing Employee : </td>
		<td  align="left" valign="top">
		
<select name="ExistingEmployee" id="ExistingEmployee" class="textbox" onChange="Javascript:EmployeeShow();">
	<option value="1" <?=($arryEmployee[0]['ExistingEmployee']=="1")?("selected"):("");?>>Yes</option>
	<option value="0" <?=($arryEmployee[0]['ExistingEmployee']=="0")?("selected"):("");?>>No</option>
</select>

</td>
</tr>

 <tr>
        <td  align="right"   class="blackbold"> Employee Code : </td>
        <td   align="left" >

	<input name="EmpCode" type="text" class="datebox" id="EmpCode" value="<?php echo stripslashes($arryEmployee[0]['EmpCode']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_EmpCode');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_EmpCode','EmpCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_EmpCode"></span>

</td>
      </tr>

<tr>
	     <td  align="right"  class="blackbold" >Gender :<span class="red">*</span> </td>
	     <td   align="left" >
		 
		 
          <input type="radio" name="Gender" id="Gender" value="Male" <?=($arryEmployee[0]['Gender']=="Male")?("checked"):("");?>/>
          Male&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Gender" id="Gender" value="Female"  <?=($arryEmployee[0]['Gender']=="Female")?("checked"):("");?>  />
          Female		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" width="45%"> First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryEmployee[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   
	   <tr class="unfixedtr">
        <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
        <td   align="left" >
<? if($arryEmployee[0]['date_of_birth']>0)$date_of_birth = $arryEmployee[0]['date_of_birth'];?>		
<script>
$(function() {
$( "#date_of_birth" ).datepicker({ 
		showOn: "both",
	yearRange: '1930:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	maxDate: "-1D", 
	changeMonth: true,
	changeYear: true
	});
});
</script>
<input id="date_of_birth" name="date_of_birth" readonly="" class="datebox" value="<?=$date_of_birth?>"  type="text" >         </td>
      </tr>

 <tr class="unfixedtr">
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
 <tr class="unfixedtr">
        <td  align="right"   class="blackbold"> Marital Status  : </td>
        <td   align="left" >
		
            <select name="MaritalStatus" class="inputbox" id="MaritalStatus" >
			<option value="">--- Select ---</option>
              <option value="Single" <?  if($arryEmployee[0]['MaritalStatus']=="Single"){echo "selected";}?>> Single </option>
              <option value="Married" <?  if($arryEmployee[0]['MaritalStatus']=="Married"){echo "selected";}?>> Married </option>
              <option value="Other" <?  if($arryEmployee[0]['MaritalStatus']=="Other"){echo "selected";}?>> Other </option>
            </select> </td>
      </tr>

<? if($arryCurrentLocation[0]['country_id']!=106){?>
 <tr class="unfixedtr">
        <td align="right"   class="blackbold">Social Security Number  : </td>
        <td  align="left" >
		<input name="SSN" type="text" class="inputbox" id="SSN" value="<?=stripslashes($arryEmployee[0]['SSN'])?>"  maxlength="30" /> </td>
      </tr> 
<? } ?>
<!--
 <tr class="unfixedtr">
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	
	
	
		</td>
  </tr>	 -->

 <tr class="unfixedtr">
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

<script>
EmployeeShow();
</script>
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
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryEmployee[0]['Address'])?></textarea>			          </td>
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
		<?
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
        $MainDir = "upload/add_proof/".$_SESSION['CmpID']."/";
        if($arryEmployee[0]['AddressProof1'] !='' && file_exists($MainDir.$arryEmployee[0]['AddressProof1']) ){ 
	$OldAddressProof1 = $MainDir.$arryEmployee[0]['AddressProof1'];
	?><br><br>
	<input type="hidden" name="OldAddressProof1" value="<?=$OldAddressProof1?>">
	<div id="AddressProof1Div">
	<?=$arryEmployee[0]['AddressProof1']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['AddressProof1']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['AddressProof1']?>','AddressProof1Div')"><?=$delete?></a>
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
        $MainDir = "upload/add_proof/".$_SESSION['CmpID']."/";
        if($arryEmployee[0]['AddressProof2'] !='' && file_exists($MainDir.$arryEmployee[0]['AddressProof2']) ){ 
	$OldAddressProof2 = $MainDir.$arryEmployee[0]['AddressProof2'];
	?><br><br>
	<input type="hidden" name="OldAddressProof2" value="<?=$OldAddressProof2?>">
	<div id="AddressProof2Div">
	<?=$arryEmployee[0]['AddressProof2']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['AddressProof2']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['AddressProof2']?>','AddressProof2Div')"><?=$delete?></a>
	</div>
	<?	} ?>		
	
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
        <td align="right"   class="blackbold">Joining Date  :<span class="red">*</span></td>
        <td  align="left" >		
<? if($arryEmployee[0]['JoiningDate']>0)$JoiningDate = $arryEmployee[0]['JoiningDate'];?>		
<script>
$(function() {
$( "#JoiningDate" ).datepicker({ 
		showOn: "both",
	yearRange: '1950:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});
});
</script>
<input id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value="<?=$JoiningDate?>"  type="text" >		</td>
      </tr>
 
	  
	  <tr>
        <td  align="right"   class="blackbold"> Category  :<span class="red">*</span> </td>
        <td   align="left" >
		
            <select name="catID" class="inputbox" id="catID" >
			<option value="">--- Select ---</option>
              <? for($i=0;$i<sizeof($arryEmpCategory);$i++) {?>
              <option value="<?=$arryEmpCategory[$i]['catID']?>" <?  if($arryEmpCategory[$i]['catID']==$arryEmployee[0]['catID']){echo "selected";}?>>
              <?=$arryEmpCategory[$i]['catName']?>
              </option>
              <? } ?>
            </select> </td>
      </tr>  
	  
<!--tr>
        <td  align="right"   class="blackbold"> Division  :<span class="red">*</span> </td>
        <td   align="left" >

<select name="Division" class="inputbox" id="Division" onChange="Javascript:DeptListSend('','');">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arryDepartment);$i++) {?>
  <option value="<?=$arryDepartment[$i]['depID']?>" <?  if($arryDepartment[$i]['depID']==$arryEmployee[0]['Division']){echo "selected";}?>>
  <?=$arryDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select></td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> <div id="DeptTitle">Department  :<span class="red">*</span></div> </td>
        <td   align="left" >
		<div id="DeptValue"></div>
<input type="hidden" name="OldDeptID" id="OldDeptID" value="<?=$arryEmployee[0]['Department']?>" />	
<input type="hidden" name="Department" id="Department" value="<?=$arryVacancy[0]['Department']?>" />


	<script language="javascript">
	DeptListSend('','');
	</script>

	</td>
      </tr-->	  

<tr >
	<td  align="right"   class="blackbold">Department :<span class="red">*</span></td>
	<td align="left">

	<select name="Department" class="inputbox" id="Department">
	  <option value="">--- Select ---</option>
	  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
	  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryEmployee[0]['Department']){echo "selected";}?>>
	 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
	  </option>
	  <? } ?>
	</select>

	 	</td>
  </tr>



<?  if($arryEmployee[0]['Status']==1){ ?>
 <tr style="display:none">
        <td  align="right"  >  </td>
        <td   align="left" valign="top" >
			<input type="checkbox" name="DeptHead" value="1" <?  if($arryEmployee[0]['DeptHead']>0){echo "checked";}?>>&nbsp;<B>Make Departmental Head</B>

</td>
      </tr>
<? } ?>

	  
	<tr>
        <td  align="right"   class="blackbold"> Designation  :<span class="red">*</span> </td>
        <td   align="left" ><select name="JobTitle" class="inputbox" id="JobTitle">
          <option value="">--- Select ---</option>
          <? for($i=0;$i<sizeof($arryJobTitle);$i++) {?>
          <option value="<?=$arryJobTitle[$i]['attribute_value']?>" <?  if($arryJobTitle[$i]['attribute_value']==$arryEmployee[0]['JobTitle']){echo "selected";}?>>
          <?=$arryJobTitle[$i]['attribute_value']?>
          </option>
          <? } ?>
        </select></td>
      </tr>
	
	<tr >
    <td  align="right"   class="blackbold">Job Type :<span class="red">*</span></td>
    <td align="left">

	<select name="JobType" class="inputbox" id="JobType">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryJobType);$i++) {?>
			<option value="<?=$arryJobType[$i]['attribute_value']?>" <?  if($arryJobType[$i]['attribute_value']==$arryEmployee[0]['JobType']){echo "selected";}?>>
			<?=$arryJobType[$i]['attribute_value']?>
			</option>
		<? } ?>
	</select> 	</td>
  </tr>
<? if(sizeof($arryShift)>0){?>
<tr>
    <td  align="right"   class="blackbold">Work Shift :</td>
    <td align="left">
	<select name="shiftID" class="inputbox" id="shiftID">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryShift);$i++) {?>
			<option value="<?=$arryShift[$i]['shiftID']?>" <?  if($arryShift[$i]['shiftID']==$arryEmployee[0]['shiftID']){echo "selected";}?>>
			<?=stripslashes($arryShift[$i]['shiftName'])?>
			</option>
		<? } ?>
	</select> 	</td>
</tr>	
<? } ?>
<tr>
        <td align="right"   class="blackbold" >
		Total Experience  :<span class="red">*</span></td>
        <td height="30" align="left" >
		
	<select name="ExperienceYear" class="textbox" id="ExperienceYear" style="width:70px;">
		<option value="">--Select--</option>
		<option value="Fresher">Fresher</option>
		<? for($i=0;$i<=30;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryEmployee[0]['ExperienceYear']!=''  && $arryEmployee[0]['ExperienceYear'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
		<option value="30+" <? if($arryEmployee[0]['ExperienceYear'] == '30+') echo 'selected';?>> 30+ </option>	 
     </select> Years &nbsp;&nbsp; 	
		
	<select name="ExperienceMonth" class="textbox" id="ExperienceMonth" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=0;$i<=11;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryEmployee[0]['ExperienceMonth']!=''  && $arryEmployee[0]['ExperienceMonth'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select> Months	
		
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
        <td  align="right"   class="blackbold" valign="top" height="40"> Probation Period   : </td>
        <td   align="left" valign="top">
<input name="ProbationPeriod" type="text" class="textbox" id="ProbationPeriod" value="<?php echo stripslashes($arryEmployee[0]['ProbationPeriod']); ?>" size="2" maxlength="4" onkeypress="return isNumberKey(event);" />  

<select name="ProbationUnit" class="textbox" id="ProbationUnit">
<option value="Days" <?  if($arryEmployee[0]['ProbationUnit']=="Days"){echo "selected";}?>>Days</option>
<option value="Hrs" <?  if($arryEmployee[0]['ProbationUnit']=="Hrs"){echo "selected";}?>>Hrs</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<label style="display:none44"><input type="checkbox" name="ProbationEvent" id="ProbationEvent"  value="1" <?  if($arryEmployee[0]['ProbationEvent']>0){echo "checked";}?>> Create Event
<input type="hidden" name="ProbationEventID" value="<?=$arryEmployee[0]['ProbationEvent']?>">
</label>


        </td>
      </tr>

	
	

    <tr>
        <td align="right"  valign="top" class="blackbold"  > Leave Allowed  : </td>
        <td align="left" valign="top">
	 <select name="LeaveAccrual" class="textbox" id="LeaveAccrual" style="width:100px;"  onchange="Javascript:ShowHideRow();">
		<option value="0" <?  if($arryEmployee[0]['LeaveAccrual']=="0"){echo "selected";}?>>Fixed</option>
		<option value="1" <?  if($arryEmployee[0]['LeaveAccrual']=="1"){echo "selected";}?>>Accrual</option>
	</select>
           </td>
      </tr>

	 
    <tr id="leaveruletr">
        <td align="right" class="blackbold" ></td>
        <td align="left" valign="top">
	<a class="fancybox fancybox.iframe" href="changeLeaveRule.php?emp=<?=$_GET['edit']?>">Edit Leave Custom Rule</a>
           </td>
      </tr>

	

	 <tr>
        <td  align="right"   class="blackbold" >  Exempt  : </td>
        <td   align="left" valign="bottom" >

<select name="Exempt" id="Exempt" class="textbox" style="width:100px;" >
	<option value="0"  > No </option>
	<option value="1" <?=($arryEmployee[0]['Exempt']==1)?('selected'):('')?>> Yes </option>
</select>

			
	 </td>
      </tr>
	
	


     <tr>
        <td  align="right"   class="blackbold" >  Yearly Review Allowed : </td>
        <td   align="left" valign="bottom" >
	<select name="YearlyReview" id="YearlyReview" class="textbox" style="width:100px;" onchange="Javascript:ShowHideRow();" >
		<option value="0"  > No </option>
		<option value="1" <?=($arryEmployee[0]['YearlyReview']==1)?('selected'):('')?>> Yes </option>
	</select>
			
	 </td>
      </tr>


<tr id="yearlyreviewtr">
        <td  align="right"   class="blackbold" valign="top" height="40"> Yearly Review Period  : </td>
        <td   align="left" valign="top" >
<? $YearlyReviewArry = explode('-',$arryEmployee[0]['YearlyReviewPeriod']); ?>
<select name="YearlyReviewYear" class="textbox" id="YearlyReviewYear" style="width:70px;">
		<option value="">--Select--</option>		
		<? for($i=0;$i<=10;$i++){ ?>
		 <option value="<?=$i?>" <? if($YearlyReviewArry[0]!=''  && $YearlyReviewArry[0] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>			
     </select> Years &nbsp;&nbsp; 	
		
	<select name="YearlyReviewMonth" class="textbox" id="YearlyReviewMonth" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=0;$i<=11;$i++){ ?>
		 <option value="<?=$i?>" <? if($YearlyReviewArry[1]!=''  && $YearlyReviewArry[1] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>  Months	&nbsp;&nbsp; 	
		
	<select name="YearlyReviewDay" class="textbox" id="YearlyReviewDay" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=1;$i<31;$i++){ ?>
		 <option value="<?=$i?>" <? if($YearlyReviewArry[2]!=''  && $YearlyReviewArry[2] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>  Days	

         </td>
      </tr>




   <tr>
        <td  align="right"   class="blackbold" >  Benefit Allowed : </td>
        <td   align="left" valign="bottom" >
	<select name="Benefit" id="Benefit" class="textbox" style="width:100px;" onchange="Javascript:ShowHideRow();">
		<option value="0"  > No </option>
		<option value="1" <?=($arryEmployee[0]['Benefit']==1)?('selected'):('')?>> Yes </option>
	</select>
			
	 </td>
      </tr>

<tr id="benefittr">
        <td  align="right"   class="blackbold" valign="top" height="40"> Benefit Eligibility Period : </td>
        <td   align="left" valign="top" >
<? $EligibilityPeriodArry = explode('-',$arryEmployee[0]['EligibilityPeriod']); ?>
<select name="EligibilityYear" class="textbox" id="EligibilityYear" style="width:70px;">
		<option value="">--Select--</option>		
		<? for($i=0;$i<=10;$i++){ ?>
		 <option value="<?=$i?>" <? if($EligibilityPeriodArry[0]!=''  && $EligibilityPeriodArry[0] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>			
     </select> Years &nbsp;&nbsp; 	
		
	<select name="EligibilityMonth" class="textbox" id="EligibilityMonth" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=0;$i<=11;$i++){ ?>
		 <option value="<?=$i?>" <? if($EligibilityPeriodArry[1]!=''  && $EligibilityPeriodArry[1] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>  Months	&nbsp;&nbsp; 	
		
	<select name="EligibilityDay" class="textbox" id="EligibilityDay" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=1;$i<31;$i++){ ?>
		 <option value="<?=$i?>" <? if($EligibilityPeriodArry[2]!=''  && $EligibilityPeriodArry[2] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>  Days	


<!--
<input name="EligibilityPeriod" type="text" class="textbox" id="EligibilityPeriod" value="<?php echo stripslashes($arryEmployee[0]['EligibilityPeriod']); ?>" size="2" maxlength="4" onkeypress="return isNumberKey(event);" />  

<select name="EligibilityUnit" class="textbox" id="EligibilityUnit">
<option value="Days" <?  if($arryEmployee[0]['EligibilityUnit']=="Days"){echo "selected";}?>>Days</option>
<option value="Hrs" <?  if($arryEmployee[0]['EligibilityUnit']=="Hrs"){echo "selected";}?>>Hrs</option>
</select>
-->


         </td>
      </tr>


   <tr>
        <td  align="right"   class="blackbold" >  Overtime Allowed : </td>
        <td   align="left" valign="bottom" >
	<select name="Overtime" id="Overtime" class="textbox" style="width:100px;" >
		<option value="0"  > No </option>
		<option value="1" <?=($arryEmployee[0]['Overtime']==1)?('selected'):('')?>> Yes </option>
	</select>
			
	 </td>
      </tr>

<script language="JavaScript1.2" type="text/javascript">
	ShowHideRow();
	</script>
	 
 <? } ?>
 
 






 <? if($_GET["tab"]=="exit"){ ?> 
 <tr>
       		 <td colspan="2" align="left" class="head">Employee Exit</td>
        </tr>
  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		

	  
	  <tr>
        <td align="right"   class="blackbold" width="45%">Joining Date  :</td>
        <td  align="left" >		
		<? if($arryEmployee[0]['JoiningDate']>0){
				echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); 
				$JoiningYear = date("Y", strtotime($arryEmployee[0]['JoiningDate'])); 
		   }else{
			   $JoiningYear = date("Y");
		   }
	  ?>
<input type="hidden" id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value="<?=$arryEmployee[0]['JoiningDate']?>"  >	
	</td>
      </tr>	
		
			
<tr>
        <td  align="right"   class="blackbold" > Exit Type  : </td>
        <td   align="left" >

	<select name="ExitType" class="inputbox" id="ExitType" onchange="Javascript:SetRegDateLabel();">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryExitType);$i++) {?>
		<option value="<?=$arryExitType[$i]['attribute_value']?>" <?  if($arryExitType[$i]['attribute_value']==$arryEmployee[0]['ExitType']){echo "selected";}?>>
		<?=$arryExitType[$i]['attribute_value']?>
		</option>
		<? } ?>         
	</select>

           </td>
      </tr>



     <tr>
        <td align="right"   class="blackbold" id="reglabel">Resignation Date  :</td>
        <td  align="left">
	<? if($arryEmployee[0]['ExitDate']<=0) $arryEmployee[0]['ExitDate']=''; ?>	
		
<script>
$(function() {
$( "#ExitDate" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=$JoiningYear?>:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#ExitDate").on("click", function () { 
			$(this).val("");
		}
	);


});
SetRegDateLabel
</script>
<input id="ExitDate" name="ExitDate" readonly="" class="datebox" value="<?=$arryEmployee[0]['ExitDate']?>"  type="text" >	

<script>
	function SetRegDateLabel(){
		if(document.getElementById("ExitType").value==""){
			reglabel = ' Resignation Date : ';
		}else{
			reglabel = document.getElementById("ExitType").value+' Date : ';
		}
		$("#reglabel").html(reglabel);
	}


	SetRegDateLabel();
</script>


					</td>
      </tr>
	  
	 <tr>
        <td align="right"   class="blackbold" >Reason  :</td>
        <td  align="left"  >
	 <input name="ExitReason" type="text" class="inputbox" id="ExitReason" value="<?=stripslashes($arryEmployee[0]['ExitReason'])?>" maxlength="50" />			</td>
      </tr> 

<tr>
        <td align="right"   class="blackbold" >Last Working Date  :</td>
        <td  align="left">
	<? if($arryEmployee[0]['LastWorking']<=0) $arryEmployee[0]['LastWorking']=''; ?>	
		
<script>
$(function() {
$( "#LastWorking" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=$JoiningYear?>:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#LastWorking").on("click", function () { 
			$(this).val("");
		}
	);


});

</script>
<input id="LastWorking" name="LastWorking" readonly="" class="datebox" value="<?=$arryEmployee[0]['LastWorking']?>"  type="text" >	

					</td>
      </tr>


    <tr>
        <td  align="right"   class="blackbold" > Full & Final  : </td>
        <td   align="left" >
			 <select name="FullFinal" class="textbox" id="FullFinal" style="width:100px;">
				<option value="">--- Select ---</option>
				<option value="Yes" <?  if($arryEmployee[0]['FullFinal']=="Yes"){echo "selected";}?>>Yes</option>
 				<option value="No" <?  if($arryEmployee[0]['FullFinal']=="No"){echo "selected";}?>>No</option>
           </select>

           </td>
      </tr>

  


	   <tr>
          <td align="right"   class="blackbold" valign="top">Description  :</td>
          <td  align="left" >
            <textarea name="ExitDesc" type="text" class="bigbox" id="ExitDesc"><?=stripslashes($arryEmployee[0]['ExitDesc'])?></textarea>			          </td>
        </tr>

	    <tr>
        <td  align="right"   class="blackbold" valign="top" height="25"> Assets/Files Clearence  : </td>
        <td   align="left" >
			<input type="radio" name="ExitClearence" id="ExitClearence" value="1" <?  if($arryEmployee[0]['ExitClearence']=="1"){echo "checked";}?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="ExitClearence" id="ExitClearence2" value="0" <?  if($arryEmployee[0]['ExitClearence']!="1"){echo "checked";}?>> No

           </td>
      </tr>

	   <tr>
       		 <td colspan="2" >&nbsp;</td>
        </tr>	
<? } ?>	  
 
 
 
 
 <? if($_GET["tab"]=="supervisor"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Supervisor</td>
        </tr>
		
	 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold" width="45%"> Supervisor : </td>
        <td   align="left" >
		
            <select name="Supervisor" class="inputbox" id="Supervisor" >
			<option value="">--- None ---</option>
              <? for($i=0;$i<sizeof($arrySupervisor);$i++) {?>
              <option value="<?=$arrySupervisor[$i]['EmpID']?>" <?  if($arrySupervisor[$i]['EmpID']==$arryEmployee[0]['Supervisor']){echo "selected";}?>>
              <?=$arrySupervisor[$i]['UserName']?> (<?=$arrySupervisor[$i]['Department']?>)
              </option>
              <? } ?>
            </select> </td>
      </tr>	
	  
	  <tr>
        <td  align="right"   class="blackbold"> Reporting Method : </td>
        <td   align="left" >
            <input type="text" name="ReportingMethod" maxlength="30" class="inputbox" id="ReportingMethod" value="<?=stripslashes($arryEmployee[0]['ReportingMethod'])?>">
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
        <td  align="right"   class="blackbold" width="45%"> ID Type : </td>
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
		showOn: "both",
	yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
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
        $MainDir = "upload/ids/".$_SESSION['CmpID']."/";
        if($arryEmployee[0]['IdProof'] !='' && file_exists($MainDir.$arryEmployee[0]['IdProof']) ){

	$OldIdProof = $MainDir.$arryEmployee[0]['IdProof'];
 ?>
	<br><br>
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
		 <input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="<?=stripslashes($arryEmployee[0]['BankName'])?>">
            </td>
      </tr>	
	 <tr>
        <td  align="right"   class="blackbold"> Account Name  :<span class="red">*</span> </td>
        <td   align="left" >
            <input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="<?=stripslashes($arryEmployee[0]['AccountName'])?>">
			 </td>
      </tr>	  
	  <tr>
        <td  align="right"   class="blackbold"> Account Number  :<span class="red">*</span> </td>
        <td   align="left" >
            <input type="text" name="AccountNumber" maxlength="30" class="inputbox" id="AccountNumber" value="<?=stripslashes($arryEmployee[0]['AccountNumber'])?>">
			 </td>
      </tr>	
	   <tr>
        <td  align="right"   class="blackbold"> Routing Number  :<span class="red">*</span> </td>
        <td   align="left" >
            <input type="text" name="IFSCCode" maxlength="30"  class="inputbox" id="IFSCCode" value="<?=stripslashes($arryEmployee[0]['IFSCCode'])?>">
			 </td>
      </tr>	
	  
	  <tr>
       		 <td colspan="2">&nbsp;</td>
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
	
	<? 
        $MainDir = "upload/resume/".$_SESSION['CmpID']."/";
        if($arryEmployee[0]['Resume'] !='' && file_exists($MainDir.$arryEmployee[0]['Resume']) ){ 

	$OldResume = $MainDir.$arryEmployee[0]['Resume'];
?>
	<br><br>
	<input type="hidden" name="OldResume" value="<?=$OldResume?>">
	<div id="ResumeDiv">
	<?=stripslashes($arryEmployee[0]['Resume'])?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['Resume']?>" title="<?=$arryEmployee[0]['Resume']?>" class="download">Download</a>
	&nbsp;
	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['Resume']?>','ResumeDiv')"><?=$delete?></a>
	</div>
<?	} ?>		
	
	</td>
  </tr>	
  
   <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
		
 <? } ?>
	  
<? if($_GET["tab"]=="role"){ ?>

<tr>
		 <td colspan="2" align="left" class="head">Role/Permissions</td>
	</tr>





	
<!--
<tr>
        <td  align="right"  valign="top"  class="blackbold" > Role  : </td>
        <td   align="left" >
	
		<select name="Role" class="textbox" id="Role" onchange="Javascript:ShowPermission();" >
			<option value="">--- Select ---</option>
              <option value="Admin" <?  if($arryEmployee[0]['Role']=="Admin"){echo "selected";}?>> Admin </option>
              <option value="Other" <?  if($arryEmployee[0]['Role']=="Other"){echo "selected";}?>> Other </option>
            </select>
	
			
			          </td>
      </tr>  
	 
 <tr>
        <td  align="right"   class="blackbold"> View User Info  : </td>
        <td   align="left" valign="bottom" >
	<input type="checkbox" name="vUserInfo" id="vUserInfo"  value="1" <?  if($arryEmployee[0]['vUserInfo']>0){echo "checked";}?>>
			
	 </td>
      </tr> 
 <tr>
        <td  align="right"   class="blackbold" > View All Records  : </td>
        <td   align="left" valign="bottom">
	<input type="checkbox" name="vAllRecord" id="vAllRecord"  value="1" <?  if($arryEmployee[0]['vAllRecord']>0){echo "checked";}?>>
		<?=ROLE_ALL_RECORD?>	
	 </td>
      </tr> 
--> 

	<? if(sizeof($arryRoleGroup)>0){?>
	<tr>
		<td  align="right"  class="blackbold" width="20%"> Role Group : </td>
		<td   align="left" >
	
	<select name="GroupID" class="inputbox" id="GroupID" onchange="Javascript:ShowPermissionGroupRole();">
		<option value="">--- None ---</option>
		<? foreach($arryRoleGroup as $roleG){?>
		 <option value="<?=$roleG['GroupID'];?>" <? if($roleG['GroupID']==$arryEmployee[0]['GroupID']){echo "selected";}?>> <?=stripslashes($roleG['group_name'])?> </option>

		<? }?>
	</select>

		    </td>
	 </tr>
	<? } ?>



 <tr id="CollapseExpand">
        <td   align="right" valign="bottom" colspan="2">

<a href="javascript:void(0);" id="collapseAll">Collapse All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  id="expandAll">Expand All</a>


	 </td>
      </tr> 
 
     <tr id="PermissionsVal">
					       <td align="right" valign="top"  class="blackbold"  width="20%"><div id="PermissionTitle">Allow Permissions :</div></td>
					       <td align="left">
						   <div id="PermissionValueNew" >
						   
							  	<table width="100%" cellspacing=0 cellpadding=2 style="background-color:#EFEFEF"><tr>
								<td ><strong>Module Name</strong></td>
								<td width="20%"><input type="checkbox" name="ViewAll" id="ViewAll" onclick="javascript:SelectDeselect('ViewAll','ViewLabel');"  /><strong>View</strong></td>
								<td width="20%"><input type="checkbox" name="ModifyAll" id="ModifyAll" onclick="javascript:SelectDeselect('ModifyAll','ModifyLabel');"  /><strong>Modify</strong></td>

<td width="20%"><input type="checkbox" name="FullAll" id="FullAll" onclick="javascript:SelectDeselect('FullAll','FullLabel');"  /><strong>Full</strong></td>


								</tr></table>
 <? 
								$Line=0;
echo '<div id="accordion" >';
foreach($arryDepartment as $key=>$valuesDept){

	$arrayMainModules = $objConfig->getMainModulesUser($arryEmployee[0]['UserID'],0,$valuesDept['depID']);
	
	if(sizeof($arrayMainModules)>0){
		
		
		echo '<h2>'.$valuesDept['Department'].'</h2>';
		
		echo '<table width="100%" cellspacing=0 cellpadding=0>';
		foreach($arrayMainModules as $key=>$valuesMod){
			$Line++; 
			echo '<tr><td height="30">'.stripslashes($valuesMod['Module']).'</td> ';
			?>
<td width="22%">
<input type="checkbox" name="ViewLabel<?=$Line?>" id="ViewLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['ViewLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>								
			
	
<td width="22%">			
<input type="checkbox" name="ModifyLabel<?=$Line?>" id="ModifyLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['ModifyLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>											
		
<td width="17%">			
<input type="checkbox" name="FullLabel<?=$Line?>" id="FullLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['FullLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>	


	
			<?
			echo '</tr>';
			/*if ($Line % 2 == 0) {
				echo "</tr><tr>";
			}*/
	

		} //end arrayAllModules
		 
	
		echo '</table>';

	  }  //end if arrayAllModules
   
 }  //end arryDepartment 
echo '</div>';   
							
 ?>
								
						   
						   
						   

	<input type="hidden" name="Line" id="Line" value="<?=$Line?>" />
	

						   
						   </div>
						   </td>
			          </tr> 



	<? if(sizeof($arryRoleGroup)>0){?>
	<script language="javascript1.2" type="text/javascript">
	ShowPermissionGroupRole();
	</script>
	<? } ?>





<? } ?>




<? if($_GET["tab"]=="account"){ ?>
	
	<tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>
		
      <tr>
        <td  align="right"   class="blackbold" width="35%"> Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryEmployee[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Employee','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	 
        <tr>
        <td  align="right"   class="blackbold">Password : </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value=""  maxlength="15" autocomplete="off"/> 
		<span><?=LEAVE_BLANK_PASSWORD?></span>
		

		
		</td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password : </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value=""  maxlength="15" autocomplete="off"/> </td>
      </tr>	
	
      
	  
	 


<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryEmployee[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryEmployee[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>
	
 <? } ?>	
	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="UserID" id="UserID"  value="<?=$arryEmployee[0]['UserID']?>" />	

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>
</div>





  



<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>

<? if($_GET["tab"]=="role"){ ?>	
	$("#accordion").accordion({
		heightStyle: "content",
		duration: 'fast',
		active: true
	});

	$("#collapseAll").click(function(){
	    $(".ui-accordion-content").hide()
	});


	$("#expandAll").click(function(){
	    $(".ui-accordion-content").show()
	});


	//ShowPermission();
<? } ?>
</SCRIPT>



