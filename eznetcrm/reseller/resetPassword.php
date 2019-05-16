<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	include ('includes/function.php');
	require_once("../../classes/company.class.php");
	require_once("../../classes/employee.class.php");
    require_once("../../classes/user.class.php");
	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();	

	$ErrorMsg = INVALID_REQUEST;
	

	if($_GET['cmp']>0){
		$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');

		$CmpID   = $arryCompany[0]['CmpID'];	
		if($CmpID>0){
			/********Connecting to main database*********/
			$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];
			$Config['DbName2'] = $CmpDatabase;
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}else{
				$Config['DbName'] = $CmpDatabase;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				$connected=1;
			}
			/*******************************************/		
			if($_GET['emp']>0 && $connected==1) {

				/*****POST***/
		if ($_POST) {
			
			
		 if(empty($_POST['Password'])) {
			$_SESSION['mess_conf'] = ENTER_NEW_PASSWORD;
		} else if (empty($_POST['ConfirmPassword'])) {
		  $_SESSION['mess_conf'] = ENTER_CONFIRM_PASSWORD;
		} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
			$_SESSION['mess_conf'] = CONFIRM_PASSWORD_NOT_MATCH;
		}else{
			
		  if($objEmployee->ChangePassword($_POST['AdminID'],$_POST['Password'])){

					$objUser->ChangePassword($_POST['UserID'],$_POST['Password']);

					$_SESSION['AdminPassword'] = md5($_POST['Password']);	
									
					$_SESSION['mess_conf'] = PASSWORD_CHANGED;
				}else{
					$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED; 
				}
			
				}
			}
				


				/***********************/


				$arryEmployee = $objEmployee->GetEmployee($_GET['emp'],'');
				$EmpID   = $arryEmployee[0]['EmpID'];
				$UserID   = $arryEmployee[0]['UserID'];

				if($arryEmployee[0]['EmpID']<=0){
					$ErrorExist=1;
					$ErrorMsg = USER_NOT_EXIST;
				}else{
					$ErrorMsg = '';
				}
			}else{
				$ErrorExist=1;
				$ErrorMsg = INVALID_REQUEST;
				
			}			
			/*******************************************/	
		}
	}

	

	require_once("includes/footer.php");  
?>
