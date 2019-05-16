<?
	session_start();
	require_once("../includes/config.php");
	require_once("../includes/common.php"); 
	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/region.class.php");
	require_once("../classes/admin.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/function.class.php");	
	$objConfig=new admin();	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}


	CleanGet();

	$AjaxHtml='';

	switch($_GET['action']){
		case 'generateLicense':			
			if($_GET['DomainName']!=''){				
				echo GenerateKeyString();
			}
			break;
			exit;


		case 'local_time':
			if($_GET['Timezone']!='' && $_GET['TimezonePlusMinus']!=''){
				$Timezone = $_GET['TimezonePlusMinus'].$_GET['Timezone']; 
				echo '<br>Local Time: <strong>'.getLocalTime($Timezone).'</strong>';
			}
			break;
			exit;
	case 'delete_upload_file':
			if(!empty($_SESSION['ConfigCmpID'])){
				$Config['CmpID']=$_SESSION['ConfigCmpID'];
				unset($_SESSION['ConfigCmpID']);
			}
			if($_GET['file_dir']!='' && $_GET['file_name']!=''){
				$objFunction=new functions();
				$objFunction->DeleteFileStorage($_GET['file_dir'],$_GET['file_name']);
				echo "1";
			}else{
				echo "0";
			}
			break;
			exit;
	 case 'delete_file':
			if($_GET['file_path']!=''){
				unlink($_GET['file_path']);
				echo "1";
			}else{
				echo "0";
			}
			break;
			exit;
		
	case 'state':
			$objRegion=new region();
			if(!empty($_GET['country_id'])){
				$arryState = $objRegion->getStateByCountry($_GET['country_id']);
				$NumState = sizeof($arryState);
			}
				$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';
				
				if(!empty($_GET['select']) && !empty($NumState)){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);
				
				for($i=0;$i<$NumState;$i++) {
				
					$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
				}

				$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
				if(empty($NumState)){
					$AjaxHtml  .= '<option value="">No state found.</option>';
				}else if(!empty($_GET['other'])){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				} 

				$AjaxHtml  .= '</select>';
			
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="'.$StateSelected.'">';
							
			break;
			
			
	case 'city':
			$objRegion=new region();
			$NumCity='';
			if(!empty($_GET['country_id'])){ 
				if(!empty($_GET['ByCountry'])){
					$arryCity = $objRegion->getCityList('', $_GET['country_id']);
					$NumCity = sizeof($arryCity);
				}else if(!empty($_GET['state_id'])){ 
					$arryCity = $objRegion->getCityList($_GET['state_id'], $_GET['country_id']);
					$NumCity = sizeof($arryCity);
				}
			} 
			
				$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';
				
				if($_GET['select']==1 && $NumCity>0){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}
				$CitySelected='';
				if(!empty($arryCity[0]['city_id'])){
					$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);
				}
				
				for($i=0;$i<$NumCity;$i++) {
				
					$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.stripslashes($arryCity[$i]['name']).'</option>';
					
				}

				$Selected = ($_GET['current_city'] == '0')?(" Selected"):("");
				if(!empty($_GET['other'])){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				}else if($NumCity<=0){
					$AjaxHtml  .= '<option value="">No city found.</option>';
				}

				$AjaxHtml  .= '</select>';
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_city_id" id="ajax_city_id" value="'.$CitySelected.'">';
							
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

	case 'SetRegionByZip':		
		$objRegion=new region();
		if(!empty($_GET['ZipCode'])){
			$arryZipcode = $objRegion->getZipCodeByZip($_GET['ZipCode']);
			echo json_encode($arryZipcode[0]);exit;			

		}
		break;

								
	}
	
	echo $AjaxHtml;
	

?>
