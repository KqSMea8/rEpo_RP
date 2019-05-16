<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For package_form.php
 */
//print_r($arryPackage);
//echo stripslashes($arryPackage->pckg_name);
?>
<script type="text/javascript" src="../../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action=""  method="post" onSubmit="" enctype="multipart/form-data">
        <tr>
            <td  align="center" valign="top" >

                <table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">Package Details Form</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> Plan Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <?php echo $FormHelper->input(__('pckg_name'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_name', 'maxlength' => 50, 'value' => stripslashes($arryPackage->pckg_name)));
                            ?>
                        </td>
                    </tr>
		<tr>
                        <td  align="right"   class="blackbold"> Plan Title  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <?php echo $FormHelper->input(__('pckg_title'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_title', 'maxlength' => 50, 'value' => stripslashes($arryPackage->plan_title)));
                            ?>

                        </td>

                    </tr>
                  <tr>
                        <td  align="right"   class="blackbold"> Package Price  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <?php echo $FormHelper->input(__('pckg_price'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_price', 'maxlength' => 50, 'value' => stripslashes($arryPackage->pckg_price))); ?>
                        </td>
                    </tr>
			<tr>
                        <td  align="right"   class="blackbold"> Plan Duration  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <?php echo $FormHelper->input(__('pckg_duration'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_duration', 'maxlength' => 50, 'value' => stripslashes($arryPackage->package_time)));
                            ?>

                        </td>
                   	 </tr>
<tr><td colspan="2">&nbsp;</td></tr>
			 <tr>
                        <td  align="right"   class="blackbold" valign="top"> Package Feature  :<span class="red">*</span> </td>
                        <td   align="left" >

		<textarea
									name="pckg_tagline" id="pckg_tagline">
									<?php echo stripslashes($arryPackage->package_feature); ?>
													</textarea>
                           
<script type="text/javascript">

                                                        var editorName = 'pckg_tagline';
                                                        
                                                        var editor = new ew_DHTMLEditor(editorName);
                                                        
                                                        editor.create = function() { 
                                                            var sBasePath = '../../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '850', 300, 'custom');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>
                            <?php /*echo $FormHelper->input(__('pckg_tagline'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_tagline', 'maxlength' => 50, 'value' => stripslashes($arryPackage->pckg_tagline)));*/ ?>
                        </td>
                    </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td align="right"   class="blackbold" valign="top" >Description  :<span class="red">*</span></td>
			

                        <td  align="left"  class="editor_box">
					<textarea
									name="pckg_description" id="pckg_description">
									<?php echo stripslashes($arryPackage->pckg_description); ?>
													</textarea>
                            <?php /*echo $FormHelper->input(__('pckg_description'), array('type' => 'textarea', 'class' => '', 'id' => 'pckg_description',  'value' => stripslashes($arryPackage->pckg_description)));*/ ?>
<script type="text/javascript">

                                                        var editorName = 'pckg_description';
                                                        
                                                        var editor = new ew_DHTMLEditor(editorName);
                                                        
                                                        editor.create = function() { 
                                                            var sBasePath = '../../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '850', 300, 'custom');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>
                        </td>
                    </tr>
                    <?php
                   /* if (!empty($arryElement)) {
                        foreach ($arryElement as $arryElem) {
                            echo '<tr>';
                            echo ' <td align="right"   class="blackbold" valign="top">' . $arryElem->element_name . '  :<span class="red">*</span></td>';
                            $name = $arryElem->element_slug;
                            $type = $arryElem->type;
                            $elementarray = array('type' => $type, 'class' => 'inputbox', 'id' => $name, 'maxlength' => 50, 'value' => $tempdata);
                           
                            if (in_array($type, array('select', 'checkbox', 'radio'))) {
                                $options = explode(',', $arryElem->description);
                                $options = array_combine($options, $options);
                                $elementarray['options'] = $options;
				if($type=='select')
 				$elementarray['selected']=$tempdata[$arryElem->element_slug];
				else
				$elementarray['checked']=explode(',',$tempdata[$arryElem->element_slug]);
                                
                            }else if(!empty($tempdata)){
                                  $elementarray['value']=$tempdata[$arryElem->element_slug];                                
                            }

                            echo '<td  align="left" >' . $FormHelper->input(__('element[' . $name . ']'), $elementarray) . '</td>';
                            echo '</tr>';
                        }
                    }*/
                    ?>

                    <tr>
                        <td  align="right"   class="blackbold" 
                             >Status  : </td>
                        <td   align="left"  >
                            <?php
                            $ActiveChecked = ' checked';
                            if ($_REQUEST['edit'] > 0) {
                                if ($arryPackage->status == 1) {
                                    $ActiveChecked = ' checked';
                                    $InActiveChecked = '';
                                }
                                if ($arryPackage->status == 0) {
                                    $ActiveChecked = '';
                                    $InActiveChecked = ' checked';
                                }
                            }
                            ?>
                            <label><input type="radio" name="status" id="status" value="1" <?= $ActiveChecked ?> />
                                Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="status" id="status" value="0" <?= $InActiveChecked ?> />
                                InActive</label> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">&nbsp;
            </td>
        </tr>
        <tr>
            <td  align="center">

                <div id="SubmitDiv" style="display:none1">

                    <?php
                    if ($_GET['edit'] > 0)
                        $ButtonTitle = 'Update ';
                    else
                        $ButtonTitle = ' Submit ';
                    ?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="pckg_id" id="pckg_id" value="<?= $_GET['edit'] ?>" />
                </div>

            </td>
        </tr>
    </form>
</table>


