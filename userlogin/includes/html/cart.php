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
				<td class="head1"  width="15%">Date</td>
				<td class="head1" width="10%">Qty</td>
				<td width="20%" class="head1">Product</td>
				<td width="30%" class="head1">Note</td>
				<td width="10%" align="center" class="head1">Action</td>
			</tr>
			<?php if(count($CartItem)>0){
				foreach($CartItem as $list){
			
			echo '<tr bgcolor="#ffffff" valign="middle" align="left">
				<td>'.$list['CartID'].'</td>
				<td>'.date('l, F d Y',strtotime($list['AddedDate'])).'</td>
				<td>'.$list['Quantity'].'</td>
				<td>'.$list['Sku'].'</td>
				<td>'.$list['DesComment'].'</td>
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
			<td> Sales Person  : </td>
			<td >
				<input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arryCustomer[0]['SalesPerson']); ?>"  maxlength="40" readonly />
				<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arryCustomer[0]['SalesPersonID']); ?>" type="hidden">
				

			</td>	
			
		</tr>
		
		<tr bgcolor="#ffffff" valign="middle" align="left">
				 <td > Delivery Date  : </td>
        <td>

		<script type="text/javascript">
		$(function() {
			$('#DeliveryDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true
		
				}
			);
		});
		</script>

<input id="DeliveryDate" name="DeliveryDate" readonly="" class="datebox" value=""  type="text" > 


</td>
<td> Currency  : </td>
	<td>
<? 

if(empty($arryCompany[0]['AdditionalCurrency']))
$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

 ?>
<select name="CustomerCurrency" disabled="disabled" class="disabled"    id="CustomerCurrency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" >
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>
			
		</tr>
		
		<tr>

        <td >Payment Term  :</td>
        <td >
		<? if(!empty($TransactionExist)){ ?>
		<input type="text" name="PaymentTerm" id="PaymentTerm" maxlength="30" readonly class="disabled_inputbox"  value="<?=(!empty($arrySale[0]['PaymentTerm']))?($arrySale[0]['PaymentTerm']):("")?>">
		<? }else{ ?>
		  <select name="PaymentTerm" disabled="disabled" class="disabled"   id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						if($arryPaymentTerm[$i]['termType']==1){
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
						}else{
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
						}
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryCustomer[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		
		<select name="SelectCard" class="textbox" id="SelectCard"  style="display:none;">
		  	<option value="">--- Select ---</option>
			<option value="New">New Card</option>
			<option value="Existing">Existing</option>	 	 
		</select> 
		<? } ?>

		</td>

		<td>Payment Method  :</td>
                 <td>
		  <select name="PaymentMethod"  disabled="disabled" class="disabled"  id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<?php for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
                                    <option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryCustomer[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
                                    </option>
			<? } ?>
		</select> 
		</td>



</tr>
<tr>
        

        <td  align="right" class="blackbold">Shipping Carrier  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod" onchange="Javascript:shipCarrier();">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryCustomer[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
<td> Customer PO#  : </td>
	<td>
	<input name="CustomerPO" type="text" class="inputbox" id="CustomerPO" value=""  maxlength="50" />          
	</td>

</tr>
<tr id="spmethod" style="display:none;">
	<td align="right" class="blackbold">Shipping Method : </td>
	<td align="left">
	<select name="ShippingMethodVal" class="inputbox" id="ShippingMethodVal">
	</select>
	<input type="hidden" name="spval" id="spval" value="<?=(!empty($arrySale[0]['ShippingMethodVal']))?($arrySale[0]['ShippingMethodVal']):("") ?>">

	</td>
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
jQuery('document').ready(function(){

	jQuery('#PaymentTerm').change(function(){
		if(jQuery(this).val()=='PayPal'){
			if(jQuery('.paypa-email-tr').length==0){
				var html='';
				html+='<tr class="paypa-email-tr" id="paypa-email-tr"><td align="right" class="blackbold">Paypal Email:</td>';
				html+='<td align="left" id="paypal-email-input-td"><input type="text" class="inputbox" name="paypalemail" id="paypalemail">';
				if(jQuery('#CustID').val()){
					html+='<a href="paypalemail.php?cid='+jQuery('#CustID').val()+'" class="fancybox fancybox.iframe" id="paypalemailSearch"><img src="../images/search.png"></a>';
				}
				html+='</td>';
				html+='<td align="right" class="blackbold"> </td><td align="left"></td></tr>';
			jQuery(this).parent('td').parent('tr').after(html);
			}		
		}else{
			jQuery('.paypa-email-tr').remove();
		}
		SelectCreditCard();
		
	});
	
	
});
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

function SelectCreditCard(){
	/*$('#SelectCard').hide();
	$('#CreditCardInfo').hide();  */
 
	
	if($("#PaymentTerm").val()=='Credit Card'){
		$('#SelectCard').show(); 
		if($("#CreditCardNumber").val()!='' && $("#CreditCardType").val()!=''){
			$('#CreditCardInfo').show(); 
		}else{
			$('#CreditCardInfo').hide();  
		}
	}else{
		$('#SelectCard').hide();
		$('#CreditCardInfo').hide();  
	}
	
}
function shipCarrier(){
	var method = document.getElementById("ShippingMethod").value;
	var spval = document.getElementById("spval").value;
	 
	var countryCode= '';
	var SendParam = 'action='+method+'&countryCode='+countryCode+'&shippval='+spval; 

	if(method==''){
		 document.getElementById("spmethod").style.display = 'none'; 
		document.getElementById("ShippingMethodVal").value=''; 
	}else{

		 $.ajax({
			type: "GET",
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
				if(responseText!=''){
					document.getElementById("spmethod").style.display = 'table-row';
					document.getElementById("ShippingMethodVal").innerHTML=responseText; 
				}else{
					 document.getElementById("spmethod").style.display = 'none'; 
					document.getElementById("ShippingMethodVal").value=''; 
				}
		
			}
		});	
 	}

}

</script>





