
<script language="JavaScript1.2" type="text/javascript">
function validateCompany(frm){

	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& isEmail(frm.Email)
		){  
					return true;	
					
			}else{
					return false;	
			}	

		
}
</script>

<section id="mainContent">
			<?php //echo $datah['Content'];?>
				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">Reseller account</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li class="active"><a class="active"
													href="register.php">Create
														new account<span class="element-invisible">(active tab)</span>
												</a></li>
												<li><a href="user.php">Log
														in</a></li>
												<li><a
													href="password.php">Request
														new password</a></li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">

<div class="message_success"  id="msg_div" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-register-form-errors"
														style="display: none;">
														<ul></ul>
													</div>
												</div>


												<form accept-charset="UTF-8" id="user-register-form"
													method="post" action="#" enctype="multipart/form-data"
													class="user-info-from-cookie" novalidate="novalidate" onSubmit="return validateCompany(this);">
													<div>
														<div class="form-wrapper" id="edit-account">
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">First Name<span
																	title="This field is required." class="form-required">*</span></label> 
																	 <input type="text" maxlength="60" size="60"
																	value="" name="FirstName" id="FirstName"
																	class="username form-text required">
															</div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed"
																	style="opacity: 1;">Last Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" maxlength="60" size="60"
																	value="" name="LastName" id="LastName"
																	class="username form-text">
																
															</div>
															<div class="form-item form-type-textfield form-item-mail">
																<label for="edit-mail" class="in-field-labels-processed">E-mail
																	address <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="254"
																	size="60" value="" name="Email" id="Email" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>');">
															
															</div>

														</div>

														<div id="edit-field-company-name"
															class="field-type-text field-name-field-company-name field-widget-text-textfield form-wrapper">
															<div id="field-company-name-add-more-wrapper">
																<div
																	class="form-item form-type-textfield form-item-field-company-name-und-0-value">
																	<label for="edit-field-company-name-und-0-value"
																		class="in-field-labels-processed">Company Name <span title="This field is required."
																	class="form-required">*</span></label>
																	<input type="text" maxlength="50" size="60" value=""
																		name="CompanyName" id="CompanyName"
																		class="text-full form-text">
																</div>
															</div>
														</div>

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
																		id="country_id" 
																		>
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
																value="Create new account" name="op" id="edit-submit">
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
