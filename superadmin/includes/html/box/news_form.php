<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	if( ValidateForSimpleBlank(frm.Heading, "News Heading")
		&&ValidateForSimpleBlank(frm.Date, "Date")	
		&& ValidateOptionalUpload(frm.Image, "Image")
		
		)
                {  
		var Url = "isRecordExists.php?Heading="+escape(document.getElementById("Heading").value)+"&editID="+document.getElementById("NewsID").value;
		SendExistRequest(Url, "Heading", "News Heading");
		return false;  					
		}
      else{
					return false;	
			}	
}



function isURlKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
	 
    if ((charCode < 45 || charCode > 57)&&(charCode < 65 || charCode > 90)&&(charCode < 97 || charCode > 122)&&(charCode<95))
    {
        return false;
    }else{

    return true;
    }
}
</script>

<?php
//echo "<pre>";print_r($arryNews);
?>
<table width="97%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post"
		onSubmit="return validateForm(this);" enctype="multipart/form-data">

	<tr>
		<td align="center" valign="top">


		<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="2" align="left" class="head">News Details</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Category Name :</td>
				<td align="left"><select name="CategoryName" id="CategoryName"
					class="textbox" style="width: 200px">
					<?php foreach ($arryCategoryName as $arryCatName){
						//echo "<pre>";print_r($arryCatName);
						?>
					<option value="<?=$arryCatName['CategoryID']?>"
					<?php if($arraycategoryNametById[0]['CategoryID']==$arryCatName['CategoryID']){echo "selected='selected'";}?>><?php echo $arryCatName['NewsCategoryName']?></option>

					<?php } ?>
				</select></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Heading :<span class="red">*</span>
				</td>
				<td align="left"><input name="Heading" type="text" size="100" class="textbox"
					id="Heading" 
					value="<?php echo stripslashes($arryNews[0]['Heading']); ?>"
					maxlength="200" /></td>
			</tr>
<tr>
				<td align="right" class="blackbold">News Url : 
				</td>
				<td align="left"><input name="NewsUrl" size="100" type="text" class="textbox"
					id="NewsUrl" 
					value="<?php echo stripslashes($arryNews[0]['NewsUrl']); ?>"
					maxlength="100" onkeypress="return isURlKey(event)"/></td>
				
			</tr>

                        <tr>
                            <td  width="45%" align="right" valign="top"  class="blackbold">Summary   :</td> 
                             <td  align="left" >
                               <textarea name="Summary" class="bigbox" id="Summary"   ><?=stripslashes($arryNews[0]['Summary'])?></textarea></td>
                          </tr>
			<tr>
				<td align="right">Date :<span class="red">*</span></td>
				<td align="left"><? $Date=''; if($arryNews[0]['Date']>0)$Date = $arryNews[0]['Date'];?>
				<script>
$(function() {
$( "#Date" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-1?>:<?=date("Y")+20?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#expNone").on("click", function () { 
		$("#Date").val("");
	}
	);	

});
</script> <input id="Date" name="Date" readonly="" class="datebox"
					value="<?=$Date?>" type="text"> &nbsp;&nbsp;&nbsp;&nbsp;<!--a href="Javascript:void(0);" id="expNone">None</a-->

				</td>
			</tr>

			<tr>
				<td class="blackbold" valign="top" align="right">Image:</td>
				<td height="40" align="left" valign="top" class="blacknormal"><input
					name="Image" id="Image" type="file" class="inputbox"
					onkeypress="javascript: return false;"
					onkeydown="javascript: return false;" oncontextmenu="return false"
					ondragstart="return false" onselectstart="return false" /> &nbsp;  

		<?
if(IsFileExist($Config['NewsDir'],$arryNews[0]['Image'])){ 
	$OldImage =  $arryNews[0]['Image'];

	$PreviewArray['Folder'] = $Config['NewsDir'];
	$PreviewArray['FileName'] = $arryNews[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryNews[0]['Heading']);
	$PreviewArray['Width'] = "150";
	$PreviewArray['Height'] = "150";
	$PreviewArray['Link'] = "1";

	echo '<br><br><div id="ImageDiv">'.PreviewImage($PreviewArray).'
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['NewsDir'].'\',\''.$arryNews[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

}
?>
				
				</td>
			</tr>


<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Title :</td>
								<td width="56%" align="left" valign="top">
						<textarea id="MetaTitle" class="textarea" type="text" name="MetaTitle"><?=stripslashes($arryNews[0]['MetaTitle']) ?></textarea></td>
							</tr>


							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Keywords :</td>
								<td width="56%" align="left" valign="top">
					<textarea id="MetaKeywords" class="bigbox" type="text" name="MetaKeywords"><?=stripslashes($arryNews[0]['MetaKeywords']) ?></textarea>

								</td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Description :</td>
					<td width="56%" align="left" valign="top">
					<textarea id="MetaDescription" class="bigbox" type="text" name="MetaDescription"><?=stripslashes($arryNews[0]['MetaDescription']) ?></textarea>
					</td>
							</tr>

			<tr>
				<td align="right" class="blackbold">Status :</td>
				<td align="left"><? 
				$ActiveChecked = ' checked';$InActiveChecked ='';
				if($_GET['edit'] > 0){
					if($arryNews[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					if($arryNews[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
				?> <label><input type="radio" name="Status" id="Status" value="1"
				<?=$ActiveChecked?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp; <label><input
					type="radio" name="Status" id="Status" value="0"
					<?=$InActiveChecked?> /> InActive</label></td>
			</tr>

			<tr>
				<td width="30%" colspan="2" align="left" valign="top"					class="blackbold">Content :</td>

			</tr>
			<tr>

				<td colspan="2" align="left" valign="top" class="editor_box"><textarea
					name="Content" id="Content"><?php echo stripslashes($arryNews[0]['Detail']); ?></textarea>
				<script type="text/javascript">

                                                        var editorName = 'Content';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '100%', 600, 'custom');
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

	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>

	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
		<input name="Submit" type="submit" class="button" id="SubmitButton"
			value=" <?=$ButtonTitle?> " /> <input type="hidden" name="NewsID"
			id="NewsID" value="<?=$_GET['edit']?>" /> <?php /*?><input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryHelp[0]['state_id']; ?>" />	
					<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryHelp[0]['city_id']; ?>" /><?php */?>

		</div>

		</td>
	</tr>
	</form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
