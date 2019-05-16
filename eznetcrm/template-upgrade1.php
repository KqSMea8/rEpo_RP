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

	<div id="skip-link">
		<a href="#main-content" class="element-invisible element-focusable">Skip
			to main content</a>
	</div>
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
			
		$('#TotalAmount').val(TotalAmount);
		
		$('#pricetext').hide();
		if(MaxUser>0){
			var datahtml = '<h3>Your currenty selected subscription is 1 '+arrPlan[1]+'(s) for '+MaxUser+' user(s)<br> for price $'+TotalAmount+' .</h3> <br><h3>Additional Space:- '+AdditionalSpace+'  '+AdditionalSpaceUnit+'  Free Space:- '+FreeSpace+'  '+FreeSpaceUnit+'</h3>';
				
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
</SCRIPT>
	<div id="wrapper">

		<div id="mainContainer">

			<header id="headerArea">

				<div class="wrap clearfix">

					<div class="logo">
						<a href="index.php" title="Home" rel="home" id="logo"> <img
							src="img/eZnetLogo.png" alt="Home"> </a>
					</div>
					<?php include('includes/user_menu.php');?>
					<nav class="menuArea">
						<div class="region region-main-menu">
							<div id="block-superfish-1" class="block block-superfish">


								<div class="content">
									<ul id="superfish-1"
										class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow">
										<?php
										$bannerDt=showBanner();
										foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

										<li id="menu-218-1"
											class=" middle even sf-item-2 sf-depth-1 sf-no-children <?php if($_GET['slug']==$meData['UrlCustom']){echo 'active-trail first odd sf-item-1 sf-depth-1 sf-no-children';}?>"><a
											href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
											class="sf-depth-1"><?php echo $meData['Title'];?> </a>
										</li>


										<?php } ?>

									</ul>
								</div>
							</div>
						</div>
					</nav>

				</div>

			</header>

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


															<div id="pricetext"></div>

															<!--div id="pricetext55">
																<h3>Your current subscription is 1 month(s) for 1
																	user(s) for price $0.00 .</h3>
																<br>
																<h3>Your Current Usage is 0 GB. Additional Space:- 0 GB
																	Free Space:- 5GB</h3>
															</div-->


				
<input type="hidden" name="FreeSpace" id="FreeSpace" value="<?php echo $arrayPkj[0]['space'];?>">
<input type="hidden" name="FreeSpaceUnit" id="FreeSpaceUnit" value="GB">
<input type="hidden" name="pack_id" id="pack_id" value="<?php echo $pack_id;?>"> 
<input type="hidden" name="Price" id="Price" value="<?php echo $arrayPkj[0]['price'];?>"> 
<input type="hidden" name="AdditionalSpacePrice" id="AdditionalSpacePrice" value="<?php echo $arrayPkj[0]['additional_spaceprice'];?>"> 
<input type="hidden" name="Deduction" id="Deduction" value=<?php echo $Deduction;?>>

<input type="hidden" name="Duration" id="Duration" value="<?php echo $arrayPkj[0]['duration'];?>"> 
<input type="hidden" name="TotalAmount" id="TotalAmount" value="0">
 <input type="submit" class="form-submit" value="Proceed to pay" name="op" id="edit-submit">
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


		<footer id="footer">

			<div class="wrap clearfix">

				<div class="followUs">
					<h2>Follow Us</h2>
					<div class="region region-footer-firstcolumn">
						<div id="block-block-1" class="block block-block">


							<div class="content">
								<ul>
								<?php
								$socialDat=getSocialLinks();
								foreach($socialDat as $socialData){?>
									<li><a href="<?php echo $socialData['URI'];?>" target="_blank"><img
											src="../images/<?php echo $socialData['Icon'];?>"> </a></li>
											<?php } ?>


								</ul>


								<br> <br> <br> <br> <br>
								<h2>Subscribe to our Newsletter</h2>
							</div>
						</div>
						<div id="block-simplenews-1" class="block block-simplenews">


							<div class="content">

								<div style="display: none;"
									id="clientsidevalidation-simplenews-block-form-1-errors"
									class="messages error clientside-error">
									<ul></ul>
								</div>
								<form novalidate="novalidate" class="simplenews-subscribe"
									id="srform" name="form" accept-charset="UTF-8">
									<div>
										<div class="form-item form-type-textfield form-item-mail">
											<label for="edit-mail">E-mail <span class="form-required"
												title="This field is required.">*</span> </label> <input
												placeholder="Your Email" id="email" name="email" size="20"
												maxlength="128" class="form-text required" type="text">
										</div>
										<a href="javascript:void(0)" id="submit"
											onclick="subcription()">Subscribe</a>
										<!-- <input id="submit" onclick="subcription()" name="submit" value="Subscribe" type="submit"> -->
										<div class="msg"></div>
									</div>
								</form>


							</div>
						</div>
					</div>

				</div>

				<div class="quickLinks">

					<div class="region region-footer-secondcolumn">
						<div id="block-system-main-menu"
							class="block block-system block-menu">

							<h2>Main menu</h2>

							<div class="content">
								<ul class="menu">
								<?php
								$bannerDt=showBanner();
								foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

									<li id="menu-218-1" class="leaf"><a
										href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
										class="sf-depth-1"><?php echo $meData['Title'];?> </a>
									</li>


									<?php } ?>

								</ul>

							</div>
						</div>
					</div>
					<div class="region region-footer">
						<div id="block-block-17" class="block block-block">


							<div class="content">
								<p
									style="font-size: 14px; font-family: 'Open Sans', sans-serif; text-align: center; font-weight: 400;">
									&#169;
									<?php echo date("Y"); ?>
									, eZnet CRM. All Rights Reserved
								</p>
							</div>
						</div>
					</div>

				</div>

				<div class="newsLetter logedout">

					<div class="region region-footer-thirdcolumn">
						<div id="block-block-15" class="block block-block">


							<div class="content">
								<p style="line-height: 175%;">
									<img src="img/eZnetLogo_0_1.png">
								</p>
								<p>
									<span
										style="font-size: 15px; font-weight: 400; font-family: 'Open Sans', sans-serif; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; 650 Technology Park</span>
								</p>
								<p>
									<span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; Lake Mary, FL 32746</span>
								</p>
								<p>
									<span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1-877-368-4446</span>
								</p>
								<p>
									<span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; <a href="mailto:info@eznetcrm.com">info@eznetcrm.com</a>
									</span>
								</p>
							</div>
						</div>
					</div>

				</div>

			</div>

		</footer>


	</div>


	<p style="display: none;" id="back-top">
		<a href="#top"><span id="button"></span><span id="link">Back to top</span>
		</a>
	</p>

