
<br>
 
<table id="list_table" cellspacing="1" cellpadding="10" width="100%" align="center">
		<tr align="left"  >
		<td class="head1" width="15%">Sales Person</td>    
		<td class="head1" width="15%">Sales Person Type</td>    
		<td class="head1" width="7%">Commission %</td> 		
		</tr>
		<?php foreach ($arryCustomerSaleCommPer as $key => $values) {
			if(!empty($values['EmpSpId'])){
	            $empSalesPersonName = $objConfig->getSalesPersonName($values['EmpSpId'],0);
			    $values['SalesPerson'] = $empSalesPersonName;
			}
			if(!empty($values['VenSpId'])){
				$vendorSalesPersonName = $objConfig->getSalesPersonName($values['VenSpId'],1);
				$values['SalesPerson'] = $vendorSalesPersonName;
			}
		?>
		 <tr align="left" bgcolor="#FAFAFA">
		 <td><?=$values['SalesPerson'];?></td>
		 <td><?=$salesPersonType = (!empty($values['EmpSpId']) ? "Employee" : "Vendor" );?></td>
		 <td><input type="text" name="commission_per"  maxlength="50" onkeypress="return isDecimalKey(event);"  style="width:90px;text-align: right;" class="textbox " id="commission_per_<?php echo $values['ID']?>" value="<?=$values['CommPercentage'];?>"> <input name="search" type="button" class="search_button" value="Update" onclick="UpdateCommPer('<?php echo $values['ID']?>');"></td>
		 </tr>
		 <? } ?>
</table>
  

<script language="JavaScript1.2" type="text/javascript">
function UpdateCommPer(MainID)
{
   var spArray = <?php echo json_encode($arryCustomerSaleCommPer) ?>;
	var totalCommission =0;
$.each( spArray, function( key, value ) {
    var commission_percent = $("#commission_per_"+value['ID']+"").val();
    totalCommission = parseInt(totalCommission) + parseInt(commission_percent);
   // console.log(totalCommission);
});

var commission_per = $("#commission_per_"+MainID+"").val();
if(totalCommission<=100)
{
$.ajax({
		type: "POST",
		url: "../sales/ajax.php",
		dataType: 'json',
		data:{action:'updateCommisionPercentage',commission_per:commission_per,id:MainID}, 
	    success: function(data){
      $(".message").html(data['msg']);
		}
		});
}
else
{
	alert("Commission Percentage Should Be Less Or Equal To 100");
	return false;
}
}
</script>

