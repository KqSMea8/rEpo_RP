<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();


	if($Config['vUserInfo']!=1){
		$ErrorExist=1;
		echo '<div class="redmsg" align="center"><br><br>'.ERROR_NOT_AUTH_USER.'</div>';
	}


	if($_GET['view']>0) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['view'],'');
		$EmpID   = $_REQUEST['view'];	
		if($arryEmployee[0]['Supervisor']>0){
			$arrySupervisor = $objEmployee->GetEmployeeBrief($arryEmployee[0]['Supervisor']);
		}


		if($arryEmployee[0]['EmpID']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.USER_NOT_EXIST.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}

	require_once("includes/footer.php");  

?>
