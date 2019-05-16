<?
$arrySettingFields = $objCommon->getSettingsFields($valuesDept['depID'],$group_id=1);
$BoxClassDisabled='class="disabled inputbox" readonly';
foreach ($arrySettingFields as $key => $values) {
	$arrySettingPVal[$values['setting_key']] = $values['setting_value'];
}

 if(empty($AcPArray)) $AcPArray = array();

/*$AcPArray = array(	
	array("label" => "Clearing Account",  "name" => "ClearingAccountP")
); */
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
		case 'PQ_START':
			if($objCommon->isPurchaseExist('Quote')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'PO_START':
			if($objCommon->isPurchaseExist('Order')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'INV_P_START':
			if($objCommon->isPurchaseExist('Invoice')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'RMA_P_START':
			if($objCommon->isPurchaseExist('RMA')){
				$BoxClass = $BoxClassDisabled;
			}
			break;
		case 'CRD_P_START':
			if($objCommon->isPurchaseExist('Credit')){
				$BoxClass = $BoxClassDisabled;
			}
		case 'REC_P_START':
			if($objCommon->isPurchaseExist('Receipt')){
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


$readonly='';
if($field["setting_key"]=='TaxableBillingAp'){
	if(($objCommon->isPurchaseExist('Order') || $objCommon->isPurchaseExist('Invoice'))){
		$readonly='readonly';
	}
}
                                                                            ?>
                                                                      <input type="checkbox" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" value="1"  
<?if($field["setting_value"]==1) echo 'checked';?>   <?=$readonly?>>
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
    
                                                    
                                                   
<? $CountX=0;

for($i=0;$i<sizeof($AcPArray);$i++){
	$x++; //used in finance account settings
	$name = $AcPArray[$i]['name'];
	$id = "GlAccountID".$x;
	$value = $arrySettingPVal[$name];

	$AccountName = "Account_".$AcPArray[$i]['name'];
	$AccountId = "GlAccount_".$x;
	
	$AccountVal = '';
	if(!empty($value)){
		$arryBankAccount = $objBankAccount->getBankAccountById($value);
		if(!empty($arryBankAccount[0]['AccountNumber'])){
			$AccountVal = ucwords($arryBankAccount[0]['AccountName']).' ['.$arryBankAccount[0]['AccountNumber'].']';
		}
	}
	
	$CountX++;


	if($CountX=='1') echo '<tr>';
 ?>





                <td height="30" align="right" class="blackbold"><?=$AcPArray[$i]['label']?> :</td>
                <td>



<input name="<?=$AccountName?>" id="<?=$AccountId?>" type="text" class="disabled" style="width:200px;" value="<?=$AccountVal?>" readonly />
<input name="<?=$name?>" id="<?=$id?>" type="hidden" class="disabled" value="<?=$value?>"  maxlength="20" readonly />

<a class="fancybox fancybig fancybox.iframe" href="viewAccount.php?id=<?=$x?>&pop=1" ><?=$search?></a>	  
           
 <a href="Javascript:ClearHead('<?=$x?>');" ><?=$clear?></a>                  

	</td>

<? 
	if($CountX%2==0) echo '</tr><tr>';

	

} ?>


</table> 
