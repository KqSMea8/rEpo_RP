<?php // echo 'hello'; die;?>
<script language="JavaScript1.2" type="text/javascript">
function validate_personal(frm){

	var DataExist=0;
	/**********************/
	var EmpCode = Trim(document.getElementById("EmpCode")).value;
	if(EmpCode!=''){
		if(!ValidateMandRange(document.getElementById("EmpCode"), "User Code",3,20)){
			return false;
		}
	}
	/**********************/



	if( ValidateRadioButtons(frm.Gender, "Gender")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")		
		){

			if(document.getElementById('ExistingEmployee').value == 1){
				/*if(!ValidateForSelect(frm.date_of_birth,"Date of Birth")){
					return false;
				}
				if(!ValidateForSimpleBlank(frm.JobTitle,"Designation")){
					return false;
				}*/
			}






			if(EmpCode!=''){
				DataExist = CheckExistingData("isRecordExists.php","&EmpCode="+escape(EmpCode)+"&editID="+document.getElementById("EmpID").value, "EmpCode","User Code");
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
		&& ValidateForSimpleBlank(frm.IFSCCode,"IFSC Code")
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

	if(     isEmailOpt(frm.PersonalEmail)
		//&& ValidateForTextareaMand(frm.Address,"Contact Address",10,200)
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
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
							
			var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("EmpID").value+"&Type=Employee";
			SendExistRequest(Url,"Email", "Email Address");
			
			return false;	
		}else{
			return false;	
		}	
}


function validate_role(frm){
	ShowHideLoader('1','S');
}

function ShowPermissionGroupRole(){
	if(document.getElementById("GroupID").value >0 ){		
		$("#PermissionsVal").hide();
		$("#CollapseExpand").hide();
		$("#PermissionsHad").hide();
	}else{		
		$("#PermissionsVal").show();
		$("#CollapseExpand").show();
		$("#PermissionsHad").show();

	}
}
</script>
<!--Amit Singh-->
<script type="text/javascript" src="<?=$MainPrefix?>js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
        right: 221px !important;
    top: 259px !important;
    }
</style>
<!--End-->


	




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
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

<!-----------------------------  Code By Ravi For Chat 11-05-15 ----------------------->
	  	<?php if($_GET["tab"]=="chat"){	  
	  		$chatpermission=$serailchatpermission=$chatrole=array();
	  			 $chatuid=$_GET['edit'];	  
	  		$serailchatpermission=$objchat->getPermissionByUser($_GET['edit']);	  		
	  	 	if(!empty($serailchatpermission[0]->permission)){
	  	 	
	  	 		$chatpermission=unserialize($serailchatpermission[0]->permission);
	  	 	
	  	 	}
	  	 	$chatroles=$objchat->getchatrole($chatuid);
		  	 if(!empty($chatroles)){
		  	 	foreach($chatroles as $chatro){
		  	 		$chatrole[]=$chatro->rolename;
	
		  	 	}
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
			
			<tr>
				<td colspan="2" align="left" class="head">Chat Role</td>
			</tr>
			<tr>
				<td align="" class="blackbold">Roles :</td>
				<td align="" class="blackbold"><ul class="chat-role"><li><label>Sales</label><input type ="checkbox" name="chatrole[]" value="Sales" <?php if(in_array("Sales",$chatrole)) echo "checked";?>/></li>
				<li><label>Support</label><input type ="checkbox" name="chatrole[]" value="Support" <?php if(in_array("Support",$chatrole)) echo "checked";?>/></li></ul></td>				
			</tr>
			<?php }?>
	<!------------------------ End Code------------------------->

  <!------------------------ zoom added sanjiv ------------------------->
	<? if($_GET["tab"]=="zoom"){

			if(empty($objMeeting->findMeetingUserByAdmin()) && ($_SESSION['AdminType']=='admin')){
 				$createAdminData = array();
				$createAdminData['email'] = $_SESSION['AdminEmail'];
				$createAdminData['first_name'] = $_SESSION['DisplayName'];
				$result = $objMeeting->custcreateAdminUser($createAdminData);
						if(!empty($result->email)){
							$result->created_at  = $objMeeting->convertIsoDateToSql($result->created_at);
							$result->account_type= 'admin';
							$result->cust_id= $_SESSION['AdminID'];
							$objMeeting->saveUser($result);
							$_SESSION['mess_user'] = 'Your Account is activated successfully.';
						}else if($result->error){
							$_SESSION['mess_user'] = $result->error->message;
						}else{
							$_SESSION['mess_user'] = 'Something went wrong. Contact to Administrator!';
						}
			}

	  		$zoompermission=$serailzoompermission=array();
	  			 	  
	  		$serailzoompermission=$objMeeting->getPermissionByUser($_GET['edit']);
	  				  
	  	 	if(!empty($serailzoompermission[0]['permission'])){
	  	 	
	  	 		$zoompermission=unserialize($serailzoompermission[0]['permission']);
	  	 	
	  	 	}
	  	?>
			<tr>
				<td colspan="2" align="left" class="head">Zoom Permission 
					<input type="hidden" value="<?php echo $arryEmployee[0]['Email']; ?>" name="Email">
					<input type="hidden" value="<?php echo $arryEmployee[0]['FirstName']; ?>" name="FirstName">
					<input type="hidden" value="<?php echo $arryEmployee[0]['LastName']; ?>" name="LastName">
				</td>
			</tr>

			<tr>
				<td align="" class="blackbold">Create Meetings :</td>
				<td align="" class="blackbold"><input type ="checkbox" name="zoompermission[]" value="createMeeting" <?php if(in_array("createMeeting",$zoompermission)) echo "checked";?>/></td>				
			
			</tr>

			<tr>
				<td align="" class="blackbold">View Recordings:</td>
				<td align="" class="blackbold"><input type ="checkbox" name="zoompermission[]" value="viewRecording" <?php if(in_array("viewRecording",$zoompermission)) echo "checked";?>/></td>				
			</tr>

			<tr>
				<td align="" class="blackbold">Delete Recordings :</td>
				<td align="" class="blackbold"><input type ="checkbox" name="zoompermission[]" value="deleteRecording" <?php if(in_array("deleteRecording",$zoompermission)) echo "checked";?>/></td>				
			
			</tr>

			<tr>
				<td align="" class="blackbold">View All :</td>
				<td align="" class="blackbold"><input type ="checkbox" name="zoompermission[]" value="viewAll" <?php if(in_array("viewAll",$zoompermission)) echo "checked";?>/></td>				
			</tr>
			<? }?>
	<!------------------------ End Code------------------------->

<?php if($_GET["tab"]=="personal"){ ?>
<tr>
	 <td colspan="4" align="left" class="head">Personal Details</td>
</tr>
<tr>
	 <td colspan="4">&nbsp;</td>
</tr>
<tr>
		<td  align="right" valign="center"  class="blackbold">New Employee : </td>
		<td  colspan="3" align="left" valign="top">
		
<select name="ExistingEmployee" id="ExistingEmployee" class="textbox" onChange="Javascript:EmployeeShow();">
	<option value="1" <?=($arryEmployee[0]['ExistingEmployee']=="1")?("selected"):("");?>>Yes</option>
	<option value="0" <?=($arryEmployee[0]['ExistingEmployee']=="0")?("selected"):("");?>>No</option>
</select>

</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%" valign="top"> User Code : </td>
        <td   align="left" width="30%" valign="top">

	<input name="EmpCode" type="text" class="datebox" id="EmpCode" value="<?php echo stripslashes($arryEmployee[0]['EmpCode']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_EmpCode');return isUniqueKey(event);" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_EmpCode','EmpCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" />
	<div id="MsgSpan_EmpCode"></div>

</td>
      
	     <td  align="right"  class="blackbold" width="20%">Gender :<span class="red">*</span> </td>
	     <td   align="left" >
		 
		 
          <input type="radio" name="Gender" id="Gender" value="Male" <?=($arryEmployee[0]['Gender']=="Male")?("checked"):("");?>/>
          Male&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Gender" id="Gender" value="Female"  <?=($arryEmployee[0]['Gender']=="Female")?("checked"):("");?>  />
          Female		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" > First Name  :<span class="red">*</span> </td>
        <td   align="left" > 
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);" />            </td>
     
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryEmployee[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   




<tr>
        <td colspan="4">  
     <div id="EmpDiv">
     <table width="100%" border="0" cellpadding="5" cellspacing="0" >





 <tr>
        <td  align="right"   width="20%"> Date of Birth :   </td>
        <td   align="left" width="30%" >
<?php if($arryEmployee[0]['date_of_birth']>0)$date_of_birth = $arryEmployee[0]['date_of_birth'];?>		
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
      




        <td  align="right"  class="blackbold" width="20%"> Designation  : </td>
        <td   align="left" >
<input name="JobTitle" type="text" class="inputbox" id="JobTitle" value="<?php echo stripslashes($arryEmployee[0]['JobTitle']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/> 
	
</td>
      </tr>
<?php if($arryEmployee[0]['JoiningDate']>0){ ?>
<tr>
  <td  align="right"   > Joining Date : </td>
        <td   align="left" >
		<?php 
		   echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate']));
		   
	   
	   ?>

        </td>
</tr>

<?php } ?>




</table>
	</div>
	</td>
</tr>











<script>
EmployeeShow();
</script>



	  



<tr>
	 <td colspan="4">&nbsp;</td>
</tr>

<!--
<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	
	
	
		</td>
  </tr>	 -->

 

<?php } ?>

<?php if($_GET["tab"]=="contact"){ ?>
	
	<tr>
       		 <td colspan="4" align="left"   class="head">Contact Details</td>
        </tr>
   
	  
	    <tr>
        <td align="right"   class="blackbold" width="45%">Personal Email  : </td>
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
		<?php
	if(!empty($arryEmployee[0]['country_id'])){
		$CountrySelected = $arryEmployee[0]['country_id']; 
	}else{
		$CountrySelected = $arryCurrentLocation[0]['country_id'];
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
              <?php for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?php  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <?php } ?>
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
        <td align="right"   class="blackbold" >Zip Code  : </td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryEmployee[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  : </td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryEmployee[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);"/>			</td>
      </tr>


<?php } ?>

  
 <? if($_GET["tab"]=="role"){ 
 	include($MainPrefix."includes/html/box/role_edit.php");
 } ?>
 
 
 
 


<?php 
	if($_GET["tab"]=="sales" && $Config['SalesCommission']==1){
		$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID);
	?>

 <tr>
       		 <td colspan="4" height="50">&nbsp;</td>
        </tr>	

	  <tr>
				<td  align="right" class="blackbold" width="45%">Sales Commission :</td>
				<td align="left">

				<select name="CommType" class="inputbox" id="CommType" onChange="Javascript:CommTypeOption();">
					<option value="">--- None ---</option>
					<?php for($i=0;$i<2;$i++) {?>
						<option value="<?=$arryCommType[$i]['attribute_value']?>" <?  if($arryCommType[$i]['attribute_value']==$arrySalesCommission[0]['CommType']){echo "selected";}?>>
						<?=$arryCommType[$i]['attribute_value']?>
						</option>
					<?php } ?>
				</select> 	</td>
			  </tr>	
					
			      <tr>
				<td align="right" class="blackbold" >
				<div id="PercentageTitle">Commission Percentage  :<span class="red">*</span></div>
				<div id="AmountTitle">Commission Amount  :<span class="red">*</span></div>
				</td>
				<td  align="left"  >
				<div id="PercentageValue">
				<input name="CommPercentage" type="text" class="textbox" id="CommPercentage" value="<?=stripslashes($arrySalesCommission[0]['CommPercentage'])?>" size="3"  maxlength="3" onkeypress='return isNumberKey(event)'/> %	of Sales</div>	
				<div  id="AmountValue"><input name="CommAmount" type="text" class="textbox" id="CommAmount" value="<?=stripslashes($arrySalesCommission[0]['CommAmount'])?>" maxlength="10" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?></div>
						

			

		</td>
			</tr>


<tr>
        <td align="right"   class="blackbold" valign="top">
		<div id="TargetTitle">Sales Target for  Commission  :</div></td>
    <td height="30" align="left" valign="top" >
	
	 <div id="TargetValue"><input name="TargetAmount" type="text" class="textbox" id="TargetAmount" value="<?=stripslashes($arrySalesCommission[0]['TargetAmount'])?>" maxlength="15" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?></div>
	
	</td>
  </tr>	 



 <tr>
       		 <td colspan="4" height="50">

<SCRIPT LANGUAGE=JAVASCRIPT>
				CommTypeOption();
			</SCRIPT>

</td>
        </tr>	


	<?php } ?>





<?php if($_GET["tab"]=="account"){ ?>
	
	<tr>
       		 <td colspan="4" align="left" class="head"><?=$SubHeading?></td>
        </tr>
		
      <tr>
        <td  align="right"   class="blackbold" width="35%"> Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryEmployee[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Employee','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>
        <?php require_once($MainPrefix."password_strength_html.php"); ?>
        </td>
      </tr>
	  
	 
        <tr>
        <td  align="right"   class="blackbold">Password : </td>
        <td   align="left" class="blacknormal"><input name="Password" type="Password" class="inputbox" id="Password" value=""  maxlength="15" autocomplete="off"/> 
		<span  class="passmsg"><?=LEAVE_BLANK_PASSWORD?></span>
		

		
		</td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password : </td>
        <td   align="left" class="blacknormal"><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value=""  maxlength="15" autocomplete="off"/> </td>
      </tr>	
	
      
	  
	 


<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <?php 
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
	
 <?php } ?>	
	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	
	<div id="SubmitDiv" style="display:none1">
	
	<?php if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
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
<?php if($_GET["tab"]=="role"){ ?>
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


	ShowPermission();
<?php } ?>
</SCRIPT>

  







