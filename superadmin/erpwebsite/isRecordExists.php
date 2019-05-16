<?php
    require_once("../../includes/config.php");
	require_once("../../includes/function.php");
        
	require_once("../../classes/erp.dbClass.php");
	require_once("../../classes/erp.admin.class.php");
        require_once("../../classes/erp.Suser.Class.php");
        
	require_once("../../classes/region.class.php");
	require_once("../../classes/faq.class.php");
	#require_once("../classes/package.class.php");
	require_once("../../classes/company.class.php");
	require_once("../../classes/license.class.php");
	
	$objConfig=new admin();	

	CleanGet();
	/* Checking for keyword existance */
	if($_GET['AdminUsername'] != ""){
		$objAdmin = new admin();
		if($objAdmin->isAdminExists($_GET['AdminUsername'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	/* Checking for Company existance */
	if($_GET['Multiple'] == "1" && $_GET['DisplayName'] != ""){
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "2";
		}else{
			if($_GET['Email'] != ""){
				if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}

	/* Checking for Company existance */
	if($_GET['DisplayName'] != ""){

		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Company Email existance */
	if($_GET['Type'] == "Company" && $_GET['Email'] != ""){
		$objCompany = new company();
		if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Package existance */
	/*if($_GET['Package'] != ""){
		$objPackage=new package();
		if($objPackage->isPackageExists($_GET['Package'],$_GET['editID'],$_GET['CatID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}*/


	/* Checking for FAQs existance */
	if($_GET['Question'] != ""){
		$objFaq = new faq();
		if($objFaq->isFaqExists($_GET['Question'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Country existance */
	if($_GET['Country'] != ""){
		$objRegion=new region();
		if($objRegion->isCountryExists($_GET['Country'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for State existance */
	if($_GET['State'] != "" && $_GET['CountryID']>0){
		$objRegion=new region();
		if($objRegion->isStateExists($_GET['State'],$_GET['CountryID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}	
			
		exit;

	}

	/* Checking for City existance */
	if($_GET['City'] != "" && $_GET['StateID']>0){
		
		$objRegion=new region();
		if($objRegion->isCityExists($_GET['City'],$_GET['StateID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}

	/* Checking for ZipCode existance */
	if($_GET['ZipCode'] != "" && $_GET['CityID']>0){
		
		$objRegion=new region();
		if($_GET['editID']>0){
			if($objRegion->isZipCodeExists($_GET['ZipCode'],$_GET['CityID'],$_GET['editID'])){
				echo "1";
			}else{
				echo "0";
			}

		}else{
			echo $objRegion->isMultiZipCodeExists($_GET['ZipCode'],$_GET['CityID']);
		}
		
		exit;
	}

	/**************************/
		/* Checking for DomainName existance */
	if($_GET['Multiple'] == "1" && $_GET['DomainName'] != ""){
		$objLicense=new license();
		if($objLicense->isDomainExists($_GET['DomainName'],$_GET['editID'])){
			echo "1";
		}else{
			if($_GET['LicenseKey'] != ""){
				if($objLicense->isLicenseKeyExists($_GET['LicenseKey'],$_GET['editID'])){
					echo "2";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}

	/* Checking for DomainName existance */
	if($_GET['DomainName'] != ""){
		$objLicense=new license();
		if($objLicense->isDomainExists($_GET['DomainName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	
		/* Checking for Coupon Code existance */
		if($_GET['CouponCode'] != ""){
		$objLicense=new license();
		if($objLicense->isCouponExists($_GET['CouponCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	


	
    if($_GET['Type'] == "User" && $_GET['uEmail'] != ""){
        $objUser = new Suser();
        
        if($objUser->isEmailExit($_GET['uEmail'],$_GET['Uid']))
        {
            echo "1";
        }else{
            echo "0";
        }
        exit;
    }


?>
