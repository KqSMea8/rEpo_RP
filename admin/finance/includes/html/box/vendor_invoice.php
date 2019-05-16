<? if(!empty($SuppCode)){?>
<script language="JavaScript1.2" type="text/javascript">


function GetPagingData(curPage,module){
	if(curPage<1){
		curPage=1;
	}
	if(module=='Invoice'){
		GetVendorInvoice(curPage);
	}else{
		GetVendorCredit(curPage);
	}
}

 function GetVendorInvoice(curPage){
	var SuppCode = $("#VendorCode").val();
	
	var curP = 1;
	if(curPage>0){
		curP = curPage;
	}
	 
	if(SuppCode!=''){	
		var sendParam='&SuppCode='+escape(SuppCode)+'&module=Invoice&action=VendorInvoice&curP='+curP+' &r='+Math.random();
		 
		//ShowHideLoader(1,'L');
		$.ajax({
			type: "GET",
			async:false,
			url: '../ajax_order.php',
			data: sendParam,
			success: function (responseText) { 				 	
				$("#invoiceList").html(responseText);			
				//ShowHideLoader(0,'');
			}
		});
	}
}





 function GetVendorCredit(curPage){
	var SuppCode = $("#VendorCode").val();
	
	var curP = 1;
	if(curPage>0){
		curP = curPage;
	}
	 
	if(SuppCode!=''){	
		var sendParam='&SuppCode='+escape(SuppCode)+'&module=Credit&action=VendorCredit&curP='+curP+' &r='+Math.random();
		 
		//ShowHideLoader(1,'L');
		$.ajax({
			type: "GET",
			async:false,
			url: '../ajax_order.php',
			data: sendParam,
			success: function (responseText) { 				 	
				$("#creditList").html(responseText);			
				//ShowHideLoader(0,'');
			}
		});
	}
}


$(document).ready(function () {	 
	GetVendorInvoice();
	GetVendorCredit();
});
</script>
<input type="hidden" name="VendorCode" id="VendorCode" value="<?=$SuppCode?>" readonly>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="2" align="left" >
		<div id="invoiceList" ></div>
	</td>
</tr>	
	
	<tr>
	<td colspan="2" align="left" >
		<div id="creditList" ></div>
	</td>
</tr>
  </table>
<? } ?>


