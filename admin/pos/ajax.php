<?	session_start();
	$Prefix = "../../"; 
	
    	require_once($Prefix."includes/config.php");
		
	require_once($Prefix."classes/dbClass.php");
   	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/leave.class.php");	
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/cartsettings.class.php");
	require_once($Prefix."classes/product.class.php");
	require_once("classes/user.class.php");
	
	//echo $Prefix."classes/user.class.php";die;
	
	/**********Added by karishma for Dealer 24 may 2016********/
//require_once($Prefix."classes/dealer.class.php");

/**********End by karishma for Dealer 24 may 2016********/
	$objConfig=new admin();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

 
 
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

	case 'searchProduct':
		if(!empty($_GET['Query'])){
			
			if(empty($_GET['AccountID'])) echo "Please Select account name First!!";
			
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
			if(!empty($_GET['ASIN']) && !empty($_GET['itemID'])){
				$objProduct->updateASINAjax( $_GET['ASIN'], $_GET['itemID'] );
			}
			$service = $objProduct->AmazonProductSettings($Prefix,true,addslashes($_GET['AccountID']));
			$result = $objProduct->searchProduct($service,trim($_GET['Query']),$_GET['Category']);
			
			$html = (!empty($_GET['ASIN']))? '<span class="breakhead">List to this Amazon Product  </span>':'<span class="breakhead">Results from '.$objProduct->URL.' </span>';
			if(!empty($result)){
				foreach ($result as $values){
		  			$html .= '<div>
							 	<div style="float: left;width: 25%;min-height: 85px;"><img alt="" src="'.$values->AttributeSets->ItemAttributes->SmallImage->URL.'"></div>
							 	<div style="float: left;width: 60%;margin-bottom:10px;">
								 	<div class="had">'.$values->AttributeSets->ItemAttributes->Title.'</div>
								 	<div style="font-size: 12px;">Brand: '.$values->AttributeSets->ItemAttributes->Brand.'</div>
								 	<div style="font-size: 13px;">ASIN: '.$values->ASIN.'</div>
								 	<div><a href="https://'.$objProduct->URL.'/gp/product/'.$values->ASIN.'" target="_blank">See all product details</a></div>
							 	</div>';
					  			if(!empty($_GET['ASIN'])){
					  				$html .= '<div style="float: left;width: 15%;margin-top: 25px;"><img src="../images/ok.png"></div>
					  						 <input type="hidden" name="ProductTypeName" id="ProductTypeName" value="'.$values->AttributeSets->ItemAttributes->ProductTypeName.'"/>';
					  			}else{
								   $html .= '<div style="float: left;width: 15%;margin-top: 25px;"><input class="button" style="background-color:#37a000;border-color:#37a000;" type="button" name="Choose" value="Choose" tittle="Choose" onclick=searchProduct("'.$values->ASIN.'");></div>';
					  			}
							 $html .= '<div style="clear: both;"></div></div>';
							 if(!empty($_GET['ASIN'])){break;}
	  			}
			}
		    echo $html;
		}else{
			echo 'No Result found from'.$objProduct->SERVICE_URL;
		}
	break;
	
	case 'DealerWalletHistory': 
		$objDealer=new dealer(); 
		$DealerId=$_GET['DealerId'];
		if(!empty($DealerId)){
			$Config['DbName'] = $_SESSION['CmpDatabase']; 
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$arryDealer = $objDealer->getDealerWalletHistoryByDealerId($DealerId);
			//echo '<pre>';
			//print_r($arryDealer);
			
			$AjaxHtml .= '<table cellspacing="1" cellpadding="3" width="100%" align="center" >
			<tr align="left">
				<td width="15%" height="20" class="head1">Name</td>
				<td width="15%" height="20" class="head1" align="center">Credited</td>
				<td width="16%" height="20" class="head1" align="center">Debited</td>
				<td width="16%" height="20" class="head1" align="center">Notes</td>				
				<td width="17%" height="20" class="head1" align="center">Transaction
				No.</td>
				<td width="12%" height="20" class="head1" align="center">Note</td>
				<td width="10%" height="20" class="head1" align="center">Date</td>
				</tr>';
			foreach($arryDealer as $key=>$values){
				$AjaxHtml .= '<tr align="left" bgcolor="'.$bgcolor.'">
				<td height="26">'.$values['dealerName'].'</td>
				<td align="center">'.$values['creditAmount'].'</td>
				<td align="center">'.$values['DebitAmount'].'</td>
				<td align="center">'.$values['Note'].'</td>				
				<td align="center">'.$values['transactionNo'].'</td>
				<td>'.$values['walletNote'].'</td>
				<td>'.date('Y-m-d',strtotime($values['date'])).'</td>
			</tr>';
			}
				
				$AjaxHtml .= '</table>';
				
			
		}
		break;

		case 'processCheck':
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
			
			$arr = array();
			$PID = $objConfig->getPID('e-commerce',$_GET['taskmsg']);
			if($ID = $PID[0]['PID']){
				$statusPID = $objConfig->isRunning($ID);
				if($statusPID){
					$arr['msgStsus'] = 2;
					$arr['status'] = 1;
				}else{
					$objConfig->removePID('e-commerce',$_GET['taskmsg'],$ID);
					$arr['msgStsus'] = 1;
					$arr['status']   = 0;
				}
			}else{
				$arr['msgStsus'] = 0;
				$arr['status']   = 0;
			}
			echo json_encode($arr);
			exit();
		break;

	        case 'lowestPrice':
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
				
			$arr = array();
			if(!empty($_GET['AccountID']) && !empty($_GET['Sku']) && !empty($_GET['ItemCondition'])){
				$Amazonservice = $objProduct->AmazonProductSettings($Prefix,true,$_GET['AccountID']);
				$arr['lowestPrice'] = $objProduct->GetLowestPricingForSKU($Amazonservice, $_GET['ItemCondition'], $_GET['Sku']);
				$arr['Sku'] = $_GET['Sku'];
			}else{
				$arr['lowestPrice'] = 0;
				$arr['Sku']   = 0;
			}
			echo json_encode($arr);
			exit();
		break;
		
		case 'updateAmazonQntPrice': 
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
		
			$arr = array();
			if(!empty($_GET['Type']) && !empty($_GET['Sku']) && !empty($_GET['Val']) && !empty($_GET['AccountID'])){ 
				
				$Amazonservice = $objProduct->amazonSettings($Prefix,true,$_GET['AccountID']);
				
				if( $_GET['Type']=='Quantity' )
					$return = $objProduct->updateAmazonQuantity($Amazonservice, $_GET['Sku'], $_GET['Val'], $_GET['AccountID']);
				else if( $_GET['Type']=='Price' )
					$return = $objProduct->updateAmazonPrice($Amazonservice, $_GET['Sku'], $_GET['Val'], $_GET['AccountID']);
				
				$objProduct->updateTableQntPrice($_GET['Type'], $_GET['Val'], $_GET['Sku'], $_GET['AccountID']);
			}else{
				$return = 0;
			}
			echo $return;
			exit();
		break;
		
		case 'getLocation':
		    $vendor  =  $_GET['vendor'];
		    $location  =  $_GET['location'];
			
			
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objUser  = new user();
			$pos_settings   = $objUser->getResult('pos_settings',array('vendor_id'=>$vendor,'action'=>'basic_location_sttings'));
			if(count($pos_settings)>0){
				  $staringHtml   = "";
				foreach($pos_settings as $val){
					     $data  = unserialize($val['data']);
						// $Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
						$staringHtml  .='<option value="'.$val['id'].'"   '.(($location==$val['id'])?"selected":"").' >'.$data['LocationName'].'</option>';
					
				}
				echo $staringHtml;die;
			}
			
		   
		break;					
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
