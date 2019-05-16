<?php	session_start();
$Prefix = "../";
require_once($Prefix."includes/config.php");
require_once($Prefix."includes/function.php");
require_once($Prefix."classes/dbClass.php");
require_once($Prefix."classes/company.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/admin.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/MyMailer.php");
require_once("language/english.php");

require_once($Prefix."classes/sales.class.php");
require_once($Prefix."classes/inv_tax.class.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix."classes/bom.class.php");
require_once($Prefix."classes/variant.class.php");
require_once($Prefix."classes/pager.cls.php");  //By Chetan 18Sep//
require_once($Prefix."classes/warehouse.shipment.class.php");



if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}


$objCommon = new common();
$objConfig=new admin();
/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
$objCompany=new company();
$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);
$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
$Config['AdminEmail'] = $arryCompany[0]['Email'];
$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';

CleanGet();

switch($_GET['action']){



	case 'delete_file':
		if($_GET['file_path']!=''){
			unlink($_GET['file_path']);
			echo "1";
		}else{
			echo "0";
		}
		break;
		exit;
	case 'currency':
		$objRegion=new region();
		$arryCurrency = $objRegion->getCurrency($_GET['currency_id'],'');
		echo $StoreCurrency = $arryCurrency[0]['symbol_left'].$arryCurrency[0]['symbol_right'];
		break;
		exit;

	case 'state':
		$objRegion=new region();
		 
		$arryState = $objRegion->getStateByCountry($_GET['country_id']);
			
		$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';

		if($_GET['select']==1){
			$AjaxHtml  .= '<option value="">--- Select ---</option>';
		}

		$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);

		for($i=0;$i<sizeof($arryState);$i++) {

			$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
				
			$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
				
		}

		$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
		if($_GET['other']==1){
			$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
		}else if(sizeof($arryState)<=0){
			$AjaxHtml  .= '<option value="">No state found.</option>';
		}

		$AjaxHtml  .= '</select>';
			
			

		$AjaxHtml  .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="'.$StateSelected.'">';
			
		break;
			
			
	case 'city':
		$objRegion=new region();
		$arryCity = $objRegion->getCityByState($_GET['state_id']);

		$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';

		if($_GET['select']==1){
			$AjaxHtml  .= '<option value="">--- Select ---</option>';
		}


		$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);

		for($i=0;$i<sizeof($arryCity);$i++) {

			$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");
				
			$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.htmlentities($arryCity[$i]['name'], ENT_IGNORE).'</option>';
				
		}

		$Selected = ($_GET['current_city'] == '0')?(" Selected"):("");
		if($_GET['other']==1){
			$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
		}else if(sizeof($arryCity)<=0){
			$AjaxHtml  .= '<option value="">No city found.</option>';
		}

		$AjaxHtml  .= '</select>';
			

		$AjaxHtml  .= '<input type="hidden" name="ajax_city_id" id="ajax_city_id" value="'.$CitySelected.'">';
			
		break;

			
	case 'shippingstate':
		$objRegion=new region();
		if ($_GET['country_id'] == "0")
		{
			$AjaxHtml  = '<select name="State" id="state_id"  onclick="Javascript: GetStateId();" class="multiselect" multiple size="7">';

			$AjaxHtml  .= '<option value="0">All States</option>';

			$AjaxHtml  .= '</select>';
		}
		else
		{
			$arryState = $objRegion->getStateByCountry($_GET['country_id']);

			$AjaxHtml  = '<select name="State" id="state_id" class="multiselect" multiple size="7"  onclick="Javascript: GetStateId();">';

			if($_GET['select']==1){
				$AjaxHtml  .= '<option value="0">All States</option>';
			}

			$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);

			for($i=0;$i<sizeof($arryState);$i++) {

				$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
					
				$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
			}

			$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
			if($_GET['other']==1){
				$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
			}else if(sizeof($arryState)<=0){
				$AjaxHtml  .= '<option value="">No state found.</option>';
			}

			$AjaxHtml  .= '</select>';
		}
			

			
			
		break;

		 

	case 'taxstate':
		$objRegion=new region();

		$arryState = $objRegion->getStateByCountry($_GET['country_id']);
			
		$AjaxHtml  = '<select name="State" id="state_id" class="inputbox"   onclick="Javascript: SetMainStateId();">';

		if($_GET['select']==1){
			$AjaxHtml  .= '<option value="0">All States</option>';
		}

		$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);

		for($i=0;$i<sizeof($arryState);$i++) {

			$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
				
			$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
				
		}

		$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
		if($_GET['other']==1){
			$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
		}else if(sizeof($arryState)<=0){
			$AjaxHtml  .= '<option value="">No state found.</option>';
		}

		$AjaxHtml  .= '</select>';

			
		break;


	case 'TaxRateAddress':
		if(!empty($_GET["Country"])){
			$objRegion=new region();
			$arryCountry = $objRegion->GetCountryID($_GET["Country"]);
			$country_id = $arryCountry[0]['country_id']; //set
			if($country_id>0 && !empty($_GET["State"])){
				$arryState = $objRegion->GetStateID($_GET["State"], $country_id);
				$state_id = $arryState[0]['state_id'];//set
			}
		}
		#echo $country_id.' : '.$state_id;exit;
		break;

	case 'zipSearch':
		$objRegion=new region();
		if(!empty($_GET['city_id'])){
			$arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
			for($i=0;$i<sizeof($arryZipcode);$i++) {
				$AjaxHtml .= '<li onclick="set_zip(\''.stripslashes($arryZipcode[$i]['zip_code']).'\')">'.stripslashes($arryZipcode[$i]['zip_code']).'</li>';
			}

		}
		break;

			
}

