<?php
//$argv[1]='CmpID=644&AdminID=644&AdminType=admin&ExcelFile=36.xls&DuplicayColumn=&TotalImport=&LocationCountry=United+States&CustCode=&Company=&FirstName=4&LastName=6&Gender=&Email=13&Mobile=&Landline=&Website=&CustomerSince=&PaymentTerm=&ShippingMethod=&Taxable=&Status=&CreditLimit=&Currency=&c_taxRate=&customerHold=&VAT=&b0cfb2=&0ccf24=&73cf10=&f3cff8=&c5cf90=&2fcfc6=&39cfdf=&25cf7a=&cbcfd5=&62cfb1=&3bcf6b=&55cf16=&a9cf35=&5ecf9b=&41cf38=&8ecfc5=&d7cfb8=&b5cfe1=&f3cf71=&2ecf42=&d9cfbf=&a1cfd0=&48cf09=&30cf1f=&Address=&country_id=&ZipCode=&OtherCity=&OtherState=&Submit=Save&FileDestination=upload%2FExcel%2F644%2F36.xls&FileName=36.xls&DbColumn=48&submit=Save';

//$argv[1] = 'CmpID=331&AdminID=331&AdminType=admin&ExcelFile=34.xls&DuplicayColumn=&TotalImport=&CustCode=&CustomerType=&Company=6&FirstName=1&LastName=&Gender=&Email=3&Mobile=5&Landline=&Website=&CustomerSince=&PaymentTerm=&PaymentMethod=&ShippingMethod=&Taxable=&Status=&01cf01=&9bcf9b=&26cf26=&cbcfcb=&3ccf3c=&fbcffb=&CreditLimit=&Currency=&f6cfe1=&tel_ext=&DefaultAccount=&Address=4&country_id=7&ZipCode=2&OtherCity=9&OtherState=8&Submit=Save&FileDestination=upload%2FExcel%2F331%2F34.xls&FileName=34.xls&DbColumn=32&submit=Save';
//if(empty($argv[1])) exit;

#$argv[1] = "CmpID=37&AdminID=37&AdminType=admin&ExcelFile=14.xls&DuplicayColumn=&TotalImport=&LocationCountry=India&CustCode=&CustomerType=0&Company=6&FirstName=4&LastName=5&Gender=&Email=7&Mobile=&Landline=&Website=&CustomerSince=&PaymentTerm=&PaymentMethod=&ShippingMethod=&Taxable=&Status=&01cf01=&9bcf9b=&26cf26=&cbcfcb=&3ccf3c=&fbcffb=&CreditLimit=&Currency=&f6cfe1=&tel_ext=&DefaultAccount=&c_taxRate=&Address=&country_id=3&ZipCode=&OtherCity=1&OtherState=2&Submit=Save&FileDestination=upload%2FExcel%2F37%2F14.xls&FileName=14.xls&DbColumn=33&submit=Save";
 
//$argv[1] ='CmpID=612&AdminID=612&AdminType=admin&ExcelFile=53.xls&DuplicayColumn=&TotalImport=&LocationCountry=United+Kingdom&CustCode=0&CustomerType=&Company=1&FirstName=&LastName=&Gender=&Email=9&Mobile=&Landline=7&Website=&CustomerSince=&PaymentTerm=&ShippingMethod=&Taxable=&Status=&CreditLimit=10&Currency=&c_taxRate=&customerHold=&ebcf1c=&Address=2&country_id=8&ZipCode=6&OtherCity=5&OtherState=4&Submit=Save&FileDestination=upload%2FExcel%2F612%2F53.xls&FileName=53.xls&DbColumn=25&submit=Save';
//$argv[1]='CmpID=644&AdminID=644&AdminType=admin&ExcelFile=93.xls&DuplicayColumn=&TotalImport=&LocationCountry=United+States&CustCode=&Company=&FirstName=4&LastName=6&Gender=&Email=13&Mobile=&Landline=&Website=&CustomerSince=&PaymentTerm=&ShippingMethod=&Taxable=&Status=&CreditLimit=&Currency=&c_taxRate=&customerHold=&VAT=&b0cfb2=&0ccf24=&73cf10=&f3cff8=&c5cf90=&2fcfc6=&39cfdf=&25cf7a=&cbcfd5=&62cfb1=&3bcf6b=&55cf16=&a9cf35=&5ecf9b=&41cf38=&8ecfc5=&d7cfb8=&b5cfe1=&f3cf71=&2ecf42=&d9cfbf=35&a1cfd0=36&48cf09=37&Address=&country_id=&ZipCode=&OtherCity=&OtherState=&Submit=Save&FileDestination=upload%2FExcel%2F644%2F93.xls&FileName=93.xls&DbColumn=47&submit=Save';
ob_start();
session_start();

//echo $argv[1];exit;	

if(!empty($argv[1])){
	$arr = explode("&",urldecode($argv[1]));
	foreach($arr as $arrIndex =>$arrValue){
		$arr1 = explode("=",$arrValue); 
			$parameters[trim($arr1[0])] = trim($arr1[1]);
	}
}	
	//echo "test<pre>";print_r($parameters);exit;
	

	$Prefix = "/var/www/html/erp/";
	$Department = 8; $ThisPage = 'ImportCustomer.php';	
	//$Prefix = "/opt/lampp/htdocs/erp/";
	ini_set("display_errors","1"); error_reporting('E_ALL');
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
        
	require_once($Prefix."classes/sales.customer.class.php");
	//require_once($Prefix."classes/function.class.php");
	require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');
        require_once($Prefix."classes/field.class.php");
	////////////////////////////////	
	$objField = new field();
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);	
		
	$objCustomer=new Customer();
	//$objFunction=new functions();

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
			$_SESSION['CmpID'] = $parameters['CmpID'];
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

