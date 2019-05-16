<?	session_start();
	
        require_once("includes/settings.php");

	$Config['DbHost'] = $_SESSION['DbHost'];
	$Config['DbUser'] = $_SESSION['DbUser'];
	$Config['DbPassword'] = $_SESSION['DbPassword'];
	$Config['DbName'] = $Config['DbMain'];

	$objRegion=new region();

	switch($_GET['action']){
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

			
	
                       

							
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
