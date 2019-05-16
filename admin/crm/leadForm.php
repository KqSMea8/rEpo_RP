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
$editData = array();
if(!empty($_GET['view'])){
  $editData = $objLead->GetLeadWebForm($_GET['view']);
  $leadSelectedColumn = $editData[0]['LeadColumn'];
  //print_r($editData); die;
}

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
    $mandClass = ($valArry['mandatory']==1) ?'validate' : '' ;
    $inputmand = ($valArry['mandatory']==1) ? 'y' : 'n' ;

    $html .= '<div class="form-group '.$mandClass.' ">
    <label class="col-md-4 control-label">'.$fieldtitle.' '.$mand.'</label>
    <div class="col-md-8 inputGroupContainer">
    <div class="input-group">';

    //if($type =='captcha'){
      //$FieldBox = '<div class="captcha-code"><div class="g-recaptcha" data-sitekey="6LeVtC4UAAAAAIti77ayAXJwg8ZIlc2fMzn2o7nq"></div></div>';

    //}
    if($type =='text'){
      $FieldBox = '<input data-mand="'.$inputmand.'" name="'.$fieldname.'" type="text" class="inputbox form-control input-textform" id="'.$fieldname.'"   />';

    }
    if($type =='email'){
      $FieldBox = '<input data-mand="'.$inputmand.'" name="'.$fieldname.'" type="email" class="inputbox form-control input-textform" id="'.$fieldname.'"   />';

    }
    if($type =='textarea' ){
      $FieldBox = '<textarea data-mand="'.$inputmand.'" name="'.$fieldname.'"   id="'.$fieldname.'" class="textarea form-control input-textform"  ></textarea>';
    }

    if($type =='select' ){
      $FieldBox = '<select data-mand="'.$inputmand.'"   name="'.$fieldname.'" class="inputbox form-control input-textform" >';
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

  $FieldBox =  '<input data-mand="'.$inputmand.'" type="checkbox" class="inputbox form-control input-textform" name="'.$fieldname.'" id="'.$fieldname.'" value="'.$valArry['defaultvalue'].'"  />';

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
$FieldBox = '<script language="JavaScript1.2" type="text/javascript">
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
<input data-mand="'.$inputmand.'" name="'.$fieldname.'" maxlength="'.$valArry['maximumlength'].'" id="'.$fieldname.'" readonly="" class="datebox form-control input-textform" value="" type="text" >';         
}


$html.=$FieldBox.'<span id="'.$fieldname.'err" class="red err" style="font-size:small; padding:3px;"></span>  </div></div></div>';        
}

    //echo $html;
     //updated by chetan 11Mar//
$HtmlForm = '<html><head>

<link rel="stylesheet prefetch" href="'.$Config['Url'].'css/admin.css">
<script src="'.$Config['Url'].'fancybox/lib/jquery-1.10.1.min.js"></script>

<link rel="stylesheet prefetch" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" >
<script src="'.$Config['Url'].'fancybox/timepicker/jquery.timepicker.js" ></script>
<script src="'.$Config['Url'].'fancybox/jquery_calender/jquery-ui.js" ></script>

<script language="javascript" src="'.$Config['Url'].'includes/global.js"></script>


<style>




            #contact-form {
width:480px;
margin: auto;
background: #fff;
padding:0 10px;
}
    
 #contact-form label.col-md-4.control-label { font-family: "Open Sans",sans-serif;
    font-style: inherit;
    font-weight: inherit;
    vertical-align: baseline;
    float: left;
    text-align: left;
    width: 150px;
margin:13px 0;
}

.red.err {
    float: none;
    font-size: small;
    margin-left: 153px;
    padding-bottom: 3px;
    padding-left: 3px;
    padding-right: 3px;
    padding-top: 3px;
}
.refs{


font-family: arial;
    font-size: 11px;
    margin-left: 10px;
cursor: pointer;

}

.captcha-code{width:100px; height:30px; display:block; margin-bottom:30px; float:left;}



#contact-form h2.registration-heading {
   float: left;
    margin-top: 20px;
  
}

.button{background:#f27122; padding:5px 10px; float:left; margin-left:150px; text-transform:uppercase; margin-top:35px;}  



fieldset{border:1px solid #ddd;}



            #contact-form h2.registration-heading {color: #106db2; padding: 10px;}
            #contact-form legend{margin-bottom:0px;}

input.form-control.input-textform { 
    float: right;
    width: 300px;
margin:10px 0;
height:35px;
}



/*button.submit-button {
  background: #f27122;
  border: none;
  padding: 5px;
  font-weight: bold;
  color: #fff;
}*/






            #success_message{ display: none;}

select.form-control.selectpicker.input-textform {
  width: 300px;
}
</style>
<script src="https://www.google.com/recaptcha/api.js"></script>

<script language="JavaScript1.2" type="text/javascript">


function validate(){
  var asd="";
  var error=0;
  $(".validate").each(function(){
    asd = $(this).find(".input-textform").val();
    console.log(asd);
    if(typeof asd == "undefined" ||  asd==""){
      var txt = $(this).find("label").text().replace("*","");
      $(this).find(".err").html(txt+" is required.");
      error=1;
    }else{
      $(this).find(".err").html("");
    }
  });
  if(error==1){
    return false;
  }
}

</script>




</head>
<body>
<div class="container">
<div id="contact-form">
<form class="form-horizontal" action="'.$Config['Url']."processLead.php".'" method="post"  id="contact_form" onsubmit="return validate();" >
<fieldset>
<legend><center><h2 class="registration-heading"><b>'.$_POST["FormTitle"].'</b></h2></center><br/><p>'.$_POST["Description"].'</p></legend><br>
<form name="leadactionform" id="leadactionform" action="'.$_POST['ActionUrl'].'" method="post">


'.$html.'
<div class="captcha-code"><div class="g-recaptcha" data-sitekey="6LeVtC4UAAAAAIti77ayAXJwg8ZIlc2fMzn2o7nq"></div></div>
<input name="Cmp" type="hidden" id="Cmp" value="'.md5($_SESSION['CmpID']).'"  />
<input name="RoleGroup" type="hidden" id="RoleGroup" value="'.$_POST['RoleGroup'].'"  />
<br><br><br>
<input name="LeadSubmit" type="submit" class="button" id="LeadSubmit" value=" Submit "  />

</form>
</div></div></body></html>'; 
    //echo $HtmlForm; die("ANKIT");



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

