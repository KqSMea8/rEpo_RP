<?php  ob_start(); 
	session_start();
	error_reporting(5); 
      if($_SESSION['AdminID']=='')
     {
     	echo '<script>location.href="../index.php";</script>';
     }
	ini_set("display_errors","1");
	require_once("classes/wp-db.php");
    	require_once("includes/config.php");
     	require_once("../../includes/function.php");
	require_once("../../classes/admin.class.php");	
        require_once("classes/common.class.php");	
	require_once("../../classes/pager.cls.php");
        require_once("classes/plan.class.php");
        require_once("classes/package.class.php");
        require_once("classes/user.class.php");
        require_once(_chatRoot."/classes/formhelper.php");
        require_once(_chatRoot."/classes/class.validation.php");


	////////////////////////////////
	////////////////////////////////
	(empty($_GET['curP']))?($_GET['curP']=1):(""); 
	(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
	(empty($_GET['key']))?($_GET['key']=""):(""); 
	(empty($_GET['asc']))?($_GET['asc']=""):(""); 
 	(empty($_GET['att']))?($_GET['att']=""):(""); 

	(empty($EditPage))?($EditPage=""):("");
	(empty($HideNavigation))?($HideNavigation=""):("");
	(empty($LoginPage))?($LoginPage=""):("");
	(empty($InnerPage))?($InnerPage=""):("");

	$objConfig='';

	//$objConfig=new admin();	 
//	die('Setting');
  	
	//$objPager=new pager(); 
	
    //$objcommon=new common();
    //die('settings');
	//$objUserConfig=new Suser();
//print_r($_GET);
//	CleanGet();
	  
	//print_r($_GET);
//die;
	unset($_SESSION['CmpDatabase']);
	////////////////////////////////
	////////////////////////////////
	$ThisPage = GetAdminPage();
	$SelfPage = $ThisPage;

	if(empty($ThisPageName)) $ThisPageName = $ThisPage;
	if($_SESSION['AdminID']  == '') {
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
		$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
		$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
		$Config['AdminEmail'] = $arrayAdmin[0]['AdminEmail'];
		$Config['RecieveSignEmail']  = $arrayConfig[0]['RecieveSignEmail'];	
		#if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);
		
	}
	if(!empty($_GET['att'])){
		$ThisPageName = $ThisPageName.'?att='.$_GET['att'];
	}
        
        function __($value){
            
            return $value;
        }
          
?>

