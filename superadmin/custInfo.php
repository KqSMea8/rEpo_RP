<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/sales.customer.class.php");
	$objCompany=new company();
	$objCustomer = new Customer();

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
			if($_GET['CustID']>0 && $connected==1) {
				$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],'',''); 
			
				if($arryCustomer[0]['Cid']<=0){
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
