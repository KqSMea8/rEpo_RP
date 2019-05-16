<?  ob_start();
	session_start();
	//error_reporting(0);

	$Config['AdminDir']  = 'userlogin';
	////////////////////////////////
	$Prefix = "../";  $MainPrefix = ""; $DeptFolder = "";
	$PageArry = explode("/",$_SERVER['PHP_SELF']);
	$revPageArray = array_reverse($PageArry);
	
	/*if(!empty($PageArry[4])){
		$Prefix = "../../"; $MainPrefix = "../"; $Config['DeptFolder'] = $PageArry[3];
		require_once("../language/english.php");
	}*/

		
	
	////////////////////////////////
	require_once($Prefix."define.php");
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/cms.class.php");	
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/pager.cls.php");
	require_once($Prefix."classes/MyMailer.php");	
	require_once("language/english.php");
	require_once(_ROOT."/classes/dbfunction.class.php");
 	require_once(_ROOT."/classes/customer.supplier.class.php"); 
	require_once("includes/common.php");
 	
	////////////////////////////////
	////////////////////////////////

	$objCustomerSupplier= new CustomerSupplier();

	$ThisPage = $revPageArray[0]; //GetAdminPage();
	$SelfPage = $ThisPage;
	if(empty($ThisPageName)) $ThisPageName = $ThisPage;
	$objConfig=new admin();	
	$objPager=new pager();
	$arrayConfig = $objConfig->GetSiteSettings(1);
 
	$objMenu=new cms();	
	$objConfigure=new configure();
	
	if($arrayConfig[0]['IpBlock']=='1'){
		if(!$objConfig->CheckDet()){
			header('location:http://www.google.com');
			exit;
		}
	}
	
	if(!empty($_SESSION['UserID'])){
		CleanGet();

		 
		// Geting data from main database
		$objCompany=new company(); 
		$objRegion=new region();
		
		if(!empty($_SESSION['locationID'])){
			$arryCurrentLocation = $objConfigure->GetLocationData($_SESSION['locationID'],'');
		}

		$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
		$arryCountry = $objRegion->getCountry('','');

		$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
		$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
		$Config['CmpDepartment'] = $arryCompany[0]['Department'];

		$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']);		 
		$_SESSION['TodayDate'] = $Config['TodayDate'];

		$Config['DateFormat'] = $arryCompany[0]['DateFormat'];  $_SESSION['DateFormat']= $Config['DateFormat'];
		$MaxAllowedUser = ($arryCompany[0]['MaxUser']>0)?($arryCompany[0]['MaxUser']):(1000);
		$Config['TrackInventory'] = $arryCompany[0]['TrackInventory'];

	/*  */
		$Config['SelectOneItem'] = $arryCompany[0]['SelectOneItem'];
		$_SESSION['SelectOneItem']= $Config['SelectOneItem'];
	
		/* create spiff display for sales order*/
		$Config['spiffDis'] = $arryCompany[0]['spiffDis'];
		$_SESSION['spiffDis']= $Config['spiffDis'];


		 $ExclusiveItem = $objCustomerSupplier->getCustVenExclusive($_SESSION['CompanyUserID'],$_SESSION['ref_id'],$_SESSION['CmpID']); 	
		 
 
		if(empty($_SESSION['UserData']['CustID']) && !empty($_SESSION['UserData']['Cid'])){
			 $_SESSION['UserData']['CustID'] = $_SESSION['UserData']['Cid'];
		}


		 
		/*********StorageLimit************/
		if($arryCompany[0]['StorageLimit']>0){ //GB

			if($arryCompany[0]['StorageLimitUnit']=="TB"){
				$StorageLimit = ($arryCompany[0]['StorageLimit']*1024*1024*1024); //KB
			}else{
				$StorageLimit = ($arryCompany[0]['StorageLimit']*1024*1024); //KB
			}

			if($arryCompany[0]['Storage']>=$StorageLimit){ //KB Check
		 		$Config['StorageLimitError'] = str_replace("[StorageLimit]",$arryCompany[0]['StorageLimit']." ".$arryCompany[0]['StorageLimitUnit'],UPLOAD_ERROR_STORAGE_LIMIT);	
			}
		}
		
		/******************************/
		if(!empty($_SESSION['CmpDatabase'])){
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		}else{
		
			echo '<div align="center"><br><br>'.ERROR_OTHER_BROWSER.'</div>';
			exit;
		}

		

	} else{
	$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
	$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
	 
	}
	
	


	/****************************/	
	if(!empty($_SESSION['loginID'])){	 
		if($objConfigure->isUserKicked($_SESSION['loginID']) && $SelfPage != 'logout.php'){			
			header("location: ".$MainPrefix."logout.php");
			exit;
		}
		$objConfigure->updateLastViewTime();
	}
	/****************************/	

	////////////////////////////////
	////////////////////////////////

	
	if(empty($_SESSION['UserID'])) {
		if (isset($_SERVER['QUERY_STRING']))
		{
			$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
			$ThisPage = str_replace("&amp;",",",$ThisPage);

		}
		
	}


	$QueryString = $ThisPage.'?export=1&'.$_SERVER['QUERY_STRING'];
	$QueryString = str_replace("&export=1","",$QueryString);

	
	/***************************************/
	/*******Check Admin Session ************/
	//if($SelfPage!='index.php' && $PopupPage!=1){
	
	
	if($LoginPage!=1){
		if(empty($_SESSION['AdminID'])) {
			unset($_SESSION);session_destroy(); 
			$RedirectLoginUrl = '../admin/index.php';
			header('location: '.$RedirectLoginUrl);
			exit;
		}
	}
	
	/***************************************/
	/***************************************/

	if(!empty($_SESSION['UserID']) ){	

		if(!empty($_GET['att'])){
			$ThisPageName = $ThisPageName.'?att='.$_GET['att'];
		}
		if(!empty($_GET['module'])){
			$ThisPageName = $ThisPageName.'?module='.$_GET['module'];
		}
	
	
		/****************************/
		$RecordsPerPage = ($arryCompany[0]['RecordsPerPage']>0)?($arryCompany[0]['RecordsPerPage']):('20');	

		$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;

		$Config['UserEmail'] = $arryCompany[0]['Email'];
		$Config['AdminEmail'] = $arryCompany[0]['Email'];
		$_SESSION['UserEmail'] = $Config['AdminEmail'];
		$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
		/****************************/		
	
		/****************************/		
		$arrayDefaultMenu = $objConfig->GetDefaultMenus();
		$Config['DefaultMenu']='';
		foreach($arrayDefaultMenu as $key=>$values){
			$Config['DefaultMenu'] .= $values['ModuleID'].',';
		}
		$Config['DefaultMenu'] = rtrim($Config['DefaultMenu'],",");
		$AllowedModules = explode(",",$Config['DefaultMenu']);
		/****************************/	
		$Config['vUserInfo'] = '1';	
		$Config['vAllRecord'] = '1';

		if($_SESSION['UserType'] == "customer"){
			$arryEmpSetting = $objConfigure->GetEmpSetting($_SESSION['UserID']); 
			if(isset($arryEmpSetting[0]['vUserInfo'])){
			$Config['vUserInfo'] = $arryEmpSetting[0]['vUserInfo'];	
			$Config['vAllRecord'] = $arryEmpSetting[0]['vAllRecord'];	
			}
		} 
		
		$_SESSION['vAllRecord'] = $Config['vAllRecord'];
		$_SESSION['vUserInfo'] = $Config['vUserInfo'];
	
	}

	/*****************************/	
	
	

?>
