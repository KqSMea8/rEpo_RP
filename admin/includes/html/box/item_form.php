<script language="JavaScript1.2" type="text/javascript">
$(function(){
    
<?php if($_GET['edit']){?>
        $('#Sku').keypress(function(e){  ClearAvail('MsgSpan_Display');return isUniqueKey(e);});
        $('#Sku').blur(function(){

            CheckAvailField('MsgSpan_Display','Sku','<?=$_GET['edit']?>');

        });
        $('#Sku').after('<div id="MsgSpan_Display"></div>');
 <?php }?>       
 $("#form1").submit(function(){
        var err;
        $('div.red').html('');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
						$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text' || $(this).attr('type') == 'file')
            {
              if($(this).attr('type') == 'file')
                {
                    fileinput = $(this).closest('td').find('input[type="hidden"]');
                    if(fileinput.length == 0){
                        if($.trim($(this).val()) == "")
                        {    
                            $("#"+$fldname+"err").html(""+$input+" is mandatory field.");err = 1;
                        }   
                    }else{
                        
                        if(fileinput.val()=='')
                        {
                            $("#"+$fldname+"err").html(""+$input+" is mandatory field.");err = 1;
                        }    
                    }
                }else{
            
            
                    if( $.trim($(this).val()) == "")
                    {
                            $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                            err = 1;
                    }
                }
              
             }else{//by niraj for checkbox 11feb16
                if($('input[name^="'+$fldname+'"]').length == 1)
		{ 
			if($('#'+$fldname+':checked').length < 1)
			{
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}
		}else{
			if($('input[name^="'+$fldname+'"]:checked').length < 1)
			{  
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}

		}
             }  
            
          });
          
        if(err == 1){ return false; }else{ 
                    
            file = document.getElementById("Image");
            if(!ValidateOptionalUpload(file, "Image"))
            {
                $("#Image").focus();
                return false;
            } 
                       
            if(document.getElementById("ItemID").value>0){
                    ShowHideLoader('1','S');
                    return true;
            }else{
              var Url = "isRecordExists.php?Sku="+escape($("#Sku").val())+"&editID="+$("#ItemID").val()+"&Type=Inventory";
              SendExistRequest(Url,"Sku", "SKU Number "+$("#Sku").val());
              return false;
            }
        
            //return true;
            }
       });
    
        $farr = ['sell_price','qty_on_hand'];
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


});
</script>

<form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >


<? if (!empty($_SESSION['mess_item'])) { ?>
<tr>
<td  align="center"  class="message"  >
<? if (!empty($_SESSION['mess_item'])) {
echo $_SESSION['mess_item'];
unset($_SESSION['mess_item']);
} ?>
</td>
</tr>
<? } ?>
<tr>
<td align="center" valign="top" >
<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="borderall">


<?php 
 //By Chetan 26Aug//

$head=1;
$arrayvalues = (!empty($arryItem)) ? $arryItem[0] : array();
for($h=0;$h<sizeof($arryHead);$h++){?>
                
	<tr>
	    <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
	</tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php"); 

 }
//End?>


</table>
</td>
</tr>

<tr>
<td align="center">

<?
if ($_GET['edit'] > 0) {
	$ButtonTitle = 'Update';
} else {
	$ButtonTitle = 'Submit';
}


?>

<input name="Submit" type="submit" class="button" id="<?=(isset($ButtonID)) ? $ButtonID : '';?>" value="<?=$ButtonTitle?>" <?=(isset($DisabledButton)) ? $DisabledButton : ''; ?> />   
<input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />


</td>
</tr>


</table>
</form>


