
<?php unset($_SESSION['attcfile']); ?>
<?php
if($_GET[type]=='sent')
        {
         
        
	 $RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
        }else if($_GET[type]=='trash')
        {
           
           $RedirectURL = "trashEmail.php?curP=".$_GET['curP']."&module=".$_GET["module"];   
        }
        else if($_GET[type]=='inbox')
        {
          
           $RedirectURL = "viewImportedEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];   
        }else if($_GET['type']=='spam')
        {
           
           $RedirectURL = "spamEmail.php?curP=".$_GET['curP']."&module=".$_GET["module"];
             
        }
        else if($_GET['type']=='Draft')
        {
           
           $RedirectURL = "draftList.php?curP=".$_GET['curP']."&module=".$_GET["module"];
             
        }
        else {
           
           $RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
       }
?>

<div >
<?  if($_GET['pop'] != 1){ ?>
<a href="<?=$RedirectURL?>" class="back">Back</a>
<a href="editImportContactList.php?pop=1" target="_blank" class="fancybox fancybox.iframe add">Add Contact</a>
<? } ?>

<span id="loading-ff" style="float:right;margin-right: 15px;display:none;"><img src="../images/loader.gif"></span>
<span class="loading-image" style="margin-right: 15px;display: none;text-align: center;width: 755px; float: right;"><img src="../images/loader.gif"> Saving</span>
</div>


<div class="had">
Compose Email
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  

  


<script language="JavaScript1.2" type="text/javascript">
function validateCompose(frm){
          
           if(frm.FromDD.value=='')
           {
              alert('Please Select From Email Id'); 
              frm.FromDD.focus();
              return false;   
               
           } 
           else if((frm.recipients.value=='') && (frm.Cc.value=='') && (frm.Bcc.value==''))
               
          {
              
              alert('Please specify at least one recipient.'); 
              frm.recipients.focus();
              return false;
          }
          
         else if((frm.Subject.value==''))
              
        {
           
            var Result1=confirm('Send this email without a subject');
            if (Result1 == false) {
                    
                    frm.Subject.focus();
                    return false;
                }
                
                
                
                    else if((frm.mailcontent.value=='&nbsp;'))
                 {

                     var Result=confirm('Send this email without a subject or text in the body?');


                     if (Result == false) {

                             frm.Subject.focus();
                             return false;
                         }
                         else {

                             ShowHideLoader('1','S');
                         }

                 }     
                
                       
        }
        
              
        
		
}


function Cc()
{
    
     document.getElementById('C_cc').style.display='block';
     document.getElementById('C_cc1').style.display='block';
     document.getElementById('C_cc2').style.display='block';
     document.getElementById('To_cc').style.display='none';
}
function Bcc()
{
    
   document.getElementById('B_cc').style.display='block';   
   document.getElementById('B_cc1').style.display='block';   
   document.getElementById('B_cc2').style.display='block'; 
   document.getElementById('To_cc').style.display='none';
}
function Cc1()
{
    
     
     if(document.getElementById('C_cc').style.display=='block')
     {
           
        document.getElementById('B_cc2').style.display='none';   
        document.getElementById('C_cc2').style.display='none'; 
        document.getElementById('To_cc').style.display='none'; 
        
        document.getElementById('B_cc').style.display='block';   
        document.getElementById('B_cc1').style.display='block';   
        
      }
     
     
}

function Bcc1()
{
    
   if(document.getElementById('B_cc').style.display=='block') 
   {
        
        document.getElementById('C_cc2').style.display='none';   
        document.getElementById('B_cc2').style.display='none'; 
        document.getElementById('To_cc').style.display='none'; 
        
        document.getElementById('C_cc').style.display='block';   
        document.getElementById('C_cc1').style.display='block'; 
   }
   
}
</script>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>

<link href="multiSelect/uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/jquery.uploadfile.min.js"></script>