if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/



switch($_GET['action']){


	case 'ItemInfo':
		$objItem=new items();
		$_GET['Status'] = 1;
		$arryProduct=$objItem->GetItemsView($_GET);


		if($_GET['proc']=='Purchase'){
			$arryProduct[0]['price'] = $arryProduct[0]['purchase_cost'];
		}else if($_GET['proc']=='Sale'){
			$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
			$arryProduct[0]['purchasePrice'] = $arryProduct[0]['purchase_cost'];
		}else{
			$arryProduct[0]['price'] = 0;
		}


		$arryRequired = $objItem->GetRequiredItem($_GET['ItemID'],'');
		$NumRequiredItem = sizeof($arryRequired);

		//Get Kit Item15Sep
		//$arryKit = $objItem->GetKitItem($_GET['ItemID']);
		// $NumKiItem = sizeof($arryKit);


		//Get Option Code Item Item
		/*if($_GET['optionID'] > 0){
		 $arryOptionCodeItem = $objItem->GetOptionCodeItem($_GET['optionID']);
		 $NumOptionCodeItem = sizeof($arryOptionCodeItem);

		 }*/

		/*By Chetan31Aug*/
		if($_GET['optionID']){
			$optionIDs = json_decode(stripslashes($_GET['optionID']));
			$arryOptionCodeItem = array();
			foreach($optionIDs as $optionID)
			{
				if($optionID > 0)
				{
					$arryOptionCodeItem = $objItem->GetOptionCodeItem($optionID);
					$arryKit = $arryOptionCodeItem;  //By chetan 15Sep//
					$NumKiItem = sizeof($arryOptionCodeItem);//By chetan 15Sep//
					//$NumOptionCodeItem = sizeof($arryOptionCodeItem);
				}
			}
		}else{
			$arryKit = $objItem->GetKitItem($_GET['ItemID']);
			$NumKiItem = sizeof($arryKit);
		}
		/**End**/
		/************ARRAy MERGE****************************************************************************/
		/***********************Variant********************************************/


		/************Amit Singh***27nov2015*****************edited 1Dec2015**/
		if($_SESSION['TrackVariant']==1){
			$arryProductAttributes = $objItem->GetProductAttributesForFront($arryProduct[0]['ItemID']);
			if (!empty($arryProductAttributes)) {

				//$options = array();
				$var=0;
				foreach ($arryProductAttributes as $key => $attribute) {
					//
					$requiredhtml=($attribute['required']==1)? '<span class="red">*</span>':'';
					if($attribute['gaid']!=0) {
						$options = $objItem->GetOptionListForList($attribute['gaid'],0);

					}else {
						$options = $objItem->GetOptionListForList($attribute['gaid'],$attribute['paid']);

					}
					//else $options = $objProduct->parseOptions($attribute['options']);
					$html.='<div class="row" style="margin-bottom:10px;"><div >'.stripslashes($attribute['caption']).'</div>';
					$html.='<div>';
					if ($attribute['attribute_type'] == "select") {
						$html.='<input type="hidden" readonly="readonly" name="requireattr[]" id="requireattr'.$var.'" value="'.$attribute['required'].'">';
						$html.='<input type="hidden" readonly="readonly" name="compulsoryattr[]" id="compulsoryattr'.$var.'" value="'.$attribute['paid'].'">';
						$html.=' <select id="attribute_input_'.$attribute['paid'].'" name="oa_attributes'.$_GET['SelID'].'['.$attribute['paid'].']" class="textbox"  style="width:110px" onchange="calcAttrPrice(this.value,'.$_GET['SelID'].')">';

						$html.='<option value="">Select</option>';
						foreach ($options as $option) {
							$html.='<option value="'. $option['Id'].'">'.$option['title'].'</option>';

						}
						$html.=' </select>';
					}
					$html.='</div></div>';
					$var++;
				}
			}else{
				$html = '';
			}

		}else{
			$html = '';
		}//Amit End code
		/***************END VARIANT ******************************/
		/*By Chetan 25Aug*/
		if($NumRequiredItem > 0 && ($NumKiItem > 0 && $_GET['showcompo']== 1 && $arryProduct[0]['itemType']!='' && $arryProduct[0]['itemType'] == 'Kit')){
			$RequiredItemAndKitItemArry = array_merge($arryRequired,$arryKit);
		}else if($NumKiItem > 0 && $_GET['showcompo']== 1 && $arryProduct[0]['itemType']!='' && $arryProduct[0]['itemType'] == 'Kit'){
			$RequiredItemAndKitItemArry = $arryKit;
		}else{
			$RequiredItemAndKitItemArry = $arryRequired;
		}
		/**End**/
		/**comment in 17 june2015 **/
		/*if($NumRequiredItem > 0 && $NumKiItem > 0 && empty($_GET['optionID'])){
		 $RequiredItemAndKitItemArry = array_merge($arryRequired,$arryKit);
		 }else if($NumKiItem > 0 && empty($_GET['optionID'])){
		 $RequiredItemAndKitItemArry = $arryKit;
		 }else{
		 $RequiredItemAndKitItemArry = $arryRequired;
		 }*/


		//Merge Option Item

		/*if($NumOptionCodeItem > 0){
		 $RequiredItemAndKitItemArry = array_merge($RequiredItemAndKitItemArry,$arryOptionCodeItem);
		 $NumRequiredItem = intval($NumRequiredItem + $NumOptionCodeItem);
		 }*/



		$arrUniqueVal = array();
		if(sizeof($RequiredItemAndKitItemArry) > 0){

			for($i=0;$i<sizeof($RequiredItemAndKitItemArry);$i++) {
				 
				 
				$arrUniqueVal["Row_".$RequiredItemAndKitItemArry[$i]['sku']] = $RequiredItemAndKitItemArry[$i];
				 
				/*for ($j = $i + 1; $j < sizeof($RequiredItemAndKitItemArry); $j++) {
				  
				if ($RequiredItemAndKitItemArry[$i]['sku'] != "") {
				if ($RequiredItemAndKitItemArry[$i]['sku'] == $RequiredItemAndKitItemArry[$j]['sku']) {
				 
				unset($RequiredItemAndKitItemArry[$i]);
				 
				}

				}

				}*/
				/*if($RequiredItemAndKitItemArry[$i]['sku']!= "") {
				 print_r(array_keys($RequiredItemAndKitItemArry, $RequiredItemAndKitItemArry[$i]));
				 }*/
			}


		}
		 

		 
		$RequiredItem = '';
		if(sizeof($arrUniqueVal)>0){
			foreach($arrUniqueVal as $key=>$values){
				$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.stripslashes($values["sell_price"]).'#';
			}
			$RequiredItem = rtrim($RequiredItem,"#");
			$NumRequiredItem = sizeof($arrUniqueVal);//By Chetan 16/6/15
		}

		 
		/*By Chetan22Sep
		 $arryAlias = $objItem->GetAliasbyItemID($arryProduct[0]['ItemID']);
		 $NumAlias = sizeof($arryAlias);

		 foreach($arryAlias as $alias)
		 {
		 $AliasRequiredItem = "";
		 $AliasRequiredItem .= stripslashes($alias["item_id"]).'|'.stripslashes($alias['ItemAliasCode']).'|'.stripslashes($alias["description"]).'|'.stripslashes($arryProduct[0]["qty"]).'|'.stripslashes($arryProduct[0]["qty_on_hand"]).'#';
		 $NumRequiredItem = intval($NumRequiredItem + 1);
		 $resarr = $objItem->getAliasRequiredItemByIds($arryProduct[0]['ItemID'],$alias['AliasID']);
		 if(count($resarr))
		 {
		 foreach($resarr as $key=>$values){
		 $AliasRequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
		 $NumRequiredItem = intval($NumRequiredItem + 1);
		 }
		 }
		 $AliasRequiredItem = rtrim($AliasRequiredItem,"#");
		 $RequiredItem .=  ($RequiredItem)? '#'.$AliasRequiredItem : $AliasRequiredItem; //By Chetan 28Aug//
		 }
		 /*--End--*/
		 
		/********************************************************************************/

		 

		$arryProduct[0]['RequiredItem'] = $RequiredItem;
		$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
		$arryProduct[0]['variantDisplay'] = $html;

		echo json_encode($arryProduct[0]);exit;

		break;
		exit;

		//Updated by Chetan 3Feb Add functionailty for alias also to get Qty//
	case 'getItemCondionQty':
		$objItem=new items();
		if($_GET['Condi']!=''){
			$exist=$objItem->checkItemSku($_GET['Sku']);
			if(!empty($exist))
			{
				$arryProduct=$objItem->getItemCondionQty($_GET['Sku'],$_GET['Condi']);
			}else{
				$ArrDetail = $objItem->checkItemAliasSku($_GET['Sku']);
				$arryProduct=$objItem->getItemCondionQty($ArrDetail[0]['sku'],$_GET['Condi']);
			}
			if($arryProduct[0]['condition_qty']!=''){
				$desProduct[0]['condition_qty']=$arryProduct[0]['condition_qty'];
			}else {$desProduct[0]['condition_qty']='0';}
			if(!empty($exist))
			{
				$cost = $objItem->getAvgCostsofPurOrderbyID($_GET['Sku'],$_GET['Condi']);
			}else{
				$ArrDetail = $objItem->checkItemAliasSku($_GET['Sku']);
				$cost = $objItem->getAvgCostsofPurOrderbyID($ArrDetail[0]['sku'],$_GET['Condi']);
			}
			//$cost = $objItem->getAvgCostsofPurOrderbyID($_GET['Sku'],$_GET['Condi']);
			$desProduct[0]['AvgCost'] = (!empty($cost[0]['avgPrice'])) ? $cost[0]['avgPrice']:'';
		}else{
			$arryProduct=$objItem->checkItemSku($_GET['Sku']);
			$desProduct[0]['condition_qty']=$arryProduct[0]['qty_on_hand'];
		}


		echo json_encode($desProduct[0]);exit;

		break;
		exit;
		 
		// By Rajan 16 feb
	case 'SearchSalesCode':
		$objItem=new items();
		$arryProduct=$objItem->checkItemSku($_GET['key']);


		echo json_encode($arryProduct[0]);exit;

		break;
		exit;

		//end

		/**************** BY Rajan 03 feb 2016*********************/
	case 'ItemAllInfo':
		$objItem=new items();
		$_GET['Status'] = 1;
		$arryProduct=$objItem->GetItemsView($_GET);
		if($_GET['proc']=='Purchase'){
			$arryProduct[0]['price'] = $arryProduct[0]['purchase_cost'];
		}else if($_GET['proc']=='Sale'){
			$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
		}else{
			$arryProduct[0]['price'] = 0;
		}


		$arryRequired = $objItem->GetRequiredItem($_GET['ItemID'],'');
		$NumRequiredItem = sizeof($arryRequired);
		 
		$RequiredItem = '';
		if(sizeof($arrUniqueVal)>0){
			foreach($arrUniqueVal as $key=>$values){
				$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
			}
			$RequiredItem = rtrim($RequiredItem,"#");
		}

		 
		 

		$arryProduct[0]['RequiredItem'] = $RequiredItem;
		$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;

		echo json_encode($arryProduct[0]);exit;

		break;
		exit;

			
		/****************** End Rajan 03 feb 2016****************************************/






		 
	case 'CustomerInfo':
		$objCustomer = new Customer();
		$arryCustomer = $objCustomer->GetCustomerAllInformation('',$_GET['CustCode'],'');
		$arryContact = $objCustomer->GetCustomerShippingContact($_GET['CustId']);
		if($arryCustomer[0]['CustomerName']!=''){
			$arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerName'];
		}else{
			$arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerCompany'];
		}


		$shipList='<select name="shipto" id="shipto"  class="inputbox" onchange="ChangeShipaddress(this.value,\''.$_GET['CustId'].'\')">';

		for($count=0;$count<count($arryContact);$count++){
			//$address=$arryContact[$count]['FullName'].',';
			// if($arryContact[$count]['Address']!='') $address .=$arryContact[$count]['Address'].',';
			//if($arryContact[$count]['CityName']!='') $address .=$arryContact[$count]['CityName'].',';
			//if($arryContact[$count]['StateName']!='') $address .=$arryContact[$count]['StateName'].',';
			//if($arryContact[$count]['CountryName']!='') $address .=$arryContact[$count]['CountryName'].',';
			$shipList .='<option value="'.$arryContact[$count]['AddID'].'">'.$arryContact[$count]['Company'].'</option>';
		}

		$shipList .='</select>';
		$arryCustomer[0]['shipList']=$shipList;


		echo json_encode($arryCustomer[0]);exit;

		break;
		exit;


	case 'CustomerName':
		$objCustomer = new Customer();
		$arryCustomer = $objCustomer->GetCustomerAllInformation('',$_GET['CustName'],'');
		$arryContact = $objCustomer->GetCustomerShippingContact($arryCustomer[0]['Cid']);
		if($arryCustomer[0]['CustomerName']!=''){
			$arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerName'];
		}else{
			$arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerCompany'];
		}


		$shipList='<select name="shipto" id="shipto"  class="inputbox" onchange="ChangeShipaddress(this.value,\''.$_GET['CustId'].'\')">';

		for($count=0;$count<count($arryContact);$count++){
			//$address=$arryContact[$count]['FullName'].',';
			// if($arryContact[$count]['Address']!='') $address .=$arryContact[$count]['Address'].',';
			//if($arryContact[$count]['CityName']!='') $address .=$arryContact[$count]['CityName'].',';
			//if($arryContact[$count]['StateName']!='') $address .=$arryContact[$count]['StateName'].',';
			//if($arryContact[$count]['CountryName']!='') $address .=$arryContact[$count]['CountryName'].',';
			$shipList .='<option value="'.$arryContact[$count]['AddID'].'">'.$arryContact[$count]['Company'].'</option>';
		}

		$shipList .='</select>';
		$arryCustomer[0]['shipList']=$shipList;


		echo json_encode($arryCustomer[0]);exit;

		break;
		exit;

	case 'shippAddress':

		$objCustomer = new Customer();
		$arryContact = $objCustomer->GetCustomerShippingContact($_GET['CustID'],$_GET['ShipId']);

		$arr = array_map('utf8_encode', $arryContact[0]);
		echo json_encode($arr);

		break;
		exit;

	case 'CustomerAddress':
		$objCustomer = new Customer();
		$arryCustomer = $objCustomer->GetCustomerAddressBook($_GET['CustID'],$_GET['AddID']);
		echo json_encode($arryCustomer[0]);exit;

		break;
		exit;



		/*case 'CustomerBillingInfo':
			$objCustomer = new Customer();
			$arryCustomer = $objCustomer->GetCustomerBilling($_GET['CustId']);
			echo json_encode($arryCustomer[0]);exit;

			break;
			exit;*/
		
	case 'CustomerShippingInfo':
		$objCustomer = new Customer();
		$arryCustomer = $objCustomer->GetCustomerShipping($_GET['CustId']);
		echo json_encode($arryCustomer[0]);exit;

		break;
		exit;

	case 'checkSpiffSetting':
		$arrySpiffSettings = $objCommon->getSpiffSettings();
		if($arrySpiffSettings[0]['GLAccountTo'] > 0 && $arrySpiffSettings[0]['GLAccountFrom'] > 0 && !empty($arrySpiffSettings[0]['PaymentMethod'])){
			echo 1;exit;
		}else{
			echo 0;exit;
		}
			

		break;
		exit;

	case 'TaxRateAddress':
		if(!empty($country_id)){
			$objTax=new tax();
			$arrySaleTax = $objTax->GetTaxByLocation(1,$country_id,$state_id);
			if(sizeof($arrySaleTax)>0){

				$arrRate = explode(":",$_GET['OldTaxRate']);

				$AjaxHtml = '<select name="TaxRate" id="TaxRate" class="inputbox" onchange="Javascript: freightSett(this.value);" onclick="Javascript: ProcessTotal();"><option value="0">None</option>';
				for($i=0;$i<sizeof($arrySaleTax);$i++) {

					$Selected = ($arrRate[0] == $arrySaleTax[$i]['RateId'] && $arrRate[2] == $arrySaleTax[$i]['TaxRate'])?(" Selected"):("");

					$AjaxHtml .= "<option ".$Selected." value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['RateDescription'].":".$arrySaleTax[$i]['TaxRate']."' >
					".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."%</option>";
				}
				$AjaxHtml .= '</select>';
			}

		}

		break;



	case 'FreightTaxSet':
		$objTax=new tax();
		//if($_GET['taxid']){
		$arrySaleTax = $objTax->getTaxById($_GET['taxidval']);
		//}
		echo json_encode($arrySaleTax[0]);

		break;


	case 'SearchQuoteCode':
		$objItem=new items();
		$arryProduct=$objItem->checkItemSku($_GET['key']);

		//By Chetan 9sep//
		if(empty($arryProduct))
		{
			$arryAlias = $objItem->checkItemAliasSku($_GET['key']);

			#print_r($arryAlias); exit;
			if(count($arryAlias))
			{
				$alias = 1;
				$arryProduct=$objItem->GetItemById($arryAlias[0]["ItemID"]);
				$arryProduct[0]['Sku'] = $arryAlias[0]['ItemAliasCode'];
				$arryProduct[0]['description'] = $arryAlias[0]['description'];
				//$arryProduct[0]['evaluationType'] = $arryAlias[0]['evaluationType'];
			}
		}
		//End//
		$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
		$arryProduct[0]['purchasePrice'] = $arryProduct[0]['sell_price'];

		//By Chetan 9sep//
		if(!isset($alias))
		{
			$arryRequired = $objItem->GetRequiredItem($arryProduct[0]['ItemID'],'');
			$NumRequiredItem = sizeof($arryRequired);
			$RequiredItem = '';
			if($NumRequiredItem>0){
				foreach($arryRequired as $key=>$values){
					$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.stripslashes($values["sell_price"]).'#';
				}
				$RequiredItem = rtrim($RequiredItem,"#");
			}
		}else{

			$arryRequired = $objItem->getAliasRequiredItemByIds($arryProduct[0]['ItemID'],$arryAlias[0]['AliasID']);
			$NumRequiredItem = sizeof($arryRequired);
			$RequiredItem = '';
			if($NumRequiredItem>0){
				foreach($arryRequired as $key=>$values){
					$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.stripslashes($values["sell_price"]).'#';
				}
				$RequiredItem = rtrim($RequiredItem,"#");
			}
		}
		//End//
		/***********************Variant********************************************/

		/************Amit Singh***27nov2015*******************edited 1Dec2015****/
		if($_SESSION['TrackVariant']==1){
			$arryProductAttributes = $objItem->GetProductAttributesForFront($arryProduct[0]['ItemID']);
			if (!empty($arryProductAttributes)) {

				//$options = array();
				$var=0;
				foreach ($arryProductAttributes as $key => $attribute) {
					//
					$requiredhtml=($attribute['required']==1)? '<span class="red">*</span>':'';
					if($attribute['gaid']!=0) {
						$options = $objItem->GetOptionListForList($attribute['gaid'],0);

					}else {
						$options = $objItem->GetOptionListForList($attribute['gaid'],$attribute['paid']);

					}
					//else $options = $objProduct->parseOptions($attribute['options']);

					$html.='<div class="row" style="margin-bottom:10px;"><div >'.stripslashes($attribute['caption']).'</div>';
					$html.='<div>';
					if ($attribute['attribute_type'] == "select") {
						$html.='<input type="hidden" readonly="readonly" name="requireattr[]" id="requireattr'.$var.'" value="'.$attribute['required'].'">';
						$html.='<input type="hidden" readonly="readonly" name="compulsoryattr[]" id="compulsoryattr'.$var.'" value="'.$attribute['paid'].'">';
						$html.=' <select id="attribute_input_'.$attribute['paid'].'" name="oa_attributes'.$_GET['SelID'].'['.$attribute['paid'].']" class="textbox"  style="width:110px" onchange="calcAttrPrice(this.value,'.$_GET['SelID'].')">';

						$html.='<option value="">Select</option>';
						foreach ($options as $option) {
							$html.='<option value="'. $option['Id'].'">'.$option['title'].'</option>';

						}
						$html.=' </select>';
					}
					$html.='</div></div>';
					$var++;
				}
			}else{
				$html = '';
			}
		}else{
			$html = '';
		}//Amit End code
		/***************END VARIANT ******************************/


		$arryProduct[0]['RequiredItem'] = $RequiredItem;
		$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
		$arryProduct[0]['variantDisplay'] = $html;

		//By Chetan 22sep//
		if(!isset($alias))
		{
			$arryOption = $objItem->getOptionCode($arryProduct[0]["ItemID"]);
			if(count($arryOption) > 0 && $arryProduct[0]["itemType"] == 'Kit'){

				$arryProduct[0]['showPopUp'] = 'y';
			}

			if($NumRequiredItem > 0){
				$RequiredItemIdsOnly = array_map(function($arr){return $arr['item_id'];},$arryRequired);
				$arryProduct[0]['ReqItemIDs'] = implode("#",$RequiredItemIdsOnly);
			}else{
				$arryProduct[0]['ReqItemIDs'] = '';
			}

			$arryKit = $objItem->GetKitItem($arryProduct[0]["ItemID"]);
			if(count($arryKit)>0){
				foreach($arryKit as $key=>$values){
					$KitItems .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.stripslashes($values["sell_price"]).'#';
				}
				$KitItems = rtrim($KitItems,"#");
			}

			$arryProduct[0]['KitItemsCount'] = (count($arryKit)) ? count($arryKit) : '0';
			$arryProduct[0]['KitItems'] = (count($arryKit)) ? $KitItems : '';

			//End//
		}

		//End//


		echo json_encode($arryProduct[0]);exit;

		break;
		exit;



	case 'SelectItem' :
		$objItem=new items();
		$objPager = new pager();
		#$arr = array('page'=>$_GET['page']);
		$_GET['Status'] = 1;

		//$Config['RecordsPerPage'] = $RecordsPerPage;
		$RecordsPerPage =15;
		$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;
		if($_GET['str']==''){
			//$arryProduct = $objItem->GetItemsViewForSale($_GET);

			/******Get Item Records***********/
			$Config['RecordsPerPage'] = $RecordsPerPage;
			$arryProduct = $objItem->GetItemsViewForSale($_GET);

			/**********Count Records**************/
			$Config['GetNumRecords'] = 1;
			$arryCount=$objItem->GetItemsViewForSale($_GET);
			$num=$arryCount[0]['NumCount'];
			$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
			/*************************/



		}else{
			$arryProduct = $objItem->checkItemSku($_GET['str']);
		}
		//$num=$objItem->numRows();
		//$arrayConfig = $objConfig->GetSiteSettings(1);
		//$RecordsPerPage = 15;
		/*if($RecordsPerPage == 15)
		 {
		 $RecordsPerPage = $RecordsPerPage;
		 }
		 else{
		 $RecordsPerPage = 15;
		 }*/

		//$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
		//(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");

		$AjaxHtml =  '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                        <td align="center" height="20">
                                            <div id="msg_div" class="redmsg"></div>
                                        </td>
                                    </tr>	

                                    <tr>
                                        <td align="right" valign="top">
                                            <form name="frmSrch" id="frmSrch" action="" method="post">
                                                <input type="text" id="search" placeholder="Search Keyword" class="textbox autocomplete" size="20" maxlength="30" value="">&nbsp;<input type="button" id="go" value="Go" class="search_button">
                                                <input type="hidden" name="id" id="id" value="'.$_GET["id"].'">
                                                <input type="hidden" name="proc" id="proc" value="'.$_GET["proc"].'">
                                            </form>
                                        </td>
                                    </tr>

                                <tr>
                                    <td id="ProductsListing" height="400" valign="top">

                                        <form action="" method="post" name="form1">
                                            <div id="prv_msg_div" style="display:none; padding:50px;"><img src="../images/ajaxloader.gif"></div>
                                            <div id="preview_div">

                                                <table  '.$table_bg.' class="tblData">


                                                    <tr align="left">
                                                        <td width="10%" class="head1">Sku</td>
                                                        <td class="head1" >Item Description</td>
                                                        <td width="20%" class="head1" >Purchase Cost ['.$Config['Currency'].'] </td>
                                                        <td width="16%" class="head1" >Sale Price ['.$Config['Currency'].']</td>
                                                        <td width="12%" class="head1" >Qty on Hand</td>
                                                        <td width="12%"  class="head1">Taxable</td>
                                                    </tr>';
		if (is_array($arryProduct) && count($arryProduct) > 0) {
			$flag = true;
			$Line = 0;
			foreach($arryProduct as $key => $values) {
				$flag = !$flag;
				$Line++;
				if (empty($values["Taxable"])){ $values["Taxable"] = "No"; }
				$arryOption = $objItem->getOptionCode($values["ItemID"]);//By Chetan 22Sep//
				$AliasNum = sizeof($arryAlias);
				$compo = $objItem->GetKitItem($values["ItemID"]);   //By Chetan 14Aug//


				$AjaxHtml .= '<tr align="left" valign="middle" bgcolor="'.$bgcolor.'">
                                    <td>';

				if(count($arryOption) > 0  && $values['itemType'] == 'Kit'){ //By Chetan 22Sep//
					$AjaxHtml .=   '<a class="fancybox fancybox.iframe" title="Click to select"  href="getOptionCode.php?ItemID='.$values["ItemID"].'&key='.$values["Sku"].'&id='.$_GET["id"].'&proc='.$_GET["proc"].'" >'.$values["Sku"].'</a>';
				} else {
					if(count($compo) > 0 && $values['itemType'] == 'Kit'){
						 
						$AjaxHtml .=   '<a onclick="$(\'#compo'.$Line.'\').show();" href="Javascript:void(0)" title="Click to select" >'.$values["Sku"].'</a>';
					}else{
						$AjaxHtml .=   '<a href="Javascript:void(0);" title="Click to select" onclick="Javascript:SetItemCode(\''.$values["ItemID"].'\',\''.$values["Sku"].'\',\''.$_GET["id"].'\',\''.$_GET["proc"].'\');" >'.$values["Sku"].'</a>';
						//

					}//End//
				}

				$AjaxHtml .=     '</td>
                                    <td>'.stripslashes($values['description']).'</td>
                                    <td>'.number_format($values['purchase_cost'], 2).'</td>
                                    <td>'.number_format($values['sell_price'], 2).'</td>
                                    <td>'.stripslashes($values['qty_on_hand']).'</td>
                                    <td>'.stripslashes($values['sale_tax_rate']).'</td>
                                </tr>';

				//if(count($compo) > 0 && $values['itemType'] == 'Kit' && ($values["bill_option"] != "Yes" || $values["bill_option"] == "") && $AliasNum == 0){
				if(count($compo) > 0 && $values['itemType'] == 'Kit'  && $AliasNum == 0){
					$AjaxHtml .= '<tr class="compo" id="compo'.$Line.'" style="display:none">
				<td>Display Component Item</td>
				<td colspan="5">
					<input type="radio" name="yes" id="yes" onclick="Javascript:SetItemCode(\''.$values["ItemID"].'\', \''.$values["Sku"].'\',\''.$_GET["id"].'\',\''.$_GET["proc"].'\');" value="yes"> Yes&nbsp;&nbsp;
					<input type="radio" onclick="Javascript:SetItemCode(\''.$values["ItemID"].'\', \''.$values["Sku"].'\',\''.$_GET["id"].'\',\''.$_GET["proc"].'\');" name="no" id="no" value="no"> No</td>    
				</tr>';

			 } //End//
			} // foreach end //



		} else {

			$AjaxHtml .= '<tr>
                                <td  colspan="7" class="no_record">'.NO_RECORD.'</td>
                            </tr>';

		}



		$AjaxHtml .= '<tr>
                                <td colspan="10">Total Record(s) : &nbsp;'.$num.'      
                                    '.((count($arryProduct) > 0) ? '&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; '.$pagerLink.'' : '').'
                                </td>
                            </tr>
                            </table>
                                   </div>
                             </form>
                            </td>
                            </tr>

                        </table>';

		echo json_encode($AjaxHtml);  exit;



}







