<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had"><?=$MainModuleName?> <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span></div>
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
											<!-- <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Category : </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="CatId" id="CatId" class="inputbox">
													<option value="0">Select</option>
													<?php
												
													 foreach ($CategoriesArray as $key => $values) {
													 	echo '<option value="'.$values['CatId'].'" ';
														if($arryArticle[0]['CatId']==$values['CatId']) echo 'selected';
														echo ' >'.$values['Name'].'</option>';
													  	
													 }
													?>
													</select>
                                                    
                                                </td>
                                            </tr>-->
											
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Title :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Title" id="Title" value="<?=(!empty($arryArticle)) ? stripslashes($arryArticle[0]['Title']) : ''; ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            
                                           <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Priority (used for sorting) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" onkeypress="return isNumberKey(event)" value="<?=(!empty($arryArticle)) ? stripslashes($arryArticle[0]['Priority']) : '';?>" type="text" class="inputbox" />
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
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Form : </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="FormId" id="FormId" class="inputbox">
													<option value="">Select Form</option>
													<?php
												
													 foreach ($FormsArray as $key => $values) {
													 	echo '<option value="'.$values['FormId'].'" ';
												if(!empty($arryArticle) && $arryArticle[0]['FormId']==$values['FormId']) echo 'selected';
														echo ' >'.$values['FormName'].'</option>';
													  	
													 }
													?>
													</select>
                                                    
                                                </td>
                                            </tr>
                                            
											<tr>
                                                <td width="30%" colspan="2" align="left" valign="top"  class="blackbold"> 
                                                   Content :</td>
                                                
                                                </tr>
                                            <tr>
                                                
                                                <td colspan="2" align="left" valign="top" class="editor_box">

                                                    <textarea name="Fulltext" id="full_text"><?=(!empty($arryArticle)) ? stripslashes($arryArticle[0]['Fulltext']) : '';?></textarea>
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

                                       <!-- <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Content :</td>
                                                <td align="left" valign="top"  class="editor_box">
                                                    <Textarea name="Fulltext" id="Fulltext" class="inputbox"  ><? echo stripslashes($arryArticle[0]['Fulltext']); ?></Textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'Fulltext';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() { 
                                                            var sBasePath = '../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '610', 200, 'Basic');
                                                            oFCKeditor.BasePath = sBasePath;                                                            
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>

                                                </td>
                                            </tr>  -->   

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
                            <input type="hidden" name="ArticleId" id="ArticleId" value="<?= $ArticleId; ?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitArticle" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
