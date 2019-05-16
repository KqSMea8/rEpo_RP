<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/payroll.class.php");
	include_once("includes/FieldArray.php");
	$objEmployee=new employee();
	$objPayroll=new payroll();
	$ModuleName = 'Bank Detail';
	/*************************/
	if(!empty($_GET['emp'])) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['emp'],'');
		
		if($arryEmployee[0]['EmpID']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.EMP_NOT_EXIST.'</div>';
		}

		/****************************/
		$arryBank = $objPayroll->GetBank('',$_GET['emp'],'1');
		$BankDivHtml='';
		if(!empty($arryBank[0]['AccountNumber'])){
			$BankDivHtml = 'Bank Name : '.stripslashes($arryBank[0]['BankName'])
					.'<br>Account Name : '.stripslashes($arryBank[0]['AccountName'])
					.'<br>Account Number : '.stripslashes($arryBank[0]['AccountNumber'])
					.'<br>Routing Number : '.stripslashes($arryBank[0]['IFSCCode']);
		}	
		/****************************/
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}
	/*************************/

	$arryBank = $objPayroll->GetBank('',$_GET['emp'],'');
	$num = sizeof($arryBank);
	require_once("../includes/footer.php");
?>
