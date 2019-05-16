<?php 
/**************************************************/
//$ThisPageName = 'leadForm.php'; $HideNavigation = 1;
/**************************************************/
//require_once("../includes/header.php");
//require_once($Prefix."classes/lead.class.php");
//$objLead = new lead();

ini_set("display_errors","1"); error_reporting(1);	
require_once("includes/config.php");	
require_once("classes/dbClass.php");
require_once("includes/function.php");
require_once("classes/MyMailer.php");	
require_once("classes/admin.class.php");	
require_once("classes/company.class.php");
require_once("classes/configure.class.php");
require_once("classes/lead.class.php");
require_once("admin/language/english.php");
 	//require_once("classes/lead.class.php");
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$objConfig=new admin();	


$arryCompany = $objConfig->GetCompanyBySecuredID($_GET['cmp']);   
$CmpDatabase = $Config['DbMain']."_".$arryCompany[0]['DisplayName'];
$Config['DbName2'] = $CmpDatabase;


$Config['DbName'] = $CmpDatabase;
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();


$objLead = new lead();
$arryLeadForm = $objLead->GetLeadWebForm($_GET['formid']);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
if(!empty($_SESSION['CAPTCHA_CODE_ERROR']) && $_SESSION['CAPTCHA_CODE_ERROR']=='1' ){
	unset($_SESSION['CAPTCHA_CODE_ERROR']);
	echo '<h6 style="color: red; font-size: 14px; font-weight: normal; text-align: center;">Image varification code mismatch.</h6>';
}
echo $arryLeadForm[0]['HtmlForm'];

//require_once("../includes/footer.php"); 
?>

