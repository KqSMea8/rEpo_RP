<script language="JavaScript1.2" type="text/javascript">
function validate_basic(frm){
	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		//&& ValidateForSelect(frm.date_of_birth,"Date of Birth")
		//&& ValidateForSelect(frm.AssignTo,"Assign To")	
		
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

	if( ValidateForTextareaMand(frm.Address,"Contact Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		){
		
			ShowHideLoader('1','S');
			
			
		
			return true;	
		}else{
			return false;	
		}	
}






function validate_portal(frm){

	if(frm.Supp_end_date.value>=frm.Supp_start_date.value){
			alert("Support End Date should be greater than Support Start Date.");
			return false;
		}	else{
		
		return true;
		}
}




function validate_Image(frm){
	if( ValidateOptionalUpload(frm.Image, "Image")
		
		){
			return true;	
		}else{
			return false;	
		}	
}
</script>

<div class="right_box">
  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
    <form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
      <? if (!empty($_SESSION['mess_contact'])) {?>
      <tr>
        <td  align="center"  class="message"  ><? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?>
        </td>
      </tr>
      <? } ?>
      <tr>
        <td  align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
            <? if($_GET["tab"]=="basic"){ ?>
            <tr>
              <td colspan="2" align="left" class="head">Basic Information</td>
            </tr>
            <tr>
              <td  align="right" width="45%"   class="blackbold"> First Name  :<span class="red">*</span> </td>
              <td   align="left" ><input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryContact[0]['FirstName']); ?>"  maxlength="40" />
              </td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
              <td   align="left" ><input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryContact[0]['LastName']); ?>"  maxlength="40" />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Email  :<span class="red">*</span> </td>
              <td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo stripslashes($arryContact[0]['Email']); ?>"  maxlength="80" />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Personal Email  :</td>
              <td  align="left" ><input name="PersonalEmail" type="text" class="inputbox" id="PersonalEmail" value="<?php echo stripslashes($arryContact[0]['PersonalEmail']); ?>"  maxlength="80" />
              </td>
            </tr>
            <tr style="display:none;">
              <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
              <td   align="left" ><script type="text/javascript">
