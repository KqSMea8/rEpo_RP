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
	require_once("../language/english.php");

	
	require_once("../includes/common.php");

	$objConfig=new admin();

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
 
	switch($_GET['action']){
		case 'delete_upload_file':  
			require_once($Prefix."classes/function.class.php");
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
			if($_GET['country_id']>0){
				$arryState = $objRegion->getStateByCountry($_GET['country_id']);
				$NumState = sizeof($arryState);
			}
			
				$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';
				
				if($_GET['select']==1 && $NumState>0){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);
				
				for($i=0;$i<sizeof($arryState);$i++) {
				
					$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
				}

				$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
				if($NumState<=0){
					$AjaxHtml  .= '<option value="">No state found.</option>';
				}else if($_GET['other']==1){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				} 
				$AjaxHtml  .= '</select>';
			
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="'.$StateSelected.'">';
							
			break;
			
			
	case 'city':
			$objRegion=new region();

			if($_GET['country_id']>0){ 
				if(!empty($_GET['ByCountry'])){
					$arryCity = $objRegion->getCityList('', $_GET['country_id']);
				}else if(!empty($_GET['state_id'])){
					$arryCity = $objRegion->getCityList($_GET['state_id'], $_GET['country_id']);
				}
			} 

				$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}
				$CitySelected='';
				if(!empty($arryCity[0]['city_id'])){
				$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);
				
				for($i=0;$i<sizeof($arryCity);$i++) {
				
					$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.htmlentities($arryCity[$i]['name'], ENT_IGNORE).'</option>';
					
				}
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
				if(!empty($_GET['other'])){
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
				if(!empty($_GET['other'])){
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
				//$result = $objProduct->GetProductCategoriesForASIN($service);
				$result = $objProduct->searchProduct($service,trim($_GET['Query']),$_GET['Category']);
					
				$html = (!empty($_GET['ASIN']))? '<span class="breakhead">List to this Amazon Product  </span>':'<span class="breakhead">Results from '.$objProduct->URL.' </span>';
				if(!empty($result)){
					foreach ($result as $values){ //pr($values,1);
							  $price = ($values->AttributeSets->ItemAttributes->ListPrice->Amount>0)? $values->AttributeSets->ItemAttributes->ListPrice->Amount.' '.$values->AttributeSets->ItemAttributes->ListPrice->CurrencyCode : 'Not Found';
					$html .= '<div>
							 	<div style="float: left;width: 25%;min-height: 85px;"><img alt="" src="'.$values->AttributeSets->ItemAttributes->SmallImage->URL.'"></div>
							 	<div style="float: left;width: 60%;margin-bottom:10px;">
								 	<div class="had">'.$values->AttributeSets->ItemAttributes->Title.'</div>
								 	<div style="font-size: 12px;">Brand: '.$values->AttributeSets->ItemAttributes->Brand.'</div>
								 	<div style="font-size: 13px;">ASIN: '.$values->ASIN.'</div>
									<div style="font-size: 12px;">Price: '.$price.'</div>
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
		
		case 'quickAmazon':
			if(!empty($_GET['Query'])){
		
				if(empty($_GET['AccountID'])) echo "Please Select account name First!!";
		
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				$objProduct=new product();
					
				$Amazonservice = $objProduct->AmazonProductSettings($Prefix,true,$_GET['AccountID']);
				$result_ASIN = $objProduct->searchProduct($Amazonservice,trim($_GET['Query']),$_GET['Category']);
					
				$ASIN_List = $rList = array();
				if(!empty($result_ASIN)){
					foreach ($result_ASIN as $values){
						array_push($ASIN_List, $values->ASIN);
						$rList[$values->ASIN] = $values;
					}
					$lowest_ASIN = $objProduct->getLowestOfferListingForASIN($Amazonservice, array_slice($ASIN_List, 0, 20), $_GET['ItemCondition']);
				}
					
				foreach ($lowest_ASIN as $key=>$price){
					$p = $price->prices[0]->LandedPrice;
					if($p>0)
						$listprice[$key] = ($p)? $p : 0 ;
				}
				asort($listprice);
				foreach ($listprice as $key => $value){
					$pvalues = $rList[$key];
					echo '<div>
						    <span class="breakhead">Lowest price result from '.$objProduct->URL.' </span>
						 	<div style="float: left;width: 25%;min-height: 85px;"><img alt="" src="'.$pvalues->AttributeSets->ItemAttributes->SmallImage->URL.'"></div>
						 	<div style="float: left;width: 60%;margin-bottom:10px;">
							 	<div class="had">'.$pvalues->AttributeSets->ItemAttributes->Title.'</div>
							 	<div style="font-size: 12px;">Brand: '.$pvalues->AttributeSets->ItemAttributes->Brand.'</div>
							 	<div style="font-size: 13px;">Price: '.$value.'</div>
							 	<div style="font-size: 13px;" id="ASIN_NO" val="'.$key.'">ASIN: '.$pvalues->ASIN.'</div>
							 	<div><a href="https://'.$objProduct->URL.'/gp/product/'.$key.'" target="_blank">See all product details</a></div>
						 	</div>
				  			<div style="float: left;width: 15%;margin-top: 25px;"><img src="../images/ok.png"></div>
				  			<input type="hidden" name="ProductTypeName" id="ProductTypeName" value="'.$pvalues->AttributeSets->ItemAttributes->ProductTypeName.'"/>
							<div style="clear: both;"></div>
				  		';
					/*</div><div id="linkBox" onclick="resetSearch();">
					 <span class="breakhead-up">Search for a different Amazon product</span>
					 </div>*/
					break;
				}
			}else{
				echo 'No Result found from'.$objProduct->SERVICE_URL;
			}
			break;
		
		case 'processCheck':
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
				
			$arr = array();
			$PID = $objConfig->getPID('e-commerce',$_GET['taskmsg']);

			(!isset($PID[0]['PID']))?($PID[0]['PID']=""):("");


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
			if(!empty($_GET['Type']) && !empty($_GET['Sku']) && ($_GET['Val']>=0) && !empty($_GET['AccountID'])){
		
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
		
		case 'updateEbayQntPrice':
			require_once($Prefix."classes/item.class.php");
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
		
			$arr = array();
			if(!empty($_GET['Type']) && !empty($_GET['ItemID']) && !empty($_GET['Val']) ){
				$x = array($_GET['ItemID']=>$_GET['Val']);
				if( $_GET['Type']=='Quantity' )
					$return = $objProduct->updateEbayAllQuantity($Prefix, $x);
					else if( $_GET['Type']=='Price' )
						$return = $objProduct->updateEbayAllPrice($Prefix, $x);
		
			}else{
				$return = 0;
			}
			echo $return;
			exit();
			break;
				
		case 'getCategories':
			require_once($Prefix."classes/item.class.php");
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$objProduct=new product();
		
			if( is_numeric($_GET['SiteID']) ){
				$return = $objProduct->getEbayCategoties($Prefix, $_GET['SiteID'], $_GET['Level'], $_GET['ParentID']);
			}else{
				$return = 'Please select valid site name!';
			}
				
			echo json_encode($return);
			exit();
			break;
				
		case 'searchEbayProduct':
			if(!empty($_GET['Query'])){
		
				if(!is_numeric($_GET['SiteID'])) echo "Please Select Site name First!!";
					
				require_once($Prefix."classes/item.class.php");
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				$objProduct=new product();
					
				$result = $objProduct->searchEbayItemByKeywords($Prefix,$_GET['Query']);
				//$result = $objProduct->searchProduct($service,trim($_GET['Query']),$_GET['Category']);
				$results = '';
				foreach($resp->searchResult->item as $item) {
					$pic   = $item->galleryURL;
					$link  = $item->viewItemURL;
					$title = $item->title;
					// Build the desired HTML code for each searchResult.item node and append it to $results
					//$results .= "<tr><td><img src=\"$pic\"></td><td><a href=\"$link\">$title</a></td></tr>";
				}
				$html = (!empty($_GET['productId']))? '<span class="breakhead">List to this Ebay Item  </span>':'<span class="breakhead">Results from Ebay </span>';
				if(!empty($result)){
					foreach ($result as $values){ //pr($values,1);
						$html .= '<div>
						 	<div style="float: left;width: 25%;min-height: 85px;"><img alt="" src="'.$values->galleryURL.'"></div>
						 	<div style="float: left;width: 60%;margin-bottom:10px;">
							 	<div class="had">'.$values->title.'</div>
							 	<div><a href='.$values->viewItemURL.' target="_blank">See all product details</a></div>
						 	</div>';
						if(!empty($_GET['productId'])){
							$html .= '<div style="float: left;width: 15%;margin-top: 25px;"><img src="../images/ok.png"></div>
				  					  <input type="hidden" name="productId" id="productId" value="'.$values->productId.'"/>';
						}else{
							$html .= '<div style="float: left;width: 15%;margin-top: 25px;"><input class="button" style="background-color:#37a000;border-color:#37a000;" type="button" name="Choose" value="Choose" tittle="Choose" onclick=searchProduct("'.$values->productId.'");></div>';
						}
						$html .= '<div style="clear: both;"></div></div>';
						if(!empty($_GET['productId'])){break;}
					}
				}
				echo $html;
			}else{
				echo 'No Result found from Ebay';
			}
			break;
							
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>

