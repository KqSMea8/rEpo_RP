<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>


<div class="had">
<?=$ModuleName?>   <span>&raquo;
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
                                                   Menu Type : </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="MenuTypeId" id="MenuTypeId" class="inputbox">													
													<?php
													
															
													foreach ($MenutypeArr as $key => $values) {
													 	echo '<option value="'.$values['MenuTypeId'].'" ';
														echo ($values['MenuTypeId'] == $arryMenu[0]['MenuTypeId']) ? "selected" : "";
														echo '>'.$values['MenuType'].'</option>';
													  	
													 }
													?>
													</select>
                                                    
                                                </td>
                                            </tr>
											
											 <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Parent Menu : </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="ParentId" id="ParentId" class="inputbox">
													<option value="0">Root Menu</option>
													<?php
													$webcmsObj->getParentMenus(0,0,$arryMenu[0]['ParentId'],$CustomerID);	
													 /*foreach ($MainParentArr as $key => $values) {
													 	echo '<option value="'.$values['MenuId'].'">'.$values['Name'].'</option>';
													  	
													 }*/
													?>
													</select>
                                                    
                                                </td>
                                            </tr>
											
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Menu Name :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?= stripslashes($arryMenu[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Alias : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Alias" id="Alias" value="<?= stripslashes($arryMenu[0]['Alias']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Priority (used for sorting) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" onkeypress="return isNumberKey(event)" value="<?= stripslashes($arryMenu[0]['Priority']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Content :</td>
                                                <td width="56%"  align="left" valign="top">
													<select name="Link" id="Link" class="inputbox">													
													<?php
													
															
													foreach ($ArticlesArray as $key => $values) {
													 	echo '<option value="'.$values['ArticleId'].'"';
														echo ($values['ArticleId'] == $arryMenu[0]['Link']) ? "selected" : "";
														echo '>'.$values['Title'].'</option>';
													  	
													 }
													?>
													</select>
                                                    
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Meta Keywords :</td>
                                                <td width="56%"  align="left" valign="top">
													 <textarea style="width:60%; height: 85px;" class="inputbox" id="MetaKeywords" name="MetaKeywords"><?= stripslashes($arryMenu[0]['MetaKeywords']) ?></textarea>
                                                   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Meta Title :</td>
                                                <td width="56%"  align="left" valign="top">
												 <textarea style="width:60%; height: 85px;" class="inputbox" id="MetaTitle" name="MetaTitle"><?= stripslashes($arryMenu[0]['MetaTitle']) ?></textarea>
                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Meta Description :</td>
                                                <td width="56%"  align="left" valign="top">
												 <textarea style="width:60%; height: 85px;" class="inputbox" id="MetaDescription" name="MetaDescription"><?= stripslashes($arryMenu[0]['MetaDescription']) ?></textarea>
                                                  
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
                            <input type="hidden" name="MenuId" id="MenuId" value="<?= $MenuId; ?>" />
                             <input type="hidden" name="CustomerID" id="CustomerID" value="<?php echo $CustomerID;?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
