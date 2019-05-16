<? 
if($arryCustomer[0]['CustCode']!=''){
?>

<script language="JavaScript1.2" type="text/javascript">
function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}


function ValidateSearch(frm){	
	
	if(document.getElementById("fby").value=='Year'){
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else if(document.getElementById("fby").value=='Month'){
		if(!ValidateForSelect(frm.m, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else{
		if(!ValidateForSelect(frm.f, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.t, "To Date")){
			return false;	
		}

		if(frm.f.value>frm.t.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

	}

	ShowHideLoader(1,'F');
	return true;	



	
}



function GetPagingData(curPage,module){
	if(curPage<1){
		curPage=1;
	}
	if(module=='Invoice'){
		GetCustomerInvoice(curPage);
	}else{
		GetCustomerCredit(curPage);
	}
}

 function GetCustomerInvoice(curPage){
	var CustCode = $("#CustomerCode").val();
	
	var curP = 1;
	if(curPage>0){
		curP = curPage;
	}
	 
	if(CustCode!=''){	
		var sendParam='&CustCode='+escape(CustCode)+'&module=Invoice&action=CustomerInvoice&curP='+curP+' &r='+Math.random();
		 
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





 function GetCustomerCredit(curPage){
	var CustCode = $("#CustomerCode").val();
	
	var curP = 1;
	if(curPage>0){
		curP = curPage;
	}
	 
	if(CustCode!=''){	
		var sendParam='&CustCode='+escape(CustCode)+'&module=Credit&action=CustomerCredit&curP='+curP+' &r='+Math.random();
		 
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
	GetCustomerInvoice();
	GetCustomerCredit();
});
</script>
<input type="hidden" name="CustomerCode" id="CustomerCode" value="<?=$arryCustomer[0]['CustCode']?>" readonly>
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
