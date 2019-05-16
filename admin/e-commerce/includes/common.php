<?
/*****Variable Define & Default Array for empty edit********/
$Config['SaUrl'] = 'https://sa.eznetcrm.com/erp/';
 

(!isset($_GET['attID']))?($_GET['attID']=""):("");
(!isset($_GET['disID']))?($_GET['disID']=""):("");
(!isset($_GET['marketplace']))?($_GET['marketplace']=""):("");
(!isset($_GET['CatID']))?($_GET['CatID']=""):("");
(!isset($_GET['MemberID']))?($_GET['MemberID']=""):("");
(!isset($_GET['ProductID']))?($_GET['ProductID']=""):("");
(!isset($_GET['ProductSku']))?($_GET['ProductSku']=""):("");
(!isset($_GET['ProductID']))?($_GET['ProductID']=""):("");
(!isset($_GET['ProductSku']))?($_GET['ProductSku']=""):("");
(!isset($_GET['featured']))?($_GET['featured']=""):("");
(!isset($_GET['del_alias']))?($_GET['del_alias']=""):("");
(!isset($_GET['ParentID']))?($_GET['ParentID']=""):("");
(!isset($_GET['synctype']))?($_GET['synctype']=""):("");
(!isset($_GET['module']))?($_GET['module']=""):("");
(!isset($_GET['status']))?($_GET['status']=""):("");
(!isset($_GET['promoID']))?($_GET['promoID']=""):("");
(!isset($_GET['AmazonAcc_id']))?($_GET['AmazonAcc_id']=""):("");
(!isset($_GET['AmazonAcc']))?($_GET['AmazonAcc']=""):("");
(!isset($_GET['sync_ebay']))?($_GET['sync_ebay']=""):("");
(!isset($_GET['s2']))?($_GET['s2']=""):("");
(!isset($_GET['ItemCondition']))?($_GET['ItemCondition']=""):("");
(!isset($_GET['QuantityFrom']))?($_GET['QuantityFrom']=""):("");
(!isset($_GET['QuantityTo']))?($_GET['QuantityTo']=""):("");
(!isset($_GET['PriceFrom']))?($_GET['PriceFrom']=""):("");
(!isset($_GET['PriceTo']))?($_GET['PriceTo']=""):("");
(!isset($_GET['AliasID']))?($_GET['AliasID']=""):("");
(!isset($_GET['RowColor']))?($_GET['RowColor']=""):("");

(!isset($categoryIdGetPost))?($categoryIdGetPost=""):("");
(!isset($colRule))?($colRule=""):("");
(!isset($columnname))?($columnname=""):("");
(!isset($CountryName))?($CountryName=""):("");
(!isset($StateName))?($StateName=""):("");
(!isset($CityName))?($CityName=""):("");
(!isset($Mid))?($Mid=""):("");
(!isset($cat_title))?($cat_title=""):("");
(!isset($status))?($status=""):("");
(!isset($id))?($id=""):("");
(!isset($ParentID))?($ParentID=""):("");
(!isset($productStatus))?($productStatus=""):("");
(!isset($disNone))?($disNone=""):("");
(!isset($ShowEmp))?($ShowEmp=""):("");
(!isset($ParentCategory))?($ParentCategory=""):("");
(!isset($MainParentCategory))?($MainParentCategory=""):("");
(!isset($NumLanguages))?($NumLanguages=""):("");
(!isset($PrefixPO))?($PrefixPO=""):("");
(!isset($ModuleID555))?($ModuleID555=""):("");
(!isset($MainModuleName))?($MainModuleName=""):("");
(!isset($TemplateStatus))?($TemplateStatus=""):("");
(!isset($CartSettingId))?($CartSettingId=""):("");
(!isset($DisabledButton))?($DisabledButton=""):("");
(!isset($mid))?($mid=""):("");
(!isset($irts))?($irts=""):("");

(!isset($Config['Junk']))?($Config['Junk']=""):("");


 
/****************************/

#echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){
	switch ($MainModuleID) {
		
		case('211'):  
				$arryProduct = $objConfigure->GetDefaultArrayValue('e_products'); 
				break;
		case('212'):  
				$arryCategory = $objConfigure->GetDefaultArrayValue('e_categories'); 
				break;

		case('213'):  
				$arryManufacturer = $objConfigure->GetDefaultArrayValue('e_manufacturers'); 
				break;

		case('221'):  
				$arryAttributes = $objConfigure->GetDefaultArrayValue('e_global_attributes'); 
				#$arrayOptionList = $objConfigure->GetDefaultArrayValue('e_global_optionList'); 
				break;

	
		case('216'):  
				$arryShipping = $objConfigure->GetDefaultArrayValue('e_shipping_selected'); 
				
				break;

		case('217'):  
				$arryTax = $objConfigure->GetDefaultArrayValue('e_tax_rates'); 
				break;
		case('218'):  
				$arryTaxClass = $objConfigure->GetDefaultArrayValue('e_tax_classes'); 
				break;

		case('232'):  
				$arrayCoupon = $objConfigure->GetDefaultArrayValue('e_promo_codes'); 
				break;

		case('226'):  
				$arryNewsletterTemplate = $objConfigure->GetDefaultArrayValue('e_newsletter_template'); 
				break;

		case('228'):  
				$arryPage = $objConfigure->GetDefaultArrayValue('e_pages'); 
				break;

		case('3021'):  
				$arrySocial = $objConfigure->GetDefaultArrayValue('e_social_links'); 
				break;

		case('3029'):  
				$arrySlider = $objConfigure->GetDefaultArrayValue('e_slider_banner'); 
				
				break;
		 
		
	}
		}
?>
