<?php   ob_start();
session_start();

date_default_timezone_set('Asia/Kolkata');

if(empty($_SESSION['AdminID'])){
	echo '<script>location.href="../index.php";</script>';
}

require_once("classes/wp-db.php"); 
require_once("includes/config.php");
require_once("../../includes/common.php");
require_once("../../includes/function.php");
require_once("../../classes/admin.class.php");
require_once("classes/common.class.php");
require_once("../../classes/pager.cls.php");
require_once("classes/plan.class.php");
require_once("classes/package.class.php");
require_once("classes/user.class.php");
require_once(_chatRoot."/classes/formhelper.php");
require_once(_chatRoot."/classes/class.validation.php");
//require_once("classes/user.class.php");


////////////////////////////////
////////////////////////////////
(empty($_GET['curP']))?($_GET['curP']=1):(""); 
(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
(empty($_GET['key']))?($_GET['key']=""):(""); 
(empty($HideNavigation))?($HideNavigation=""):("");
(empty($LoginPage))?($LoginPage=""):("");
(empty($InnerPage))?($InnerPage=""):("");
(empty($FooterStyle))?($FooterStyle=""):("");

$objConfig=new admin();
$objPager=new pager();
$objcommon=new common();
$objUser= new user();
//$objUserConfig=new Suser();
CleanGet();

unset($_SESSION['CmpDatabase']);
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
  
	$arrayConfig = $objcommon->GetStSettings(1);
 
	$arrayAdmin = $objcommon->GetAdminSt(1);
	#$arraySignature = $objConfig->GetSignatureSt(10,1);

	$RecordsPerPage = $arrayConfig[0]->RecordsPerPage;
	$Config['SiteName']  = stripslashes($arrayConfig[0]->SiteName);
	$Config['SiteTitle'] = stripslashes($arrayConfig[0]->SiteTitle);
	$Config['RecieveSignEmail']  = $arrayConfig[0]->RecieveSignEmail;

	$Config['AdminEmail'] = $arrayAdmin[0]->AdminEmail;  
	#if(!empty($arraySignature[0]->PageContent)) $Config['MailFooter'] = stripslashes($arraySignature[0]->PageContent);

 
	if(!empty($_GET['att'])){
		$ThisPageName = $ThisPageName.'?att='.$_GET['att'];
	}

	function __($value){
		return $value;
	}

?>

