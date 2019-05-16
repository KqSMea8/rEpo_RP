<?	 
	/************NumOfCurrency****************/
	$arryAddCurrency =  array();	
	if(!empty($arryCompany[0]['AdditionalCurrency']))
		$arryAddCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);
	if(!in_array($Config['Currency'],$arryAddCurrency)){
		$arryAddCurrency[] = $Config['Currency'];
	}
	$NumOfCurrency = sizeof($arryAddCurrency);	 
	/****************************/	


	$IndustryID = $arryCompany[0]['IndustryID'];	
	/****************************/	 
	$arrySettingFinance = $objCommon->getSettingsFields($valuesDept['depID'],$group_id=1);
	foreach ($arrySettingFinance as $key => $values) {
		$arrySettingFVal[$values['setting_key']] = $values['setting_value'];
		$arrySettingFCaption[$values['setting_key']] = $values['caption'];

		if($values['input_type']==""){
			 $AccountArray[] = $values['setting_key'];			 
		}
	}
 
	/***********************************************/
	/********* Pop Elements from Array *************/
	//echo '<pre>';print_r($AccountArray);
	$FlagEcom=0; $FlagPos=0;
	if($objConfigure->getSettingVariable('SO_SOURCE')==1){
		if(empty($arryCompany[0]['Department']) || in_array("2",$arryCmpDepartment)){			
			$FlagEcom = 1;
		}
				
	}


	if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){			
			$FlagPos = 1;
		}

	 
	if($FlagEcom==0){//ecommerce
		$AccountArray = array_diff($AccountArray, ["AmazonAccount","EbayAccount","AmazonEbayFee"]);	
	}else{
		 $EbayActive = $objConfigure->isEbayActive();
		 $AmazonActive = $objConfigure->isAmazonActive();
		 if(!$EbayActive && !$AmazonActive){
			$AccountArray = array_diff($AccountArray, ["AmazonAccount","EbayAccount","AmazonEbayFee"]);	
		 }else  if(!$EbayActive){
			$AccountArray = array_diff($AccountArray, ["EbayAccount" ]);
		 }else  if(!$AmazonActive){
			$AccountArray = array_diff($AccountArray, ["AmazonAccount" ]);
		}
		  
	}



	if($FlagPos==0){//pos
		$AccountArray = array_diff($AccountArray, ["PosAccount","PosFee"]);	
	}
	if(!$objConfig->isHostbillActive()){//hotbill
		$AccountArray = array_diff($AccountArray, ["HostbillFee"]);	
	}
	if($IndustryID>0){//standard
		$AccountArray = array_diff($AccountArray, [ "InventoryAdjustment", "ArContraAccount", "ApContraAccount", "ArGainLoss", "ApGainLoss"]);  //"PurchaseClearing"

		/*if($IndustryID!='14'){  //Retail General 
			$AccountArray = array_diff($AccountArray, ["ArReturn"]);	
		}*/
		if($IndustryID=='12'){ // Real estate
			$AccountArray = array_diff($AccountArray, ["FreightAR", "SalesTaxAccount",  "FreightExpense" ]);	
 
		}

		if($IndustryID=='13'){ // Restaurent
			$AccountArray = array_diff($AccountArray, ["PurchaseClearing", "ArRestocking", "ApRestocking" ]);	
 
		}	
	}  
	if($NumOfCurrency<=1){
		$AccountArray = array_diff($AccountArray, ["ArGainLoss", "ApGainLoss"]);
	}	
	$AccountArray = array_values($AccountArray);	 
	// print_r($AccountArray); exit;	
	/****************************/
	/****************************/

	// Greyed out fiscal year if there is any transaction
	if($arrySettingFVal['FiscalYearStartDate']>0 && $arrySettingFVal['FiscalYearEndDate']>0){
 		if($objBankAccount->isAccountDataExist($arrySettingFVal['FiscalYearStartDate'],$arrySettingFVal['FiscalYearEndDate'])){
			$FiscalClassDate = ' disabled';	
			$FiscalDisabled = 'disabled';
		}
	}

