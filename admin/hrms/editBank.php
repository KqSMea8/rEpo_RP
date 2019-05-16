<?
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/payroll.class.php");
	$objEmployee=new employee();
	$objPayroll=new payroll();
	$RedirectURL = "viewBank.php?emp=".$_GET['emp'];


	if(!empty($_GET['del_id'])){
            $_SESSION['mess_bank'] = BANK_REMOVED;
            $objPayroll->RemoveBank($_GET['del_id'],$_GET['emp']);
            header("location:".$RedirectURL);
            exit;
	}


	 
	if(!empty($_POST['EmpID'])){
		CleanPost(); 
		if(!empty($_POST['BankID'])) {
			$_SESSION['mess_bank'] = BANK_UPDATED;
			$BankID = $_POST['BankID'];
			$objPayroll->UpdateBankDetail($_POST);			
		}else{
			$_SESSION['mess_bank'] = BANK_ADDED;
			$BankID = $objPayroll->addBankDetail($_POST);
		}	

		$objPayroll->UnDefaultBank($BankID,$_POST['EmpID']);

		header("location:".$RedirectURL);
		exit;


	}






	if(!empty($_GET['emp'])) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['emp'],'');
		
		if($arryEmployee[0]['EmpID']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.EMP_NOT_EXIST.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_GET.'</div>';
	}
	/*************************/

	if(empty($ErrorExist)){ 
		if(!empty($_GET['edit'])) {
			$arryBank = $objPayroll->GetBank($_GET['edit'],$_GET['emp'],'');
			
			$PageAction = 'Edit';
			$ButtonAction = 'Update';
		}else{
			$arryBank = $objConfigure->GetDefaultArrayValue('h_bank');
			$PageAction = 'Add';
			$ButtonAction = 'Submit';
		}

	}

	require_once("../includes/footer.php");  

?>
