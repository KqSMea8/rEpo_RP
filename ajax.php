<?	session_start();
	
        require_once("includes/config.php");
	require_once("classes/dbClass.php");
        require_once("includes/function.php");
	require_once("classes/region.class.php");
	require_once("classes/admin.class.php");
        require_once("classes/orders.class.php");
	require_once("classes/leave.class.php");	
	require_once("classes/time.class.php");
	$objConfig=new admin();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

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
				
                                if(!empty($_GET['country_id']))
                                {
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
                               }
                               else{
                                    $AjaxHtml  .= '<option value="">--- Select ---</option>';
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
                       

							
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>