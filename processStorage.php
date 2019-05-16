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
	/* Checking for Company Email existance */
	if($_GET['Email'] != ""){		
		if($objConfig->isCmpEmailExists($_GET['Email'],'')){
			$arryCompany = $objCompany->GetCompanyByEmail($_GET['Email']);
			/*if($arryCompany[0]['StorageLimit']>0){
				echo $arryCompany[0]['StorageLimit'].'#'.$arryCompany[0]['StorageLimitUnit'];
			}else{
				echo 'Unlimited';
			}*/

		
			
			$UsedStorage = $arryCompany[0]['Storage']; //kb
			if($UsedStorage>0){			

				if($UsedStorage<1024){
					$StorageUsed = $UsedStorage.'#KB';
					$StorageUsedTemp = '1#GB';
				}else if($UsedStorage<1024*1024){
					$StorageUsed = round($UsedStorage/1024).'#MB';
					$StorageUsedTemp = '1#GB';
				}else if($UsedStorage<1024*1024*1024){
					$StorageUsed = round(($UsedStorage/(1024*1024))).'#GB';
					$StorageUsedTemp = $StorageUsed;
				}else{
					$StorageUsed = round(($UsedStorage/(1024*1024*1024))).'#TB';
					$StorageUsedTemp = $StorageUsed;
				}
			}else{
				$StorageUsed= '0#GB';
				$StorageUsedTemp= '0#GB';
			}
			
			if(isset($_GET['actual']) && $_GET['actual'] =='1'){
				echo $StorageUsed;
			}else{
				echo $StorageUsedTemp;
			}
			exit;
		
		}else{
			echo '0#GB';exit;
		}		
	}else{
		echo '0#GB';exit;
	}
?>
