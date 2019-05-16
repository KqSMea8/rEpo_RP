<?php  if($HideNavigation!=1){?>
<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had"><?= $MainModuleName ?> <span>&raquo; <? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>

</span></div>
<?php }?>
<? if (!empty($errMsg)) {?>
<div align="center" class="red"><?php echo $errMsg;?></div>
<? } ?>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_contact'])) { 
    echo $_SESSION['mess_contact'];
    unset($_SESSION['mess_contact']);
} ?></div>




<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script language="JavaScript1.2" type="text/javascript">
    
    
function validateRule(frm){
    
    
        if((frm.Markread.checked==false) && (frm.MarkasFlagged.checked==false) && (frm.MovetoFolder.checked==false))
        {
           alert("Select Atleast one rule"); 
           return false;
        }

        else if((frm.MovetoFolder.checked==true) && (frm.FolderID.value=='NotSelected'))
        {
           alert("Please select Folder");
           frm.FolderID.focus();
           return false;
        }
   
        
    
		
}

function validateRuleFirstTime(frm){
    
     if(ValidateForSimpleBlank(frm.RuleEmail, "Email") && isEmail(frm.RuleEmail))
    {
        if((frm.Markread.checked==false) && (frm.MarkasFlagged.checked==false) && (frm.MovetoFolder.checked==false))
        {
           alert("Select Atleast one rule"); 
           return false;
        }

        else if((frm.MovetoFolder.checked==true) && ((frm.FolderID.value=='NotSelected')) || (frm.FolderID.value=='CreateFolder'))
        {
           alert("Please select Folder");
           frm.FolderID.focus();
           return false;
        }
    }else {
        return false;
    }
		
		
}
</script>

<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
        <form name="form1" action="" method="post" onSubmit="<?php if(empty($_GET['edit']) && empty($_GET['emailNo'])){ ?>return validateRuleFirstTime(this); <?php } else {?> return validateRule(this); <?php } ?>" enctype="multipart/form-data">


	<tr>
		<td align="center" valign="top">


		<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
                    <?php
                    if(sizeof($RuleDataArray) > 0)
                    {
                    ?>
                    
                       <tr>
                           <td colspan="4" align="left" class="head">Add Rule | from:(<?php echo $emailInfo[0]["From_Email"]?>)<br>Rule is already created for above emailid <a href="editImportEmailRule.php?edit=<?=$RuleDataArray[0]["RuleID"]?>&pop=Yes">Click here for edit</a></td>
			</tr>
                    <?php } else {

                        ?>     
                    
                        
			<tr>
                            <td colspan="" align="left" class="head" style="width:90px;">
                                <?php if(empty($_GET["edit"])) {echo "Add";} else { echo "Edit";} ?> Rule | from:
                            </td>
                                                        
                           <td  class="head" style="width:390px;"><?php echo $emailInfo[0]["From_Email"]?><?php if(empty($_GET['edit']) && empty($_GET['emailNo'])){ ?><input type="text" name="RuleEmail" id="RuleEmail" value="" class="inputbox"><?php } ?></td>

                            <td colspan="2" align='left' class="head"></td>                                                                                                                                                                             
			</tr>
                        
                        <tr>
                                <td colspan="4" align="left" class="head">When a message arrives from above Email Id that matches these rules:</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">
                                    
				</td>
                                <td align="left">
                                    <input type="checkbox" name="Markread" id="Markread" value="1" <?php if($RulesDetails[0]["ReadEmail"]==1) echo "checked"; ?>> Mark as read 
                                </td>

			</tr>
			<tr>
				<td align="right" class="blackbold">
                                    
				</td>
                                <td align="left">
                                    <input type="checkbox" name="MarkasFlagged" id="MarkasFlagged" value="1" <?php if($RulesDetails[0]["FlaggedEmail"]==1) echo "checked";?> > Mark as flagged  
                                </td>

			</tr>

			<tr>
				<td align="right" class="blackbold">
                                    
				</td>
                                <td align="left">
                                    <input type="checkbox" name="MovetoFolder" id="MovetoFolder" value="1" <?php if($RulesDetails[0]["MoveToFolder"]==1) echo "checked";?>> Move to folder   
                                    <span id="folderContID"><select name="FolderID" id="FolderID" class="inputbox" onchange="CreateFolderdropdown(this.value);">
                                        <option value="NotSelected">Choose Folder</option>
                                        <option value="CreateFolder">Create Folder</option>
                                        <option value="Inbox" <?php if($RulesDetails[0]["FolderName"]=='Inbox') echo "selected";?>>Inbox</option>
                                        <option value="Spam" <?php if($RulesDetails[0]["FolderName"]=='Spam') echo "selected";?>>Spam</option>
                                        <?php
                                        for($i=0;$i<sizeof($FolderList);$i++) {
                                            ?>
                                            <option value="<?=$FolderList[$i]['FolderId']?>" <?php if($RulesDetails[0]["FolderID"]==$FolderList[$i]['FolderId']) echo "selected";?>><?=$FolderList[$i]['FolderName']?></option>
                                        <?php 
                                        }
                                        ?>
                                        
                                    </select>
                                    </span>
                                    
                                    <input type="text" name="AddNewFolder" id="AddNewFolder" class="inputbox" value="" style="display:none;" > 
                                    <input type="submit" name="AddFolder" id="AddFolder" value="AddFolder" class="button" style="display:none;" onclick="return CreateFolderWithAjax();"  >   
                                    
                                </td>
			</tr>

			<tr>
				<td align="right" class="blackbold">
                                    
				</td>
                                <td align="left">
                                    
                                </td>
			</tr>
		</table>

		</td>
	</tr>



	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
		<input name="Submit" type="submit" class="button" id="SubmitButton"
			value=" <?=$ButtonTitle?> " />
                    
                     <input type="hidden" name="RuleID" id="RuleID"  value="<?php echo $_GET['edit'] ?>" />
                     <input type="hidden" name="RuleForEmail" id="RuleForEmail"  value="<?php echo $emailInfo[0]["From_Email"] ?>" />
                     
                    <input type="hidden" name="AdminID" id="AdminID"  value="<?php echo $_SESSION['AdminID']; ?>" />	
                    <input type="hidden" name="AdminType" id="AdminType"  value="<?php echo $_SESSION['AdminType']; ?>" />
                    <input type="hidden" name="EmailListId" id="EmailListId"  value="<?php echo $EmailListData[0]['id']; ?>" />
                    <input type="hidden" name="EmailListName" id="EmailListName"  value="<?php echo $EmailListData[0]['EmailId']; ?>" />
                    <input type="hidden" name="OwnerEmailId" id="OwnerEmailId"  value="<?php echo $OwnerEmailId; ?>" />
                    <?php if(empty($_GET['edit']) && empty($_GET['emailNo'])){ ?><input type="hidden" name="FirstTimeAdded" id="FirstTimeAdded"  value="Yes" /><?php } ?>
                    
                
                </div>

		</td>
	</tr>
                    <?php } ?>
	</form>
