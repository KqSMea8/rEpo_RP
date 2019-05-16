<?  	 
    	require_once("../includes/config.php");
	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");
	require_once("../classes/region.class.php");
	#require_once("../classes/package.class.php");
	require_once("../classes/company.class.php");
	require_once("../classes/license.class.php");
	require_once("../classes/Suser.Class.php");
	require_once("../classes/reseller.class.php");
	require_once("../classes/commonsuper.class.php");
	require_once("../classes/help.class.php");
	require_once("../classes/newsarticle.class.php");
	require_once("../classes/industry.class.php");
	require_once("../classes/question.class.php");
	require_once("../classes/notification.class.php");
	$objConfig=new admin();	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
	

	CleanGet();

	(empty($_GET['Type']))?($_GET['Type']=""):("");
	(empty($_GET['editID']))?($_GET['editID']=""):("");
	(empty($_GET['Multiple']))?($_GET['Multiple']=""):("");

	/* Checking for AdminUsername existance */
	if(!empty($_GET['AdminUsername'])){ 
		$objAdmin = new admin();
		if($objAdmin->isAdminExists($_GET['AdminUsername'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	/* Checking for Company existance */
	if($_GET['Multiple'] == "1" && !empty($_GET['DisplayName'])){
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "2";
		}else{
			if(!empty($_GET['Email'])){ 
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
	if(!empty($_GET['DisplayName'])){ 
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Company Email existance */
	if($_GET['Type'] == "Company" && !empty($_GET['Email'])){
		$objCompany = new company();
		if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Package existance */
	/*if(!empty($_GET['Package'])){ 
		$objPackage=new package();
		if($objPackage->isPackageExists($_GET['Package'],$_GET['editID'],$_GET['CatID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}*/


 


	/* Checking for Country existance */
	if(!empty($_GET['Country'])){ 
		$objRegion=new region();
		if($objRegion->isCountryExists($_GET['Country'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for State existance */
	if(!empty($_GET['State']) && !empty($_GET['CountryID'])){
		$objRegion=new region();
		if($objRegion->isStateExists($_GET['State'],$_GET['CountryID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}	
			
		exit;

	}

	/* Checking for City existance */
	if(!empty($_GET['City']) && (!empty($_GET['StateID']) || !empty($_GET['CountryID']))){
	
		$objRegion=new region();

		if($_GET['editID']>0){ 
			if($objRegion->isCityExists($_GET['City'],$_GET['StateID'],$_GET['CountryID'],$_GET['editID'])){
				echo "1";
			}else{
				echo "0";
			}

		}else{ 
			echo $objRegion->isMultiCityExists($_GET['City'],$_GET['StateID'],$_GET['CountryID']);
		}
	
		
		exit;
	}

	/* Checking for ZipCode existance */
	if(!empty($_GET['ZipCode']) && !empty($_GET['CityID'])){
		
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
	if($_GET['Multiple'] == "1" && !empty($_GET['DomainName'])){
		$objLicense=new license();
		if($objLicense->isDomainExists($_GET['DomainName'],$_GET['editID'])){
			echo "1";
		}else{
			if(!empty($_GET['LicenseKey'])){
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
	if(!empty($_GET['DomainName'])){
		$objLicense=new license();
		if($objLicense->isDomainExists($_GET['DomainName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	
	/* Checking for Coupon Code existance */
	if(!empty($_GET['CouponCode'])){
		$objLicense=new license();
		if($objLicense->isCouponExists($_GET['CouponCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	


	/* Checking for Company User Email existance */
    	if($_GET['Type'] == "User" && !empty($_GET['uEmail'])){
		$objUser = new Suser();
		if($objUser->isEmailExit($_GET['uEmail'],$_GET['Uid']))
		{
	    		echo "1";
		}else{
	    		echo "0";
		}
		exit;
    	}


	/* Checking for Reseller Email existance */
	if($_GET['Type'] == "Reseller" && !empty($_GET['Email'])){
		$objReseller = new reseller();
		if($objReseller->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Tier Name existance */
	if(!empty($_GET['tierName'])){
		$objCommon=new common();
		if($objCommon->isTierNameExists($_GET['tierName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Tier Range existance */
	if(!empty($_GET['tierRangeFrom']) && !empty($_GET['tierRangeTo'])){
		$objCommon=new common();
		if($objCommon->isTierFromToExists($_GET['tierRangeFrom'],$_GET['tierRangeTo'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Tier Range existance */
	if(!empty($_GET['tierRangeFrom']) || !empty($_GET['tierRangeTo'])){
		$objCommon=new common();
		if($objCommon->isTierRangeExists($_GET['tierRangeFrom'],$_GET['tierRangeTo'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Commission Tier existance */
	if(!empty($_GET['CommissionTier'])){
		$objCommon=new common();
		if($objCommon->isCommissionTierExists($_GET['CommissionTier'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Spiff Tier Name existance */
	if(!empty($_GET['spiffTierName'])){
		$objCommon=new common();
		if($objCommon->isSpiffNameExists($_GET['spiffTierName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Spiff Sales Target existance */
	if(!empty($_GET['spiffSalesTarget'])){
		$objCommon=new common();
		if($objCommon->isSpiffTargetExists($_GET['spiffSalesTarget'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for termName existance */
	if(!empty($_GET['termName'])){
		$objCommon=new common();
		if($objCommon->isTermExists($_GET['termName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Attribute existance */
	if(!empty($_GET['AttributeValue'])){
		$objCommon=new common();
		if($objCommon->isAttributeExists($_GET['AttributeValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for CategoryName existance */
	if(!empty($_GET['CategoryName'])){
		$objHelp=new help();
		if($objHelp->isHelpCategoryExists($_GET['CategoryName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for CategoryName existance in News Article */
	
	if(!empty($_GET['NewsCategoryName'])){ 
		$objNews=new news();
		if($objNews->isNewsCategoryExists($_GET['NewsCategoryName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Heading existance in News */
	if(!empty($_GET['Heading'])){
		$objNews=new news();
		if($objNews->isNewsHeadingExists($_GET['Heading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Industry Name existance */
	if(!empty($_GET['IndustryName'])){ 
		$industry=new industry();
		if($industry->isIndustryNameExists($_GET['IndustryName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Question existance */
	if(!empty($_GET['Question'])){ 
		$questionObj=new question();
		if($questionObj->isQuestionExists($_GET['Question'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	if(!empty($_GET['Title'])){ 
		$objCommon=new common();
		if($objCommon->isFaqTitleExists($_GET['Title'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	if(!empty($_GET['NotificationHeading'])){
		$objNotification = new notification();
		if($objNotification->isNotificationHeadingExists($_GET['NotificationHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
?>
