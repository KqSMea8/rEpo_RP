<?php	session_start();

	date_default_timezone_set('America/New_York');

	$Prefix = "../../"; 
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix.'classes/class.pdf.php');
	require_once($Prefix.'classes/class.ezpdf.php');
	require_once($Prefix.'includes/pdf_function.php');
	require_once("../language/english.php");
	require_once("language/english.php");

	/********************************/
	$objConfig=new admin();

	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}
	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$objCompany=new company(); 
	$objConfigure=new configure();

	CleanGet();
	$arryCompany = $objCompany->GetCompanyDetail($_SESSION['CmpID']);


	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	$arryCurrentLocation = $objConfigure->GetLocationData($_SESSION['locationID'],'');
	$Config['TodayDate'] = getLocalTime($arryCurrentLocation[0]['Timezone']);
	$_SESSION['TodayDate'] = $Config['TodayDate'];


	$Config['Prefix'] = $Prefix;

	$Config['vAllRecord'] = $_SESSION['vAllRecord'];

	$ThisPageName='';
	(empty($_GET['curP']))?($_GET['curP']=1):(""); 
	(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
	(empty($_GET['key']))?($_GET['key']=""):(""); 
	(empty($_GET['tab']))?($_GET['tab']=""):(""); 
	(empty($_GET['asc']))?($_GET['asc']=""):(""); 
 	(empty($_GET['status']))?($_GET['status']=""):(""); 

	(empty($_GET['edit']))?($_GET['edit']=""):("");
	(empty($_GET['view']))?($_GET['view']=""):("");
	(empty($_GET['del_id']))?($_GET['del_id']=""):("");
	(empty($_GET['active_id']))?($_GET['active_id']=""):("");
	(empty($_GET['module']))?($_GET['module']=""):("");
	(empty($_GET['opt']))?($_GET['opt']=""):("");
	(empty($_GET['parent_type']))?($_GET['parent_type']=""):(""); 
	(empty($_GET['parentID']))?($_GET['parentID']=""):(""); 
	(empty($_GET["customview"])) ?($_GET["customview"]="") :("");

	(empty($AttachFlag))?($AttachFlag=""):("");
	(empty($SelfPage))?($SelfPage=""):("");
	(empty($YCordLine))?($YCordLine=""):("");
 	(empty($id))?($id=""):(""); 

	$Config['GetNumRecords'] = '';	
	$Config['RecordsPerPage'] = ''; 
?>
