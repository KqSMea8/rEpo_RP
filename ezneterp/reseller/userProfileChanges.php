<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
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


			
			
			
			if($_GET['view']>0 && $connected==1) {
				
				//$arryLog=$objUser->GetUserLog($_GET);
				
				$arryEmployeeChange = $objEmployee->getEmployeeChanges($_GET['view'],'');
				$EmpID   = $_REQUEST['view'];
				

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
