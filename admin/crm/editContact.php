<?php 
	/**************************************************************/
	$ThisPageName = 'viewContact.php'; $EditPage = 1;
	/**************************************************************/

	include_once("../includes/header.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/field.class.php"); //By chetan//
	$objCommon=new common();
	$objField=new field();//By chetan//	


	$_GET['edit'] = (int)$_GET['edit'];

	(!isset($CustID))?($CustID=""):(""); 

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
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_contact'] = CONTACT_STATUS;
		$objCustomer->changeAddressBookStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if (!empty($_POST)) {
 
			CleanPost();
 
//For array to string conversion by niraj 10feb16
	array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
      //End array to string conversion by niraj
				if(!empty($_POST['tab']) && $_POST['tab']=="image"){
					$_GET['tab'] = $_POST['tab'];
					$AddID = $_GET['edit']; 
					$_POST['AddID'] = $AddID;
				}
 
			 
						
				if (!empty($_POST['AddID'])) {
					$AddID = $_POST['AddID'];
					$_POST['CrmContact']=1;
                                        $objCustomer->updateCustomerAddress($_POST,$AddID);
                                         //By Chetan2july//
                                       // $fieldIDs = explode(',',$_POST['fieldIds']);
                                       // $fieldNames = explode(',',$_POST['fields']);

                                       // $objField->updateModuleForm($_POST,$AddID,$fieldIDs,$fieldNames);
                                        //End//
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
                                           //By Chetan2july//
                                        //$fieldIDs = explode(',',$_POST['fieldIds']);print_r($fieldIDs);
                                       // $fieldNames = explode(',',$_POST['fields']);print_r($fieldNames);
                                       // if($AddID>0){
                                        //$objField->updateModuleForm($_POST,$AddID,$fieldIDs,$fieldNames);
                                       // }
                                        //End//
					$_SESSION['mess_contact'] = CONTACT_ADDED;
				}
				
				

				/*****ADD COUNTRY/STATE/CITY NAME****/
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
		

	if (!empty($_GET['edit'])) {
		$arryContact = $objCustomer->GetContactAddress($_GET['edit'],'');
                $PageHeading = 'Edit Contact detail for: '.stripslashes($arryContact[0]['FirstName']);
		$AddID   = $_GET['edit'];	



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

		
	$arryCustomer = $objCustomer->GetCustomerList();
		
	if(!empty($arryContact) && $arryContact[0]['Status'] != ''){
		$ContactStatus = $arryContact[0]['Status'];
	}else{
		$ContactStatus = 1;
	}				
		
	
	
	$_GET['Status']=1;$_GET['ExistingEmployee']=1;$_GET['Division']=5; 
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	

	  $arryHead=$objField->getHead('',$ModuleParentID,1); //By Chetan//		

	require_once("../includes/footer.php"); 	 
?>
