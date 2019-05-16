<script type="text/javascript" src="../../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had"> <?= $ModuleTitle; ?></div>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="top">
            <form name="form1" action="" method="post"  enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Template Name :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Template_Name" id="Template_Name" value="<?= stripslashes($arryNewsletterTemplate[0]['Template_Name']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Template Subject :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Template_Subject" id="Template_Subject" value="<?= stripslashes($arryNewsletterTemplate[0]['Template_Subject']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" align="left" valign="top"  class="blackbold">
                                                    Content for Email :
                                                </td>

                                            </tr>


                                            <tr>

                                                <td  colspan="2" class="editor_box" align="right" valign="top">
                                                 
                                                    <Textarea name="Template_Content" id="Template_Content" class="inputbox"><?= stripslashes($arryNewsletterTemplate[0]['Template_Content']) ?></Textarea>
                                                     <script type="text/javascript">

                                                        var editorName = 'Template_Content';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'custom');
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
                                                <td align="right" valign="middle"  class="blackbold"> Status  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="Yes" <?= ($TemplateStatus == "Yes") ? "checked" : "checked" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($TemplateStatus == "No") ? "checked" : "" ?> value="No" /></td>
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
                            <input type="hidden" name="TemplateId" id="TemplateId" value="<?= $TemplateId; ?>" />
                            <input name="Submit" type="submit" class="button" id="UpdateNewsletterTemplate" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>
                    </tr>

                </table>
            </form>
        </td>
    </tr>

</table>
