<?php  ob_start();
	session_start();
	error_reporting(5); ini_set("display_errors","1");
    //require_once("../../includes/config.php");
    require_once("includes/config.php");
	require_once("../../includes/language.php");
    require_once("../../includes/function.php");
    require_once("../../classes/erp.dbClass.php");
	require_once("../../classes/erp.admin.class.php");
        require_once("../../classes/Suser.Class.php");
	require_once("../../classes/pager.cls.php");
	require_once("../../classes/MyMailer.php");	
	require_once("../language/english.php");	
////////////////////////////////
	////////////////////////////////
	(!$_GET['curP'])?($_GET['curP']=1):(""); 
	(!$_GET['sortby'])?($_GET['sortby']=""):(""); 
	(!$_GET['key'])?($_GET['key']=""):(""); 

	$objConfig=new admin();	 
	$objPager=new pager();
	$objUserConfig=new Suser();
	CleanGet();
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
?>

	
