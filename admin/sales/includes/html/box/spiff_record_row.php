<?php 
if(!empty($OrderID)){
	$arrySpiffEntry = $objSale->GetSpiffEntry($OrderID,'');  
	$SpiffNumLine = sizeof($arrySpiffEntry);
}	

if(empty($SpiffNumLine)) $SpiffNumLine=0;

?> 

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () { 
	var counter = 1;
       
	$("#addrowspiff").on("click", function () {   

		counter = parseInt($("#SpiffNumLine").val()) + 1;
	
		var newRow = $("<tr class='itembg'>");
		var cols1 = "";

        cols1 += '<td align="left"> <input type="text" name="SpiffVendor' + counter + '" id="SpiffVendor' + counter + '" class="inputbox"  value=""  maxlength="60" autocomplete="off"  onclick="Javascript:AutoSpiffVendor(this);" onblur="SetSpiffInfo(this.value,' + counter + ');" /> <input type="hidden" name="SpiffSuppCode' + counter + '" id="SpiffSuppCode' + counter + '" class="inputbox"  value=""   maxlength="60" autocomplete="off"    /></td><td><input type="text" name="SpiffAmount' + counter + '" id="SpiffAmount' + counter + '"  onkeypress="return isDecimalKey(event);" class="textbox" value="0.00" style="width:90px;"  maxlength="50"/></td><td align="right"><img src="../images/delete.png" id="ButtonDelSpiff" style="cursor:pointer"></td>';
        
		newRow.append(cols1);
		$("table.order-list-spiff").append(newRow);
		$("#SpiffNumLine").val(counter);
		
		counter++;

	});
	
	
	
	$("table.order-list-spiff").on("click", "#ButtonDelSpiff", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="SpiffID"]').val();  
		if(id>0){
			var DelItemVal = $("#DelItemSpiff").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItemSpiff").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		
	});
	

	
	
});



function AutoSpiffVendor(elm){ 
	$(elm).autocomplete({
		source: "../jsonVendorSpiff.php",
		minLength: 3
	});

} 

function SetSpiffInfo(inf,Line){ 
	if(inf == ''){ 
		document.getElementById("SpiffSuppCode"+Line).value='';
		document.getElementById("SpiffVendor"+Line).value='';
		return false;
	} 

	var SuppCode = document.getElementById("SpiffSuppCode"+Line).value;

 	var SendUrl = "&action=SupplierInfo&SuppCode="+escape(SuppCode)+"&VendorNameCode="+escape(inf)+"&r="+Math.random(); 
 
	document.getElementById("SpiffSuppCode"+Line).value='';
	document.getElementById("SpiffVendor"+Line).value='';
	$("#SpiffVendor"+Line).addClass('loaderbox');
	
	$.ajax({
		type: "GET",
		url: "../purchasing/ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText){
			$("#SpiffVendor"+Line).removeClass('loaderbox');

			if(responseText["SuppID"]>0){
			
var SuppCodeExist=0;  
$("table.order-list-spiff").find('input[name^="SpiffSuppCode"]').each(function () {
	SuppCode = $(this).val(); 
	if(SuppCode!='' && responseText["SuppCode"]==SuppCode){
		SuppCodeExist=1;
	}
});

if(SuppCodeExist=="1"){
	alert("Spiff vendor already exist.");
}else{  
document.getElementById("SpiffSuppCode"+Line).value=responseText["SuppCode"];
document.getElementById("SpiffVendor"+Line).value=responseText["VendorName"];
}
				 
			  
			}   

		}
	});

}

	
	

	
</script>



 <table width="100%"   class="order-list-spiff"  cellpadding="0" cellspacing="1">
<thead>
    <tr   >
		
		<td align="left"  class="head1" width="45%">Vendor  </td>
		<td align="left" class="head1">Spiff Amount</td>
		<td align="right" class="head1"  > 
 <a href="Javascript:void(0);"  id="addrowspiff" >Add More</a>
 	</td>
    </tr>
</thead>
<tbody>

	<?  
	
	for($Line=1;$Line<=$SpiffNumLine;$Line++) { 
		$Count=$Line-1;		

	if($arrySpiffEntry[$Count]['Amount']>0) { 
		$Amount =  number_format($arrySpiffEntry[$Count]['Amount'],2); 
	}else{
		$Amount =  '0.00';
	}	
	?>
     <tr class='itembg' align="left">

	<input type="hidden" name="SpiffID<?=$Line?>" id="SpiffID<?=$Line?>" value="<?=stripslashes($arrySpiffEntry[$Count]['ID'])?>" readonly maxlength="20"  />
 
		

		<td align="left">
 
		<input name="SpiffVendor<?=$Line?>" type="text"  class="inputbox"  id="SpiffVendor<?=$Line?>" value="<?php echo stripslashes($arrySpiffEntry[$Count]['VendorName']); ?>"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoSpiffVendor(this);" onblur="SetSpiffInfo(this.value,'<?=$Line?>');" />

		<input name="SpiffSuppCode<?=$Line?>" type="hidden"  class="inputbox"  id="SpiffSuppCode<?=$Line?>" value="<?php echo stripslashes($arrySpiffEntry[$Count]['SuppCode']); ?>"  maxlength="60"  autocomplete="off"  />

		</td>
        	<td align="left">
        	<input type="text" name="SpiffAmount<?=$Line?>" id="SpiffAmount<?=$Line?>" class="textbox" style="width:90px;" onkeypress="return isDecimalKey(event);"  maxlength="50" value="<?=stripslashes($Amount)?>"/></td>

		<td align="right">
<img src="../images/delete.png" id="ButtonDelSpiff"  style="cursor:pointer">
		 

		</td>
  
    </tr>
	<?php } ?>
 
</tbody>
<tfoot>

	<tr class='itembg' align="center">
	
		
		<input type="hidden" name="SpiffNumLine" id="SpiffNumLine" value="<?=$SpiffNumLine?>" readonly maxlength="20"  />
		<input type="hidden" name="DelItemSpiff" id="DelItemSpiff" value="" class="inputbox" readonly />
       
       
    </tr>
</tfoot>
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



</script>


