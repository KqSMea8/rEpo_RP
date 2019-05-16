<?
$arrySettingFields = $objCommon->getSettingsFields($valuesDept['depID'],$group_id=1);

$BoxClassDisabled='class="disabled inputbox" readonly';
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0"  >
<tr>
  <td  valign="top" >

                 
        <?php 
$CountS=0;
foreach ($arrySettingFields as $field) { 
    $it = strtolower($field["input_type"]);
    if($field["FixedCol"] != '1')
    {
	$CountS++;
	if($CountS=='1') echo '<tr>';

/****Check Sales Existance************/
$BoxClass='class="inputbox"';
if(substr_count($field["setting_key"],"_START")==1){
	switch($field["setting_key"]){
		case 'SQ_START':
			if($objCommon->isSalesExist('Quote')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'SO_START':
			if($objCommon->isSalesExist('Order')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'INV_S_START':
			if($objCommon->isSalesExist('Invoice')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'RMA_S_START':
			if($objCommon->isSalesExist('RMA')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'CRD_S_START':
			if($objCommon->isSalesExist('Credit')){
				$BoxClass = $BoxClassDisabled;
			}
			break;


	}
}
/************************************/
                    ?>
                                                   
                                                        <td width="20%" height="30" align="right" valign="top"  class="blackbold"> 
                                                            <?= $field['caption'] ?> : <?php if($field['validation'] == "Yes") { ?><span class="red">*</span> <?php }?> 

<? if(!empty($field["InfoText"])){
	echo '<img src="'.$MainPrefix.'icons/help.png" class="help" title="'.stripslashes($field["InfoText"]).'">';
  }
 ?>


</td>
                                                     
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

$readonly='';
if($field["setting_key"]=='TaxableBilling'){
	if(($objCommon->isSalesExist('Order') || $objCommon->isSalesExist('Invoice'))){
		$readonly='readonly';
	}
}



                                                                            ?>
                                                                      <input type="checkbox" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" value="1"  
<?if($field["setting_value"]==1) echo 'checked';?>   <?=$readonly?> >
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
		if($CountS%2==0) echo '</tr><tr>';
	}
?>
                                                    
                                                   



 
                                      
                                    </td>
                                </tr>

</table> 
