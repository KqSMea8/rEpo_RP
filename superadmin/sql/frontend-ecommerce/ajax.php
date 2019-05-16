<?	//session_start();

require_once("includes/settings.php");
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
			
		$AjaxHtml  = '<select name="state_id" class="inputbox form-control" id="state_id"  onchange="Javascript: SetMainStateId();">';

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
			
	case 'stater':
		$objRegion=new region();

		$arryState = $objRegion->getStateByCountry($_GET['country_id']);
			
		$AjaxHtml  = '<select name="state_id" class="inputbox form-control" id="state_id"  onchange="Javascript: SetMainStateIdR();">';

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

		$AjaxHtml  = '<select name="city_id" class="inputbox form-control" id="city_id" onchange="Javascript: SetMainCityId();">';

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
			$AjaxHtml  = '<select name="State" id="state_id"  onclick="Javascript: GetStateId();" class="multiselect form-control" multiple size="7">';

			$AjaxHtml  .= '<option value="0">All States</option>';

			$AjaxHtml  .= '</select>';
		}
		else
		{
			$arryState = $objRegion->getStateByCountry($_GET['country_id']);

			$AjaxHtml  = '<select name="State" id="state_id" class="multiselect form-control" multiple size="7"  onclick="Javascript: GetStateId();">';

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
			
		$AjaxHtml  = '<select name="State" id="state_id" class="inputbox form-control"   onclick="Javascript: SetMainStateId();">';

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
			
	case 'cardform':
		$current_year=date('Y');
		$AjaxHtml  ='<table id="cardtbl">

				<tr>
					<td align=right>Card Type:</td>
					<td align=left>
					<select name="creditCardType" id="creditCardType" >
						<option value=Visa selected>Visa</option>
						<option value=MasterCard>MasterCard</option>
						<option value=Discover>Discover</option>
						<option value=Amex>American Express</option>
					</select></td>
					<td align=right>Card Number:</td>
					<td align=left><input type=text size=19 maxlength=19
						name="creditCardNumber" id="creditCardNumber"></td>
				</tr>

				<tr>
					<td align=right>Expiration Date:</td>
					<td align=left>
					<p> 
					<select name="expDateMonth" id="expDateMonth" style="width:38%">';

		for($count=1;$count<=12;$count++){

			if(strlen($count)==1) $AjaxHtml  .='<option value="0'.$count.'">0'.$count.'</option>';
			else $AjaxHtml  .='<option value="'.$count.'">'.$count.'</option>';
				
		}

		$AjaxHtml  .='</select>
					
					<select name="expDateYear" id="expDateYear" style="width:58%">';
			
		
		for($count=$current_year;$count<=$current_year+10;$count++){
			$AjaxHtml  .='<option value="'.$count.'">'.$count.'</option>';
		}
			

		$AjaxHtml  .='</select></p>
					</td>
					<td align=right>CVV Number:</td>
					<td align=left><input type=text size=3 maxlength=4 name=cvv2Number id="cvv2Number"
						></td>
				</tr>


			</table>';


			
		break;
			
		//By Chetan 15Sep//
	case 'variantData': 
			    $Config['DbName'] = $_SESSION['CmpDatabase'];
			    $objConfig->dbName = $Config['DbName'];
			    $objConfig->connect();
			    $objvariant=new varient();
				if($_GET['VariantId']){			    
			$variantArray = $objvariant->GetVariant($_GET['VariantId']);
			    
			    foreach($variantArray as $varvalues)
			    {
				$AjaxHtml.='<input type="hidden" readonly="readonly" name="variantVal" id="variantVal" value="">';
				$AjaxHtml.='<input type="hidden" readonly="readonly" name="variantID" value="'.$varvalues['id'].'">';
				$AjaxHtml.='<input type="hidden" readonly="readonly" name="compulsory" id="compulsory" value="'.$varvalues['required'].'">';
				if($varvalues['variant_type_id']=='4'){

				$arryvariantm = $objvariant->GetMultipleVariantOption($varvalues['id']);	

				    if(!empty($arryvariantm)){
					$AjaxHtml.='<select name="varselect" id="varselect" multiple class="form-control"  style="width:200px">';
				    foreach($arryvariantm as $val){
					$AjaxHtml.='<option value="'.$val['id'].'">'.$val['option_value'].'</option>';
				    }
				    $AjaxHtml.='</select>';
				    }

				}elseif($varvalues['variant_type_id']=='5') {
				    $arryvariantd = $objvariant->GetMultipleVariantOption($varvalues['id']);


				    if(!empty($arryvariantd))
				    {
					$AjaxHtml.='<select name="varselect" id="varselect" class="form-control" style="width:200px">';
					$AjaxHtml.='<option value="">Select</option>';
					     foreach($arryvariantd as $val){
						 $AjaxHtml.='<option value="'.$val['id'].'">'.$val['option_value'].'</option>';
					     }
					$AjaxHtml.='</select>';

				     }
				}


			    }
			}
			    break;
		//End//	
			
}

if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
