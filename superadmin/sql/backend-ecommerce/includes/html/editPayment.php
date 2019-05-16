<script type="text/javascript" src="../../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div class="had"> <?= $ModuleTitle; ?></div>
<form name="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="98%"   border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                              <tr>
                                                <td colspan="2"><div class="admin-form-header"><span class="icon ic-icon ic-payment"></span>Basic Settings</div></td>   
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                     Payment method name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="PaymentMethodName" id="PaymentMethodName" value="<?= stripslashes($arryPaymentMethod[0]['PaymentMethodName']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                      Payment method title :  <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="PaymentMethodTitle" id="PaymentMethodTitle" value="<?= stripslashes($arryPaymentMethod[0]['PaymentMethodTitle']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                           
                                             <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                      Payment page message :  </td>
                                                <td width="56%" class="editor_box" align="left" valign="top">
                                                    <textarea name="PaymentMethodMessage" id="PaymentMethodMessage" style=" border: 1px solid #DAE1E8; height: 100px; width: 325px;"><?= stripslashes($arryPaymentMethod[0]['PaymentMethodMessage']) ?></textarea>
                                                        <script type="text/javascript">

                                                        var editorName = 'PaymentMethodMessage';

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
                                             <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Thank you page message :  </td>
                                                <td width="56%" class="editor_box"  align="left" valign="top">
                                                    <textarea name="PaymentMethodDescription" id="PaymentMethodDescription" style=" border: 1px solid #DAE1E8; height: 100px; width: 325px;"><?= stripslashes($arryPaymentMethod[0]['PaymentMethodDescription']) ?></textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'PaymentMethodDescription';

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
                                             <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Priority :  </td>
                                                 <td width="56%"  align="left" valign="top">
                                                    <select name="Priority" id="Priority" class="inputbox">
                                                    <option value="1" <?php if($arryPaymentMethod[0]['Priority'] == "1"){ echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($arryPaymentMethod[0]['Priority'] == "2"){ echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($arryPaymentMethod[0]['Priority'] == "3"){ echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($arryPaymentMethod[0]['Priority'] == "4"){ echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($arryPaymentMethod[0]['Priority'] == "5"){ echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($arryPaymentMethod[0]['Priority'] == "6"){ echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($arryPaymentMethod[0]['Priority'] == "7"){ echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($arryPaymentMethod[0]['Priority'] == "8"){ echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($arryPaymentMethod[0]['Priority'] == "9"){ echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($arryPaymentMethod[0]['Priority'] == "10"){ echo "selected";}?>>10</option>
                                                </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status :  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="Yes" <?= ($PaymentStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($PaymentStatus == "No") ? "checked" : "" ?> value="No" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>  
                                            
                                            <?php if(count($arryPaypalSettingFields) > 0) { ?>
                                            <tr>
                                                <td colspan="2"><div class="admin-form-header"><span class="icon ic-icon ic-payment"></span>Advanced Settings</div></td>   
                                            </tr>
                                           
                                              <?php foreach ($arryPaypalSettingFields as $field) { 
                                                    $it = strtolower($field["input_type"]);
                                                    ?>
                                                    <tr>
                                                        <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                            <?= $field['Caption'] ?>  <?php if($field['Validation'] == "Yes") { ?><span class="red">*</span> <?php }?> </td>
                                                     
                                                        <td width="56%"  align="left" valign="top">
                                                            <?php
                                                            switch ($it) {
                                                                case "select" : {
                                                                        $v = explode(",", $field["Options"]);
                                                                        $short = strtolower($field["Options"]) == 'yes, no' || strtolower($field["Options"]) == 'yes,no';
                                                                        ?><select name="<?= $field["Name"] ?>" id="<?= $field["Name"] ?>" class="inputbox">

                                                                        <?php
                                                                        for ($i = 0; $i < count($v); $i++) {
                                                                            $v[$i] = trim($v[$i]);
                                                                            if ($v[$i] != "") {
                                                                                echo '<option value="' . $v[$i] . '" ' . ($field["Value"] == $v[$i] ? "selected=\"selected\"" : "") . '>' . $v[$i] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                        </select>
                                                                            <?php
                                                                            break;
                                                                        }
                                                                    case "textarea" : {
                                                                            ?>
                                                                        <textarea name="<?= $field["Name"] ?>" id="<?= $field["Name"] ?>"><?=$field["Value"];?></textarea>
                                                                        <?php
                                                                        break;
                                                                    }

                                                                default :
                                                                case "text" : { 
                                                                        ?>
                                                                        <input type="text" name="<?= $field["Name"] ?>" id="<?= $field["Name"] ?>" class="inputbox" value="<?=$field["Value"];?>">
                                                                        <?php
                                                                        break;
                                                                    }
                                                            }
                                                           /* if (trim($field["Description"] != "")) {
                                                                ?>
                                                                <div class="formItemComment">
                                                                <?= str_replace("\n", '<br/>', htmlspecialchars(str_replace("<br/>", "\n", $field["Description"]))) ?>
                                                                </div>
                                                                <?php
                                                            }*/
                                                            ?>
                                                        </td>
                                                    </tr>

                                                        <?php }
                                                        
                                            }?>
                                            
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <input type="hidden" name="PaymentID" id="PaymentID" value="<?= $PaymentID; ?>" />
                            <input name="Submit" type="submit" class="button" id="UpdatePaymentSettings" value="Save Changes" />&nbsp;
                        </td>  
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
