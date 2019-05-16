<?
$ColorCodeArray = array(   
	"Red" => "#FFB0AA", "Green" => "#CAFFCA", "Blue" => "#CCCCFF",
	"Yellow" => "#FFFF99",	"Grey" => "#CCCCCC", "Pink" => "#FFE3EB"   
);
 
/***** Variable Define ********/
/****************************/
$Status = $HideSubmit = $HideSearch=$HideSibmit = $num= $ErrorMsg = '';
$ImageExist = $FromDate = $ToDate = $Config['HideDefaultIcon'] = '';
$DeleteSpan='';
(empty($_GET['y']))?($_GET['y']=""):("");
(empty($_GET['m']))?($_GET['m']=""):("");
(empty($_GET['fby']))?($_GET['fby']=""):("");
(empty($_GET['f']))?($_GET['f']=""):("");
(empty($_GET['t']))?($_GET['t']=""):("");
(empty($_GET['pop']))?($_GET['pop']=""):("");	
(empty($_GET['tab']))?($_GET['tab']=""):(""); 
(empty($_GET['FromDate']))?($_GET['FromDate']=""):("");
(empty($_GET['ToDate']))?($_GET['ToDate']=""):("");
(empty($_GET['customview']))?($_GET['customview']="All"):("");
(empty($_GET['action']))?($_GET['action']=""):("");
(empty($_GET['Action']))?($_GET['Action']=""):("");
(empty($_GET['file']))?($_GET['file']=""):("");
(empty($_GET['del_file']))?($_GET['del_file']=""):("");
(empty($_GET['link']))?($_GET['link']=""):("");
(empty($_GET['locationID']))?($_GET['locationID']=""):("");
(!isset($_GET['sp']))?($_GET['sp']=""):("");
(!isset($_GET['d']))?($_GET['d']=""):("");


(empty($Config['AddGap']))?($Config['AddGap']=""):("");  	
(empty($HideForm))?($HideForm=""):("");
(empty($country_code))?($country_code=""):(""); 
(empty($country_prefix))?($country_prefix=""):("");  
(empty($Prefix))?($Prefix=""):("");  
$ActiveChecked = '';$InActiveChecked ='';
(empty($Tooltip))?($Tooltip=""):("");

/**************************************/

$Config['ObjectStorage']=0;  
$_SESSION['ObjectStorage'] = $Config['ObjectStorage'];

/*
if(isset($arryCompany[0]['ObjectStorage'])){
	$Config['ObjectStorage'] = $arryCompany[0]['ObjectStorage'];
	$_SESSION['ObjectStorage'] = $Config['ObjectStorage'];
}*/

$Config['CmpID'] = (!empty($_SESSION['CmpID']))?($_SESSION['CmpID']):(""); 

/*******Object Storage OLD**********/
/**************************************/
/*
$Config['OsUsername'] = "pramod";
$Config['OsPassword'] = "dMeK12I9I1jj";
$Config['OsTenantId'] = "686913a917184cd88695ffc77d3b48a7";
$Config['OsIdentityUrl'] = 'http://75.112.188.250:5000';
$Config['OsUploadUrl'] = 'http://75.112.188.224:8080/v1/AUTH_'.$Config['OsTenantId'].'/';
*/

/*******Object Storage New**********/
/***********************************/  //NewPK
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

 
/******* HRMS ********/
$Config['EmployeeDir'] = "employee/";
$Config['AddressProofDir'] = "add_proof/";
$Config['EducationDir'] = "education/";
$Config['IdDir'] = "ids/";
$Config['EmpResumeDir'] = "emp_resume/";
$Config['CandidateDir'] = "candidate/";
$Config['CandResumeDir'] = "cand_resume/";
$Config['DeclarationDir'] = "declaration/";
$Config['ReimDir'] = "reim/";
$Config['BenefitDir'] = "benefit/";
$Config['TrainingDir'] = "training/";
$Config['NewsDir'] = "news/";
$Config['H_DocumentDir'] = "h_document/";
$Config['AssetDir'] = "asset/";
/******* Purchasing ********/
$Config['P_Quote'] = "p_quote/";
$Config['P_Order'] = "p_order/";
$Config['P_Rma'] = "p_rma/";
/******* Sales ********/
$Config['S_Quote'] = "s_quote/";
$Config['S_Order'] = "s_order/";
$Config['S_Rma'] = "s_rma/";
/******* Warehouse ********/
$Config['P_Receipt'] = "p_receipt/";
$Config['S_Shipment'] = "s_shipment/";
/******* CRM ********/
$Config['C_DocumentDir'] = "c_document/";
$Config['C_Quote'] = "c_quote/";
/******* Inventory ********/
$Config['Items'] = "items/";
$Config['ItemsSecondary'] = "items_secondary/";
$Config['ItemCategory'] = "category/";
/******* Finance ********/
$Config['CustomerDir'] = "customer/";
$Config['VendorDir'] = "vendor/";
$Config['JournalDir'] = "journal/";
$Config['JournalArchiveDir'] = "journal_archive/";
$Config['S_DocomentDir'] = "s_document/";
$Config['P_DocomentDir'] = "p_document/";
$Config['P_Credit'] = "p_credit/";
$Config['S_Credit'] = "s_credit/";
$Config['S_Invoice'] = "s_invoice/";
$Config['P_Invoice'] = "p_invoice/";

/******* Ecommerce ********/
$Config['Products'] = "products/";
$Config['ProductsSecondary'] = "products_secondary/";
$Config['ProductsCategory'] = "cat/";
$Config['ProductsManufacturer'] = "manufacturer/";
$Config['ProductsBanner'] = "banner/";

/******* Superadmin ********/
$Config['SuperCmpID'] = '000';
$Config['NotificationDir'] = 'notification/';
$Config['DefaultLogo'] = $Config['Url'].'images/logo.png';
$Config['DefaultLogoCrm'] = $Config['Url'].'images/logo_crm.png';
$Config['SiteLogoDir'] = "logo/";
$Config['CmpDir'] = "company/";

$Config['HelpDoc'] = 'helpdoc/';
$Config['HelpVedio'] = 'helpvedio/';
?>
