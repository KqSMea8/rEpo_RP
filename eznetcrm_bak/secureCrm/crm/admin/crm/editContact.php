<?php 
/**************************************************************/
$ThisPageName = 'viewContact.php'; $EditPage = 1;
/**************************************************************/

	include_once("../includes/header.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");	
	$objCommon=new common();




	//$objContact=new contact();
	$objEmployee=new employee();
	$objCustomer=new Customer();  
	$ModuleName = "Contact";
	$RedirectURL = "viewContact.php?module=".$_GET['module']."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="basic";

	$EditUrl = "editContact.php?edit=".$_GET["edit"]."&module=".$_GET['module']."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];


	
	/*********  Multiple Actions To Perform **********

	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objContact->RemoveContact($del_id);
					}
					$_SESSION['mess_contact'] = CONTACT_REMOVED;
					break;
			case 'active':
					$objContact->MultipleContactStatus($multiple_action_id,1);
					$_SESSION['mess_contact'] = CONTACT_REMOVED;
					break;
			case 'inactive':
					$objContact->MultipleContactStatus($multiple_action_id,0);
					$_SESSION['mess_contact'] = CONTACT_REMOVED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_contact'] = CONTACT_REMOVED;
		$objCustomer->RemoveCustomerContact($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_contact'] = CONTACT_STATUS;
		$objCustomer->changeAddressBookStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}
	

	
	 if ($_POST) {


            		 if($_POST['tab']=="image"){
				$_GET['tab'] = $_POST['tab'];
				$AddID = $_GET['edit']; 
				$_POST['AddID'] = $AddID;
			 }
		
			 if (empty($_POST['Email']) && empty($_POST['AddID'])) {
				$errMsg = $MSG[10];
			 } else {
				 			
				if (!empty($_POST['AddID'])) {
					$AddID = $_POST['AddID'];
					$_POST['CrmContact']=1;
					$objCustomer->updateCustomerAddress($_POST,$AddID);
					$_SESSION['mess_contact'] = CONTACT_UPDATED;
					/***************************
					switch($_GET['tab']){
						case 'basic':
							$objContact->UpdatePersonal($_POST);
							$_SESSION['mess_contact'] = CONTACT_PERSONAL_UPDATED;
							break;
						case 'contact':
							$objContact->UpdateContact($_POST);
							$_SESSION['mess_contact'] = CONTACT_CONTACT_UPDATED;
							break;
						case 'portal':
							$objContact->UpdatePortal($_POST);
							$_SESSION['mess_contact'] = CONTACT_PORTAL_UPDATED;
							break;

                        
						
					}
					/***************************/
				} else {	
					/*
					if($objContact->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_contact'] = CONTACT_EMAIL_EXIST;
					}else{	
						$AddID = $objContact->AddContact($_POST); 
						$_SESSION['mess_contact'] = CONTACT_ADDED;
					}*/
					$_POST['CrmContact']=1;
					$AddID = $objCustomer->addCustomerAddress($_POST,$CustID,'contact'); 
					$_SESSION['mess_contact'] = CONTACT_ADDED;
				}
				
				

				/*****ADD COUNTRY/STATE/CITY NAME****/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/***********************************/

				$arryCountry = $objRegion->GetCountryName($_POST['Country']);
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

				$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
				/**************END COUNTRY NAME*********************/
				
                		
				
	
				/*
				if($_FILES['Image']['name'] != ''){
					
					$ImageExtension = GetExtension($_FILES['Image']['name']); 
					$imageName = $AddID.".".$ImageExtension;	
					$ImageDestination = "upload/contact/".$imageName;
					if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
						$objContact->UpdateImage($imageName,$AddID);
					}
				}*/

	

				if (!empty($_GET['edit'])) {
					header("Location:".$RedirectURL);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			}
		}
		

	if (!empty($_GET['edit'])) {
		$arryContact = $objCustomer->GetContactAddress($_GET['edit'],'');
		$AddID   = $_REQUEST['edit'];	



		if(empty($arryContact[0]['AddID'])) {
			header('location:'.$RedirectURL);
			exit;
		}		
		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryContact[0]['AssignTo'] != $_SESSION['AdminID'] && $arryContact[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/
	
	}

		
	$arryCustomer = $objCustomer->GetCustomer('','','Yes');

		
	if($arryContact[0]['Status'] != ''){
		$ContactStatus = $arryContact[0]['Status'];
	}else{
		$ContactStatus = 1;
	}				
		
	
	
	$_GET['Status']=1;$_GET['Division']=5;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	

			

	require_once("../includes/footer.php"); 	 
?>
