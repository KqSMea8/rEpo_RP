<?php 

/**************************************************/
$FancyBox = 1; $HideNavigation = 1; $ThisPageName = 'meeting.php'; $EditPage = 1; $_GET['type']='lead';
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix."classes/field.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/meeting.class.php");

//include_once("includes/FieldArray.php");
$RedirectURL = "viewLead.php?module=lead";
$objLead = new lead();
$objCommon = new common();
$objField = new field();
$objCommon = new common();				
$objMeeting = new Meeting();

$arryGroup = $objCommon->getAllRoleGroup();// added by sanjiv

/*****************/
if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_Leadform'] = FORM_REMOVE;
    $objLead->RemoveLeadForm($_GET['del_id']);
    header("Location:meetingViewCreateLead.php?type=meetingLead&curP=" . $_GET["curP"]);
exit;
}
/*****************/
$html ='';
if(!empty($_POST['webinar_id'])){ 
    CleanPost(); 
    
    $_POST['RoleGroup'] = (!empty($_POST['columnTo1'])) ? base64_encode(implode(',',$_POST['columnTo1'])) : ''; //added by sanjiv
    
    $_POST['ExtraInfo'] = 'Meeting';
    $_POST['ActionUrl'] = $Config['Url'].'processLead.php';
	
    $html ='<tr>
        <td  align="right" class="blackbold" width="25%" valign="top"> First Name <span class="red">*</span> : </td>
        <td  align="left" valign="top" ><input data-mand="y" name="FirstName" type="text" class="inputbox" id="FirstName"   /><span id="FirstNameerr" class="red err" style="font-size:small; padding:3px;"></span></td>
	</tr>
	<tr>
		<td  align="right" class="blackbold" width="25%" valign="top"> Last Name <span class="red">*</span> : </td>
        <td  align="left" valign="top" ><input data-mand="y" name="LastName" type="text" class="inputbox" id="LastName"   /><span id="LastNameerr" class="red err" style="font-size:small; padding:3px;"></span></td>
	</tr> 
	<tr>
       <td  align="right" class="blackbold" width="25%" valign="top"> Primary Email <span class="red">*</span> : </td>
       <td  align="left" valign="top" ><input data-mand="y" name="primary_email" type="text" class="inputbox" id="primary_email"   /><span id="primary_emailerr" class="red err" style="font-size:small; padding:3px;"></span></td>
	</tr>
	<tr>
       <td  align="right" class="blackbold" width="25%" valign="top"> Phone : </td>
       <td  align="left" valign="top" ><input data-mand="n" name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" /></td>
	</tr>';
 
    //updated by chetan 11Mar//
    $HtmlForm = '
        <link href="'.$Config['Url'].$Config['AdminCSS'].'" rel="stylesheet" type="text/css">
        <script language="javascript" src="'.$Config['Url'].'includes/global.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    
    $(function(){
       $("#leadactionform").submit(function(){
        var err;
	$("span.err").html(""); 
        $("#leadactionform  :input[data-mand^=\'y\']").each(function(){
	    $input = ($(this).closest("td").prev().clone().children().remove().end().text()).replace(":","");
		$fldname = $(this).attr("name");
            if($(this).attr("type") == "" || typeof($(this).attr("type")) == "undefined" || $(this).attr("type") == "text")
            {
              	if( $.trim($(this).val()) == "")
              	{
               		$("#"+$(this).attr(\'name\')+"err").html(""+$input+" is mandatory field.");
               		err = 1;       
              	}
	    }else{
                
                 if($("input[name^=\'"+$fldname+"\']").length == 1)
		{ alert("IN");
			if($("#"+$fldname+":checked").length < 1)
			{
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}
		}else{
			if($("input[name^=\'"+$fldname+"\']:checked").length < 1)
			{  
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}

		}
            }	
              if($(this).attr(\'name\') == "PrimaryEmail" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$(this).attr(\'name\')+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
              
          });
        if(err == 1) return false; else return true;
       });
      
   }); 
</script>


        <form name="leadactionform" id="leadactionform" action="'.$_POST['ActionUrl'].'" method="post">
        <h4>'.$_POST['FormTitle'].'</h4>
        <strong>'.$_POST['Subtitle'].'</strong><br> 
        '.$_POST['Description'].'<br>
           <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
           '.$html.'
           <tr>
           <td align="left"></td>
           <td align="left">
           <input name="Cmp" type="hidden" id="Cmp" value="'.md5($_SESSION['CmpID']).'"  />
           	<input name="webinar_id" type="hidden" id="webinar_id" value="'.$_POST['webinar_id'].'"  />
           <input name="LeadSubmit" type="submit" class="button" id="LeadSubmit" value=" Submit "  />
           </td>
            </tr>
           </table>
           
           
       </form>
    '; //End//
    //echo $HtmlForm;exit;
    $LeadColumn = rtrim($LeadColumn, ",");
    $_POST['LeadColumn'] = $LeadColumn;
   $lastID = $objLead->UpdateLeadWebForm($_POST, $HtmlForm);
    $_SESSION['msg_lead_form'] = 'generated';
    header('location:vLeadForm.php?formid='.$lastID.'&opt=code');    
    exit;
    
}
$arryWebinars = $objMeeting->findWebinarByUserID('', true);

//$arryLeadForm = $objLead->GetLeadWebForm('1');

require_once("../includes/footer.php"); 
?>
