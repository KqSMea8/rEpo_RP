<?	session_start();
	$Prefix = "../../"; 

    require_once($Prefix."includes/config.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix.'classes/class.pdf.php');
	require_once($Prefix.'classes/class.ezpdf.php');
	require_once($Prefix.'includes/pdf_function.php');
	require_once("language/english.php");

	/********************************/
	$objConfig=new admin();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$objCompany=new company(); 
	$arryCompany = $objCompany->GetCompanyDetail($_SESSION['CmpID']);


	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$Config['Prefix'] = $Prefix;

?>