<?php 
$TotalAmount=0;
$arryReimSetting=$objConfigure->GetLocation($_SESSION['locationID'],''); 
if($HideAdminPart==1){
	$DisabledRate = 'class="disabled" readonly';
}else{
	$DisabledRate = 'class="textbox" ';
}


?>
<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	$("#addrow").on("click", function () { 
		counter = parseInt($("#NumLine").val()) + 1;
		
		var newRow = $("<tr class='itembg'>");
		var cols = "";
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<select name="Type'+counter+'" data-row="'+counter+'" id="Type'+counter+'" class="textbox MType" style="width:105px;"><option value="Mile">Mileage</option><option value="Miss">Miscellaneous</option></select><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><td><input type="text" name="FromZip' + counter + '"   id="FromZip' + counter + '" data-row=' + counter + ' class="textbox" style="width:110px;" onkeypress="return isNumberKey(event);" size="10" maxlength="8"  /></td><td><input type="text" name="ToZip' + counter + '"  id="ToZip' + counter + '" data-row=' + counter + ' class="textbox" style="width:110px;" onkeypress="return isNumberKey(event);" size="10" maxlength="8"  /></td><td><input type="text" name="MileageRate' + counter + '" id="MileageRate' + counter + '" <?php echo $DisabledRate; ?> style="width:110px;" data-row=' + counter + '  onkeypress="return isDecimalKey(event);" value="<?php echo $arryReimSetting[0]["ReimRate"];?>"  size="10" maxlength="20"  /></td><td><input type="text" name="TotalMiles' + counter + '"  id="TotalMiles' + counter + '" style="width:110px;" data-row=' + counter + ' class="disabled" readonly onkeypress="return isNumberKey(event);" size="10" maxlength="20"  /></td><td><input type="text" name="Reference' + counter + '" id="Reference' + counter + '" class="textbox" style="width:110px;" onkeypress="return isAlphaKey(event);"  size="10" maxlength="50"  /></td><td><input type="text" name="ReimComment' + counter + '" id="ReimComment' + counter + '" class="textbox" style="width:110px;" onkeypress="return isAlphaKey(event);"  size="10" maxlength="50"  /></td><td align="right"><input type="text" name="TotalRate' + counter + '" id="TotalRate' + counter + '" data-row=' + counter + ' class="disabled" readonly size="13" maxlength="20" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';

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

		var item_id = row.find('input[name^="item_id"]').val(); 
		if(item_id>0){
			var DelItemIDVal = $("#DelItemID").val();
			if(DelItemIDVal!='') DelItemIDVal = DelItemIDVal+',';
			$("#DelItemID").val(DelItemIDVal+item_id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		totalprice()

	  });

	});

      
</script>

<script>
function totalprice(){

	 var grandTotal=0;  
	 var inputTotal=0;  
	 $('.redmsg').html("");
     $("[id^='TotalRate']").each(function(){
         if($(this).val() == ''){
        	 inputTotal = 0;
         }else{
        	 inputTotal=$(this).val();
         }
		if(inputTotal>0){
  	     		grandTotal= parseFloat(grandTotal)+parseFloat(inputTotal);
		}
     });
 
     $("#TotalAmount").val(grandTotal.toFixed(2));
}


