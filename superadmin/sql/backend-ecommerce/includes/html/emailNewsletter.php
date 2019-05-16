<script type="text/javascript" src="../../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had"> <?= $ModuleTitle; ?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="top">
            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <div class="message"><? if (!empty($_SESSION['mess_Subscriber'])) {
    echo stripslashes($_SESSION['mess_Subscriber']);
    unset($_SESSION['mess_Subscriber']);
} ?></div>
                        <form name="form1" action="" method="post" onSubmit="javascript:return ValidateForm(this);"  enctype="multipart/form-data">   
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1" >

                                            <tr>
                                                <td colspan="2" align="left" valign="top"  class="blackbold"> 
                                                    <div class="admin-form-header first"><span class="icon ic-icon ic-checkmark"></span>Newsletter Email Template</div>
                                            </tr>

                                            <tr>
                                                <td width="35%" align="right"  valign="top"  class="blackbold"  style="padding-top:8px;"  >
                                                    Select Template :</td>
                                                <td align="left">
                                                    <select name="Previous_Template" id="Previous_Template" class="inputbox">
                                                        <option value="0">Select Template</option> 
                                                        <?php if (count($previousTemplate) > 0) { ?>
                                                            <?php foreach ($previousTemplate as $key) { ?>
                                                                <option value="<?= $key['Templapte_Id'] ?>" <?php if ($_GET['template_id'] == $key['Templapte_Id']) {
                                                            echo "selected";
                                                        } ?>><?= $key['Template_Name'] ?></option> 
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value="0">No Template Created</option>
<?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1" <?php if ($_GET['template_id'] > 0) { ?>style="display: block;" <?php } else { ?> style="display: none;" <?php } ?>>
                                            <tr>
                                                <td colspan="2" align="left" valign="top"  class="blackbold"> 
                                                    <div class="admin-form-header first"><span class="icon ic-icon ic-checkmark"></span>Newsletter Email Properties</div>
                                            </tr>
                                            <tr>
                                                <td width="20%" align="right" valign="top"  class="blackbold"  style="padding-top:8px;"  >
                                                    Send Email To : <span class="red">*</span>&nbsp;</td>
                                                <td align="left">
                                                    <select name="ToEmail" id="ToEmail" class="inputbox">
                                                        <option value="allSubscriber">All Subscriber</option> 
                                                        <option value="selectedSubscriber">Selected Subscriber</option> 
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr style="display:none;" id="subscribeUserLists">
                                                <td  align="left" colspan="2"  valign="top">

                                                    <table width="97%"  style="border:1px solid #ccc;">
                                                        <tr>
                                                            <td class="a-to-z-list">
                                                                <div style="position: relative; overflow: hidden; height: 130px;">
                                                                    <?
                                                                    for ($i = 65; $i <= 90; $i = $i + 1) {
                                                                        print "<div style='float: left;'><a href='Javascript:;' class='chr'>" . chr($i) . "</a>";
                                                                        print "<div class='chrEmail' id='chr_" . chr($i) . "' style='left: 0; border: 0px solid rgb(255, 0, 0); display: block; width: 800px; height: 100px; position: absolute; margin-top: 8px; overflow-y: scroll; overflow-x: hidden;'></div></div>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Other Email : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Other_Email" id="Other_Email" value="" type="text" class="inputbox" />
                                                    <span>(You can add other email addresses, separated by comma)</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Subject :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Subject" id="Subject" value="<?= $arrayTemplateByID[0]['Template_Subject']; ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    From Name :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    From Email :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="From_Email" id="From_Email" value="" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" valign="top"  class="blackbold">
                                                    <div class="admin-form-header editor-manager"><div class="admin-form-header-buttons"><span class="icon ic-icon ic-pencil editor-switch"></span></div>Content for  Email</div>
                                                </td>

                                            </tr>


                                            <tr>

                                                <td  colspan="2" class="editor_box" align="right" valign="top">
                                                    <textarea id="Html_Content" name="Html_Content" rows="15" cols="80"><?= $arrayTemplateByID[0]['Template_Content']; ?></textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'Html_Content';

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
                                            <!--<tr>
                                            <td align="center" height="15" valign="top"><br>
                                               <input type="checkbox" name="save_template" id="save_template" value="Yes">&nbsp;Do You Want To Save Template&nbsp;&nbsp; 
                                               </td>
                                        </tr>
                                           <tr style="display:none;" id="template_box">

                                                <td width="56%" align="center" valign="top">
                                                    Template Name<span class="red">*</span> &nbsp;&nbsp;<input  name="Template_Name" id="Template_Name" value="" type="text" class="inputbox" />
                                                </td>
                                             </tr>-->
                                            <tr>
                                                <td align="center"  height="135" valign="top"><br>

                                                    <input name="btnSubmit" type="submit" class="button" id="btnSendNewsletter" value="Send Newsletter" />&nbsp;
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>

                            </table>
                        </form>
                    </td>
                </tr>


            </table>
        </td>
    </tr>

</table>

