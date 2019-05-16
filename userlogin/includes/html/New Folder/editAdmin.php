
<SCRIPT LANGUAGE=JAVASCRIPT>

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}
function validate(frm)
{	
	if( ValidateForBlank(frm.Name, "Name")
	   && ValidateForBlank(frm.AdminUsername, "User Name")
	   && isUserName(frm.AdminUsername)
	   && ValidateMandRange(frm.AdminUsername, "User Name", 5, 25)
	   && ValidateForPassword(frm.AdminPassword, "Password")
	   && isPassword(frm.AdminPassword)
	   && ValidateMandRange(frm.AdminPassword, "Password", 5, 15)
	   && ValidateForEmail(frm.AdminEmail, "Email Address")
	   && isEmail(frm.AdminEmail)
	){
	
	
			var Url = "isRecordExists.php?AdminUsername="+escape(document.getElementById("AdminUsername").value)+"&editID="+document.getElementById("AdminUserID").value;
			SendExistRequest(Url,"AdminUsername","User Name");
			
			return false;
	}else{
		return false;	
	}
}
</SCRIPT>

<div class="had">
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
</div>
<TABLE WIDTH=768   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<form name="form1" action="" method="post" onSubmit="return validate(this);"><TR>
	  <TD align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="middle" >
		  <div class="message"><? if(!empty($_SESSION['mess_admin'])) {echo $_SESSION['mess_admin']; unset($_SESSION['mess_admin']); }?></div>
		    <table width="85%" border="0" cellpadding="0" cellspacing="0" >
              
               
                <tr>
                  <td align="center" valign="top" >
				   <div  align="right"><a href="viewAdmins.php" class="Blue">List Administrators</a></div><br>
				  
				  <table width="100%"  border="0" align="right" cellpadding="4" cellspacing="1" class="borderall">
                      
                      <tr>
                        <td align="right" valign="middle"  class="blackbold">Name <span class="red">*</span></td>
                        <td align="left" valign="middle"><input name="Name" type="text" class="inputbox" id="Name" size="20" value="<?=stripslashes($arryAdmin[0][Name])?>" maxlength="60" /></td>
                      </tr>
                      <tr>
                        <td width="28%" align="right" valign="middle"  class="blackbold">User Name <span class="red">*</span>  </td>
                        <td width="72%" align="left" valign="middle">
                        <input name="AdminUsername" type="text" class="inputbox" id="AdminUsername" size="20" value="<?=stripslashes($arryAdmin[0][Username])?>" maxlength="20">                        </td>
                      </tr>
                      <tr>
                        <td align="right" valign="top"  class="blackbold">Password <span class="red">*</span>  </td>
                        <td align="left" valign="top" class="blacknormal"><input name="AdminPassword" type="text"
						 class="inputbox" id="AdminPassword" size="20" value="<?=$arryAdmin[0][Password]?>" maxlength="30"> <span class="blacknormal" ><br>(Minimum of 5 to 15 characters in length.) </span> </td>
                      </tr>
					    <tr>
                        <td width="28%" align="right" valign="middle"  class="blackbold">Email <span class="red">*</span>  </td>
                        <td align="left" valign="middle">
                          <input name="AdminEmail" type="text" class="inputbox" id="AdminEmail" size="30" value="<?=stripslashes($arryAdmin[0][AdminEmail])?>" maxlength="70"></td>
                      </tr>
					     <tr >
					       <td align="right" valign="top"  class="blackbold">Allow Permissions</td>
					       <td align="left" class="blacknormal">
						   <? if($_GET['edit']==1){ 
						   		echo 'All Modules';
							  }else{
							  		$arrayAllModules = $objConfig->getMainModules($_GET['edit']);	
									$Line = 0;
									echo '<table cellspacing=0 cellpadding=2 width="100%"><tr>';
									for($i=0;$i<sizeof($arrayAllModules);$i++) { 
										$Line = $i+1;
										echo '<td>';
										
					   				?>
									
<input type="checkbox" name="Modules[]" id="Modules<?=$Line?>" value="<?=$arrayAllModules[$i]['ModuleID']?>"									<? if(!empty($arrayAllModules[$i]['AdminID']) && !empty($_GET['edit'])) echo " checked"; ?> /><?=stripslashes($arrayAllModules[$i]['Module'])?>
                       		 <?   
							 		echo '</td>';
							 			if ($Line % 2 == 0) {
											echo "</tr><tr>";
										}

							 
							  } 
							 	   echo '</tr></table>';
							  }	
							  ?>
								
						   
						   
						   
<?  if(sizeof($arrayAllModules)>1) {	?>
 <table width="100%"  border="0">
  <tr>
    <td align="right">
	<input type="hidden" name="Line" id="Line" value="<?=$Line?>" />
	
	<a href="javascript:SelectAllRecord();" class="normaltext-link">Select All</a> <span class="blackbold"> | </span> <a href="javascript:SelectNoneRecords();" class="normaltext-link"> Select None</a>&nbsp;</td>
  </tr>
</table>	
<? } ?>
						   
						   
						   </td>
			          </tr>
					     <tr >
                      <td align="right" valign="top"  class="blackbold">Status  </td>
                      <td align="left" class="blacknormal">
		
		<? if($_GET['edit']==1){?>	
		<input name="Status" type="hidden" value="1"  />Active		  
		<? }else{ ?>
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>  
		<? } ?>		                                          </td>
                    </tr>	
                  </table>
				 
				  
				  </td>
                </tr>
             
          </table> </td>
        </tr>
		
		<tr>
		<td align="center">
		<br> <input  type="hidden" name="AdminUserID" id="AdminUserID" value="<?=$_GET['edit']?>" />
		
		

		
		
		
		<input name="Submit" type="submit" id="SubmitButton" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
		<input type="reset" name="Reset" value="Reset" class="button" />
		<br><br><br><br>
		</td>
		</tr>
		
      </table></TD>
  </TR>
	 </form>
</TABLE>