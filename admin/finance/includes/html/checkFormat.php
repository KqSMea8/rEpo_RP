<div class="had">&nbsp;</div>
<div class="message" align="center"></div>

<style>

#toolbar img{cursor:pointer;margin:5px;}

.draggable{border:0px solid #aaa;color:#333;cursor:move;font-size:12px;}
/*.draggable:hover{border:1px dashed #aaa;}*/

.draggablestub{border:0px solid #aaa;color:#333;cursor:move;font-size:12px;}
/*.draggablestub:hover{border:1px dashed #aaa;}*/
.draggable2stub{border:0px solid #aaa;color:#333; font-size:12px;}
.inputtext{background: none;border-bottom:1px solid #888;font-size:12px;color:#232323; padding: 1px; font-weight:500}
.inputamnt{background: #e7f0f5; border:1px solid #e7f0f5;font-size:12px;color:#232323; padding: 1px; font-weight:500}
</style>
<script>
  $(function() {
	$( ".draggable" ).draggable({ containment: "#check-wrapper", scroll: false });
	$( ".draggablestub" ).draggable({ containment: "#stub-wrapper", scroll: false });

	$("#FontPlus").click(function() {		
	    var fontSize = parseInt($('#cmp').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#cmp').css({'font-size':fontSize});

	 
	    var fontSize = parseInt($('#date').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#date').css({'font-size':fontSize});

	    var fontSize = parseInt($('#dt').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#dt').css({'font-size':fontSize});


	    var fontSize = parseInt($('#pay').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#pay').css({'font-size':fontSize});

  	    var fontSize = parseInt($('#word1').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#word1').css({'font-size':fontSize});

	    var fontSize = parseInt($('#currency').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#currency').css({'font-size':fontSize});

	    var fontSize = parseInt($('#curr').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#curr').css({'font-size':fontSize});


	    var fontSize = parseInt($('#memo').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#memo').css({'font-size':fontSize});

	    var fontSize = parseInt($('#VendorAddress').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#VendorAddress').css({'font-size':fontSize});

	     var fontSize = parseInt($('#checknumber').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#checknumber').css({'font-size':fontSize});

	    /*******Stub**********/
	    var fontSize = parseInt($('#cmpStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#cmpStub').css({'font-size':fontSize});

	 
	    var fontSize = parseInt($('#dateStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#dateStub').css({'font-size':fontSize});

	    var fontSize = parseInt($('#dtStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#dtStub').css({'font-size':fontSize});

  	   var fontSize = parseInt($('#payStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#payStub').css({'font-size':fontSize});


	    var fontSize = parseInt($('#currencyStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#currencyStub').css({'font-size':fontSize});

	     var fontSize = parseInt($('#invoiceStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#invoiceStub').css({'font-size':fontSize});

	    var fontSize = parseInt($('#currStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#currStub').css({'font-size':fontSize});


	    var fontSize = parseInt($('#checknumberStub').css("font-size"));
	    fontSize = fontSize + 1 + "px";
	    $('#checknumberStub').css({'font-size':fontSize});

		SetStub2();
	});





	$("#FontMinus").click(function() {		
	    var fontSize = parseInt($('#cmp').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#cmp').css({'font-size':fontSize});

	    var fontSize = parseInt($('#date').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#date').css({'font-size':fontSize});

	    var fontSize = parseInt($('#dt').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#dt').css({'font-size':fontSize});

	
	    var fontSize = parseInt($('#pay').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#pay').css({'font-size':fontSize});

	    var fontSize = parseInt($('#word1').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#word1').css({'font-size':fontSize});
	
	    var fontSize = parseInt($('#currency').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#currency').css({'font-size':fontSize});

	     var fontSize = parseInt($('#curr').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#curr').css({'font-size':fontSize});


	    var fontSize = parseInt($('#memo').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#memo').css({'font-size':fontSize});  

	    var fontSize = parseInt($('#VendorAddress').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#VendorAddress').css({'font-size':fontSize});  


	     var fontSize = parseInt($('#checknumber').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#checknumber').css({'font-size':fontSize});


	   /*******Stub**********/
	    var fontSize = parseInt($('#cmpStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#cmpStub').css({'font-size':fontSize});

	 
	    var fontSize = parseInt($('#dateStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#dateStub').css({'font-size':fontSize});

	    var fontSize = parseInt($('#dtStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#dtStub').css({'font-size':fontSize});

	    var fontSize = parseInt($('#payStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#payStub').css({'font-size':fontSize});


	    var fontSize = parseInt($('#currencyStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#currencyStub').css({'font-size':fontSize});

	    var fontSize = parseInt($('#invoiceStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#invoiceStub').css({'font-size':fontSize});


	    var fontSize = parseInt($('#currStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#currStub').css({'font-size':fontSize});


	    var fontSize = parseInt($('#checknumberStub').css("font-size"));
	    fontSize = fontSize - 1 + "px";
	    $('#checknumberStub').css({'font-size':fontSize});

		SetStub2();

	});


	$("#SpacePlus").click(function() {		
	   	var padd = parseInt($("#checktd").css('padding-bottom')); 
		padd = padd + 1 + "px";	    	
		$('#checktd').css({'padding-bottom':padd});		
		$('#stub-td').css({'padding-bottom':padd});	
		$('#stub-td2').css({'padding-bottom':padd});
	});

	$("#SpaceMinus").click(function() {		
		var padd = parseInt($("#checktd").css('padding-bottom')); 
		padd = padd - 1 + "px";		
		$('#checktd').css({'padding-bottom':padd});		
		$('#stub-td').css({'padding-bottom':padd});
		$('#stub-td2').css({'padding-bottom':padd});
	});

  });


function ToggleTool(elm){
	var obj = "#"+elm;
	var vsb = $(obj).css('visibility');

	if(vsb=='visible'){
		$(obj).css('visibility', 'hidden');
	}else{
		$(obj).css('visibility', 'visible');
	}
}

function ToggleToolDisplay(elm){
	var obj = "#"+elm;
	var vsb = $(obj).css('display');

	if(vsb=='none'){
		$(obj).show();
	}else{
		$(obj).hide();
	}
}

function SaveCheck(){
	var sendParam='&action=SaveCheckTemplate&r='+Math.random();

	if($("#cmp").length)sendParam += '&cmpStyle='+$("#cmp").attr("style");
	if($("#checknumber").length)sendParam += '&checknumberStyle='+$("#checknumber").attr("style");
	if($("#date").length)sendParam += '&dateStyle='+$("#date").attr("style");
	if($("#pay").length)sendParam += '&payStyle='+$("#pay").attr("style");
	if($("#word").length)sendParam += '&wordStyle='+$("#word").attr("style");
	if($("#currency").length)sendParam += '&currencyStyle='+$("#currency").attr("style");
	if($("#memo").length)sendParam += '&memoStyle='+$("#memo").attr("style");
	if($("#VendorAddress").length)sendParam += '&VendorAddressStyle='+$("#VendorAddress").attr("style");

	if($("#cmpStub").length)sendParam += '&cmpStubStyle='+$("#cmpStub").attr("style");
	if($("#checknumberStub").length)sendParam += '&checknumberStubStyle='+$("#checknumberStub").attr("style");
	if($("#dateStub").length)sendParam += '&dateStubStyle='+$("#dateStub").attr("style");
	if($("#payStub").length)sendParam += '&payStubStyle='+$("#payStub").attr("style");
	if($("#currencyStub").length)sendParam += '&currencyStubStyle='+$("#currencyStub").attr("style");
	if($("#invoiceStub").length)sendParam += '&invoiceStubStyle='+$("#invoiceStub").attr("style");

	if($("#LabelDate").length)sendParam += '&LabelDateStyle='+$("#LabelDate").attr("style");
	if($("#LabelPay").length)sendParam += '&LabelPayStyle='+$("#LabelPay").attr("style");
	if($("#LabelMemo").length)sendParam += '&LabelMemoStyle='+$("#LabelMemo").attr("style");
	if($("#LabelDateStub").length)sendParam += '&LabelDateStubStyle='+$("#LabelDateStub").attr("style");
	if($("#LabelPayStub").length)sendParam += '&LabelPayStubStyle='+$("#LabelPayStub").attr("style");

	if($("#checktd").length)sendParam += '&BoxStyle='+$("#checktd").attr("style");


	$(".message").html('Processing.....');
	$.ajax({
		type: "GET",
		async:false,
		url: 'ajax.php',
		data: sendParam,
		success: function (responseText) {  
			$(".message").html('Template has been saved successfully.');
			SetStub2();
			
		}
	});
	
}


function SetStub2(){
	var stubtdhtml = $("#stub-td").html();
	$("#stub-td2").html(stubtdhtml);
}


</script>

<?  if (!empty($ErrorMsg)) {   ?>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<?php } else {


?>






<table width="700" border="0" cellpadding="0" cellspacing="0">
<tr>
	
	 <td align="left" valign="top" width="50">
		&nbsp;	
	 </td>
	 <td align="left" valign="top" >
<input type="button" class="button" name="Save" id="Save"   value="Save" onclick="Javascript:SaveCheck();">

<input type="button" class="print_button"  name="Print" id="Print"   value="Print" onclick="Javascript:window.print();">

<a href="Javascript:void(0);" class="white_bt hideprint" id="SpacePlus" ><img src="../icons/space_p.png"  border="0"  onMouseover="ddrivetip('<center>Spacing ++</center>', 90,'')"; onMouseout="hideddrivetip()" ></a>

<a href="Javascript:void(0);" class="white_bt hideprint" id="SpaceMinus" ><img src="../icons/space_m.png"  border="0"  onMouseover="ddrivetip('<center>Spacing --</center>', 90,'')"; onMouseout="hideddrivetip()" ></a>

<a href="Javascript:void(0);" class="grey_bt" id="FontPlus" >A+</a>
<a href="Javascript:void(0);" class="grey_bt" id="FontMinus" >A-</a> 
 
	 </td>
	
	</tr>	

<?

$BoxStyle = !empty($arryTemplate[0]['BoxStyle'])?($arryTemplate[0]['BoxStyle']):('padding-top:1px;padding-bottom:1px;');

 if($CheckFormat=='Check, Stub, Stub'){ 
	include("includes/html/box/check_format.php");	
	include("includes/html/box/stub_format.php");	
	include("includes/html/box/stub_format.php");
 }else if($CheckFormat=='Stub, Check, Stub'){
	include("includes/html/box/stub_format.php");	
	include("includes/html/box/check_format.php");	
	include("includes/html/box/stub_format.php");	
 }else if($CheckFormat=='Stub, Stub, Check'){
	include("includes/html/box/stub_format.php");	
	include("includes/html/box/stub_format.php");
	include("includes/html/box/check_format.php");	
 }
?>



	</table>


<? } ?>





