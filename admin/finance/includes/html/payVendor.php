<script src="js/payVendor.js?<?=time()?>"></script>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>


<style>
.ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-text-only {
	background: #d40503 none repeat scroll 0 0;
	border: 0 solid #094989;
	font-weight: bold;
	color: #fff;
}

.ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix.ui-draggable-handle {
    background: #3377af none repeat scroll 0 0;
    color: #fff;
}
</style>

<script language="JavaScript1.2" type="text/javascript">

function closeWindow(){
    return "Please confirm that you want to leave this page.\nData you have saved will be lost.";
}

window.onbeforeunload = closeWindow;

$( document ).ready(function() {

	$("#SuppCode").change(function() {
		var PaymentTerm = $("#SuppCode :selected").attr("PaymentTerm");

		if(PaymentTerm!=''){
			var arryPaymentTerm = PaymentTerm.split('-');
			PaymentTerm = arryPaymentTerm[0].trim();
			$("#Method").val(PaymentTerm); 
			getPaymentMethodName(PaymentTerm);
		}
	});



 EnableAmount();

  setTimeout(function() {
    $('.message').fadeOut('fast');
}, 20000);




 
});
</script>



<a href="<?=$ViewUrl?>" class="back">Back</a>
<div class="had"><?=$MainModuleName?>    <span>&raquo; <?=$PageHeading?> <span></div>

<div class="message" align="center"><? if(!empty($_SESSION['mess_payment'])) {echo $_SESSION['mess_payment'].'<br>'; unset($_SESSION['mess_payment']); }?></div>

<?  if (!empty($ErrorMsg)) {   ?>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<?php } else {?>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	
	<tr>
	 <td align="left" valign="top">
	 <table width="100%" border="0" cellpadding="5" cellspacing="0" style="height: 153px;">
	 <tr>
        <td align="right"   class="blackbold">Total Amount Paid : <span class="red">*</span></td>
        <td align="left">
		  <input name="PaidAmount" type="text" class="inputbox" id="PaidAmount" style="width: 90px;" maxlength="10" onkeypress="return isDecimalKey(event);"  value="<?=$arryTransaction[0]['OriginalAmount']?>"   onchange="Javascript:setBalanceAmount();" />  

 &nbsp;&nbsp;&nbsp;&nbsp;
<span id="BalanceSpan" class="red" style="display:none"></span>

		</td>
     </tr>
	 <tr>
        <td  align="right"  class="blackbold">Vendor : <span class="red">*</span></td>
        <td  align="left">
			
<select name="SuppCode" id="SuppCode" class="<?=$ClassName?>" <?=$Disabled?> onChange="return checkContra();">
	<option value="">---Select---</option>
	<?php foreach($arryVendorList as $values){

		$SuppCode = trim($values['SuppCode']);
?>
	<option PaymentTerm="<?=$values['PaymentTerm']?>" value="<?=$SuppCode?>" 
	<?=($arryTransaction[0]['SuppCode']==$SuppCode)?('selected'):('')?> ><?=stripslashes($values['VendorName'])?></option>
	<?php }?>

</select>
<script>
$("#SuppCode").select2();
</script> 
<input type="hidden" name="SuppCodeOld" id="SuppCodeOld" value="<?=$arryTransaction[0]['SuppCode']?>" readonly>	
		
		</td>
     </tr>
	 
     
	  </tr>
<tr  <? if(empty($ContraTransactionID)) echo 'style="display: none;"'; ?> id="EntryTpe">
        <td  align="right"  class="blackbold">Entry Type : <span class="red">*</span></td>
        <td   align="left">
		
		
		   <select name="EntryType" class="<?=$ClassName?>" <?=$Disabled?> id="EntryType" onChange="getEntryType(this.value);">
		  	<option value="">--- Select ---</option>
                        <option value="Invoice" <?=($arryContraTr[0]['EntryType']=='Invoice')?('selected'):('')?>>Invoice</option>
                        <option value="GL Account" <?=($arryContraTr[0]['EntryType']=='GL Account')?('selected'):('')?>>GL Account</option>
			 
		</select> 
		
		</td>
     </tr>
     
    <tr <?=($ContraTransactionID>0 && $arryContraTr[0]['EntryType']=='GL Account')?(''):('style="display: none;"')?> id="showGLCode">
        <td  align="right" class="blackbold">GL Account : <span class="red">*</span></td>
        <td   align="left">
<select name="GLCode" class="<?=$ClassName?>" <?=$Disabled?> id="GLCode">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
	<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"
 <?=($arryContraTr[0]['GLCode']==$arryBankAccountList[$i]['BankAccountID'])?('selected'):('')?> >
	<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
	[<?=$arryBankAccountList[$i]['AccountNumber']?>]
	</option>
	<? } ?>
</select> 


		</td>
    </tr>  
	 <tr>
            <td  align="right"  class="blackbold">Payment Account : <span class="red">*</span></td>
            <td   align="left">


