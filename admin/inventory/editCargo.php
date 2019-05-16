<?php 
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	#require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();

	$objSupplier=new supplier();
	#$objUser=new user();

	$ModuleName = "Vendor";
	$RedirectURL = "viewSupplier.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "editSupplier.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];


	
	/*********  Multiple Actions To Perform **********/
	/*
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objSupplier->RemoveSupplier($del_id);
					}
					$_SESSION['mess_supplier'] = SUPP_REMOVED;
					break;
			case 'active':
					$objSupplier->MultipleSupplierStatus($multiple_action_id,1);
					$_SESSION['mess_supplier'] = SUPP_STATUS_CHANGED;
					break;
			case 'inactive':
					$objSupplier->MultipleSupplierStatus($multiple_action_id,0);
					$_SESSION['mess_supplier'] = SUPP_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }*/


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_supplier'] = SUPP_REMOVED;
		$objSupplier->RemoveSupplier($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_supplier'] = SUPP_STATUS_CHANGED;
		$objSupplier->changeSupplierStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			CleanPost();
			 if($_POST['tab']=="image"){
				$_GET['tab'] = $_POST['tab'];
				$LastInsertId = $_GET['edit']; 
				$_POST['SuppID'] = $LastInsertId;
			 }


			 if (empty($_POST['Email']) && empty($_POST['SuppID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {


				if (!empty($_POST['SuppID'])) {
					$LastInsertId = $_POST['SuppID'];
					/*
					$objSupplier->UpdateSupplier($_POST);
					$_SESSION['mess_supplier'] = SUPP_UPDATED;
					*/
					/***************************/
					
					switch($_GET['tab']){
						case 'general':
							$objSupplier->UpdateGeneral($_POST);
							$_SESSION['mess_supplier'] = GENERAL_UPDATED;
							break;
						case 'contact':
							$objSupplier->UpdateContact($_POST);
							$_SESSION['mess_supplier'] = CONTACT_UPDATED;
							break;
						case 'shipping':
							$objSupplier->UpdateShippingBilling($_POST,$_GET['tab']);
							$_SESSION['mess_supplier'] = SHIPPING_UPDATED;
							break;
						case 'billing':
							$objSupplier->UpdateShippingBilling($_POST,$_GET['tab']);
							$_SESSION['mess_supplier'] = BILLING_UPDATED;
							break;
						/*case 'currency':
							$objSupplier->UpdateCurrency($_POST);
							$_SESSION['mess_supplier'] = CURRENCY_UPDATED;
							break;*/
						case 'bank':
							$objSupplier->UpdateBankDetail($_POST);	
							$_SESSION['mess_supplier'] = BANK_UPDATED;
							break;
					}
					/***************************/
				} else {	 
					if($objSupplier->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_supplier'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objSupplier->AddSupplier($_POST); 


						/****** Add To User Table******/
						/*******************************
						$_POST['UserName'] = trim($_POST['FirstName'].' '.$_POST['LastName']);
						$_POST['UserType'] = "supplier";
						$UserID = $objUser->AddUser($_POST);
						$objSupplier->query("update p_supplier set UserID=".$UserID." where SuppID=".$LastInsertId, 0);
						$_POST['UserID'] = $UserID;
						/*******************************/
						/*******************************/


						$_SESSION['mess_supplier'] = SUPP_ADDED;
						$_GET['tab']="contact";
						$RedirectURL = "editSupplier.php?edit=".$LastInsertId."&tab=contact";

					}
				}
				
				if($LastInsertId>0)$_POST['SuppID'] = $LastInsertId; 


				/****** Add To User Table******/
				/*******************************
				if($_POST['UserID']>0 && $_GET['tab']=="role"){
					$objSupplier->query("update p_supplier set Role='".$_POST['Role']."' where SuppID=".$_POST['SuppID'], 0);
					$objUser->UpdateRolePermission($_POST);
				}
				/***********************************/
				/***********************************/

				if($_FILES['Image']['name'] != ''){
					$ImageExtension = GetExtension($_FILES['Image']['name']); 
					$imageName = $LastInsertId.".".$ImageExtension;	
					$ImageDestination = "upload/supplier/".$imageName;
					if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
						$objSupplier->UpdateImage($imageName,$LastInsertId);
					}
				}

			
				/***********************************/
				/***********************************/
				if($_POST['SuppID']>0 && $_GET['tab']=="contact"){
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************************/

					$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
					$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

					if(!empty($_POST['main_state_id'])) {
						$arryState = $objRegion->getStateName($_POST['main_state_id']);
						$arryRgn['State']= stripslashes($arryState[0]["name"]);
					}else if(!empty($_POST['OtherState'])){
						 $arryRgn['State']=$_POST['OtherState'];
					}

					if(!empty($_POST['main_city_id'])) {
						$arryCity = $objRegion->getCityName($_POST['main_city_id']);
						$arryRgn['City']= stripslashes($arryCity[0]["name"]);
					}else if(!empty($_POST['OtherCity'])){
						 $arryRgn['City']=$_POST['OtherCity'];
					}


					/***********************************/
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();

					$objSupplier->UpdateCountyStateCity($arryRgn,$_POST['SuppID']);

				}
				/***********************************/
				/***********************************/





	

				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			}
		}
		

	if(!empty($_GET['edit'])) {
		$arrySupplier = $objSupplier->GetSupplier($_GET['edit'],'','');
		$SuppID   = $_GET['edit'];	
		
	}else{

		/*$arryNumEmp = $objSupplier->CountSupplier();
		if($arryNumEmp[0]['TotalSupplier']>=$MaxAllowedUser){
			$errMsg = LIMIT_USER_REACHED.$MaxAllowedUser;
			$HideForm = 1;
		}*/
	}
				
	if($arrySupplier[0]['Status'] != ''){
		$SupplierStatus = $arrySupplier[0]['Status'];
	}else{
		$SupplierStatus = 1;
	}				
		
	
	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';
	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';
	}else if($_GET['tab']=='currency'){
		$SubHeading = 'Currency';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
	}


	$arryPaymentTerm = $objCommon->GetTerm('','1');
	$arryPaymentMethod = $objCommon->GetAttribValue('PaymentMethod','');
	$arryShippingMethod = $objCommon->GetAttribValue('ShippingMethod','');

	$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Supplier','');

	require_once("../includes/footer.php"); 	 
?>


