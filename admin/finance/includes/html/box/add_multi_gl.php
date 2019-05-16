<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 1;
	$("#addrowGL").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine1").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";

                cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp; <select name="AccountID' + counter + '" class="inputbox" id="AccountID' + counter + '" onChange="Javascript: SetAccountName(this.value,'+counter+');"><option value="">--- Select ---</option><? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?><option value="<?=$arryBankAccountList[$i]['BankAccountID']?>"><?=stripslashes($arryBankAccountList[$i]['AccountName']);?> [<?=$arryBankAccountList[$i]['AccountNumber']?>]</option><? } ?></select><input type="hidden" name="AccountName' + counter + '" id="AccountName' + counter + '" value=""></td><td><input type="text" name="GlAmnt' + counter + '" id="GlAmnt' + counter + '"  onkeypress="return isDecimalKeyNeg(event,this);" class="textbox" value="0.00" style="width:100px;"  maxlength="20" autocomplete="off" onblur="SetPayAmnt()" />&nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="invoice_check_'+counter+'" id="invoice_check_'+counter+'" onClick="SetPayAmntByCheck('+counter+')"></td><td><input type="text" name="Notes' + counter + '" id="Notes' + counter + '" class="inputbox" value=""  maxlength="50"/></td>';
        
		newRow.append(cols);
                
		//if (counter == 4) $('#addrowGL').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list-gl").append(newRow);
		$("#NumLine1").val(counter);
               
		counter++;
               
	});


	$("table.order-list-gl").on("blur", 'input[name^="GlAmnt"]', function (event) {
		
		calculateGLGrandTotal();
		
	});



	


	$("table.order-list-gl").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItemGL").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItemGL").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGLGrandTotal();

	});

	});



	function calculateGLGrandTotal() {

		var totalglAmnt=0;
		//alert(totalglAmnt);
		$("table.order-list-gl").find('input[name^="GlAmnt"]').each(function () {
			totalglAmnt += +$(this).val();
		});


		$("#TotalGlAmount").val(totalglAmnt.toFixed(2));
		$("#TotalGlAmountHtml").html(totalglAmnt.toFixed(2)); 

		 
	}


    function SetPayAmnt(){
	var totalAmt = 0;
	var totalInvoice = document.getElementById("NumLine1").value;
	var PaidAmount = parseFloat(document.getElementById("Amount").value);

	for(var i=1; i <= totalInvoice;i++){
		if(document.getElementById("GlAmnt"+i) != null){
			var GlAmnt = parseFloat(document.getElementById("GlAmnt"+i).value);

			if(GlAmnt > 0 || GlAmnt < 0){
				totalAmt += GlAmnt;
				document.getElementById("invoice_check_"+i).checked = true;
			}else{
				document.getElementById("GlAmnt"+i).value = '';
				document.getElementById("invoice_check_"+i).checked = false;
			}
		}
	}
	
	
	/*if(totalAmt == PaidAmount){
		document.getElementById("TotalGlAmount").value = totalAmt;
		$("#TotalGlAmountHtml").html(totalAmt.toFixed(2));
	}else{
		document.getElementById("TotalGlAmount").value = '';
		$("#TotalGlAmountHtml").html('');
	}*/
	document.getElementById("TotalGlAmount").value = totalAmt.toFixed(2);
	$("#TotalGlAmountHtml").html(totalAmt.toFixed(2));
	
     }
     
      function SetPayAmntByCheck(line){
          
	var totalAmt = 0,totalInvoice = 0,PaidAmount = 0,invAmnt = 0,remainInvAmnt = 0;

	totalInvoice = document.getElementById("NumLine1").value;
	PaidAmount = document.getElementById("Amount").value;

	for(var i=1; i <= totalInvoice;i++){
		if(document.getElementById("GlAmnt"+i) != null){
			var GlAmnt = parseFloat(document.getElementById("GlAmnt"+i).value);
			if(GlAmnt>0 || GlAmnt<0){
				invAmnt +=  parseFloat(document.getElementById("GlAmnt"+i).value);
			}
		}
	}

	remainInvAmnt = parseFloat(PaidAmount)-parseFloat(invAmnt);


	if(document.getElementById("invoice_check_"+line).checked){
		document.getElementById("GlAmnt"+line).value = remainInvAmnt.toFixed(2);
	}else{
		document.getElementById("GlAmnt"+line).value = '';
	}

	SetPayAmnt();
       
     }
