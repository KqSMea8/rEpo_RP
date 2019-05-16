
<script language="JavaScript1.2" type="text/javascript">


function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}



function ShowPermission(){
	if(document.getElementById("Role").value=='Admin'){
		document.getElementById('PermissionTitle').style.display = 'block'; 
		document.getElementById('PermissionValue').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValue').style.display = 'none'; 
	}
}
//Buy Chetan18Aug//
function SelectType(type){

	 if($("#defaultvalue").attr('type')!='text'){ 
           $("#defaultvalue").replaceWith('<input name="defaultvalue" type="text" class="inputbox" id="defaultvalue" value=""  maxlength="50" />');
       	}

	if(document.getElementById("type").value=='select'){
                $("#dropvalue").val('');
                $("#defaultvalue").val('');
                $("#defaultvalue").closest('tr').hide();
		document.getElementById('divtype1').style.display = 'block'; 
		document.getElementById('divtype2').style.display = 'block'; 
                document.getElementById('radiotype').style.display = 'none'; 
                document.getElementById('radiotype1').style.display = 'none'; 

               
	}else if(document.getElementById("type").value=='date' || document.getElementById("type").value=='textarea'){

                if(document.getElementById("type").value=='textarea'){
                    $("#defaultvalue").closest('tr').show();
                    $("#defaultvalue").parent().html('<textarea id="defaultvalue" class="inputbox" name="defaultvalue"></textarea>');
                }
								document.getElementById('divtype1').style.display = 'none'; 
								document.getElementById('divtype2').style.display = 'none'; 
								document.getElementById('radiotype').style.display = 'none';
								document.getElementById('radiotype1').style.display = 'none'; 
								
								
        }else if(document.getElementById("type").value=='radio' ){
                $("#RadioValue").val('');                           //15July//
                $("#defaultvalue").closest('tr').hide();
                document.getElementById('radiotype').style.display = 'block'; 
                document.getElementById('radiotype1').style.display = 'block';
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none';
								
               
								
        }else if(document.getElementById("type").value=='multicheckbox' ){ 
                 $("#dropvalue").val('');
                $("#defaultvalue").val('');
                $("#defaultvalue").closest('tr').hide();
								document.getElementById('divtype1').style.display = 'block'; 
								document.getElementById('divtype2').style.display = 'block'; 
                document.getElementById('radiotype').style.display = 'none'; 
                document.getElementById('radiotype1').style.display = 'none'; 
        }else{
                $("#defaultvalue").val('');
                $("#defaultvalue").closest('tr').show();
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none'; 
                document.getElementById('radiotype').style.display = 'none'; 
                document.getElementById('radiotype1').style.display = 'none'; 
								document.getElementById('multichecktype').style.display = 'none';  //By Niraj jan28,2016//
                document.getElementById('multichecktype1').style.display = 'none';  //By Niraj jan28,2016//
               
	}
}

//15july//
function editSelectType(type)
{
    if(type=='select'){
                $("#defaultvalue").closest('tr').hide();
								document.getElementById('divtype1').style.display = 'block'; 
								document.getElementById('divtype2').style.display = 'block'; 
                document.getElementById('radiotype').style.display = 'none'; 
                document.getElementById('radiotype1').style.display = 'none'; 
								
               
	}else if(type=='date' || type=='textarea'){
                 if(type=='textarea'){ 
                if($('#type').hasClass('disabled')){var dis = 'disabled';}else{dis ='';}
                $("#defaultvalue").parent().html('<textarea name="defaultvalue" '+dis+' id="defaultvalue" class="inputbox '+dis+'">'+$("#defaultvalue").val()+'</textarea>');

                }else{
                    $("#defaultvalue").closest('tr').hide();
                }
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none'; 
								document.getElementById('radiotype').style.display = 'none';
								document.getElementById('radiotype1').style.display = 'none'; 
								
               
        }else if(type=='radio' ){
                $("#defaultvalue").closest('tr').hide();
                document.getElementById('radiotype').style.display = 'block'; 
                document.getElementById('radiotype1').style.display = 'block';
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none';
								
                
        }else if(document.getElementById("type").value=='multicheckbox' ){
                $("#defaultvalue").closest('tr').hide();
								document.getElementById('divtype1').style.display = 'block'; 
								document.getElementById('divtype2').style.display = 'block'; 
                document.getElementById('radiotype').style.display = 'none'; 
                document.getElementById('radiotype1').style.display = 'none'; 
        }else{
                $("#defaultvalue").closest('tr').show();
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none'; 
                document.getElementById('radiotype').style.display = 'none'; 
                document.getElementById('radiotype1').style.display = 'none'; 
								
                
	}
}
//End//
</script>

<script language="JavaScript1.2" type="text/javascript">

