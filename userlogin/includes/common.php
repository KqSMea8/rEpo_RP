<?
if(isset($_SESSION['CmpID']))$Config['CmpID'] = $_SESSION['CmpID'];

/***** Variable Define ********/
/****************************/
(empty($_GET['curP']))?($_GET['curP']=1):(""); 
(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
(empty($_GET['key']))?($_GET['key']=""):(""); 
(empty($_GET['tab']))?($_GET['tab']=""):(""); 
(empty($_GET['asc']))?($_GET['asc']=""):(""); 

(empty($_GET['edit']))?($_GET['edit']=""):("");
(empty($_GET['view']))?($_GET['view']=""):("");
(empty($_GET['del_id']))?($_GET['del_id']=""):("");
(empty($_GET['active_id']))?($_GET['active_id']=""):("");
(empty($_GET['module']))?($_GET['module']=""):("");
(empty($_GET['opt']))?($_GET['opt']=""):("");
(empty($_GET['CmpID']))?($_GET['CmpID']=""):("");
(empty($Config['CmpID']))?($Config['CmpID']=""):("");

(empty($_GET['y']))?($_GET['y']=""):("");
(empty($_GET['m']))?($_GET['m']=""):("");
(empty($_GET['fby']))?($_GET['fby']=""):("");
(empty($_GET['f']))?($_GET['f']=""):("");
(empty($_GET['t']))?($_GET['t']=""):("");
(empty($_GET['pop']))?($_GET['pop']=""):("");	
(empty($_GET['tab']))?($_GET['tab']=""):(""); 
(empty($_GET['search']))?($_GET['search']=""):(""); 	
(empty($_GET['FromDate']))?($_GET['FromDate']=""):("");
(empty($_GET['ToDate']))?($_GET['ToDate']=""):("");
(empty($_GET['file']))?($_GET['file']=""):("");
(empty($_GET['pk']))?($_GET['pk']=""):("");
(empty($_GET['batchOn']))?($_GET['batchOn']=""):("");
(empty($_GET['he']))?($_GET['he']=""):("");
(empty($_GET['this']))?($_GET['this']=""):("");	
(empty($_GET['AddID']))?($_GET['AddID']=""):("");	
 

(empty($NavText))?($NavText=""):("");
(empty($Tooltip))?($Tooltip=""):("");
(empty($HideNavigation))?($HideNavigation=""):("");
(empty($ModuleParentID))?($ModuleParentID=""):("");
(empty($MainModuleName))?($MainModuleName=""):("");
(empty($LoginPage))?($LoginPage=""):("");
(empty($SetInnerWidth))?($SetInnerWidth=""):("");
(empty($InnerPage))?($InnerPage=""):("");
(empty($FromDate))?($FromDate=""):("");
(empty($ToDate))?($ToDate=""):("");
(empty($rand))?($rand=""):("");
(empty($clearfix))?($clearfix=""):("");

(empty($star))?($star=""):("");
(empty($datamand))?($datamand=""):(""); 
(empty($CurrentDepartment))?($CurrentDepartment=""):(""); 
(empty($TransactionExist))?($TransactionExist=""):(""); 
(empty($MandForEcomm))?($MandForEcomm=""):(""); 
(empty($SendUrl))?($SendUrl=""):(""); 


(empty($Config['CurrentDepID']))?($Config['CurrentDepID']=""):("");
(empty($Config['GetNumRecords']))?($Config['GetNumRecords']=""):("");
(empty($Config['RecordsPerPage']))?($Config['RecordsPerPage']=""):("");
(empty($Config['batchmgmt']))?($Config['batchmgmt']=""):("");
(empty($_SESSION['currency_id']))?($_SESSION['currency_id']=9):(""); 
(empty($_SESSION['CompanyUserID']))?($_SESSION['CompanyUserID']=""):(""); 
(empty($_SESSION['UserName']))?($_SESSION['UserName']=""):(""); 
(empty($_SESSION['AdminID']))?($_SESSION['AdminID']=""):(""); 
(empty($_SESSION['AdminType']))?($_SESSION['AdminType']=""):(""); 
(empty($_SESSION['UserType']))?($_SESSION['UserType']=""):(""); 
(empty($_SESSION['ref_id']))?($_SESSION['ref_id']=""):(""); 
/*******Object Storage Define**********/
/**************************************/
$Config['ObjectStorage'] = 1;
$_SESSION['ObjectStorage'] = $Config['ObjectStorage'];
/*******
$Config['OsUsername'] = "pramod";
$Config['OsPassword'] = "dMeK12I9I1jj";
$Config['OsTenantId'] = "686913a917184cd88695ffc77d3b48a7";
$Config['OsIdentityUrl'] = 'http://75.112.188.250:5000';
$Config['OsUploadUrl'] = 'http://75.112.188.224:8080/v1/AUTH_'.$Config['OsTenantId'].'/';
/****************************/

$Config['OsRegion'] = 'us-west-1';
$Config['OsVersion'] = '2006-03-01';
$Config['OsEndpoint'] = 'https://object.virtualstacks.com/'; //'http://208.72.26.254/';
$Config['use_path_style_endpoint'] = true;
$Config['OsKey'] = 'OZ5TQ1SYADQ8FB8NW0M4';
$Config['OsSecret'] ='RGMOrCm8UL8po7vEEdo6chYgg09prlW98opNzMx5';
$Config['OsUploadUrl'] = $Config['OsEndpoint'];
$PrefixOsDir ='';
if(strlen($Config['CmpID'])=='1'){
	$PrefixOsDir='00';
}else if(strlen($Config['CmpID'])=='2'){
	$PrefixOsDir='0';
} 
$Config['OsDir'] = $PrefixOsDir.$Config['CmpID'];
/***** File Upload Directory ********/
/************************************/
$Config['UploadDir'] = "upload/";
$Config['RootUploadDir'] = $_SERVER['DOCUMENT_ROOT']."/".$Config['UploadDir']; 
$Config['RootUploadUrl'] = $Config['WebUrl'].$Config['UploadDir']; 

//With CmpID
$Config['FileUploadDir'] = "../".$Prefix.$Config['UploadDir'].$Config['CmpID']."/";
$Config['FilePreviewDir'] = $Config['RootUploadDir'].$Config['CmpID']."/";
$Config['FileUploadUrl'] = $Config['RootUploadUrl'].$Config['CmpID']."/";
 
/***** Common Directory ********/
$Config['S_Invoice'] = "s_invoice/";
$Config['S_Order'] = "s_order/";
/******* Inventory ********/
$Config['Items'] = "items/";
$Config['ItemsSecondary'] = "items_secondary/";
$Config['ItemCategory'] = "category/";
/******* Superadmin ********/
$Config['SuperCmpID'] = '000';
$Config['DefaultLogo'] = $Config['Url'].'/images/logo.png';
$Config['DefaultLogoCrm'] = $Config['Url'].'images/logo_crm.png';
$Config['SiteLogoDir'] = "logo/";
$Config['SiteLogo'] = "logo/";
$Config['CmpDir'] = "company/";
 
 


?>