<select name="PaidFrom" class="<?=$ClassName?>" <?=$Disabled?> id="PaidFrom" onchange="Javascript:setDefaultCheckNumber();">
    <option value="">--- Select ---</option>
<? for($i=0;$i<sizeof($arryBankAccount);$i++) {
	$selected='';
	if(!empty($_GET['edit']) || !empty($PaymentErrorFlag) ){
		if($arryBankAccount[$i]['BankAccountID']==$arryTransaction[0]['AccountID']) $selected='Selected'; 
	}else if($arryBankAccount[$i]['DefaultAccount']==1){
		 $selected='Selected';
	}

	/****************
	$BankCurrency='';unset($BankCurrencyArray);
	if(!empty($arryBankAccount[$i]['BankCurrency'])){
		$BankCurrencyArray = explode(",",$arryBankAccount[$i]['BankCurrency']);
		$BankCurrency = $BankCurrencyArray[0];
	}*/
	$BankCurrency = $arryBankAccount[$i]['BankCurrency'];
	if(empty($BankCurrency))$BankCurrency = $Config['Currency'];
	/****************/

?>
     <option currency="<?=$BankCurrency?>" value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?=$selected?>>
     <?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
            <? } ?>
</select> 


<select name="BankCurrency" class="textbox"  id="BankCurrency" style="display:none"  onChange="return checkContra();">
</select>
<script type="text/javascript">
setBankCurrency('<?=$ModuleCurrency?>');
</script>


                    </td>
         </tr>
	<tr>
        <td  align="right" class="blackbold">Payment Term : <span class="red">*</span></td>
        <td   align="left">
<select name="Method" class="<?=$ClassName?>" <?=$Disabled?> id="Method" onChange="getPaymentMethodName(this.value);">
<option value="">--- Select ---</option>
	 <? for($i=0;$i<sizeof($arryPaymentTerm);$i++) { 
				$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
			?>
				<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryTransaction[0]['Method']){echo "selected";}?>><?=$PaymentTerm?></option>
			<? } ?>
</select> 
		</td>
  </tr>
      <tr style="display: none;" id="CheckBankNameTr">
            <td  align="right" class="blackbold">Bank Name : <span class="red">*</span></td>
            <td  align="left"><input name="CheckBankName" type="text" class="<?=$ClassName?>" <?=$Disabled?> id="CheckBankName" maxlength="40" value="<?=stripslashes($arryTransaction[0]['CheckBankName'])?>"  /></td>
         </tr>
	 <tr style="display: none;" id="CheckNumberTr">
            <td  align="right" class="blackbold">Check Number : <span class="red">*</span></td>
            <td  align="left"><input name="CheckNumber" type="text" class="<?=$ClassName?>" <?=$Disabled?> id="CheckNumber" maxlength="20" value="<?=stripslashes($arryTransaction[0]['CheckNumber'])?>"  onKeyPress="Javascript:return isNumberKey(event);"  onBlur="Javascript:CheckNumberExist('MsgSpan_CheckNumber','CheckNumber');"  /> &nbsp;&nbsp;<span id="MsgSpan_CheckNumber"></span>


<input type="hidden" class="inputbox" name="Voided" id="Voided" value="0">

</td>
         </tr>
       <tr style="display: none;" id="CheckFormatTr">
        <td  align="right" class="blackbold">Check Format : <span class="red">*</span></td>
        <td   align="left">
<?
$CheckFormat1 = 'Check, Stub, Stub';
$CheckFormat2 = 'Stub, Check, Stub';
$CheckFormat3 = 'Stub, Stub, Check';
?>
<select name="CheckFormat" class="<?=$ClassName?>" <?=$Disabled?> id="CheckFormat" onchange="Javascript:PrintCheckFormat();">
	<option value="">--- Select ---</option>
	<option value="<?=$CheckFormat1?>" <?=($arryTransaction[0]['CheckFormat']==$CheckFormat1)?('selected'):('')?>><?=$CheckFormat1?></option>
	<option value="<?=$CheckFormat2?>" <?=($arryTransaction[0]['CheckFormat']==$CheckFormat2)?('selected'):('')?>><?=$CheckFormat2?></option>
	<option value="<?=$CheckFormat3?>" <?=($arryTransaction[0]['CheckFormat']==$CheckFormat3)?('selected'):('')?>><?=$CheckFormat3?></option>
</select> 

<?
if($_GET['edit']>0){
	$HideCheckPrint = empty($arryTransaction[0]['CheckFormat'])?('style="display: none;"'):('');
	echo '<a href="Javascript:PrintCheckFormat();" class="action_bt" id="CheckPrintLink" '.$HideCheckPrint.'>Print Check Format</a>';
}
?>

		</td>

		  
    </tr>  
         
 
