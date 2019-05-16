<div class="had">Shopping Cart</div>
<a class="back" href="#" onclick="Javascript:window.history.go(-1)" style="margin-top:0">Back</a> 
 <table width="100%" border="0" cellspacing="0" cellpadding="0"
	align="center">

<tr>
	<td>&nbsp;
	 
	</td>
</tr>
	<tr>
		<td>

		<table <?= $table_bg ?>>
			<tr align="left">
				<td  class="head1" width="10%">Order #</td>
				<td class="head1">Date</td>
				<td class="head1" width="15%">Qty</td>
				<td width="30%" class="head1">Product</td>
				<td width="10%" align="center" class="head1">Action</td>
			</tr>
			<?php if(count($CartItem)>0){
				foreach($CartItem as $list){
			
			echo '<tr bgcolor="#ffffff" valign="middle" align="left">
				<td>'.$list['CartID'].'</td>
				<td>'.date('l, F d Y',strtotime($list['AddedDate'])).'</td>
				<td>'.$list['Quantity'].'</td>
				<td>'.$list['Sku'].'</td>

				<td align="center">';
				
			
			?>
		
			<a href="cart.php?DelID=<?=$list['CartID']?>" onclick="return confDel('Cart Item')"><?=$delete?></a>		
				
				<?php echo '</td>
			</tr>';
			}}else{
			echo '<tr bgcolor="#ffffff" valign="middle" align="center">
				<td colspan="5" height="40">Your cart is empty.</td>				
			</tr>';
			}
			?>
			

		</table>

		</td>
	</tr>
</table>
<?php if(count($CartItem)>0){ ?>
<form method="post" action="checkout.php" onsubmit="return validate();" >
 <table width="100%" border="0" cellspacing="0" cellpadding="0"
	align="center">
	<tr>
		<td>

		<table <?= $table_bg ?>>
			<tr align="left">
				<td  class="head1" colspan="2">DELIVERY DETAILS / BILLING DETAILS </td>
				
			</tr>
		
			<tr bgcolor="#ffffff" valign="middle" align="left">
				<td>Select a Delivery Address </td>
				<td><select name="shipto" id="shipto" >
		<?php 
	
		for($count=0;$count<count($arryContact);$count++){
			$address ='';
			if($arryContact[$count]['FirstName']!='') $address .=$arryContact[$count]['FirstName'].',';
			if($arryContact[$count]['LastName']!='') $address .=$arryContact[$count]['LastName'].',';
			if($arryContact[$count]['Address']!='') $address .=$arryContact[$count]['Address'].',';
			if($arryContact[$count]['CityName']!='') $address .=$arryContact[$count]['CityName'].',';
			if($arryContact[$count]['StateName']!='') $address .=$arryContact[$count]['StateName'].',';
			if($arryContact[$count]['CountryName']!='') $address .=$arryContact[$count]['CountryName'].',';
			
			echo '<option value="'.$arryContact[$count]['AddID'].'">'.substr($address,0,-1).'</option>';
		}
		?>
			</select></td>			
				
			</tr>

		</table>

		</td>
	</tr>
	<tr>
		<td>

		<table <?= $table_bg ?>>
			<tr align="left">
				<td  class="head1" colspan="2">SPECIAL INSTRUCTION</td>
				
			</tr>
		
			<tr bgcolor="#ffffff" valign="middle" align="left">
				<td>Comment </td>
				<td><textarea class="inputbox" style="width:300px;height:100px" name="Comment"></textarea></td>			
				
			</tr>

		</table>

		</td>
	</tr>
</table> 

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	align="center">
	<tr>
		<td>

		<table width="100%" border="0" cellspacing="0" cellpadding="0"
	align="center">
			
			<tr valign="middle" align="left">
				<td><a href="editSalesQuoteOrder.php?module=Order"  style="color:#fff; font-weight: bold; font-size: 12px;" class="search_button" >Continue Shopping</a></td>
				<td align="right"><input type="submit"  class="button" name="checkout" value="Checkout &raquo;"></td>			
				
			</tr>
			

		</table>

		</td>
	</tr>
</table>
</form>
<?php }?>

<script type="text/javascript">
function validate(){
	var shipto=$('#shipto').val();
	
	var action = 'validateaddress';
	var res=0;
	$.ajax({
		url: 'ajaxOrder.php',
		async:false,
		type: 'POST',
		data: {action:action,shipto:shipto},			
		success:function(data){	
			var obj = jQuery.parseJSON(data);
			
			if(confirm("Your order ship to :" +obj.message)){
				res=1;
				
			}
			
		}
	});
	if(res==1){
		return true;
	}
	
	return false;
}
</script>