</table>

<script>

function CreateFolderdropdown(foldervalue)
{
   if(foldervalue=='CreateFolder')
   {
      document.getElementById("AddNewFolder").style.display='initial';
      document.getElementById("AddFolder").style.display='initial';
      
   }else {
      document.getElementById("AddNewFolder").style.display='none';
      document.getElementById("AddFolder").style.display='none'; 
   }
   
   
}
function CreateFolderWithAjax()
{
   
   if(document.getElementById("AddNewFolder").value=='')
   {
       alert("Please Enter Folder Name");
       document.getElementById("AddNewFolder").focus();
       return false;
   }else {
       
       var  sendParam='';
       folName='';
       
       
       
        folName=document.getElementById("AddNewFolder").value;
       
        sendParam='actionn=checkFolderName&foldername='+folName+'&folderid=&AdminId='+<?=$_SESSION['AdminID']?>+'&CompId='+<?=$_SESSION[CmpID]?>+'&randomval='+Math.random();
                 
                $.ajax({
                        type: "POST",
                        async:false,
                        url: 'ajax.php',
                        data: sendParam,
                        success: function (responseText) {
                            
                           if(responseText > 0)
                           {
                              alert("Folder Name Already Exist");
                              document.getElementById("AddNewFolder").focus();
                              return false;
                           }
                           else {
                               
                               var emaillistttid=document.getElementById("EmailListId").value;
                               var emaillisstname=document.getElementById("EmailListName").value;
                               
                               var admintypee=document.getElementById("AdminType").value;
                                //sendParam1='actionn1=AddFolderName&Name=iii&AdminID='+<?=$_SESSION['AdminID']?>+'&AdminType='+<?=$_SESSION['AdminType']?>+'&EmailListId='+emaillistttid+'&EmailListName='+emaillisstname+'&randomval='+Math.random();
                            sendParam1='actionn1=AddFolderName&Name='+folName+'&AdminID='+<?=$_SESSION['AdminID']?>+'&AdminType='+admintypee+'&EmailListId='+emaillistttid+'&EmailListName='+emaillisstname+'&randomval='+Math.random();
     
                         $.ajax({
                                type: "POST",
                                async:false,
                                url: 'ajax.php',
                                data: sendParam1,
                                success: function (responseText1) {
                                    
     
                                    document.getElementById("folderContID").innerHTML= responseText1;
                                    document.getElementById("AddNewFolder").style.display='none';
                                    document.getElementById("AddFolder").style.display='none';  
                                      
                                  }
                                });
                               
                               
                               
                           }
                           
                           
                           
        
                        }
          });
        
       return false;
       
   }
   
   
   
}


$(document).ready(function() {
           
     
         $("#RuleEmail").tokenInput("fromEmailList.php?activatedEmail=<?=$EmailListData[0]['EmailId']?>&OwnerEmailID=<?=$OwnerEmailId?>", {
                                  theme: "facebook",
                                  preventDuplicates: true,
                                  hintText: "Search Email From",
                                  propertyToSearch: "email",
                                  tokenValue: "email",
                                  crossDomain: true,
                                  resultsFormatter: function(item) {
                                  console.log(item);
                                  if(typeof item.name == "undefined") 
                                        return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email + "</div><div class='email'></div></div></li>"
                                                else
                                                return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email + "</div><div class='email'></div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email +    "</div><div class='email'></div></div></li>"
                                                }
                                            });
                                       
   
    });
</script>





