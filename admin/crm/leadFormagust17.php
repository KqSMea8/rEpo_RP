<?php 

/**************************************************/
$ThisPageName = 'viewCreateLead.php'; $EditPage = 1; $_GET['type']='lead';
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix."classes/field.class.php");
require_once($Prefix . "classes/crm.class.php");

//include_once("includes/FieldArray.php");
$RedirectURL = "viewLead.php?module=lead";
$objLead = new lead();
$objCommon = new common();
$objField = new field();
$objCommon = new common();

//By Chetan//
$ArrCusFlds = $objField->getAllCustomFieldByModule('Lead');
$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus', '');
$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');

$arryGroup = $objCommon->getAllRoleGroup();// added by sanjiv

if(empty($arryCompany[0]['AdditionalCurrency']))
$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryLead[0]['Currency']) && !in_array($arryLead[0]['Currency'],$arrySelCurrency))
{
	$arrySelCurrency[]=$arryLead[0]['Currency'];
}
/*****************/
if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_Leadform'] = FORM_REMOVE;
    $objLead->RemoveLeadForm($_GET['del_id']);
    header("Location:viewCreateLead.php?curP=" . $_GET["curP"]);
exit;
}
/*****************/
$html ='';
if(!empty($_POST['columnTo'])){
    CleanPost(); 
    $_POST['ActionUrl'] = $Config['Url'].'processLead.php';
    //$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus', '');
    // $arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
    // $arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');
    //print_r($_POST);//die;

	$_POST['RoleGroup'] = (!empty($_POST['columnTo1'])) ? base64_encode(implode(',',$_POST['columnTo1'])) : ''; //added by sanjiv

    $ColArr = array_map(function($a) {
                                          $Arry = explode('#',$a);
					  return $Arry[0];
					}, $_POST['columnTo']);
    foreach($_POST['columnTo'] as $formvalue)
    {
        $Arry = explode('#',$formvalue); 
        
        $valArry = $objField->GetCustomfieldByFieldId($Arry[1],'*');
        
        
        $StrField .= $Arry[0].',';                                
        $type = $valArry['type'];
        $fieldtitle = $valArry['fieldlabel'];
        $fieldname = $valArry['fieldname'];
        $mand = ($valArry['mandatory']==1) ?'<span class="red">*</span>' : '' ;
        $inputmand = ($valArry['mandatory']==1) ? 'y' : 'n' ;
       
        $html .= ' <tr>
                    <td  align="right" class="blackbold" width="25%" valign="top"> '.$fieldtitle.' '.$mand.' : </td>
                    <td  align="left" valign="top" >';
                           
         if($type =='captcha'){
            $FieldBox = '<img class="captchaImg" data-src="'.$Config['WebUrl'].'erp/admin/captchaFile.php" src="'.$Config['WebUrl'].'erp/admin/captchaFile.php" /><a onclick="refreshCaptcha()">Refresh</a><br/><input data-mand="'.$inputmand.'" name="'.$fieldname.'" type="text" class="inputbox" id="'.$fieldname.'"   />';

        }
        if($type =='text'){
            $FieldBox = '<input data-mand="'.$inputmand.'" name="'.$fieldname.'" type="text" class="inputbox" id="'.$fieldname.'"   />';

        }
        if($type =='textarea' ){
            $FieldBox = '<textarea data-mand="'.$inputmand.'" name="'.$fieldname.'"   id="'.$fieldname.'" class="textarea"  ></textarea>';
        }
        
        if($type =='select' ){
                $FieldBox = '<select data-mand="'.$inputmand.'"   name="'.$fieldname.'" class="inputbox" >';
                $FieldBox .= '<option value="" >--Select--</option>';
                if($valArry['dropvalue'])
                {   
                    $optArr = explode(',',$valArry['dropvalue']);
                    
                    for ($i = 0; $i < sizeof($optArr); $i++) {
                         $FieldBox .= '<option value="'.$optArr[$i].'" >'.$optArr[$i].'</option>';
                    }
                }elseif($fieldtitle == 'Industry' )
                {
                     for ($i = 0; $i < sizeof($arryIndustry); $i++) 
                     { 
                        $FieldBox .= '<option value="'.$arryIndustry[$i]['attribute_value'].'">'.$arryIndustry[$i]['attribute_value'].'</option>'; 
                     }              
                }elseif($fieldtitle == 'Lead Source' )
                {
                     for ($i = 0; $i < sizeof($arryLeadSource); $i++) 
                     { 
                        $FieldBox .= '<option value="'.$arryLeadSource[$i]['attribute_value'].'">'.$arryLeadSource[$i]['attribute_value'].'</option>'; 
                     }              
                }elseif($fieldtitle == 'Lead Status' )
                {
                     for ($i = 0; $i < sizeof($arryLeadStatus); $i++) 
                     { 
                        $FieldBox .= '<option value="'.$arryLeadStatus[$i]['attribute_value'].'">'.$arryLeadStatus[$i]['attribute_value'].'</option>'; 
                     }              
                }elseif($fieldtitle == 'Currency' )
                {
                     for ($i = 0; $i < sizeof($arrySelCurrency); $i++) 
                     { 
                        $FieldBox .= '<option value="'.$arrySelCurrency[$i].'">'.$arrySelCurrency[$i].'</option>'; 
                     }              
                }
                
                    
                $FieldBox .= '</select>';
        }
        if($type =='checkbox'){
           
            $FieldBox =  '<input data-mand="'.$inputmand.'" type="checkbox" class="inputbox" name="'.$fieldname.'" id="'.$fieldname.'" value="'.$valArry['defaultvalue'].'"  />';

        }
        if($type=='radio'){
            $valRadio=explode(' ',$valArry['RadioValue']);
            $FieldBox = '';
            for($i=0;$i<sizeof($valRadio);$i++){
                $FieldBox .=  '<input data-mand="'.$inputmand.'" type="radio" class="inputbox" style="width:24px !important;" name="'.$fieldname.'" id="'.$fieldname.'" value="'.$valArry['defaultvalue'].'" />'.$valRadio[$i].'';
            }
        }
        if($type == 'date'){?>
                 
        <?php
            $FieldBox = 
                    
                    '<script language="JavaScript1.2" type="text/javascript">

                        $(function() {
                                   $("#'.$fieldname.'").datepicker({
                                       showOn: "both",
                                       yearRange: "'.(date('Y') - 20).':'.(date('Y')).'",
                                       dateFormat: "yy-mm-dd",
                                       maxDate: "+0D",
                                       changeMonth: true,
                                       changeYear: true
                                   });
                               });
                    </script>
                    <input data-mand="'.$inputmand.'" name="'.$fieldname.'" maxlength="'.$valArry['maximumlength'].'" id="'.$fieldname.'" readonly="" class="datebox" value="" type="text" >';         
        }
        
        
        $html.=$FieldBox.'<span id="'.$fieldname.'err" class="red err" style="font-size:small; padding:3px;"></span></td></tr>'; 
       
       
    }

    //echo $html;
     //updated by chetan 11Mar//
    $HtmlForm = '
        <link href="'.$Config['Url'].$Config['AdminCSS'].'" rel="stylesheet" type="text/css">
        <script language="javascript" src="'.$Config['Url'].'includes/global.js"></script>

<script language="JavaScript1.2" type="text/javascript">
     function refreshCaptcha(){
        $(".captchaImg").attr("src","https://codeproject.global.ssl.fastly.net/images/loading48.gif");
        $(".captchaImg").attr("src",$(".captchaImg").attr("data-src")+"?"+ Math.random());
    }
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
		{ 
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
			<input name="RoleGroup" type="hidden" id="RoleGroup" value="'.$_POST['RoleGroup'].'"  />
           <input name="LeadSubmit" type="submit" class="button" id="LeadSubmit" value=" Submit "  />
           </td>
            </tr>
           </table>
           
           
       </form>
    '; 
    #echo $HtmlForm;exit;
    $LeadColumn = rtrim($LeadColumn, ",");
    $_POST['LeadColumn'] = $LeadColumn;
    $_POST['FormType'] = 'Lead';
   $lastID = $objLead->UpdateLeadWebForm($_POST, $HtmlForm);
    $_SESSION['msg_lead_form'] = 'generated';
    header('location:vCreateForm.php?view='.$lastID);    
    exit;
    
}

$arryLeadForm = $objLead->GetLeadWebForm('1');

require_once("../includes/footer.php"); 
?>