?>





<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<tr>
        <td  align="left"   class="heading" colspan="4">General Setting


</td>
      
      </tr>





          <?php 
		$CountF=0;
		foreach ($arrySettingFinance as $field) { 
                    $it = strtolower($field["input_type"]);
                    if($field["FixedCol"] != '1')
                    {
			$CountF++;
			if($CountF=='1') echo '<tr>';
                    ?>
                                                    
                                                        <td height="30" align="right" valign="top"  class="blackbold"> 
                                                            <?= $field['caption'] ?> : <?php if($field['validation'] == "Yes") { ?><span class="red">*</span> <?php }?> </td>
                                                     
                                                        <td   align="left" valign="top">
                                                            <?php
                                                            switch ($it) {
                                                                case "select" : {

$SelectLabel = '';
/********/
if($field["setting_key"]=="UN_REC_FROM"){
	for($p=1;$p<=36;$p++){
		$arryOpt[] = $p;
	}
	$field["options"] = implode($arryOpt,",");
	$selectClass= 'datebox';
	$SelectLabel = 'Months';
}
/********/
if(empty($selectClass)) $selectClass= 'inputbox';


                                                                        $v = explode(",", $field["options"]);
                                                                        $short = strtolower($field["options"]) == 'yes, no' || strtolower($field["options"]) == 'yes,no';
                                                                        ?><select name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" class="<?=$selectClass?>">

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
										echo $SelectLabel;
                                                                            break;
                                                                        }
                                                                    case "textarea" : {
                                                                            ?>
                                                                        <textarea name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>"><?=$field["setting_value"];?></textarea>
                                                                        <?php
                                                                        break;
                                                                    }
								 case "checkbox" : {
$readonly='';
//if($field["setting_key"]=='OpeningStock' && $field["setting_value"]!=1) $readonly='readonly';

                                                                            ?>
                                                                      <input type="checkbox" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" value="1"  
<?if($field["setting_value"]==1) echo 'checked';?>   <?=$readonly?> >
                                                                        <?php
                                                                        break;
                                                                    }

                                                                default :
                                                                case "text" : { 
                                                                        ?>
                                                                        <input type="text" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" class="inputbox" value="<?=$field["setting_value"];?>" <?=$field["options"]?>>
                                                                        <?php
                                                                        break;
                                                                    }
                                                            }
                                                                
                                                            ?>
                                                        </td>
                                                    
       <?php 

		} 
		if($CountF%2==0) echo '</tr><tr>';
	}