//By Chetan 14July//
var CSfldArr = ['State','Other State','City','Other City','AssignToGroup','AssignToUser','CustomerName','Rating','TodayDate','Related Type','MainTaxRate'];
function checkField()
{
    fld = $('#fieldname').val();   
    if($.inArray(fld,CSfldArr)!='-1')
    {    
        alert('Field Name already exists in database. Please enter another.');
        return false;
    }else{
        //By chetan 15July//updated 10aug2017//
        if($('#type').val()=='checkbox' && $('#type').is(':disabled') == false)
        {
            if($('#defaultvalue').val()==''){ alert('Default Value Field is mandatory.');return false;}
        }else if($('#type').val()=='radio' && $('#type').is(':disabled') == false){
            
            if($('#RadioValue').val()==''){ alert('Value Field is mandatory.');return false;}
        }else if($('#type').val()=='select' && $('#type').is(':disabled') == false){
            
            if($('#dropvalue').val()==''){ alert('Value Field is mandatory.');return false;}
        }
        return true;
    }  
       
}
  //End//  
    function validate_Field(frm){
//ValidateForSimpleBlank(frm.fieldname,"Field Name")&&
	if( ValidateForSimpleBlank(frm.fieldlabel, "Field Label")
		&& ValidateForSelect(frm.type, " Field Type")
		&& checkField()){					//By Chetan 14July//
			
					
					
			var mod = "<?php echo $_GET['mod'];?>";	
                  var Url = "isRecordExists.php?fieldname="+escape(document.getElementById("fieldlabel").value)+"&editID="+document.getElementById("fieldid").value+"&Type=Field&mod="+mod+"";//By Chetan3July//

					SendExistRequest(Url,"fieldlabel", "Field Label");
		  	
		      return false;
				   	
					
			}else{
					return false;	
			}	
return false;
		
}
</script>


<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage <?=$ModuleName?>   &raquo; <span>
	<? if($_GET["tab"]=="Summary"){?>
<? 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
<?} else{?>

	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
	<? }?>
		
		
		</span>
</div>

	<? if (!empty($errMsg)) {?>
  
    <div  align="center"  class="red" ><?php echo $errMsg;?></div>
    
  <? } ?>
  

<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?php //echo $ActionUrl;?>"  method="post" onSubmit="return validate_Field(this);" enctype="multipart/form-data">
 <? if (!empty($_SESSION['mess_head'])) {?>
    <tr>
    <td  align="center"  class="message"  >
        <? if(!empty($_SESSION['mess_field'])) {echo $_SESSION['mess_field']; unset($_SESSION['mess_field']); }?>	
    </td>
    </tr>
 <? } ?>
  
   <tr>
    <td  align="center" valign="top" >


        <table class="borderall" width="100%" cellspacing="0" cellpadding="5" border="0">
        
        <tr>
             <td colspan="2" align="left" class="head">Field Detail</td>
        </tr>
        
        <!--tr>
                <td  align="right"   class="blackbold" width="45%"> Field Name :<span class="red">*</span> </td>
                <td   align="left" >
        <input name="fieldname" type="text" readonly="" class="inputbox <?=$class?>" <?=$disabled?> onkeypress="return isVarcharKey(event);" id="fieldname" value="<?php if(isset($arryFormField[0]['fieldname'])) echo stripslashes($arryFormField[0]['fieldname']); ?>"  maxlength="50" />            </td>
              </tr-->
              
              <tr>
                <td  align="right"   class="blackbold" width="45%"> Field Label :<span class="red">*</span></td>
                <td   align="left" >
        <input name="fieldlabel" type="text"  class="inputbox " onkeypress="return isCharKey(event);" id="fieldlabel" value="<?php echo (isset($arryFormField[0]['fieldlabel'])) ? stripslashes($arryFormField[0]['fieldlabel']) : '';?>"  maxlength="50" />            </td>
              </tr>
        
               <tr>
                <td  align="right"   class="blackbold"> Field Type : <span class="red">*</span></td>
                <td   align="left" >
            <select name="type" class="inputbox <?=$class?>" <?=$disabled?> <?=$readOnly?> id="type" onchange="return SelectType(this.value);" >
                    <option value="">--- Select Type ---</option>
                    <option value="text" <?  if(!empty($arryFormField) && ($arryFormField[0]['type']=='text' || $arryFormField[0]['type']=='hidden' || $arryFormField[0]['type']=='Image') ){echo "selected";}?>>Text</option>
                    <option value="checkbox" <?  if(!empty($arryFormField) && $arryFormField[0]['type']=='checkbox'){echo "selected";}?>>Checkbox</option>
                    <option value="radio" <?  if(!empty($arryFormField) && $arryFormField[0]['type']=='radio'){echo "selected";}?>>Radio</option>
											<option value="multicheckbox" <?  if(!empty($arryFormField) && $arryFormField[0]['type']=='multicheckbox'){echo "selected";}?>>Multi Checkbox</option>
                    <option value="date" <?  if(!empty($arryFormField) && $arryFormField[0]['type']=='date'){echo "selected";}?>>Date</option>
                    <option value="select" <?  if(!empty($arryFormField) && $arryFormField[0]['type']=='select'){echo "selected";}?>>Dropdown List</option>
                     <option value="textarea" <?  if(!empty($arryFormField) && $arryFormField[0]['type']=='textarea'){echo "selected";}?>>Text Area</option>
                 </select>       
                  </td>
              </tr>
