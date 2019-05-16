<?  	ob_start();
	session_start();
	$Prefix = "../";
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/MyMailer.php");	

	////////////////////////////////
	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);		
	/*if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}*/
	CleanGet();		
	$DbName = $Config['DbName'];
	$arryCompany = $objCompany->GetCompany('',1);

	if(sizeof($arryCompany)>0){
		foreach($arryCompany as $key=>$values){
			$Config['SiteName']  = stripslashes($values['CompanyName']);	
			$Config['SiteTitle'] = stripslashes($values['CompanyName']);
			$Config['AdminEmail'] = $values['Email'];			
			$Config['MailFooter'] = '['.stripslashes($values['CompanyName']).']';

			$Config['CmpDepartment'] = $values['Department'];		
			$Config['DateFormat'] = $values['DateFormat'];
			$Config['TodayDate'] = getLocalTime($values['Timezone']); 
			//Timezone will be changed according to location in future

			if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],$Department)==1){								

				/********Connecting to main database*********/
				unset($CmpDatabase);
				$CmpDatabase = $DbName."_".$values['DisplayName'];
				$Config['DbName'] = $CmpDatabase;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/
				$objConfigure=new configure();			
				$NumEmployee = $objConfigure->NumEmployee();

				echo $values['DisplayName'].' : '.$NumEmployee.'<br>';
				/*******************************************/	

			
			}


			
		}
	
	}



	
?>
