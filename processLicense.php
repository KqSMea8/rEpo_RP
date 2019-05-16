<?php 
	ini_set("display_errors","1"); error_reporting(5);	
	require_once("includes/function.php"); 
	
	/**************************/
	require_once("includes/config.php");	
	require_once("classes/dbClass.php");	
	require_once("classes/company.class.php");
	require_once("classes/admin.class.php");
	$objCompany = new company();
	$objConfig=new admin();	
	CleanGet(); 


	$XmlContent = $_POST['xmldata'];
	$arryXml = xml2array($XmlContent);
	$DomainName = $arryXml['licensedetail']['domain']['value'];
	$ValidateLicense = $arryXml['licensedetail']['validatelicense']['value'];
	$LicenseKey = $arryXml['licensedetail']['licensekey']['value'];

	/* Checking for DomainName/LicenseKey existance */
	if(!empty($DomainName)){	
		$RetunVal = $objCompany->isLicenseKey($DomainName,$ValidateLicense,$LicenseKey);
	
		echo $RetunVal;

		exit;
	}

?>
