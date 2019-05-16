<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
        var counter2 = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";

        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp; <select name="AccountID' + counter + '" class="inputbox" id="AccountID' + counter + '" onChange="Javascript: SetAccountName(this.value,'+counter+');"><option value="">--- Select ---</option><? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?><option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"><?=stripslashes($arryBankAccountList[$i]['AccountName']);?> [<?=$arryBankAccountList[$i]['AccountNumber']?>]</option><? } ?></select><input type="hidden" name="AccountName' + counter + '" id="AccountName' + counter + '" value=""></td><td><input type="text" name="DebitAmnt' + counter + '" id="DebitAmnt' + counter + '" class="textbox" onkeypress="return isDecimalKey(event);" value="0.00" style="width:90px;"  maxlength="50" /></td><td><input type="text" name="CreditAmnt' + counter + '" id="CreditAmnt' + counter + '"  onkeypress="return isDecimalKey(event);" class="textbox" value="0.00" style="width:90px;"  maxlength="50"/></td><td><input type="text" name="Comment' + counter + '" id="Comment' + counter + '" class="inputbox"  maxlength="100"/></td>';



              counter2 = parseInt($("#NumLine").val()) + 2;

               var newRow2 = $("<tr class='itembg'>");
               var cols2 = "";

              cols2 += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp; <select name="AccountID' + counter2 + '" class="inputbox" id="AccountID' + counter2 + '" onChange="Javascript: SetAccountName(this.value,'+counter2+');"><option value="">--- Select ---</option><? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?><option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"><?=stripslashes($arryBankAccountList[$i]['AccountName']);?> [<?=$arryBankAccountList[$i]['AccountNumber']?>]</option><? } ?></select><input type="hidden" name="AccountName' + counter2 + '" id="AccountName' + counter2 + '" value=""></td><td><input type="text" name="DebitAmnt' + counter2 + '" id="DebitAmnt' + counter2 + '" class="textbox" onkeypress="return isDecimalKey(event);" value="0.00" style="width:90px;"  maxlength="50" /></td><td><input type="text" name="CreditAmnt' + counter2 + '" id="CreditAmnt' + counter2 + '"  onkeypress="return isDecimalKey(event);" class="textbox" value="0.00" style="width:90px;"  maxlength="50"/></td><td><input type="text" name="Comment' + counter2 + '" id="Comment' + counter2 + '" class="inputbox"  maxlength="100"/></td>';

		newRow.append(cols);
                
                newRow2.append(cols2);
                
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);		
                
                $("table.order-list").append(newRow2);
		$("#NumLine").val(counter2);

		$("#AccountID"+counter).select2();
		$("#AccountID"+counter2).select2();

		counter++;
		counter2++;
	});


	$("table.order-list").on("blur", 'input[name^="DebitAmnt"],input[name^="CreditAmnt"]', function (event) {
		
		calculateGrandTotal();
		
	});


	$("table.order-list").on("blur", 'input[name^="DebitAmnt"]', function (event) {
		
		var row = $(this).closest("tr");
		var DebitAmntVal = row.find('input[name^="DebitAmnt"]').val(); 

		if(parseInt(DebitAmntVal) > 0){
			row.find('input[name^="CreditAmnt"]').val('0.00');
		}
		

		calculateGrandTotal();
		
	});

	$("table.order-list").on("blur", 'input[name^="CreditAmnt"]', function (event) {
		
			var row = $(this).closest("tr");
			var CreditAmntVal = row.find('input[name^="CreditAmnt"]').val(); 

			if(parseInt(CreditAmntVal) > 0){
				row.find('input[name^="DebitAmnt"]').val('0.00');
			}
		 


			calculateGrandTotal();
		
		});

	


	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="JournalEntryID"]').val(); 
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



	function calculateGrandTotal() {

		var totalDebitAmount=0;
		var totalCreditAmount=0;
		
		
		$("table.order-list").find('input[name^="DebitAmnt"]').each(function () {
			totalDebitAmount += +$(this).val();
		});

		$("table.order-list").find('input[name^="CreditAmnt"]').each(function () {
			totalCreditAmount += +$(this).val();
		});

			
		$("#TotalDebit").val(totalDebitAmount.toFixed(2));
		$("#TotalCredit").val(totalCreditAmount.toFixed(2));

		 
	}


</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td width="25%" class="heading">&nbsp;&nbsp;&nbsp;Account Name</td>
		<td width="10%" class="heading bank_currency_td" style="display:none">Bank Currency</td>
		<td width="12%" class="heading">Debit </td>
		<td width="12%" class="heading">Credit</td>
		<td  class="heading conversion_td" style="display:none">Conversion Rate</td>
		<td width="12%" class="heading">Comment</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		
	?>
     <tr class='itembg'>
		<td>
