<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had"> <?=$ModuleTitle;?></div>
 <form name="form1" action="" method="post"  enctype="multipart/form-data">
<TABLE WIDTH=768   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   <TR>
            <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Page Name (for Menu)  <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?= stripslashes($arryPage[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Page Title <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Title" id="Title" value="<?= stripslashes($arryPage[0]['Title']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Priority (used for sorting) </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" value="<?= stripslashes($arryPage[0]['Priority']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                              Page URL (custom) </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="UrlCustom" id="UrlCustom" value="<?= stripslashes($arryPage[0]['UrlCustom']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Meta Keywords </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="MetaKeywords" id="MetaKeywords" value="<?= stripslashes($arryPage[0]['MetaKeywords']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Meta Title </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="MetaTitle" id="MetaTitle" value="<?= stripslashes($arryPage[0]['MetaTitle']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>
                                             <tr>
                                               <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Meta Description </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="MetaDescription" id="MetaDescription" value="<?= stripslashes($arryPage[0]['MetaDescription']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>
                                             
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status  </td>
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
                                               <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Page Content </td>
                                                <td width="56%"  align="left" valign="top">
                                                    
                                                 <textarea name="page_content" id="page_content"><?= stripslashes($arryPage[0]['Content']) ?></textarea>
                                                  <script type="text/javascript">

                                                                var editorName = 'page_content';

                                                                var editor = new ew_DHTMLEditor(editorName);

                                                                editor.create = function() {
                                                                    var sBasePath = '../FCKeditor/';
                                                                    var oFCKeditor = new FCKeditor(editorName, '410', 200, 'custom');
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
                           <? if ($_GET['edit'] > 0) {$ButtonTitle = 'Update';} else{ $ButtonTitle = 'Submit';}?>
                            <input type="hidden" name="PageId" id="PageId" value="<?=$PageId;?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />&nbsp;
                           
                    </tr>

                </table></TD>
        </TR>
    
</TABLE>
</form>
<SCRIPT LANGUAGE=JAVASCRIPT>
    $(document).ready(function() {
   $("#SubmitPage").click(function(){
       
            var Name = $.trim($("#Name").val());
            var Title = $.trim($("#Title").val());
           
           
  if(Name == "")
       {
           alert("Please enter page name");
           $("#Name").focus();
           return false;
       }
       
     if(Title == "")
       {
           alert("Please enter page title");
           $("#Title").focus();
           return false;
       }
     
   
       });
    }); 
</SCRIPT>