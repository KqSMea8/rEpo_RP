<?

if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryPurchase[0]['Currency']) && !in_array($arryPurchase[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryPurchase[0]['Currency'];
}
?>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">
function GetCurrencyRate(CurrencyGL,Line){
	var ConfigCurrency = $("#ConfigCurrency").val();
	if(ConfigCurrency!=CurrencyGL){
		var SendUrl ='action=getCurrencyRate&Currency='+CurrencyGL+'&r='+Math.random(); 
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax_pay.php',
			data: SendUrl,
			success: function (responseText) { 	
				$("#ConversionRateGl"+Line).val(responseText);	
				$("#ConversionRateGl"+Line).show();		
			}

		});
	}else{
		$("#ConversionRateGl"+Line).val('1');
		$("#ConversionRateGl"+Line).hide();		
	}

	
}

 

$(document).ready(function () {
	var counter = 1;      
	$("#addrowgl").on("click", function () { 	

		counter = parseInt($("#NumLineGL").val()) + 1;
	
		var newRow = $("<tr class='itembg'>");
		var cols = "";
		var BankCurrency = $("#BankCurrency").val();  
		var ConversionRateGL = $("#ConversionRateGL").val();
	
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete"></td><td><select name="AccountIDGL' + counter + '" class="inputbox" id="AccountIDGL' + counter + '" ><option value="">--- Select ---</option><? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?><option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"><?=stripslashes($arryBankAccountList[$i]['AccountName']);?> [<?=$arryBankAccountList[$i]['AccountNumber']?>]</option><? } ?></select></td><td><!--select style="width:100px;" name="CurrencyGL' + counter + '" class="inputbox" id="CurrencyGL' + counter + '" onChange="Javascript: GetCurrencyRate(this.value,'+counter+');"><? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?><option value="<?=$arrySelCurrency[$i]?>" <?if($arrySelCurrency[$i]==$Config["Currency"]){echo "selected";}?> ><?=$arrySelCurrency[$i]?></option><? } ?></select--><input type="text" name="CurrencyGL' + counter + '"  id="CurrencyGL' + counter + '"  class="textbox disabled CurrencyGLCls" size="10" maxlength="15" value="'+BankCurrency+'" readonly /></td><td style="display:none"><input style="display:none1;" type="text" name="ConversionRateGl' + counter + '"  id="ConversionRateGl' + counter + '"  class="textbox ConversionGLCls" size="10" maxlength="15"  onkeypress="return isDecimalKey(event);" value="'+ConversionRateGL+'" readonly /></td><td><input type="text" name="AmountGL' + counter + '"  id="AmountGL' + counter + '" class="textbox" size="10" maxlength="15" onkeypress="return isDecimalKeyNeg(event);"/></td><td align="right"><a href="Javascript:AddGlToTransaction(' + counter + ');" id="addrog_' + counter + '" class="add" style="float:left;display:none;">Add</a><input type="text" name="paymentGL' + counter + '" id="paymentGL' + counter + '" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="width:90px;text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLineGL").val(counter);
		$("#AccountIDGL"+counter).select2();
		counter++;
	});


	$("table.order-list").on("blur", 'input[name^="AmountGL"],input[name^="ConversionRateGl"],select[name^="CurrencyGL"]', function (event){ 
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();  
      });

	

	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

	});


	 

});


     

	function calculateRow(row){ 	
		
	   	var  AmountGL = +row.find('input[name^="AmountGL"]').val();		
		//var ConversionRateGl = +row.find('input[name^="ConversionRateGl"]').val();	
		var ConversionRateGl = 1;
		
		if(ConversionRateGl<=0){			
			ConversionRateGl=1;
		}		
             
         	var SubTotal = '';
		<? if($_SESSION['ConversionType']==1){ ?>
		SubTotal = AmountGL/ConversionRateGl;  
		<? }else{ ?>
		SubTotal = AmountGL*ConversionRateGl;  
		<? } ?>  

		row.find('input[name^="paymentGL"]').val(SubTotal.toFixed(2));

		if(SubTotal!='' && SubTotal!='0'){
			row.find('a[id^="addrog_"]').show();			
		}else{
			row.find('a[id^="addrog_"]').hide();	
		}
	}

	

	function calculateGrandTotal() {
	
		var subtotal=0, TotalAmountGL=0, paymentGL = 0; ;		
		

		$("table.order-list").find('input[name^="paymentGL"]').each(function () 
		{
			paymentGL = $(this).val();
			subtotal += +paymentGL;

			$("#TotalAmountGL").val(subtotal.toFixed(2));
						
		});		
    
	}




