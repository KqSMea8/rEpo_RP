<table width="100%" id="myTable"  cellpadding="0" cellspacing="1">
	<tr align="left" >
		<td align="left" class="heading" colspan="2">Charge Card Credit </td>
		 
	</tr>
	<tr class='itembg'>
		<td align="right" width="20%"> Select Credit Card : </td>
		<td align="left">  

<input type="hidden" name="PaymentTermGL" id="PaymentTermGL" value="<?=$arrySale[0]['PaymentTerm']?>" class="textbox">
		<select name="SelectCardGl" class="textbox" id="SelectCardGl" >
			<option value="">--- Select ---</option>
			<option value="New">New Card</option>
			<option value="Existing">Existing</option>	 	 
		</select> 

	 </td>
	</tr>

	<tr class='itembg'>
		<td    colspan="2"> 
<? 
$Action='VCard';    
$BoxPrefix = '../sales/'; 
include("../includes/html/box/invoice_card.php");
?> </td>
		 
	</tr>

</table>





<script language="JavaScript1.2" type="text/javascript">
 
	jQuery('document').ready(function(){

		$('#SelectCardGl').change(function(){ 
			var CustID = $("#CustCodeGL :selected").attr("CustIDGl");
 
			if(CustID>0){
				var url = '';
				if($(this).val()=='New'){
					url = '../editCustCard.php?CustID='+CustID+'&SaveSelect=1&type=2';
				}else{
					url = '../selectCustCard.php?CustID='+CustID+'&type=2';
				}
				 
				$.fancybox({
					 'href' : url,
					 'type' : 'iframe',
					 'width': '800',
					 'height': '800'
				});
			}else{
				alert("Please select customer first.");
			}
		});







	});

	 

</script>
