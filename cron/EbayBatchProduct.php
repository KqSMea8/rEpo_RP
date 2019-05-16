<?php

//sleep(200); die;
//$argv[1]='CmpID=37&AdminID=37&AdminType=admin';
if(empty($argv[1])) exit;

if(!empty($argv[1])){
	$arr = explode("&",$argv[1]);
	foreach($arr as $arrIndex =>$arrValue){
		$arr1 = explode("=",$arrValue); 
			$parameters[$arr1[0]] = $arr1[1];
	}
}

ob_start();
session_start();
	
	//echo "<pre>";
	//print_r($parameters);
	//$Prefix = "/var/www/html/erp_old/erp/";
	$Department = 5; $ThisPage = 'EbayBatchProduct.php';	
	$Prefix = "/var/www/html/erp/";
	//ini_set("display_errors","1"); error_reporting(5);
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");  
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	  
    require_once($Prefix."classes/product.class.php");
    require_once($Prefix."classes/function.class.php");
	//require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/manufacturer.class.php");
	
	////////////////////////////////
	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);	
		
	$objFunction=new functions();
	//$objItem = new items();
	$objManufacturer = new Manufacturer();
	$objProduct=new product();
	
		
	$DbName = $Config['DbName'];
	$arryCompany = $objCompany->GetCompany($parameters['CmpID'],1);
	$Config['vAllRecord']=1;
	if(sizeof($arryCompany)>0){
		foreach($arryCompany as $key=>$values){
			$Config['SiteName']  = stripslashes($values['CompanyName']);	
			$Config['SiteTitle'] = stripslashes($values['CompanyName']);
			$Config['AdminEmail'] = $values['Email'];			
			$Config['MailFooter'] = '['.stripslashes($values['CompanyName']).']';

			$Config['CmpDepartment'] = $values['Department'];		
			$Config['DateFormat'] = $values['DateFormat'];
			$Config['TodayDate'] = getLocalTime($values['Timezone']); 
			$_SESSION['AdminType'] = $parameters['AdminType'] ;
			$_SESSION['AdminID'] = $parameters['AdminID'];
			//Timezone will be changed according to location in future

			if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],$Department)==1){		
			
                            
                     
			/********Connecting to main database*********/
			unset($CmpDatabase);
			//$values['DisplayName'] = 'sakshay'; //for testing

			$CmpDatabase = $DbName."_".$values['DisplayName'];
			$Config['CmpDatabase'] = $CmpDatabase;
			$Config['DbName'] = $Config['CmpDatabase']; 
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
                     
                        
			require($Prefix."cron/includes/".$ThisPage);			
			/*********** End Main Code****************/

			}


			
		}
	}


	



	
?>
