<?php
ValidateCrmSession();
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
	function calculateprice555(){
		var MaxUser = document.getElementById("MaxUser").value;
		var SendUrl = "ajax_main.php?action=upgradeprice&MaxUser="+escape(MaxUser)+"&r="+Math.random(); 
		$('#pricetext').hide();
		if(MaxUser>0){
				httpObj.open("GET", SendUrl, true);
				httpObj.onreadystatechange = function RecievePrice(){
					if (httpObj.readyState == 4) {
						if(httpObj.responseText!='') {
							$('#pricetext').show();
							$('#pricetext').html(httpObj.responseText);						
						}else {
							alert("Error occur : " + httpObj.responseText);				
						}
					}
				};
				httpObj.send(null);
		}
	}


	function calculateCoupon(){
		 
		var CouponCode = document.getElementById("CouponCode").value;
		var SendUrl = "ajax_main.php?action=CouponCode&CouponCode="+escape(CouponCode); 
		$('#pricetext').hide();
		if(CouponCode !=''){
				httpObj.open("GET", SendUrl, true);
				httpObj.onreadystatechange = function RecievePrice(){
					if (httpObj.readyState == 4) {
						if(httpObj.responseText!='') {
							//$('#pricetext').show();
							
							var coupenParse=parseFloat(httpObj.responseText);
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
	

	function calculateprice(){
		var MaxUser = $('#MaxUser').val();
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
		
		if(AdditionalSpace>0){
			var addition_sp = AdditionalSpace;
			if(AdditionalSpaceUnit=="TB"){
				addition_sp = addition_sp*1024;
			}			
			AdditionalPrice = (addition_sp*AdditionalSpacePrice)/10;
		}

		
		if(PlanDuration==Duration){
			TotalAmount = MaxUser*Price;	
		}else if(Duration=='user/month' && PlanDuration=='user/year'){
			TotalAmount = MaxUser*Price*12;	
		}else if(Duration=='user/year' && PlanDuration=='user/month'){
			TotalAmount = MaxUser*(Price/12);	
		}
		TotalAmount = (TotalAmount + AdditionalPrice) - Deduction;
		
		TotalAmount = Math.round(TotalAmount);

		//TotalAmount = TotalAmount/coupenParse;
			
		$('#TotalAmount').val(TotalAmount);
		
		$('#pricetext').hide();
		if(MaxUser>0){
			var datahtml = '<h3>You have been choosen subscription for 1 '+arrPlan[1]+'(s) for '+MaxUser+' user(s)<br>After deduction of $'+Deduction+' for time '+DaysLeft+' day(s):</h3> <h3><br>Final Price:- $'+TotalAmount+' <br>Additional Space:- '+AdditionalSpace+'  '+AdditionalSpaceUnit+'<br>Free Space:- '+FreeSpace+'  '+FreeSpaceUnit+'</h3>';

			//var datahtml = '<h3>You have been choosen 1 '+arrPlan[1]+'(s) subscription for '+MaxUser+' user(s) for $'+TotalAmount+'<br>after deduction of $'+Deduction+'.<br>Your old deduction of $0.00 and time 23 days has been deducted<br>Space:20GB<br>Price: $20.00.</h3>';
			
			$('#pricetext').show();
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


<div class="top-cont1"> </div>

			<section id="mainContent">
			<?php //echo $datah['Content'];?>



				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title" style="text-align: center;">
											Choose Your Plan</h1>



										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-pre-payment-calculation-form-errors"
														style="display: none;">
														<ul></ul>
													</div>

													<div id="PlanDetail">
														<span class="label">Plan Type:-</span> <span class="value"><?php echo $arrayPkj[0]['name'];?>
														</span><br> <span class="label">Price:-</span> <span
															class="value">$<?php echo $arrayPkj[0]['price'];?> </span>
														<br> <span class="label">Free Space:-</span> <span
															class="value"><?php echo $arrayPkj[0]['space'].' GB';?> </span>

													</div>

													<form accept-charset="UTF-8"
														id="pre-payment-calculation-form" method="post"
														action="index.php?slug=upgrade-payment"
														novalidate="novalidate" onsubmit="return validate(this);">
														<div>
															<div id="prepricetext">
																<h3>
																	Your current subscription is for
																	<?php echo $arrayCompany[0]['MaxUser'];?>
																	user(s) till
																	<?=date("jS F, Y",strtotime($arrayCompany[0]['ExpiryDate']))?>
																	.
																</h3>
																<br>
																<h3>

																<?php
																//if($arrayCompany[0]['Storage']>0){
																$UsedStorage = $arrayCompany[0]['Storage']; //kb
																if($UsedStorage>0){
																	if($UsedStorage<1024){
																		$StorageUsed = $UsedStorage.' KB';
																	}else if($UsedStorage<1024*1024){
																		$StorageUsed = round($UsedStorage/1024,2).' MB';
																	}else if($UsedStorage<1024*1024*1024){
																		$StorageUsed = round(($UsedStorage/(1024*1024)),8).' GB';
																	}else{
																		$StorageUsed = round(($UsedStorage/(1024*1024*1024)),8).' TB';
																	}
																}else{
																	$StorageUsed= '0';
																}
																echo "Your Current Usage is ". $StorageUsed.'.';
																//}

																if($arrayCompany[0]['StorageLimit']>0){
																	echo " Current Space:- ".$arrayCompany[0]['StorageLimit']." ".$arrayCompany[0]['StorageLimitUnit']."";
																}
																	
																	
																	
																?>

																</h3>
															</div>
															<div
																class="form-item form-type-select form-item-num-users">
																<label for="edit-num-users">Select Number of users <span
																	title="This field is required." class="form-required">*</span>
																</label> <select class="form-select required"
																	name="MaxUser" id="MaxUser"
																	onchange="javascript:calculateprice();"><option
																		value="">Select</option>
																		<?php
																		for($i=1;$i<=200;$i++){?>
																	<option value="<?php echo $i;?>">
																	<?php echo $i;?>
																	</option>
																	<?php } ?>
																</select>
															</div>
															<div
																class="form-item form-type-select form-item-space-size">
																<label for="edit-space-size">Select Additional Space </label>
																<select class="form-select" name="AdditionalSpace"
																	id="AdditionalSpace"
																	onchange="javascript:calculateprice();">
																	<option selected="selected" value="0">select</option>
																	<?php
																	for($j=10; $j<=50000; $j+=10){?>
																	<option value="<?php echo $j;?>">
																	<?php echo $j;?>
																	</option>
																	<?php } ?>

																</select>

															</div>
															<div
																class="form-item form-type-select form-item-space-unit">
																<label for="edit-space-unit">Select Space Unit </label>
																<select class="form-select" name="AdditionalSpaceUnit"
																	id="AdditionalSpaceUnit"
																	onchange="javascript:calculateprice();">
																	<option value="GB">GB</option>
																	<option value="TB">TB</option>
																</select>
															</div>
															<div
																class="form-item form-type-select form-item-plan-duration">
																<label for="edit-plan-duration">Select Plan Duration <span
																	title="This field is required." class="form-required">*</span>
																</label> <select class="form-select required"
																	name="PlanDuration" id="PlanDuration"
																	onchange="javascript:calculateprice();"><option
																		selected="selected" value="user/month">user/month</option>
																	<option value="user/year">user/year</option>
																</select>
															</div>

															<div
																class="form-item form-type-select form-item-num-users">
																<label for="edit-num-users">Coupon Code </label> <input
																	id="CouponCode" name="CouponCode" maxlength="250"
																	class="datebox" value="" type="text">
																	<input type="button" name="apply" value="Apply" id="btn1" onclick="calculateCoupon()"/>
																	
																	 
															</div>

															<div id="pricetext"></div>

															<!--div id="pricetext55">
																<h3>Your current subscription is 1 month(s) for 1
																	user(s) for price $0.00 .</h3>
																<br>
																<h3>Your Current Usage is 0 GB. Additional Space:- 0 GB
																	Free Space:- 5GB</h3>
															</div-->



															<input type="hidden" name="FreeSpace" id="FreeSpace"
																value="<?php echo $arrayPkj[0]['space'];?>"> <input
																type="hidden" name="FreeSpaceUnit" id="FreeSpaceUnit"
																value="GB"> <input type="hidden" name="pack_id"
																id="pack_id" value="<?php echo $pack_id;?>"> <input
																type="hidden" name="Price" id="Price"
																value="<?php echo $arrayPkj[0]['price'];?>"> <input
																type="hidden" name="AdditionalSpacePrice"
																id="AdditionalSpacePrice"
																value="<?php echo $arrayPkj[0]['additional_spaceprice'];?>">
															<input type="hidden" name="Deduction" id="Deduction"
																value=<?php echo $Deduction;?>> <input type="hidden"
																name="DaysLeft" id="DaysLeft"
																value=<?php echo $DaysLeft;?>> <input type="hidden"
																name="Duration" id="Duration"
																value="<?php echo $arrayPkj[0]['duration'];?>"> <input
																type="hidden" name="TotalAmount" id="TotalAmount"
																value="0"> <input type="submit" class="form-submit"
																value="Proceed to pay" name="op" id="edit-submit">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>




			</section>

		</div>