$(function() {
	$('#date_of_birth').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '1930:<?=date("Y")?>', 
		maxDate: "-1D",  
        changeMonth: true,
       changeYear: true
		}
	);
});
</script>
                <input id="date_of_birth" name="date_of_birth" readonly="" class="disabled" size="10" value="<?=$arryContact[0]['date_of_birth']?>"  type="text" >
              </td>
            </tr>
            <tr style="display:none;">
              <td align="right"   class="blackbold">Company  : </td>
              <td  align="left" ><input name="Company" type="text" class="inputbox" id="Company" value="<?php echo stripslashes($arryContact[0]['Company']); ?>"  maxlength="60" />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Title  : </td>
              <td  align="left" ><input name="Title" type="text" class="inputbox" id="Title" value="<?php echo stripslashes($arryContact[0]['Title']); ?>"  maxlength="40" />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Department  : </td>
              <td  align="left" ><input name="Department" type="text" class="inputbox" id="Department" value="<?php echo stripslashes($arryContact[0]['Department']); ?>"  maxlength="50" />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Reference  : </td>
              <td  align="left" ><input name="Reference" type="checkbox"  <?php if($arryContact[0]['Reference']=="Yes"){ echo"checked";} ?> id="Reference" value="Yes" />
              </td>
            </tr>
            <tr style="display:none;">
              <td align="right"   class="blackbold">Reports To  : </td>
              <td  align="left" ><select name="ReportsTo" id="ReportsTo" class="inputbox">
                  <? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
                  <option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryContact[0]['ReportsTo']){echo "selected";}?>>
                  <?=stripslashes($arryEmployee[$i]['UserName']);?></option>
                  <? } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"> Lead Source  : </td>
              <td   align="left" ><select name="LeadSource" class="inputbox" id="LeadSource" >
                  <option value="">--- Select ---</option>
                  <? for($i=0;$i<sizeof($arryLeadSource);$i++) {?>
                  <option value="<?=$arryLeadSource[$i]['attribute_value']?>" <?  if($arryLeadSource[$i]['attribute_value']==$arryContact[0]['LeadSource']){echo "selected";}?>>
                  <?=$arryLeadSource[$i]['attribute_value']?>
                  </option>
                  <? } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"> Assigned To  : </td>
              <td   align="left" ><? if($HideSibmit!=1){?>
                <select name="AssignTo" class="inputbox" id="AssignTo" >
                  <option value="">--- Select ---</option>
                  <? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
                  <option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryContact[0]['AssignTo']){echo "selected";}?>>
                  <?=stripslashes($arryEmployee[$i]['UserName']);?>
                 </option>
                  <? } ?>
                </select>
                <? }else{ 
						$HideSibmit = 1;
					?>
                <div class="redmsg">No employee exist.</div>
                <? } ?>
              </td>
            </tr>







            <tr>
              <td align="right"   class="blackbold">Do Not Call  : </td>
              <td  align="left" ><input name="DoNotCall" type="checkbox"  <?php if($arryContact[0]['DoNotCall']=="Yes"){ echo"checked";} ?> id="DoNotCall" value="Yes"   />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Notify Owner  : </td>
              <td  align="left" ><input name="NotifyOwner" type="checkbox"  <?php if($arryContact[0]['NotifyOwner']=="Yes"){ echo"checked";} ?> id="NotifyOwner" value="Yes"   />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Email Opt Out : </td>
              <td  align="left" ><input name="EmailOptOut" type="checkbox"  <?php if($arryContact[0]['EmailOptOut']=="Yes"){ echo"checked";} ?> id="EmailOptOut" value="Yes"   />
              </td>
            </tr>
            <? } ?>
            <? if($_GET["tab"]=="portal"){ ?>
            <tr>
              <td colspan="2" align="left"   class="head">Customer Details</td>
            </tr>

 <tr>
        <td  align="right" width="45%"   class="blackbold">  Customer  : </td>
        <td   align="left" >
		
	<? if(sizeof($arryCustomer)>0){?>
	<select name="CustID" class="inputbox" id="CustID" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['Cid']?>" <?  if($arryCustomer[$i]['Cid']==$arryContact[0]['CustID']){echo "selected";}?>>
			<?=stripslashes($arryCustomer[$i]['FullName']);?> 
			</option>
		<? } ?>
	</select>

	<? }else{ 
		echo NO_CUSTOMER_EXIST;
	} ?>


            </td>
 </tr>

            <tr style="display:none;">
              <td  align="right"   > Portal User : </td>
              <td   align="left" ><input type="checkbox" name="PortalUser" id="PortalUser"  <?php if($arryContact[0]['PortalUser']=="Yes"){ echo"checked";} ?> value="Yes" ></td>
            </tr>
            <tr style="display:none;">
              <td  align="right"   > Support Start Date : </td>
              <td   align="left" >
			  <?php if($arryContact[0]['Supp_start_date']){
			  
			  $supportDate=explode(' ',$arryContact[0]['Supp_start_date']);
			  }
			  ?>
              
              <script type="text/javascript">
$(function() {


	$('#Supp_start_date').datepicker(
		{
		
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
		minDate: "-D", 
        changeMonth: true,
		changeYear: true
		}
	);
});
</script>
              
		
                <input id="Supp_start_date" name="Supp_start_date" readonly="" class="disabled" size="10" value="<?=$supportDate[0]?>"  type="text" >
              </td>
            </tr>
            <tr style="display:none;">
              <td  align="right"   > Support End Date : </td>
              <td   align="left" >
			  
			   <?php if($arryContact[0]['Supp_end_date']){
			  
			  $supportEndDate=explode(' ',$arryContact[0]['Supp_end_date']);
			  }
			  ?>
              
                   <script type="text/javascript">