</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >   
 <tr>
<td class="head1">GL Account</td>
</tr>



 <tr>
     <td valign="top">
 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td width="1%" class="heading"></td>
                     
		<td width="25%" class="heading">GL Account</td>
		<td width="15%" class="heading">Currency</td>
		
		<td width="1%" class="heading" style="display:none">Conversion Rate</td>
		<td width="15%" class="heading">Amount</td>
                	
                	
		
		<td  class="heading" align="right">Payment</td>
    </tr>
</thead>
<tbody>
	<? 
	$subtotal=0;
 $NumLineGL=0; //change in edit mode
	for($Line=1;$Line<=$NumLineGL;$Line++) { 
		$Count=$Line-1;	
		

	



	?>
     <tr class='itembg'>
		<td>
<img src="../images/delete.png" id="ibtnDel" title="Delete">

		</td>
               
                   
                       
                                              
<td valign="top">
<select name="AccountIDGL<?=$Line?>" class="inputbox" id="AccountIDGL<?=$Line?>" >
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
						<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" <?php if($arryJournalEntry[$Count]['AccountID'] == $arryBankAccountList[$i]['BankAccountID'] ){ echo "selected";}?>>
						<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
						[<?=$arryBankAccountList[$i]['AccountNumber']?>]
				   </option>
					<? } ?>
			</select> 
			
		 
</td>
        <td>
<?
if(!empty($arryTranGL[0]['Currency'])){
	$CurrencySelected = $arryTranGL[0]['Currency'];
}else{
	$CurrencySelected = $Config['Currency'];
}


?>
<!--select name="CurrencyGL<?=$Line?>" class="textbox" style="width:100px;" id="CurrencyGL<?=$Line?>" onChange="Javascript: GetCurrencyRate(this.value,<?=$Line?>);">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?if($arrySelCurrency[$i]==$CurrencySelected){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select-->

<input type="text" name="CurrencyGL<?=$Line?>"  id="CurrencyGL<?=$Line?>"  class="textbox disabled CurrencyGLCls" size="10" maxlength="15" value="<?=$CurrencySelected?>" readonly />


 </td>
	 
        
<? $HideCurrency = ($CurrencySelected == $Config['Currency'])?('style="display:none"'):(''); ?>        
        <td style="display:none"><input <?=$HideCurrency?> data-qty="y" type="text" name="ConversionRateGl<?=$Line?>" id="ConversionRateGl<?=$Line?>" class="textbox ConversionGLCls" size="10" maxlength="6" readonly onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["ConversionRate"])?>"/></td>
        <td><input type="text" name="AmountGL<?=$Line?>" id="AmountGL<?=$Line?>" class="textbox" size="10" maxlength="15" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["Amount"])?>"/> </td>
       
       
       
       <td align="right">
<a href="Javascript:AddGlToTransaction(<?=$Line?>);" id="addrog_<?=$Line?>" class="add_row" style="float:left;display:none;">Add</a>

<input type="text" align="right" name="paymentGL<?=$Line?>" id="paymentGL<?=$Line?>" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="width:90px;text-align:right;" value=""/></td>
       
    </tr>
	<? 
		$subtotal += $arrySaleItem[$Count]["paymentGL"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="13" align="right">

		 <a href="Javascript:void(0);"  id="addrowgl" class="add_row" style="float:left">Add Row</a>
		 
       		 <input type="hidden" name="NumLineGL" id="NumLineGL" value="<?=$NumLineGL?>" readonly maxlength="20"  />
        	 <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
 <input type="hidden" name="ConfigCurrency" id="ConfigCurrency" value="<?=$Config['Currency']?>"  readonly />


		
<? (empty($TotalAmountGL))?($TotalAmountGL=""):(""); ?>

<!--/div-->
		<br>
		<b>Total Amount :</b> <input type="text" align="right" name="TotalAmountGL" id="TotalAmountGL" class="disabled" readonly value="<?=$TotalAmountGL?>" style="width:90px;text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

 </td>
    </tr>
</table>



