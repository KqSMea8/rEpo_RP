<?	session_start();
    	require_once("../includes/config.php");
    	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/region.class.php");
	require_once("../classes/admin.class.php");	
	require_once("../classes/configure.class.php");	
	require_once("../classes/territory.class.php");
	require_once("language/english.php");
	$objConfig=new admin();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();
	switch($_GET['action']){
		case 'local_time':
			if($_GET['Timezone']!='' && $_GET['TimezonePlusMinus']!=''){
				$Timezone = $_GET['TimezonePlusMinus'].$_GET['Timezone']; 
				echo '<br>Local Time: <strong>'.getLocalTime($Timezone).'</strong>';
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
		case 'notification_read':
			$Config['CurrentDepID'] = $_GET["depID"];
			$objConfigure=new configure();
			$objConfigure->ReadNotification('');
			break;
			exit;	

		case 'GetTerritoryManager':
			$objTerritory=new territory();
			if($_GET['TerritoryID']!='None'){	
				$TerritoryID = str_replace("None","",$_GET['TerritoryID']);
				$TerritoryID = rtrim($TerritoryID,",");
				$arryEmployee = $objTerritory->GetTerritoryManager($TerritoryID, $_GET['EmpID']);
				$num = sizeof($arryEmployee);
			}
			$AjaxHtml  = '<select name="ManagerID" class="inputbox" id="ManagerID" >';
			
			if($num>0){
				$AjaxHtml  .= '<option value="">--- Select ---</option>';
				for($i=0;$i<$num;$i++) {
					$Selected = ($_GET['OldManagerID'] == $arryEmployee[$i]['AssignTo'])?(" Selected"):("");
					$AjaxHtml  .= '<option value="'.$arryEmployee[$i]['AssignTo'].'" '.$Selected.'>'.stripslashes($arryEmployee[$i]['UserName']).'</option>';
				}

		    }else{
				$AjaxHtml  .= '<option value="">'.NO_MANAGER.'</option>';
			}

			$AjaxHtml  .= '</select>';			

			break;
			exit;	



						
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
