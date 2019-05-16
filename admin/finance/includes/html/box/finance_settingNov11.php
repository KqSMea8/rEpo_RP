<?

	 
	  	$IndustryID = $arryCompany[0]['IndustryID'];


	//if($Config['SelectOneItem']==0){ //Distribution Company Type
		/***********************/
		$InvCostArray = array(				
				array("name" => "InventoryAR"),
				array("name" => "CostOfGoods")				
			      );
		$NumInvCost = sizeof($InvCostArray);
		/***********************/
		$ClearingArray = array(				
				array("name" => "CreditCardFee"),
				array("name" => "PurchaseClearing")			
			      );
		$NumClearing = sizeof($ClearingArray);		
		/***********************/	
		$ArReturnArray = array(				
				array("name" => "ArReturn")
			      );		 
		/***********************/	
		$ApReturnArray = array(				
				array("name" => "ApReturn")
			      );
		$NumApReturn = sizeof($ApReturnArray);		
		/***********************/
		$ArContraArray = array(				
				array("name" => "ArContraAccount")
			      );
		/***********************/
		$ApContraArray = array(				
				array("name" => "ApContraAccount")
			      );		
		/***********************/
		if($objConfigure->getSettingVariable('SO_SOURCE')==1){
			if(empty($arryCompany[0]['Department']) || in_array("2",$arryCmpDepartment)){
				$EcomArray = array(
						array("name" => "AmazonAccount"),
						array("name" => "EbayAccount"),
						array("name" => "AmazonEbayFee")
					      );
				$NumEcom = sizeof($EcomArray);
			}
			if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
				$PosArray = array(
						array("name" => "PosAccount"),
						array("name" => "PosFee")
					      );
				$NumPos = sizeof($PosArray);
			}
			
		}
		/***********************/
		if($objConfig->isHostbillActive()){
			$HostbillArray = array(				
					array("name" => "HostbillFee")
				      );
			$NumHostbill = sizeof($HostbillArray);
		}
		/***********************/

	//}



	

 
	//if($Config['TrackInventory']==1){
		$ArArray = array(); 

		if($NumInvCost>0){
			$ArArray = array_merge($ArArray,$InvCostArray);
		}
		if($IndustryID<=0){  
			$ArArray = array_merge($ArArray,$ClearingArray);
		}
		$DefaultArray = array(			
			array("name" => "RetainedEarning"),			

			array("name" => "AccountReceivable"),			
			
			array("name" => "Sales"),
			array("name" => "SalesDiscount")
			
		);

		
		$DefaultArray2 = array(		
			array("name" => "FreightAR"),						
			array("name" => "SalesTaxAccount"),
			array("name" => "ArGainLoss")					
			
		);

		$ArArray = array_merge($ArArray,$DefaultArray); 

		if($IndustryID!='12'){  
			$ArArray = array_merge($ArArray,$DefaultArray2);
		}


		if($IndustryID<=0){  
			$ArArray = array_merge($ArArray,$ArContraArray);
		}

		if($NumEcom>0){
			$ArArray = array_merge($ArArray,$EcomArray);
		}

		if($NumHostbill>0){
			$ArArray = array_merge($ArArray,$HostbillArray);
		}
		if($NumPos>0){
			$ArArray = array_merge($ArArray,$PosArray);
		}
		if($IndustryID<=0 || $IndustryID=='14'){ //14 for Retail General 
			$ArArray = array_merge($ArArray,$ArReturnArray);
		}	
	 
		$ApArray = array(
			array("name" => "AccountPayable") 				
			
		); 

		$ApArray2 = array(							
			array("name" => "FreightExpense"),
			array("name" => "ApGainLoss")				
			
		); 
		if($IndustryID!='12'){  //12 for Real estate
			$ApArray = array_merge($ApArray,$ApArray2);
		}

		if($NumApReturn>0){
			$ApArray = array_merge($ApArray,$ApReturnArray);
		}
	 	if($IndustryID<=0){  
			$ApArray = array_merge($ApArray,$ApContraArray);
		}
		$ArApArray = array_merge($ArArray,$ApArray);
		
	/*}else{
		$ArArray = array(
			array( "name" => "InventoryAR"),
			array( "name" => "RetainedEarning"),

			array("name" => "AccountReceivable"),			
			array(  "name" => "CreditCardClearing"),
			array("name" => "Sales"),	
			array("name" => "FreightAR"),		
			array( "name" => "SalesDiscount"),	
			array(  "name" => "SalesTaxAccount"),
			array( "name" => "ArReturn"),		
			array("name" => "ArContraAccount") 
		); 
		if($NumEcom>0){
			$ArArray = array_merge($ArArray,$EcomArray);
		}
		$ApArray = array(
			array( "name" => "AccountPayable"),
			array(  "name" => "ApReturn"),		 
			array(  "name" => "ApContraAccount")
		); 
		 $ArApArray = array_merge($ArArray,$ApArray);
	}*/

	//echo '<pre>';print_r($ArApArray);exit;

	/****************************/
	$arrySettingFinance = $objCommon->getSettingsFields($valuesDept['depID'],$group_id=1);
	foreach ($arrySettingFinance as $key => $values) {
		$arrySettingFVal[$values['setting_key']] = $values['setting_value'];
		$arrySettingFCaption[$values['setting_key']] = $values['caption'];
	}	
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
                                                                case "text" : { 
                                                                        ?>
                                                                        <input type="text" name="<?= $field["setting_key"] ?>" id="<?= $field["setting_key"] ?>" class="inputbox" value="<?=$field["setting_value"];?>">
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



for($x=0;$x<sizeof($ArApArray);$x++){
	
	$name = $ArApArray[$x]['name'];
	$id = "GlAccountID".$x;
	$value = $arrySettingFVal[$name];
	$caption = $arrySettingFCaption[$name];

	$AccountName = "Account_".$ArApArray[$x]['name'];
	$AccountId = "GlAccount_".$x;
	
	$AccountVal = '';
	if(!empty($value)){
		$arryBankAccount = $objBankAccount->getBankAccountById($value);
		if(!empty($arryBankAccount[0]['AccountNumber'])){
			$AccountVal = ucwords($arryBankAccount[0]['AccountName']).' ['.$arryBankAccount[0]['AccountNumber'].']';
		}
	}

	if($ArApArray[$x]['name']=='AccountReceivable'){
		$CountX=0;
		echo '<tr><td  align="left"  class="heading" colspan="4">Account Receivable &nbsp;&nbsp;&nbsp;<span class=red>['.SETTING_CAPTION_MSG.']</span></td></tr>';
	}


	if($ArApArray[$x]['name']=='AccountPayable'){
		$CountX=0;
		echo '<tr><td  align="left"  class="heading" colspan="4">Account Payable</td></tr>';
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

<input name="<?=$AccountName?>" id="<?=$AccountId?>" type="text" class="disabled" style="width:200px;" value="<?=$AccountVal?>" readonly />
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

 


  
 