<?=($Line>2)?('<img src="../images/delete.png" id="ibtnDel">&nbsp;&nbsp;'):("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")?>
<select name="AccountID<?=$Line?>" class="inputbox" id="AccountID<?=$Line?>" onChange="Javascript: SetAccountName(this.value,<?=$Line?>);">
					<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {

$BankCurrency = (!empty($arryBankAccountList[$i]['BankCurrency']))?($arryBankAccountList[$i]['BankCurrency']):($Config["Currency"]);
?>
<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" BankFlag="<?=$arryBankAccountList[$i]['BankFlag']?>" BankCurrency="<?=$BankCurrency?>" <?php if($arryJournalEntry[$Count]['AccountID'] == $arryBankAccountList[$i]['BankAccountID'] ){ echo "selected";}?>>
<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
[<?=$arryBankAccountList[$i]['AccountNumber']?>]
</option>
					<? } ?>
			</select> 
<script>
$("#AccountID"+<?=$Line?>).select2();
</script> 

 



			<input type="hidden" name="AccountName<?=$Line?>" id="AccountName<?=$Line?>" value="<?=$arryJournalEntry[$Count]['AccountName']?>">
			<input type="hidden" name="JournalEntryID<?=$Line?>" id="JournalEntryID<?=$Line?>" value="<?=stripslashes($arryJournalEntry[$Count]["JournalEntryID"])?>" readonly maxlength="20"  />
		</td>


	<td  class="bank_currency_td" style="display:none">

	<select name="BankCurrency<?=$Line?>" class="textbox"  id="BankCurrency<?=$Line?>" style="display:none" onChange="Javascript:GetBankCurrencyRate();" >
	</select>
	<input type="hidden" name="BankCurrencySel<?=$Line?>" id="BankCurrencySel<?=$Line?>" value="<?=$arryJournalEntry[$Count]['BankCurrency']?>">

	</td>


        <td><input type="text" name="DebitAmnt<?=$Line?>" id="DebitAmnt<?=$Line?>" class="textbox" style="width:90px;" onkeypress="return isDecimalKey(event);"  maxlength="50" value="<?=$arryJournalEntry[$Count]['DebitAmnt']?>"/></td>
        <td><input type="text" name="CreditAmnt<?=$Line?>" id="CreditAmnt<?=$Line?>" class="textbox" style="width:90px;" onkeypress="return isDecimalKey(event);"  maxlength="50" value="<?=$arryJournalEntry[$Count]['CreditAmnt']?>"/></td>

	<td  class="conversion_td" style="display:none"> 
<?  $arryJournalEntry[$Count]['BankCurrencyRate']  ?>
<input type="text" onkeypress="return isDecimalKey(event);" maxlength="20" size="8"  class="textbox"  value="<?=$arryJournalEntry[$Count]['BankCurrencyRate']?>" id="BankConversionRate<?=$Line?>" name="BankConversionRate<?=$Line?>" onChange="Javascript:GetBankCurrencyRate(1);" style="display:none" >

&nbsp;&nbsp;&nbsp;<span id="BaseCurrencyValue<?=$Line?>" class="red" style="display:none"></span>

 </td>
      
       <td><input type="text" name="Comment<?=$Line?>" id="Comment<?=$Line?>" class="inputbox"  maxlength="100" value="<?=stripslashes($arryJournalEntry[$Count]['Comment'])?>"/></td>
       
    </tr>
	<?php } ?>

 
</tbody>
<tfoot>

	<tr class='itembg' id="totallabel">
	<td  align="right" height="30">
		
		<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
		<input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />	
	<strong>Total</strong>
       </td>
<td>&nbsp;<input type="text" align="right" name="TotalDebit" id="TotalDebit" size="15" value="<?=$arryJournal[0]['TotalDebit']?>" style="width:90px;" onkeypress="return isDecimalKey(event);" readonly/></td>
<td>&nbsp;<input type="text" align="right" name="TotalCredit" id="TotalCredit" size="15" value="<?=$arryJournal[0]['TotalCredit']?>" style="width:90px;" onkeypress="return isDecimalKey(event);" readonly/></td>
	<td>&nbsp;</td>
    </tr>
</tfoot>
</table>
<div style="padding-top:20px;padding-bottom:25px;" id="addrowdiv">
<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Rows</a>
</div>
<? echo '<script>SetInnerWidth();</script>'; ?>

<script type="text/javascript">


var httpObj3 = false;
		try {
			 httpObj3 = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj3 = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj3 = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj3 = false;
			}
	  }

	}




function SetAccountName(AccountID,numRow){

		 

		ShowHideLoader('1','L');
		var SendUrl = 'ajax.php?action=SetAccountName&AccountID='+AccountID+'&r='+Math.random()+'&numRow='+numRow+'&select=1'; 
		httpObj3.open("GET", SendUrl, true);
		//alert(SendUrl);
		httpObj3.onreadystatechange = function StateListRecieve(){
			if (httpObj3.readyState == 4) {
				//alert(httpObj2.responseText);
				document.getElementById("AccountName"+numRow).value  = httpObj3.responseText;
				ShowHideLoader('');

			}
		};
		httpObj3.send(null);
		 
	}
 
</script>

