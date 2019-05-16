<?php
//ValidateCrmSession();
require_once("../classes/cmp.class.php");
require_once("../classes/company.class.php");
$objCmp=new cmp();
$objCompany=new company();

$pack_id=$_GET['pack_id'];
if($pack_id>0){

	$arrayPkj=$objCmp->getPackagesById($pack_id);
	//print_r($arrayPkj);
	if(empty($arrayPkj[0]['name'])){
		header("location: dashboard");
		exit;
	}

	//$_SESSION['CrmCmpID'];
	$arrayCompany=$objCompany->GetCompanyDetail($_SESSION['CrmCmpID']);
	if(empty($arrayCompany[0]['CmpID'])){
		header("location: dashboard");
		exit;
	}

	$arrayCurrentOrder = $objCmp->GetCurrentOrder($_SESSION['CrmCmpID']);
	$Deduction = 0;
	if($arrayCurrentOrder[0]['OrderID']>0){
		// $arrayCurrentOrder[0]['TotalAmount'];
		$TimeSec = strtotime($arrayCurrentOrder[0]['EndDate']) - strtotime($arrayCurrentOrder[0]['StartDate']);
		$Days = round($TimeSec)/ (24*3600);
		$OneDayPrice = $arrayCurrentOrder[0]['TotalAmount']/$Days;

		$TimeLeft = strtotime($arrayCurrentOrder[0]['EndDate']) - strtotime(date('Y-m-d'));
		$DaysLeft = round($TimeLeft)/ (24*3600);
		if($DaysLeft>0 && $OneDayPrice>0){
			$Deduction = round($DaysLeft*$OneDayPrice);
		}

	}


}else{
	header("location: dashboard");
	exit;
}
?>

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
</style>

