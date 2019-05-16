<?php
	/**************************************************/
	$ThisPageName = 'myExpenseClaim.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="myExpenseClaim.php?curP=".$_GET['curP'];
	$ModuleName = "Expense Claim";	

	if($_POST) {
		/********************************/
		CleanPost();
		/********************************/
		$_POST['EmpID'] = $_SESSION["AdminID"];
		$ClaimID = $objPayroll->addExpenseClaim($_POST);
		$objPayroll->sendExpenseClaimEmail($ClaimID); 
		$_SESSION['mess_claim'] = CLAIM_ADDED;


		/*****************************************/
		if($_FILES['document']['name'] != ''){
			$FileArray = $objFunction->CheckUploadedFile($_FILES['document'],"Scan");
			if(empty($FileArray['ErrorMsg'])){
				$documentExtension = $FileArray['Extension']; 

				$heading = escapeSpecial($_POST['heading']);
				$documentName = "Bill_".$ClaimID.".".$documentExtension;	
                                $MainDir = "upload/document/".$_SESSION['CmpID']."/";				

				if(!empty($_POST['OldDocument']) && file_exists($_POST['OldDocument'])){
					$OldDocumentSize = filesize($_POST['OldDocument'])/1024; //KB
					unlink($_POST['OldDocument']);		
				}
		
                                if (!is_dir($MainDir)) {
                                        mkdir($MainDir);
                                        chmod($MainDir,0777);
                                }
                                $documentDestination = $MainDir.$documentName;				
				if(@move_uploaded_file($_FILES['document']['tmp_name'], $documentDestination)){
					$objPayroll->UpdateClaimBill($documentName,$ClaimID);
					$objConfigure->UpdateStorage($documentDestination,$OldDocumentSize,0);

				}
			}else{
				$ErrorMsg = $FileArray['ErrorMsg'];
			}

			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_document'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_claim'] .= $ErrorPrefix.$ErrorMsg;
			}

		}

		/*********************************************/







		header("location:".$RedirectUrl);
		exit;		
	}
	
	$HideAdminPart = 1;
	$OnSubmit = 'onSubmit="return ValidateForm(this);"';

	$arrySalary  = $objPayroll->getSalary('',$_SESSION["AdminID"]);
	if(!empty($arrySalary[0]['NetSalary'])){
		$NetSalary  = $arrySalary[0]['NetSalary'];
	}else{
		$NetSalary = '0';
	}


	require_once("../includes/footer.php"); 
?>
