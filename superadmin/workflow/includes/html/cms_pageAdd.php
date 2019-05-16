
<script type="text/javascript" src="../../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
	}
</script>


<?php include_once('siteManagementMenu.php');?>


<div class="clear"></div>
<div class="message" align="center"><? //if(!empty($_SESSION['mess_pg'])) {echo $_SESSION['mess_pg']; unset($_SESSION['mess_pg']); }?>
</div>
<?php 	 ?>

<form name="form1" action="" method="post" enctype="multipart/form-data">
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle">
				<div align="right"><a href="cms.php" class="back">Back</a>&nbsp;
				</div>
				<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="borderall">


					<tr>
						<td align="center" valign="top">
						<table width="100%" border="0" cellpadding="5" cellspacing="1">
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Name (for Menu) :<span class="red">*</span></td>
								 <td   align="left" >
                               <?php echo $FormHelper->input(__('Name'),array('type'=>'text','class'=>'inputbox','id'=>'Name','maxlength'=>50,'value'=>stripslashes($arryPages->Name))); ?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Title :<span class="red">*</span></td>
								 <td   align="left" >
                               <?php echo $FormHelper->input(__('Title'),array('type'=>'text','class'=>'inputbox','id'=>'Title','maxlength'=>50,'value'=>stripslashes($arryPages->Title)));?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Priority (used for sorting) :</td>
								<td   align="left" >
                               <?php echo $FormHelper->input(__('Priority'),array('type'=>'text','class'=>'inputbox','id'=>'Priority','maxlength'=>50,'value'=>stripslashes($arryPages->Priority)));?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Slug:<span class="red">*</span></td>
								<td   align="left" >
                               <?php echo $FormHelper->input(__('page_slug'),array('type'=>'text','class'=>'inputbox','id'=>'page_slug','maxlength'=>50,'value'=>stripslashes($arryPages->page_slug)));?>
							   </tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Title : </td>
								<td   align="left" >
                               <?php echo $FormHelper->input(__('MetaTitle'),array('type'=>'textarea','class'=>'','id'=>'MetaTitle','value'=>stripslashes($arryPages->MetaTitle)));?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Keywords :</td>
								<td   align="left" >
                               <?php echo $FormHelper->input(__('MetaKeywords'),array('type'=>'textarea','class'=>'','id'=>'MetaKeywords','value'=>stripslashes($arryPages->MetaKeywords)));?>
							   </tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Description :</td>
								<td   align="left" >
                               <?php echo $FormHelper->input(__('MetaDescription'),array('type'=>'textarea','class'=>'','id'=>'MetaDescription','value'=>stripslashes($arryPages->MetaDescription)));?>
					           </tr>
					          
							<tr>
								<td align="right" valign="middle" class="blackbold">Status :</td>
								<td align="left" class="blacknormal" value="<?php echo $arryPages->Status;?> " >
								<table width="151" border="0" cellpadding="0" cellspacing="0"
									class="blacknormal margin-left">
									<tr>
										<td width="20" align="left" valign="middle"><input
											name="Status" type="radio" value="1"
											<?= ($arryPages->Status == "1") ? "checked" : "" ?> /></td>
										<td width="48" align="left" valign="middle">Active</td>
										<td width="20" align="left" valign="middle"><input
											name="Status" type="radio"
											<?= ($arryPages->Status == "0") ? "checked" : "" ?> value="0" /></td>
										<td width="63" align="left" valign="middle">Inactive</td>
									</tr>
								</table>
								</td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Template:</td>
								<td width="56%" align="left" valign="top"><select
									name="Template">
									<option value="">Select Template</option>
									<?php foreach($files as $fkey=>$fvalue){?>
									<option value="<?php echo $fkey;?>"
									<?php if($arryPage[0]['template']==$fkey){echo 'selected="selected"';}?>>
										<?php echo $fvalue;?> <?php }?></option>
								</select></td>
							</tr>


							<tr>
								<td width="30%" colspan="2" align="left" valign="top"
									class="blackbold">Page Content :</td>

							</tr>
							<tr>

								<td colspan="2" align="left" valign="top" class="editor_box">
							<textarea
									name="page_content" id="page_content">
									<?=stripslashes($arryPages->page_content) ?>
													</textarea> <script type="text/javascript">

                                                        var editorName = 'page_content';
                                                        
                                                        var editor = new ew_DHTMLEditor(editorName);
                                                        
                                                        editor.create = function() { 
                                                            var sBasePath = '../../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '1170', 500, 'custom');
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
				} ?> <input type="hidden" name="id" id="id" value="<?= $id; ?>" /> <input
					name="Submit" type="submit" class="button" id="SubmitPage"
					value=" <?= $ButtonTitle ?> " />&nbsp;</td>
			</tr>

		</table>
		</td>
	</tr>
</table>
</form>
<style>
td.editor_box {
    text-align: center;
}
</style>
