<?
/*******Object Storage Define**********/
/**************************************/
$Config['ObjectStorage'] = 0;
$_SESSION['ObjectStorage'] = $Config['ObjectStorage'];
$Config['CmpID'] = '000';
$_SESSION['CmpID'] = $Config['CmpID'];

/*******Object Storage OLD**********/
/*******************************
$Config['OsUsername'] = "pramod";
$Config['OsPassword'] = "dMeK12I9I1jj";
$Config['OsTenantId'] = "686913a917184cd88695ffc77d3b48a7";
$Config['OsIdentityUrl'] = 'http://75.112.188.250:5000';
$Config['OsUploadUrl'] = 'http://75.112.188.224:8080/v1/AUTH_'.$Config['OsTenantId'].'/';

/*******Object Storage New**********/
/***********************************/  //NewPK
$Config['OsRegion'] = 'us-west-1';
$Config['OsVersion'] = '2006-03-01';
$Config['OsEndpoint'] = 'https://object.virtualstacks.com/';//'http://208.72.26.254/';
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
/*********************************/
$Config['UploadDir'] = "upload/";
$Config['RootUploadDir'] = $_SERVER['DOCUMENT_ROOT']."/".$Config['UploadDir']; 
$Config['RootUploadUrl'] = $Config['WebUrl'].$Config['UploadDir']; 

//With CmpID
$Config['FilePreviewDir'] = $Config['RootUploadDir'].$Config['CmpID']."/";
$Config['FileUploadUrl'] = $Config['RootUploadUrl'].$Config['CmpID']."/";

/***** Common Directory ********/
/****************************/
$Config['EmployeeDir'] = "employee/";
$Config['NewsDir'] = "news/";

$Config['BannerDir'] = "banner/";
$Config['TestimonialDir'] = "testimonial/";
$Config['FaqDir'] = "faq/";
$Config['ErpBannerDir'] = "erpbanner/";
$Config['CompanyDir'] = "CompanyDir/";
$Config['ResellerDir'] = "reseller/";
$Config['HelpDoc'] = 'helpdoc/';
$Config['HelpVedio'] = 'helpvedio/';
$Config['NotificationDir'] = 'notification/';
$Config['CmpDir'] = "company/";
/****************************/

$Config['DefaultLogo'] = $Config['Url'].'images/logo.png';
$Config['SiteLogoDir'] = "logo/";

$Config['SiteImageDir'] = "image/";
$Config['SiteIconDir'] = "icon/";
?>
