
<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="85%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewTemplates.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="98%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
				  <tr>
                      <td align="right" valign="top" =""  class="blackbold">
					  Template Category  <span class="red">*</span>					  </td>
                      <td align="left">
					  <? if(sizeof($arryTemplateCategory)>0){?>
		  <select name="catID" class="blacknormal" id="catID" style="width: 200px;" >
		  	  <option value="">--- Select Category ---</option>
              <? for($i=0;$i<sizeof($arryTemplateCategory);$i++) {?>
              <option value="<?=$arryTemplateCategory[$i]['catID']?>" <?  if($arryTemplateCategory[$i]['catID']==$arryTemplate[0]['catID']){echo "selected";}?>>
              <?=stripslashes($arryTemplateCategory[$i]['Name'])?>
              </option>
              <? } ?>
            </select> 
			<? }else{
				$Disabled = 'disabled="disabled"';
			?>
			<span class="red">No Category found !</span> 
			<? } ?>					  </td>
                    </tr> 
				    <tr>
                      <td width="25%" align="right" valign="top" =""  class="blackbold">
					   Template Heading <span class="red">*</span> </td>
                      <td width="75%" align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($arryTemplate[0]['heading'])?>" type="text" class="inputbox"  size="30" maxlength="50" />					    </td>
                    </tr>
				
					<!--
	                <tr>
	                  <td  align="right" valign="top"   class="blackbold">Header Menu Button</td>
	                  <td  align="left" valign="top" class="blacknormal">
					  <select name="HeaderMenuButton" id="HeaderMenuButton" class="inputbox">
                        <option value="css" <? if($arryTemplate[0]['HeaderMenuButton'] == 'css') echo 'selected';?>> Css Driven </option>
                        <option value="image" <? if($arryTemplate[0]['HeaderMenuButton'] == 'image') echo 'selected';?>> Image Driven </option>
                      </select></td>
	                  </tr>
					  -->
	                <tr>
	  <td  align="right" valign="top"   class="blackbold">Upload Template (Zip File) 
	  <? if($_GET['edit']<=0){	?>	<span class="red">*</span><? } ?></td>
    <td  align="left" valign="top" class="blacknormal">
	<input name="ZipFile" type="file" class="inputbox" id="ZipFile" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	(Only Zip Files are allowed to upload. It should only have images and style.css file in a zipped folder named as <strong>images.zip</strong>
	 )	</td>
	  </tr>
	  
	<tr>
    <td  align="right" valign="top"   class="blackbold">Upload Image <?  if($_GET['edit']<=0){	?>	<span class="red">*</span><? } ?> </td>
    <td  align="left" valign="top" class="blacknormal">
	<input name="Image" type="file" class="inputbox" id="Image" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	<?=$MSG[200]?> <br><?=$MSG[201]?>	</td>
  </tr>
<?php if($arryTemplate[0]['Image'] !='' && file_exists('../templates/images/'.$arryTemplate[0]['Image']) ){
$ImageExist = 1;
 ?>
<tr>
  <td  align="right"   class="blackbold" valign="top">Current Image </td>
    <td  align="left" valign="top">
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=templates/images/<?php echo $arryTemplate[0][Image];?>', 150, 100, 'yes' );"><?php echo '<img src="../resizeimage.php?w=100&h=100&img=templates/images/'.$arryTemplate[0]['Image'].'" border=0 class="imgborder" ></a>';?>
				</a>	  </td>
  </tr>  
<?
	}
?>				
	
					
 <? if($_GET['edit']>0){	?>
 <tr>
  <td  align="right"   class="blackbold" valign="top">Current CSS </td>
    <td  align="left" valign="top">
<?
$CSS_Contents = file_get_contents("../templates/".$_GET['edit']."/css/style.css");
?>
<textarea name="CSS_Contents" id="CSS_Contents" class="inputbox" cols="100" rows="30"><?=$CSS_Contents?></textarea>
<input type="hidden" name="CSS_Contents_Old" value="<?=$CSS_Contents?>">	  </td>
  </tr>  
<? } ?>  

					
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Status  </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
		
		
  <tr >
                      <td align="right" valign="top"  class="blackbold">Open to the Public   </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Public" type="radio" value="1" <?=($Public==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Yes</td>
            <td width="20" align="left" valign="middle"><input name="Public" type="radio" <?=($Public==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">No</td>
          </tr>
        </table>                                            </td>
                    </tr>	


		
                  </table></td>
                </tr>
				
				
				 <tr><td align="center">
			  <br>
			  <input type="hidden" name="templateID" id="templateID"  value="<?=$_GET['edit']?>" />
			  <input type="hidden" name="ImageExist" id="ImageExist"  value="<?=$ImageExist?>" />
			  <input type="hidden" name="TemplateExist" id="TemplateExist"  value="<?=$TemplateExist?>" />
			  <input type="hidden" name="NextTemplateID" id="NextTemplateID"  value="<?=$NextTemplateID?>" />
			  
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?> <?=$ModuleName?>"  <?=$Disabled?>/>
			  <input type="reset" name="Reset" value="Reset" class="button" <?=$Disabled?> />
				    <br>  <br>  <br>
				  
				  </td></tr> 
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSelect(frm.catID, "Template Category")  
		&& ValidateForBlank(frm.heading, "Template Heading")
		&& ValidateMandRange(frm.heading, "Template Heading",3,50)
		){
			
			if(frm.templateID.value<=0 || frm.ZipFile.value != ''){
				if(!ValidateMandZipFile(frm.ZipFile, "Template")){
					return false;
				}
			}
			
			/*
			if(frm.TemplateExist.value != 1){
				if(!ValidateMandUploadTemplate(frm.Template, "Template")){
					return false;
				}
			}
			*/
		
		
			if(frm.ImageExist.value != 1){
				if(!ValidateMandImage(frm.Image, "Image")){
					return false;
				}
			}
			
			
			
			
			/*
			if (typeof ew_UpdateTextArea == 'function'){
				ew_UpdateTextArea();
			}
			
			if (!ew_ValidateForm(frm,"detail","Template Detail")){
				return false;
			}*/
		
			var Url = "isRecordExists.php?TemplateHeading="+document.getElementById("heading").value+"&editID="+document.getElementById("templateID").value;
			SendExistRequest(Url,"heading","Template Heading");
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>