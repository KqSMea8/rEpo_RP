<!--div class="had">
    Manage Email Folder    <span>&raquo;
        <? 	
        
        echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>

    </span>
</div-->
<? if (!empty($errMsg)) {?>
<div align="center"  class="red" ><?php echo $errMsg; ?></div>
<? } ?>

<script language="JavaScript1.2" type="text/javascript">
    
    $(document).ready(function() {
            //$('.fancybox').fancybox();
        $(".fancybox").fancybox({
            type: 'iframe',
            afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
                parent.location.reload(true);
                
            }
        });
    });
    
    
     
    function validateContact(frm) {



        if (ValidateForSimpleBlank(frm.Name, "Folder Name")) {
            
            
            
                if((document.getElementById('MsgTxt').innerHTML=='NotAvailable'))
                {
                  alert("Enter Another Folder Name");
                  frm.Name.focus();
                  return false;
                }        
                else {
                             
                ShowHideLoader('1', 'S');
                return true;
            }
       
        } else {
            return false;
        }
    }
    function validateContactEdit(frm) {

        if (ValidateForSimpleBlank(frm.Name, "Name")) {

            if((document.getElementById('MsgTxt').innerHTML=='NotAvailable'))
                {
                  alert("Enter Another Folder Name");
                  frm.Name.focus();
                  return false;
                }        
                else {
                             
                ShowHideLoader('1', 'S');
                return true;
            }
        } else {
            return false;
        }
    }
    
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action=""  method="post" onSubmit="<?php if (empty($_GET['edit'])) { ?> return validateContact(this);<?php } else { ?> return validateContactEdit(this); <?php } ?>" enctype="multipart/form-data">
       <tr>
            <td  align="center" class="redmsg">

                  <? if (!empty($_SESSION['mess_folder'])) {
    echo $_SESSION['mess_folder'];
    unset($_SESSION['mess_folder']);
} ?>
            </td>
        </tr>
   <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    

                    <tr>
                        <td align="right" width="40%"  class="blackbold">Folder Name  :<span class="red">*</span> </td>
                        <td  align="left" >
                            <input name="Name" type="text" class="inputbox" id="Name" value="<?php echo stripslashes($EmailFolderDetails[0]['FolderName']); ?>" onblur="<?php if (empty($_GET['edit'])) { ?> return CheckFolderName(this.value,'Add','');<?php } else { ?> return CheckFolderName(this.value,'Edit',<?=$_GET['edit']?>); <?php } ?>"  maxlength="80" onkeypress="return isCharKey(event);"/>
                            <span id="MsgFolder"></span>
                            <span id="MsgTxt" style="display:none;"></span>
                        </td>

                    </tr>

                </table>	

            </td>
        </tr>



        <tr>
            <td  align="center">

                <div id="SubmitDiv" style="display:none1">

                    <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Add ';?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />



<input type="hidden" name="Referer" id="Referer" value="<?=$_SERVER['HTTP_REFERER']?>" />

                    <input type="hidden" name="FolderID" id="FolderID" value="<?= $_GET['edit'] ?>" />

                    <input type="hidden" name="AdminID" id="AdminID"  value="<?php echo $_SESSION['AdminID']; ?>" />	
                    <input type="hidden" name="AdminType" id="AdminType"  value="<?php echo $_SESSION['AdminType']; ?>" />
                    <input type="hidden" name="EmailListId" id="EmailListId"  value="<?php echo $EmailListData[0]['id']; ?>" />
                    <input type="hidden" name="EmailListName" id="EmailListName"  value="<?php echo $EmailListData[0]['EmailId']; ?>" />

                </div>

            </td>
        </tr>
    </form>

</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
    function CheckFolderName(FolderName,EditType,FolderID){
        
       
       $("#MsgFolder").html(' ');
       if(FolderName!='')
       {
        var  sendParam='';
        sendParam='actionn=checkFolderName&foldername='+FolderName+'&folderid='+FolderID+'&AdminId='+<?=$_SESSION['AdminID']?>+'&CompId='+<?=$_SESSION[CmpID]?>+'&randomval='+Math.random();
                 
                $.ajax({
                        type: "POST",
                        async:false,
                        url: 'ajax.php',
                        data: sendParam,
                        success: function (responseText) { 
                           //alert(EditType+'=='+responseText); return false;
                           if((EditType=='Add') && (responseText > 0))
                           {
                              $("#MsgFolder").html("<b style='color:red'>Not Available</b>");
                              $("#MsgTxt").html("NotAvailable");
                              
                           } 
                           if((EditType=='Add') && (responseText==0))
                           {
                              $("#MsgFolder").html("<b style='color:green'>Available</b>"); 
                              $("#MsgTxt").html("Available");
                           }
                           if((EditType=='Edit') && (responseText >= 1))
                           {   
                             $("#MsgFolder").html("<b style='color:red'>Not Available</b>"); 
                             $("#MsgTxt").html("NotAvailable");
                           }
                           if((EditType=='Edit') && (responseText ==0))
                           {   
                             $("#MsgFolder").html("<b style='color:green'>Available</b>");
                             $("#MsgTxt").html("Available");
                           }
                           
        
                        }
          });
        
     }
    }
    StateListSend();
    
  
</SCRIPT>




