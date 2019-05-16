<?php
//$argv[1]='CmpID=37&AdminID=37&AdminType=admin&ExcelFile=61.xls&DuplicayColumn=company&TotalImport=&type=&Mand1=0&company=1&Mand2=1&FirstName=&Mand3=0&LastName=&Mand4=0&primary_email=&Mand5=0&designation=&Mand6=0&ProductID=&Mand7=0&product_price=&Mand8=0&Website=&Mand9=0&Industry=&Mand10=0&AnnualRevenue=&Mand11=0&NumEmployee=&Mand12=0&lead_source=&Mand13=0&lead_status=&Mand14=0&LeadDate=&Mand15=0&LastContactDate=&Mand16=0&Currency=&Mand17=0&assign=&Mand18=0&Address=&Mand19=0&country_id=&Mand20=0&ZipCode=&Mand21=0&LandlineNumber=&Mand22=0&Mobile=&Mand23=0&description=&Mand24=0&59cf59=&Mand25=0&c8cfc8=&Mand26=0&e2cfe2=&Mand27=0&0dcf0d=&Mand28=0&24cf24=&Mand29=0&18cf18=&Mand30=0&Rating=&Mand31=0&71cf0b=&Mand32=0&4bcfb0=&Mand33=0&OtherCity=&Mand34=0&OtherState=&Mand35=0&saveTemplateSubmit=Save+Template+%26+Submit&FileDestination=upload%2FExcel%2F37%2F61.xls&NumMandatory=2&DbColumn=35&AssignTo=&FolderID=2';

if(empty($argv[1])) exit;

ob_start();
session_start();
	
if(!empty($argv[1])){
	$arr = explode("&",urldecode($argv[1]));
	foreach($arr as $arrIndex =>$arrValue){
		$arr1 = explode("=",$arrValue); 
			$parameters[$arr1[0]] = $arr1[1];
	}
}	
	//echo "<pre>";
	//print_r($parameters);
	$Prefix = "/var/www/html/erp/";
	$Department = 5; $ThisPage = 'ImportLead.php';	
	//$Prefix = "/opt/lampp/htdocs/erp/";
	ini_set("display_errors","1"); error_reporting(5);
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	
        
    require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/territory.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');

	 require_once($Prefix."classes/field.class.php");
        $objField = new field();


	////////////////////////////////
	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);	
		
	$objLead=new lead();
	$objTerritory=new territory();
	$objEmployee=new employee();
	$objFunction=new functions();
		
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

