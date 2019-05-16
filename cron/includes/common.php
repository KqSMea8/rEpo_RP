<?  	ob_start();
	session_start();
	
	
	$Prefix = "/var/www/html/erp/";
	//$Prefix = "../";

	ini_set("display_errors","1"); error_reporting(5);
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/cmp.class.php");	
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/MyMailer.php");	
	
	////////////////////////////////
	////////////////////////////////	
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objCmp=new cmp();
	$arrayConfig = $objConfig->GetSiteSettings(1);		
	$arrayAdmin = $objConfig->GetAdmin(1);
	$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
	$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
	$Config['AdminEmail'] = $arrayConfig[0]['SiteEmail'];
	
?>
