<?php 
    /**************************************************/
    $ThisPageName = 'viewCompany.php'; $EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/function.class.php");

	$RedirectURL = "viewCompany.php?curP=".$_GET['curP'];

	$objCompany=new company();
	$objFunction=new functions();	
	

	if(!empty($_POST['CmpID']) && !empty($_POST['SecurityCode'])) {
		if($_POST['SecurityCode']!=$_SESSION['SecurityCode']){
			$errMsg = 'Invalid Security Code.';
		}else{
			CleanPost();
			

			$arryCompany = $objCompany->GetCompany($_POST['CmpID'],'');

			$_SESSION['mess_company'] = COMPANY_REMOVED;
			/*******Delete Bucket Object Storage*******/
			if($Config['ObjectStorage']=="1"){ 
				$ResponseArray = $objFunction->DeleteBucketObjStorage($_POST['CmpID']);			
			}		
			/*******Delete DB Backup*****************/
			$db = $arryCompany[0]['DisplayName'];          
			$file = glob($dataBaseMainpath."$db/*.*");
			$file =  array_reverse($file);
			foreach($file as $key=>$values) {				
				unlink($values);				
			} 
			rmdir($dataBaseMainpath.$db);		
			
			/***************************************/

			$objCompany->RemoveCompany($_POST['CmpID']);
			header("Location:".$RedirectURL);
			exit;	
		}		
	}
		
	if (!empty($_GET['del_id'])) {
		$arryCompany = $objCompany->GetCompany($_GET['del_id'],'');
		$CmpID   = $_GET['del_id'];


		/***************/
		if(empty($arryCompany[0]['CmpID'])){
			header("Location:".$RedirectURL);
			exit;
		}

		if($_SESSION['AdminType']=="user"){ 
			$arrayCmpCheck = $objCompany->CheckUserCmp($_SESSION['AdminID'],$_GET['del_id']);
			if(!empty($arrayCmpCheck[0]['id'])){
				header("Location:".$RedirectURL);
				exit;
			}
		}
		/***************/




				
	}


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

	$objConfigure=new configure();
	
	require_once("includes/footer.php"); 
?>
