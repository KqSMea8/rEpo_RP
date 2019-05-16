<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action=""  method="post" onSubmit="return validateElement(this);" enctype="multipart/form-data">
        <tr>
            <td  align="center" valign="top" >

                <table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">Element Details</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> Element Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <?php 

$element_name = (!empty($arryElement->element_name))?($arryElement->element_name):('');
 
echo $FormHelper->input(__('element_name'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'ElementName', 'maxlength' => 50, 'value' => stripslashes($element_name)));
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Element Slug  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <?php 
 $element_slug = (!empty($arryElement->element_slug))?($arryElement->element_slug):('');

echo $FormHelper->input(__('element_slug'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'element_slug', 'maxlength' => 50, 'value' => stripslashes($element_slug))); ?>
                        </td>
                    </tr>
                    
                     <tr>
                        <td  align="right"   class="blackbold"> Element Type  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <?php 

 $element_type = (!empty($arryElement->type))?($arryElement->type):('');


echo $FormHelper->input(__('type'), array('type' => 'select', 'options'=>array('text'=>'Text',
                                'number'=>'Number','textarea'=>'TextArea','select'=>'SelectBox','checkbox'=>'Checkbox','radio'=>'Radio'),'class' => 'inputbox', 'id' => 'type', 'value' => '', 'maxlength' => 50, 'selected' => stripslashes( $element_type))); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Description  :</td>
                        <td  align="left" >
                            <?php 

 $description = (!empty($arryElement->description))?($arryElement->description):('');

echo $FormHelper->input(__('description'), array('type' => 'textarea', 'class' => 'inputbox', 'id' => 'description', 'maxlength' => 50, 'value' => stripslashes($description))); ?>
                        </td>
                    </tr>	

                    <tr>
                        <td  align="right"   class="blackbold" 
                             >Status  : </td>
                        <td   align="left"  >
                            <?php
                            $ActiveChecked = ' checked';$InActiveChecked = '';
                            if ($_GET['edit'] > 0) {
                                if ($arryElement->status == 1) {
                                    $ActiveChecked = ' checked';
                                    $InActiveChecked = '';
                                }
                                if ($arryElement->status == 0) {
                                    $ActiveChecked = '';
                                    $InActiveChecked = ' checked';
                                }
                            }
                            ?>
                            <label><input type="radio" name="status" id="status" value="1" <?= $ActiveChecked ?> />
                                Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="status" id="status" value="0" <?= $InActiveChecked ?> />
                                InActive</label> 
                        <?php //echo $arryElement->status;//echo $arryElement->element_slug;?>
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

                    <?php if ($_GET['edit'] > 0)
                        $ButtonTitle = 'Update ';
                    else
                        $ButtonTitle = ' Submit ';
                    ?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="element_id" id="element_id" value="<?= $_GET['edit'] ?>" />
                </div>

            </td>
        </tr>
    </form>
</table>
