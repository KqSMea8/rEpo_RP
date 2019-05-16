
<SCRIPT LANGUAGE=JAVASCRIPT>
var ModuleName = '<?=$ModuleName?>';
function ValidateForm(frm)
{
	if(  ValidateForSimpleBlank(frm.module_type, 'Assign To') && ValidateForSimpleBlank(frm.comment, 'comment') 
	){
	}else{
		return false;	
	}
	

	
	
}

</SCRIPT>
  <div ><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had">Manage <?=$ModuleName?>  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:10px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   
                    <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> Assign To :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">
                       <select name="module_type" id="module_type" class="inputbox" >
                       		<option value="" >--Select--</option>
                       		<option value="sales" <?php if($arryComments[0]['module_type']=='sales') echo 'selected';?> >Sales</option>
                       		<option value="purchases" <?php if($arryComments[0]['module_type']=='purchases') echo 'selected';?>>Purchases</option>
                       		<option value="both" <?php if($arryComments[0]['module_type']=='both') echo 'selected';?>>Both</option>
                       </select>
                       
					  </td>
                    </tr>
                    
                     <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> View Type :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">
                       <select name="view_type" id="view_type" class="inputbox" >
                       		<option value="public" <?php if($arryComments[0]['view_type']=='public') echo 'selected';?> >Public</option>
                       		<option value="private" <?php if($arryComments[0]['view_type']=='private') echo 'selected';?> >Private</option>
                       </select>
                       
					  </td>
                    </tr>
					
					<tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> Comment :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">
                       <textarea name="comment" id="comment" class="inputbox" maxlength="200" rows="10"><?=stripslashes($arryComments[0]['comment'])?></textarea>
					  </td>
                    </tr>
                  			
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status :</td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                      </td>
                    </tr>
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
			<? if(isset($_GET['edit']) && $_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="MasterCommentID" id="MasterCommentID" value="<?=$_GET['edit']?>">   
 
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
		  </tr>
	    </form>
</TABLE>
