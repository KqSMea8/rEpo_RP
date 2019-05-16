<?php
	require_once("includes/header.php");

	$objAdmin = new admin();

	$ModuleName = "Administrator";

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_adminis'] = $ModuleName.$MSG[103];
		$objAdmin->deleteAdmin($_REQUEST['del_id']);
		header("location:viewAdmins.php?curP=".$_GET['curP']);
		exit;
	}


	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_adminis'] = $ModuleName.$MSG[104];
		$objAdmin->changeAdminStatus($_REQUEST['active_id']);
		header("location:viewAdmins.php?curP=".$_GET['curP']);
		exit;
	}
	
	

	if ($_POST) {
		
		if (!empty($_POST['AdminUserID'])) {
			$objAdmin->UpdateAdmin($_POST);
			$AdminUserID = $_POST['AdminUserID'];
			$_SESSION['mess_adminis'] = $ModuleName.$MSG[102];
			
		} else {		
			$AdminUserID = $objAdmin->addAdmin($_POST);
			$_SESSION['mess_adminis'] = $ModuleName.$MSG[101];
		}
		
		
		$objAdmin->UpdateAdminModules($_POST['Modules'],$AdminUserID);
	
		header("location: viewAdmins.php?curP=".$_GET['curP']);
		exit;
		
	}
	

	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryAdmin = $objAdmin->getAdmin($_GET['edit']);
		$Status   = $arryAdmin[0]['Status'];
		//extract($arryAdmin[0]);
	}

 

 require_once("includes/footer.php"); 
 
 
 ?>