<SCRIPT LANGUAGE=JAVASCRIPT>


	function calculateCoupon555(){
		var TotalAmount = $('#TotalAmount').val();
		var CouponCode = document.getElementById("CouponCode").value;
		var SendUrl = "ajax_main.php?action=CouponCode&CouponCode="+escape(CouponCode)+"&TotalAmount="+escape(TotalAmount); 
		$('#coupontext').html('');
		if(CouponCode !=''){
				httpObj.open("GET", SendUrl, true);
				httpObj.onreadystatechange = function RecievePrice(){
					if (httpObj.readyState == 4) {
						if(httpObj.responseText!='') {
							//$('#pricetext').show();
							
							var Cdiscount=parseFloat(httpObj.responseText);
							if(Cdiscount>0){
							
								//alert(coupenParse);
							var TotalAmountVal = $('#TotalAmount').val();							
							var DiscountVal = TotalAmountVal*Cdiscount/100;
							var TotalPrice = TotalAmountVal-DiscountVal;
							  //alert(TotalPrice);
							  $('#CouponDiscount').val(DiscountVal);
							  $('#TotalAmount').val(TotalPrice);
							  $('#TotalAmountSpan').html(TotalPrice); 
							  $('#coupontext').html("<span class=greentxt>Coupon Code Applied.</span>"); 
							  $('#CouponCd').hide();
							}else{
								$('#coupontext').html(httpObj.responseText);
							}
							//alert(coupenParse);
							//$('#pricetext').html(httpObj.responseText);						
						}else {
							alert("Error occur : " + httpObj.responseText);				
						}
					}
				};
				httpObj.send(null);
		}
		

	}

	function calculateCoupon(){
		var TotalAmount = $('#TotalAmount').val();
		var CouponCode = document.getElementById("CouponCode").value;
		var SendUrl = "&action=CouponCode&CouponCode="+escape(CouponCode)+"&TotalAmount="+escape(TotalAmount);
		
	   	$.ajax({
		type: "GET",
		url: "ajax_main.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {
			var CouponApplied=0;
			if(responseText['id']>0){
                var packageId= $('#pack_id').val();
				var Percentage=responseText['Percentage'];
				var Amount=responseText['Amount'];
				var CouponType=responseText['CouponType'];
				var DiscountType=responseText['DiscountType'];
				var Package=responseText['Package'];
				var MaxUser = $('#MaxUser').val();
				var NumUser = parseInt(responseText['User']);
				var arrayPackage = Package.split(",");
				//// for hidden field 
				 $('#CouponType').val(CouponType);
				 $('#DiscountType').val(DiscountType);
				 $('#User').val(NumUser);
				
				/// 
				var packexist=0;
				
				if(CouponType=='Package'){
					for(var i = 0; i < arrayPackage.length; i++){
						if(packageId==arrayPackage[i]){
							packexist = 1;
							break;						
						}					
					}
					if(packexist==1){
						CouponType = DiscountType;
			
						if(NumUser>0 && MaxUser>NumUser){
							calculateprice(NumUser);	
						}				
					}
					
				}

				
				var TotalAmountVal = $('#TotalAmount').val();
				
				if(CouponType=='Percentage'){												
					  var DiscountVal = TotalAmountVal*Percentage/100;
					  var TotalPrice = TotalAmountVal-DiscountVal;	
					  if(TotalPrice<=0){
						  TotalPrice = 0;	
						}				  
					  $('#CouponDiscount').val(DiscountVal);
					  $('#TotalAmount').val(TotalPrice);
					  $('#TotalAmountSpan').html(TotalPrice); 					  
					  $('#CouponCd').hide();
					  CouponApplied=1;
					
				}else if(CouponType=='Fixed'){					
					  var TotalPrice = TotalAmountVal-Amount;
					  if(TotalPrice<=0){
						  TotalPrice = 0;	
						}					 
					  $('#CouponDiscount').val(Amount);
					  $('#TotalAmount').val(TotalPrice);
					  $('#TotalAmountSpan').html(TotalPrice); 					  
					  $('#CouponCd').hide();
					  CouponApplied=1;
					
				}
				
			
				
			}

			if(CouponApplied==1){
				$('#coupontext').html("<span class=greentxt>Coupon Code Applied.</span>"); 				
			}else{
				$('#coupontext').html("Coupon Code Not Applied.");
			}
			
			//document.getElementById("CustomerName").value=responseText["CustomerName"];
			   
		}

	   });


	}

	

	function calculateprice(UserLess){
		
		var MaxUser = $('#MaxUser').val();
		var UserNum = MaxUser - UserLess;
		var Price = $('#Price').val();
		var PlanDuration = $('#PlanDuration').val();
		var Duration = $('#Duration').val();
		var AdditionalSpace = $('#AdditionalSpace').val();
		var AdditionalSpaceUnit = $('#AdditionalSpaceUnit').val(); 
		var FreeSpace = $('#FreeSpace').val();
		var FreeSpaceUnit = $('#FreeSpaceUnit').val(); 
		var AdditionalSpacePrice = $('#AdditionalSpacePrice').val();
		var Deduction = $('#Deduction').val();
		var TotalAmount = 0; var AdditionalPrice = 0;
		var arrPlan = PlanDuration.split("/");
		var DaysLeft = $('#DaysLeft').val(); 

		//alert(PlanDuration);

		if(UserLess==0){
		 $('#CouponType').val('');
		 $('#DiscountType').val('');
		 $('#User').val('');
		}

		
		if(AdditionalSpace>0){
			var addition_sp = AdditionalSpace;
			if(AdditionalSpaceUnit=="TB"){
				addition_sp = addition_sp*1024;
			}			
			AdditionalPrice = (addition_sp*AdditionalSpacePrice)/10;
		}

		
		if(PlanDuration==Duration){
			TotalAmount = UserNum*Price;	
		}else if(Duration=='user/month' && PlanDuration=='user/year'){
			TotalAmount = UserNum*Price*12;	
			AdditionalPrice = AdditionalPrice*12;
		}else if(Duration=='user/month' && PlanDuration=='user/month'){
			TotalAmount = UserNum*(Price/12);	
		}else if(Duration=='user/month' && PlanDuration=='user/quarter'){
			TotalAmount = UserNum*Price*3;	
			AdditionalPrice = AdditionalPrice*3;
		}else if(Duration=='user/month' && PlanDuration=='user/halfyear'){
			TotalAmount = UserNum*Price*6;
			AdditionalPrice = AdditionalPrice*6;
		}

		
		TotalAmount = (TotalAmount + AdditionalPrice) - Deduction;
		
		TotalAmount = Math.round(TotalAmount);


		if(TotalAmount<=0){
			TotalAmount = 0;	
		}
		
		//TotalAmount = TotalAmount/coupenParse;
			
		$('#TotalAmount').val(TotalAmount);
		
		$('#pricetext').hide();
		$('#CouponCd').hide();
		$('#coupontext').html('');
		$('#CouponCode').val(''); 
		$('#CouponDiscount').val(''); 
		if(MaxUser>0){
		

			var datahtml = '<h3>You have been choosen subscription for 1 '+arrPlan[1]+'(s) for '+MaxUser+' user(s)<br></h3> <h3><br><br>Final Price: $<span id="TotalAmountSpan">'+TotalAmount+'</span> <br><br>Additional Space: '+AdditionalSpace+'  '+AdditionalSpaceUnit+'<br>Free Space: '+FreeSpace+'  '+FreeSpaceUnit+'</h3>';

			//var datahtml = '<h3>You have been choosen 1 '+arrPlan[1]+'(s) subscription for '+MaxUser+' user(s) for $'+TotalAmount+'<br>after deduction of $'+Deduction+'.<br>Your old deduction of $0.00 and time 23 days has been deducted<br>Space:20GB<br>Price: $20.00.</h3>';
			
			$('#pricetext').show();
			$('#CouponCd').show();
			$('#pricetext').html(datahtml);	
		}
	}
	
	


	
