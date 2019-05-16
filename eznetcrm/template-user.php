<?php 
IsCrmSession();
	require_once("../classes/company.class.php");
	require_once("../classes/admin.class.php");

	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../includes/browser_detection.php");
	$objConfig=new admin();
	$objCompany=new company();
	$objUser=new user();

	if($_POST) { 

		if(empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			$LoginEmail = mysql_real_escape_string($_POST['LoginEmail']); 
			$LoginPassword = mysql_real_escape_string($_POST['LoginPassword']);

			$ArryUserEmail = $objConfig->CheckUserEmail($LoginEmail); 
			
			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
			if(empty($mess) && $CmpID>0){ // Company Login Check

				$objCompany->ActiveCompanyAutomatic($CmpID); 

				$ArryCompany = $objCompany->ValidateCompany($LoginEmail, $LoginPassword, $CmpID);	

				if($ArryCompany[0]['CmpID']>0){ // Company Login Check
					session_regenerate_id(); 
					
					//plz do not change these sessions
					$_SESSION['CrmAdminID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['CrmUserID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['CrmCmpID'] = $CmpID;  
					$_SESSION['CrmDisplayName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['CrmAdminEmail'] = $ArryCompany[0]['Email'];					
					$_SESSION['CrmAdminPassword'] = $ArryCompany[0]['Password'];								
					$ValidLogin = 1;
					
					/* session value for admin start here */
					
					$arryMain = $objCompany->GetCompanyDetailDisplay($ArryCompany[0]['DisplayName']);
					
					$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
					$RefID = mysql_real_escape_string($ArryUserEmail[0]['RefID']);
					$DbName2 = $Config['DbName']."_".$ArryUserEmail[0]['DisplayName'];
			
					$_SESSION['AdminID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['UserID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['CmpID'] = $CmpID; 
					$_SESSION['AdminType'] = "admin"; 
					$_SESSION['DisplayName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['UserName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['AdminEmail'] = $ArryCompany[0]['Email'];					
					$_SESSION['AdminPassword'] = $ArryCompany[0]['Password'];			
					$_SESSION['CmpDatabase'] = $DbName2;
					$_SESSION['CmpDepartment'] = $ArryUserEmail[0]['Department'];

					
				$Config['DbName'] = $DbName2;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();  					

				$objUser->AddUserLogin($_SESSION['UserID'],$_SESSION['AdminType']);
				
				$objConfigure=new configure();				
				$objConfigure->UpdatePrimaryLocation($arryMain[0]); // Update Primary Location of Company
					/* end here */
					
				}

			}
			
			
			
			/********************/  

			if($ValidLogin==1 && $_SESSION['CrmUserID']>0){

				if(!empty($_POST['ContinueUrl'])){
					$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
					echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
					exit;
				}else{
					echo '<script>location.href="dashboard";</script>';
					exit;
				}
			}else{
				if(empty($mess))
					$mess = INVALID_EMAIL_PASSWORD;
			}
			/********************/
			
			
			
			
			
			
			
		}
		
	}else{
		session_destroy();	
		ob_end_flush();		
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

										<h1 id="page-title" class="title">User account</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li><a href="register">Create new account</a></li>
												<li class="active"><a class="active" href="user">Log in<span
														class="element-invisible">(active tab)</span> </a></li>
												<li><a href="password">Request new password</a></li>
												<li><a href="reset">Re-Send Activation Email</a></li>
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
														action="" novalidate="novalidate" name="form1" id="form1" onsubmit="return validateLogin(this);">
														<div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed">
																	User E-mail address <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="80"
																	size="60" value="" name="LoginEmail" id="LoginEmail">
																<div class="description">You may login with your
																	assigned e-mail address.</div>
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
																<input type="submit" class="form-submit" title="Log in" value="Log in"
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
