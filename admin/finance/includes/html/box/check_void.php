<div id="checkvoid_div" style="display:none;width:550px;border:none;background:none"  >
<table width="100%" border="0" cellpadding="5" cellspacing="0" >	 
	<tr>
		 <td colspan="2" align="left" class="head">Void Check ?</td>
	</tr>
	<tr>
		 <td colspan="2"  >&nbsp;</td>
	</tr>
	<tr>
		 <td colspan="2" align="center" >This check number already exists.</td>
	</tr>
	<tr>
		 <td colspan="2" align="center"><b>Do you want to void this check number ?</b></td>
	</tr>
	<tr>
		 <td colspan="2" align="center"><input type="button" name="Yes" id="yesVoid"  class="button" value="Yes">&nbsp;&nbsp;&nbsp;<input type="button" name="No" id="cancelVoid" class="button" value="No">



</td>
	</tr>
	<tr>
		 <td colspan="2" >&nbsp;</td>
	</tr>
</table>
</div>


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {

 	$('#yesVoid').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		//$(this).parent().hide();
		$.fancybox.close();
		SetVoidForm();
	});


	$('#cancelVoid').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		//$(this).parent().hide();
		$.fancybox.close();
	});


});


function SetVoidForm(){
	$("#CheckNumber").attr('class', 'disabled');
	$('#CheckNumber').attr('readonly', 'true');
	$("#Voided").val('1');
	$("#MsgSpan_CheckNumber").html('');
	var CheckNumber = $("#CheckNumber").val();	 

	var sendParam='&action=TransactionByCheckNumber&CheckNumber='+escape(CheckNumber)+'&r='+Math.random();  
	 
	$.ajax({
		type: "GET",
		async:false,
		url: 'ajax_pay.php',
		dataType : "JSON",
		data: sendParam,
		success: function (responseText) {				 
			$("#TransactionID").val(responseText["TransactionID"]);	
			ListTransaction();  
		}
	});


	  
 
}

</script>
