<?php
	/**************************************************/
	$ThisPageName = 'viewBonus.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewBonus.php?curP=".$_GET['curP'];
	$ModuleName = "Bonus";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_bonus'] = BONUS_REMOVED;
		$objPayroll->deleteBonus($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

			$HideAdminPart='';$IssueDate='';$EditFlag='';$ReturnFlag='';

	if($_POST) {
		CleanPost(); 
		$_POST['EmpID'] = $_POST['MainEmpID'];
		if(!empty($_POST['BonusID']) && !empty($_POST['EditApprove'])) {
			$BonusID = $_POST['BonusID'];
			$objPayroll->updateBonus($_POST);

			if($_POST["Approved"] != $_POST["OldApproved"]){
				#$objPayroll->sendBonusEmail($BonusID); 
			}

			$_SESSION['mess_bonus'] = BONUS_UPDATED;

		}else{
			$BonusID = $objPayroll->addBonus($_POST);
			#$objPayroll->sendBonusEmail($BonusID); 

			$_SESSION['mess_bonus'] = BONUS_ADDED;
		}




		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryBonus = $objPayroll->getBonus($_GET['edit'],'');
		$_GET['emp'] = $arryBonus[0]['EmpID'];

		if(empty($arryBonus[0]['BonusID'])){
			header("location:".$RedirectUrl);
			exit;
		}

		if(empty($arryBonus[0]['Approved'])){
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
				$arryBonus[0]['Department']='';
	}
	
	$NetSalary = '0';

	require_once("../includes/footer.php"); 
?>
