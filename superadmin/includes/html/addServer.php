<SCRIPT LANGUAGE=JAVASCRIPT>


function SetModuleOff()
{
	var flag = false; var checkflag = ''; var ErpOff = 0;
	if(document.getElementById("Department0").checked){
		flag = true;
		checkflag = 1;
	}else{
		flag = false;
	}
	
	
	for(var i=1;i<=4;i++){
		document.getElementById("Department"+i).disabled =  flag;
		if(checkflag==1){
			document.getElementById("Department"+i).checked =  false;
		}

		if(document.getElementById("Department"+i).checked == false){
			ErpOff = 1;
		}

	}



	
	if(ErpOff == 0){
		document.getElementById("Department0").checked =  true;
		for(var i=1;i<=4;i++){
			document.getElementById("Department"+i).disabled =  true;
			document.getElementById("Department"+i).checked =  false;		
		}
	}



}




</SCRIPT>

<div><a href="callServerList.php" class="back">Back</a></div>



	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } ?>


	<script language="JavaScript1.2" type="text/javascript">
	/*
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
		&& ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")
		&& ValidateMandRange(frm.DisplayName, "Display Name",3,30)
		&& isDisplayName(frm.DisplayName)
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){  
		
						
					if(!ValidateForSelect(frm.Timezone, "Timezone")){
						return false;
					}				
		
					if(document.getElementById("CmpID").value<=0){
						if(!ValidateForSimpleBlank(frm.Password, "Password")){
							return false;
						}
						
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
*/
</script>

<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<!--<form name="form1" action=""  method="post" onSubmit="return validateCompany(this);" enctype="multipart/form-data"> -->
<form name="form1" action=""  method="post"  enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Server Details</td>
</tr>
	<tr>
	<td  align="right"   class="blackbold"> Server Name  :<span class="red">*</span> </td>
	<td   align="left" >
 
	<input name="serverName" type="text"  class="inputbox" value="<?php echo $server_name; ?>"  maxlength="50" />
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold"> Server IP  :<span class="red">*</span> </td>
	<td   align="left" >
	<input name="serverIP" type="text" class="inputbox"  value="<?php echo $server_ip; ?>"  maxlength="30" /></td>
	</tr>	 
	
	<tr>
	<td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Server ID  :<span class="red">*</span></td>
	<td  align="left" class="blacknormal">
	<input name="serverID" type="text" class="inputbox" id="ContactPerson" value="<?php echo $server_user; ?>"  maxlength="30" />
	</td>
	</tr>
	
	<tr>
	<td  align="right" class="blackbold"> <div id="StateTitleDiv">Server Password  :<span class="red">*</span></div> </td>
	<td   align="left" ><div id="StateValueDiv">
	<input name="serverPassword" type="text" class="inputbox" id="OtherState" value="<?php echo $server_password; ?>"  maxlength="30" /> </div>          
	</td>
	</tr>
     
	<tr>
	<td  align="right" class="blackbold"><div id="CityTitleDiv"> Server Port :<span class="red">*</span></div>  </td>
	<td align="left" >
	<div id="CityValueDiv">
	<input name="serverPort" type="text" class="inputbox"  value="<?php echo $server_port; ?>"  maxlength="30" />  </div>   </td>
	</tr>
	
	
      <tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';$InActiveChecked ='';
			 if($_GET['edit'] > 0){
				 if($callServer[0]->status == 'Active') {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($callServer[0]->status == 'Deactive') {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <label><input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive</label> </td>
      </tr>
	  
	<tr>
	<td  align="right"   class="blackbold" >&nbsp; </td>
	<td  align="left">

	<div id="SubmitDiv" style="display:none1">

	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

	</div>

	</td>
	</tr>
	
</table>	
  

	
	  
	
	</td>
   </tr>

   

 
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	ShowPermission();
</SCRIPT>


