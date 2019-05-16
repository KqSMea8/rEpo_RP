<?php
	/**************************************************/
	$ThisPageName = 'viewReimbursement.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/reimbursement.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objReimbursement=new reimbursement();
	$objEmployee=new employee();

	$RedirectUrl ="viewReimbursement.php?curP=".$_GET['curP'];
	$ModuleName = "Reimbursement";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_Reim'] = REIM_REMOVED;
		$objReimbursement->deleteReimbursement($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	$HideAdminPart=$IssueDate=$EditFlag=$ReturnFlag='';

	if($_POST) {
		CleanPost(); 
		//echo "<pre>";print_r($_POST);exit;
		$_POST['EmpID'] = $_POST['MainEmpID'];
		if(!empty($_POST['ReimID']) && !empty($_POST['ReturnDate'])) {
			$ReimID = $_POST['ReimID'];
			$objReimbursement->returnReimbursement($_POST);
			$_SESSION['mess_Reim'] = REIM_UPDATED;
		}else if(!empty($_POST['ReimID']) && !empty($_POST['EditApprove'])) {
			$ReimID = $_POST['ReimID'];
			$objReimbursement->updateReimbursement($_POST);

			if($_POST["Approved"] != $_POST["OldApproved"]){
				$objReimbursement->sendReimbursementEmail($ReimID); 
			}

			$_SESSION['mess_Reim'] = REIM_UPDATED;

		}else{  
			
			
			
			$ReimID = $objReimbursement->addReimbursement($_POST);
			 
		    	$objReimbursement->addReimbursementLineItem($ReimID,$_POST);
			
			$objReimbursement->sendReimbursementEmail($ReimID);
			

			$_SESSION['mess_Reim'] = REIM_ADDED;
		}


		/*****************************************/
		if($_FILES['document']['name'] != ''){

			$FileInfoArray['FileType'] = "Scan";
			$FileInfoArray['FileDir'] = $Config['ReimDir'];
			$FileInfoArray['FileID'] = $ReimID;
			$FileInfoArray['OldFile'] = $_POST['OldDocument'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['document'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objReimbursement->UpdateReim($ResponseArray['FileName'],$ReimID);
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}

 
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_Reim'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_Reim'] .= $ErrorPrefix.$ErrorMsg;
			}

		}

		/*********************************************/

		 
		if(empty($NumLine)) $NumLine = 1;
		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryReimbursement = $objReimbursement->getReimbursementData($_GET['edit'],'');
		/************* Line Item ****************/
		$arryReimbursementItem = $objReimbursement->ListReimbursementItem($_GET['edit']);
		/*****************************/
		$_GET['emp'] = $arryReimbursement[0]['EmpID'];
 
		
		if(empty($arryReimbursement[0]['ReimID'])){
			header("location:".$RedirectUrl);
			exit;
		}



		if($arryReimbursement[0]['Returned'] != '1' && $arryReimbursement[0]['Approved'] == '1'){	
			$ReturnFlag = 1; 
			$PgHead = 'Pay';
			$OnSubmit = 'onSubmit="return ValidatePay(this);"';
			
		}else if(empty($arryReimbursement[0]['Approved'])){
			$EditFlag = 1;
			$PgHead = 'Edit';
			$OnSubmit = 'onSubmit="return ValidateEdit(this);"';
		}else{
			$HideFlag = 1;
		}

	}else{
		$arryEmployee = $objEmployee->GetEmployeeBrief('');
		$ReturnType = 1;
		$OnSubmit = 'onSubmit="return ValidateForm(this);"';
		$arryReimbursement[0]['Department']='';
		
	}
	
 

	require_once("../includes/footer.php"); 
?>
