<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	

	$("#addrow").on("click", function () { 
		counter = parseInt($("#NumLine").val()) + 1;
		var newRow = $("<tr class='itembg'>");
		var cols = "";

		
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input size="5" onkeypress="return isAlphaKey(event);"   type="text" name="title' + counter + '" id="title' + counter + '" class="inputbox"  /></td><td><input size="10" type="text" name="Price' + counter + '" id="Price' + counter + '" class="textbox"     /> </td><td><select name="PriceType' + counter + '"  class="inputbox" id="PriceType' + counter + '"><option value="Fixed">Fixed</option><option value="Percentage">Percentage</option></select></td><td><input type="text"  name="Weight' + counter + '" id="Weight' + counter + '"  class="textbox" size="10"  value="" /></td><td><input type="text" name="SortOrder' +counter+ '" id="SortOrder' +counter+ '" class="textbox" size="5" maxlength="10"  /></td>';



		newRow.append(cols);
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	

	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by Bhoodev **********/
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


 
 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  class="heading">Title</td>
		
		<td width="15%" class="heading"> Price</td>
		<td  class="heading">Price Type</td>
		<td width="15%" class="heading">Weight</td>
		<td  class="heading" >Sort Order</td>
    </tr>
</thead>
<tbody>
	<?php 


	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		
	#if($arryQuote[0]['Taxable']=='Yes' && $arryQuote[0]['Reseller']!='Yes' && $arrayOptionList[$Count]['Taxable']=='Yes'){
	//if($arryQuote[0]['tax_auths']=='Yes' && $arrayOptionList[$Count]['Taxable']=='Yes'){
		//$TaxShowHide = 'inline';
	//}else{
		//$TaxShowHide = 'none';
	//}

	//$ReqDisplay = !empty($arrayOptionList[$Count]['req_item'])?(''):('style="display:none"');
	//if(empty($arrayOptionList[$Count]['Taxable'])) $arrayOptionList[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
		<td><?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")?>
                <input type="text" name="title<?=$Line?>" id="title<?=$Line?>"  class="inputbox" onkeypress="return isAlphaKey(event);"     value="<?=stripslashes($arrayOptionList[$Count]["title"])?>"/>

		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arrayOptionList[$Count]["Id"])?>" readonly maxlength="20"  />


                
		</td>
        <td><input type="text" name="Price<?=$Line?>" id="Price<?=$Line?>" class="textbox" size="10"    value="<?=stripslashes($arrayOptionList[$Count]["Price"])?>"/></td>

        <td>


<select name="PriceType<?=$Line?>" class="inputbox" id="PriceType<?=$Line?>"><option value="Fixed" <?php if($arrayOptionList[$Count]["PriceType"]=="Fixed"){ echo "selected";}?>>Fixed</option><option value="Percentage" <?php if($arrayOptionList[$Count]["PriceType"]=="Percentage"){ echo "selected";}?>>Percentage</option></select><!--input type="text" name="PriceType<?=$Line?>" id="PriceType<?=$Line?>" class="inputbox"   value="<?=stripslashes($arrayOptionList[$Count]["on_hand_qty"])?>"/></td-->


        <td><input type="text" name="Weight<?=$Line?>" id="Weight<?=$Line?>" class="textbox" size="10"   value="<?=stripslashes($arrayOptionList[$Count]["Weight"])?>"/></td>


       <td><input type="text" name="SortOrder<?=$Line?>" id="SortOrder<?=$Line?>" class="textbox" size="5"  onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrayOptionList[$Count]["SortOrder"])?>"/></td>
      
       
    </tr>
<? }?>
	
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="5" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add New Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
</td>
</tr>
</tfoot>
</table>



<?php //echo '<script>SetInnerWidth();</script>'; ?>
