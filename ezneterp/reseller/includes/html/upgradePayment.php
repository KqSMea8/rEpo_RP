
<style>
.tabs {
	display: block;
}

#page-title {
	color: #333;
	font-size: 32px;
	font-weight: 300;
	margin: 50px 0 0;
	padding: 0 0 30px;
	text-align: left;
}

#payment-form {
	margin: 0px auto auto;
}
</style>

<script language="JavaScript1.2" type="text/javascript">




function validatePayment(){

	if( ValidateForSimpleBlank(document.getElementById("customer_first_name"), "First Name")
		&& ValidateForSimpleBlank(document.getElementById("customer_last_name"), "Last Name")
		&& ValidateMandRange(document.getElementById("DisplayName"), "User Name",3,30)
		&& isUserName(document.getElementById("DisplayName"))
		&& ValidateForSimpleBlank(document.getElementById("Email"), "Email")
		&& isEmail(document.getElementById("Email"))
		&& ValidateForSimpleBlank(document.getElementById("CompanyName"), "Company Name")	
		&& ValidateMandRange(document.getElementById("customer_credit_card_number"), "Card Number",10,20)
		&& ValidateForSimpleBlank(document.getElementById("cc_cvv2_number"), "CSV Number")
		&& ValidateForSimpleBlank(document.getElementById("customer_address1"), "Address Line 1")
		&& ValidateForSimpleBlank(document.getElementById("customer_city"), "City")
		&& ValidateForSimpleBlank(document.getElementById("customer_state"), "State")
		&& isZipCode(document.getElementById("customer_zip"))
		){ 
		 
		//var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID=&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

		//CheckMultipleExist(Url,"Email", "Email Address","DisplayName", "User Name")

		return true;	
			
		}else{
				return false;	
		}	

		
}
</script>



<div class="top-cont1"></div>

<section id="mainContent">
<?php //echo $datah['Content'];?>

<?php
$arrDuration = explode("/", $_POST['PlanDuration']);

?>

<div class="InfoText">

<div class="wrap clearfix"><article id="leftPart">

<div class="detailedContent">
<div class="column" id="content">
<div class="section"><a id="main-content"></a>

<h1 style="text-align: center;" class="title" id="page-title">Checkout</h1>

<table id="cart-table" class="table table-striped">
	<thead>
		<tr>
			<th width="20%" class="text-center">Item</th>
			<th width="30%" class="text-center">Number of users</th>
			<th width="20%" class="text-center">Plan Type</th>
			<th width="20%" class="text-center">Price $</th>
			<th width="15%" class="text-center">Subtotal $</th>
		</tr>
	</thead>
	<tbody id="cartcontents">
		<tr>
			<td>CRM: <?php echo $arrayPkjName[0]['name'];?></td>
			<td class="text-center"><?php echo $_POST['MaxUser'];?></td>
			<td class="text-center"><?php echo $arrayPkjName[0]['name'];?></td>
			<td class="text-center"><?php echo $_POST['TotalAmount'];?></td>
			<td class="text-right"><?php echo $_POST['TotalAmount'];?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td class="text-right" colspan="4">
			<h3>Total:</h3>
			</td>
			<td class="text-right">
			<h3 id="total-display">$ <?php echo $_POST['TotalAmount'];?></h3>
			</td>
		</tr>
	</tfoot>
</table>



<div class="region region-content">
<div class="block block-system" id="block-system-main">


<div class="content">
<div class="messages error clientside-error"
	id="clientsidevalidation-payment-form-errors" style="display: none;">
<ul style="display: none;"></ul>
</div>

<div class="message_success" id="msg_div" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>


<div class="pay-mn">
<form accept-charset="UTF-8" id="payment-form" name="paymentform"
	method="post" action="index.php?slug=upgrade-paymentWTS"
	novalidate="novalidate" onSubmit="return validatePayment();"
	style="width: 100%;">

<? if($_POST['TotalAmount']>0){ ?>
<div class="payinfo-lft">

<h1
	style="font-size: 25px; font-weight: 300; margin-left: 18%; text-align: left;">Payment
Information</h1>


<div>


<div
	class="form-item form-type-select form-item-customer-credit-card-type">
<label for="edit-customer-credit-card-type">Card Type </label> <select
	class="form-select valid" name="customer_credit_card_type"
	id="customer_credit_card_type">
	<option value="Visa">Visa</option>
	<option value="MasterCard"
	<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="MasterCard"){ echo "selected";}?>>MasterCard</option>
	<option value="Discover"
	<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="Discover"){ echo "selected";}?>>Discover</option>
	<option value="Amex"
	<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="Amex"){ echo "selected";}?>>American
	Express</option>
</select></div>
<div
	class="form-item form-type-textfield form-item-customer-credit-card-number">
<label for="edit-customer-credit-card-number">Card Number <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value="" name="customer_credit_card_number"
	id="customer_credit_card_number"> <span class="odr-cl"
	style="display: none;"><?= !empty($arrayOrderInfo[0]['customer_credit_card_number'])? '***********'. substr($arrayOrderInfo[0]['customer_credit_card_number'],-2-3):''; ?>
</span></div>
<div class="form-item form-type-select form-item-cc-expiration-month"><label
	for="edit-cc-expiration-month">Expiry Month </label> <select
	class="form-select" name="cc_expiration_month"
	id="edit-cc-expiration-month">
	<?php
	for($i=1;$i<=12;$i++){?>
	<option value="<?php echo $i;?>"
	<?php if($arrayOrderInfo[0]['cc_expiration_month']==$i){ echo "selected";}?>>
		<?php echo $i;?></option>
		<?php } ?>

