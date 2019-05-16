<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	
	if($('#TemplateId').val()==''){
		if($('#TemplateDisplayName').val()==''){
			alert('Please enter template display name');
			return false;
			
		}
		else if($('#template').val()==''){
			alert('Please select your template');
			return false;
			
		}
	}else if($('#TemplateId').val()!=''){
		if($('#TemplateDisplayName').val()==''){
			alert('Please enter template display name');
			return false;
			
		}
	}
	
	
	
}

</SCRIPT>

<a href="<?=$RedirectUrl?>"  class="back">Back</a>
<div class="had">
Template    <span> &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle">
		  <br><br />
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				 
					
					<tr>
<?php $TemplateDisplayName = (!empty($arryTemplate[0]->TemplateDisplayName))?($arryTemplate[0]->TemplateDisplayName):(''); ?>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Template Display Name : <span class="red">*</span></td>
                      <td width="56%" align="left"><input value="<?=stripslashes($TemplateDisplayName)?>" name="TemplateDisplayName" type="text" class="inputbox" id="TemplateDisplayName" size="31" maxlength="30" <? if($_GET['edit']==1) echo 'Readonly'; ?>/> </td>
                    </tr>
                    <tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Template Type : <span class="red">*</span></td>
                      <td width="56%" align="left">
                      <?php 
$TemplateType = (!empty($arryTemplate[0]->TemplateType))?(stripslashes($arryTemplate[0]->TemplateType)):('');
                      $TemplateType=array('restaurant'=>'Restaurant','jewellry'=>'Jewellry','garments'=>'Garments','furniture'=>'Furniture','printing'=>'Printing Graphics');?>
                      <select name="TemplateType" class="inputbox">
                      <?php foreach($TemplateType as $key=>$val){
                      	echo '<option value="'.$key.'" ';
                      	if ($TemplateType==$key) echo 'selected="selected"';
                      	echo '>'.$val.'</option>';
                      }?>
                      	
                      </select>
                     
                    </tr>
					<?php
				if(!isset($_GET['edit']) || empty($_GET['edit'])  ){ ?>
				<tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Upload : <span class="red">*</span> </td>
                      <td width="56%" align="left"><input type="file" name="template" id="template"/> </td>
                    </tr>
				<?php	}	?>
					
					
                  </table></td>
                </tr>
				
				<tr>
                  <td align="center" valign="top" >
				  <br>
				
				  <input type="hidden" name="TemplateId" id="TemplateId"  value="<?=$_GET['edit']?>" />
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
				  <br>  
				  <br>				  </td>
                </tr>	
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
