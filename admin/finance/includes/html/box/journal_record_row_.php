<?php
 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
 } 

?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";

        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp; <select name="AccountID' + counter + '" class="inputbox" id="AccountID' + counter + '" onChange="Javascript: SetAccountName(this.value,'+counter+');"><option value="">--- Select ---</option><? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?><option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"><?=stripslashes($arryBankAccountList[$i]['AccountName']);?>- (<?=$arryBankAccountList[$i]['AccountType']?>)</option><? } ?></select><input type="hidden" name="AccountName' + counter + '" id="AccountName' + counter + '" value=""></td><td><input type="text" name="DebitAmnt' + counter + '" id="DebitAmnt' + counter + '" class="textbox" onkeypress="return isDecimalKey(event);" value="0.00" style="width:90px;"  maxlength="50" /></td><td><input type="text" name="CreditAmnt' + counter + '" id="CreditAmnt' + counter + '"  onkeypress="return isDecimalKey(event);" class="textbox" value="0.00" style="width:90px;"  maxlength="50"/></td><td><select name="EntityType' + counter + '" class="inputbox" id="EntityType' + counter + '" style="width:150px;" onChange="Javascript: CustomerList('+counter+');"><option value="">--- Select ---</option><option value="customer">Customer</option><option value="employee">Employee</option><option value="supplier">Supplier</option></select>&nbsp;&nbsp;&nbsp;<select name="EntityID' + counter + '" class="inputbox" id="EntityID' + counter + '" style="width:150px;" onChange="Javascript: SetEntityName(this.value,'+counter+');"><option value="">Loading...</option></select><input type="hidden" name="EntityName' + counter + '" id="EntityName' + counter + '" value=""></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
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
		<td width="20%" class="heading">&nbsp;&nbsp;&nbsp;Account Name</td>
		<td width="10%" class="heading">Debit</td>
		<td width="10%" class="heading">Credit</td>
		<td width="20%" class="heading">Entity</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		
	?>
     <tr class='itembg'>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="AccountID<?=$Line?>" class="inputbox" id="AccountID<?=$Line?>" onChange="Javascript: SetAccountName(this.value,<?=$Line?>);">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
						<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>">
						<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
						- (<?=$arryBankAccountList[$i]['AccountType']?>)
				   </option>
					<? } ?>
			</select> 
			<input type="hidden" name="AccountName<?=$Line?>" id="AccountName<?=$Line?>" value="">
		</td>
        <td><input type="text" name="DebitAmnt<?=$Line?>" id="DebitAmnt<?=$Line?>" class="textbox" style="width:90px;" onkeypress="return isDecimalKey(event);"  maxlength="50" value="0.00"/></td>
        <td><input type="text" name="CreditAmnt<?=$Line?>" id="CreditAmnt<?=$Line?>" class="textbox" style="width:90px;" onkeypress="return isDecimalKey(event);"  maxlength="50" value="0.00"/></td>
        <td> <select name="EntityType<?=$Line?>" class="inputbox" id="EntityType<?=$Line?>" style="width:150px;" onChange="Javascript: CustomerList(<?=$Line?>);">
					<option value="">--- Select ---</option>
					<option value="customer">Customer</option>
					<option value="employee">Employee</option>
					<option value="supplier">Supplier</option>
					
			</select>&nbsp;&nbsp;&nbsp;
                   
			<select name="EntityID<?=$Line?>" class="inputbox" id="EntityID<?=$Line?>" style="width:150px;" onChange="Javascript: SetEntityName(this.value,<?=$Line?>);"><option value="">Loading...</option></select>
		<input type="hidden" name="EntityName<?=$Line?>" id="EntityName<?=$Line?>" value="">
               </td>
      
       
    </tr>
	<?php } ?>

 
</tbody>
<tfoot>

	<tr class='itembg'>
	<td  align="right" height="30">
		
		<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
		<input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />	
	<strong>Total</strong>
       </td>
	<td>&nbsp;<input type="text" align="right" name="TotalDebit" id="TotalDebit" size="15" value="0.00" style="width:90px;" /></td>
	<td>&nbsp;<input type="text" align="right" name="TotalCredit" id="TotalCredit" size="15" value="0.00" style="width:90px;" /></td>
	<td>&nbsp;</td>
    </tr>
</tfoot>
</table>
<div style="padding-top:20px;padding-bottom:25px;">
<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add New Record</a>
</div>
<? echo '<script>SetInnerWidth();</script>'; ?>

<script type="text/javascript">

var httpObj = false;
		try {
			  httpObj = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj = false;
			}
	  }

	}

var httpObj2 = false;
		try {
			  httpObj2 = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj2 = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj2 = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj2 = false;
			}
	  }

	}

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


function CustomerList(numRow){
		 
		ShowHideLoader('1','L');
		var SendUrl = 'ajax.php?action=Entitylist&EntityType='+document.getElementById("EntityType"+numRow).value+'&r='+Math.random()+'&numRow='+numRow+'&select=1'; 
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				
				document.getElementById("EntityID"+numRow).innerHTML  = httpObj.responseText;
				ShowHideLoader('');

			}
		};
		httpObj.send(null);
	}




function SetEntityName(EntityID,numRow){

		 

		ShowHideLoader('1','L');
		var SendUrl = 'ajax.php?action=EntityName&EntityType='+document.getElementById("EntityType"+numRow).value+'&EntityID='+EntityID+'&r='+Math.random()+'&numRow='+numRow+'&select=1'; 
		httpObj2.open("GET", SendUrl, true);
		//alert(SendUrl);
		httpObj2.onreadystatechange = function StateListRecieve(){
			if (httpObj2.readyState == 4) {
				//alert(httpObj2.responseText);
				document.getElementById("EntityName"+numRow).value  = httpObj2.responseText;
				ShowHideLoader('');

			}
		};
		httpObj2.send(null);
		 
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
<SCRIPT LANGUAGE=JAVASCRIPT> 
 CustomerList();
</SCRIPT>