<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<? if (!empty($_SESSION['mess_emailSent'])) {?><div class="message" align="center">
   <? echo $_SESSION['mess_emailSent'];
    unset($_SESSION['mess_emailSent']);

	?></div>
<? }else{?>

<form name="form1" action=""  method="post" onSubmit="return validateCompose(this);" enctype="multipart/form-data" id="composeform1">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall1">
<tr>
	 <td colspan="3" align="left" class="head" style="width:98%;">New Message</td>
</tr>


<?php 
                     
                      $select_emailid="select * from importemaillist where status=1 and DefalultEmail=1 and AdminID=".$_SESSION['AdminID'];
                      $data_emailid=mysql_query($select_emailid);
                      $num_count=mysql_num_rows($data_emailid);
                      
                      
                      
                      if($num_count >0)
                      {
                      ?> 

<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> From : <span class="red">*</span></td>
              <td   align="left" width="15%">
                  
                  <select name="FromDD" id="FromDD" class="inputbox"> 
                      <option value="">Select From Email</option>
                      <?php
                      $data_emailid1=mysql_query("select * from importemaillist where status=1 and AdminID=".$_SESSION['AdminID']);
                      while($Email_data=mysql_fetch_array($data_emailid1))
                        { 
                           ?>
                      <option value="<?php echo $Email_data[EmailId]?>" <?php if($Email_data[DefalultEmail]==1) echo "selected"; ?>><?php echo $Email_data[EmailId]?></option>
                        <?php }?>
                      
                  </select>
              </td>
              <td>&nbsp;</td>
              
             
              
       
</tr>

<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> To : <span class="red">*</span> </td>
              <td   align="left" width="15%"><input name="recipients" type="text" class="inputbox" style="width:402px;" id="recipients" value="" />
		<input type="hidden" name="action" value="composeMail" />
             <input type="hidden" name="draftId" id="draftId" value="<?=$_GET['ViewId']?>" />
             
              <script type="text/javascript">
                                         $(document).ready(function() {
                                             //var url= 'emailContacts.php';
                                              
                                            $("#recipients,#Cc,#Bcc").tokenInput("autoselectContactList.php?AdminID=<?php echo $_SESSION['AdminID']?>", {
                                                theme: "facebook",
                                                preventDuplicates: true,
                                                hintText: "Search Contact Email",
                                                propertyToSearch: "email",
                                                tokenValue: "email",
                                                crossDomain: true,
                                                resultsFormatter: function(item) {
                                                      
                                                         
                                                		console.log(item);
                                                		if(typeof item.name == "undefined") 
                                                			return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email + "</div><div class='email'></div></div></li>"
                                                		else
                                                    		return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name +  " &nbsp;&nbsp; (" + item.email + ")</div><div class='email'></div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email +    "</div><div class='email'></div></div></li>"
                                                }
                                            });
                                        });
                                    </script>
                                    
              </td>
              <td style="float:right; margin-right: 48%;" id="To_cc"><a href="javascript:Cc();">CC</a> &nbsp;<a href="javascript:Bcc();">BCC</a></td>
              
             
              
       
</tr>


<tr >
    <td  id="C_cc" align="left" width="6%"   class="blackbold" style="padding-left:10px; display: none;"> Cc : </td>
              <td  id="C_cc1" style="display: none;"  align="left" width="15%"><input name="Cc" type="text" class="inputbox" style="width:402px;" id="Cc" value="" />
              
                 
              </td>
              <td id="C_cc2" style="display: none;float:right; margin-right: 48%;"><a href="javascript:Cc1();">BCC</a></td>
              

       
</tr>
<tr >
    <td id="B_cc"  align="left" width="6%"   class="blackbold" style="padding-left:10px;display: none;"> Bcc : </td>
    <td id="B_cc1"   align="left" width="41%" style="display:none;"><input name="Bcc" type="text" class="inputbox" style="width:402px;" id="Bcc" value="" />
              
               
              </td>
              <td id="B_cc2" style="display: none;"><a href="javascript:Bcc1();">CC</a></td>
             
              
       
</tr>

<tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Subject : </td>
              <td   align="left" width="15%"><input name="Subject" type="text" class="inputbox" style="width:402px;" id="Subject" value="<? echo stripslashes($arryComposeItems[0]['Subject']); ?>" />
              
              </td>
              <td >&nbsp;</td>
              
             
              
       
</tr>

<tr>
    <?php 
    if(!empty($_GET['emailNo']) && $_GET['type']=='sent'){
        
       
       $RefIdd=$_GET['emailNo'];
	$select_attach1="select * from importemailattachments where EmailRefId='".$RefIdd."'";
	$attachdatas1=mysql_query($select_attach1);
	 while($row1=mysql_fetch_array($attachdatas1)) {
             
         }
         
    }?>
    
                            <td  align="left" colspan="3" style=" width: 100%;">
                                
                                <Textarea name="mailcontent" id="mailcontent" class="inputbox"  ><?php if((($_GET['action']=='Forward') || ($_GET['action']=='Reply') || ($_GET['action']=='ReplyToAll')) && ($_GET['type']!='Draft')) { echo $arryReplyForwardMsg; } ?><?php echo stripslashes($arryComposeItems[0]['EmailContent']);?></Textarea>

				<script type="text/javascript">

             var editorName = 'mailcontent';
             
             

             var editor = new ew_DHTMLEditor(editorName);

             editor.create = function() {
                 var sBasePath = '../FCKeditor/';
                 var oFCKeditor = new FCKeditor(editorName, '100%', 500, 'EmailCompose');
                 oFCKeditor.BasePath = sBasePath;
                 oFCKeditor.ReplaceTextarea();
                 this.active = true;
             }
             ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

             ew_CreateEditor();

                  
                                </script>			          </td>
        </tr>

 <tr  >
    <td  align="" width="8%"   class="blackbold" style="padding-left:10px;">Attachment : </td>
              <td   align="left" width="15%" colspan="2">


<div id="mulitplefileuploader">Upload</div>
<?php 
if(!empty($_GET['ViewId']) || !empty($_GET['emailNo'])){
        
        if(isset($_GET['ViewId']))
        {
           $RefId=$_GET['ViewId'];   
        }
            else {
             $RefId=$_GET['emailNo'];
            }
        
	$select_attach="select * from importemailattachments where EmailRefId='".$RefId."'";
	$attachdatas=mysql_query($select_attach);
	 while($row=mysql_fetch_array($attachdatas)) {
             
                  $_SESSION['currtime']=time();
                 ?>
		<div class="ajax-file-upload-statusbar">
			<div class="ajax-file-upload-filename"><?=$row['FileName']?></div>
			<span class="ajax-file-upload-red" style="" onclick="attachDelete('<?=$_SESSION['currtime']."_".$row['FileName']?>',this,'<?=$row['FileName']?>');">Delete</span>
                        <input type="hidden" class="classAttcfile" name="attcfile[]" value="<?=$row['FileName']?>">
		</div>
	<?php }
}
?>

<div id="status"></div>
<script>
    
  var nC=jQuery.noConflict();  
nC(document).ready(function()
{
    
   
   
    var settings = {
    url: "uploadAttachment.php", 
    dragDrop:true,
    fileName: "myfile",
    showFileCounter : false,
    //allowedTypes:"jpg,png,gif,doc,pdf,zip",	
  
	 onSuccess:function(files,data,xhr)
    {
        //alert(data); //return false;
    },
    showDelete:true,
    showDone: false,
    deleteCallback: function(data,pd)
	{
     
     
    for(var i=0;i<1;i++)
    {  
        nC.post("deleteAttachment.php",{op:"delete",name:data,drafftId:$("#draftId").val(),Frrom:'firstattemp'},
        function(resp, textStatus, jqXHR)
        {
            //alert(resp); 
            nC("#status").append("");      
        });
     }      
     pd.statusbar.hide(); //You choice to hide/not.

}
}
var uploadObj = nC("#mulitplefileuploader").uploadFile(settings);




 


});
</script>
              
              </td>
<td >&nbsp;</td>
              
             
              
       
</tr>
                      

</table>	
  
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	<input type="hidden" name="OwnerEmailId" value="<?=$OwnerEmailId?>"  />
	<span class="loading-image" style="margin-right: 15px;display:none;" ><img src="../images/loader.gif">Saving</span>
	  <input type="button" class="button" id="SubmitButton" value="Save as Draft" onclick="saveDraft();" />
      <input name="Submit" type="submit" class="button" id="SubmitButton" value="Send"  />


</div>

</td>
   </tr>
   
   <?php } else { ?>

    <tr  >
    <td   colspan="3" align=""    class="blackbold" style="padding-left:10px;"> Default Email Id is not configured. </td>
              
              
             
              
       
</tr>

                      <?php } ?>
   
</table>
 </form>
<? } ?>
<script>
    
    

