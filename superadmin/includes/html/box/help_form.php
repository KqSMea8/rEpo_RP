<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<style type="text/css">
input[type="text"][name="Heading"], input[type="text"][name="VideoUrl"] {
    width: 500px;
}
</style>
<script language="JavaScript1.2" type="text/javascript">
function validateHelp(frm){

	if( ValidateForSimpleBlank(frm.Heading, "Heading") 
	    && isValidLinkOpt(frm.VideoUrl,"Video Url")
	){  	
		var Url = "isRecordExists.php?editID="+escape(document.getElementById("WsID").value)+"&Type=Help";
		return false;	
				
	}else{
			return false;	
	}	

}
</script>
<?php
//echo "<pre>";print_r($arryHelp);
?>
<table width="97%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post"
		onSubmit="return validateHelp(this);"
		enctype="multipart/form-data">


	<tr>
		<td align="center" valign="top">


		<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="2" align="left" class="head">Help Details</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Department Name :<span
					class="red">*</span></td>
				<td align="left"><select name="Department" id="Department"
					class="textbox" style="width: 200px">
					<?php foreach ($arryDepartmentName as $arryDepName){
						//echo "<pre>";print_r($arryDepName);
						?>
					<option value="<?=$arryDepName['depID']?>"
					<?php if($arraydepartById[0]['depID']==$arryDepName['depID']){echo "selected='selected'";}?>><?php echo $arryDepName['Department']?></option>

					<?php } ?>
				</select></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Category Name :<span class="red">*</span>
				</td>
				<td align="left"><select name="CategoryName" id="CategoryName"
					class="textbox" style="width: 200px">
					<?php foreach ($arryCategoryName as $arryCatName){
						//echo "<pre>";print_r($arryCatName);
						?>
					<option value="<?=$arryCatName['CategoryID']?>" 
					<?php if($arraycategoryNametById[0]['CategoryID']==$arryCatName['CategoryID']){echo "selected='selected'";}?>><?php echo $arryCatName['CategoryName']?></option>

					<?php } ?>
				</select></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Heading :<span class="red">*</span>
				</td>
				<td align="left"><input name="Heading" type="text" class="inputbox"
					id="Heading"
					value="<?php echo stripslashes($arryHelp[0]['Heading']); ?>"
					maxlength="100" /></td>
			</tr>
	<tr>
				<td align="right" class="blackbold">Video URL :</td>
				<td align="left"><input name="VideoUrl" type="text" class="inputbox"
					id="VideoUrl" value="<?php echo stripslashes($arryHelp[0]['VideoUrl']); ?>"
					maxlength="100" /> (Video URL should start with http:// )</td>
			</tr>


			<tr>
				<td class="blackbold" valign="top" align="right">Upload Document :</td>
				<td align="left" class="blacknormal" valign="top"><input
					name="UploadDoc" type="file" class="inputbox" id="UploadDoc"
					onkeypress="javascript: return false;"
					onkeydown="javascript: return false;" oncontextmenu="return false"
					ondragstart="return false" onselectstart="return false" /> 
				 

<?        
		 
	if(IsFileExist($Config['HelpDoc'],$arryHelp[0]['UploadDoc']) ){ 
	
			$OldUploadDoc =  $arryHelp[0]['UploadDoc'];

		?><br><br>
			<input type="hidden" name="OldUploadDoc" value="<?=$OldUploadDoc?>">


			<div id="DocDiv">
			<?=$arryHelp[0]['UploadDoc']?>&nbsp;&nbsp;&nbsp;
			<a href="download.php?file=<?=$arryHelp[0]['UploadDoc']?>&folder=<?=$Config['HelpDoc']?>" title="<?=$arryHelp[0]['UploadDoc']?>" class="download">Download</a>
		&nbsp;
			<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['HelpDoc']?>', '<?=$arryHelp[0]['UploadDoc']?>','DocDiv')"><?=$delete?></a>
			<br><br>
			</div>
	
		<?	} ?>


</td>
			</tr>
			
			
			<!-- Video Upload  -->
			
				<tr>
				<td class="blackbold" valign="top" align="right">Upload Video :</td>
				<td align="left" class="blacknormal" valign="top"><input
					name="Videolink" type="file" class="inputbox" id="Videolink"
					onkeypress="javascript: return false;"
					onkeydown="javascript: return false;" oncontextmenu="return false"
					ondragstart="return false" onselectstart="return false" /> 


				<? /*$MainDirVideo = "../upload/help/video/";	
					$documentvideo = stripslashes($arryHelp[0]['Videolink']);
					
				if($documentvideo !='' && file_exists($MainDirVideo.$documentvideo) ){
				
					?>
                   
				<div id="VIDDiv" style="padding: 10px 0 10px 0;"><?=$documentvideo?>&nbsp;&nbsp;&nbsp;
				<a href="dwn.php?file=<?=$MainDirVideo.$documentvideo?>" class="download">Download</a>
				<a href="Javascript:void(0);"
					onclick="Javascript:DeleteFile('<?=$MainDirVideo.$documentvideo?>','VIDDiv')">
					<?=$delete?></a> <!--input type="hidden" name="Videolink"
					value="<?=$MainDirVideo.$documentvideo?>"--></div>
					<? }*/?>
				<?php if(IsFileExist($Config['HelpVedio'],$arryHelp[0]['Videolink']) ){ 
	
			$OldVideolink =  $arryHelp[0]['Videolink'];

		?><br><br>
			<input type="hidden" name="OldVideolink" value="<?=$OldVideolink?>">


			<div id="VIDDiv">
			<?=$arryHelp[0]['Videolink']?>&nbsp;&nbsp;&nbsp;
			<a href="download.php?file=<?=$arryHelp[0]['Videolink']?>&folder=<?=$Config['HelpVedio']?>" title="<?=$arryHelp[0]['Videolink']?>" class="download">Download</a>
		&nbsp;
			<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['HelpVedio']?>', '<?=$arryHelp[0]['Videolink']?>','VIDDiv')"><?=$delete?></a>
			<br><br>
			</div>
	
		<?	} ?>
		
			</td>
			</tr>
			
			
			<!-- End -->


			<tr>
				<td align="right" class="blackbold">Status :</td>
				<td align="left"><? 
				$ActiveChecked = ' checked'; $InActiveChecked ='';
			 if($_GET['edit'] > 0){
				 if($arryHelp[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryHelp[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			 }
		  ?> <label><input type="radio" name="Status" id="Status" value="1"
		  <?=$ActiveChecked?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp; <label><input
					type="radio" name="Status" id="Status" value="0"
					<?=$InActiveChecked?> /> InActive</label></td>
			</tr>


			<tr>
				<td width="30%" colspan="2" align="left" valign="top"
					class="blackbold">Content :</td>

			</tr>

			<tr>

				<td colspan="2" align="left" valign="top" class="editor_box"><textarea
					name="Content" id="Content"><?php echo stripslashes($arryHelp[0]['Content']); ?></textarea> <script type="text/javascript">

                                                        var editorName = 'Content';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '1000', 500, 'custom');
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
			value=" <?=$ButtonTitle?> " /> <input type="hidden" name="WareHouseID"
			id="WareHouseID" value="<?=$_GET['edit']?>" /> <?php /*?><input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryHelp[0]['state_id']; ?>" />	
					<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryHelp[0]['city_id']; ?>" /><?php */?>

		</div>

		</td>
	</tr>
	</form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
