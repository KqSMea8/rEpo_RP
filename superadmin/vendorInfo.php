<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/supplier.class.php");
	$objCompany=new company();
	$objSupplier=new supplier();

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
			if($_GET['SuppID']>0 && $connected==1) {
				$arrySupplier = $objSupplier->GetSupplier($_GET['SuppID'],'','');
			
				if($arrySupplier[0]['SuppID']<=0){
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
