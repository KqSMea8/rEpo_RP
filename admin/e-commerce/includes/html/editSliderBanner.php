<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had">
<?=$MainModuleName?>   <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
<form name="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Name : <span class="red">*</span></td>
                                                <td width="56%"  align="left" valign="top">
                                                	<input  name="Name" id="Name" value="<?= stripslashes($arrySlider[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                                                    
                                                </td>
                                            </tr>
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Priority (used for sorting) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" onkeypress="return isNumberKey(event)" value="<?= stripslashes($arrySlider[0]['Priority']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
											  <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Content :</td>
                                                <td width="56%"  align="left" valign="top">
                                                  <textarea name="Content" id="full_text"><?= stripslashes($arrySlider[0]['Content']) ?></textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'full_text';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '910', 200, 'Default');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>
                                                </td>
                                            </tr>
											
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Image :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                     <input  name="Slider_image" id="Slider_image" type="file" class="inputbox"  size="50" />
                                                    <br>
                                                                        <?= $MSG[201] ?>	
                                                    
                                                                        <br>
                                                            

<? 
if(IsFileExist($Config['ProductsBanner'],$arrySlider[0]['Slider_image'])){   
$OldImage = $arrySlider[0]['Slider_image'];
?>
 
<span id="DeleteSpan">
<?php
    $PreviewArray['Folder'] = $Config['ProductsBanner'];
    $PreviewArray['FileName'] = $arrySlider[0]['Slider_image']; 
    $PreviewArray['FileTitle'] = stripslashes($arrySlider[0]['Name']);
    $PreviewArray['Width'] = "120";
    $PreviewArray['Height'] = "120";
    $PreviewArray['Link'] = "1";
    echo '<br><div id="ImageDiv">'.PreviewImage($PreviewArray);

   #echo '&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['ProductsBanner'].'\',\''.$arrySlider[0]['Slider_image'].'\',\'ImageDiv\')">'.$delete.'</a>';

    echo '<input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

?>
</span>
<? } ?> 


            
<?php
/*												
$MainDir = $Prefix."upload/company/".$_SESSION['CmpID']."/slider_image/"; 
		//$MainDir = $_SERVER["DOCUMENT_ROOT"]."/web/upload/company/logo/"; 
		if ($arrySlider[0]['Slider_image'] != '' && file_exists($MainDir.$arrySlider[0]['Slider_image'])) { 
		 $OldImage = $MainDir . $arrySlider[0]['Slider_image']; 
		?>
		<span id="DeleteSpan">
		<input type="hidden" name="OldImage" value="<?=$OldImage?>">  
		
		<a data-fancybox-group="gallery" class="fancybox" href="<?=$MainDir.$arrySlider[0]['Logo']?>">
		<? echo '<img src="resizeimage.php?w=200&h=200&img=' . $MainDir. $arrySlider[0]['Logo'] . '" border=0  >'; ?>
		</a>&nbsp;
		<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arrySlider[0]['Slider_image']?>','DeleteSpan')" onmouseout="hideddrivetip();">
		<?=$delete?></a>
		
		</span>	
		                                                                           
		 <? } */  ?>
                                                </td>
                                            </tr>
                                           
                                            
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status  :</td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($PageStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($PageStatus == "No") ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>

                                           

                                        </table>

                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                            <input type="hidden" name="Id" id="Id" value="<?= $sliderId; ?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitSlider" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>