$(function() {


	$('#Supp_end_date').datepicker(
		{
		
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
		minDate: "-D", 
        changeMonth: true,
		changeYear: true
		}
	);
});
</script>		

               
                <input id="Supp_end_date" name="Supp_end_date" readonly="" class="disabled" size="10" value="<?=$supportEndDate[0]?>"  type="text" >
              </td>
            </tr>
            <? } ?>
            <? if($_GET["tab"]=="contact"){ ?>
            <tr>
              <td colspan="2" align="left"   class="head">Address Details</td>
            </tr>
            <tr>
              <td align="right" width="45%"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
              <td  align="left" ><textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryContact[0]['Address'])?>
</textarea>
              </td>
            </tr>
            <tr <?=$Config['CountryDisplay']?>>
              <td  align="right"   class="blackbold"> Country  :</td>
              <td   align="left" ><?
	if($arryContact[0]['country_id'] > 0 ){
		$CountrySelected = $arryContact[0]['country_id']; 
	}else{
		$CountrySelected = $arryCurrentLocation[0]['country_id'];
	}
	?>
                <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                 <option value="">--Select Country--</option>
                  <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                  <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
                  <?=$arryCountry[$i]['name']?>
                  </option>
                  <? } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
              <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"><div id="StateTitleDiv">Other State  :</div></td>
              <td   align="left" ><div id="StateValueDiv">
                  <input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryContact[0]['OtherState']; ?>"  maxlength="30" />
                </div></td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
              <td  align="left"  ><div id="city_td"></div></td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div></td>
              <td align="left" ><div id="CityValueDiv">
                  <input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryContact[0]['OtherCity']; ?>"  maxlength="30" />
                </div></td>
            </tr>
            <tr>
              <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
              <td  align="left"  ><input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryContact[0]['ZipCode'])?>" maxlength="15" />
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
              <td  align="left"  ><input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryContact[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);"/>
              </td>
            </tr>
            <tr style="display:none;">
              <td align="right"   class="blackbold">Fax  : </td>
              <td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?php echo $arryContact[0]['Fax']; ?>"  maxlength="20" />
              </td>
            </tr>
           <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
  <input  name="Landline" id="Landline" type="text"  class="inputbox" value="<?=stripslashes($arryContact[0]['LandlineNumber'])?>"   maxlength="20" onkeypress="return isNumberKey(event);" />

				</td>
      </tr>
           
<tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>

		

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <Textarea name="Description" id="Description" class="textarea" maxlength="500"   ><?=stripslashes($arryContact[0]['Description'])?></Textarea></td>
			</tr>



 <? } ?>


            <? if($_GET["tab"]=="Image"){ ?>
            <tr>
              <td colspan="2" align="left" class="head">Image</td>
            </tr>
            <tr>
              <td colspan="2" height="50">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" align="right" valign="top"   class="blackbold" width="46%">  Image   :</td>
              <td  align="left" valign="top" ><input name="Image" type="file" class="inputbox" id="Image" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                <? if($arryContact[0]['Image'] !='' && file_exists('upload/contact/'.$arryContact[0]['Image']) ){ ?>
                <br>
                <br>
                
                <div id="ResumeDiv"> <a title="" href="upload/contact/<?=$arryContact[0]['Image']?>" data-fancybox-group="gallery" class="fancybox">View Image</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="Javascript:void(0);" onclick="Javascript:DeleteFile('upload/contact/<?=$arryContact[0]['Image']?>','ResumeDiv')">Delete Image</a> </div>
                <?	} ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" height="50">&nbsp;</td>
            </tr>
            <? } ?>
           
           
          </table></td>
      </tr>
      <tr>
        <td  align="center" ><br />
          <div id="SubmitDiv" style="display:none1">
            <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
            <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
            <input type="hidden" name="AddID" id="AddID" value="<?=$_GET['edit']?>" />
            <input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryContact[0]['state_id']; ?>" />
            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryContact[0]['city_id']; ?>" />
          </div></td>
      </tr>
    </form>
  </table>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>
