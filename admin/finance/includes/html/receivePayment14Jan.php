<script src="js/cashReceipt.js"></script>
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
$( document ).ready(function() {
  setTimeout(function() {
    $('.message').fadeOut('fast');
}, 5000); 
}); 
</script>
<a href="viewSalesPayments.php" class="back">Back</a>
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
        <td  align="right"  class="blackbold">Customer : <span class="red">*</span></td>
        <td  align="left">
			
                        <select name="CustomerName" id="CustomerName" class="inputbox" onChange="return checkContra(this.value);">
                            <option value="">---Select---</option>
                            <?php foreach($arryCustomerList as $values){?>
                            <option value="<?=$values['custID']?>" <?=($arryTransaction[0]['CustID']==$values['custID'])?('selected'):('')?>><?=$values['CustomerName']?></option>
                            <?php }?>
                            
                        </select>
			

<input type="hidden" name="CustIDOld" id="CustIDOld" value="<?=$arryTransaction[0]['CustID']?>" readonly>	

		</td>
     </tr>
	 <tr>
        <td align="right"   class="blackbold">Amount Received : <span class="red">*</span></td>
        <td align="left">
		  <input name="ReceivedAmount" type="text" class="inputbox" id="ReceivedAmount" style="width: 90px;" maxlength="10" onkeypress="return isDecimalKey(event);"  value="<?=$arryTransaction[0]['TotalAmount']?>"/>

  <!--input name="ReceivedAmount" type="text" class="inputbox" id="ReceivedAmount" style="width: 90px;" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="javascript:ChangeAmount();"  value="" -->

 <input name="ReceivedAmountOld" type="hidden" class="inputbox" readonly id="ReceivedAmountOld" value="" />
<input name="ConfirmContra" type="hidden" class="inputbox" readonly id="ConfirmContra" value="0" />
		 
		</td>
     </tr>
   <tr>
        <td  align="right"  class="blackbold">Entry Type : <span class="red">*</span></td>
        <td   align="left">
				
	  <select name="EntryType" class="inputbox" id="EntryType" onChange="getEntryType(this.value);">
	  	<option value="">--- Select ---</option>
		<option value="Invoice" <?=($arryTransaction[0]['EntryType']=='Invoice')?('selected'):('')?>>Invoice</option>
		<option value="GL Account" <?=($arryTransaction[0]['EntryType']=='GL Account')?('selected'):('')?>>GL Account</option>
		 
	</select> 
		
		</td>
     </tr>
     
    <tr <?=($arryTransaction[0]['EntryType']=='GL Account')?(''):('style="display: none;"')?> id="showGLCode">
        <td  align="right" class="blackbold">GL Account : <span class="red">*</span></td>
        <td   align="left">
<select name="GLCode" class="inputbox" id="GLCode">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
	<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"  <?=($arryTransaction[0]['GLCode']==$arryBankAccountList[$i]['BankAccountID'])?('selected'):('')?>>
	<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
	[<?=$arryBankAccountList[$i]['AccountNumber']?>]
	</option>
	<? } ?>
</select> 


		</td>
    </tr>  
	 <tr>
        <td  align="right"  class="blackbold">Deposit To : <span class="red">*</span></td>
        <td   align="left">
		
	
<select name="PaidTo" class="inputbox" id="PaidTo" onchange="Javascript:setDefaultCheckNumber();">
    <option value="">--- Select ---</option>
<? 
for($i=0;$i<sizeof($arryBankAccount);$i++) {
	$selected='';
	if($_GET['edit']>0){ 
		if($arryBankAccount[$i]['BankAccountID']==$arryTransaction[0]['AccountID']) $selected='Selected'; 
	}else if($arryBankAccount[$i]['DefaultAccount']==1){
		 $selected='Selected';
	}

?>
     <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?=$selected?>>
     <?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
            <? } ?>
</select> 
		
		</td>
     </tr>
	<tr>
        <td  align="right" class="blackbold">Payment Method : <span class="red">*</span></td>
        <td   align="left">
		  <select name="Method" class="inputbox" id="Method" onChange="getPaymentMethodName(this.value);">
		  	<option value="">--- Select ---</option>