?>
                                                      
                                                    
                                                    <tr>
                                                        <td width="20%" height="30" align="right" class="blackbold">Fiscal Year :</td>
                                                        <td width="30%">
                                                            Start :
                                                            <input type="text" name="FiscalYearStartDate" maxlength="30" class="datebox<?=$FiscalClassDate?>" <?=$FiscalDisabled?> id="FiscalYearStartDate" value="<?=$arrySettingFVal['FiscalYearStartDate']?>" readonly>
							   <? if(empty($FiscalDisabled)){ ?>
                                                            <script type="text/javascript">
                                                                $(function() {
                                                                    $('#FiscalYearStartDate').datepicker(
                                                                            {
                                                                                showOn: "both",
                                                                                yearRange: '<?= date("Y")-2 ?>:<?= date("Y")+2 ?>', 
                                                                                //maxDate: "-1D", 
                                                                                dateFormat: 'yy-mm-dd',
                                                                                changeMonth: true,
                                                                                changeYear: true,
                                                                                //minDate:'0d'

                                                                            }
                                                                    );
                                                                });
                                                            </script>
								<? } ?>
                                                        &nbsp;&nbsp;&nbsp;End :
                                                            <input type="text" name="FiscalYearEndDate" maxlength="30" class="datebox<?=$FiscalClassDate?>" <?=$FiscalDisabled?> id="FiscalYearEndDate" value="<?=$arrySettingFVal['FiscalYearEndDate']?>" readonly>
							    <? if(empty($FiscalDisabled)){ ?>
                                                            <script type="text/javascript">
                                                                $(function() {
                                                                    $('#FiscalYearEndDate').datepicker(
                                                                            {
                                                                                showOn: "both",
                                                                                yearRange: '<?= date("Y")-2 ?>:<?= date("Y")+2 ?>', 
                                                                                //maxDate: "-1D", 
                                                                                dateFormat: 'yy-mm-dd',
                                                                                changeMonth: true,
                                                                                changeYear: true,
                                                                                //minDate:'0d'

                                                                            }
                                                                    );
                                                                });
                                                            </script>
							   <? } ?>
                                                        </td>
                                                    


                                                        <td width="20%" align="right" class="blackbold">Calendar Year :</td>
                                                        <td   >
                                                            Start :
                                                            <input type="text" name="CalendarYearStartDate" maxlength="30" class="datebox" readonly id="CalendarYearStartDate" value="<?=$arrySettingFVal['CalendarYearStartDate']?>">

                                                            <script type="text/javascript">
                                                                $(function() {
                                                                    $('#CalendarYearStartDate').datepicker(
                                                                            {
                                                                                showOn: "both",
                                                                                yearRange: '<?= date("Y")-2 ?>:<?= date("Y")+2 ?>', 
                                                                                //maxDate: "-1D", 
                                                                                dateFormat: 'yy-mm-dd',
                                                                                changeMonth: true,
                                                                                changeYear: true,
                                                                                //minDate:'0d'

                                                                            }
                                                                    );
                                                                });
                                                            </script>
                                                        &nbsp;&nbsp;&nbsp;End :
                                                            <input type="text" name="CalendarYearEndDate" maxlength="30" class="datebox" readonly  id="CalendarYearEndDate" value="<?=$arrySettingFVal['CalendarYearEndDate']?>">

                                                            <script type="text/javascript">
                                                                $(function() {
                                                                    $('#CalendarYearEndDate').datepicker(
                                                                            {
                                                                                showOn: "both",
                                                                                yearRange: '<?= date("Y")-2 ?>:<?= date("Y")+2 ?>', 
                                                                                //maxDate: "-1D", 
                                                                                dateFormat: 'yy-mm-dd',
                                                                                changeMonth: true,
                                                                                changeYear: true,
                                                                                //minDate:'0d'

                                                                            }
                                                                    );
                                                                });
                                                            </script>
                                                        </td>
                                                    </tr>


<? $CountX=0;
   
$rename = '<img src="'.$Config['Url'].'admin/images/edit.png" border="0" class="editicon" onMouseover="ddrivetip(\'<center>Rename Caption</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';

 

