<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	$objEmployee=new employee();
	CleanGet();

	if(empty($_GET['tab'])) $_GET['tab']="personal";


	$EditUrl = "myProfile.php?tab=";
	$RedirectURL = "myProfile.php?tab=".$_GET['tab'];
	$ActionUrl = $EditUrl.$_GET["tab"];



	if(!empty($_GET['del_emergency'])){
		$_SESSION['mess_employee'] = EMP_EMERGENCY_REMOVED;
		$objEmployee->RemoveEmergency($_REQUEST['del_emergency']);
		header("Location:".$ActionUrl);
		exit;
	}
	if(!empty($_GET['del_family'])){
		$_SESSION['mess_employee'] = EMP_FAMILY_REMOVED;
		$objEmployee->RemoveFamily($_REQUEST['del_family']);
		header("Location:".$ActionUrl);
		exit;
	}
	if(!empty($_GET['del_employment'])){
		$_SESSION['mess_employee'] = EMP_EMPLOYMENT_REMOVED;
		$objEmployee->RemoveEmployment($_REQUEST['del_employment']);
		header("Location:".$ActionUrl);
		exit;
	}
	if(!empty($_GET['del_doc'])){
		$_SESSION['mess_employee'] = DOC_REMOVED;
		$objEmployee->RemoveEmpDoc($_GET['del_doc'],$Config['EducationDir']);
		header("Location:".$ActionUrl);
		exit;
	}


	 if($_POST) {

		/********************************/
		//CleanPost();  //error in updating skill
		/********************************/

		$EmpID   = $_SESSION['AdminID'];
		$_POST['EmpID'] = $EmpID;
		$LastInsertId = $EmpID;

		 if($_POST['tab']=="image"){
			$_GET['tab'] = $_POST['tab'];
		 }


		 /***************************/
		 
		 $arryemp=$objEmployee->getEmpInfoBeforeUpdate($EmpID);

		/***************************/

		/***************************/
			switch($_GET['tab']){
				case 'personal':
					$objEmployee->AddMyPersonalLog($arryemp,$_POST);
					$objEmployee->UpdateMyPersonal($_POST);
					$_SESSION['mess_profile'] = PERSONAL_UPDATED;
					break;
				case 'contact':
					$objEmployee->AddContactLog($arryemp,$_POST);
					$objEmployee->UpdateContact($_POST);
					$_SESSION['mess_profile'] = CONTACT_UPDATED;
			
					/***************************/
			if($_FILES['AddressProof1']['name'] != ''){

				$FileInfoArray['FileType'] = "Scan";
				$FileInfoArray['FileDir'] = $Config['AddressProofDir'];
				$FileInfoArray['FileID'] = "Address1_".$EmpID;
				$FileInfoArray['OldFile'] = $_POST['OldAddressProof1'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['AddressProof1'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){				 
					$objEmployee->UpdateUploadedFile("AddressProof1", $ResponseArray['FileName'], $Config['AddressProofDir'], $EmpID);			
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
				$FileInfoArray['FileID'] = "Address2_".$EmpID;
				$FileInfoArray['OldFile'] = $_POST['OldAddressProof2'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['AddressProof2'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){				 
					$objEmployee->UpdateUploadedFile("AddressProof2", $ResponseArray['FileName'], $Config['AddressProofDir'], $EmpID);			
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}

				if(!empty($ErrorMsg)){
					$_SESSION['mess_employee'] .= '<br><br>'.$ErrorMsg;
				}

			}



					break;
				case 'education':
					$objEmployee->addEducationLog($arryemp,$_POST);
					$objEmployee->UpdateEducation($_POST);
					$_SESSION['mess_profile'] = EDUCATION_UPDATED;
					break;
				case 'employment':

					$employment=$objEmployee->getemploymentBeforeUpdate($_POST['employmentID']);
				     
					if($_POST['employmentID']>0){
						$objEmployee->addEmploymentLog($employment,$_POST);
					}

					$objEmployee->UpdateEmployment($_POST);
					$_SESSION['mess_employee'] = EMPLOYMENT_UPDATED;
					break;
				case 'family':
					$family=$objEmployee->getfamilyBeforeUpdate($_POST['familyID']);
					if($_POST['familyID']>0){
						$objEmployee->addFamilyLog($family,$_POST);
					}

					$objEmployee->UpdateFamily($_POST);
					$_SESSION['mess_employee'] = FAMILY_UPDATED;
					break;
				case 'emergency':
					$emergency=$objEmployee->getEmergencyBeforeUpdate($_POST['contactID']);
					if($_POST['contactID']>0){
						$objEmployee->addEmergencyLog($emergency,$_POST);
				
					}
					$objEmployee->UpdateEmergency($_POST);
					$_SESSION['mess_employee'] = EMERGENCY_UPDATED;
					break;
				case 'job':
					$objEmployee->addJobEmpLog($arryemp,$_POST);
					$objEmployee->UpdateJobEmp($_POST);	
					$_SESSION['mess_profile'] = JOB_UPDATED;
					break;
				case 'id':
					$objEmployee->addImmigrationLog($arryemp,$_POST);
					$objEmployee->UpdateImmigration($_POST);
					$_SESSION['mess_profile'] = ID_UPDATED;

			if($_FILES['IdProof']['name'] != ''){
						 
				$FileInfoArray['FileType'] = "Scan";
				$FileInfoArray['FileDir'] = $Config['IdDir'];
				$FileInfoArray['FileID'] = "ID_".$EmpID;
				$FileInfoArray['OldFile'] = $_POST['OldIdProof'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['IdProof'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){
					 $objEmployee->UpdateIdFile($ResponseArray['FileName'],$EmpID);					
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}						 

				if(!empty($ErrorMsg)){
					$_SESSION['mess_employee'] .= '<br><br>'.$ErrorMsg;
				}						 

				if(!empty($ErrorMsg)){
					$_SESSION['mess_profile'] .= '<br><br>'.$ErrorMsg;
				}

			}

					break;		
		
			}
		/***************************/
		/*
		$objEmployee->UpdateBasicInfo($_POST);
		$_SESSION['mess_profile'] = PROFILE_UPDATED;
		*/

		/************************************/
		if($_FILES['Document']['name'] != ''){
			if(empty($_POST['DocType'])) $_POST['DocType']='Document'; 
			$DocumentTitle = escapeSpecial($_POST['DocumentTitle']); 
			 
			$FileInfoArray['FileType'] = $_POST['DocType'];
			$FileInfoArray['FileDir'] = $Config['EducationDir'];
			$FileInfoArray['FileID'] = $DocumentTitle.$EmpID;
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['Document'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){
				$objEmployee->AddEmployeeDoc($EmpID, $ResponseArray['FileName'], 'Education' , $_POST['DocumentTitle']);						 
				$_SESSION['mess_profile'] = DOC_UPLOADED;	
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			} 

 
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_profile'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_profile'] .= $ErrorPrefix.$ErrorMsg;
			}

		}
		/************************************/


		/************************************/
		if($_FILES['Resume']['name'] != ''){
 			$FileInfoArray['FileType'] = "Resume";
			$FileInfoArray['FileDir'] = $Config['EmpResumeDir'];
			$FileInfoArray['FileID'] = $EmpID;
			$FileInfoArray['OldFile'] = $_POST['OldResume'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['Resume'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){ 
				$objEmployee->UpdateResume($ResponseArray['FileName'],$EmpID);	
				$ErrorMsg = RESUME_UPDATED;
		
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}							 

			 

			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_profile'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_profile'] .= $ErrorPrefix.$ErrorMsg;
			}

		}

		/************************************/
		if($_FILES['Image']['name'] != ''){

			$FileInfoArray['FileType'] = "Image";
			$FileInfoArray['FileDir'] = $Config['EmployeeDir'];
			$FileInfoArray['FileID'] = $EmpID;
			$FileInfoArray['OldFile'] = $_POST['OldImage'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){
				$objEmployee->UpdateImage($ResponseArray['FileName'],$EmpID);						
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}			

			if(!empty($ErrorMsg)){
				$_SESSION['mess_profile'] = $ErrorMsg;
			}

		}

		/************************************/
		header("Location:".$RedirectURL);
		exit;
	 }

	





	if($_SESSION['AdminType'] != "admin") {
		$EmpID   = $_SESSION['AdminID'];	
		$arryEmployee = $objEmployee->GetEmployee($EmpID,'');

		$arrySupervisor = $objEmployee->GetEmployeeBrief($arryEmployee[0]['Supervisor']);
	}



	$arryUnderGraduate = $objCommon->GetAttribValue('UnderGraduate','');
	$arryGraduation = $objCommon->GetAttribValue('Graduation','');
	$arryPostGraduation = $objCommon->GetAttribValue('PostGraduation','');
	$arryDoctorate = $objCommon->GetAttribValue('Doctorate','');
	$arryProfessionalCourse = $objCommon->GetAttribValue('ProfessionalCourse','');


	$arryImmigrationType = $objCommon->GetFixedAttribute('ImmigrationType','');
	$arryBloodGroup = $objCommon->GetFixedAttribute('BloodGroup','');
	$arrySkill = $objCommon->GetAttributeValue('Skill','attribute_value');




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
	}else if($_GET['tab']=='account'){
		$SubHeading = 'Account / Login Details';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Details";
	}



	 

	require_once("../includes/footer.php");
?>

