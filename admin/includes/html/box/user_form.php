<script language="JavaScript1.2" type="text/javascript">




function validateEmployee(frm){


	var DataExist=0;
	/**********************/
	var EmpCode = Trim(document.getElementById("EmpCode")).value;
	if(EmpCode!=''){
		if(!ValidateMandRange(document.getElementById("EmpCode"), "User Code",3,20)){
			return false;
		}
	}
	/**********************/

	/*if(document.getElementById("depID") != null){
		document.getElementById("Department").value = document.getElementById("depID").value;
	}*/

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateRadioButtons(frm.Gender, "Gender")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
	){

		if(document.getElementById('ExistingEmployee').value == 1){

				/*if(!ValidateForSelect(frm.date_of_birth,"Date of Birth")){
					return false;
				}
				if(!ValidateForSelect(frm.JoiningDate,"Joining Date")){
					return false;
				}

				if(!ValidateForSimpleBlank(frm.JobTitle,"Designation")){
					return false;
				}*/
				if(!ValidateOptionalUpload(frm.Image, "Image")){
					return false;
				}
				/*if(!ValidateForSimpleBlank(frm.PersonalEmail, "Personal Email")){
					return false;
				}*/
				if(!isEmailOpt(frm.PersonalEmail)){
					return false;
				}
				/*if(!ValidateForTextareaMand(frm.Address,"Contact Address",10,200)){
					return false;
				}
				if(!ValidateForSelect(frm.country_id,"Country")){
					return false;
				}

				if(!isZipCode(frm.ZipCode)){
					return false;
				}
				if(!ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)){
					return false;
				}*/

			}



			if(!ValidateForSimpleBlank(frm.Email, "Email")){
				return false;
			}

			if(!isEmail(frm.Email)){
				return false;
			}



				
		
					if(document.getElementById("EmpID").value<=0){
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
                                                //****************Amit Singh*******************/
                                                    var isvaldd=$('#isvalidate').val();
                                                    //alert(isvaldd);
                                                    if(isvaldd != '1'){ 
                                                        alert("Please Enter Valid Password.");
                                                        //document.getElementById("msg_div").innerHTML = "Please Enter Valid Password.";
                                                        return false;	
                                                    }
                                //*********************************************/
					
					}				
				


					if(EmpCode!=''){
						DataExist = CheckExistingData("isRecordExists.php","&EmpCode="+escape(EmpCode), "EmpCode","User Code");
						if(DataExist==1)return false;
					}

					/**********************/
					DataExist = CheckExistingData("isRecordExists.php", "&Type=Employee&Email="+escape(document.getElementById("Email").value), "Email","Email Address");
					if(DataExist==1)return false;
					/**********************/

					/*
					var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("EmpID").value+"&Type=Employee";
					SendExistRequest(Url,"Email", "Email Address");*/



					ShowHideLoader('1','S');

					return true;	
					
			}else{
					return false;	
			}	

		
}
</script>
<!--Amit Singh-->
<script type="text/javascript" src="<?=$MainPrefix?>js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
       margin-top: -80px !important;
    right: 326px !important;
    }
</style>
<!--End-->

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateEmployee(this);" enctype="multipart/form-data">
  <?php if (!empty($_SESSION['mess_user'])) {?>
<tr>
<td  align="center"  class="message"  >
	<?php if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?>	
</td>
</tr>
<?php } ?>

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Personal Details</td>
</tr>

<tr>
		<td  align="right" valign="center"  class="blackbold">New Employee : </td>
		<td  colspan="3" align="left" valign="top">
		
<select name="ExistingEmployee" id="ExistingEmployee" class="textbox" onChange="Javascript:EmployeeShow();">
	<option value="1">Yes</option>
	<option value="0">No</option>
</select>

</td>
</tr>

 <tr>
        <td  align="right"   class="blackbold"> User Code : </td>
        <td   align="left" >

	<input name="EmpCode" type="text" class="datebox" id="EmpCode" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_EmpCode');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_EmpCode','EmpCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_EmpCode"></span>

