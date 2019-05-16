<?php

//usr/bin/php /var/www/html/erp/admin/ArInvoicePostToGl.php 28551 37 POS

//$argv['0'] = $_GET['ord']; //OrderID
//$argv['1'] = $_GET['cmp'];  //CmpID
//$argv['2'] = $_GET['type'];  //OrderSource
//echo "here";
//print_r( $argv);
// die;
if(!empty($argv['1']) && !empty($argv['2']) && !empty($argv['3'])){

	//ob_start();
	//session_start();

	ini_set('display_errors',0);
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED); 
	$OrderID = $argv['1']; 
	$CmpID = $argv['2'];
	$OrderType = strtolower(trim($argv['3']));
	$Prefix='/var/www/html/erp/'; 
	//$Prefix ='../';
	$Config['CronJob'] = '1'; 
   	require_once($Prefix."includes/config.php"); 
    	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/region.class.php");	
	require_once($Prefix."classes/configure.class.php");	
	$PrefixTemp = $Prefix.'admin/';	
	require_once($PrefixTemp."language/english.php");
	require_once($PrefixTemp."finance/language/english.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/card.class.php");

	$objConfig=new admin();
	$objConfigure=new configure();
	$objCompany=new company(); 
	$objReport=new report();
	$objRegion=new region();
	$arryCompany = $objCompany->GetCompany($CmpID,1);
	 
	if(!empty($arryCompany[0]['DisplayName'])){
		/***************/
		$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
		$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
		$Config['AdminEmail'] = $arryCompany[0]['Email'];
		$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
		$Config['CmpDepartment'] = $arryCompany[0]['Department'];
		$Config['DateFormat'] = $arryCompany[0]['DateFormat'];
		$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']); 
		$Config['AdminID'] = $arryCompany[0]['CmpID'];
		$Config['AdminType'] = 'admin';
		$Config['MarketPlace'] = $arryCompany[0]['MarketPlace'];
		$Config['ConversionType'] = $arryCompany[0]['ConversionType'];
		$arrySelCurrency = $objRegion->getCurrency($arryCompany[0]['currency_id'],'');
		if(!empty($arrySelCurrency[0]['code']))$Config['Currency'] = $arrySelCurrency[0]['code'];

		
		/***************/
		$DbName = $Config['DbMain']."_".$arryCompany[0]['DisplayName'];
		$Config['DbName'] = $DbName;
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();	
		/***************/
		$ModuleIsActive = 0;
		if($OrderType=='pos'){				
			if(!empty($arryCompany[0]['Department'])){
				$arryCmpDepartment = explode("," , $arryCompany[0]['Department']);		}
			if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){	
			 	$ModuleIsActive = 1;
			}
			

								
		}

		if($ModuleIsActive == 1){
			 $PostedOrderID = $OrderID;
			 include_once($PrefixTemp."includes/AutoPostToGlArInvoice.php");
			 echo INVOICE_POSTED_TO_GL_AACOUNT;	
		}







	}
	 


} 
else{
echo "not created";
}
  
?>

