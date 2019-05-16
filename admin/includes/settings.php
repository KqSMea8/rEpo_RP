<?  ob_start();
	session_start();
	error_reporting(0);

 
	date_default_timezone_set('America/New_York');


	$Config['AdminDir']  = 'admin';
	////////////////////////////////
	$Prefix = "../";  $MainPrefix = ""; $DeptFolder = "";
	$PageArry = explode("/",$_SERVER['PHP_SELF']);
	$revPageArray = array_reverse($PageArry);
	
	/*if(!empty($PageArry[4])){
		$Prefix = "../../"; $MainPrefix = "../"; $Config['DeptFolder'] = $PageArry[3];
		require_once("../language/english.php");
	}*/

		
	if($revPageArray[1]!=$Config['AdminDir']){
		$Prefix = "../../"; $MainPrefix = "../"; $Config['DeptFolder'] = $revPageArray[1];
		require_once("../language/english.php");		
	}

	if(substr_count($revPageArray[0],'.php')!=1){
		exit;
	}
	
	//By Chetan 17Feb//
        if(  (!strstr($_SERVER['REQUEST_URI'],'vcsearch')) && (!strstr($_SERVER['REQUEST_URI'],'createcustomsearch'))
               && ($_GET['pop']!=1)   &&   (!strstr($_SERVER['REQUEST_URI'],'editaliasItem')) &&  (!strstr($_SERVER['REQUEST_URI'],'custInfo')) )
        {
           unset($_SESSION['PostData']);
        }
        //End//

	 
	//////////////////////////////// 
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
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/chat.class.php");  // By Ravi For Chat
	require_once($Prefix."classes/webcms.class.php"); // By Karishma For multi website
    
	$objchat=new chat();							// By Ravi For Chat
	$objWebcms = new webcms(); // By Karishma For multi website
	////////////////////////////////
	////////////////////////////////
	
	
	(empty($_GET['curP']))?($_GET['curP']=1):(""); 
	(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
	(empty($_GET['key']))?($_GET['key']=""):(""); 
	(empty($_GET['tab']))?($_GET['tab']=""):(""); 
	(empty($_GET['asc']))?($_GET['asc']=""):(""); 
 
	(empty($_GET['edit']))?($_GET['edit']=""):("");
	(empty($_GET['view']))?($_GET['view']=""):("");
	(empty($_GET['del_id']))?($_GET['del_id']=""):("");
	(empty($_GET['active_id']))?($_GET['active_id']=""):("");
	(empty($_GET['module']))?($_GET['module']=""):("");
	(empty($_GET['opt']))?($_GET['opt']=""):("");

	(empty($Tooltip))?($Tooltip=""):("");
	(empty($LoginPage))?($LoginPage=""):("");
	(empty($HideNavigation))?($HideNavigation=""):("");
	(empty($NavText))?($NavText=""):("");
	(empty($SecurityPage))?($SecurityPage=""):("");
        (empty($EditPage))?($EditPage=""):("");
	(empty($clearfix))?($clearfix=""):("");
	(empty($AttachFlag))?($AttachFlag=""):("");
 
	 (empty($Line))?($Line=""):(""); 
	 (empty($InnerPage))?($InnerPage=""):(""); 
	$NotAllowed = 0;
	(!empty($_GET['locationID']))?($_SESSION['locationID']=(int)$_GET['locationID']):(""); 
	(empty($_SESSION['locationID']))?($_SESSION['locationID']=1):(""); 
	(empty($_SESSION['currency_id']))?($_SESSION['currency_id']=9):(""); 
	(empty($_SESSION['AdminType']))?($_SESSION['AdminType']=''):("");
	(empty($_SESSION['EmpEmail']))?($_SESSION['EmpEmail']=''):("");
	(empty($_SESSION['EDI_Access']))?($_SESSION['EDI_Access']=''):(""); 

	(empty($Config['DeptFolder']))?($Config['DeptFolder']=''):(""); 
	(empty($Config['ModuleDepName']))?($Config['ModuleDepName']=''):(""); 
	(empty($Config['DefaultMenu']))?($Config['DefaultMenu']=''):(""); 
	(empty($_GET['search']))?($_GET['search']=''):(""); 
	$rand='';
	$Config['GetNumRecords'] = '';	
	$Config['RecordsPerPage'] = ''; 
	$Config['ConversionType'] = '';
 
	$DefaultModule=$MainModuleID=$ModuleParentID =$MainModuleName='';
	 
 
	$CurrentDepID='';
	$Config['CurrentDepID']='';
	$RoleGroupUserId='';
	$TopSearch='';
	$CurrentDepartment='';

	$objConfig=new admin();	
	$objPager=new pager();
	$arrayConfig = $objConfig->GetSiteSettings(1);	

	
	if($arrayConfig[0]['IpBlock']=='1'){
		if(!$objConfig->CheckDet()){
			header('location:http://www.google.com');
			exit;
		}
	}

/***************Multi website  by Karishma******************/
 if(!empty($_GET["c"])){ 
		$objCom=new company(); 
		$arryCompanyWeb = $objCom->GetCompanyByDisplay($_GET["c"]);


		if(!empty($arryCompanyWeb[0]['Image'])){ $loginLogo=$arryCompanyWeb[0]['Image'];}
		$is_Company='1';
		
		if(!empty($_GET["u"])){
			$objConfig->dbName = 'erp_'.$arryCompanyWeb[0]['DisplayName'];
			$objConfig->connect();			
			$arryCustomerWeb = $objWebcms->GetCustomerIDBySiteName($_GET["u"]);				
	
			$loginLogo=$arryCustomerWeb[0]['Logo'];
			$is_Company=0;
		}
}
/***************************End*****************************/

 


	if(!empty($_SESSION['AdminID'])){
		CleanGet();
		
		// Geting data from main database
		$objCompany=new company(); 
		$objRegion=new region();
		

		$arryCompany = $objCompany->GetCompany($_SESSION['CmpID'],1);

		$arryCountry = $objRegion->getCountry('','');

		$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
		$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
		$Config['CmpDepartment'] = $arryCompany[0]['Department'];
		if(!empty($arryCompany[0]['Department'])){
			$arryCmpDepartment = explode("," , $arryCompany[0]['Department']);			
		}

		//$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']);
		$Config['DateFormat'] = $arryCompany[0]['DateFormat'];  $_SESSION['DateFormat']= $Config['DateFormat'];
		$Config['TimeFormat'] = ($arryCompany[0]['TimeFormat']!='')?($arryCompany[0]['TimeFormat']):("H:i:s");  
		$_SESSION['DateFormat']= $Config['DateFormat'];
		$_SESSION['TimeFormat']= $Config['TimeFormat'];

		/************/
		$ArrayDateFormat=$objConfig->GetDateFormatValue($Config['DateFormat']); 
		if($ArrayDateFormat[0]['dateID'] > 4){
			 $Config['DateFormatForm'] = $Config['DateFormat'];
			 $Config['DateFormatJS'] = $ArrayDateFormat[0]['DateFormat2'];
		}else{
			 $Config['DateFormatForm'] ='Y-m-d';
			 $Config['DateFormatJS'] = 'yy-mm-dd';
		}
		/************/

		$Config['ConversionType'] = $arryCompany[0]['ConversionType'];
		$_SESSION['ConversionType']= $Config['ConversionType'];
		 
   /*********Bin location based Setting ***************************/ 
		$Config['InventoryLevel'] = $arryCompany[0]['InventoryLevel'];
		$_SESSION['InventoryLevel']= $Config['InventoryLevel']; 
    /*********End ***************************/
		
		if(!empty($_SESSION['MaxAllowedUser'])){ //coming from license key
			$MaxAllowedUser = $_SESSION['MaxAllowedUser'];
		}else{
			$MaxAllowedUser = ($arryCompany[0]['MaxUser']>0)?($arryCompany[0]['MaxUser']):(1000);
		}

		

		/*********Inventory Setting ***************************/
		$Config['TrackInventory'] = $arryCompany[0]['TrackInventory'];
		$_SESSION['TrackInventory'] = $Config['TrackInventory'];
		$Config['MarketPlace'] = $arryCompany[0]['MarketPlace'];
		$_SESSION['MarketPlace']= $Config['MarketPlace'];
		$Config['TrackVariant'] = $arryCompany[0]['TrackVariant'];
		$_SESSION['TrackVariant']= $Config['TrackVariant'];
		$Config['sync_items'] = $arryCompany[0]['sync_items'];
		$_SESSION['sync_items']= $Config['sync_items'];
		$Config['sync_type'] = $arryCompany[0]['sync_type'];
		$_SESSION['sync_type']= $Config['sync_type'];
		$Config['ecomType'] = $arryCompany[0]['ecomType'];
		
		/********Added by karishma for dealer on 6 oct 2016********/
		$_SESSION['companyType'] = $arryCompany[0]['companyType'];
		/********End by karishma for dealer on 6 oct 2016********/
	
	/* Create  sub form for sales,purchase,finance Company Session */
		$Config['SelectOneItem'] = $arryCompany[0]['SelectOneItem'];
		$_SESSION['SelectOneItem']= $Config['SelectOneItem'];
		/* Create Default Inventory Company Session */
		$Config['DefaultInventoryCompany'] = $arryCompany[0]['DefaultInventoryCompany'];
		$_SESSION['DefaultInventoryCompany']= $Config['DefaultInventoryCompany'];
		

/*create Picking Session */
$Config['Picking'] = $arryCompany[0]['Picking'];
$_SESSION['Picking'] = $Config['Picking'];

 				$Config['batchmgmt'] = $arryCompany[0]['batchmgmt'];
        $_SESSION['batchmgmt']= $Config['batchmgmt'];
#if($_GET['bt4']==1) {echo $_SESSION['batchmgmt'];}
		// Added by karishma for editable field on 2 Feb 2016
		
		$Config['AdditionalCurrency']  = stripslashes($arryCompany[0]['AdditionalCurrency']);
         	// End by karishma for editable field on 2 Feb 2016  
         	 
		/* End Default Inventory Company Session */
		/*********StorageLimit************/
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
		/***********By Comapnay*************
		if($arryCompany[0]['currency_id']>0){
			$arrySelCurrency = $objRegion->getCurrency($arryCompany[0]['currency_id'],'');
			$Config['Currency'] = $arrySelCurrency[0]['code'];
			$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
			$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
			$Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value'];
		}
		/*********By Location**************/
		if($_SESSION['currency_id']>0){
			$arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'],'');
			$Config['Currency'] = $arrySelCurrency[0]['code'];
			$_SESSION['ConfigCurrency']= $Config['Currency'];

			$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
			$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
			$Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value'];
		}
		
		/******************************/
		if(!empty($_SESSION['CmpDatabase'])){
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		}else{
			session_destroy();
			echo '<div align="center"><br><br>'.ERROR_OTHER_BROWSER.'</div>';
			exit;
		}
		
	}else{
		$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
		$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
		
	}

	$objMenu=new cms();	
	$objConfigure=new configure();
	

	////////////////////////////////
	////////////////////////////////

	$ThisPage = $revPageArray[0]; //GetAdminPage();
	$SelfPage = $ThisPage;
	if(empty($ThisPageName)) $ThisPageName = $ThisPage;
	if(empty($_SESSION['AdminID'])) {
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
		ValidateAdminSession($ThisPage);
	}
	/***************************************/
	/***************************************/
	
	if(!empty($_SESSION['AdminID'])){	

		if(!empty($_GET['att'])){
			$ThisPageName = $ThisPageName.'?att='.$_GET['att'];
		}
		if(!empty($_GET['module'])){
			$ThisPageName = $ThisPageName.'?module='.$_GET['module'];
		}
	 

		if($ThisPageName=='viewProductCategory.php') $ThisPageName = 'viewProducts.php';
		/****************************/

		$arryCurrentLocation = $objConfigure->GetLocationData($_SESSION['locationID'],'');

		$arryDepartment = $objConfigure->GetDepartment();

		$arrySubDepartment = $objConfigure->GetSubDepartment('');

		$arryCurrentDepartment = $objConfigure->GetCurrentDepartment($ThisPageName);
		
		if(!empty($arryCurrentDepartment[0]["depID"])){
			$CurrentDepartment = stripslashes($arryCurrentDepartment[0]["Department"]);
			$CurrentDepID = stripslashes($arryCurrentDepartment[0]["depID"]);
			$Config['CurrentDepID'] = $CurrentDepID;
			if(empty($Config['DeptFolder'])) $DeptFolder = strtolower($CurrentDepartment).'/';
			$arryDepartmentInfo = $objConfigure->GetDepartmentInfo($CurrentDepID); 
			$Config['DeptHeadEmail'] = $arryDepartmentInfo[0]["Email"];
		}
		
		/* create spiff display for sales order*/
		$Config['spiffDis'] = $objConfigure->getSettingVariable('SpiffDisplay');
		$_SESSION['spiffDis']= $Config['spiffDis'];
		
		

		$Config['TodayDate'] = getLocalTime($arryCurrentLocation[0]['Timezone']);
		$_SESSION['TodayDate'] = $Config['TodayDate'];

		/*if((!empty($_GET['locationID']))){
			$_SESSION['currency_id']=$arryCurrentLocation[0]['currency_id']; //setting curreny id in session
		}else if(empty($_SESSION['currency_id'])){
			$_SESSION['currency_id']=$arryCurrentLocation[0]['currency_id'];
		}*/
         	$_SESSION['currency_id']=$arryCurrentLocation[0]['currency_id'];
		/****************************/
		$RecordsPerPage = ($arryCompany[0]['RecordsPerPage']>0)?($arryCompany[0]['RecordsPerPage']):('20');
		
		$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;
		$Config['AdminEmail'] = $arryCompany[0]['Email'];
		$_SESSION['AdminEmail'] = $Config['AdminEmail'];
		$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
		/****************************/		
		$arrayModuleID = $objConfig->getModuleID($_SESSION['AdminID'],$ThisPageName,$CurrentDepID,'');
		 //print_r($arrayModuleID);die;	
		if(!empty($arrayModuleID[0]['ModuleID'])){
			$MainModuleID = $arrayModuleID[0]['ModuleID'];
			$ModuleParentID = $arrayModuleID[0]['Parent'];
			$MainModuleName = $arrayModuleID[0]['Module'];
			if(!empty($arrayModuleID[0]['DefaultParent'])){
				$DefaultModule = $arrayModuleID[0]['DefaultParent'];	
			}	
			if(empty($Config['CurrentDepID'])){
				$CurrentDepID = $arrayModuleID[0]['depID'];
				if($CurrentDepID>0){			
					$Config['CurrentDepID'] =  $CurrentDepID;
					$Config['CmpDepartment'] .= ','.$CurrentDepID;
				}
			}
		}


		/*if($arrayModuleID[0]['EditPage']==1){
			$arrayModuleID2 = $objConfig->getParentModuleID($arrayModuleID[0]['Parent'],'');	
			$MainModuleID = $arrayModuleID2[0]['ModuleID'];
			$ModuleParentID = $arrayModuleID2[0]['Parent'];
		}*/
		/****************************/		
		$arrayDefaultMenu = $objConfig->GetDefaultMenus();
		foreach($arrayDefaultMenu as $key=>$values){
			$Config['DefaultMenu'] .= $values['ModuleID'].',';
		}
		$Config['DefaultMenu'] = rtrim($Config['DefaultMenu'],",");
		$AllowedModules = explode(",",$Config['DefaultMenu']);

		/****************************/	
		if($objConfigure->isUserKicked($_SESSION['loginID']) && $SelfPage != 'logout.php'){			
			header("location: ".$MainPrefix."logout.php");
			exit;
		}
		$objConfigure->updateLastViewTime();

		/****************************/	
		if($_SESSION['AdminType'] == "employee"){
			$GpIDArray = $objConfig->getEmployeeRoleID($_SESSION['AdminID']);
			if(!empty($GpIDArray[0]['GroupID']))$RoleGroupUserId = $GpIDArray[0]['GroupID'];

			$ArryEmployeeBasic = $objConfig->GetEmployeeBasic($_SESSION['AdminID']);
			$ExistingEmployee = $ArryEmployeeBasic[0]['ExistingEmployee'];								
			if($ExistingEmployee!="1"){
				$Config['DefaultMenu'] = -555; //unset
			}
		}
		/****************************/		
		require_once($MainPrefix."includes/security.php");
		/****************************/
		
		/****************************/		
		$TaxCaption = $objConfigure->getSettingVariable('TAX_CAPTION');
		if(empty($TaxCaption)){	
			$TaxCaption = 'Tax';
		}		 
		/****************************/

 	}

		/********common page********/	
		include($MainPrefix."includes/common.php");
		$CommonPage = "includes/common.php";
		if(file_exists($CommonPage)){ 
			include($CommonPage);
		}		
		/****************************/

 		 



	


	
?>
