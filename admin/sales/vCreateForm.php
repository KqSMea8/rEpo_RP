<?php 

/**************************************************/
$ThisPageName = 'viewCreateRMA.php';  $EditPage = 1;  $_GET['type']='lead';
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/rma.sales.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix."classes/field.class.php");


//include_once("includes/FieldArray.php");
$RedirectURL = "viewCreateRMA.php";
$objRmaSale = new rmasale();
$objCommon = new common();
$objField = new field();
$objCommon = new common();

//By Chetan//

$ArrCusFlds = $objField->getAllCustomFieldByModule('Lead');
$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus', '');
$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');

if(empty($arryCompany[0]['AdditionalCurrency']))
$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryLead[0]['Currency']) && !in_array($arryLead[0]['Currency'],$arrySelCurrency))
{
	$arrySelCurrency[]=$arryLead[0]['Currency'];
}

$html ='';
if(!empty($_GET['view'])){

$arryLeadForm = $objRmaSale->GetRmaWebForm($_GET['view']);


if(!empty($arryLeadForm[0]['columnTo'])){
    
    $arryLeadForm[0]['ActionUrl'] = $Config['Url'].'processLead.php';
    //$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus', '');
    // $arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
    // $arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');
    //print_r($arryLeadForm[0]);//die;
    $ColArr = array_map(function($a) {
                                          $Arry = explode('#',$a);
					  return $Arry[0];
					}, $arryLeadForm[0]['columnTo']);
    foreach($arryLeadForm[0]['columnTo'] as $formvalue)
    {
$LeadColumn .= $formvalue.',';
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
                           
        
        if($type =='text'){
            $FieldBox = '<input data-mand="'.$inputmand.'" name="'.$fieldname.'" type="text" class="inputbox" id="'.$fieldname.'"  maxlength="'.$valArry['maximumlength'].'" />';

        }
        if($type =='textarea' ){
            $FieldBox = '<textarea data-mand="'.$inputmand.'" name="'.$fieldname.'" maxlength="'.$valArry['maximumlength'].'"   id="'.$fieldname.'" class="textarea"  ></textarea>';
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
        
        
        $html.=$FieldBox.'<span id="'.$fieldname.'err" class="red" style="font-size:small; padding:3px;"></span></td></tr>'; 
       
       
    }

    //echo $html;
    //die;
    $HtmlForm = '
        <link href="'.$Config['Url'].$Config['AdminCSS'].'" rel="stylesheet" type="text/css">
        <script language="javascript" src="'.$Config['Url'].'includes/global.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    
    $(function(){
       $("#leadactionform").submit(function(){
      var err; 
        $("#leadactionform  :input[data-mand^=\'y\']").each(function(){
              if( $.trim($(this).val()) == "")
              {
               $("#"+$(this).attr(\'name\')+"err").html(""+$(this).attr(\'name\')+" is mandatory field.");
               err = 1;       
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


        <form name="leadactionform" id="leadactionform" action="'.$arryLeadForm[0]['ActionUrl'].'" method="post">
        <h4>'.$arryLeadForm[0]['FormTitle'].'</h4>
        <strong>'.$arryLeadForm[0]['Subtitle'].'</strong><br> 
        '.$arryLeadForm[0]['Description'].'<br>
           <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
           '.$html.'
           <tr>
           <td align="left"></td>
           <td align="left">
           <input name="Cmp" type="hidden" id="Cmp" value="'.md5($_SESSION['CmpID']).'"  />
           <input name="LeadSubmit" type="submit" class="button" id="LeadSubmit" value=" Submit "  />
           </td>
            </tr>
           </table>
           
           
       </form>
    '; 
	#echo $LeadColumn;exit;
	//$LeadColumn = rtrim($LeadColumn, ",");
	//print_r($arryLeadForm[0]['columnTo']);exit;
	//$arryLeadForm[0]['LeadColumn'] = $LeadColumn;
	//$lastID = $objLead->UpdateLeadWebForm($arryLeadForm[0], $HtmlForm);
	//$_SESSION['msg_lead_form'] = 'generated';
    //header('location:leadForm.php?formid='.$lastID);    
    //exit;
    
}
}



require_once("../includes/footer.php"); 
?>

