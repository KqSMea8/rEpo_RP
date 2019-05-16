<?php
	/**************************************************/
	$ThisPageName = 'myReimbursement.php'; $EditPage=1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/reimbursement.class.php");
	require_once($Prefix."classes/employee.class.php"); // For Get EmpID 
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/configure.class.php");
	
	$objReimbursement=new reimbursement();
	$objFunction=new functions();

	$RedirectUrl ="myReimbursement.php?curP=".$_GET['curP'];
	$ModuleName = "Reimbursement";	


	if($_POST) {
		
    	//echo "<pre>";print_r($_POST);exit;
		/********************************/
		CleanPost();
		/********************************/
		$_POST['EmpID'] = $_SESSION["AdminID"];
	    $ReimID = $objReimbursement->addReimbursement($_POST); 
	    $objReimbursement->sendReimbursementEmail($ReimID); 
		$_SESSION['mess_Reim'] = REIM_ADDED;
		
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

		/********************  Line Item  *************************/
		
		 $arryReimbursementItem = $objReimbursement->addReimbursementLineItem($ReimID,$_POST);
		 
	    /********************************************************/
		 
		if(empty($NumLine)) $NumLine = 1;
		header("location:".$RedirectUrl);
		exit;		
	}
	
	$HideAdminPart = 1;
	$OnSubmit = 'onSubmit="return ValidateForm(this);"';

	require_once("../includes/footer.php"); 
?>
