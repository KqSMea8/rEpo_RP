<?php
//IsCrmSession();
ValidateCrmSession();
require_once("../classes/region.class.php");
require_once("../classes/cmp.class.php");
$objRegion=new region();
$objCmp=new cmp();
$arryCountry = $objRegion->getCountry('','');
$CmpID=$_SESSION['CrmAdminID'];
$arryCompany= $objCmp->getCompanyById($CmpID);
//print_r($arryCompany);
if(isset($_POST['submit'])){

	$cidMsg=$objCmp->UpdateProfile($_POST,$CmpID);
	
		$_SESSION['mess_company_success']=PROFILE_UPDATED;
		header("location: my-profile");
	    exit;
	
}
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
	<script language="JavaScript1.2" type="text/javascript">
function validateUserPr(frm){



	if(ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateForSimpleBlank(frm.Address,"Address")
		&& isZipCode(frm.ZipCode)	
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidatePhoneNumber(frm.LandlineNumber,"Landline Number",10,20)	
		){  
			
					return true;	
					
			}else{
					return false;	
			}	

		
}
</script>

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

										<h1 id="page-title" class="title">My Profile</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li class="active"><a class="active"
													href="my-profile">My Profile</a></li>
												<li><a href="index.php?slug=payment-history">Payment History<span
														class="element-invisible">(active tab)</span> </a></li>
												<li><a href="change-password">Change Password</a>
												</li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">

												<div class="message_success" id="msg_div" align="center">
												<? if(!empty($_SESSION['mess_company_success'])) {echo $_SESSION['mess_company_success']; unset($_SESSION['mess_company_success']); }?>
												</div>


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-register-form-errors"
														style="display: none;">
														<ul></ul>
													</div>
												</div>


												<form accept-charset="UTF-8" id="user-register-form"
													method="post" action="#" enctype="multipart/form-data"
													class="user-info-from-cookie" novalidate="novalidate"
													onSubmit="return validateUserPr(this);">
													<div>
														<div class="form-wrapper" id="edit-account">

															<div id="edit-field-company-name"
																class="field-type-text field-name-field-company-name field-widget-text-textfield form-wrapper">
																<div id="field-company-name-add-more-wrapper">
																	<div
																		class="form-item form-type-textfield form-item-mail">
																		<label for="edit-mail"
																			class="in-field-labels-processed">User Name: </label>

																		<input type="text" maxlength="50" size="60"
																			value="<?php echo stripslashes($arryCompany[0]['DisplayName']);?>"
																			name="DisplayName" id="DisplayName" class="read-only"
																			readonly>

																	</div>


																	<div
																		class="form-item form-type-textfield form-item-mail">
																		<label for="edit-mail"
																			class="in-field-labels-processed">Login E-mail: </label>

																		<input type="text" maxlength="50" size="60"
																			value="<?php echo stripslashes($arryCompany[0]['Email']);?>"
																			name="Email" id="Email" class="read-only" readonly>


																	</div>
																	<div
																		class="form-item form-type-textfield form-item-field-company-name-und-0-value">
																		<label for="edit-field-company-name-und-0-value"
																			class="in-field-labels-processed">Company Name <span
																			title="This field is required." class="form-required">*</span>
																		</label> <input type="text" maxlength="50" size="60"
																			value="<?php echo stripslashes($arryCompany[0]['CompanyName']);?>"
																			name="CompanyName" id="CompanyName"
																			class="text-full form-text">
																	</div>
																</div>
															</div>


															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">Description </label> <input
																	type="text" maxlength="200" size="60"
																	value="<?php echo stripslashes($arryCompany[0]['Description']);?>"
																	name="Description" id="Description"
																	class="username form-text required">

															</div>

															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">Address <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" maxlength="200" size="60"
																	value="<?php echo stripslashes($arryCompany[0]['Address']);?>"
																	name="Address" id="Address"
																	class="username form-text required">

															</div>

															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">Zip Code <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" maxlength="20" size="60"
																	value="<?php echo stripslashes($arryCompany[0]['ZipCode']);?>"
																	name="ZipCode" id="ZipCode"
																	class="username form-text required">

															</div>

															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">Mobile </label> <input type="text"
																	maxlength="20" size="60"
																	value="<?php echo stripslashes($arryCompany[0]['Mobile']);?>"
																	name="Mobile" id="Mobile"
																	class="username form-text required">

															</div>


															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">Landline <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" maxlength="20" size="60"
																	value="<?php echo stripslashes($arryCompany[0]['LandlineNumber']);?>"
																	name="LandlineNumber" id="LandlineNumber"
																	class="username form-text required">

															</div>





														</div>


														<!-- 
														<div id="edit-field-name"
															class="field-type-text field-name-field-name field-widget-text-textfield form-wrapper">
															<div id="field-name-add-more-wrapper">
																<div
																	class="form-item form-type-textfield form-item-field-name-und-0-value">
																	<label for="edit-field-name-und-0-value"
																		class="in-field-labels-processed">New Password : <span
																		title="This field is required." class="form-required">*</span>
																	</label> <input type="password" maxlength="15"
																		size="60" value="" name="Password" id="Password"
																		class="text-full form-text required">
																		<span><?/*=$MSG[150]*/?></span>
																		 
																</div>
															</div>
														</div>
														 
														
															<div id="edit-field-name"
															class="field-type-text field-name-field-name field-widget-text-textfield form-wrapper">
															<div id="field-name-add-more-wrapper">
																<div
																	class="form-item form-type-textfield form-item-field-name-und-0-value">
																	<label for="edit-field-name-und-0-value"
																		class="in-field-labels-processed">Confirm Password :  <span
																		title="This field is required." class="form-required">*</span>
																	</label> <input type="password" maxlength="15"
																		size="60" value="" name="ConfirmPassword" id="ConfirmPassword"
																		class="text-full form-text required">
																		 
																</div>
															</div>
														</div>
														
														-->



														<div id="edit-field-company-name"
															class="field-type-text field-name-field-company-name field-widget-text-textfield form-wrapper">
															<div id="field-company-name-add-more-wrapper">
																<div
																	class="form-item form-type-textfield form-item-field-company-name-und-0-value">
																	<label for="edit-field-company-name-und-0-value"
																		class="in-field-labels-processed">Country </label>
																		<?
																		if($arryCompany[0]['country_id'] != ''){
																			$CountrySelected = $arryCompany[0]['country_id'];
																		}else{
																			$CountrySelected = 1;
																		}
																		?>
																	<select name="country_id" class="text-full form-text"
																		id="country_id">
																		<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
																		<option value="<?=$arryCountry[$i]['country_id']?>"
																		<?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
																			<?=$arryCountry[$i]['name']?>
																		</option>
																		<? } ?>
																	</select>
																</div>
															</div>
														</div>


														<div id="edit-actions" class="form-actions form-wrapper">
															<input type="submit" class="form-submit"
																value="Update Profile" name="submit" id="edit-submit" title="update profile">
														</div>
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

