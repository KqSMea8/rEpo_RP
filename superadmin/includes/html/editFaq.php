<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){


	if( ValidateForSimpleBlank(frm.Title, "Faq Title")
		 
		
	)		
                {    
             
                      DataExist = CheckExistingData("isRecordExists.php", "&Title="+escape(document.getElementById("Title").value)+"&editID="+document.getElementById("FaqID").value, "Title","Faq Title");
		if(DataExist==1)return false;
              ShowHideLoader('1','S');
			return true;		
		} else{
     
					return false;	
			}	
}


</script>

<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<div class="had">FAQ Management  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add  ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_faq'])) {echo $_SESSION['mess_faq']; unset($_SESSION['mess_faq']); }?>
</div>
<div align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
			</div>
<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm(this);">
 
	    <table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tr>
		<td align="center" valign="middle">
		   
			  <br>
		   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">			
		     <tr>
		       <td align="center" valign="top">
			<table width="100%" border="0" cellpadding="5" cellspacing="1">


			     <tr>                              
                   <td  width="45%" align="right"   class="blackbold"> Faq Title  :<span class="red">*</span> </td>                         	
		 <td   align="left" valign="top"><input name="Title" id="Title" type="text" class="textbox" size="50" maxlength="50"
								value="<?= stripslashes($arryeditFaq[0]['Title']) ?>" onkeypress="return isAlphaKey(event);"/> 									 
			     </td>
			  </tr>

         
                            <tr>
				<td class="blackbold" valign="top" align="right">Image:</td>
                            <td height="40" align="left" valign="top" class="blacknormal">

<input name="Image" id="Image" type="file" class="inputbox" onkeypress="javascript: return false;" onkeydown="javascript: return false;"
   oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />   


<?
if(IsFileExist($Config['FaqDir'],$arryeditFaq[0]['Image'])){ 
	$OldImage =  $arryeditFaq[0]['Image'];

	$PreviewArray['Folder'] = $Config['FaqDir'];
	$PreviewArray['FileName'] = $arryeditFaq[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryeditFaq[0]['Title']);
	$PreviewArray['Width'] = "150";
	$PreviewArray['Height'] = "150";
	$PreviewArray['Link'] = "1";

	echo '<br><br><div id="ImageDiv">'.PreviewImage($PreviewArray).'
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['FaqDir'].'\',\''.$arryeditFaq[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

}
?>

 
   
			</td></tr>										
				


<tr>
								<td  align="right" valign="top" class="blackbold">
								Meta Title :</td>
								<td   align="left" valign="top">
						<textarea id="MetaTitle" class="textarea" type="text" name="MetaTitle"><?=stripslashes($arryeditFaq[0]['MetaTitle']) ?></textarea></td>
							</tr>


							<tr>
								<td   align="right" valign="top" class="blackbold">
								Meta Keywords :</td>
								<td   align="left" valign="top">
					<textarea id="MetaKeywords" class="bigbox" type="text" name="MetaKeywords"><?=stripslashes($arryeditFaq[0]['MetaKeywords']) ?></textarea>

								</td>
							</tr>

							<tr>
								<td   align="right" valign="top" class="blackbold">
								Meta Description :</td>
					<td   align="left" valign="top">
					<textarea id="MetaDescription" class="bigbox" type="text" name="MetaDescription"><?=stripslashes($arryeditFaq[0]['MetaDescription']) ?></textarea>
					</td>
							</tr>
			
			<tr>
			   <td align="right" valign="middle" class="blackbold">Status :</td>
								<td align="left" class="blacknormal">
								<table width="151" border="0" cellpadding="0" cellspacing="0"
									class="blacknormal margin-left">
									<tr>
		<td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($FaqStatus == "1") ? "checked" : "" ?> /></td>								
		<td width="48" align="left" valign="middle">Active</td>
	        <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($FaqStatus == "0") ? "checked" : "" ?> value="0" /></td>
	        <td width="63" align="left" valign="middle">Inactive</td>
		  </tr>



                      
								</table>
								</td>
							</tr>


                        <tr>
				<td width="30%" colspan="2" align="left" valign="top"
					class="blackbold">Content :</td>

			</tr>

			<tr>

				<td colspan="2" align="left" valign="top" class="editor_box"><textarea
					name="Content" id="Content"><?php echo stripslashes($arryeditFaq[0]['Content']); ?></textarea> <script type="text/javascript">

                                                        var editorName = 'Content';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '100%', 500, 'custom');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script></td>
			</tr>


							
						</table>
						</td>
					</tr>


				</table>
				</td>
			</tr>
			<tr>
				<td align="center" height="135" valign="top"><br>
				<? if ($_GET['edit'] > 0) {
					$ButtonTitle = 'Update';
				} else {
					$ButtonTitle = 'Submit';
				} ?> 

<input type="hidden" name="FaqID" id="FaqID" value="<?= $FaqID; ?>" /> 

<input name="Submit" type="submit" class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />


</td>
			</tr>

		</table>
 
</form>
