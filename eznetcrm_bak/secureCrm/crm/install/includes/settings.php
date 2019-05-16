<?  	ob_start();
	session_start();
	ini_set("display_errors","0"); error_reporting(0);
	require_once("../includes/language.php");
	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");
	require_once("../classes/company.class.php");
	require_once("../classes/region.class.php");	
	require_once("../classes/MyMailer.php");	
	require_once("language/english.php");

	////////////////////////////////
	////////////////////////////////

	$ThisPage = GetAdminPage();
	$Config['SiteName'] = 'eZnetCRM';
	$Config['AdminCSS'] = "css/admin.css";
	$Config['AdminCSS2'] = "css/admin-style.css";
	#$Config['Online']   = 1;
	$Config['Install']   = 1;
	$Config['DbName']    = 'crm';
	$Config['DbMain']    = $Config['DbName'];
	$Config['EmailTemplateFolder']	= 'includes/html/email/';
?>