function saveDraft(){
    
        //alert('in savetodraft'); return false;
	var inst = FCKeditorAPI.GetInstance("mailcontent");
	var sValue = inst.GetHTML();
	$("#mailcontent").val(sValue);

	$('.loading-image').show();
	$('#loading-ff').show();
        var SendParam = $("#composeform1").serializeArray();
       //alert(SendParam); return false;
       $.ajax({
			type: "POST",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
                            
                                
				if(responseText>0){
                                        
                                        
                                        //this code is for updating draftnum count//
                                        
                                        if($("#draftId").val() =='')
                                        {
                                            var drafttext='';
                                            $("div.left-main-nav ul li.submenu a").each(function(){
                                            
                                             var texttval=$.trim($(this).text());
                                             if(texttval=='Draft')
                                             {
                                                drafttext='Yes';
                                                $(this).html('Draft <strong>(<span id="draftnum">1</span>)');
                                             }
                                            
                                            });
                                            
                                            
                                               if(drafttext!='Yes') {
                                                  
                                                   $("#draftnum").html(parseInt($("#draftnum").html())+1);  
                                               }
                                             
                                        }
                                        //end code is for updating draftnum count//
                                        
					$("#draftId").val(responseText);
					$('.loading-image').text('Saved');
				}else if(responseText=='null') {
					$('.loading-image').hide();
				}else{
					$('.loading-image').html('Error! Try again.');
				}
				$('#loading-ff').hide();
			}
      });
}

