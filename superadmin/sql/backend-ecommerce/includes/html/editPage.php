<script type="text/javascript" src="../../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had"> <?= $ModuleTitle; ?></div>
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
                                                    Page Name (for Menu)  :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top"><input  name="Name" id="Name" value="<?= stripslashes($arryPage[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
 <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Display Menu  :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
					<select name="DisplayMenu" id="DisplayMenu" class="inputbox">
						<option value="">Select</option>
						<option value="Header" <?php if($arryPage[0]['DisplayMenu']=="Header"){ echo "selected";}?>>Header</option>
						<option value="Footer" <?php if($arryPage[0]['DisplayMenu']=="Footer"){ echo "selected";}?>>Footer</option>
						<option value="Both" <?php if($arryPage[0]['DisplayMenu']=="Both"){ echo "selected";}?>>Both</option>
					</select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Page Title :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Title" id="Title" value="<?= stripslashes($arryPage[0]['Title']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Priority (used for sorting) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" value="<?= stripslashes($arryPage[0]['Priority']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Page URL (custom) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="UrlCustom" id="UrlCustom" value="<?= stripslashes($arryPage[0]['UrlCustom']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Meta Keywords :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <textarea  name="MetaKeywords" id="MetaKeywords"  class="inputbox" style="width:60%; height: 85px;" ><?= stripslashes($arryPage[0]['MetaKeywords']) ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Meta Title :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <textarea  name="MetaTitle" id="MetaTitle" class="inputbox" style="width:60%; height: 85px;"><?= stripslashes($arryPage[0]['MetaTitle']) ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Meta Description :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <textarea  name="MetaDescription" id="MetaDescription" class="inputbox" style="width:60%; height: 85px;"><?= stripslashes($arryPage[0]['MetaDescription']) ?></textarea>
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
<tr>
                                                <td width="30%"  colspan="2" align="left"  valign="top"  class="blackbold"> 
                                                    Page Content :</td>
                                              </tr>
                                            <tr>
   
                                              
                                                
                                                <td  colspan="2" align="left" valign="top"  class="editor_box">

                                                    <textarea name="page_content" id="full_text"><?= stripslashes($arryPage[0]['Content']) ?></textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'full_text';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../../FCKeditor/';
                                                            
                                                            var oFCKeditor = new FCKeditor(editorName, '1000', 500, 'Default');
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


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                            <input type="hidden" name="PageId" id="PageId" value="<?= $PageId; ?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
