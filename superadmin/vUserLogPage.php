<?php 	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/user.class.php");
	$objCompany=new company();

	$objUser=new user();

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
			}
			/*******************************************/
			$_GET['loginID'] = $_GET['view'];
			if($_GET['loginID']>0){	

				$arryLog=$objUser->GetUserLog($_GET);


		
				$arryUserPage=$objUser->GetUserLogPage($_GET);
				$num=$objUser->numRows();
				$RecordsPerPage = 100;
				$pagerLink=$objPager->getPager($arryUserPage,$RecordsPerPage,$_GET['curP']);
				(count($arryUserPage)>0)?($arryUserPage=$objPager->getPageRecords()):("");
				
			}else{
				$ErrorMsg = INVALID_REQUEST;
			}			
		}
	}



	require_once("includes/footer.php"); 	 
?>


