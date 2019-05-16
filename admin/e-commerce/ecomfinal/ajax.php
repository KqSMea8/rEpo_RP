<?	session_start();
$Prefix = "../../../";
require_once($Prefix."includes/config.php");
require_once($Prefix."classes/dbClass.php");
require_once($Prefix."includes/function.php");
require_once($Prefix."classes/region.class.php");
require_once("classes/admin.class.php");
require_once("classes/leave.class.php");
require_once($Prefix."classes/time.class.php");
require_once("classes/configure.class.php");

require_once("classes/cartsettings.class.php");
$objConfig=new admin();

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}
/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
CleanGet();
switch($_GET['action']){
	case 'delete_file':
		if($_GET['file_path']!=''){
			$objConfigure=new configure();
			$objConfigure->UpdateStorage($_GET['file_path'],0,1);
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
			
	case 'statelist':
		$objRegion=new region();
		$arryState = $objRegion->getStateByCountry($_GET['country_id']);
			
		$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: CityList();">';

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

			$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.stripslashes($arryCity[$i]['name']).'</option>';

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
	case 'citylist':
		$objRegion=new region();
		$arryCity = $objRegion->getCityByState($_GET['state_id']);

		$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" >';

		if($_GET['select']==1){
			$AjaxHtml  .= '<option value="">--- Select ---</option>';
		}


		$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);

		for($i=0;$i<sizeof($arryCity);$i++) {

			$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.stripslashes($arryCity[$i]['name']).'</option>';

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


	case 'zipSearch':
		$objRegion=new region();
		if(!empty($_GET['city_id'])){
			$arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
			for($i=0;$i<sizeof($arryZipcode);$i++) {
				$AjaxHtml .= '<li onclick="set_zip(\''.stripslashes($arryZipcode[$i]['zip_code']).'\')">'.stripslashes($arryZipcode[$i]['zip_code']).'</li>';
			}

		}
		break;

	case 'socailicon':
		$objCartsettings=new Cartsettings();
		
		if(!empty($_POST['socailiconid'])){ 
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$arryicon = $objCartsettings->getSocialicon($_POST['socailiconid']);
			
			echo $arryicon['0']['icon']; 
		}
		break;


			
}

if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
