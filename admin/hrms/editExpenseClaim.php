<?php
	/**************************************************/
	$ThisPageName = 'viewExpenseClaim.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewExpenseClaim.php?curP=".$_GET['curP'];
	$ModuleName = "Expense Claim";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_claim'] = CLAIM_REMOVED;
		$objPayroll->deleteExpenseClaim($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	



	if($_POST) {
		CleanPost(); 
		$_POST['EmpID'] = $_POST['MainEmpID'];
		if(!empty($_POST['ClaimID']) && !empty($_POST['ReturnDate'])) {
			$ClaimID = $_POST['ClaimID'];
			$objPayroll->returnExpenseClaim($_POST);
			$_SESSION['mess_claim'] = CLAIM_UPDATED;
		}else if(!empty($_POST['ClaimID']) && !empty($_POST['EditApprove'])) {
			$ClaimID = $_POST['ClaimID'];
			$objPayroll->updateExpenseClaim($_POST);

			if($_POST["Approved"] != $_POST["OldApproved"]){
				$objPayroll->sendExpenseClaimEmail($ClaimID); 
			}

			$_SESSION['mess_claim'] = CLAIM_UPDATED;

		}else{
			$ClaimID = $objPayroll->addExpenseClaim($_POST);
			$objPayroll->sendExpenseClaimEmail($ClaimID); 

			$_SESSION['mess_claim'] = CLAIM_ADDED;
		}


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
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryExpenseClaim = $objPayroll->getExpenseClaim($_GET['edit'],'');
		$_GET['emp'] = $arryExpenseClaim[0]['EmpID'];
		$ReturnType =  $arryExpenseClaim[0]['ReturnType'];
		
		if(empty($arryExpenseClaim[0]['ClaimID'])){
			header("location:".$RedirectUrl);
			exit;
		}



		if($arryExpenseClaim[0]['Returned'] != '1' && $arryExpenseClaim[0]['Approved'] == '1'){	
			$ReturnFlag = 1; 
			$PgHead = 'Pay';
			$OnSubmit = 'onSubmit="return ValidatePay(this);"';
			
		}else if(empty($arryExpenseClaim[0]['Approved'])){
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
	}
	
	$NetSalary = '0';

	require_once("../includes/footer.php"); 
?>
