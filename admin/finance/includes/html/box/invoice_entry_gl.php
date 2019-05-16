
<script language="JavaScript1.2" type="text/javascript">


function SetGlEntryType(){
 
	var GlEntryType = $("#GlEntryType").val();
	if(GlEntryType == "Single"){ 

	 $("#glAccountSingleRow").show(1000);
	 $("#glAccountSingleRowFld").show(1000);
	 $("#glAccountMultipleRow").hide(1000);

	 
	}else if(GlEntryType == "Multiple"){ 

		$("#glAccountSingleRow").hide(1000);
		$("#glAccountSingleRowFld").hide(1000);
		$("#glAccountMultipleRow").show(1000);
	}else{ 
		$("#glAccountMultipleRow").hide(1000);
		$("#glAccountSingleRow").hide(1000);
		$("#glAccountSingleRowFld").hide(1000);
	}	
    
}



var ConfigCurrency = '<?=$Config["Currency"]?>';

function GetCurrencyRateGL(){	
	 
	var CurrencyGL = $("#CurrencyGL").val();
	var CurrencyDate =  $("#PaymentDate").val();
	$("#ConversionRateGL").val('');
	$("#ConversionRateGL").addClass('loaderbox');
	if(ConfigCurrency!=CurrencyGL){	
		$("#ConversionRateGL").show();
		$("#ConversionRateGLLabel").show();		
		var SendUrl ='action=getCurrencyRateByModule&Module=AR&Currency='+escape(CurrencyGL)+'&CurrencyDate='+escape(CurrencyDate)+'&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendUrl,
			success: function (responseText) { 
				$("#ConversionRateGL").removeClass('loaderbox');	
				$("#ConversionRateGL").val(responseText);						
			}

		});
	}else{
		$("#ConversionRateGL").removeClass('loaderbox');	
		$("#ConversionRateGL").val('1');
		$("#ConversionRateGL").hide();
		$("#ConversionRateGLLabel").hide();			
	}

	
}


function CheckInvoiceField(MSG_SPAN,FieldName,editID){ 
	document.getElementById(MSG_SPAN).innerHTML="";
	
	FieldLength = document.getElementById(FieldName).value.length;

	if(FieldLength>=3){
		document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
		var Url = "isRecordExists.php?SaleInvoiceID="+escape(document.getElementById(FieldName).value)+"&editID="+editID;
		var SendUrl = Url+"&r="+Math.random(); 
		 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function RecieveAvailFieldRequest(){
			if (httpObj.readyState == 4) {
				
				if(httpObj.responseText==1) {	 
					document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Not Available!</span>";
					ShowAdjustPopup();
				}else if(httpObj.responseText==0) {	 
					document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>Available!</span>";
				}else {
					alert("Error occur : " + httpObj.responseText);
				}
			}
		};
		httpObj.send(null);

	}else if(FieldLength>0){
		document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>It should be minimum of 3 characters long.</span>";
	}

	
}

</script>



  <!--FOR GL ACCOUNT-->

  <table width="100%"  border="0" align="center"   cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 
        <?php   
        $arryRecurr = $arrySale;
        include("../includes/html/box/recurring_gl.php");
        
        ?>

	<? if($arrySale[0]['OrderPaid']>0) { ?>
	<tr>
		 <td  align="right"   class="blackbold" >Payment Status  : </td>
		<td   align="left" >	

<? echo $objSale->GetCreditStatusMsg($arrySale[0]['Status'],$arrySale[0]['OrderPaid']); ?>


		</td>
	</tr>
	<? } ?>


      <? if($arrySale[0]['CreatedDate']>0){ ?>
		<tr>
		<td  align="right"   class="blackbold" > Created Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['CreatedDate'])); ?>
		</td>
		<td  align="right"   class="blackbold" >  Updated Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['UpdatedDate'])); ?>
		</td>
		</tr>
	<? } ?>
    <tr>
        <td  align="right"   class="blackbold" width="15%" valign="top"> Invoice Number # : </td>
        <td   align="left" width="35%">
<? if(!empty($_GET['edit'])) {?>
	<input name="SoInvoiceIDGL" type="text" class="datebox" id="SoInvoiceIDGL"    value="<?php echo stripslashes($arrySale[0]['InvoiceID']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SoInvoiceIDGL');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckInvoiceField('MsgSpan_InvoiceIDGL','SoInvoiceIDGL','<?=$_GET['edit']?>');" oncontextmenu="return false" />
		 &nbsp;&nbsp;<span id="MsgSpan_InvoiceIDGL"></span>
<?}else{?>
		 <input name="SoInvoiceIDGL" type="text" class="datebox"  id="SoInvoiceIDGL" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_InvoiceIDGL');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckInvoiceField('MsgSpan_InvoiceIDGL','SoInvoiceIDGL','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" />
		 &nbsp;&nbsp;<span id="MsgSpan_InvoiceIDGL"></span>

<? } ?>
		</td>
   
 
	<td  align="right" width="20%"  class="blackbold">Customer : <span class="red">*</span></td>
	<td   align="left" >
		 <select id="CustCodeGL" class="inputbox" name="CustCodeGL" onchange="Javascript:setDefaultAccount(0);">
			   <option value="">---Select---</option>
			   <? 


 if(!empty($arryCustomer)){
				for($i=0;$i<sizeof($arryCustomer);$i++) {

				$customerHolddisabled = ($arryCustomer[$i]['customerHold']==1)?('disabled'):('');

?>
			    
				 <option CustIDGl="<?=$arryCustomer[$i]['custID']?>" <?=$customerHolddisabled?> value="<?=$arryCustomer[$i]['CustCode'];?>" <?php if($arrySale[0]['CustCode']  == $arryCustomer[$i]['CustCode']){echo "selected";}?>> <?php echo $arryCustomer[$i]['CustomerName']; ?></option>
				<?php } } ?>
			</select>
		

	<input type="hidden" name="DefaultAccount" id="DefaultAccount" value="" class="textbox">
