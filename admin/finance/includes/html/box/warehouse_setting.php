<? 
$arrySettingFields = $objCommon->getSettingsFields($valuesDept['depID'],$group_id=1);
$BoxClassDisabled='class="disabled inputbox" readonly';
foreach ($arrySettingFields as $key => $values) {
	$arrySettingPVal[$values['setting_key']] = $values['setting_value'];
}

?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0"  >
<tr>
  <td  valign="top" >

                 
        <?php 
$CountP=0;
foreach ($arrySettingFields as $field) { 
            $it = strtolower($field["input_type"]);
            if($field["FixedCol"] != '1')
            {
  
		$CountP++;
		if($CountP=='1') echo '<tr>';

/****Check Purchase Existance************/
$BoxClass='class="inputbox"';
if(substr_count($field["setting_key"],"_START")==1){
	switch($field["setting_key"]){
		case 'REC_P_START':
			if($objCommon->isPurchaseExist('Receipt')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'SHIP_START':
			if($objCommon->isSalesExist('Shipment')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'RMA_C_START':
			if($objCommon->isCustomerRmaExist('Receipt')){
				$BoxClass = $BoxClassDisabled;
			}
			break;

		case 'RMA_V_START':
			if($objCommon->isVendorRmaExist('Receipt')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'WO_START':
			if($objCommon->isWorkOrderExist()){ 
				$BoxClass = $BoxClassDisabled;
			}
			break;

		case 'PICK_START':
			if($objCommon->isPickingExist()){
				$BoxClass = $BoxClassDisabled;
			}
			break;		


	}
}
/************************************/                                                  ?>
                                                     
                                                        <td width="20%" height="30"  align="right" valign="top"  class="blackbold"> 
                                                            <?= $field['caption'] ?> : <?php if($field['validation'] == "Yes") { ?><span class="red">*</span> <?php }?> </td>
                                                     
                                                        <td width="30%"  align="left" valign="top">
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
                                                                        <input type="text" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" <?=$BoxClass?> value="<?=$field["setting_value"]?>" <?=$field["options"]?>>
                                                                        <?php
                                                                        break;
                                                                    }
                                                            }
                                                                
                                                            ?>
                                                        </td>
                                                   
   <?php 

		} 
		if($CountP%2==0) echo '</tr><tr>';
	}

 
?>
    
 


</table> 