<tr style="display: none;" id="ShippingTr">	 
<?  
$Currency = $Config['Currency']; 
include("../includes/html/box/shipping_box_standalone.php"); 
?>	 
<input name="subtotal" type="hidden" class="inputbox" readonly id="subtotal" value="0" />
</tr>  


<? 
     
   /*if(!empty($arryShippInfo[0]['totalFreight'])){
	$ActualFreightDisplay = '';
	$ActualFreight = $arryShippInfo[0]['totalFreight'];	
   }else{*/
	$ActualFreightDisplay = 'style="display:none"';
	$ActualFreight =  '';
  // }	
?>
	 <tr id="ActualFreightDiv" <?=$ActualFreightDisplay?>>
            <td valign="top" align="right" class="blackbold"> Actual Freight : </td>
            <td align="left"> 
<input type="text" align="right" name="ActualFreight" id="ActualFreight" class="disabled" readonly value="<?=$ActualFreight?>" size="4"  /> </td>
	</tr>



 
	</table>
	 
	 </td>
	 <td align="right" valign="top">
	 <table width="100%" border="0" cellpadding="5" style="height: 153px;"  cellspacing="0">
	<tr>
	 <td  align="right" style=" padding-top: 10px; vertical-align: top;" class="blackbold">Payment Date  : <span class="red">*</span></td>
		<td   align="left" >

			<script type="text/javascript">
			$(function() {
			$('#Date').datepicker(
			{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

			}
			);
			});
			</script>

		<? 
		$arryTime = explode(" ",$Config['TodayDate']);
		$Date = ($arryTransaction[0]['PaymentDate']>0)?($arryTransaction[0]['PaymentDate']):($arryTime[0]); 
		?>
		<input id="Date" name="Date" readonly="" class="<?=$ClassDate?>" value="<?=$Date?>"  type="text" <?=$Disabled?> onChange="return checkContra();">
                
                
                 <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $APCurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>

		</td>
	</tr>
	
	 <tr>
            <td  align="right" class="blackbold" valign="top">Reference No : </td>
            <td  align="left">
<textarea id="ReferenceNo" class="<?=$ClassName?>" <?=$Disabled?> type="text" name="ReferenceNo" maxlenghth="200"><?=stripslashes($arryTransaction[0]['ReferenceNo'])?></textarea>

</td>
         </tr>
	 <tr>
            <td valign="top" align="right" class="blackbold">Payment Comment :</td>
            <td align="left"><textarea id="Comment" class="<?=$ClassName?>" <?=$Disabled?> type="text" name="Comment" maxlenghth="500"><?=stripslashes($arryTransaction[0]['Comment'])?></textarea></td>
	</tr>
	 <tr>
            <td valign="top" align="right" class="blackbold"> </td>
            <td align="left"><a href="checkFormat.php" class="fancybox fancybox.iframe"  id="CheckFormatLink" style="display:none">Check Printing Format</a></td>
	</tr>

  
	</table>
	 </td>
	</tr>

 	<tr>
	<td colspan="2" align="center">
	<?
	$_GET['view'] = $_GET['edit'];
	$arryShipStand['ModuleType'] = 'VendorPayment';
	$arryShipStand['RefID'] = $TransactionID; 
	include("../includes/html/box/shipping_info_standalone.php");
	?>
	</td>
</tr>

        <tr>
            <td colspan="2" id="invoiveList" align="center"></td>
        </tr>
        <tr>
            <td colspan="2" id="glList" align="center" style="display:none">
<? include("includes/html/box/gl_pay_form.php");  ?>
</td>
        </tr>
	 <tr>
            <td colspan="2" id="savedList" align="center"></td>
        </tr>

          <tr>
            <td colspan="2" align="center">

<input type="submit" class="button" name="save_payment" id="save_payment" style="display: none;" value="Process Saved Payment">
<input type="hidden" name="TransactionID" id="TransactionID" value="<?=$TransactionID?>" readonly>

<input type="hidden" name="ContraTransactionID" id="ContraTransactionID" value="<?=$ContraTransactionID?>" readonly>

<input type="hidden" name="ContraFlag" id="ContraFlag" value="<?=$ContraFlag?>" readonly>
<input name="ConfirmContra" type="hidden" class="inputbox" readonly id="ConfirmContra" value="0" />

</td>
        </tr>
	</table>
 </form>

<?php }?>

<div id="dialog-modal2" style="display: none;"></div>
<br><br>

<? if(!empty($_GET['edit']) || !empty($PaymentErrorFlag) ){ ?>
<script type="text/javascript">
  getPaymentMethodName('<?=$arryTransaction[0]["Method"]?>');
  //SetVendorInvoice('<?=$arryTransaction[0]["SuppCode"]?>','<?=$confirmContra?>');
  ListTransaction();
</script>
<? } ?>

<? 
include("includes/html/box/check_void.php");
include("includes/html/box/vendor_payment_unposted.php"); ?>

