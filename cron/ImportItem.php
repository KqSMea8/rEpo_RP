<?php 
//$argv[1]='CmpID=37&AdminID=37&AdminType=admin&ExcelFile=62.csv&DuplicayColumn=FirstName%2CLastName&TotalImport=&LocationCountry=India&type=&Mand1=0&company=3&Mand2=0&FirstName=0&Mand3=1&LastName=1&Mand4=1&primary_email=&Mand5=0&designation=2&Mand6=0&ProductID=&Mand7=0&product_price=&Mand8=0&Website=11&Mand9=0&Industry=&Mand10=0&AnnualRevenue=10&Mand11=0&NumEmployee=&Mand12=0&lead_source=&Mand13=0&lead_status=&Mand14=0&LeadDate=&Mand15=0&LastContactDate=&Mand16=0&Currency=&Mand17=0&assign=&Mand18=0&Address=4&Mand19=0&country_id=8&Mand20=0&ZipCode=7&Mand21=0&LandlineNumber=9&Mand22=0&Mobile=&Mand23=0&description=&Mand24=0&Rating=&Mand25=0&1ecf1e=&Mand26=0&80cf5b=&Mand27=0&52cfc9=&Mand28=0&OtherCity=5&Mand29=0&OtherState=6&Mand30=0&Submit=Submit&FileDestination=upload%2FExcel%2F37%2F62.csv&NumMandatory=2&DbColumn=30&AssignTo=&FolderID="';

//if(empty($argv[1])) exit;

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
	//print_r($parameters);echo "gotit";die;
	$Prefix = "/var/www/html/erp/";
	$Department = 5; $ThisPage = 'ImportItem.php';	
	//$Prefix = "/opt/lampp/htdocs/erp/";
	ini_set("display_errors","1"); 
	error_reporting('ALL');
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	        
        require_once($Prefix."classes/item.class.php");
	require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');


	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);			
	$objItem=new items();
		
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

