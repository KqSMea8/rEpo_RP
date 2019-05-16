<?php


if($_GET['pop']!=1){

	$arryNextEmail = $objImportEmail->NextEmail($_GET['ViewId'],$_GET['type'],$OwnerEmailId,$activeDataEmailID['EmailId'],$_GET['flagged']);


	$arryPrevEmail = $objImportEmail->PrevEmail($_GET['ViewId'],$_GET['type'],$OwnerEmailId,$activeDataEmailID['EmailId'],$_GET['flagged']);



?>

    <?php if($arryNextEmail[0]['autoId']> 0)
    {?> 
    <a class="next" title="Next Email" href="viewEmail.php?ViewId=<?=$arryNextEmail[0]['autoId']?>&type=<?=$_GET['type']?><?php if((trim($_GET['flagged'])=='Yes')) echo "&flagged=Yes";?>" onclick="LoaderSearch();"></a>
    <?php } 
     if($arryPrevEmail[0]['autoId']> 0)
    {?>
    <a class="prev" title="Previous Email" href="viewEmail.php?ViewId=<?=$arryPrevEmail[0]['autoId']?>&type=<?=$_GET['type']?><?php if(($_GET['flagged']=='Yes')) echo "&flagged=Yes";?>" onclick="LoaderSearch();"></a>
    <?php }?>
    <a href="<?=$RedirectURL?>" class="back">Back</a>
    <a class="add_quick" href="javascript:validateView('form1','<?=$Type?>')">Delete</a>
    <?php if ($_GET['type']=='Draft')
    { ?>
    <a class="edit" href="composeEmail.php?ViewId=<?=$_GET['ViewId']?>&type=<?=$_GET['type']?>">Edit</a>
    <?php
    }

}//end pop

     if ($_GET['type']!='Draft')
    { ?>
    <a class="add_quick" href="composeEmail.php?action=Forward&emailNo=<?=$_GET['ViewId']?>&type=<?=$_GET['type']?>&pop=<?=$_GET['pop']?>">Forward</a>
    <a class="add_quick" href="composeEmail.php?action=Reply&emailNo=<?=$_GET['ViewId']?>&type=<?=$_GET['type']?>&pop=<?=$_GET['pop']?>">Reply</a>
    <!--a class="add_quick" href="composeEmail.php?action=ReplyToAll&emailNo=<?=$_GET['ViewId']?>&type=<?=$_GET['type']?>">ReplyToAll</a-->
    <?php }?>
    <a class="add_quick fancybox fancybox.iframe" href="editImportEmailRule.php?emailNo=<?=$_GET['ViewId']?>&pop=Yes">Add Rule </a>
     
   

<div class="had">
View Message <?php if($arrySentItems[0]['FlagStatus']==1) {?><img src="images/email_flag2.png" alt="Flag" title="Flagged"><?php }?>
		
		</span>
                
                
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
    
  <? } ?>
  <div align="center"  class="message" ></div>
  

  




<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>

<link href="multiSelect/uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min999.js"></script>
<script src="../js/jquery.uploadfile.min.js"></script>


<script type="text/javascript">
	var ew_DHTMLEditors = [];
        
         function validateView(formmname,type) 
         {
            
            
        
           if((type=='sent') || (type=='inbox'))
              { 
                  
                  
                  if(confirm("Are you sure you want to move the selected email in trash?"))
                  {
								
                    ShowHideLoader(1,'P');
                    document.getElementById(formmname).submit(); 
		    return true;
		  }else{
			return false;
	          }
                  
                   
              }
              if((type=='trash') ||(type=='Draft')||(type=='spam'))
              { 
                  if(confirm("This will permanent delete email and their files. Continue ??"))
                  {
								
                    ShowHideLoader(1,'P');
                    document.getElementById(formmname).submit(); 
		    return true;
		  }else{
			return false;
	          }
              }
              
              
         }
       
</script>



<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data" >


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head"></td>
</tr>
<?php
if (is_array($arrySentItems) && $num > 0) {
    
    
    
?>
<tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> From : </td>
              <td   align="left" width="15%">
                  <?php 
                  
                   
                   if($arrySentItems[0][OrgMailType]=='Inbox')
                   {
                      echo $arrySentItems[0][From_Email];    
                   }else {
                     echo $arrySentItems[0][FromDD];
                   }
                  ?>
                    
              </td>       
</tr>
<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> To : </td>
              <td   align="left" width="15%">
             
                
                  <input name="recipients" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" id="recipients" value="<?php echo $arrySentItems[0][Recipient]?>" /> 
                                    
              </td>
              
             
              
       
</tr>
<?php if(!empty($arrySentItems[0][Cc]))
{ ?>
<tr id="CCC"  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Cc : </td>
              <td   align="left" width="15%">
                  
                  <input name="Cc" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" id="Cc" value="<?php echo $arrySentItems[0][Cc]?>" /> 
                  
              </td>
              
             
              
       
</tr>
<?php } ?>
<?php if(!empty($arrySentItems[0][Bcc]))
{ ?>
<tr id=""  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Bcc : </td>
              <td   align="left" width="15%">
              
                  
                  <input name="Bcc" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" id="Bcc" value="<?php echo $arrySentItems[0][Bcc]?> " />
              </td>
             
              
       
</tr>

<?php } ?>

<tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Subject : </td>
              <td   align="left" width="15%">
                  <input name="Subject" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" value="<?php echo stripcslashes($arrySentItems[0][Subject])?>" />
                    
              </td>       
</tr>

<tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Date : </td>
              <td   align="left" width="15%">
                  <?php 
                  
                   echo date("F j, Y, g:i a",strtotime($arrySentItems[0][composedDate]));
                  ?>
                    
              </td>       
</tr>

<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> &nbsp; </td>      
                            <td  align="left" >
<?php 
   echo  $dataa=trim(stripslashes(str_replace('<br type="_moz" />', '', $arrySentItems[0]['EmailContent'])));                              
  //echo $emailContents = preg_replace ("/(?<!a href=\")(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/i","<a href=\"\\0\" target=\"blank\">\\0</a>",$dataa); 
  
  

  
  
                                
?>
		               </td>
        </tr>
        
        <tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> &nbsp; </td>      
                            <td  align="left" >
                                

		               </td>
        </tr>

        <?php $arryAttachment = $objImportEmail->GetAttachmentFileName($_GET['ViewId']); 
        
             
            if(count($arryAttachment) > 0 )
            {
        ?>
 <tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">Attachment :<span class="red">*</span> </td>
              <td   align="left" width="15%">
                 
                 <?php
   
                                          
                                          foreach($arryAttachment as $key=>$values)
                                          {
                                              
                                             echo $values[FileName]; 
                                           ?>  
                                             
                                       <a href="importdwn.php?file=upload/emailattachment/<?php echo $_SESSION[AdminEmail].'/'.$values[FileName]?>" class="download">Download</a><br> <br>
	

</div>
                                        <?php  }
                                          
                                         ?>
              </td>
              
             
              
       
</tr>

<?php } ?>
<?php } else { ?>


<tr id=""  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">
   No Email Found </td>
              
             
              
       
</tr>


<?php } ?>

</table>	
  
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	
      


</div>

</td>
   </tr>
   <input type="hidden" name="Type" value="<?=$Type?>">
   <input type="hidden" name="ViewId" value="<?=$_GET['ViewId']?>">
   </form>
</table>







