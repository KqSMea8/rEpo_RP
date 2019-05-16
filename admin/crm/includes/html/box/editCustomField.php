
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
//Buy Chetan//
function SelectType(type){
	if(document.getElementById("type").value=='select'){
                $("#dropvalue").val('');
                $("#defaultvalue").val('');
                $("#defaultvalue").closest('tr').show();
		document.getElementById('divtype1').style.display = 'block'; 
		document.getElementById('divtype2').style.display = 'block'; 
	}else if(document.getElementById("type").value=='date' || document.getElementById("type").value=='textarea'){
                $("#defaultvalue").closest('tr').hide();
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none'; 
        }else{
                $("#defaultvalue").val('');
                $("#defaultvalue").closest('tr').show();
                document.getElementById('divtype1').style.display = 'none'; 
                document.getElementById('divtype2').style.display = 'none'; 
	}
}
//End//
</script>

<script language="JavaScript1.2" type="text/javascript">


function validate_Field(frm){



	if( ValidateForSimpleBlank(frm.fieldname,"Field Name")
		&&ValidateForSimpleBlank(frm.fieldlabel, "Field Label")
		&& ValidateForSelect(frm.type, " Field Type")
		){
			
					
					
				
                  var Url = "isRecordExists.php?fieldname="+escape(document.getElementById("fieldname").value)+"&editID="+document.getElementById("fieldid").value+"&Type=Field";
					SendExistRequest(Url,"fieldname", "Field Name");
		  	
		      return false;
				   	
					
			}else{
					return false;	
			}	

		
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
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_Field(this);" enctype="multipart/form-data">
 <? if (!empty($_SESSION['mess_head'])) {?>
    <tr>
    <td  align="center"  class="message"  >
        <? if(!empty($_SESSION['mess_head'])) {echo $_SESSION['mess_head']; unset($_SESSION['mess_lead']); }?>	
    </td>
    </tr>
 <? } ?>
  
   <tr>
    <td  align="center" valign="top" >


        <table class="borderall" width="100%" cellspacing="0" cellpadding="5" border="0">
        
        <tr>
             <td colspan="2" align="left" class="head">Field Detail</td>
        </tr>
        
        <tr>
                <td  align="right"   class="blackbold" width="45%"> Field Name :<span class="red">*</span> </td>
                <td   align="left" >
        <input name="fieldname" type="text" class="inputbox" onkeypress="return isVarcharKey(event);" id="fieldname" value="<?php echo stripslashes($arryFormField[0]['fieldname']) ?>"  maxlength="50" />            </td>
              </tr>
              
              <tr>
                <td  align="right"   class="blackbold" width="45%"> Field Label :<span class="red">*</span></td>
                <td   align="left" >
        <input name="fieldlabel" type="text"  class="inputbox" onkeypress="return isCharKey(event);" id="fieldlabel" value="<?php echo stripslashes($arryFormField[0]['fieldlabel'])?>"  maxlength="50" />            </td>
              </tr>
        
               <tr>
                <td  align="right"   class="blackbold"> Field Type : <span class="red">*</span></td>
                <td   align="left" >
            <select name="type" class="inputbox" <?=$readOnly?> id="type" onchange="return SelectType(this.value);" >
                    <option value="">--- Select Type ---</option>
                    <option value="text" <?  if($arryFormField[0]['type']=='text'){echo "selected";}?>>Text</option>
                    <option value="checkbox" <?  if($arryFormField[0]['type']=='checkbox'){echo "selected";}?>>Checkbox</option>
                    <option value="radio" <?  if($arryFormField[0]['type']=='radio'){echo "selected";}?>>Radio</option>
                    <option value="date" <?  if($arryFormField[0]['type']=='date'){echo "selected";}?>>Date</option>
                    <option value="select" <?  if($arryFormField[0]['type']=='select'){echo "selected";}?>>Dropdown List</option>
                    <!-- <option value="file" <?  if($arryFormField[0]['type']=='file'){echo "selected";}?>>Fileupload Box</option>-->
                     <option value="hidden" <?  if($arryFormField[0]['type']=='hidden'){echo "selected";}?>>Hidden Field</option>
                     <option value="textarea" <?  if($arryFormField[0]['type']=='textarea'){echo "selected";}?>>Text Area</option>
                 </select>       
                  </td>
              </tr>
               <tr>
                <td  align="right"   class="blackbold"  width="45%"><div id="divtype1"> Value :</div> </td>
                <td    align="left" ><div id="divtype2">
        <input name="dropvalue" type="text" <?=$readOnly?>  class="inputbox" id="dropvalue" value="<?php echo stripslashes($arryFormField[0]['dropvalue']) ?>"  maxlength="50" />  </div> </td>
              </tr>
              <tr>
                <td  align="right"   class="blackbold" width="45%"> Default Value : </td>
                <td   align="left" >
        <input name="defaultvalue" type="text"  <?=$readOnly?> class="inputbox" id="defaultvalue" value="<?php echo stripslashes($arryFormField[0]['defaultvalue']) ?>"  maxlength="50" />  </td>
              </tr>
              
              
              <tr>
                <td  align="right"   class="blackbold"> Mandatory :</td>
                <td   align="left" >
          <input type="checkbox" name="mandatory" <?=$readOnly?> value="1" <? if($arryFormField[0]['mandatory']==1){ echo "checked";}?> />    </td>
              </tr>
              
              <tr>
                <td  align="right"   class="blackbold" width="45%"> Sequence : </td>
                <td   align="left" >
        <input name="sequence" type="text"   class="inputbox" id="sequence" value="<?php echo stripslashes($arryFormField[0]['sequence']) ?>"  maxlength="30" size="20" />  
        
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
	<div id="SubmitDiv" <?=$dis?>>
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
   </div>
<input type="hidden" name="fieldid" id="fieldid" value="<?=$_GET['edit']?>" />
<input type="hidden" name="headid" id="headid"  value="<?php echo $_GET['head']; ?>" />	
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />
</td>
   </tr>
   </form>
</table>
</div>

<script>
SelectType('text');
</script>
 