<script>
$("#CustCodeGL").select2();
</script>
	
	</td>
	</tr>	
        
         <tr>
        <td align="right"   class="blackbold"> <span id="adjustamountspan">Invoice Amount :</span> <span class="red">*</span></td>
        <td align="left">
		<?php if(!empty($arryOtherIncome[0]['Amount'])){$Amnt = $arryOtherIncome[0]['Amount'];}else{$Amnt = "0.00";}?>
    	<input name="Amount" type="text" class="textbox" size="15" id="Amount" onkeypress="return isDecimalKeyNeg(event,this);"  value="<?=$Amnt?>" maxlength="20" autocomplete="off"/>  
		   
		</td>
    
	<td  align="right"   class="blackbold" >GL Entry Type : <span class="red">*</span></td>
	<td   align="left" >
	 <select name="GlEntryType" class="inputbox" id="GlEntryType" onchange="Javascript:SetGlEntryType();">
		    <option value="">--- Select ---</option>
                        <option value="Single" <?php if($arryOtherIncome[0]['GlEntryType'] == 'Single'){echo "selected";}?>>Single</option>
                        <option value="Multiple" <?php if($arryOtherIncome[0]['GlEntryType'] == 'Multiple'){echo "selected";}?>>Multiple</option>
			 
		</select> 
	</td>
	</tr>	
     



 <tr >

<td  align="right"   class="blackbold" > Currency  :<span class="red">*</span> </td>
	<td   align="left" >
<? 
 
if(empty($arrySale[0]['CustomerCurrency']))$arrySale[0]['CustomerCurrency']= $Config['Currency'];

$arrySelCurrency=array();
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);
$HideRate='';

if($arrySale[0]['CustomerCurrency']==$Config['Currency']){
	$HideRate = 'style="display:none;"';
}
 
?>
<select name="CurrencyGL" class="textbox" id="CurrencyGL"  style="width:100px;" onChange="Javascript: GetCurrencyRateGL();">

	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arrySale[0]['CustomerCurrency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>

<td  align="right"   class="blackbold" id="ConversionRateGLLabel" <?=$HideRate?>> Conversion Rate  : </td>
	<td   align="left" >
<input type="text" onkeypress="return isDecimalKey(event);" maxlength="20" size="8"  class="textbox"  value="<?=$arrySale[0]['ConversionRate']?>" id="ConversionRateGL" name="ConversionRateGL" <?=$HideRate?>>

</td>
 
      </tr>


	<tr>
          	
                <td  align="right" class="blackbold"><span id="glAccountSingleRow" style="display: none;">GL Account : <span class="red">*</span></span></td>
		<td  align="left">
                    <span id="glAccountSingleRowFld" style="display: none;">
                    <select name="IncomeTypeID" class="inputbox" id="IncomeTypeID">
                    <option value="">--- Select ---</option>
                    <? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
                    <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?php if($arryOtherIncome[0]['IncomeTypeID'] == $arryBankAccount[$i]['BankAccountID']){echo "selected";}?>>
                    &nbsp;<?=$arryBankAccount[$i]['AccountName']?> [<?=$arryBankAccount[$i]['AccountNumber']?>]
                    </option>
                    <? } ?>
                    </span>
                    </select> 




		</td>
	 
		
	</tr>  
	
	<tr>
		<td  align="right" valign="top"  class="blackbold">Invoice Date  :<span class="red">*</span> </td>
		
		<td   align="left" valign="top" >
                    <script type="text/javascript">
			$(function() {
			$('#PaymentDate').datepicker(
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
		<?php 	
			
			if(!empty($arryOtherIncome[0]['PaymentDate'])){
				$paymentDate = $arryOtherIncome[0]['PaymentDate'];
			}else{
			 $arryTime = explode(" ",$Config['TodayDate']);
			 $paymentDate = $arryTime[0];
			}
			 
		?>
		 <input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$paymentDate;?>"  type="text" > 
                 
                 <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $IECurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>
		</td>
	 

	 
	<td valign="top" align="right" class="blackbold">Invoice Comment :</td>
		<td align="left">
                    <textarea id="InvoiceCommentGL" class="textarea" type="text" name="InvoiceCommentGL"><?=stripslashes($arrySale[0]['InvoiceComment'])?></textarea></td>


	</tr>	

        <tr id="glAccountMultipleRow" style="display:none;">
			<td colspan="4">
				<? 	include("includes/html/box/add_multi_gl.php");?>
			</td>
		</tr>


<?
 
$CreditCardDisplay = 'style="display:none;"';
if(!empty($OrderID) && !empty($arrySale[0]['CustCode'])){
	$CreditCardDisplay = '';
} 
?>

	  <tr id="glCreditCardRow"  <?=$CreditCardDisplay?>>
			<td colspan="4"> 
				<? include("includes/html/box/credit_card_gl.php");?>
			</td>
		</tr>
	 
</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
	    <input type="hidden" name="IncomeID" id="IncomeID" value="<?=$_GET['edit'];?>">
	
	</td>
	</tr>
</table>
<? if($arrySale[0]['InvoiceEntry']==2){?>
<script language="JavaScript1.2" type="text/javascript">
  SetGlEntryType();
</script>    
<? } ?>

 <!--END FOR GL ACCOUNT--->
