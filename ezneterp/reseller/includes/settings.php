<?php ob_start();
	session_start();
	error_reporting(1);
	$Prefix = "../../";  $MainPrefix = "../"; 



	$PageArry = explode("/",$_SERVER['PHP_SELF']);
	$revPageArray = array_reverse($PageArry);
	if(substr_count($revPageArray[0],'.php')!=1){
		exit;
	}




	require_once($Prefix."includes/erp_config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/erp.dbClass.php");
	require_once($Prefix."classes/erp.admin.class.php");
        
        require_once($Prefix."classes/company.class.php");
        
	require_once($Prefix."classes/pager.cls.php");
	require_once($Prefix."classes/MyMailer.php");	
	require_once($Prefix."classes/rsl.class.php");
	require_once("language/english.php");

	////////////////////////////////
	////////////////////////////////

	
	(!$_GET['curP'])?($_GET['curP']=1):(""); 
	(!$_GET['sortby'])?($_GET['sortby']=""):(""); 
	(!$_GET['key'])?($_GET['key']=""):(""); 

	$objConfig=new admin();	 
	$objPager=new pager();
	$objRes=new rs();
	CleanGet();
	
	////////////////////////////////
	////////////////////////////////
	$ThisPage = $revPageArray[0]; //GetAdminPage();

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
		$Config['AdminEmail'] = $arrayConfig[0]['SiteEmail']; //$arrayAdmin[0]['AdminEmail'];
		$Config['RecieveSignEmail']  = $arrayConfig[0]['RecieveSignEmail'];	
		$Config['MailFooter'] = '['.stripslashes($arrayConfig[0]['SiteName']).']';
		
		#if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);
		
	}
	
?>

