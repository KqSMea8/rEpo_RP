<?  ob_start();
	session_start();

    require_once("includes/config.php");
	require_once("includes/language.php");
    require_once("includes/function.php");
    require_once("classes/dbClass.php");
	require_once("classes/admin.class.php");	
	require_once("classes/category.class.php");	
	require_once("classes/product.class.php");
	require_once("classes/member.class.php");
	require_once("classes/MyMailer.php");
	include_once("classes/paging_store.class.php");
	require_once("classes/orders.class.php");
	require_once("classes/region.class.php");
	require_once("classes/partner.class.php");
	require_once("classes/bulk.class.php");
	//////////////////////////////////////////////////////////////////////////////////////////////////
	(!$_GET['curP'])?($_GET['curP']=1):(""); // Current page number
	$NumLanguages = 1;


	$objPager=new pager();
	$objConfig=new admin();	
	$objCategory=new category();
	$objProduct=new product();
	$objMember=new member();
	$objOrder=new orders();
	$objRegion=new region();
	$objPartner=new partner();
	$objBulk=new bulk();
	

	if (is_object($objConfig)) {		// Checking the object of 'admin' class.
		$arrayConfig = $objConfig->GetSiteSettings(1);	
		$arrayAdmin = $objConfig->GetAdmin(1);
		$arraySignature = $objConfig->GetSignature(10,1);
		
		
		$RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];
		$MemberApproval	= $arrayConfig[0]['MemberApproval'];
		$Config['SiteName']  = $arrayConfig[0]['SiteName'];	
		$Config['SiteTitle'] = $arrayConfig[0]['SiteTitle'];
		$Config['AdminEmail'] = $arrayAdmin[0]['AdminEmail'];
		
		if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);
		
	}
	
	if($HTTP_SERVER_VARS['HTTP_HOST']=="parwez"){
		$Config['Url'] = 'http://parwez/webo/';
	}


	
	$ThisPage = GetPage(); 

	$ThisPageUrl = $ThisPage.'?'.$_SERVER['QUERY_STRING'];

	if(!empty($_GET['ref']))
		$ContinueUrl = $_GET['ref'];
	else
		$ContinueUrl = $ThisPageUrl;


	$LanguageDirectory    = "languages/English/";
	$HtmlParams = 'dir="LTR" lang="es"';
	$CharSet	= 'iso-8859-1';
	
	require_once($LanguageDirectory."general.php");
	require_once($LanguageDirectory."other.php");
	require_once($LanguageDirectory."msg.php");
	


	
?>