function validate(frm)
{	
	if( ValidateForSelect(frm.MaxUser, 'Number of users')
	){	
		return true;	
	}else{
		return false;	
	}
}


function coupon(frm){
	//var Url = "isRecordExists.php?CouponCode="+escape(document.getElementById("CouponCode").value);
	//SendExistRequest(Url,"CouponCode", "Coupon Code");
	//return false;
			
}




</SCRIPT>


<div class="top-cont1"></div>

<section id="mainContent">
<?php //echo $datah['Content'];?>



<div class="InfoText">

<div class="wrap clearfix"><article id="leftPart">

<div class="detailedContent">
<div class="column" id="content">
<div class="section"><a id="main-content"></a>

<h1 id="page-title" class="title" style="text-align: center;">Choose
Your Plan</h1>



<div class="region region-content">
<div class="block block-system" id="block-system-main">

<div class="content">
<div class="messages error clientside-error"
	id="clientsidevalidation-pre-payment-calculation-form-errors"
	style="display: none;">
<ul></ul>
</div>

<div id="PlanDetail"><span class="label">Plan Type:-</span> <span
	class="value"><?php echo $arrayPkj[0]['name'];?> </span><br>
<span class="label">Price:-</span> <span class="value">$<?php echo $arrayPkj[0]['price'];?>
</span> <br>
<span class="label">Free Space:-</span> <span class="value"><?php echo $arrayPkj[0]['space'].' GB';?>
</span></div>

<form accept-charset="UTF-8" id="pre-payment-calculation-form"
	method="post" action="index.php?slug=upgrade-paymentWTS"
	novalidate="novalidate" onsubmit="return validate(this);">
<div>


<div class="form-item form-type-select form-item-num-users"><label
	for="edit-num-users">Select Number of Users <span
	title="This field is required." class="form-required">*</span> </label>
