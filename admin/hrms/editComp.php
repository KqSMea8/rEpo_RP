<?php
	/**************************************************/
	$ThisPageName = 'viewComp.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objLeave=new leave();
	$objEmployee=new employee();

	$RedirectUrl ="viewComp.php?curP=".$_GET['curP'];
	$ModuleName = "Compensatory-Off";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_comp'] = COMP_REMOVED;
		$objLeave->deleteComp($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	



	if($_POST) {
		CleanPost(); 
		$_POST['EmpID'] = $_POST['MainEmpID'];
		
		if(!empty($_POST['CompID']) && !empty($_POST['EditApprove'])) {
			$CompID = $_POST['CompID'];
			$objLeave->updateComp($_POST);

			if($_POST["Approved"] != $_POST["OldApproved"]){
				$objLeave->sendCompEmail($CompID); 
			}

			$_SESSION['mess_comp'] = COMP_UPDATED;

		}else{
			$CompID = $objLeave->addComp($_POST);
			$objLeave->sendCompEmail($CompID); 

			$_SESSION['mess_comp'] = COMP_ADDED;
		}




		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryComp = $objLeave->getComp($_GET['edit'],'');
		$_GET['emp'] = $arryComp[0]['EmpID'];
	

		if(empty($arryComp[0]['CompID'])){
			header("location:".$RedirectUrl);
			exit;
		}

		if(empty($arryComp[0]['Approved']) && $arryComp[0]['SupApproval'] == '1'){
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
	

	require_once("../includes/footer.php"); 
?>
