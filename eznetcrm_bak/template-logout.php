<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: home"); // Redirecting To Home Page
}
?>

	<style>
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

										<h1 id="page-title" class="title">User account</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?slug=register">Create new account</a></li>
												<li class="active"><a class="active" href="<?php echo $_SERVER['PHP_SELF'];?>?slug=user">Log in<span
														class="element-invisible">(active tab)</span> </a></li>
												<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?slug=password">Request new password</a></li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-login-errors"
														style="display: none;">
														<ul></ul>
													</div>
													<form accept-charset="UTF-8" id="user-login" method="post"
														action="#" novalidate="novalidate">
														<div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed">
																	User E-mail address <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="60"
																	size="60" value="" name="email" id="email">
																<div class="description">You may login with either your
																	assigned username or your e-mail address.</div>
															</div>
															<div class="form-item form-type-password form-item-pass">
																<label for="edit-pass" class="in-field-labels-processed">Password
																	<span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="password" class="form-text required"
																	maxlength="128" size="60" name="password" id="password">
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

