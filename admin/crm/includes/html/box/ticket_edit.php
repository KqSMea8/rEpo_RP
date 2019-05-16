<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">
function validate_Information(frm){


	if(ValidateForSimpleBlank(frm.title, "Ticket Title")
		&& ValidateRadioButtons(frm.assign,"Assign To")){


var AssignUser =  document.getElementById('assign1').checked;
var AssignGroup =  document.getElementById('assign2').checked;
//alert(AssignUser);
if(AssignUser == true){


if(document.getElementById('AssignToUser').value == ''){

alert("Please Enter Assign User Name.");
document.getElementById('AssignToUser').focus();
return false;	
}
}else if(AssignGroup == true){
if(document.getElementById('AssignToGroup').value == ''){

alert("Please Select Assign Group.");
document.getElementById('AssignToGroup').focus();
return false;	
}


}

	


		if(ValidateForSelect(frm.Status,"Ticket Status")
		&& ValidateForSelect(frm.priority,"Ticket Priority")
		&& ValidateForSelect(frm.category,"Ticket Category")
		//&& ValidateForTextareaMand(frm.description,"Description")
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
		
//var Url = "isRecordExists.php?TicketTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("TicketID").value+"&Type=Ticket";
					//SendExistRequest(Url,"title", "Ticket Title");
					ShowHideLoader('1','S');	
					return true;	
}	
return false;	
					
			}else{
					return false;	
			}	

		
}

		


function validate_Description(frm){
	if(ValidateForTextareaMand(frm.description,"Description")
		
		
		){
			ShowHideLoader('1','S');
			return true;	
		}
	return false;
}	

function validate_Resolution(frm){
	ShowHideLoader('1','S');
	return true;	
}

</script>

<div class="right_box">
    <form name="form1" id="form1" action="<?=$ActionUrl?>"  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  
  <?php if (!empty($_SESSION['mess_ticket'])) {?>
<tr>
<td  align="center"  class="message"  >
	<?php if(!empty($_SESSION['mess_ticket'])) {echo $_SESSION['mess_ticket']; unset($_SESSION['mess_ticket']); }?>	
</td>
</tr>
<?php } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  
<?php if($_GET["tab"]=="Information"){ ?>

<?php
//By Chetan//
if(isset($_GET['parent_type']) && $_GET['parent_type'] != '')
 {
     $Narry = array_map(function($arr){
        
            if($arr['head_value'] == 'Related To')
            {
                unset($arr);
            }else{
               return $arr;
            }
    }, $arryHead);
   $arryHead = array_values(array_filter($Narry));
}
$head=1; 
$arrayvalues = $arryTicket[0];
for($h=0;$h<sizeof($arryHead);$h++){     
?>
                    <tr>
                        <td colspan="4" align="left" class="head_desc"><?=$arryHead[$h]['head_value']?></td>
                    </tr>

<?php $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
$arrField = array_map(function($arr){return $arr['fieldname'];},$arryField);

include("includes/html/box/CustomFieldsNew.php");

if($h == 0){?>
                    
                    
<?php if(empty($arryTicket[0]['CustID'])){?>
    <script>$( document ).ready(function() {

 if($('#CustID').val()!='')
            {
		
              $('#sendnotification').prev().addBack().show();
            }else{

              $('#sendnotification').prev().addBack().hide();
              $("#sendnotificationerr").text('');
              $("#notificationserr").text('');
		$('#sendn').hide();
              $('tr #notifi').hide();
              $('#sendnotification').attr('checked',false);
              $('#notifications option:first').attr('selected',true);
            }    


   //$('#sendnotification').closest('td').addBack().hide().prev().hide();
});</script>
<?php }
?>
<tr <?php if(empty($arryTicket[0]['sendnotification']) || !in_array('CustID',$arrField)){ ?> style="display: none;" <?php }?> id="notifi">
	 <td  valign="top" align="right" >Notifications :<span class="red">*</span></td>
                <td valign="top"  align="left" >
                    
                    <select name="notifications" class="inputbox"  id="notifications" >
                        <option value="">--Select--</option>
                        <option value="All">All</option>
                        <?php foreach($arryTicketStatus as $arr){?>
                            
                                <option value="<?=$arr['attribute_value']?>" <?php if($arryTicket[0]['notifications'] == $arr['attribute_value']){ echo  "selected=selected";}?>><?=$arr['attribute_value']?></option> 

                            
                       <?php }?>
                        
                    </select>
                    <div class="red" id="notificationserr" style="margin-left:5px;"></div> 
                </td>
                </td>
                        
                        
</tr>

<?php } } }
 
 //End//
?>       
	
</table>	

	</td>
   </tr>

   

   <tr>
    <td  align="center" >

	<div id="SubmitDiv" style="display:none1">
	
	<?php if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

</div>
<input type="hidden" name="TicketID" id="TicketID" value="<?=$_GET['edit']?>" />



</td>
   </tr>
</table>
           </form>

</div>
<SCRIPT LANGUAGE=JAVASCRIPT>



    selModule();

</SCRIPT>
