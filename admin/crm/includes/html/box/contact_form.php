<script language="JavaScript1.2" type="text/javascript">
    
 //By chetan 3July//   
$(function(){   
 var err;     

if(document.getElementById("state_id") != null){
        document.getElementById("main_state_id").value = document.getElementById("state_id").value;
}
if(document.getElementById("city_id") != null){
        document.getElementById("main_city_id").value = document.getElementById("city_id").value;
}

function checkemail(email,$fld)
{		  /*   BY rajan
			    atpos = email.indexOf("@");
			    dotpos = email.lastIndexOf(".");
			    if (atpos < 1 || ( dotpos - atpos < 2 ))
		   */

// Added By Rajan 08 feb 2016
    	 var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   	 if(regex.test(email) == false)
	    {
		$("#"+$fld+"err").html("Please enter correct email.");
		err = 1; 
	    }
 }
      
      
      
 $("#form1").submit(function(){
        err ='';
        $('div.red').html('');
	var stateDisplay = $("#state_td").css('display');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            $fldname = $(this).attr('name');
             $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
                  
                if(($fldname == "OtherState" && ($('#state_id').val()!='' && typeof($('#state_id').val())!="undefined")) || 
                    ($fldname == "OtherCity" && ($('#city_id').val()!='' &&  typeof($('#city_id').val())!="undefined"))  )
                    {}else{
                        
                        if($fldname == "OtherState" || $fldname == "OtherCity")
                        {
                            $input = ($(this).closest('td').prev('td').clone().children().remove().text()).replace(':*','');
                        }else if($fldname == "CloseTime"){
                            $input = 'Close Time';
                        }
                
			if($fldname == "OtherState" && stateDisplay=='none'){
				//alert('hi');
			}else{
		                $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
		                err = 1;
			}
                }    
              }
              
            }else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            } 
            
              if(($fldname == "Email" && $(this).val()!= ""))
               {    
                    checkemail($(this).val(),$fldname);
               }
               
             
          });
          
          if($("#PersonalEmail").val()!= "")
          {
            checkemail($("#PersonalEmail").val(),"PersonalEmail");
          }
         

 // BY Rajan 08 feb 2016
      	
      	if( $("#form1  :input[data-mand^=\'n\']") && $("#Email").val()!="" )
      		{

      		checkemail($("#Email").val(),"Email");
	}
      // End by Rajan 08 feb 2016
        if(err == 1) return false; else return true;
        
    
    });   
 
 
    $farr = ['ZipCode','Landline','Mobile'];
    $('input').keypress(function(e){
          
         if($.inArray($(this).attr('name'),$farr ) != -1)
         {
             return isDecimalKey(e);
         }
    });
 

	//By Chetan 16July//
      if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').not('[name="Reference"],[name="DoNotCall"],[name="EmailOptOut"],[name="NotifyOwner"]').click(function(){
            
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
      
      //End//




});

//End//
</script>

<form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


<?php
//Updated by chetan 11DEc//
$head = 1;
$arrayvalues = (!empty($arryContact)) ? $arryContact[0] : '';

for($h=0;$h<sizeof($arryHead);$h++){
    if($arryHead[$h]['head_value'] != 'Assign Role')
    {
?>
                
        <tr>
            <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
        </tr>

<?php 
$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 

    $Narry = array_map(function($arr){
            if($arr['fieldname'] == 'FullName' || $arr['fieldname'] == 'contact')
            {
                unset($arr);
            }else{
               return $arr; 
            }
        },$arryField);

    $arryField = array_values(array_filter($Narry));         

include("includes/html/box/CustomFieldsNew.php"); 

} }
//head close?>	
  

</table>


	
	  
	
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="AddID" id="AddID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo (!empty($arryContact[0]['state_id'])) ? $arryContact[0]['state_id'] : ''; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo (!empty($arryContact[0]['city_id'])) ? $arryContact[0]['city_id'] : ''; ?>" />

</div>

</td>
   </tr>
</table>
   </form>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