if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();

switch($_GET['action']){
	case 'DHL':

		//$objshipment=new shipment();

		//$arryshipmentMethod = $objshipment->defaultFedexShippingMethod();

		$AjaxHtml='';

		/*$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {

		$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'">'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}*/

		break;
		exit;

	case 'Fedex':
		$objshipment=new shipment();
		/*$arrysp = $objshipment->ShipFromC($_GET['countryCode']);
		 $arryshipmentMethod = $objshipment->fedexServiceType($arrysp[0]['serviceType']);*/
		$arryshipmentMethod = $objshipment->fedexServiceTypeAll();

		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}
		break;
		exit;


	case 'UPS':

		$objshipment=new shipment();

		/*$arrysp = $objshipment->UpsShipFromC($_GET['countryCode']);
		 $arryshipmentMethod = $objshipment->upsServiceType($arrysp[0]['serviceType']);*/
		$arryshipmentMethod = $objshipment->upsServiceTypeAll();

		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
				
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");
				
			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}
		break;
		exit;

	case 'USPS':
		$objshipment=new shipment();

		$arryshipmentMethod = $objshipment->defaultUSPSShippingMethod();

		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}
		break;
		exit;

}



if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
/*******************************************/

//*****************************************Amit Singh**************************************

if(!empty($_GET['price_id']) && !empty($_GET['row'])){

	$objItem=new items();
	 
	$arryItmPrice = $objItem->GetAttributPrice($_GET['price_id']);
	echo json_encode($arryItmPrice[0]);exit;

}


//*********************************************************************************************

?>