<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {
	//if(strtolower($arryPaymentMethod[$i]['attribute_value'])!='check'){
?>
	<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?=($arryTransaction[0]['Method']==$arryPaymentMethod[$i]['attribute_value'])?('selected'):('')?>>
	<?=$arryPaymentMethod[$i]['attribute_value']?>
</option>
<? //}

} ?>
		</select> 
		</td>
  </tr>
   <!--tr style="display: none;" id="CheckBankNameTr">
            <td  align="right" class="blackbold">Bank Name : <span class="red">*</span></td>
            <td  align="left"><input name="CheckBankName" type="text" class="inputbox" id="CheckBankName" value="<?=stripslashes($arryTransaction[0]['CheckBankName'])?>" /></td>
         </tr-->

 <tr style="display: none;" id="CheckNumberTr">
            <td  align="right" class="blackbold">Check Number : <span class="red">*</span></td>
            <td  align="left"><input name="CheckNumber" type="text" class="inputbox" id="CheckNumber" maxlength="20" value="<?=stripslashes($arryTransaction[0]['CheckNumber'])?>"  onKeyPress="Javascript:return isNumberKey(event);"   /> &nbsp;&nbsp;<span id="MsgSpan_CheckNumber"></span>


<input type="hidden" class="inputbox" name="Voided" id="Voided" value="0">

</td>
         </tr>

 
	<!--tr style="display: none;" id="CheckFormatTr">
        <td  align="right" class="blackbold">Check Format : <span class="red">*</span></td>
        <td   align="left">
<?
$CheckFormat1 = 'Check, Stub, Stub';
$CheckFormat2 = 'Stub, Check, Stub';
$CheckFormat3 = 'Stub, Stub, Check';
?>
<select name="CheckFormat" class="inputbox" id="CheckFormat" onchange="Javascript:PrintCheck();">
	<option value="">--- Select ---</option>
	<option value="<?=$CheckFormat1?>" <?=($arryTransaction[0]['CheckFormat']==$CheckFormat1)?('selected'):('')?>><?=$CheckFormat1?></option>
	<option value="<?=$CheckFormat2?>" <?=($arryTransaction[0]['CheckFormat']==$CheckFormat2)?('selected'):('')?>><?=$CheckFormat2?></option>
	<option value="<?=$CheckFormat3?>" <?=($arryTransaction[0]['CheckFormat']==$CheckFormat3)?('selected'):('')?>><?=$CheckFormat3?></option>
</select> 
		</td>
    </tr-->   
 
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
		<input id="Date" name="Date" readonly="" class="datebox" value="<?=$Date?>"  type="text" > 
                <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $ARCurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>

		</td>
	</tr>
	
	 <tr>
            <td  align="right" class="blackbold">Reference No : </td>
            <td  align="left"><input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value="<?=stripslashes($arryTransaction[0]['ReferenceNo'])?>"  /></td>
         </tr>
	 <tr>
            <td valign="top" align="right" class="blackbold">Payment Comment :</td>
            <td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment" maxlenghth="500"><?=stripslashes($arryTransaction[0]['Comment'])?></textarea></td>
	</tr>
	</table>
	 </td>
	</tr>
        <tr>
            <td colspan="2" id="invoiveList" align="center"></td>
        </tr>
        
          <tr>
            <td colspan="2" align="center">
<input type="submit" class="button" name="save_payment" id="save_payment" style="display: none;" value="Save Payment">

<input type="hidden" name="TransactionID" id="TransactionID" value="<?=$TransactionID?>" readonly>

<input type="hidden" name="ContraTransactionID" id="ContraTransactionID" value="<?=$ContraTransactionID?>" readonly>

</td>
        </tr>
	</table>
 </form>

<?php }?>

<div id="dialog-modal2" style="display: none;"></div>

<? if($_GET['edit']>0){ ?>
<script type="text/javascript">
  getPaymentMethodName('<?=$arryTransaction[0]["Method"]?>');
  SetCustomerInvoice('<?=$arryTransaction[0]["CustID"]?>','<?=$confirmContra?>');
</script>
<? } ?>


<br><br>
<? 
	include("includes/html/box/customer_receipt_unposted.php"); 
?>
