<?
	//if($Config['SelectOneItem']==0){ //Distribution Company Type
		/***********************/
		$InvCostArray = array(				
				array("label" => "Inventory",  "name" => "InventoryAR"),
				array("label" => "Cost Of Goods",  "name" => "CostOfGoods")				
			      );
		$NumInvCost = sizeof($InvCostArray);
		/***********************/	
		$ArReturnArray = array(				
				array("label" => "Sales Returns & Allowances",  "name" => "ArReturn")
			      );
		$NumArReturn = sizeof($ArReturnArray);
		/***********************/	
		$ApReturnArray = array(				
				array("label" => "Purchase Returns & Allowances",  "name" => "ApReturn")
			      );
		$NumApReturn = sizeof($ApReturnArray);		
		/***********************/
		if($objConfigure->getSettingVariable('SO_SOURCE')==1){
			if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
				$EcomArray = array(
						array("label" => "Amazon Account",  "name" => "AmazonAccount"),
						array("label" => "Ebay Account",  "name" => "EbayAccount"),
						array("label" => "Amazon / Ebay Fee",  "name" => "AmazonEbayFee")
					      );
				$NumEcom = sizeof($EcomArray);
			}
		}
		/***********************/
		if($objConfig->isHostbillActive()){
			$HostbillArray = array(				
					array("label" => "Hostbill Fee",  "name" => "HostbillFee")
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

		$DefaultArray = array(			
			array("label" => "Retained Earnings",  "name" => "RetainedEarning"),
			array("label" => "Credit Card Fee",  "name" => "CreditCardFee"),
			
			array("label" => "Account Receivable",  "name" => "AccountReceivable"),			
			
			array("label" => "Sales",  "name" => "Sales"),			
			array("label" => "Freight",  "name" => "FreightAR"),
			array("label" => "Sales Discount",  "name" => "SalesDiscount"),			
			array("label" => "Sales Tax Account",  "name" => "SalesTaxAccount"),
			array("label" => "Contra Account",  "name" => "ArContraAccount")		
			
		);
		$ArArray = array_merge($ArArray,$DefaultArray); 

		if($NumEcom>0){
			$ArArray = array_merge($ArArray,$EcomArray);
		}

		if($NumHostbill>0){
			$ArArray = array_merge($ArArray,$HostbillArray);
		}
		if($NumArReturn>0){
			$ArArray = array_merge($ArArray,$ArReturnArray);
		}	
	 
		$ApArray = array(
			array("label" => "Account Payable",  "name" => "AccountPayable"),					
			array("label" => "Freight Expense",  "name" => "FreightExpense"),			
			array("label" => "Contra Account",  "name" => "ApContraAccount")
		); 
		if($NumApReturn>0){
			$ApArray = array_merge($ApArray,$ApReturnArray);
		}
	 
		$ArApArray = array_merge($ArArray,$ApArray);
		
	/*}else{
		$ArArray = array(
			array("label" => "Inventory",  "name" => "InventoryAR"),
			array("label" => "Retained Earnings",  "name" => "RetainedEarning"),

			array("label" => "Account Receivable",  "name" => "AccountReceivable"),			
			array("label" => "Credit Card Clearing",  "name" => "CreditCardClearing"),
			array("label" => "Sales",  "name" => "Sales"),	
			array("label" => "Freight",  "name" => "FreightAR"),		
			array("label" => "Sales Discount",  "name" => "SalesDiscount"),	
			array("label" => "Sales Tax Account",  "name" => "SalesTaxAccount"),
			array("label" => "Sales Returns & Allowances",  "name" => "ArReturn"),		
			array("label" => "Contra Account",  "name" => "ArContraAccount") 
		); 
		if($NumEcom>0){
			$ArArray = array_merge($ArArray,$EcomArray);
		}
		$ApArray = array(
			array("label" => "Account Payable",  "name" => "AccountPayable"),
			array("label" => "Purchase Returns & Allowances",  "name" => "ApReturn"),		 
			array("label" => "Contra Account",  "name" => "ApContraAccount")
		); 
		 $ArApArray = array_merge($ArArray,$ApArray);
	}*/

	//echo '<pre>';print_r($ArApArray);exit;

	/****************************/
	$arrySettingFinance = $objCommon->getSettingsFields($valuesDept['depID'],$group_id=1);
	foreach ($arrySettingFinance as $key => $values) {
		$arrySettingFVal[$values['setting_key']] = $values['setting_value'];
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
        <td  align="left"   class="heading" colspan="4">General Setting</td>
      
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
for($x=0;$x<sizeof($ArApArray);$x++){
	
	$name = $ArApArray[$x]['name'];
	$id = "GlAccountID".$x;
	$value = $arrySettingFVal[$name];

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
		echo '<tr><td  align="left"  class="heading" colspan="4">Account Receivable</td></tr>';
	}


	if($ArApArray[$x]['name']=='AccountPayable'){
		$CountX=0;
		echo '<tr><td  align="left"  class="heading" colspan="4">Account Payable</td></tr>';
	}
	$CountX++;


	if($CountF=='1') echo '<tr>';
 ?>





                <td height="30" align="right" class="blackbold"><?=$ArApArray[$x]['label']?> :</td>
                <td>

 

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


  
 
