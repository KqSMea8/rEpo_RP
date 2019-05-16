<?php 
IsCrmSession();
require_once("../classes/region.class.php");
require_once("../classes/company.class.php");
require_once("../classes/cmp.class.php");
require_once("../classes/admin.class.php");
$objConfig=new admin();
$objCompany=new company();
$objRegion=new region();
$objCmp=new cmp();
$arryCountry = $objRegion->getCountry('','');


if ($_POST){

	
	if($objConfig->isCmpEmailExists($_POST['Email'],'')){
		$_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
	}else if($objCompany->isDisplayNameExists($_POST['DisplayName'],'')){
		$_SESSION['mess_company'] = DISPLAY_ALREADY_REGISTERED;
	}else{
		$_POST['Status']=0;
		$_POST['Department'] = 5;
		$_POST["Timezone"]= '-04:00';
		$_POST["DateFormat"]= 'j M, Y';
		$_POST["currency_id"]= '9';
		
		// need to get from packages
		$arrayPkj=$objCmp->getPackagesByName('STANDARD');
		
		/*****************/
		$packDataUnserialize=unserialize($arrayPkj[0]['features']);
        $packageFeatureId = implode(",", $packDataUnserialize);		
		/*****************/
				
		$_POST["MaxUser"]= $arrayPkj[0]['allow_users'];
		$_POST['PaymentPlan'] = $arrayPkj[0]['name'];
		$_POST['StorageLimit'] = $arrayPkj[0]['space'];
		$_POST['StorageLimitUnit'] = 'GB';
		/**************************/
		$NumMonth = 1;
		$arryDate = explode("-",date('Y-m-d'));
		list($year, $month, $day) = $arryDate;
		$TempDate  = mktime(0, 0, 0, $month+$NumMonth , $day, $year);
		$ExpiryDate = date("Y-m-d",$TempDate);
	    $_POST["ExpiryDate"]= $ExpiryDate;
		/***********************/
	   
		$CmpID = $objCompany->AddCompany($_POST);
		$objCmp->SendActivationMail($CmpID);
		
		
		/*************************/
		$_SESSION['mess_company'] = COMPANY_REG;
		$AddDatabase = 1;
		$UpdateAdminMenu = 1;
		
		/************************/
		if($AddDatabase == 1){
			$DbName = $objCompany->AddDatabse($_POST['DisplayName']); 
			if(!empty($DbName)){
				ImportDatabase($Config['DbHost'],$DbName,$Config['DbUser'],$Config['DbPassword'],'../superadmin/sql/erp_company.sql');
			}
		}   
		
		/************************/
		if($UpdateAdminMenu == 1){	

			
			
			
			
			$Config['DbName'] = $DbName;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
						
			$objCompany->UpdateAdminModules($CmpID,$_POST['Department']);	

			//$objCompany->UpdateAdminSubModules($CmpID,$_POST['Department'],strtolower($_POST['PaymentPlan']));
			$objCmp->UpdateAdminSubModules($CmpID,5,strtolower($_POST['PaymentPlan']),$packageFeatureId);				
		}
		/************************/
		
		
		
		
	}
		
	header("Location: register");
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
<script language="JavaScript1.2" type="text/javascript">
function validateCompany(frm){



	if( ValidateMandRange(frm.DisplayName, "User Name",3,30)
		&& isUserName(frm.DisplayName)
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		//&& ValidateForSimpleBlank(frm.Password, "New Password")
		//&& ValidateMandRange(frm.Password, "Password",5,15)
		//&& ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)
		&& ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		/* && ValidateForTextareaMand(frm.Description,"Description",10,1000)
		&& ValidateOptionalUpload(frm.Image, "Logo")
		&& ValidateForSimpleBlank(frm.ContactPerson, "Contact Person")
		&& ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& isEmailOpt(frm.AlternateEmail)
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidatePhoneNumber(frm.LandlineNumber,"Landline Number",10,20)
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		&& ValidateMandNumField(frm.MaxUser, "Allowed Number Of Users")
		&& ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")*/
		){  
					
					
				

					var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID=&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

					SendMultipleExistRequest(Url,"Email", "Email Address","DisplayName", "User Name")

					return false;	
					
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

										<h1 id="page-title" class="title">User account</h1>
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li class="active"><a class="active"
													href="register">Create
														new account<span class="element-invisible">(active tab)</span>
												</a></li>
												<li><a href="user">Log
														in</a></li>
												<li><a
													href="password">Request
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
																	style="opacity: 1;">User Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" maxlength="30" size="60"
																	value="" name="DisplayName" id="DisplayName"
																	class="username form-text required" onKeyPress="return isUniqueKey(event);">
																
															</div>
															<div class="form-item form-type-textfield form-item-mail">
																<label for="edit-mail" class="in-field-labels-processed">E-mail
																	address <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="80"
																	size="60" value="" name="Email" id="Email" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>');">
															
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
																		class="in-field-labels-processed">Company Name <span
																		title="This field is required." class="form-required">*</span></label>
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

	</div>


