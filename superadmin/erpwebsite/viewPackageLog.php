<?php 
    /**************************************************/
    $ThisPageName = 'upgradePackages.php'; $EditPage = 1; 
    /**************************************************/
    
	include_once("includes/header.php");
	require_once("../../classes/company.class.php");
	require_once("../../classes/user.class.php");
	require_once("../../classes/cmp.class.php");
	
    $objCmp=new cmp();

	$objCompany=new company();

	$objUser=new user();
	


	if($_GET['cmp']>0){
		$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');
		$CmpID   = $arryCompany[0]['CmpID'];
		$RedirectUrl = 'viewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'];	
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
			
				/*******************************************/			
				
				
				
					/*******************************************/		
			}			
		}
	}

	
	$viewAll = 'viewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'];
	require_once("includes/footer.php"); 	 
?>