</td>
     
	     <td  align="right"  class="blackbold" >Gender :<span class="red">*</span> </td>
	     <td   align="left" >
		 
		 
          <input type="radio" name="Gender" id="Gender" value="Male" <?=($arryEmployee[0]['Gender']=="Male")?("checked"):("");?>/>
          Male&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Gender" id="Gender" value="Female"  <?=($arryEmployee[0]['Gender']=="Female")?("checked"):("");?>  />
          Female		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" width="20%"> First Name  :<span class="red">*</span> </td>
        <td   align="left" width="40%">
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
     
        <td  align="right"   class="blackbold" width="15%"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryEmployee[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   



<tr>
        <td colspan="4">  
     <div id="EmpDiv">
     <table width="100%" border="0" cellpadding="5" cellspacing="0" >

  <tr>
        <td  align="right"   width="20%"> Date of Birth :  </td>
        <td   align="left" width="40%" >
		
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

<input id="date_of_birth" name="date_of_birth" readonly="" class="datebox" value="<?=$arryEmployee[0]['date_of_birth']?>"  type="text" >         </td>
     
        <td align="right"   class="blackbold" width="15%">Joining Date  :</td>
        <td  align="left" >	
		
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


<input id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value="<?=$arryEmployee[0]['JoiningDate']?>"  type="text" >		</td>
      </tr>
 
	  	  


	<tr>
        <td  align="right"  class="blackbold"> Designation  : </td>
        <td   align="left" >
<input name="JobTitle" type="text" class="inputbox" id="JobTitle" value="<?php echo stripslashes($arryEmployee[0]['JobTitle']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/> 
	
</td>
     
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

<? 
$MainDir = "upload/employee/".$_SESSION['CmpID']."/";
if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ ?>
				
	<div  id="ImageDiv"><a href="<?=$MainDir.$arryEmployee[0]['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=150&h=150&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 >';?></a>
	
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['Image']?>','ImageDiv')"><?=$delete?></a>	</div>
<?	} ?>
	
		</td>
  </tr>	  
 



<tr>
       		 <td colspan="4" align="left"   class="head">Contact Details</td>
        </tr>


   
	  
	    <tr>
        <td align="right"   class="blackbold">Personal Email  : </td>
        <td  align="left" ><input name="PersonalEmail" type="text" class="inputbox" id="PersonalEmail" value="<?php echo $arryEmployee[0]['PersonalEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Contact Address  :</td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryEmployee[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?
	if($arryEmployee[0]['country_id'] != ''){
		$CountrySelected = $arryEmployee[0]['country_id']; 
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
	  <td  align="left" id="state_td" class="blacknormal" >&nbsp;</td>
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
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryEmployee[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryEmployee[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);" />			</td>
      </tr>



	</table>
	</div>
	</td>
</tr>






	
		

	
	<tr>
       		 <td colspan="4" align="left" class="head">Account / Login Details</td>
        </tr>
		
      <tr>
        <td  align="right"   class="blackbold" > Email :<span class="red">*</span> </td>
        <td   align="left" colspan="3"><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryEmployee[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Employee','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	  <? if(empty($_GET['edit'])){ ?>
        <tr>
        <td  align="right"   class="blackbold">Password :<span class="red">*</span> </td>
        <td   align="left" colspan="3" class="blacknormal"><input name="Password" type="Password" class="inputbox" id="Password" value="<?php echo stripslashes($arryEmployee[0]['Password']); ?>"  maxlength="15" autocomplete="off"/>          <span  class="passmsg"><?=PASSWORD_LIMIT?></span>
        <?php require_once($MainPrefix."password_strength_html.php"); ?>
        </td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" colspan="3" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value="<?php echo stripslashes($arryEmployee[0]['Password']); ?>"  maxlength="15" autocomplete="off"/> </td>
      </tr>	
	 <? } ?>
	 
      
	  
	

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';$InActiveChecked ='';
			 if($_GET['edit'] > 0){
				 if($arryEmployee[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryEmployee[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>
	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="Division" id="Division" value="<?=$Division?>" />
<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>


