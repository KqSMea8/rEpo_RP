<?  	ob_start();
	session_start();
	$Prefix = "../";
	ini_set("display_errors","1"); error_reporting(5);	
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
        
	////////////////////////////////
	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);		

		
	$DbName = $Config['DbName'];
	$arryCompany = $objCompany->GetCompany('',1);
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
			//Timezone will be changed according to location in future

			if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],$Department)==1){		
			

			/********Connecting to main database*********/
			unset($CmpDatabase);
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

			include("includes/".$ThisPage);			
			/*********** End Main Code****************/
				

			}


			
		}
	}







	/*******************************************/
	$FromName = 'ERP Cron';
	$FromEmail = 'parwez005@gmail.com';
	$To = 'parwez.khan@sakshay.in';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron Subject : '.$ThisPage;
	$contents = 'Cron Content';
	#$pp = mail($To, $Subject, $contents, $headers);
	#mail("abhishek.rana@sakshay.in", $Subject, $contents, $headers);
	/*******************************************/
?>
