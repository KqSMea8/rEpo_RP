<?php $PopupPage=1; $LoginPage=1 ; $HideNavigation = 1;
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();
	
	CleanGet();

	$Config['DbName2'] = '';
	if($_POST) { 
		CleanPost();

		if (empty($_POST['Email'])) {
			$_SESSION['mess_forgot'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objConfig->CheckUserEmail($Email); 
			if(!empty($ArryUserEmail[0]['CmpID'])){
				$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
				$RefID = mysql_real_escape_string($ArryUserEmail[0]['RefID']);
				$DbName2 = $Config['DbName']."_".$ArryUserEmail[0]['DisplayName'];
				$Config['DbName2'] = $DbName2;
			}
			if(!$objConfig->connect_check()){
				$mess = ERROR_NO_DB;
			}else if(!empty($ArryUserEmail[0]['DisplayName'])){
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				$arryMain = $objCompany->GetCompanyDisplay($ArryUserEmail[0]['DisplayName']);
			}
			
			if(!empty($arryMain[0]['CompanyName'])){
				$Config['MailFooter'] = '['.stripslashes($arryMain[0]['CompanyName']).']';
				$Config['AdminEmail'] = stripslashes($arryMain[0]['Email']) ;
				$Config['DisplayName'] = $arryMain[0]['DisplayName'] ;
			}


			if(empty($mess) && $CmpID>0 && $RefID==0){  // Admin 

				/********Connecting to main database*********/
				$UserType = "admin";				
				/*******************************************/
				if($objCompany->ForgotPassword($Email,$CmpID)){
					$_SESSION['mess_forgot'] = FORGOT_SUCC;
					$ValidLogin = 1;
				} else{
					$_SESSION['mess_forgot'] = INVALID_EMAIL; 
				}	
			}else if(empty($mess) && $CmpID>0 && $RefID>0){  // Employee 
			
				if($ValidLogin!=1){
					/********Connecting to main database*********/
					$UserType = "employee";
					$Config['DbName'] = $DbName2;
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();  
					/*******************************************/
					$Config['SiteName'] = stripslashes($arryMain[0]['CompanyName']);
					if($objEmployee->ForgotPassword($Email)){
						$_SESSION['mess_forgot'] = FORGOT_SUCC;
					} else{
						$_SESSION['mess_forgot'] = INVALID_EMAIL; 
					}
			        }	
			}

			if(empty($_SESSION['mess_forgot'])){
				$_SESSION['mess_forgot'] = INVALID_EMAIL; 
			}

		}

		/*header("location: forgot.php?c=".$_GET['c']);
		exit;*/
		
	}


	//if($_GET['t']=='e' && empty($_POST['UserType']))$_POST['UserType'] = 'employee';


	/***********************
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	if(!empty($_GET["c"])){
		$arryCompany = $objCompany->GetCompanyByDisplay($_GET["c"]);
		if(empty($arryCompany[0]["CmpID"])){
			$ErrorMsg = ERROR_INACTIVE_ADMIN;
		}else{
			$Config['DbName2'] = $Config['DbName']."_".$arryCompany[0]["DisplayName"];
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}
		}
	}else{
		$ErrorMsg = ERROR_INACTIVE_PAGE;
	}

	/***********************/

	require_once("includes/footer.php"); 
 ?>
