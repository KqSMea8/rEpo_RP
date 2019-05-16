<?php $NavText=1;  
	require_once("includes/header.php");

	if($_SESSION['AdminType']!="admin"){
		$arryDepartment= $objConfig->GetAllowedDepartmentUser($_SESSION['UserID']);
		$NumAllowedDepartment = sizeof($arryDepartment);
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