$(function(){


$("body").on('change',"[id^='Type']",function(){
	
	var counter  =  $(this).attr('data-row');	 
	var TypeReim = $("#Type"+counter).val();
	 $('.redmsg').html("");
	if(TypeReim == 'Miss'){
		$("#FromZip"+counter).hide(500);
		$("#ToZip"+counter).hide(500);
		$("#MileageRate"+counter).hide(500);
		$("#TotalMiles"+counter).hide(500);
		$("#TotalMiles"+counter).val("");                 
		$("#TotalRate"+counter).val("");
		$("#FromZip"+counter).val("");
		$("#ToZip"+counter).val("");
		$("#TotalMiles"+counter).val("");
		$("#TotalRate"+counter).attr("class","textbox");
		$("#TotalRate"+counter).removeAttr("readonly");			
	}else{
		$("#FromZip"+counter).show(500);
		$("#ToZip"+counter).show(500);
		$("#MileageRate"+counter).show(500);
		$("#TotalMiles"+counter).show(500);
		$("#TotalRate"+counter).val("");
		$("#TotalRate"+counter).attr("class","disabled");
		$("#TotalRate"+counter).attr("readonly","true");		
	}
	totalprice();
});

/******************************************/

$("body").on('blur',"[id^='MileageRate']",function(){
	var counter  =  $(this).attr('data-row');
	 
	var FormZip =  $('#FromZip'+counter).val(); 
	var ToZip =  $('#ToZip'+counter).val();  
	var MilaegeRate =  $('#MileageRate'+counter).val(); 
	var TotalMiles =  $('#TotalMiles'+counter).val(); 

	var TotalRate=''; 
	 
 	if(FormZip!="" && ToZip!="" && MilaegeRate>0 && TotalMiles>0){	
		 TotalRate = MilaegeRate*TotalMiles;
		
		 $('#TotalRate'+counter).val(TotalRate);
	}

       totalprice();
});

/******************************************/

$("body").on('blur',"[id^='TotalRate']",function(){

       totalprice();
});

/************* From And To Zip ************/

   $("body").on('blur',"[id^='FromZip'],[id^='ToZip']",function(){
	      
          var counterZip  =  $(this).attr('data-row');
          var FormZip =  $('#FromZip'+counterZip).val(); 
          var ToZip =  $('#ToZip'+counterZip).val();  	
          var MilaegeRate =  $('#MileageRate'+counterZip).val(); 
          var TotalRate='';


          $('#TotalMiles'+counterZip).val('');
	 $('.redmsg').html("");





            if(FormZip.length>4 && ToZip.length>4){
				$("#TotalMiles"+counterZip).addClass('loaderbox');
			
				$.ajax({
					type: "GET",
					url: "ajax.php",
					data: {FormZip:FormZip,ToZip:ToZip,action:'getdistancebyzip'},
					success: function (responseText) {
					   $("#TotalMiles"+counterZip).removeClass('loaderbox');
					   TotalRate = MilaegeRate*responseText;
					   $('#TotalRate'+counterZip).val(TotalRate);
					   $('#TotalMiles'+counterZip).val(responseText);

					   totalprice();
                  
					    				   
					}
				});
            }else{
		 $('.redmsg').html("Please enter valid zip codes.");	
	    } 
          
   });
	  
});
</script>
<? echo "<div style='float:right;padding:4px;'><b>All amounts stated in ".$Config['Currency']."</div>"; ?>
<div class="redmsg" align="center">&nbsp;</div>
 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading">&nbsp;&nbsp;&nbsp;Type</td>
<td width="12%" class="heading">From Zip</td>
		<td width="12%" class="heading">To Zip</td>
		<td width="10%" class="heading">Mileage Rate</td>
		<td width="12%" class="heading">Total Miles</td>
	    <td width="8%" class="heading">Reference</td>
		<td width="8%" class="heading">Comment</td>
		<td width="13%" class="heading" align="right">Total Rate</td>
    </tr>
</thead>
<tbody>
	<?php 
	$NumLine=1;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
	?>
     <tr class='itembg'>
	     <td>
		&nbsp;&nbsp;&nbsp;	
			<select name="Type<?=$Line?>" id="Type<?=$Line?>" class="textbox MType" style="width:105px;" data-row="<?=$Line?>">
				<option value="Mile">Mileage</option>
				<option value="Miss"> Miscellaneous</option>
			</select>
	
		</td>
		
		<td>
	    <input type="text" name="FromZip<?=$Line?>" id="FromZip<?=$Line?>" data-row="<?=$Line?>" class="textbox" style="width:110px;"  maxlength="8" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryReimbursementItem[$Count]["FromZip"])?>"/>
	   </td>
	   
	   <td>
		<input type="text" name="ToZip<?=$Line?>" id="ToZip<?=$Line?>" data-row="<?=$Line?>" class="textbox" style="width:110px;"  maxlength="8" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryReimbursementItem[$Count]["ToZip"])?>"/>
	   </td>
		<td><input type="text" name="MileageRate<?=$Line?>"  id="MileageRate<?=$Line?>" <?=$DisabledRate?> style="width:110px;"  data-row="<?=$Line?>"   maxlength="20" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryReimSetting[$Count]["ReimRate"])?>"/>
		<td><input type="text" name="TotalMiles<?=$Line?>" data-row="<?=$Line?>" id="TotalMiles<?=$Line?>" class="disabled" readonly style="width:110px;"  maxlength="20" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryReimbursementItem[$Count]["TotalMiles"])?>"/>
        <td><input type="text" name="Reference<?=$Line?>" id="Reference<?=$Line?>" class="textbox" style="width:110px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryReimbursementItem[$Count]["Reference"])?>"/>
		<td><input type="text" name="ReimComment<?=$Line?>" id="ReimComment<?=$Line?>" class="textbox" style="width:110px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryReimbursementItem[$Count]["ReimComment"])?>"/>
      <td align="right"><input type="text" align="right" name="TotalRate<?=$Line?>" id="TotalRate<?=$Line?>" data-row="<?=$Line?>" class="disabled" readonly size="13" maxlength="20" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryReimbursementItem[$Count]["TotalRate"])#=number_format('0',2)?>"/></td>
   
    </tr>
	<? 
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="9" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
	     <input type="hidden" name="DelItemID" id="DelItemID" value="" class="inputbox" readonly />
		<br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>