</select></div>
<div class="form-item form-type-select form-item-cc-expiration-year"><label
	for="edit-cc-expiration-year">Expiry Year </label> <select
	class="form-select" name="cc_expiration_year"
	id="edit-cc-expiration-year">
	<?php
	$startYear=date("Y");

	for($j=$startYear;$j<=$startYear+20;$j++){?>
	<option value="<?php echo $j;?>"
	<?php if($arrayOrderInfo[0]['cc_expiration_year']==$j){ echo "selected";}?>>
		<?php echo $j;?></option>
		<?php } ?>
</select></div>
<div class="form-item form-type-textfield form-item-cc-cvv2-number"><label
	for="edit-cc-cvv2-number">CSV Number <span
	title="This field is required." class="form-required">*</span> </label>
<input type="password" class="form-text required" maxlength="5"
	size="60"
	value="<?= !empty($arrayOrderInfo[0]['cc_cvv2_number'])?stripslashes($arrayOrderInfo[0]['cc_cvv2_number']):''; ?>"
	name="cc_cvv2_number" id="edit-cc-cvv2-number"></div>
<div class="form-item form-type-textfield form-item-customer-address1">
<label for="edit-customer-address1">Address Line 1 <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="150" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_address1'])?stripslashes($arrayOrderInfo[0]['customer_address1']):''; ?>"
	name="customer_address1" id="edit-customer-address1"></div>
<div class="form-item form-type-textfield form-item-customer-address2">
<label for="edit-customer-address2">Address Line 2 (Optional) </label> <input
	type="text" class="form-text" maxlength="150" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_address2'])?stripslashes($arrayOrderInfo[0]['customer_address2']):''; ?>"
	name="customer_address2" id="edit-customer-address2"></div>
<div class="form-item form-type-textfield form-item-customer-city"><label
	for="edit-customer-city">City <span title="This field is required."
	class="form-required">*</span> </label> <input type="text"
	class="form-text required" maxlength="40" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_city'])?stripslashes($arrayOrderInfo[0]['customer_city']):''; ?>"
	name="customer_city" id="edit-customer-city"></div>
<div class="form-item form-type-textfield form-item-customer-state"><label
	for="edit-customer-state">State <span title="This field is required."
	class="form-required">*</span> </label> <input type="text"
	class="form-text required" maxlength="40" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_state'])?stripslashes($arrayOrderInfo[0]['customer_state']):''; ?>"
	name="customer_state" id="edit-customer-state"></div>
<div class="form-item form-type-select form-item-customer-country"><label
	for="edit-customer-country">Country </label> 
	
	



<? $CountrySelected = 1; ?>
            <select name="country_id" class="form-select valid" id="country_id" >
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>

</div>

<div class="form-item form-type-textfield form-item-customer-zip"><label
	for="edit-customer-zip">Zip Code <span title="This field is required."
	class="form-required">*</span> </label> <input type="text"
	class="form-text required" maxlength="20" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_zip'])?stripslashes($arrayOrderInfo[0]['customer_zip']):''; ?>"
	name="customer_zip" id="edit-customer-zip"></div>


		</div>


</div>
<? } ?>
<div class="cmp-info-rght">

<h1
	style="font-size: 25px; font-weight: 300; text-align: left; margin-left: 15%;">Create
Account</h1>

<div>

<div class="form-item form-type-textfield form-item-customer-first-name">
<label for="edit-customer-first-name">First Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_first_name'])?stripslashes($arrayOrderInfo[0]['customer_first_name']):''; ?>"
	name="customer_first_name" id="customer_first_name"></div>
<div class="form-item form-type-textfield form-item-customer-last-name">
<label for="edit-customer-last-name">Last Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value="<?= !empty($arrayOrderInfo[0]['customer_last_name'])?stripslashes($arrayOrderInfo[0]['customer_last_name']):''; ?>"
	name="customer_last_name" id="customer_last_name"></div>


<div class="form-item form-type-textfield form-item-customer-last-name">
<label for="edit-customer-last-name">User Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="60" size="60"
	value="" name="DisplayName" id="DisplayName" onKeyPress="return isUniqueKey(event);"></div>



<div class="form-item form-type-textfield form-item-customer-last-name">
<label for="edit-customer-last-name">E-mail address<span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="254" size="60"
	value="" name="Email" id="Email"
	onKeyPress="Javascript:ClearAvail('MsgSpan_Email');"
	onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>'); "></div>


<div class="form-item form-type-textfield form-item-customer-last-name">
<label for="edit-customer-last-name">Company Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" maxlength="50" size="60" value="" name="CompanyName"
	id="CompanyName" class="text-full form-text"></div>


</div>


</div>

<?php
		foreach($_POST as $key=>$values){
			echo '<input type="hidden" name="'.$key.'" value="'.$values.'">';
		}
			
		?> <input type="hidden" name="PaymentPlan"
	value="<?php echo $arrayPkj[0]['name'];?>">

<input type="submit" class="form-submit" value="submit" name="submit"
	id="submit" style="margin-left: 45%;"></form>

</div>



</div>
</div>
</div>
</div>
</div>
</div>

</article></div>

</div>


</section>

</div>


