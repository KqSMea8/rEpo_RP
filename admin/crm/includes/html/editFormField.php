
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
                                                   Select Form : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="FormId" id="FormId" class="inputbox">
													<option value="">Select Form</option>	
													<?php
													foreach ($arryForms as $key => $values) {
													 	echo '<option value="'.$values['FormId'].'" ';
														echo (!empty($arryFormField) && $values['FormId'] == $arryFormField[0]['FormId']) ? "selected" : "";
														echo '>'.$values['FormName'].'</option>';
													  	
													 }
													?>
													</select>
                                                    
                                                </td>
                                            </tr>
											
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Field Type : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="FieldType" id="FieldType" class="inputbox" onchange="validatevalues();">		
													<option value="">Select Field Type</option>											
													<?php
													
															
													foreach ($FieldArray as $key => $values) {
													 	echo '<option value="'.strtolower($values).'" ';
														echo (!empty($arryFormField) && strtolower($values) == $arryFormField[0]['FieldType']) ? "selected" : "";
														echo '>'.$values.'</option>';
													  	
													 }
													?>
													</select>
                                                    
                                                </td>
                                            </tr>
											
											 
											
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Field Name :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="FieldName" id="FieldName" value="<?=(isset($arryFormField[0]['FieldName'])) ? stripslashes($arryFormField[0]['FieldName']) : ''; ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Field Label :<span class="red">*</span></td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Fieldlabel" id="Fieldlabel" value="<?=(isset($arryFormField[0]['Fieldlabel'])) ? stripslashes($arryFormField[0]['Fieldlabel']) : ''; ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            
                                            <?php 
                                            $style='style="display:none"';
                                            if((!empty($arryFormField)) && ($arryFormField[0]['FieldType']=='checkbox' || $arryFormField[0]['FieldType']=='radio' || $arryFormField[0]['FieldType']=='dropdown')){
                                            	$style='';
                                            }
                                            ?>
                                            <tr <?php echo $style; ?>id="Fieldvaluestr">
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Field Values (add comma seperated value)  :</td>
                                                <td width="56%"  align="left" valign="top">
													 <textarea style="width:60%; height: 85px;" class="inputbox" id="Fieldvalues" name="Fieldvalues"><?=(isset($arryFormField[0]['Fieldvalues'])) ? stripslashes($arryFormField[0]['Fieldvalues']) : ''; ?></textarea>
                                                   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Priority (used for sorting) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" onkeypress="return isNumberKey(event)" value="<?=(isset($arryFormField[0]['Priority'])) ? stripslashes($arryFormField[0]['Priority']) : ''; ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Manadatory :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Manadatory" id="Manadatory" value="1" type="checkbox" <?php echo (!empty($arryFormField) && $arryFormField[0]['Manadatory'] == 'Yes') ? "checked" : "";?> />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status  :</td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= (isset($FieldStatus) && $FieldStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= (isset($FieldStatus) && $FieldStatus == "No") ? "checked" : "" ?> value="0" /></td>
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
                            <input type="hidden" name="FieldId" id="FieldId" value="<?= $FieldId; ?>" />
                            <input type="hidden" name="CustomerID" id="CustomerID" value="<?php echo $CustomerID;?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitFormField" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
function validatevalues(){
	 var FieldType = $.trim($("#FieldType").val());
	 if( FieldType== 'checkbox' || FieldType== 'radio' || FieldType== 'dropdown'){
		 $("#Fieldvaluestr").show()
	 }
	 else{
		 $("#Fieldvaluestr").hide()
	 }
}
</script>
