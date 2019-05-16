<?php
	/**************************************************/
	$ThisPageName = 'viewLoan.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewLoan.php?curP=".$_GET['curP'];
	$ModuleName = "Loan";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_loan'] = LOAN_REMOVED;
		$objPayroll->deleteLoan($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

		$AmountDue='';$HideAdminPart='';$IssueDate='';$EditFlag='';$ReturnFlag='';
	if($_POST) {
			CleanPost(); 
		$_POST['EmpID'] = $_POST['MainEmpID'];
		if(!empty($_POST['LoanID']) && !empty($_POST['ReturnAmount'])) {
			$LoanID = $_POST['LoanID'];
			$objPayroll->returnLoan($_POST);
			$_SESSION['mess_loan'] = LOAN_UPDATED;
		}else if(!empty($_POST['LoanID']) && !empty($_POST['EditApprove'])) {
			$LoanID = $_POST['LoanID'];
			$objPayroll->updateLoan($_POST);

			if($_POST["Approved"] != $_POST["OldApproved"]){
				$objPayroll->sendLoanEmail($LoanID); 
			}

			$_SESSION['mess_loan'] = LOAN_UPDATED;

		}else{
			$LoanID = $objPayroll->addLoan($_POST);
			$objPayroll->sendLoanEmail($LoanID); 

			$_SESSION['mess_loan'] = LOAN_ADDED;
		}




		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryLoan = $objPayroll->getLoan($_GET['edit'],'');
		$_GET['emp'] = $arryLoan[0]['EmpID'];
		$ReturnType =  $arryLoan[0]['ReturnType'];
		


		if(empty($arryLoan[0]['LoanID'])){
			header("location:".$RedirectUrl);
			exit;
		}

		if($arryLoan[0]['Returned'] != '1' && $arryLoan[0]['Approved'] == '1'){	
			$ReturnFlag = 1; 
			$PgHead = 'Return';
			$OnSubmit = 'onSubmit="return ValidateReturn(this);"';

			/***************/
			$ReturnFlag = 555;  $HideFlag = 1; //disable
			
		}else if(empty($arryLoan[0]['Approved'])){
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
		$arryLoan[0]['Department']='';
	}
	
	$NetSalary = '0';

	require_once("../includes/footer.php"); 
?>
