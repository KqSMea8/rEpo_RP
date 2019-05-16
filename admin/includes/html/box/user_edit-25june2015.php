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
	}else{		
		$("#PermissionsVal").show();
		$("#CollapseExpand").show();

	}
}
</script>



	




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_user'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<? if($_GET["tab"]=="personal"){ ?>
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

	<input name="EmpCode" type="text" class="datebox" id="EmpCode" value="<?php echo stripslashes($arryEmployee[0]['EmpCode']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_EmpCode');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_EmpCode','EmpCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
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
        <td   align="left" >isEmailOpt
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
      




        <td  align="right"  class="blackbold" width="20%"> Designation  : </td>
        <td   align="left" >
<input name="JobTitle" type="text" class="inputbox" id="JobTitle" value="<?php echo stripslashes($arryEmployee[0]['JobTitle']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/> 
	
</td>
      </tr>
<? if($arryEmployee[0]['JoiningDate']>0){ ?>
<tr>
  <td  align="right"   > Joining Date : </td>
        <td   align="left" >
		<? 
		   echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate']));
		   
	   
	   ?>

        </td>
</tr>

<? } ?>




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

 

<? } ?>

<? if($_GET["tab"]=="contact"){ ?>
	
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
        <td align="right"   class="blackbold" >Zip Code  : </td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryEmployee[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  : </td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryEmployee[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);"/>			</td>
      </tr>


<? } ?>

  
 
 
 
 
 
	  
<? if($_GET["tab"]=="role"){ ?>

<tr>
		 <td colspan="4" align="left" class="head">Role/Permissions</td>
	</tr>	
<!--
<tr>
        <td  align="right"   class="blackbold" > Role  : </td>
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
	<input type="checkbox" name="vUserInfo" id="vUserInfo"  value="1" <?  if($arryEmployee[0]['vUserInfo']>0){echo "checked";}?> >
			
	 </td>
      </tr> 
 <tr>
        <td  align="right"   class="blackbold" > View All Records  : </td>
        <td   align="left" valign="bottom">

	<input type="checkbox" name="vAllRecord" id="vAllRecord"  value="1" <?  if($arryEmployee[0]['vAllRecord']>0){echo "checked";}?> >
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



<? 
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
					<? for($i=0;$i<2;$i++) {?>
						<option value="<?=$arryCommType[$i]['attribute_value']?>" <?  if($arryCommType[$i]['attribute_value']==$arrySalesCommission[0]['CommType']){echo "selected";}?>>
						<?=$arryCommType[$i]['attribute_value']?>
						</option>
					<? } ?>
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


	<? } ?>





<? if($_GET["tab"]=="account"){ ?>
	
	<tr>
       		 <td colspan="4" align="left" class="head"><?=$SubHeading?></td>
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


	ShowPermission();
<? } ?>
</SCRIPT>

  







