<div class="had"><?=$MainModuleName; ?></div>

              <form name="form1" action="" method="post"  enctype="multipart/form-data" onSubmit="return ValidateForm(this);"> 
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" class="message">
                            <?php if ($_SESSION['mess_setting'] != "") { ?><?= $_SESSION['mess_setting'];
                               unset($_SESSION['mess_setting']); ?><?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" >
                         
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">

<tr>
        <td  align="left"   class="head" colspan="2">General Setting</td>
      
      </tr>


                                <tr>
                                    <td align="center" valign="top" >

                                        <?php
                            
                                        if (count($arrySettingFields) > 0) { ?>
                                            <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                                <?php foreach ($arrySettingFields as $field) { 
                                                    $it = strtolower($field["input_type"]);
                                                    if($field["FixedCol"] != '1')
                                                    {
                                                    ?>
                                                    <tr>
                                                        <td width="45%" align="right" valign="top"  class="blackbold"> 
                                                            <?= $field['caption'] ?> : <?php if($field['validation'] == "Yes") { ?><span class="red">*</span> <?php }?> </td>
                                                     
                                                        <td width="56%"  align="left" valign="top">
                                                            <?php
                                                            switch ($it) {
                                                                case "select" : {
                                                                        $v = explode(",", $field["options"]);
                                                                        $short = strtolower($field["options"]) == 'yes, no' || strtolower($field["options"]) == 'yes,no';
                                                                        ?><select name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" class="inputbox">

                                                                        <?php
                                                                        for ($i = 0; $i < count($v); $i++) {
                                                                            $v[$i] = trim($v[$i]);
                                                                            if ($v[$i] != "") {
                                                                                echo '<option value="' . $v[$i] . '" ' . ($field["setting_value"] == $v[$i] ? "selected=\"selected\"" : "") . '>' . ucfirst(strtolower($v[$i])) . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                        </select>
                                                                            <?php
                                                                            break;
                                                                        }
                                                                    case "textarea" : {
                                                                            ?>
                                                                        <textarea name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>"><?=$field["setting_value"];?></textarea>
                                                                        <?php
                                                                        break;
                                                                    }

                                                                default :
							 case "checkbox" : {
                                                                            ?>
                                                                      <input type="checkbox" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" value="1"  
<?if($field["setting_value"]==1) echo 'checked';?>>
                                                                        <?php
                                                                        break;
                                                                    }

                                                                default :
                                                                case "text" : { 
                                                                        ?>
                                                                        <input type="text" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" class="inputbox" value="<?=$field["setting_value"]?>" <?=$field["options"]?>>
                                                                        <?php
                                                                        break;
                                                                    }
                                                            }
                                                                
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                        <?php } ?>
                                                    
                                                   









                                            </table>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                         

                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <input name="Submit" type="submit" class="button" id="SaveSettings" value="Save" />&nbsp;
                        </td>   
                    </tr>

                </table>
               </form>
         

<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm){
	ShowHideLoader('1','S');
	return true;
}

</SCRIPT>