for($x=0;$x<sizeof($AccountArray);$x++){
	
	$name = $AccountArray[$x];
	$id = "GlAccountID".$x;
	$value = $arrySettingFVal[$name];
	$caption = $arrySettingFCaption[$name];

	$AccountName = "Account_".$name;
	$AccountId = "GlAccount_".$x;
	
	$AccountVal = '';
	if(!empty($value)){
		$arryBankAccount = $objBankAccount->getBankAccountById($value);
		if(!empty($arryBankAccount[0]['AccountNumber'])){
			$AccountVal = ucwords($arryBankAccount[0]['AccountName']).' ['.$arryBankAccount[0]['AccountNumber'].']';
		}
	}

	if($name=='AccountReceivable'){
		$CountX=0;
		echo '<tr><td  align="left"  class="heading" colspan="4">Account Receivable &nbsp;&nbsp;&nbsp;<span class=red>['.SETTING_CAPTION_MSG.']</span></td></tr>';

		$AutoPostToGlAr = ($arrySettingFVal["AutoPostToGlAr"]==1)?('checked'):('');
		$AutoPostToGlArCredit = ($arrySettingFVal["AutoPostToGlArCredit"]==1)?('checked'):('');
		echo '<tr><td  align="right" class="blackbold">Auto Post to GL [Invoice] : </td> <td><input type="checkbox" name="AutoPostToGlAr" id="AutoPostToGlAr" value="1" '.$AutoPostToGlAr.' ></td>

		<td  align="right" class="blackbold">Auto Post to GL [Credit Memo] : </td> <td><input type="checkbox" name="AutoPostToGlArCredit" id="AutoPostToGlArCredit" value="1" '.$AutoPostToGlArCredit.' ></td></tr>';
		
	}


	if($name=='AccountPayable'){
		$CountX=0;
		echo '<tr><td  align="left"  class="heading" colspan="4">Account Payable</td></tr>';

		$AutoPostToGlAp = ($arrySettingFVal["AutoPostToGlAp"]==1)?('checked'):('');
		$AutoPostToGlApCredit = ($arrySettingFVal["AutoPostToGlApCredit"]==1)?('checked'):('');

		echo '<tr><td  align="right" class="blackbold">Auto Post to GL [Invoice] : </td> <td><input type="checkbox" name="AutoPostToGlAp" id="AutoPostToGlAp" value="1" '.$AutoPostToGlAp.' ></td>

		<td  align="right" class="blackbold">Auto Post to GL [Credit Memo] : </td> <td><input type="checkbox" name="AutoPostToGlApCredit" id="AutoPostToGlApCredit" value="1" '.$AutoPostToGlApCredit.' ></td></tr>';


		
	}







	if($name=='CommissionFeeAccount'){	
		$CommissionAp = ($arrySettingFVal["CommissionAp"]==1)?('checked'):('');
		echo '<tr><td  align="right" class="blackbold"> Vendor Commision  : </td> <td><input type="checkbox" name="CommissionAp" id="CommissionAp" value="1" '.$CommissionAp.' ></td>'; 
	}
	
		





	$CountX++;
 

	if($CountF=='1') echo '<tr>';
 ?>





                <td height="30" align="right" class="blackbold"   onmouseover="Javascrip:ShowHideEdit(<?=$x?>,1)"  onmouseout="Javascrip:ShowHideEdit(<?=$x?>,0)"> <span id="caption_span<?=$x?>" ><?=$caption?></span> :

<a class="fancybox fancysmall fancybox.iframe" href="settingCaption.php?id=<?=$x?>" id="rename<?=$x?>" style="display:none" ><?=$rename?></a>

</td>
                <td>

 <input name="caption<?=$x?>" id="caption<?=$x?>" type="hidden" class="disabled" value="<?=$caption?>"  maxlength="30" readonly />
 <input name="setting_key<?=$x?>" id="setting_key<?=$x?>" type="hidden" class="disabled" value="<?=$name?>"  maxlength="30" readonly />

<input name="<?=$AccountName?>" id="<?=$AccountId?>" type="text" class="inputbox" style="width:200px;" value="<?=$AccountVal?>"   onclick="Javascript:SetAutoCompleteGL(this);"  onblur="SetGlAccount(this.value,<?=$x?>);" autocomplete="off"  />
<input name="<?=$name?>" id="<?=$id?>" type="hidden" class="disabled" value="<?=$value?>"  maxlength="20" readonly />

<a class="fancybox fancybig fancybox.iframe" href="viewAccount.php?id=<?=$x?>&pop=1" ><?=$search?></a>	  
           
 <a href="Javascript:ClearHead('<?=$x?>');" ><?=$clear?></a>                  

	</td>

<? 
	if($CountX%2==0) echo '</tr><tr>';

	

} 

?>

<tr>
        <td  align="left"  colspan="4">
<? include("includes/html/box/currency_setting.php"); ?>

</td>
      
      </tr>

</table> 

 


  
 
