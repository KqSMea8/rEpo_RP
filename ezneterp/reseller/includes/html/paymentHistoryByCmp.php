
<div class="had">Order History Detail</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
  <td  valign="top" align="left">

<table width="90%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="30%" > Company Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryohByCmpId[0]['CompanyName']); ?></strong>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Company ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryohByCmpId[0]['CmpID']); ?>
           </td>
      </tr>
      
        <tr>
        <td  align="right"   class="blackbold"  > PaymentPlan: </td>
        <td   align="left" >
<?php echo stripslashes($arryohByCmpId[0]['PaymentPlan']); ?>
           </td>
      </tr>
      
  <tr>
  
        <td  align="right"   class="blackbold"  > Display Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryohByCmpId[0]['DisplayName']); ?>
           </td>
      </tr>
<tr>
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['Email']; ?>
</td>
</tr>


<tr>
	 <td  align="right">Start Date : </td>
 <td  align="left">
<?  if($arryohByCmpId[0]['StartDate']>0){ echo date("j F, Y",strtotime($arryohByCmpId[0]['StartDate'])); }?>
</td>
</tr>

<tr>
	 <td  align="right">End Date : </td>
 <td  align="left">
<?  if($arryohByCmpId[0]['EndDate']>0){ echo date("j F, Y",strtotime($arryohByCmpId[0]['EndDate'])); }?>
</td>
</tr>

<tr>
	 <td  align="right">Updated Date : </td>
 <td  align="left">
<?  if($arryohByCmpId[0]['UpdatedDate']>0){ echo date("j F, Y",strtotime($arryohByCmpId[0]['UpdatedDate'])); }?>
</td>
</tr>


<tr>
	 <td  align="right">Max User: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['MaxUser']; ?>
</td>
</tr>

<tr>
	 <td  align="right">PlanDuration: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['PlanDuration']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Price: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['Price']; ?> $
</td>
</tr>

<tr>
	 <td  align="right">Total Amount: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['TotalAmount']; ?> $
</td>
</tr>

<tr>
	 <td  align="right">Free Space: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['FreeSpace']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Free Space Unit: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['FreeSpaceUnit']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Additional Space: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['AdditionalSpace']; ?>
</td>
</tr>


<tr>
	 <td  align="right">Additional Space Unit: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['AdditionalSpaceUnit']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Transaction ID: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['TransactionID']; ?>
</td>
</tr>


<tr>
	 <td  align="right">Coupon Code: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['CouponCode']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Coupon Discount: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['CouponDiscount']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Coupon Type: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['CouponType']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Discount Type: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['DiscountType']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Num User: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['NumUser']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Customer First Name: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_first_name']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Customer Last Name: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_last_name']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Credit Card Type: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_credit_card_type']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Credit Card Number: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_credit_card_number']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Credit Card Expiration:</td>
 <td  align="left">
<?php 
if($arryohByCmpId[0]['cc_expiration_month']<10){
	echo "0". $arryohByCmpId[0]['cc_expiration_month']."/".$arryohByCmpId[0]['cc_expiration_year'];
	
}else{
	echo $arryohByCmpId[0]['cc_expiration_month']."/".$arryohByCmpId[0]['cc_expiration_year'];
}
 ?>
</td>
</tr>

<tr>
	 <td  align="right">cvv2 Number: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['cc_cvv2_number']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Customer Address1: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_address1']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Customer Address2: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_address2']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Customer City: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_city']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Customer State: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_state']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Country Code: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['country_id']; ?>
</td>
</tr>

<tr>
	 <td  align="right">Zip Code: </td>
 <td  align="left">
<?php echo $arryohByCmpId[0]['customer_zip']; ?>
</td>
</tr>



</table>

</td>
</tr>

</table>