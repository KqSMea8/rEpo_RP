<? 	if($NumLine<1){
	 	$NumLine=5;
	}
?>

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	
	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;
             
		var newRow = $("<tr class='itembg'>");
		var cols = "";
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="FromAmount' + counter + '" id="FromAmount' + counter + '" class="textbox"  size="10" maxlength="10"  onkeypress="return isNumberKey(event);"  />&nbsp;</td><td><input type="text" name="ToAmount' + counter + '" id="ToAmount' + counter + '" class="textbox"  size="10" maxlength="10" onkeypress="return isNumberKey(event);" /></td><td><input type="text" name="TaxAmount' + counter + '" id="TaxAmount' + counter + '" class="textbox" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" name="TaxPercentage' + counter + '" id="TaxPercentage' + counter + '" class="textbox"  size="10" maxlength="5" onkeypress="return isDecimalKey(event);"/></td>';

		newRow.append(cols);
		
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
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
		

	});
        
       
        

	});


</script>


<div id="msg_div" align="center" class="redmsg"></div>
 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td class="heading" width="15%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Over [<?=$Config['CurrencySymbol']?>]</td>
		<td  class="heading" >But not over [<?=$Config['CurrencySymbol']?>]</td>
     		<td width="15%" class="heading">Tax Amount [<?=$Config['CurrencySymbol']?>]</td>
		<td width="15%" class="heading" >Tax Percentage [%]</td>
		
    </tr>
</thead>
<tbody>

	<?

	$BoxClass = ($_GET['view']>0)?('class="normal" readonly'):('class="textbox"');

	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

		$FromAmount=$ToAmount=$TaxAmount=$TaxPercentage='';

		if($_GET['view']>0){		
			$FromAmount = number_format($arryBracketLine[$Count]['FromAmount']);
			$ToAmount = number_format($arryBracketLine[$Count]['ToAmount']);
			$TaxAmount = stripslashes($arryBracketLine[$Count]['TaxAmount']);
			$TaxPercentage = stripslashes($arryBracketLine[$Count]['TaxPercentage']);
		}else if($_GET['edit']>0){
			
			$FromAmount = stripslashes($arryBracketLine[$Count]['FromAmount']);
			$ToAmount = stripslashes($arryBracketLine[$Count]['ToAmount']);
			$TaxAmount = stripslashes($arryBracketLine[$Count]['TaxAmount']);
			$TaxPercentage = stripslashes($arryBracketLine[$Count]['TaxPercentage']);
		}



		$taxBracketID = (!empty($arryBracketLine[$Count]['id']))?($arryBracketLine[$Count]['id']):('');
	?>
     <tr class="itembg">
		<td><?=($Line>1 && empty($_GET['view']))?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="FromAmount<?=$Line?>" id="FromAmount<?=$Line?>" onkeypress="return isNumberKey(event);" <?=$BoxClass?>  size="10" maxlength="10"  value="<?=$FromAmount?>"/>&nbsp;	

<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$taxBracketID?>" readonly maxlength="20"  />

		</td>

        <td><input type="text" name="ToAmount<?=$Line?>" id="ToAmount<?=$Line?>" <?=$BoxClass?> size="10" maxlength="10" onkeypress="return isNumberKey(event);"  value="<?=$ToAmount?>" /></td>

	<td><input type="text" name="TaxAmount<?=$Line?>" id="TaxAmount<?=$Line?>" <?=$BoxClass?> size="10" maxlength="10" value="<?=$TaxAmount?>" onkeypress="return isDecimalKey(event);"  /></td>

        <td><input type="text" name="TaxPercentage<?=$Line?>" id="TaxPercentage<?=$Line?>" <?=$BoxClass?>  size="10" maxlength="5" value="<?=$TaxPercentage?>" onkeypress="return isDecimalKey(event);"/>

</td>
       
       
       
    </tr>
	<? 
	} ?>
</tbody>
<tfoot>

<? if(empty($_GET['view'])){?>
    <tr class="itembg">
        <td colspan="8" align="right">

<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>

<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
<input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

		
        </td>
    </tr>
<? } ?>
</tfoot>
</table>