<select class="form-select required" name="MaxUser" id="MaxUser"
	onchange="javascript:calculateprice(0);">
	<option value="">Select</option>
	<?php
	for($i=1;$i<=200;$i++){?>
	<option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php } ?>
</select></div>
<div class="form-item form-type-select form-item-space-size"><label
	for="edit-space-size">Select Additional Space </label> <select
	class="form-select" name="AdditionalSpace" id="AdditionalSpace"
	onchange="javascript:calculateprice(0);">
	<option selected="selected" value="0">Select</option>
	<?php
	for($j=10; $j<=50000; $j+=10){?>
	<option value="<?php echo $j;?>"><?php echo $j;?></option>
	<?php } ?>

</select></div>
<div class="form-item form-type-select form-item-space-unit"><label
	for="edit-space-unit">Select Space Unit </label> <select
	class="form-select" name="AdditionalSpaceUnit" id="AdditionalSpaceUnit"
	onchange="javascript:calculateprice(0);">
	<option value="GB">GB</option>
	<option value="TB">TB</option>
</select></div>
	
<div class="form-item form-type-select form-item-plan-duration"><label
	for="edit-plan-duration">Select Plan Duration <span
	title="This field is required." class="form-required">*</span> </label>
<select class="form-select required" name="PlanDuration"
	id="PlanDuration" onchange="javascript:calculateprice(0);">
	<?php 
	$PlanDurationChk=explode(",",$arrayPkj[0]['PlanDuration']);
	foreach($PlanDurationChk as $pdChk=>$pdchkVal){
		$arryP = explode("/",$pdchkVal);

?>
	<option  value="<?php echo $pdchkVal;?>"><?php echo ucfirst($arryP[0])." / ".ucfirst($arryP[1]);?></option>	
	<?php } ?>
</select>
</div>

<div id="CouponCd" style="display: none;"
	class="form-item form-type-select form-item-num-users"><label
	for="edit-num-users">Coupon Code </label> <input id="CouponCode"
	name="CouponCode" maxlength="250" class="datebox" value="" type="text">
<input type="button" name="apply" value="Apply" id="btn1"
	onclick="calculateCoupon()" /></div>
<div id="coupontext"></div>
<div id="pricetext"></div>

<!--div id="pricetext55">
																<h3>Your current subscription is 1 month(s) for 1
																	user(s) for price $0.00 .</h3>
																<br>
																<h3>Your Current Usage is 0 GB. Additional Space: 0 GB
																	Free Space:- 5GB</h3>
															</div--> <input type="hidden" name="FreeSpace"
	id="FreeSpace" value="<?php echo $arrayPkj[0]['space'];?>"> <input
	type="hidden" name="FreeSpaceUnit" id="FreeSpaceUnit" value="GB"> <input
	type="hidden" name="pack_id" id="pack_id"
	value="<?php echo $pack_id;?>"> <input type="hidden" name="Price"
	id="Price" value="<?php echo $arrayPkj[0]['price'];?>"> <input
	type="hidden" name="AdditionalSpacePrice" id="AdditionalSpacePrice"
	value="<?php echo $arrayPkj[0]['additional_spaceprice'];?>"> <input
	type="hidden" name="Deduction" id="Deduction"
	value=<?php echo $Deduction;?>> <input type="hidden" name="DaysLeft"
	id="DaysLeft" value=<?php echo $DaysLeft;?>> <input type="hidden"
	name="Duration" id="Duration"
	value="<?php echo $arrayPkj[0]['duration'];?>"> <input type="hidden"
	name="TotalAmount" id="TotalAmount" value="0"> <input type="hidden"
	name="CouponType" id="CouponType" value="0"> <input type="hidden"
	name="DiscountType" id="DiscountType" value="0"> <input type="hidden"
	name="NumUser" id="NumUser" value="0"> <input type="hidden"
	name="CouponDiscount" id="CouponDiscount" value="0"> <input
	type="submit" class="form-submit" value="Proceed to pay" name="op"
	id="edit-submit"></div>
</form>
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

