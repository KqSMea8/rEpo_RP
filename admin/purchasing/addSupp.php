<?php 
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; $EditPage = 1; $HideNavigation = 1;
	/**************************************************/

	include_once("../includes/header.php");
	#require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();

	$objSupplier=new supplier();
	#$objUser=new user();

	$ModuleName = "Vendor";
	$RedirectURL = "viewSupplier.php?curP=".$_GET['curP'];

	
	 if ($_POST) {

			 if (empty($_POST['Email'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				 
					if($objSupplier->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_supplier'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objSupplier->AddSupplier($_POST); 


		$_POST['PrimaryContact']=1;
		$AddID = $objSupplier->addSupplierAddress($_POST,$LastInsertId,'contact');

		$_POST['PrimaryContact']=0;
		$billingID = $objSupplier->addSupplierAddress($_POST,$LastInsertId,'billing');	
		$shippingID = $objSupplier->addSupplierAddress($_POST,$LastInsertId,'shipping');	





						/****** Add To User Table******/
						/*******************************
						$_POST['UserName'] = trim($_POST['FirstName'].' '.$_POST['LastName']);
						$_POST['UserType'] = "vendor";
						$UserID = $objUser->AddUser($_POST);
						$objSupplier->query("update p_supplier set UserID=".$UserID." where SuppID=".$LastInsertId, 0);
						$_POST['UserID'] = $UserID;
						/*******************************/
						/*******************************/

						$_SESSION['mess_supplier'] = SUPP_ADDED;
						$_POST['SuppID'] = $LastInsertId;

					}
				
				
				/****** Add To User Table******/
				/*******************************
				if($_POST['UserID']>0 && $_GET['tab']=="role"){
					$objSupplier->query("update p_supplier set Role='".$_POST['Role']."' where SuppID=".$_POST['SuppID'], 0);
					$objUser->UpdateRolePermission($_POST);
				}
				/***********************************/
				
				//header("Location:".$RedirectURL);
				echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;



				
			}
		}
		
		
	$SupplierStatus = 1;

	require_once("../includes/footer.php"); 	 
?>


