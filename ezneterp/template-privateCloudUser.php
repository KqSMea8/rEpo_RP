<?php

?>

<style type="text/css">
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
</style>

<script>
function validate(frm)
{	
	if( ValidateForSelect(frm.MaxUser, 'Number of users')
	){	
		return true;	
	}else{
		return false;	
	}
}
</script>
<div class="top-cont1"></div>

<section id="mainContent"> <?php echo $datah['Content'];?>


<div class="redmsg" align="center"><? echo $_SESSION["PricingMsg"] ; unset($_SESSION["PricingMsg"]);?></div>



<form accept-charset="UTF-8" id="pre-payment-calculation-form"
	method="post" action="privateCloudPayment"
	novalidate="novalidate" onsubmit="return validate(this);">
<div>


<div class="form-item form-type-select form-item-num-users"><label
	for="edit-num-users">Select Number of users <span
	title="This field is required." class="form-required">*</span> </label>
<select class="form-select required" name="MaxUser" id="MaxUser"
	onchange="javascript:calculateprice(0);">
	<option value="">Select</option>
	<?php
	for($i=1;$i<=200;$i++){?>
	<option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php } ?>
</select></div>


<div class="form-item form-type-select form-item-plan-duration"><label
	for="edit-plan-duration">Select Plan Duration </label>
<select class="form-select required" name="PlanDuration"
	id="PlanDuration">
	<option selected="selected" value="user/month">user/month</option>
	<option value="user/year">user/year</option>
</select>
</div>



<input type="submit" class="continue-cl" value="Proceed to pay" name="op"
	id="edit-submit" title="Proceed to pay"></div>
</form>

</section></div>


