<?  ob_start();
	session_start();

 


 	$Config['CronJob'] = '0';
    	require_once("../includes/config.php");
	require_once("../includes/language.php");
    	require_once("../includes/function.php");
    	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");	
	require_once("../classes/pager.cls.php");
	require_once("../classes/MyMailer.php");
	require_once("../classes/Suser.Class.php");
	require_once("../classes/configure.class.php");	
	require_once("language/english.php");
	require_once("../includes/common.php");
	////////////////////////////////
	$Config['GetNumRecords'] = '';	
	$Config['RecordsPerPage'] = ''; 
	////////////////////////////////
	(empty($_GET['curP']))?($_GET['curP']=1):(""); 
	(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
	(empty($_GET['key']))?($_GET['key']=""):(""); 
	(empty($_GET['asc']))?($_GET['asc']=""):(""); 
	(empty($_GET['tab']))?($_GET['tab']=""):(""); 

	(empty($_GET['edit']))?($_GET['edit']=""):("");
	(empty($_GET['view']))?($_GET['view']=""):("");
	(empty($_GET['del_id']))?($_GET['del_id']=""):("");
	(empty($_GET['active_id']))?($_GET['active_id']=""):("");
	(empty($_GET['module']))?($_GET['module']=""):("");
	(empty($_GET['opt']))?($_GET['opt']=""):("");

	(empty($EditPage))?($EditPage=""):("");
	(empty($LoginPage))?($LoginPage=""):("");
	(empty($NavText))?($NavText=""):("");
	(empty($MoreFlag))?($MoreFlag=""):("");
	(empty($Line))?($Line=""):(""); 
	(empty($ModuleParent))?($ModuleParent=""):(""); 
 
	$objConfig=new admin();	 
	$objPager=new pager();
	$objUserConfig=new Suser();
	$objConfigure = new configure();
	CleanGet();
	unset($_SESSION['CmpDatabase']);

	date_default_timezone_set('America/New_York');

	////////////////////////////////
	////////////////////////////////
	$ThisPage = GetAdminPage();
	$SelfPage = $ThisPage;
	if(empty($ThisPageName)) $ThisPageName = $ThisPage;
	if(empty($_SESSION['AdminID'])) {
		if (isset($_SERVER['QUERY_STRING'])){
			$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
			$ThisPage = str_replace("&amp;",",",$ThisPage);
		}
	}	


	if(substr_count($ThisPageName,'.php')!=1){
		exit;
	}
	//////////////////////////////// 

	if (is_object($objConfig)){
		$arrayConfig = $objConfig->GetSiteSettings(1);	
		$arrayAdmin = $objConfig->GetAdmin(1);
		#$arraySignature = $objConfig->GetSignature(10,1);
		
		$RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];
		$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;	
		$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
		$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
		$Config['SiteEmail'] = stripslashes($arrayConfig[0]['SiteEmail']);
		$Config['AdminEmail'] = $arrayAdmin[0]['AdminEmail'];
		$Config['RecieveSignEmail']  = $arrayConfig[0]['RecieveSignEmail'];	

		#if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);
		
	}
	if(!empty($_GET['att'])){
		$ThisPageName = $ThisPageName.'?att='.$_GET['att'];
	}

	
	if(!empty($_SESSION['SecurityCodeTime'])){
		if((time() - $_SESSION['SecurityCodeTime']) > 180) {
			unset($_SESSION['SecurityCode']);
			unset($_SESSION['SecurityCodeTime']);
		}
	}

	if(!empty($_GET['prID'])){		
		$_SESSION['projectID']=$_GET['prID'];
	}
	if(empty($_SESSION['projectID'])) $_SESSION['projectID']=1;
//if($_SESSION['projectID'] == 4) 	header("Location: erpwesite/pageList.php");

	/**************/
	$arrayModuleDetail = $objUserConfig->GetPageByLink($ThisPageName);
	$MainModuleID = !empty($arrayModuleDetail[0]['ModuleID'])?($arrayModuleDetail[0]['ModuleID']):('');
	

	if(!empty($arrayModuleDetail[0]['depID'])){
		$_SESSION['projectID'] = (!empty($arrayModuleDetail[0]['depID']))?($arrayModuleDetail[0]['depID']):('');
		$ModuleParent = (!empty($arrayModuleDetail[0]['ModuleParent']))?($arrayModuleDetail[0]['ModuleParent']):('');
	}
	
	/**************/
 
	 include("includes/common.php");
	

	$dataBasefolder = '/prod-data-erp/database-backup/';	
	if(!empty($_GET['dir'])) $dataBasefolder = $_GET['dir'];
	$dataBaseMainpath = $dataBasefolder;
?>

