<?php ob_start();
	session_start();
	//error_reporting(0);
    require_once("../../includes/config.php");
	require_once("../../includes/language.php");
    require_once("../../includes/function.php");
    require_once("../../classes/dbClass.php");
	require_once("../../classes/admin.class.php");	
	require_once("../../classes/pager.cls.php");
	require_once("../../classes/MyMailer.php");	
	require_once("language/english.php");

	////////////////////////////////
	////////////////////////////////
	(!$_GET['curP'])?($_GET['curP']=1):(""); 
	(!$_GET['sortby'])?($_GET['sortby']=""):(""); 
	(!$_GET['key'])?($_GET['key']=""):(""); 

	$objConfig=new admin();	 
	$objPager=new pager();
	CleanGet();
	unset($_SESSION['CmpDatabase']);
	////////////////////////////////
	////////////////////////////////
	$ThisPage = GetAdminPage();
	$SelfPage = $ThisPage;
	$ThisPageName = $ThisPage;
	if($_SESSION['AdminID']  == '') {
		if (isset($_SERVER['QUERY_STRING'])){
			$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
			$ThisPage = str_replace("&amp;",",",$ThisPage);
		}
	}	


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
	
?>

