<?php 
IsCrmSession();
	require_once("../classes/company.class.php");
        require_once("../classes/cmp.class.php");

	$objCompany=new company();
        $objCmp=new cmp();
        
	if($_POST) { 

		if (empty($_POST['Email'])) {
			$_SESSION['mess_reset'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objConfig->CheckUserEmail($Email); 

			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
	                

			if(empty($mess) && $CmpID>0){  // Admin 
                            
                              $status=$objCmp->IsActive($CmpID);
                              if($status[0]['status']==0)
                              {
                                 $objCmp->SendActivationMail($CmpID);
                                 $_SESSION['mess_reset']='Email sent, Please check your email';
                                  
                              }else {
                                  
                                  $_SESSION['mess_reset']='You are already activated';
                              }
                              

					
			}else{
				$_SESSION['mess_reset'] = INVALID_EMAIL; 
			}

		}

		
	}




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
function validateForm(frm)
{	
	if( ValidateLoginEmail(frm.Email, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	){
		document.getElementById("msg_div").innerHTML = 'Processing...';
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

										<h1 id="page-title" class="title">User account</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li><a href="register">Create new account</a></li>
												<li><a href="user">Log in</a></li>
												<li ><a href="password">Request
														new password<span class="element-invisible">(active tab)</span>
												</a></li>
                                                 <li class="active"><a class="active" href="reset">Re-Send Activation Email<span class="element-invisible">(active tab)</span>
												</a></li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">

<div class="message_success"  id="msg_div" ><? if(!empty($_SESSION['mess_reset'])) {echo $_SESSION['mess_reset']; unset($_SESSION['mess_reset']); }?></div>
												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-pass-errors"
														style="display: none;">
														<ul></ul>
													</div>
													<form accept-charset="UTF-8" id="user-pass" method="post"
														action="#" novalidate="novalidate" onSubmit="return validateForm(this);">
														<div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Email address <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="" name="Email"
																	id="Email">
															</div>
															
															<div id="edit-actions" class="form-actions form-wrapper">
																<input type="submit" class="form-submit"
																	value="submit" name="submit" id="submit">
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

