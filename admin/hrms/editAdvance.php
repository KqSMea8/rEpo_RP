<?php
	/**************************************************/
	$ThisPageName = 'viewAdvance.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewAdvance.php?curP=".$_GET['curP'];
	$ModuleName = "Advance";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_dec'] = ADVANCE_REMOVED;
		$objPayroll->deleteAdvance($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	$HideAdminPart='';$IssueDate='';$EditFlag='';

	if($_POST) {
		 CleanPost(); 
		$_POST['EmpID'] = $_POST['MainEmpID'];
		if(!empty($_POST['AdvID']) && !empty($_POST['ReturnAmount'])) {
			$AdvID = $_POST['AdvID'];
			$objPayroll->returnAdvance($_POST);
			$_SESSION['mess_dec'] = ADVANCE_UPDATED;
		}else if(!empty($_POST['AdvID']) && !empty($_POST['EditApprove'])) {
			$AdvID = $_POST['AdvID'];
			$objPayroll->updateAdvance($_POST);

			if($_POST["Approved"] != $_POST["OldApproved"]){
				$objPayroll->sendAdvanceEmail($AdvID); 
			}

			$_SESSION['mess_dec'] = ADVANCE_UPDATED;

		}else{
			$AdvID = $objPayroll->addAdvance($_POST);
			$objPayroll->sendAdvanceEmail($AdvID); 

			$_SESSION['mess_dec'] = ADVANCE_ADDED;
		}




		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryAdvance = $objPayroll->getAdvance($_GET['edit'],'');
		$_GET['emp'] = $arryAdvance[0]['EmpID'];
		$ReturnType =  $arryAdvance[0]['ReturnType'];
		


		if(empty($arryAdvance[0]['AdvID'])){
			header("location:".$RedirectUrl);
			exit;
		}

		if($arryAdvance[0]['Returned'] != '1' && $arryAdvance[0]['Approved'] == '1'){	
			$ReturnFlag = 1; 
			$PgHead = 'Return';
			$OnSubmit = 'onSubmit="return ValidateReturn(this);"';
			
		}else if(empty($arryAdvance[0]['Approved'])){
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
		$arryAdvance[0]['Department']='';
		
		
	}
	
	$NetSalary = '0';
	$AmountDue = '';
	require_once("../includes/footer.php"); 
?>
