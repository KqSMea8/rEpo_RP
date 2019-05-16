<?php 

	ini_set("display_errors","1"); error_reporting(5);	
	require_once("includes/function.php"); 
	/**************************/
	
	/**************************/
	require_once("includes/config.php");	
	require_once("classes/dbClass.php");	
	require_once("classes/company.class.php");
	require_once("classes/admin.class.php");
	$objCompany = new company();
	$objConfig=new admin();	
	CleanGet(); 

	/* Checking for DisplayName existance */
	if($_GET['DisplayName'] != ""){		
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],'')){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Company Email existance */
	if($_GET['Email'] != ""){		
		if($objConfig->isCmpEmailExists($_GET['Email'],'')){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
?>