<? if(!empty($arryFormField) && $arryFormField[0]['RadioValue']!='' && $arryFormField[0]['type']=='radio'){

$displayradi0 = "style='display:block;'";

}else{$displayradi0 = ''; }?>

<tr>
	<td  align="right"   class="blackbold"  width="45%"><div id="radiotype" <?=$displayradi0?>> Value :</div> </td>
	<td  align="left" ><div <?=$displayradi0?> id="radiotype1">
	 <!--By chetan 15July-->   
	<?php if(!empty($arryFormField)){ 
			$Rval = preg_replace('/\s+/', ' ', $arryFormField[0]['RadioValue']);
			}else{
			$Rval = '';
			}	?>
	<textarea name="RadioValue" <?=$disabled?> <?=$readOnly?> class="inputbox <?=$class?>" style="width:100px;hieght:300px;" id="RadioValue"><?=$Rval?></textarea> (Add Spaces for multiple radio field value.)
<!--End--></div> </td>
</tr>
		<? if(!empty($arryFormField) && (($arryFormField[0]['dropvalue']!='' && $arryFormField[0]['type']=='select') || ($arryFormField[0]['dropvalue']!='' && $arryFormField[0]['type']=='multicheckbox'))){

		$display = "style='display:block;'";

}else{ $display = '';}?>

               <tr>
                <td  align="right"   class="blackbold"  width="45%"><div id="divtype1" <?=$display?>> Value :</div> </td>
                <td    align="left" ><div <?=$display?> id="divtype2">
<!--By chetan 15July-->     
<?php 
$Dval ='';
if(!empty($arryFormField[0]['dropvalue'])){
	$Dval = preg_replace('/\s+/', ' ', $arryFormField[0]['dropvalue']);
}


?>
                    <textarea name="dropvalue" <?=$disabled?> <?=$readOnly?>  class="inputbox <?=$class?>" id="dropvalue"><?php echo stripslashes($Dval);?></textarea> (Add Comma for multiple field value.)   </div> </td>
<!--End -->              </tr>
              <tr>
                <td  align="right"   class="blackbold" width="45%"> Default Value : </td>
                <td   align="left" >
        <input name="defaultvalue" type="text" <?=$disabled?> <?=$readOnly?> class="inputbox <?=$class?>" id="defaultvalue" value="<?php echo (isset($arryFormField[0]['defaultvalue'])) ? stripslashes($arryFormField[0]['defaultvalue']) :''; ?>"  maxlength="50" />  </td>
              </tr>
              
              
              <tr>
                <td  align="right"   class="blackbold"> Mandatory :</td>
                <td   align="left" >
          <input type="checkbox" name="mandatory"  value="1" <? if(!empty($arryFormField) && $arryFormField[0]['mandatory']==1){ echo "checked";}?> />    </td>
              </tr>
              
              <tr>
                <td  align="right"   class="blackbold" width="45%"> Sequence : </td>
               <!--By Chetan 13July---> <td   align="left" >
        <input name="sequence" type="text" onkeypress="return isNumberKey(event);"   class="inputbox" id="sequence" value="<?php echo (isset($arryFormField[0]['defaultvalue'])) ? stripslashes($arryFormField[0]['sequence']) : ''; ?>"  maxlength="30" size="20" />  
        
       </td>
              </tr>
              
                <tr >
                      <td align="right" valign="middle"  class="blackbold">Status :</td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":"checked"?> /></td>
            <td width="48" align="left" valign="middle">Show</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Hide</td>
          </tr>
        </table>                      </td>
                    </tr>
        
        </table>	
	</td>
  </tr>
   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv">
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
   </div>
 <input name="fieldname" type="hidden" readonly=""  id="fieldname" value="<?php echo (isset($arryFormField[0]['defaultvalue'])) ? stripslashes($arryFormField[0]['fieldname']) : '';?>" />     
<input type="hidden" name="fieldid" id="fieldid" value="<?=$_GET['edit']?>" />
<input type="hidden" name="headid" id="headid"  value="<?php echo $_GET['head']; ?>" />	
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />
</td>
   </tr>
   </form>
</table>
</div>
  <!--15July-->
<?php if($_GET['edit']){?>
<script>
editSelectType('<?=$arryFormField[0]['type']?>');
</script>
<?php }else{?> 
<script>
SelectType('text');
</script>
<?php }?>
