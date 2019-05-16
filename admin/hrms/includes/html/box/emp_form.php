<script language="JavaScript1.2" type="text/javascript">
function EmployeeShow(){
	if(document.getElementById('ExistingEmployee').value == 0){
		$("#maintablerow tr").hide();
		$(".fixedtr").show();
	}else{
		$("#maintablerow tr").show();
		
	}
}

function validateEmployee(frm){

	var DataExist=0;
	/**********************/
	var EmpCode = Trim(document.getElementById("EmpCode")).value;
	if(EmpCode!=''){
		if(!ValidateMandRange(document.getElementById("EmpCode"), "Employee Code",3,20)){
			return false;
		}
	}
	/**********************/

	/*if(document.getElementById("depID") != null){
		document.getElementById("Department").value = document.getElementById("depID").value;
	}*/


	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		){
		

			if(document.getElementById('ExistingEmployee').value == 1){
				if(!ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)){
					return false;
				}
				if(!ValidateForSelect(frm.JoiningDate,"Joining Date")){
					return false;
				}
				if(!ValidateForSimpleBlank(frm.JobTitle,"Designation")){
					return false;
				}
				if(!ValidateForSelect(frm.JobType,"Job Type")){
					return false;
				}
				if(!ValidateForSelect(frm.Department,"Department")){
					return false;
				}
				if(!ValidateForSelect(frm.catID,"Category")){
					return false;
				}
			}


				
					if(!ValidateForSimpleBlank(frm.Email, "Email")){
						return false;
					}

					if(!isEmail(frm.Email)){
						return false;
					}	
                                        /**code for alphanumeric 
					if(!ValidateForPassword(frm.Password, "Password")){
						return false;
					}
					if(!isPassword(frm.Password)){
						return false;
					}
                                        *Problm */
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
					
						
					
				


					/**********************/
					if(EmpCode!=''){
						DataExist = CheckExistingData("isRecordExists.php","&EmpCode="+escape(EmpCode), "EmpCode","Employee Code");
						if(DataExist==1)return false;
					}

					/**********************/
					DataExist = CheckExistingData("isRecordExists.php", "&Type=Employee&Email="+escape(document.getElementById("Email").value), "Email","Email Address");
					if(DataExist==1)return false;
					/**********************/

					/*var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("EmpID").value+"&Type=Employee";
					SendExistRequest(Url,"Email", "Email Address");*/

					document.getElementById("prv_msg_div").style.display = 'block';
					document.getElementById("preview_div").style.display = 'none';


					return true;	
					
			}else{
					return false;	
			}	

		
}
</script>
<!--Amit Singh-->
<script type="text/javascript" src="../js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
       margin-top: -80px !important;
    right: 244px !important;
    }
</style>
<!--End-->

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateEmployee(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top"  >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" id="maintablerow">

<tr class="fixedtr">
		<td  align="right" valign="center"  class="blackbold">New Employee : </td>
		<td  colspan="3" align="left" valign="top">
		
<select name="ExistingEmployee" id="ExistingEmployee" class="textbox" onChange="Javascript:EmployeeShow();">
	<option value="1">Yes</option>
	<option value="0">No</option>
</select>

</td>
</tr>

<tr class="fixedtr">
        <td  align="right"   class="blackbold"> Employee Code : </td>
        <td   align="left" colspan="3">

	<input name="EmpCode" type="text" class="datebox" id="EmpCode" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_EmpCode');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_EmpCode','EmpCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_EmpCode"></span>

</td>
      </tr>


	

<tr class="fixedtr">
        <td  align="right"   class="blackbold" width="15%"> First Name  :<span class="red">*</span> </td>
        <td   align="left"  width="35%">
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      
        <td  align="right"   class="blackbold" width="15%"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryEmployee[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>

	
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryEmployee[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);" />			</td>
      
        <td align="right"   class="blackbold" >Joining Date  :<span class="red">*</span></td>
        <td  align="left" >	
		
<script>
$(function() {
$( "#JoiningDate" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-50?>:<?=date("Y")+2?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});
});
</script>


<input id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value="<?=$arryEmployee[0]['JoiningDate']?>"  type="text" >		</td>
      </tr>
 
	  


 

	<tr>
        <td  align="right"  class="blackbold"> Designation  :<span class="red">*</span> </td>
        <td   align="left" ><select name="JobTitle" class="inputbox" id="JobTitle">
          <option value="">--- Select ---</option>
          <? for($i=0;$i<sizeof($arryJobTitle);$i++) {?>
          <option value="<?=$arryJobTitle[$i]['attribute_value']?>" <?  if($arryJobTitle[$i]['attribute_value']==$arryEmployee[0]['JobTitle']){echo "selected";}?>>
          <?=$arryJobTitle[$i]['attribute_value']?>
          </option>
          <? } ?>
        </select></td>
     
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
     
        <td  align="right"   class="blackbold"> <div id="DeptTitle">Department  :<span class="red">*</span></div> </td>
        <td   align="left" >
		<div id="DeptValue"></div>
<input type="hidden" name="OldDeptID" id="OldDeptID" value="<?=$arryEmployee[0]['Department']?>" />	
<input type="hidden" name="Department" id="Department" value="<?=$arryVacancy[0]['Department']?>" />


	<script language="javascript">
	//DeptListSend('','');
	</script>

	</td>
      </tr-->	 


	  <tr>
 <td  align="right"   class="blackbold"> Department  :<span class="red">*</span> </td>
        <td   align="left" >
		<select name="Department" class="inputbox" id="Department">
	  <option value="">--- Select ---</option>
	  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
	  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryEmployee[0]['Department']){echo "selected";}?>>
	 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
	  </option>
	  <? } ?>
	</select>
	</td>
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






	
	<tr class="fixedtr">
       		 <td colspan="4" align="left" class="head">Account / Login Details</td>
        </tr>
		
      <tr class="fixedtr">
        <td  align="right"   class="blackbold" > Email :<span class="red">*</span> </td>
        <td   align="left" colspan="3" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryEmployee[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Employee','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>		 
	 <tr class="fixedtr">

        <td  align="right"   class="blackbold" valign="top">Password :<span class="red">*</span> </td>
        <td   align="left" class="blacknormal"><input name="Password" type="Password" class="inputbox" id="Password" value="<?php echo stripslashes($arryEmployee[0]['Password']); ?>"  maxlength="15" autocomplete="off"/>          
		
        <?php require_once("../password_strength_html.php"); ?>
        </td>
     
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value="<?php echo stripslashes($arryEmployee[0]['Password']); ?>"  maxlength="15" autocomplete="off"/> </td>
     
       
      </tr>

	<tr class="fixedtr">
       		  <td  align="right"   class="blackbold" valign="top"> Status  :</td>
			 
			 <td   align="left" >
			  <? 
		  	 $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryEmployee[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryEmployee[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive
			 
			 </td>
        </tr>


	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center" valign="top">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

</div>
