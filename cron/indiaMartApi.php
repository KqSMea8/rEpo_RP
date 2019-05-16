<?php

ob_start();
session_start();


$Prefix = "/var/www/html/erp/";
$Department = 5;   $ThisPage = 'indiaMartApi.php';
ini_set("display_errors","1"); error_reporting('ALL');
$Config['CronJob'] = '1'; 

require_once($Prefix."includes/config.php");
require_once($Prefix."includes/language.php");
require_once($Prefix."includes/function.php");
require_once($Prefix."classes/dbClass.php");
require_once($Prefix."classes/admin.class.php");	
require_once($Prefix."classes/company.class.php");
//require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/configure.class.php");
require_once($Prefix."classes/lead.class.php");


$objConfig=new admin();	
$objCompany=new company(); 
//$arrayConfig = $objConfig->GetSiteSettings(1);	
$objLead=new lead();


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
			//Timezone will be changed according to location in future

		if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],$Department)==1){		
			
			$apiDate= date("d-M-Y");

			/********Connecting to main database*********/
			unset($CmpDatabase);


			$CmpDatabase = $DbName."_".$values['DisplayName'];
			$Config['CmpDatabase'] = $CmpDatabase;
			$Config['DbName'] = $Config['CmpDatabase']; 
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();


			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'http://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9711095610/GLUSR_MOBILE_KEY/OTcxMTA5NTYxMCM0MjM0OTY4/Start_Time/'.$apiDate.'/End_Time/'.$apiDate.'/');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$contents = curl_exec($ch);


			$dataArry = json_decode($contents,true);
			
			$leadArry =  array();

			foreach ($dataArry as $key => $values) {

				$nameArray = explode(" ",$values['SENDERNAME']);


				$leadArry['QUERY_ID']= $values['QUERY_ID'];

				$stateId  = $objLead->GetStateID($values['ENQ_STATE']);
				$cityId  = $objLead->GetCityID($values['ENQ_CITY']);

				if(!empty($leadArry['QUERY_ID'])){
					$res=$objLead->checkQueryidExist($leadArry['QUERY_ID']);
					if($res){
						continue;
					}else{
						
						if($values['COUNTRY_ISO']== "IN"){
							$leadArry['country_id']= '106';
						}else{
							$leadArry['country_id']='';
						}

						$leadArry['company']=  $values['GLUSR_USR_COMPANYNAME'];
						$leadArry['type']=  'Individual';
						$leadArry['FirstName']=  $values['SENDERNAME'];
						$leadArry['LastName']=  '';
						$leadArry['primary_email']=  $values['SENDEREMAIL'];
						$leadArry['designation']=  $values['SUBJECT'];
						//$leadArry['LeadDate']=  $value[];
						$leadArry['description']=  $values['ENQ_MESSAGE'];
						$leadArry['Address']=  $values['ENQ_ADDRESS'];
						$leadArry['Mobile']=  $values['MOB'];
						$leadArry['LandlineNumber']=  $values['PHONE'];
						$leadArry['CountryName']=  "India";
						$leadArry['StateName']=  $values['ENQ_STATE'];
						$leadArry['CityName']=  $values['ENQ_CITY'];
						$leadArry['state_id']= $stateId[0]['state_id'];
						$leadArry['city_id']=  $cityId[0]['city_id'];
						$leadArry['lead_source']= 'Indiamart';

						$objLead->AddLeadIndia($leadArry);


					}
				}else{

					continue;
				}	

			}

			// For Second API 

			$dataArry='';
			$contents="";
			$ch ='';

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'http://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9810347979/GLUSR_MOBILE_KEY/OTgxMDM0Nzk3OSMzNTU0NDAwNQ==/Start_Time/'.$apiDate.'/End_Time/'.$apiDate.'/');

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$contents = curl_exec($ch);


			$dataArry = json_decode($contents,true);
			
			$leadArry =  array();
		
			foreach ($dataArry as $key => $values) {

				$nameArray = explode(" ",$values['SENDERNAME']);

				$leadArry['QUERY_ID']= $values['QUERY_ID'];

				$stateId  = $objLead->GetStateID($values['ENQ_STATE']);
				$cityId  = $objLead->GetCityID($values['ENQ_CITY']);

				if(!empty($leadArry['QUERY_ID'])){
					$res=$objLead->checkQueryidExist($leadArry['QUERY_ID']);
					if($res){
						continue;
					}else{
						
						if($values['COUNTRY_ISO']== "IN"){
							$leadArry['country_id']= '106';
						}else{
							$leadArry['country_id']='';
						}

						$leadArry['company']=  $values['GLUSR_USR_COMPANYNAME'];
						$leadArry['type']=  'Individual';
						$leadArry['FirstName']=  $values['SENDERNAME'];
						$leadArry['LastName']=  '';
						$leadArry['primary_email']=  $values['SENDEREMAIL'];
						$leadArry['designation']=  $values['SUBJECT'];
						//$leadArry['LeadDate']=  $value[];
						$leadArry['description']=  $values['ENQ_MESSAGE'];
						$leadArry['Address']=  $values['ENQ_ADDRESS'];
						$leadArry['Mobile']=  $values['MOB'];
						$leadArry['LandlineNumber']=  $values['PHONE'];
						$leadArry['CountryName']=  "India";
						$leadArry['StateName']=  $values['ENQ_STATE'];
						$leadArry['CityName']=  $values['ENQ_CITY'];
						$leadArry['state_id']= $stateId[0]['state_id'];
						$leadArry['city_id']=  $cityId[0]['city_id'];
						$leadArry['lead_source']= 'Indiamart';
						$objLead->AddLeadIndia($leadArry);


					}
				}else{

					continue;
				}	

			}


			//return true;

			require($Prefix."cron/includes/".$ThisPage);			
			/*********** End Main Code****************/

		}



	}
}







?>

