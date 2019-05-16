
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<script>
    function validateVariant(frm){

	
	if( ValidateForSimpleBlank(frm.mail_chimp_Api_Key, "Mail chimp Api Key")
		//&& ValidateForSelect(frm.assignedTo, "Assigned To")
		&& ValidateForSelect(frm.mail_chimp_cmpId, "Mail chimp cmpId")
		&& ValidateForSelect(frm.groupId, "GroupId")
                && ValidateForSelect(frm.group_name, "Group name")
		){
                               
                                
                                 	
                  
                                        return true;
}
                                else{
					
                                return false;	
			}
                        //return false;
}
    </script>



<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="upload/MailChimpGuidelines.pdf" target="_blank" class="download" style="float:right;margin-left:5px;">Download Instructions</a>

<?php if(!empty($accountdetail)) { ?>
<div class="had">List Mail Chimp Account </div>
<div id="preview_div">
   <TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
<form id="form1" name="form1" action=""  method="post"  enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

    <?php if (!empty($_SESSION['message'])) {?>
    <tr>
        <td  align="center"  class="message"  >
        <?php if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
        </td>
    </tr>
    <?php } ?>
  
    <tr>
        <td  align="center" valign="top" >
                    <table <?= $table_bg ?>>
                        
						<tr align="left"  >
							<td width="11%" class="head1">Authorize Api Key</td>  
							<td width="9%" class="head1">Mail chimp CompanyId</td>								
							<td width="9%" class="head1">Group Id</td> 
							<td width="11%" align="center" class="head1" >Group Name</td>
							
							<td width="10%"  align="center" class="head1 head1_action" >Action</td>
						</tr>

							<tr align="left"  bgcolor="<?= $bgcolor ?>">  
							 <td><?= (!empty($accountdetail[0]['mail_chimp_Api_Key'])) ? stripslashes($accountdetail[0]['mail_chimp_Api_Key']) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($accountdetail[0]['mail_chimp_cmpId'])) ? stripslashes($accountdetail[0]['mail_chimp_cmpId']) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($accountdetail[0]['groupId'])) ? stripslashes($accountdetail[0]['groupId']) : (NOT_SPECIFIED) ?> </td>		
							<td align="center">
							<?= (!empty($accountdetail[0]['group_name'])) ? stripslashes($accountdetail[0]['group_name']) : (NOT_SPECIFIED) ?>		
							</td>
								
							
							<td  align="center" class="head1_inner">
							<a href="mailChimpSetting.php?AccountD_id=<?php echo $accountdetail[0]['id']; ?>" onclick="return confirmDialog(this, 'Group Id')"  ><?= $delete ?></a>   
							</td>
							</tr>
                          

                          

                       
                    </table>
        </td>
        </tr>
   
   
</table>
</form>
</td>
</tr>
 
</table>
        

                </div>	
<?php } else if(empty($accountdetail)) { ?>
<div class="had">Create  Mail Chimp Account </div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
<form id="form1" name="form1" action=""  method="post" onSubmit="return validateVariant(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

    <?php if (!empty($_SESSION['message'])) {?>
    <tr>
        <td  align="center"  class="message"  >
        <?php if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
        </td>
    </tr>
    <?php } ?>
  
    <tr>
        <td  align="center" valign="top" >
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
            <tr>
                <td colspan="2" align="left"  class="head" >Required Fields</td>
            </tr>
            <tr>
                <td  align="right" width="40%"  class="blackbold">Authorize Api Key:<span class="red">*</span> </td>
                <td><input type="text" id="mail_chimp_Api_Key" name="mail_chimp_Api_Key" class="inputbox" value=""/></td>
            </tr>
            <tr>
                <td  align="right" width="40%"  class="blackbold">Mail chimp CompanyId:<span class="red">*</span> </td>
                <td   align="left" >
                <input type="text" id="mail_chimp_cmpId" name="mail_chimp_cmpId" class="inputbox"value=""/></td>
            </tr>
            <tr>
                <td  align="right" width="40%"  class="blackbold">Group Id:<span class="red">*</span> </td>
                <td   align="left" >
                <input type="text" id="groupId" name="groupId" class="inputbox"value=""/></td>
            </tr> 
            <tr>
                <td  align="right" width="40%"  class="blackbold">Group Name:<span class="red">*</span> </td>
                <td   align="left" >
                <input type="text" id="group_name" name="group_name" class="inputbox"value=""/></td>
            </tr>  
        </table>	
        </td>
    </tr>

<tr>
        <td  align="center" >
        <div id="SubmitDiv" style="display:none1">
        <?php if(isset($res_contE)){?>
            <input type="hidden" name="hC_id" value="<?php echo $res_contE->contactId;?>" />
            <input name="add_cont" type="submit" class="button" id="SubmitButton" value="Update" />
        <?php }else{?>
        <input name="add_setting" type="submit" class="button" id="SubmitButton" value="Submit"/>
        <?php }?>
        </div>
        </td>
</tr>
   
   
</table>
</form>
</td>
</tr>
 
</table>
</div>
<?php  } ?>
						
							
							
