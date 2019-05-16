<?php
	require_once("includes/header.php");

	if(!empty($_POST['LicenseKey'])){
		$ValidateLicense=1;  $LicenseKey = $_POST['LicenseKey'];
		include("../admin/includes/license.php");
		$_SESSION['LicenseKey'] = $_POST['LicenseKey'];
		header('location: dbSetup.php');
		exit;
	}else{
		include("../admin/includes/license.php");
		unset($_SESSION['LicenseKey']);
	}

	unset($_SESSION['DisplayDbName']);
	unset($_SESSION['DbHost']);
	unset($_SESSION['DbUser']);
	unset($_SESSION['DbPassword']);
	unset($_SESSION['mess_installed']);

	

	require_once("includes/footer.php"); 
  ?>
