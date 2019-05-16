<? 	

		 if ($_POST) { 

			 /***********  Upgrade Seller Account  **************/
			
			 if (!empty($_POST['UpgradeSeller'])) {

					$objMember->UpdateSellerAccount($_POST);
					$objMember->UpdatePaidMembership($_POST['MemberID'],1,'');

					$_SESSION['Name']= $_POST['FirstName'].' '.$_POST['LastName']; 
					$_SESSION['CompanyName']= $_POST['CompanyName']; 
					$_SESSION['MemberType'] = 'Seller';

					$_SESSION['SUCC_TITLE']   = UPGRADE_TO_SELLER;
					$_SESSION['mess_account'] = UPGRADED_SELLER_ACCOUNT;

					echo '<script>location.href="account_succ.php";</script>';
					exit;
			 }






				
			 /***********  Member Registration **************/

			
			 if (!empty($_POST['UserName'])) { 
					if (!empty($_POST['MemberID'])) {		 /***********  Profile **************/
						$objMember->UpdateMember($_POST);
						$_SESSION['SUCC_TITLE']   = PROFILE;
						$_SESSION['mess_account'] = PROFILE_UPDATED;
						$ImageId = $_POST['MemberID'];

						if($_FILES['Image']['name'] != ''){
							$ImageExtension = GetExtension($_FILES['Image']['name']);
							$imageName = $_POST['CompanyName'].$ImageId.".".$ImageExtension;	
							$ImageDestination = "upload/company/".$imageName;
							if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
								$objMember->UpdateImage($imageName,$ImageId);
							}
						}

						if($_FILES['Banner']['name'] != ''){
							$ImageExtension = GetExtension($_FILES['Banner']['name']);
							$imageName = 'banner_'.$ImageId.".".$ImageExtension;	
							$ImageDestination = "upload/company/".$imageName;
							if(@move_uploaded_file($_FILES['Banner']['tmp_name'], $ImageDestination)){
								$objMember->UpdateBanner($imageName,$ImageId);
							}
						}



				    } else {	/***********  Registration **************/
						$_SESSION['SUCC_TITLE']   = REGISTRATION;
						
						if($objMember->isUserNameExists($_POST['UserName'],'','')){
							$_SESSION['mess_account'] = ALREADY_REGISTERED;
						}else{	


								if($_POST['MembershipID'] == 1){
									
									$_SESSION['membership_id'] = 1;
									$_SESSION['mess_account'] = SUCCESSFULLY_REGISTERED;
								}else{
									$_SESSION['membership_id'] = $_POST['MembershipID'];
									$_POST['MembershipID'] = 1;
								}	


								$ImageId = $objMember->AddMember($_POST);


								$_POST['MemberID'] = $ImageId;
								$objMember->UpdateStorePayment($_POST);
								$objMember->UpdateDeliveryFee($_POST);
								unset($_POST['MemberID']);


								if($_SESSION['membership_id'] > 1){
									$_SESSION['member_id'] = $ImageId;
									$_SESSION['SUCC_TITLE']   = PAYMENT;
									$_SESSION['mess_account'] = PLEASE_WAIT_PAYMENT;
									$_SESSION['ACCOUNT_REDIRECT'] = 'payment-gateway.php';
								}

								if($_FILES['Image']['name'] != ''){
									$ImageExtension = GetExtension($_FILES['Image']['name']);
									$imageName = $_POST['CompanyName'].$ImageId.".".$ImageExtension;	
									$ImageDestination = "upload/company/".$imageName;
									if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
										$objMember->UpdateImage($imageName,$ImageId);
									}
								}


								if($_FILES['Banner']['name'] != ''){
									$ImageExtension = GetExtension($_FILES['Banner']['name']);
									$imageName = 'banner_'.$ImageId.".".$ImageExtension;	
									$ImageDestination = "upload/company/".$imageName;
									if(@move_uploaded_file($_FILES['Banner']['tmp_name'], $ImageDestination)){
										$objMember->UpdateBanner($imageName,$ImageId);
									}
								}

								
						}
				
					}
				echo '<script>location.href="account_succ.php";</script>';
				exit;
				
			}
	
	} // end if top
	
	

?>