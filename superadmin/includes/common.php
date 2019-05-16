<?
/*****Variable Define & Default Array for empty edit********/
/****************************/  
(empty($_GET['link']))?($_GET['link']=""):("");
(empty($_GET['rs']))?($_GET['rs']=""):("");
(empty($_GET['tab']))?($_GET['tab']=""):("");
(empty($_GET['mode']))?($_GET['mode']=""):("");
(empty($_GET['d']))?($_GET['d']=""):("");
(empty($_GET['cmp']))?($_GET['cmp']=""):("");
(empty($_GET['cat']))?($_GET['cat']=""):("");
(empty($_GET['CategoryID']))?($_GET['CategoryID']=""):("");
(empty($_GET['sc']))?($_GET['sc']=""):("");
(empty($HideModule))?($HideModule=""):("");
(empty($MainPrefix))?($MainPrefix=""):("");
(empty($ModuleName))?($ModuleName=""):("");
(empty($MainModuleName))?($MainModuleName=""):("");
(empty($CmpID))?($CmpID=""):("");
(empty($CategoryID))?($CategoryID=""):("");
(empty($Status))?($Status=""):("");

//echo $MainModuleID;		
 

if($EditPage==1 && empty($_GET['edit'])){
	switch ($MainModuleID) {	 	 	 
		case '7': 
			$arryLicense = $objConfigure->GetDefaultArrayValue('z_iocube_license_key'); 				break;
		case '8': 
			if(empty($arryPage)){
				$arryPage = $objConfigure->GetDefaultArrayValue('pages');
			}
			if(empty($arryeditTestimonial)){
				$arryeditTestimonial = $objConfigure->GetDefaultArrayValue('testimonial');
			}
			if(empty($arryeditFaq)){
				$arryeditFaq = $objConfigure->GetDefaultArrayValue('faq');
			}
			break;
		case '10': 
			$arryUser = $objConfigure->GetDefaultArrayValue('u_user'); 				break;
		case '16': 
			$arryCoupon = $objConfigure->GetDefaultArrayValue('coupons'); 				break;
		case '29': 
			if(empty($arryTier)){
				$arryTier = $objConfigure->GetDefaultArrayValue('r_tier');
			}
			if(empty($arryTerm)){
				$arryTerm = $objConfigure->GetDefaultArrayValue('r_term');
			}
					 	
			break;
		case '30': 
			$arryReseller = $objConfigure->GetDefaultArrayValue('reseller'); 				break;
		case '38': 
			if(empty($arryHelp)){
				$arryHelp = $objConfigure->GetDefaultArrayValue('help');
			}
			if(empty($arryHelpCategory)){
				$arryHelpCategory = $objConfigure->GetDefaultArrayValue('help_cat');
			}
			break;
		case '43': 
			$arryTemplate = $objConfigure->GetDefaultArrayValue('templates'); 				break;
		case '51': 
			if(empty($arryNewsCategory)){
				$arryNewsCategory = $objConfigure->GetDefaultArrayValue('news_cat');
			}
			$arryNews = $objConfigure->GetDefaultArrayValue('news');
			break;
		case '60': 
			if(empty($arryPage)){
				$arryPage = $objConfigure->GetDefaultArrayValue('pages');
			}			 
			break;
		case '65': 
			if(empty($arryCoupon)){
				$arryCoupon = $objConfigure->GetDefaultArrayValue('coupons');
			}			 
			break;
		case '73': 
			$arryeditIndustry = $objConfigure->GetDefaultArrayValue('industry_type'); 				break;	
		case '77': 
			$arryNotification = $objConfigure->GetDefaultArrayValue('notifications'); 				break;	
		 	
	}
	 
}

/****************************/
/****************************/

?>
