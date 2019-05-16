<?php 

/**************************************************/
$ThisPageName = 'viewCreateRMA.php'; 
/**************************************************/
/**************************************************/
$EditPage = 1; $_GET['type']='RMA';
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/rma.sales.class.php");
require_once($Prefix . "classes/crm.class.php");
include_once("../includes/FieldArray.php");
$RedirectURL = "viewCreateRMA.php";
$objRmasale = new rmasale();
$objCommon = new common();




if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_Leadform'] = FORM_REMOVE;
    $objRmasale->RemoveRmaForm($_GET['del_id']);
    header("Location:viewCreateRMA.php?curP=" . $_GET["curP"]);
exit;
}
if(!empty($_POST['columnTo'])){
    CleanPost(); 
    $_POST['ActionUrl'] = $Config['Url'].'processRMA.php';
    
  

    
    foreach($_POST['columnTo'] as $formvalue){
        $LeadColumn .= $formvalue.',';
        $valArry = explode(":", $formvalue);
        $title = $valArry[0];
        $val = $valArry[1];
$datmand = 'y';
        $mand = '';  $FieldBox = '<input name="'.$val.'" data-mand="'.$datmand.'" type="text" class="inputbox" id="'.$val.'"  maxlength="50" />';
        if($val=='InvoiceID' || $val=='SKU'  || $val=='Qty' || $val=='type'){
            $mand = '<span class="red">*</span>';
						$mandval = '<span id="'.$val.'err" class="red" style="font-size:small; padding:3px;"></span>';
							$datmand = 'y';
        }else if($val=='Serial' || $val=='comment' ){
        $mandval = '<span id="'.$val.'err" class="red" style="font-size:small; padding:3px;"></span>';
       }
        if($val=='Serial' ){
            $FieldBox = '<textarea name="'.$val.'" data-mand="" id="'.$val.'" class="textarea"  ></textarea>';
						
        }
				if($val=='comment' ){
            $FieldBox = '<textarea name="'.$val.'" data-mand="" id="'.$val.'" class="textarea"  ></textarea>';
						
        }
        
        if($val=='type' ){
							$FieldBox = '<select name="'.$val.'" data-mand="y" class="inputbox" id="'.$val.'" >
							<option value="">--- Select ---</option>';

							$FieldBox .= '<option value="Credit" >Credit</option>';
							$FieldBox .= '<option value="Replacement" >Replacement</option>';

							$FieldBox .= '</select>';
        }
        
        
        
        $opt .= ' <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> '.$title.' '.$mand.' : </td>
                        <td   align="left" valign="top">
                            '.$FieldBox.' '.$mandval.'
                         </td>

                    </tr>'; 
       
    }

    
    $HtmlForm = '
        <link href="'.$Config['Url'].$Config['AdminCSS'].'" rel="stylesheet" type="text/css">
        <script language="javascript" src="'.$Config['Url'].'includes/global.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    
    $(function(){
       $("#rmaactionform").submit(function(){
      var err; 
        $("#rmaactionform  :input[data-mand^=\'y\']").each(function(){
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

        <form name="rmaactionform" id="rmaactionform" action="'.$_POST['ActionUrl'].'"  method="post">
        <h4>'.$_POST['FormTitle'].'</h4>
        <strong>'.$_POST['Subtitle'].'</strong><br> 
        '.$_POST['Description'].'<br>
           <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
           '.$opt.'
           <tr>
           <td align="left"></td>
           <td align="left">
           <input name="Cmp" type="hidden" id="Cmp" value="'.md5($_SESSION['CmpID']).'"  />
           <input name="RmaSubmit" type="submit" class="button" id="RmaSubmit" value=" Submit "  />
           </td>
            </tr>
           </table>
           
           
       </form>
    ';
    #echo $HtmlForm;exit;
    $LeadColumn = rtrim($LeadColumn, ",");
    $_POST['LeadColumn'] = $LeadColumn;
    $formid = $objRmasale->UpdateRmaWebForm($_POST, $HtmlForm);
    $_SESSION['msg_lead_form'] = 'generated';
    header('location:RmaForm.php?formid='.$formid );    
    exit;
    
}

if(!empty($_GET['formid'])){
	$arryLeadForm = $objRmasale->GetRmaWebForm($_GET['formid']);
}else{
	$arryLeadForm = $objConfigure->GetDefaultArrayValue('s_rma_form');
			
}
require_once("../includes/footer.php"); 
?>