function attachDelete(attachname,curr,orgFilename){
    
        //alert("ddd"+$("#draftId").val());return false;
	$.ajax({
		type: "POST",
		async:false,
		url: 'deleteAttachment.php',
		data: {op:'delete',name: attachname,type: 'Draft',drafftId :$("#draftId").val(),OrgFile :orgFilename,Action:'<?=$_GET[action]?>'},
		success: function (responseText) {
                    
                        
			if(responseText!='' && responseText!='null'){
				$(curr).parent(".ajax-file-upload-statusbar").remove(); 
			}
		}
  });
}

function attachdeletefromtable(attachname,curr){
    
      alert("in attache delete fiel"+attachname); 
        
	$.ajax({
		type: "POST",
		async:false,
		url: 'deleteAttachment.php',
		data: {op:'delete',name: attachname,type: 'Draft',drafftId: $("#draftId").val()},
		success: function (responseText) {
                         alert(responseText);
			if(responseText!='' && responseText!='null'){
				$(curr).parent(".ajax-file-upload-statusbar").remove();
			}
		}
  });
}



function FCKeditor_OnComplete( editorInstance )
{
	editorInstance.Events.AttachEvent( 'OnBlur', saveDraft ) ;
}

$(document).on('blur','#token-input-recipients,#token-input-Cc,#token-input-Bcc,#Subject', function(){
        
	 saveDraft();
});


window.onload=function(){
    
     <?php 
     if(($_GET['action']=='Reply') && ($arryComposeItems[0][OrgMailType]=='Inbox'))
     {
          
	?>
	 $("#recipients").tokenInput("add",{id: 0, email: "<?=$arryComposeItems[0]['From_Email']?>" });
		  
     <?php      
     }
     
     if(($_GET['action']=='ReplyToAll') && ($arryComposeItems[0][OrgMailType]=='Inbox'))
     {
          
	?>
	 $("#recipients").tokenInput("add",{id: 0, email: "<?=$arryComposeItems[0]['From_Email']?>" });
	
                    
               <?php if(!empty($arryComposeItems[0]['Cc'])){ 
		 $cc = explode(",", $arryComposeItems[0]['Cc']);
		 $i=50;foreach ($cc as $reciept){ $i++;?>
		 $("#Cc").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		 <?php } } ?>
     <?php      
     }
     
     if(($_GET['action']!='Forward') && ($arryComposeItems[0][OrgMailType]!='Inbox')) {  ?>
	<?php if(!empty($arryComposeItems[0]['Recipient'])){
	$reciepts = explode(",", $arryComposeItems[0]['Recipient']);
	$i=50;foreach ($reciepts as $reciept){ $i++;?>
	 $("#recipients").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		<?php } } ?>

		<?php if(!empty($arryComposeItems[0]['Bcc'])){ 
		$bcc = explode(",", $arryComposeItems[0]['Bcc']);
		$i=50;foreach ($bcc as $reciept){ $i++;?>
		 $("#Bcc").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		<?php } } ?>
			
		<?php if(!empty($arryComposeItems[0]['Cc'])){ 
		$cc = explode(",", $arryComposeItems[0]['Cc']);
		 $i=50;foreach ($cc as $reciept){ $i++;?>
		 $("#Cc").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		 <?php } } ?>
                     
     <?php } ?>              
};

<?php 
if(($_GET['type']!='Draft')) { ?>
           
saveattachmentswhileforward(<?=$_REQUEST[emailNo]?>);

<?php } ?>

function  saveattachmentswhileforward(emailNo){
        
                
                
                var cntt=0;
                var url='';
                var sendParam='';
                var actionn='';
                var totalfile='';
                $('input.classAttcfile').each(function() {
                    
                       cntt++;
                       
                      url+='attcname'+cntt+'='+this.value+'&';
                           
                    });
                    
                    
                   sendParam='actionn=savefile&emailNo='+emailNo+'&'+url+'totalfile='+cntt;
                   
                $.ajax({
                        type: "POST",
                        async:false,
                        url: 'uploadAttachment.php',
                        data: sendParam,
                        success: function (responseText) {
                            
                           //alert(responseText);
        
                        }
          });
        
        
    }

</script>



