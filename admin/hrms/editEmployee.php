<?php 
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; $EditPage = 1;  
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/territory.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
    	require_once($Prefix."classes/phone.class.php");
	require_once($Prefix."classes/meeting.class.php");
	require_once($Prefix."classes/SFTPConnection.class.php");

    	$objphone=new phone();
	$objFunction=new functions();
	$objCommon=new common();

	$objEmployee=new employee();
	$objUser=new user();
	$objTerritory=new territory();
	$objMeeting=new Meeting();

	$ModuleName = "Employee";
	$RedirectURL = "viewEmployee.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editEmployee.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
	$HideSubmit = '';
	
	
	/*********  Multiple Actions To Perform **********/
	/*
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objEmployee->RemoveEmployee($del_id);
					}
					$_SESSION['mess_employee'] = EMP_REMOVED;
					break;
			case 'active':
					$objEmployee->MultipleEmployeeStatus($multiple_action_id,1);
					$_SESSION['mess_employee'] = EMP_STATUS_CHANGED;
					break;
			case 'inactive':
					$objEmployee->MultipleEmployeeStatus($multiple_action_id,0);
					$_SESSION['mess_employee'] = EMP_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }*/
	
	/*********  End Multiple Actions **********/	
	if(!empty($_GET['del_emergency'])){
		$_SESSION['mess_employee'] = EMP_EMERGENCY_REMOVED;
		$objEmployee->RemoveEmergency($_GET['del_emergency']);
		header("Location:".$ActionUrl);
		exit;
	}
	if(!empty($_GET['del_family'])){
		$_SESSION['mess_employee'] = EMP_FAMILY_REMOVED;
		$objEmployee->RemoveFamily($_GET['del_family']);
		header("Location:".$ActionUrl);
		exit;
	}
	if(!empty($_GET['del_employment'])){
		$_SESSION['mess_employee'] = EMP_EMPLOYMENT_REMOVED;
		$objEmployee->RemoveEmployment($_GET['del_employment']);
		header("Location:".$ActionUrl);
		exit;
	}

	if(!empty($_GET['del_doc'])){
		$_SESSION['mess_employee'] = DOC_REMOVED;
		$objEmployee->RemoveEmpDoc($_GET['del_doc'],$Config['EducationDir']);
		header("Location:".$ActionUrl);
		exit;
	}

	/**********************************/
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_employee'] = EMP_REMOVED;
		$objEmployee->RemoveEmployee($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_employee'] = EMP_STATUS_CHANGED;
		$objEmployee->changeEmployeeStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			  CleanPost(); 

			 if (!empty($_POST['tab'])) {
				 if($_POST['tab']=="image"){
					$_GET['tab'] = $_POST['tab'];
					$LastInsertId = $_GET['edit']; 
					$_POST['EmpID'] = $LastInsertId;
				 }
			}

		        if (!empty($_POST['Email'])) {
				$_POST['Email'] = strtolower($_POST['Email']);
			}

			 if (empty($_POST['Email']) && empty($_POST['EmpID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				if (!empty($_POST['EmpID'])) {
					$LastInsertId = $_POST['EmpID'];
					/*
					$objEmployee->UpdateEmployee($_POST);
					$_SESSION['mess_employee'] = EMP_UPDATED;
					*/
					/***************************/
					switch($_GET['tab']){
						case 'personal':
						/*************************/
						$ValidateData = array(  
							array("name" => "EmpCode", "label" => "Employee Code" , "opt" => "1" ,"type" => "unique"),      
							array("name" => "FirstName", "label" => "First Name" , "min" => "3")
							
						);

						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
						if(!empty($ValidateErrorMsg)){
							$_SESSION['mess_emp'] = $ValidateErrorMsg;			
							header("Location:".$ActionUrl);
							exit;
						}
						/*************************/

							$objEmployee->UpdatePersonal($_POST);
							$objUser->UpdatePersonal($_POST);
							$_SESSION['mess_employee'] = PERSONAL_UPDATED;
							break;
						case 'contact':
						/*************************/
						$ValidateData = array( 
							array("name" => "PersonalEmail", "label" => "Personal Email" , "type" => "email"),
							array("name" => "Address", "label" => "Contact Address" , "min" => "5"),
							array("name" => "ZipCode", "label" => "Zip Code" ),
							array("name" => "Mobile", "label" => "Mobile Number" , "min" => "10", "max" => "20", "type" => "number")
										
						);

						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
						
						if(!empty($ValidateErrorMsg)){
							$_SESSION['mess_emp'] = $ValidateErrorMsg;
									
							header("Location:".$ActionUrl);
							exit;
						}
						/*************************/









							$objEmployee->UpdateContact($_POST);
							$_SESSION['mess_employee'] = CONTACT_UPDATED;

							/***************************/
			if($_FILES['AddressProof1']['name'] != ''){

				$FileInfoArray['FileType'] = "Scan";
				$FileInfoArray['FileDir'] = $Config['AddressProofDir'];
				$FileInfoArray['FileID'] = "Address1_".$LastInsertId;
				$FileInfoArray['OldFile'] = $_POST['OldAddressProof1'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['AddressProof1'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){				 
					$objEmployee->UpdateUploadedFile("AddressProof1", $ResponseArray['FileName'], $Config['AddressProofDir'], $LastInsertId);			
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}

				if(!empty($ErrorMsg)){
					$_SESSION['mess_employee'] .= '<br><br>'.$ErrorMsg;
				}

			}
			/***************************/
			if($_FILES['AddressProof2']['name'] != ''){
				$FileInfoArray['FileType'] = "Scan";
				$FileInfoArray['FileDir'] = $Config['AddressProofDir'];
				$FileInfoArray['FileID'] = "Address2_".$LastInsertId;
				$FileInfoArray['OldFile'] = $_POST['OldAddressProof2'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['AddressProof2'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){				 
					$objEmployee->UpdateUploadedFile("AddressProof2", $ResponseArray['FileName'], $Config['AddressProofDir'], $LastInsertId);			
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}

				if(!empty($ErrorMsg)){
					$_SESSION['mess_employee'] .= '<br><br>'.$ErrorMsg;
				}

			}

							break;
						case 'education':
						/*************************/
						$ValidateData = array( 							
							array("name" => "UnderGraduate", "label" => "Under Graduate" ,"select" => "1" ),
							array("name" => "Graduation", "label" => "Graduation" ,"select" => "1" )
										
						);
						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
						if(!empty($ValidateErrorMsg)){
							$_SESSION['mess_emp'] = $ValidateErrorMsg;
									
							header("Location:".$ActionUrl);
							exit;
						}
						/*************************/
							$objEmployee->UpdateEducation($_POST);
							$_SESSION['mess_employee'] = EDUCATION_UPDATED;
							break;
						case 'employment':
							$objEmployee->UpdateEmployment($_POST);
							$_SESSION['mess_employee'] = EMPLOYMENT_UPDATED;
							break;
						case 'family':
							$objEmployee->UpdateFamily($_POST);
							$_SESSION['mess_employee'] = FAMILY_UPDATED;
							break;
						case 'emergency':
							$objEmployee->UpdateEmergency($_POST);
							$_SESSION['mess_employee'] = EMERGENCY_UPDATED;
							break;
						case 'job':
						/*************************/
						$ValidateData = array( 							
							array("name" => "JoiningDate", "label" => "Joining Date" ,"select" => "1" ),
							array("name" => "catID", "label" => "Category" ,"select" => "1" ),
							array("name" => "Department", "label" => "Department" ,"select" => "1" ),
							array("name" => "JobTitle", "label" => "Designation" ,"select" => "1" ),
							array("name" => "JobType", "label" => "Job Type" ,"select" => "1" )
										
						);
						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
						if(!empty($ValidateErrorMsg)){
							$_SESSION['mess_emp'] = $ValidateErrorMsg;	
							header("Location:".$ActionUrl);
							exit;
						}
						/*************************/
							$objEmployee->UpdateJobDetail($_POST);
							$objEmployee->UpdateProbationEvent($_POST);
							$_SESSION['mess_employee'] = JOB_UPDATED;
							break;

						case 'sales':
							$objEmployee->UpdateSalesCommission($_POST);	
							$_SESSION['mess_user'] = SALE_COMM_UPDATED;
							break;
						case 'territory':
							$objTerritory->UpdateTerritoryAssign($_POST);	
							$_SESSION['mess_user'] = TERRITORY_ASSIGN_UPDATED;
							break;
						/*case 'bank':
							$objEmployee->UpdateBankDetail($_POST);	
							$_SESSION['mess_employee'] = BANK_UPDATED;
							break;*/
						case 'resume':
							$_SESSION['mess_employee'] = RESUME_UPDATED;
							break;
						case 'supervisor':
							$objEmployee->UpdateSupervisor($_POST);
							$_SESSION['mess_employee'] = SUPERVISOR_UPDATED;
							break;
						case 'id':
							$objEmployee->UpdateImmigration($_POST);
							$_SESSION['mess_employee'] = ID_UPDATED;

				if($_FILES['IdProof']['name'] != ''){

					$FileInfoArray['FileType'] = "Scan";
					$FileInfoArray['FileDir'] = $Config['IdDir'];
					$FileInfoArray['FileID'] = "ID_".$LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldIdProof'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['IdProof'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){
						 $objEmployee->UpdateIdFile($ResponseArray['FileName'],$LastInsertId);					
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
  							 

					if(!empty($ErrorMsg)){
						$_SESSION['mess_employee'] .= '<br><br>'.$ErrorMsg;
					}

				}

							break;
						case 'account':
						/*************************/
						$ValidateData = array(        
							array("name" => "Email", "label" => "Email" , "type" => "email"),
							array("name" => "Password", "label" => "Password", "min" => "5" , "opt" => "1")							
						);

						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
						if(!empty($_POST['Email']) && $objEmployee->isEmailExists($_POST['Email'],$_POST['EmpID'])){
							$ValidateErrorMsg .= '<br>'.EMAIL_ALREADY_REGISTERED;
						}
				
						if(!empty($_POST['PIN']) && $objEmployee->isPINExists($_POST['PIN'],$_POST['EmpID'])){
							$ValidateErrorMsg .= '<br>'.PIN_ALREADY_EXIST;
						}

						if(!empty($ValidateErrorMsg)){							
							$_SESSION['mess_emp'] = $ValidateErrorMsg;			
							header("Location:".$ActionUrl);
							exit;
						}



						/*************************/



							$objEmployee->UpdateAccount($_POST);
							$objUser->UpdateAccount($_POST);
							$_SESSION['mess_employee'] = ACCOUNT_UPDATED;
							break;
						case 'role':
							$_SESSION['mess_employee'] = ROLE_UPDATED;
							break;
						case 'exit':
							$objEmployee->UpdateEmpExit($_POST);	
							$_SESSION['mess_employee'] = EMP_EXIT_UPDATED;
							break;
						case 'vendor':
							$objEmployee->UpdateRestrictedVedor($_POST);	
							$_SESSION['mess_user'] = RES_VENDOR_UPDATED;
							break;
                                  /******************* Ravi chat ****************************/
						case 'chat': // BY Ravi
							$chatpr=array();
						$chatpr['permission'] = '';						
							if(!empty($_POST['chatpermission']) AND is_array($_POST['chatpermission'])){
							$chatpr['permission']=serialize($_POST['chatpermission']);
							}
							$objchat->SavePermission($chatpr,$_POST['EmpID']);						
							if(!empty($_POST['chatrole'])){							
								$objchat->Savechatrole($_POST['chatrole'],$_POST['EmpID']);
							}
						
							$_SESSION['mess_employee'] = 'Save Chat Permission';							
						break;

						/******************* Sanjiv Zoom Meeting ****************************/
						case 'zoom': // BY Sanjiv
							if($_POST['Webinar']){
								$return = $objMeeting->getEnabledWebinarUser($_POST['EmpID']);
								if($return)
								$_SESSION['mess_employee'] = 'Zoom Webinar is updated successfully.';
							}else{
								$zoompr=array();
								$zoompr['permission'] = '';
								if(!empty($_POST['zoompermission']) AND is_array($_POST['zoompermission'])){
									$zoompr['permission']=serialize($_POST['zoompermission']);
								}
						
								if($objMeeting->SavePermission($zoompr,$_POST['EmpID']))
								$_SESSION['mess_employee'] = 'Zoom Meeting Permission is saved.';
								}
					  break;


					  case 'signature':// BY Sachin

							$objEmployee->UpdateEmailSignature($_POST);	
							$_SESSION['mess_employee'] = 'Signature updated successfully';
							break;
					}
					/***************************/
				} else {

					/*************************/
					$ValidateData = array(  
						array("name" => "EmpCode", "label" => "Employee Code" , "opt" => "1" ,"type" => "unique"),            
						array("name" => "FirstName", "label" => "First Name" , "min" => "3"),		
						array("name" => "Email", "label" => "Email" , "type" => "email"),
						array("name" => "Password", "label" => "Password", "min" => "5"),
						array("name" => "ConfirmPassword", "label" => "Confirm Password")			
					);

					$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
					if(!empty($_POST['Password']) && $_POST['Password']!=$_POST['ConfirmPassword']){
						$ValidateErrorMsg .= '<br>'.CONFIRM_PASSWORD_NOT_MATCH;
					}

					if(!empty($ValidateErrorMsg)){
						$_SESSION['mess_emp'] = $ValidateErrorMsg;
						$ActionUrl = 'editEmployee.php';			
						header("Location:".$ActionUrl);
						exit;
					}
					/*************************/

	
					if($objEmployee->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_employee'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						 
						$LastInsertId = $objEmployee->AddEmployee($_POST); 


						/****** Add To User Table******/
						/*******************************/
						$_POST['UserName'] = trim($_POST['FirstName'].' '.$_POST['LastName']);
						$_POST['UserType'] = "employee";
						$UserID = $objUser->AddUser($_POST);
						$objEmployee->query("update h_employee set UserID=".$UserID." where EmpID=".$LastInsertId, 0);
						$_POST['UserID'] = $UserID;
						/*******************************/
						/*******************************/


						$_SESSION['mess_employee'] = EMP_ADDED;
						$_GET['tab']="role";
						$RedirectURL = "editEmployee.php?edit=".$LastInsertId;

					}
				}
				
				if($LastInsertId>0)$_POST['EmpID'] = $LastInsertId; 


				/****** Add To User Table******/
				/*******************************/
				if($_POST['UserID']>0 && $_GET['tab']=="role"){
					$objEmployee->UpdateEmpRole($_POST);
					if(empty($_POST['GroupID'])){
						$objUser->UpdateRolePermissionNew($_POST);
					}
				}
				/***********************************/

				/****** Else to Employee Table******
				if($_POST['EmpID']>0 && $_GET['tab']=="role"){
					$objEmployee->UpdateRoleModules($_POST);
				}
				/***********************************/



				/************************************/
				if($_FILES['Resume']['name'] != ''){

					$FileInfoArray['FileType'] = "Resume";
					$FileInfoArray['FileDir'] = $Config['EmpResumeDir'];
					$FileInfoArray['FileID'] = $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldResume'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Resume'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){ 
						$objEmployee->UpdateResume($ResponseArray['FileName'],$LastInsertId);	
						$ErrorMsg = RESUME_UPDATED;
				
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}							 

					$_SESSION['mess_employee'] = $ErrorMsg;

				}

				/************************************/
				if($_FILES['Image']['name'] != ''){		

					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['EmployeeDir'];
					$FileInfoArray['FileID'] = $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){
						$objEmployee->UpdateImage($ResponseArray['FileName'],$LastInsertId);						
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
					 

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_employee'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_employee'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				/************************************/
				/************************************/
				if($_FILES['Document']['name'] != ''){
					if(empty($_POST['DocType'])) $_POST['DocType']='Document'; 
					$DocumentTitle = escapeSpecial($_POST['DocumentTitle']); 

					$FileInfoArray['FileType'] = $_POST['DocType'];
					$FileInfoArray['FileDir'] = $Config['EducationDir'];
					$FileInfoArray['FileID'] = $DocumentTitle.$LastInsertId;
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Document'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){
						$objEmployee->AddEmployeeDoc($LastInsertId, $ResponseArray['FileName'], 'Education' , $_POST['DocumentTitle']);						 
						$_SESSION['mess_employee'] = DOC_UPLOADED;	
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
  				 

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_employee'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_employee'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				/************************************/
	

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
		$arryEmployee = $objEmployee->GetEmployee($_GET['edit'],'');
		$PageHeading = 'Edit Employee: '.stripslashes($arryEmployee[0]['UserName']);	
		$EmpID   = $_GET['edit'];	
		
		$arrySupervisor = $objEmployee->GetEmployeeBrief('');

		if(substr_count("5,6,7", $arryEmployee[0]['Division'])==0){
			$Config['SalesCommission']=0;
		}

		if($arryEmployee[0]['EmpID']<=0){
			header("Location:".$RedirectURL);
			exit;
		}


	}else{

		/*$arryNumEmp = $objEmployee->CountEmployee();
		if($arryNumEmp[0]['TotalEmployee']>=$MaxAllowedUser){
			$errMsg = LIMIT_USER_REACHED.$MaxAllowedUser;
			$HideForm = 1;
		}*/
	}
				
	if($arryEmployee[0]['Status'] != ''){
		$EmployeeStatus = $arryEmployee[0]['Status'];
	}else{
		$EmployeeStatus = 1;
	}				
		
	
	
	$arryUnderGraduate = $objCommon->GetAttribValue('UnderGraduate','');
	$arryGraduation = $objCommon->GetAttribValue('Graduation','');
	$arryPostGraduation = $objCommon->GetAttribValue('PostGraduation','');
	$arryDoctorate = $objCommon->GetAttribValue('Doctorate','');
	$arryProfessionalCourse = $objCommon->GetAttribValue('ProfessionalCourse','');
	
	$arryJobTitle = $objCommon->GetAttributeValue('JobTitle','attribute_value');
	$arryJobType = $objCommon->GetAttributeValue('JobType','');
	$arrySalaryFrequency = $objCommon->GetAttributeValue('SalaryFrequency','');
	$arryImmigrationType = $objCommon->GetFixedAttribute('ImmigrationType','');
	$arryBloodGroup = $objCommon->GetFixedAttribute('BloodGroup','');
	$arryExitType = $objCommon->GetFixedAttribute('ExitType','');
	$arryEmpCategory = $objCommon->GetEmpCategory();			
	$arrySkill = $objCommon->GetAttributeValue('Skill','attribute_value');
	$arryShift = $objCommon->getShift('','1');

	$arryRoleGroup = $objCommon->getAllRoleGroup();


	if($_GET['tab']=='emergency'){
		$SubHeading = 'Emergency Contacts';
	}else if($_GET['tab']=='role'){
		$SubHeading = 'Role/Permission';
	}else if($_GET['tab']=='exit'){
		$SubHeading = 'Employee Exit';
	}else if($_GET['tab']=='employment'){
		$SubHeading = 'Employment History';
	}else if($_GET['tab']=='id'){
		$SubHeading = 'ID Proof';
	}else if($_GET['tab']=='sales'){
		$SubHeading = 'Sales Commission';
	}else if($_GET['tab']=='territory'){
		$SubHeading = 'Territory';
	}else if($_GET['tab']=='account'){
		$SubHeading = 'Account / Login Details';
	}else if($_GET['tab']=='vendor'){
		$SubHeading = 'Restricted Vendor';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Details";
	}


	//print_r($arrySubDepartment);

	require_once("../includes/footer.php"); 	 
?>


