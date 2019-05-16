<script language="JavaScript1.2" type="text/javascript">
//By Chetan18Aug//
$(function(){
    
$("#form1").submit(function(){
        document.getElementById("CurrentDivision").value = window.parent.document.getElementById("CurrentDivision").value;
        var err;
        $('div.red').html('');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
                if(($fldname == "OtherState" && ($('#state_id').val()!='' && typeof($('#state_id').val())!="undefined")) || 
                    ($fldname == "OtherCity" && ($('#city_id').val()!='' &&  typeof($('#city_id').val())!="undefined")) ){}else{
                        
                        if($fldname == "OtherState" || $fldname == "OtherCity")
                        {
                            $input = ($(this).closest('td').prev('td').clone().children().remove().text()).replace(':*','');
                        }
                
                        $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                        err = 1;
                }    
              }
              
             }else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            }  
            
            
            if($fldname == "Email" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
               
          });
          
        if(err == 1){ return false; }else{ return true;}
       });
    
        $farr = ['ZipCode','Landline','Mobile','Fax'];
          $('input').keypress(function(e){

             if($.inArray($(this).attr('name'),$farr ) != -1)
             {
                 return isNumberKey(e);        
             }
          });
    
        if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').click(function(){
            
          fldname = $(this).attr('name');
          if(!$(this).is(':checked'))
          { 
                $('<input>').attr({
                        type: 'hidden',
                        id: fldname,
                        name: fldname,
                        value:''
                }).appendTo('#form1');
          }else{
                $('input[name="'+fldname+'"][type="hidden"]').remove();
          }
            
        });
          
      } 
      
})      

//End//
</script>

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:550px;" >

<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">

<? if($_GET['tab']=="shipping") echo $PageAction." Address";else echo $PageAction." Contact";?>   </div>


<form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" class="borderall">

 	  
<?php 
 //By chetan 30sep//
/******************** Code ****************************/

/********* By Karishma for MultiStore 22 Dec 2015******/
if($_REQUEST['tab']=='shipping' || $_REQUEST['tab']=='contacts')  $arrayvalues = $arryCustAddress[0];
else $arrayvalues = $arryCustomer[0];
/*****End By Karishma for MultiStore 22 Dec 2015**********/
$arrayvalues = $arryCustAddress[0];
for($h=0;$h<sizeof($arryHead);$h++){
if($arryHead[$h]['head_value']== 'Basic Information'){    
    
    $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
    $Narry = array_map(function($arr){
            if($arr['fieldname'] == 'FirstName' || $arr['fieldname'] == 'LastName' || $arr['fieldname'] == 'Email')
            {
                return $arr;
            }else{
                unset($arr);
            }
        },$arryField);

    $arryField = array_values(array_filter($Narry)); 
    include("crm/includes/html/box/CustomFieldsNew.php");
    
}
if($arryHead[$h]['head_value']== 'Address Details')
{  
/********* By Karishma for MultiStore 22 Dec 2015******/	
   $arrayvalues = $arryCustAddress[0];
/*****End By Karishma for MultiStore 22 Dec 2015**********/
   $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
   include("crm/includes/html/box/CustomFieldsNew.php");
}

if($arryHead[$h]['head_value']== 'Assign Role')
{  
   $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
   include("crm/includes/html/box/CustomFieldsNew.php");
}

}
//End//?> 
</table>		
	
	</td>
	
  </tr>

	<tr>
    <td align="center">
<input type="Submit" class="button" name="SubmitContact" id="SubmitContact" value="<?=$ButtonAction?>">
<input type="hidden" name="CustID" id="CustID" value="<?=$_GET['CustID']?>" />
<input type="hidden" name="AddID" id="AddID" value="<?=$_GET['AddID']?>" />
<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="">
<!----By Karishma for MultiStore 22 Dec 2015--->
<input type="hidden" name="tab" id="tab" value="<?=$_GET['tab']?>" />
<!----End By Karishma for MultiStore 22 Dec 2015--->
<input type="hidden" value="<?php echo $arryCustAddress[0]['state_id']; ?>" id="main_state_id" name="main_state_id">		
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustAddress[0]['city_id']; ?>" />


</td>	
  </tr>


</table>
</form>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>




<? } ?>
