<script class="jsbin" src="js/jquery.min.js"></script>
<script class="jsbin" src="js/jquery-ui.min.js"></script>
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

<script>
function readURL(input) 
{
        if (input.files && input.files[0]) 
		{
            var reader = new FileReader();

            reader.onload = function (e) 
			{
                $('#img')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
}
</script>


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
                               <?php 
$PageName = (!empty($arryPages->Name))?($arryPages->Name):('');
echo $FormHelper->input(__('Name'),array('type'=>'text','class'=>'inputbox','id'=>'Name','maxlength'=>50,'value'=>stripslashes($PageName))); ?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Title :<span class="red">*</span></td>
								 <td   align="left" >
                               <?php
$PageTitle = (!empty($arryPages->Title))?($arryPages->Title):('');
 echo $FormHelper->input(__('Title'),array('type'=>'text','class'=>'inputbox','id'=>'Title','maxlength'=>50,'value'=>stripslashes($PageTitle)));?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Priority (used for sorting) :</td>
								<td   align="left" >
                               <?php 
$Priority = (!empty($arryPages->Priority))?($arryPages->Priority):('');
echo $FormHelper->input(__('Priority'),array('type'=>'text','class'=>'inputbox','id'=>'Priority','maxlength'=>50,'value'=>stripslashes($Priority)));?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Slug:<span class="red">*</span></td>
								<td   align="left" >
                               <?php 
$page_slug = (!empty($arryPages->page_slug))?($arryPages->page_slug):('');
echo $FormHelper->input(__('page_slug'),array('type'=>'text','class'=>'inputbox','id'=>'page_slug','maxlength'=>50,'value'=>stripslashes($page_slug)));?>
							   </tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Title : </td>
								<td   align="left" >
                               <?php 
$MetaTitle = (!empty($arryPages->MetaTitle))?($arryPages->MetaTitle):('');
echo $FormHelper->input(__('MetaTitle'),array('type'=>'textarea','class'=>'','id'=>'MetaTitle','value'=>stripslashes($MetaTitle)));?>
								</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Keywords :</td>
								<td   align="left" >
                               <?php 
$MetaKeywords = (!empty($arryPages->MetaKeywords))?($arryPages->MetaKeywords):('');
echo $FormHelper->input(__('MetaKeywords'),array('type'=>'textarea','class'=>'','id'=>'MetaKeywords','value'=>stripslashes($MetaKeywords)));?>
							   </tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Meta Description :</td>
								<td   align="left" >
                               <?php 
$MetaDescription = (!empty($arryPages->MetaDescription))?($arryPages->MetaDescription):('');
echo $FormHelper->input(__('MetaDescription'),array('type'=>'textarea','class'=>'','id'=>'MetaDescription','value'=>stripslashes($MetaDescription)));?>
					           </tr>
					          
							<tr>
								<td align="right" valign="middle" class="blackbold">Status :</td>
								<td align="left" class="blacknormal" >
								<table width="151" border="0" cellpadding="0" cellspacing="0"
									class="blacknormal margin-left">
									<tr>
										<td width="20" align="left" valign="middle">
<?  $PageStatus = (!empty($arryPages->Status))?($arryPages->Status):(''); ?>
<input
											name="Status" type="radio" value="1"
											<?= ($PageStatus == "1") ? "checked" : "" ?> /></td>
										<td width="48" align="left" valign="middle">Active</td>
										<td width="20" align="left" valign="middle"><input
											name="Status" type="radio"
											<?= ($PageStatus == "0") ? "checked" : "" ?> value="0" /></td>
										<td width="63" align="left" valign="middle">Inactive</td>
									</tr>
								</table>
								</td>
							</tr>

                                                        
                                                         <!--<tr>
                <?  $image = (!empty($arryPages->image))?($arryPages->image):(''); ?>   
                <?  $Template = (!empty($arryPages->Template))?($arryPages->Template):(''); ?>             
                                    
                        <td align="right" >Select image:<span class="red">*</span></td>
                    <input type="hidden" name="image" value="<?php echo $image; ?>"/>
                  <td>

                        <?php if ($_GET['edit'] > 0 && $image!='' ) { ?>
                        <?php echo '<img src="../../upload/ecomupload/37/banner_image/' . $image . '" border=0  width="70%" height="200" img id="img"" >'; }?>
                      <img id="img">
                        <input type="file" name="image" onChange="readURL(this);" value="<?php echo $image;
                        ?>"  /></td></tr>
                                                        
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Page Template:</td>
								<td width="56%" align="left" valign="top">								
								<select
									name="Template">
									<option value="">Select Template</option>
									<?php 
									if(!empty($files)){
									foreach($files as $fkey=>$fvalue){
                                                                            
									?>
									<option value="<?php echo $fkey;?>"
									<?php if($Template==$fkey){echo 'selected="selected"';}?>>
										<?php echo $fvalue;?> <?php }
									}?></option>
								</select></td>
							</tr>


							<tr>
								<td width="30%" colspan="2" align="left" valign="top"
									class="blackbold">Page Content :</td>

							</tr>
							<tr>-->

<?  $page_content = (!empty($arryPages->page_content))?($arryPages->page_content):(''); ?>

								<td colspan="2" align="left" valign="top" class="editor_box"><textarea
									name="page_content" id="page_content">
									<?=stripslashes($page_content) ?>
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
				<? if (!empty($_GET['REQUEST'])) {
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

