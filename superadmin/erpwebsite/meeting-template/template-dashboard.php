<?php 
ValidateCrmSession();
 ?>

	<style type="text/css">
	.tabs {
    display: block;
}
#page-title{
  color: #333;
    font-size: 32px;
    font-weight: 300;
    margin: 50px 0 0;
    padding: 0 0 30px;
    text-align: left;
}
	</style>
	<SCRIPT LANGUAGE=JAVASCRIPT>

function validateLogin(frm)
{	
	//ClearMsg();
	if( ValidateLoginEmail(frm.LoginEmail, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	   && ValidateForLogin(frm.LoginPassword, '<?=ENTER_PASSWORD?>')
	){
		document.getElementById("msg_div").innerHTML = '<span class=normalmsg><?=PLEASE_WAIT?></span>';
		
		return true;	
	}else{
		return false;	
	}
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




										<h1 id="page-title" class="title">My Dashboard</h1>
										
		<div class="message_success"  id="msg_div" align="center"><? if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?></div>								
										
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li><a href="my-profile">My Profile</a></li>
												<li><a  href="index.php?slug=payment-history">Payment History<span
														class="element-invisible">(active tab)</span> </a></li>
												<li><a href="change-password">Change Password</a></li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">
<div id="msg_div" class="message"><?=$mess?></div>

												<div class="content">
													<div class="error">
													<?php echo $error;?>
														
													</div>
													<form accept-charset="UTF-8" id="user-login" method="post"
														action="" novalidate="novalidate" name="form1" id="form1" onsubmit="return validateLogin(this);" style="display:none;">
														<div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed">
																	User E-mail address <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="80"
																	size="60" value="" name="LoginEmail" id="LoginEmail">
																<div class="description">You may login with either your
																	assigned username or your e-mail address.</div>
															</div>
															<div class="form-item form-type-password form-item-pass">
																<label for="edit-pass" class="in-field-labels-processed">Password
																	<span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="password" class="form-text required"
																	maxlength="30" size="60" name="LoginPassword" id="LoginPassword">
																<div class="description">The password field is case
																	sensitive.</div>
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

		</div>

