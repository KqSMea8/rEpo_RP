<?php	session_start();
	$Prefix = "../../"; 
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
            
                         //Get Kit Item
                            $arryKit = $objItem->GetKitItem($_GET['ItemID']);
                            $NumKiItem = sizeof($arryKit);
                            
                            
                         //Get Option Code Item Item
                            /*if($_GET['optionID'] > 0){
                                $arryOptionCodeItem = $objItem->GetOptionCodeItem($_GET['optionID']);
                                $NumOptionCodeItem = sizeof($arryOptionCodeItem);

                            }*/

                       /*By Chetan*/
                            if($_GET['optionID']){
                                $optionIDs = json_decode(stripslashes($_GET['optionID']));
                                $arryOptionCodeItem = array();
                                foreach($optionIDs as $optionID)
                                {
                                    if($optionID > 0)
                                    {    
                                       $resArray = $objItem->GetOptionCodeItem($optionID);
                                       array_push($arryOptionCodeItem,$resArray[0]);
                                       $NumOptionCodeItem = sizeof($arryOptionCodeItem);
                                    }
                                }    
                            }
                            /**End**/
                         /************ARRAy MERGE****************************************************************************/
               /***********************Variant********************************************/

if($arryProduct[0]['variant_id']!=''){
$objvariant=new varient();

		$variantArray = $objvariant->GetVariantDispaly($arryProduct[0]['variant_id']);

foreach($variantArray as $varvalues){
                           
                            
                        //$html='';
                        $html.='<div id="innerVariantlist_'.$varvalues['id'].''.$_GET['SelID'].'">';
                        $html.='<input type="text" disabled="" style="" class="inputbox" name="variant_name_'.$_GET['SelID'].'['.$varvalues['id'].'][]" value="'.$varvalues['variant_name'].'">';
                        $html.='<input type="hidden" name="variantID_'.$_GET['SelID'].'[]" value="'.$varvalues['id'].'">';
                        if($varvalues['variant_type_id']=='4'){
                            //echo 'yes';
			$arryvariantm = $objvariant->GetMultipleVariantOption($varvalues['id']);	
			
                        if(!empty($arryvariantm)){
                        $html.='<select name="varmul_'.$_GET['SelID'].'['.$varvalues['id'].'][]" multiple style="width: 100%;">';
                        foreach($arryvariantm as $val){
                            $html.='<option value="'.$val['id'].'">'.$val['option_value'].'</option>';
                        }
                        $html.='</select>';
                        }
                        
                        } else if($varvalues['variant_type_id']=='5') {
                            $arryvariantd = $objvariant->GetMultipleVariantOption($varvalues['id']);
                       
                        
                        if(!empty($arryvariantd)){
		             $html.='<select name="varmul_'.$_GET['SelID'].'['.$varvalues['id'].'][]" style="width: 100%;">';
		             $html.='<option value="">select</option>';
				  foreach($arryvariantd as $val){
				      $html.='<option value="'.$val['id'].'">'.$val['option_value'].'</option>';
				  }
		             $html.='</select>';
		             
		             }
                        }
                        
                      
                        }

}else{
$html = '';
}
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
                              
                              if($NumOptionCodeItem > 0){
                                  $RequiredItemAndKitItemArry = array_merge($RequiredItemAndKitItemArry,$arryOptionCodeItem);
				$NumRequiredItem = intval($NumRequiredItem + $NumOptionCodeItem);
                              }
                              
                              
                              
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
					$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
				}
				$RequiredItem = rtrim($RequiredItem,"#");
				$NumRequiredItem = sizeof($arrUniqueVal);//By Chetan 16/6/15
			}
                              
                 
                        /*By Chetan*/
                        if($_GET['AliasID'])
                        {
                            $AliasId = json_decode(stripslashes($_GET['AliasID']));
                            foreach($AliasId as $alias)
                            {
                                $arryAliasRequired = $objItem->GetAliasRequiredItem($alias);
                                $NumAliasRequiredItem = sizeof($arryAliasRequired);
                                if($NumAliasRequiredItem>0){
                                    foreach($arryAliasRequired as $key=>$values){
                                            $AliasRequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
                                    }
                                    $AliasRequiredItem = rtrim($AliasRequiredItem,"#");
                                    $RequiredItem .= '#'.$AliasRequiredItem;
                                    $NumRequiredItem = intval($NumRequiredItem + $NumAliasRequiredItem);
                                }   
                            }    
                        }
                        /*--End--*/
                           
                       /********************************************************************************/
                            
                     
                        
			$arryProduct[0]['RequiredItem'] = $RequiredItem;
			$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
			$arryProduct[0]['variantDisplay'] = $html;
                
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;		   
            
            
		case 'CustomerInfo':
			$objCustomer = new Customer();
			$arryCustomer = $objCustomer->GetCustomerAllInformation('',$_GET['CustCode'],'');	
			echo json_encode($arryCustomer[0]);exit;

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

					$AjaxHtml = '<select name="TaxRate" id="TaxRate" class="inputbox" onclick="Javascript: ProcessTotal();"><option value="0">None</option>';
					for($i=0;$i<sizeof($arrySaleTax);$i++) {

					$Selected = ($arrRate[0] == $arrySaleTax[$i]['RateId'] && $arrRate[2] == $arrySaleTax[$i]['TaxRate'])?(" Selected"):("");

					$AjaxHtml .= "<option ".$Selected." value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['RateDescription'].":".$arrySaleTax[$i]['TaxRate']."' >
					".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
					} 
					$AjaxHtml .= '</select>';				
				}

			}		             
								
			break;

case 'SearchQuoteCode':
		$objItem=new items(); 
		$arryProduct=$objItem->checkItemSku($_GET['key']);
		$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
                $arryProduct[0]['purchasePrice'] = $arryProduct[0]['sell_price'];
		$arryRequired = $objItem->GetRequiredItem($arryProduct[0]['ItemID'],'');
		$NumRequiredItem = sizeof($arryRequired);
		$RequiredItem = '';			
		if($NumRequiredItem>0){
			foreach($arryRequired as $key=>$values){
				$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
			}
			$RequiredItem = rtrim($RequiredItem,"#");
		}
		$arryProduct[0]['RequiredItem'] = $RequiredItem;
		$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
		echo json_encode($arryProduct[0]);exit;

		break;
		exit;  


	}



	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
