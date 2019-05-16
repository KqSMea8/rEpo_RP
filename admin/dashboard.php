<?php   $NavText=1;  
	require_once("includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();
	

	unset($arryDepartment);


	
	if($_SESSION['AdminType']!="admin"){
		unset($arryDepartment);
		if(!empty($RoleGroupUserId)){
			$arryDepartment= $objConfig->GetAllowedDepartmentGroupNew($RoleGroupUserId);
		}else{
			$arryDepartment= $objConfig->GetAllowedDepartmentUserNew($_SESSION['UserID']);
		}

		$NumAllowedDepartment = sizeof($arryDepartment);

		
		if(empty($arryCompany[0]['Department']) || in_array("1",$arryCmpDepartment)){
			$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
			$PinPunch = $arryEmployee[0]['PinPunch'];
		}



	}else{
		$arryDepartment = $objConfig->GetDeptSettingSecurity();
	}


	/****************************/
	/*
	if(empty($_SESSION["LoginUpdated"]) && $_SESSION['AdminType']!="admin"){
		$objConfigure->UpdateLoginTime();
		$_SESSION["LoginUpdated"] = 1;
	}*/

	$arryLocationMenu = $objConfigure->getLocation('',1); 
	$NumLocation = sizeof($arryLocationMenu); 

	require_once("includes/footer.php"); 
?>
