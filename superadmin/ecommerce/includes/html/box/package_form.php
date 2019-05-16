<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For package_form.php
 */
//print_r($arryPackage);
//echo stripslashes($arryPackage->pckg_name);
?>
   <form name="form1" action=""  method="post" onSubmit="" enctype="multipart/form-data">
<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
 
        <tr>
            <td  align="center" valign="top" >

                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">Package Details Form</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> Package Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <?php 
 $pckg_name = (!empty($arryPackage->pckg_name))?($arryPackage->pckg_name):('');

echo $FormHelper->input(__('pckg_name'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_name', 'maxlength' => 50, 'value' => stripslashes($pckg_name)));
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Package Tagline  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <?php 
 $pckg_tagline = (!empty($arryPackage->pckg_tagline))?($arryPackage->pckg_tagline):('');

echo $FormHelper->input(__('pckg_tagline'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_tagline', 'maxlength' => 50, 'value' => stripslashes($pckg_tagline))); ?>
                        </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Package Duration  (in days):<span class="red">*</span> </td>
                        <td   align="left" >

                            <?php 
 $package_time = (!empty($arryPackage->package_time))?($arryPackage->package_time):('');
echo $FormHelper->input(__('package_time'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'package_time', 'maxlength' => 50, 'value' => stripslashes($package_time))); ?> 
                        </td>
                    </tr>
  					<tr>
                        <td  align="right"   class="blackbold"> Package Price  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <?php 
 $pckg_price = (!empty($arryPackage->pckg_price))?($arryPackage->pckg_price):('');
echo $FormHelper->input(__('pckg_price'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'pckg_price', 'maxlength' => 50, 'value' => stripslashes($pckg_price))); ?>
                        </td>
                    </tr>
                    <?php
                    if (!empty($arryElement)) {
                        foreach ($arryElement as $arryElem) {
                            echo '<tr>';
                            echo ' <td align="right"   class="blackbold" valign="top">' . $arryElem->element_name . '  :</td>';
	
			   $name = (!empty($arryElem->element_slug))?($arryElem->element_slug):('');
			   $type = (!empty($arryElem->type))?($arryElem->type):('');
                            
                            $elementarray = array('type' => $type, 'class' => 'inputbox', 'id' => $name, 'maxlength' => 50, 'value' => $tempdata);
                           
			  $element_slug = (!empty($tempdata[$name]))?($tempdata[$name]):('');


                            if (in_array($type, array('select', 'checkbox', 'radio'))) {
                                $options = explode(',', $arryElem->description);
                                $options = array_combine($options, $options);
                                $elementarray['options'] = $options;
				if($type=='select')
 				$elementarray['selected']=$element_slug;
				else
				$elementarray['checked']=explode(',',$element_slug);
                                
                            }else if(!empty($tempdata)){
                                  $elementarray['value']=$element_slug;                                
                            }

                            echo '<td  align="left" >' . $FormHelper->input(__('element[' . $name . ']'), $elementarray) . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>

                    <tr>
                        <td  align="right"   class="blackbold" 
                             >Status  : </td>
                        <td   align="left"  >
                            <?php
                            $ActiveChecked = ' checked'; $InActiveChecked = '';
                            if ($_GET['edit'] > 0) {
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
                    
                    <tr>
						<td width="30%" colspan="2" align="left" valign="top"
									class="blackbold">Description :</td>
					</tr> <tr>	<td colspan="2" align="left" valign="top" class="editor_box" style="height: 300px;">
                            <?php 
 $pckg_description = (!empty($arryPackage->pckg_description))?($arryPackage->pckg_description):('');
echo $FormHelper->input(__('pckg_description'), array('type' => 'textarea', 'class' => '', 'id' => 'pckg_description', 'maxlength' => 50, 'value' => stripslashes($pckg_description))); ?>
                       
                        <script type="text/javascript">

                                                        var editorName = 'pckg_description';
                                                        
                                                        var editor = new ew_DHTMLEditor(editorName);
                                                        
                                                        editor.create = function() { 
                                                            var sBasePath = '../../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '1170', 300, 'custom');
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
  
</table>
  </form>

