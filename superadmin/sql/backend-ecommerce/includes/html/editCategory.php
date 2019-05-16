<script type="text/javascript" src="../../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">


    <?
    if ($ParentID == 0) {
        echo 'Manage Categories';
    } else {
        ?>
        Manage Categories <?= $MainParentCategory ?>  <strong><?= $ParentCategory ?></strong>
    <? } ?>
    <span> &raquo;
        <?
        $MemberTitle = (!empty($_GET['edit'])) ? (" Edit ") : (" Add ");
        echo $MemberTitle . $ModuleName;
        ?></span>
</div>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
               <form name="form1" action="" method="post" enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Select Parent Category : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="ParentID" id="ParentID" class="inputbox">
                                                        <option value="0">Category Root</option>
                                                        <?php
                                                        $objCategory->getCategories(0, 0, $_GET['ParentID']);
                                                        ?>
                                                    </select>	

                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    <?= $ModuleName ?> Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?= stripslashes($arryCategory[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Meta Title : </td>
                                                <td align="left" valign="top">
                                                    <input  name="MetaTitle" id="MetaTitle" value="<?= stripslashes($arryCategory[0]['MetaTitle']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Meta Keywords : </td>
                                                <td align="left" valign="top">
                                                    <Textarea name="MetaKeyword" id="MetaKeyword" class="inputbox" ><?= stripslashes($arryCategory[0]['MetaKeyword']); ?></Textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Meta Description : </td>
                                                <td align="left" valign="top">
                                                    <Textarea name="MetaDescription" id="MetaDescription" class="inputbox"  ><? echo stripslashes($arryCategory[0]['MetaDescription']); ?></Textarea>
                                                </td>
                                            </tr>


                                            <tr> 
                                                <td   align="right" valign="top"    class="blackbold"> 
                                                    Image : </td>
                                                <td  height="50" align="left" valign="top" class="blacknormal"> 
                                                    <input name="Image" type="file" class="inputbox" id="Image" size="19"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                                    <br>
                                                    (Note : Supported file types for image are: jpg, gif.) </td>
                                            </tr>
                                            <?php

$MainDir = $Prefix."upload/category/".$_SESSION['CmpID']."/";                         

if($arryCategory[0]['Image'] != '' && file_exists($MainDir.$arryCategory[0]['Image'])) {
   $ImageExist = 1;
   $OldImage = $MainDir . $arryCategory[0]['Image'];                                          
?>
        <tr > 
            <td  align="right"  class="blackbold" valign="top"></td>
            <td  height="30" align="left"> 
<span id="DeleteSpan">
<input type="hidden" name="OldImage" value="<?=$OldImage?>">                          
                    <a data-fancybox-group="gallery" class="fancybox" href="<?=$MainDir.$arryCategory[0][Image]?>"><? echo '<img src="resizeimage.php?w=200&h=200&img='.$MainDir.$arryCategory[0]['Image'] . '" border=0 >'; ?></a>&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryCategory[0]['Image']?>','DeleteSpan')" onmouseout="hideddrivetip();">
<?=$delete?></a>		
                  
</span>

            </td>
        </tr>
 <? } ?>



                                            <tr >
                                                <td align="right" valign="middle"  class="blackbold">Status : </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($CategoryStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($CategoryStatus == 0) ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Sort Order :</td>
                                                <td align="left" valign="top">
                                                    <input  name="sort_order" id="sort_order" value="<?= stripslashes($arryCategory[0]['sort_order']) ?>" type="text" class="inputbox"  size="30" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Description :</td>
                                                <td align="left" valign="top"  class="editor_box">
                                                    <Textarea name="CategoryDescription" id="CategoryDescription" class="inputbox"  ><? echo stripslashes($arryCategory[0]['CategoryDescription']); ?></Textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'CategoryDescription';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Submit'; ?>
                            <input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $_GET['edit']; ?>">   
                            <input name="Submit" type="submit" class="button" id="addCategory" value="<?= $ButtonTitle ?>" />&nbsp;
                        </td>
                    </tr>
                </table>
               </form>
            </td>
          
        </tr>
    
</table>
