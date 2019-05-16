
<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm)
{	
	if( ValidateMandRangeMsg(frm.OldPassword, "Old Password", 5, 15)
	   && ValidateMandRangeMsg(frm.Password, "New Password", 5, 15)
	){
		if(frm.OldPassword.value==frm.Password.value){
			document.getElementById("msg_div").innerHTML = "Old Password and New Password should not be same.";
			return false;	
		}
		if(!ValidateForPasswordConfirmMsg(frm.Password,frm.ConfirmPassword)){
			return false;	
		}


		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>

<section id="mainContent"> 
			<?php //echo $datah['Content'];?>

				<div class="InfoText">

					<div class="wrap clearfix">

						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">My Dashboard</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li><a href="myprofile.php">My Profile</a>
												</li>
												<!--  <li><a href="payment-history.php">Payment History<span
														class="element-invisible">(active tab)</span> </a></li>
												-->
												<li class="active"><a class="active"
													href="change_password.php">Change Password</a>
											
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">

												<div class="message" id="msg_div">
												<? if(!empty($_SESSION['mess_conf'])) {echo $_SESSION['mess_conf']; unset($_SESSION['mess_conf']); }?>
												</div>

												<div id="msg_div" class="message">
												<?=$mess?>
												</div>

												<div class="content">
													<div class="error">
													<?php echo $error;?>

													</div>
													<form name="form1" action="" method="post"
														onSubmit="return validate(this);">
														<div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed">
																	Old Password :<span title="This field is required."
																	class="form-required">*</span> </label> <input
																	name="OldPassword" type="password"
																	class="in-field-labels-processed" id="OldPassword"
																	value="" maxlength="20" onkeypress="ClearMsg();"
																	onmousedown="ClearMsg();" autocomplete="off" />

															</div>
															<div class="form-item form-type-password form-item-pass">
																<label for="edit-pass" class="in-field-labels-processed">New
																	Password : <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	name="Password" type="password"
																	class="in-field-labels-processed" id="Password"
																	value="" maxlength="20" onkeypress="ClearMsg();"
																	onmousedown="ClearMsg();" autocomplete="off" /> <span>
																	<?=PASSWORD_LIMIT?> </span>
															</div>


															<div class="form-item form-type-password form-item-pass">
																<label for="edit-pass" class="in-field-labels-processed">Confirm
																	Password : <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	name="ConfirmPassword" type="password" class="inputbox"
																	id="ConfirmPassword" value="" maxlength="20"
																	onkeypress="ClearMsg();" onmousedown="ClearMsg();"
																	autocomplete="off" />
															</div>

															<div id="edit-actions" class="form-actions form-wrapper">
																<input type="submit" class="form-submit" value="Log in"
																	name="submit" id="submit">
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

	
