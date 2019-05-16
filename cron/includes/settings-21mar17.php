<?  	ob_start();
	session_start();
	
	//$Prefix = "../"; 
	$Prefix = "/var/www/html/erp/";
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
	require_once($Prefix."classes/MyMailer.php");	
	require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/quote.class.php");
        require_once($Prefix."classes/finance.journal.class.php");
        require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/purchase.class.php");
        require_once($Prefix."classes/event.class.php");
        require_once($Prefix."classes/territory.class.php");
        require_once($Prefix."classes/column_encode.class.php");
        require_once($Prefix."classes/item.class.php");
        require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/posuser.class.php");
	require_once($Prefix."classes/meeting.class.php");

	////////////////////////////////
	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$db = new dbFunction();
	$objPosUser = new posuser();
	$objMeeting=new Meeting();
	$arrayConfig = $objConfig->GetSiteSettings(1);		

		
	$DbName = $Config['DbName'];
	$arryCompany = $objCompany->GetCompany('',1);
	$Config['vAllRecord']=1;

	if(sizeof($arryCompany)>0){
		
		/*---------------added by sanjiv ------------------------*/
		if($ZoomMeeting){ 
			$resentMeetings = $objMeeting->listDashboardMeetings(); 
			if(empty($resentMeetings->meetings)) exit('No Recent meeting is found!'); 
		}
		/*---------------added by sanjiv ------------------------*/

		foreach($arryCompany as $key=>$values){

		
			$Config['SiteName']  = stripslashes($values['CompanyName']);	
			$Config['SiteTitle'] = stripslashes($values['CompanyName']);
			$Config['AdminEmail'] = $values['Email'];			
			$Config['MailFooter'] = '['.stripslashes($values['CompanyName']).']';

			$Config['CmpDepartment'] = $values['Department'];

			unset($arryCmpDepartment);
			if(!empty($Config['CmpDepartment'])){
				$arryCmpDepartment = explode("," , $Config['CmpDepartment']);			
			}		
			$Config['DateFormat'] = $values['DateFormat'];
			$Config['TodayDate'] = getLocalTime($values['Timezone']); 
			$Config['AdminID'] = $values['CmpID'];
			$Config['AdminType'] = 'admin';
			$Config['MarketPlace'] = $values['MarketPlace'];
			$Config['ConversionType'] = $values['ConversionType'];

			//Timezone will be changed according to location in future

			/*---------------added by sanjiv ------------------------*/
			$objConfig->dbName = $Config['DbMain'];
			$objConfig->connect();

			$arrySelCurrency = $objRegion->getCurrency($values['currency_id'],'');
			if(!empty($arrySelCurrency[0]['code']))$Config['Currency'] = $arrySelCurrency[0]['code'];
			/*---------------added by sanjiv ------------------------*/

			//if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],$Department)==1){		
			if(empty($Config['CmpDepartment']) || in_array($Department,$arryCmpDepartment)){

                                                 
			/********Connecting to main database*********/
			unset($CmpDatabase);
			//$values['DisplayName'] = 'sakshay'; //for testing

			$CmpDatabase = $DbName."_".$values['DisplayName'];
			$Config['DbName'] = $CmpDatabase;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
                        /*********** Start Main Code****************/
                        /*
                        $objConfigure=new configure();			
                        $NumEmployee = $objConfigure->NumEmployee();
                        echo $values['DisplayName'].' : '.$NumEmployee.'<br>';
                        */
                     
                       // echo $Prefix."cron/includes/".$ThisPage;exit;
			require($Prefix."cron/includes/".$ThisPage);			
			/*********** End Main Code****************/
				

			}


			
		}
	}


	/*******************************************
	$FromName = 'ERP Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'parwez005@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron 75.112.188.112 : '.$ThisPage;
	$contents = 'Cron Content';
	$pp = mail($To, $Subject, $contents, $headers);
	mail("pankaj.mca13@gmail.com", $Subject, $contents, $headers);	
	exit;
	/*******************************************/




	
?>