</script>



 <table width="80%" id="myTable" class="order-list-gl"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  class="heading">&nbsp;&nbsp;&nbsp;GL Account</td>
		<td width="25%" class="heading">Amount</td>
		<td width="25%" class="heading">Notes</td>
    </tr>
</thead>
<tbody>
	<? 

	

$subtotal=0;  $AmountSum=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$GlAmnt = (!empty($arryMultiAccount[$Count]['Amount']))?($arryMultiAccount[$Count]['Amount']):('0.00');
		$AmountSum += $GlAmnt;
	?>
     <tr class='itembg'>
		<td> 
<? if($Count>0){?><img src="../images/delete.png" id="ibtnDel"><?}?>&nbsp;
<select name="AccountID<?=$Line?>" class="inputbox" id="AccountID<?=$Line?>" onChange="Javascript: SetAccountName(this.value,<?=$Line?>);">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {

		if(empty($arryMultiAccount[$Count]['AccountID'])) $arryMultiAccount[$Count]['AccountID']='';
?>
		<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" 
<?=($arryBankAccountList[$i]['BankAccountID']==$arryMultiAccount[$Count]['AccountID'])?('selected'):('')?>>
		<?=stripslashes($arryBankAccountList[$i]['AccountName'])?>
		[<?=$arryBankAccountList[$i]['AccountNumber']?>]
     </option>
	<? } ?>
</select> 
			
<?  if(empty($arryMultiAccount[$Count]['AccountName'])) $arryMultiAccount[$Count]['AccountName']=''; 
	 if(empty($arryMultiAccount[$Count]['Notes'])) $arryMultiAccount[$Count]['Notes']=''; 

 ?>


<input type="hidden" name="AccountName<?=$Line?>" id="AccountName<?=$Line?>" value="<?=$arryMultiAccount[$Count]['AccountName']?>">
		</td>
         <td>
<?  (empty($amntChecked))?($amntChecked=""):(""); ?>
             <input type="text" name="GlAmnt<?=$Line?>" id="GlAmnt<?=$Line?>" class="textbox" style="width:100px;" onblur="SetPayAmnt()"  onkeypress="return isDecimalKeyNeg(event, this);"  maxlength="20" value="<?=$GlAmnt?>" autocomplete="off"/>
             &nbsp;&nbsp;<input type="checkbox" value="1" name="invoice_check_<?=$Line?>" id="invoice_check_<?=$Line?>" onClick="SetPayAmntByCheck(<?=$Line?>)" <?=$amntChecked?>>
         </td>
      
       <td>
             <input type="text" name="Notes<?=$Line?>" id="Notes<?=$Line?>" class="inputbox" maxlength="50" value="<?=stripslashes($arryMultiAccount[$Count]['Notes'])?>"/>
           
         </td>
       
    </tr>
	<?php } 


$TotalAmount = round($AmountSum,2);

?>

 
</tbody>
<tfoot>

	<tr class='itembg'>
	<td  align="right" height="30">
		
		<input type="hidden" name="NumLine1" id="NumLine1" value="<?=$NumLine?>" readonly maxlength="20"  />
		<input type="hidden" name="DelItemGL" id="DelItemGL" value="" class="inputbox" readonly />	
	<strong>Total : </strong>
       </td>
	<td>&nbsp;
            <span id="TotalGlAmountHtml"><?=$TotalAmount?></span>
            <input type="hidden" align="right" name="TotalGlAmount" id="TotalGlAmount" size="15" value="<?=$TotalAmount?>" style="width:90px;" /></td>
	<td>  
	<?
		if(!empty($arryPurchase[0]['AdjustmentAmount'])){
				echo 'Adjustments : '.$arryPurchase[0]['AdjustmentAmount'];
		}
	?>

	</td>
    </tr>
</tfoot>
</table>


 <table width="80%"  cellpadding="0" cellspacing="1">

    <tr align="left" >
		
		<td ><a href="Javascript:void(0);"  id="addrowGL" class="add_row" style="float:left">Add Account</a></td>
    </tr>
</table>


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
				//alert(httpObj3.responseText);
				document.getElementById("AccountName"+numRow).value  = httpObj3.responseText;
				ShowHideLoader('');

			}
		};
		httpObj3.send(null);
		 
	}
 
</script>

