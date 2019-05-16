
<script class="jsbin" src="js/jquery.min.js"></script>
<script class="jsbin" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>


<div class="message" align="center">
<? if(!empty($_SESSION['mess_banner'])) {echo $_SESSION['mess_banner']; unset($_SESSION['mess_banner']); }?>
</div>



<table width="90%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post" onSubmit="" enctype="multipart/form-data">
	<tr>
		<td align="center" valign="top">


		<table width="90%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    
                    <!-------------------------------------------------------------------->
                    <tr>
                            <td colspan="2" align="left" class="head">Add Banner</td>
                            <div><a href="banner.php" class="back">Back</a></div>
                    </tr>
		
                  

                    <tr>
			<?php $image = (!empty($arryBanner->image))?($arryBanner->image):('');?>
                        <td align="right" >Select image:<span class="red">*</span></td>
                    <input type="hidden" name="image" value="<?php echo $image; ?>"/>
                    <td>

                        <?php if ($_GET['edit'] > 0) { ?>
                            <?php echo '<img src="../../upload/ecomupload/37/banner_image/' . $image . '" border=0  width="70%" height="200" img id="img"" >'; ?>
    <!--<img src="http://localhost/erp/superadmin/ecommerce/upload/<?php echo $arryBanner->image ?>" width="70%" height="200" img id="img" >-->
                        <?php } ?><img id="img"/>
                        <input type="file" name="image" onChange="readURL(this);" value="<?php echo $image;
                        ?>"/><br>
(Supported image file types are: .jpg & .png)
<br></td></tr>


                <tr>
                    <td align="right" valign="middle" class="blackbold">Status :</td>
		<?php $status = (!empty($arryBanner->status))?($arryBanner->status):('');?>

                    <td align="left" class="blacknormal">
                        <table width="151" border="0" cellpadding="0" cellspacing="0"
                               class="blacknormal margin-left">
                            <tr>
                                <td width="20" align="left" valign="middle"><input
                                        name="status" type="radio" value="1"
                                        <?= ($status == "1") ? "checked" : "" ?> /></td>
                                <td width="48" align="left" valign="middle">Active</td>
                                <td width="20" align="left" valign="middle"><input
                                        name="status" type="radio"
                                        <?= ($status == "0") ? "checked" : "" ?> value="0" /></td>
                                <td width="63" align="left" valign="middle">Inactive</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td width="30%" colspan="2" align="left" valign="top"
                        class="blackbold">Banner Content :</td>

                </tr>

                <tr>	
		<?php $bannerContent = (!empty($arryBanner->bannerContent))?($arryBanner->bannerContent):('');?>
		<td colspan="2" align="left" valign="top" class="editor_box"><textarea
                            name="bannerContent" id="page_content">
                                <?= stripslashes($bannerContent) ?>
                        </textarea> <script type="text/javascript">

var editorName = 'page_content';
                                                        
var editor = new ew_DHTMLEditor(editorName);
                                                        
editor.create = function() { 
var sBasePath = '../../admin/FCKeditor/';
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
                <tr>
                    <td align="center" height="135" valign="top"><br>
                        <?
                        if ($_GET['edit'] > 0) {
                            $ButtonTitle = 'Update';
                        } else {
                            $ButtonTitle = 'Submit';
                        }
                        ?> <input type="hidden" name="id" id="id" value="<?= $id; ?>" /> 
                          <input  name="submit" type="submit" class="button" id="SubmitPage"
                            value=" <?= $ButtonTitle ?> " />&nbsp;</td>
                </tr>
		

		</td>
	</tr>

	
	</form>
</table>
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
