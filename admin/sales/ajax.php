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
   require_once("../language/english.php");
   require_once($Prefix."classes/sales.class.php");
   require_once($Prefix."classes/inv_tax.class.php");
   require_once($Prefix."classes/item.class.php");
   require_once($Prefix."classes/bom.class.php");
   require_once($Prefix."classes/variant.class.php");
   require_once($Prefix."classes/pager.cls.php");  //By Chetan 18Sep//
   require_once($Prefix."classes/sales.quote.order.class.php");//by sachin
   require_once($Prefix."classes/configure.class.php");//by sachin
   require_once($Prefix."classes/warehouse.shipment.class.php");

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}

	$objCommon = new common();
	$objConfig=new admin();
        $objSale = new sale();//by sachin
	$objConfigure =new configure();//by sachin
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
	include("../includes/common.php");

	(empty($_GET['action']))?($_GET['action']=""):("");
	(empty($_POST['Action']))?($_POST['Action']=""):("");
	(empty($_POST['action']))?($_POST['action']=""):("");

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
        /****start code by sachin*****/
    case 'delete_file_Storage':
			if($_GET['file_path']!=''){

				//$OldFileSize = filesize($_GET['file_path'])/1024; //KB
				 /*         * ******Connecting to Cmp database******** */
		        $Config['DbName'] = $_SESSION['CmpDatabase'];
		        $objConfig->dbName = $Config['DbName'];
		        $objConfig->connect();
		        /*         * **************************************** */
				$objSale->UpdateDoc('',$_GET['orderid']);

				/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
	           /*******************************************/
				//PR($objConfigure);die;
				$objConfigure->UpdateStorage($_GET['file_path'],'',1);
				//unlink($_GET['file_path']);
				echo "1";
				
			}else{
				echo "0";
			}
			break;
			exit;
    	/****End code by sachin*****/
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
			if($_GET['country_id']>0){ //open uncomment
				if($_GET['ByCountry']==1){
					$arryCity = $objRegion->getCityList('', $_GET['country_id']);
				}else if($_GET['state_id']>0){ 
					$arryCity = $objRegion->getCityList($_GET['state_id'], $_GET['country_id']);
				}
			} 

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
 
			$country_id =  (!empty($arryCountry[0]['country_id']))?($arryCountry[0]['country_id']):("");
			$state_id=0;
			if($country_id>0 && !empty($_GET["State"])){		
				$arryState = $objRegion->GetStateID($_GET["State"], $country_id); 
				$state_id =  (!empty($arryState[0]['state_id']))?($arryState[0]['state_id']):("");//set
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
			$NumKiItem=0;
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
                            if(!empty($_GET['optionID'])){
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
#if($_GET['this']==1){ echo "<pre>";print_r($arrUniqueVal);exit;}
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
		(empty($_GET["WID"]))?($_GET["WID"]=""):("");
		$ArrDetailsku = $ArrDetailItemID = '';

		if(isset($_GET['Condi'])){
			$exist=$objItem->checkItemSku($_GET['Sku']);

			if(!empty($exist))
			{
				$arryProduct=$objItem->getItemCondionQty($_GET['Sku'],$_GET['Condi'],$_GET['WID']);
        $arryProduct[0]['evaluationType'] = $exist[0]['evaluationType'];
			}else{
				$ArrDetail = $objItem->checkItemAliasSku($_GET['Sku']);
         			$arryProduct[0]['evaluationType'] = (!empty($ArrDetail[0]['evaluationType']))?($ArrDetail[0]['evaluationType']):('');
				$ArrDetailsku = (!empty($ArrDetail[0]['sku']))?($ArrDetail[0]['sku']):('');
				$ArrDetailItemID = (!empty($ArrDetail[0]['ItemID']))?($ArrDetail[0]['ItemID']):('');
 
				$arryProduct=$objItem->getItemCondionQty($ArrDetailsku,$_GET['Condi'],$_GET['WID']);
			}


		if(!isset($arryProduct[0]['evaluationType']))$arryProduct[0]['evaluationType']='';


			if(!empty($arryProduct[0]['condition_qty'])){
						$desProduct[0]['condition_qty']=$arryProduct[0]['condition_qty'];
						$desProduct[0]['SalePrice'] = $arryProduct[0]['SalePrice'];
			}else {
						$desProduct[0]['condition_qty']='0';
						$desProduct[0]['SalePrice'] = '0.00';
			}
			if(!empty($exist))
			{
				
/********************************Get Cost************************************************/
					if($arryProduct[0]['evaluationType'] =='LIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'ASC';
							$_GET['Sku'] = $exist[0]['Sku'];
              $_GET['Condition']  = $_GET['Condi'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET,'');

							$cost[0]['AvgCost'] = (!empty($arryVendorPrice[0]['price'])) ? $arryVendorPrice[0]['price']:'';


					}else if($arryProduct[0]['evaluationType'] =='FIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'DESC';
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $_GET['Condi'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($exist[0]['ItemID'],$_GET,'');
							$cost[0]['AvgCost'] =(!empty($arryVendorPrice[0]['price'])) ? $arryVendorPrice[0]['price']:'';
					}else{
							$_GET['Sku'] = $exist[0]['Sku'];
							$_GET['Condition']  = $_GET['Condi'];
							$arryVendorPrice=$objItem->GetAvgSerialPrice($exist[0]['ItemID'],$_GET);
							//$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
							$cost[0]['AvgCost'] = (!empty($arryVendorPrice[0]['price'])) ? $arryVendorPrice[0]['price']:'';
					}

/********************************************************************************/
				$desProduct[0]['AvgCost'] = (!empty($cost[0]['AvgCost'])) ? $cost[0]['AvgCost']:'';


			}else{
				//$ArrDetail = $objItem->checkItemAliasSku($_GET['Sku']);



if($arryProduct[0]['evaluationType'] =='LIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'ASC';
							$_GET['Sku'] = $ArrDetailsku;
              $_GET['Condition']  = $_GET['Condi'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($ArrDetailItemID,$_GET,'');
							$cost[0]['AvgCost'] =$arryVendorPrice[0]['price'];
							}else if($arryProduct[0]['evaluationType'] =='FIFO'){

							$_GET['LMT'] = 1;
							$_GET['Ordr'] = 'DESC';
							$_GET['Sku'] = $ArrDetailsku;
							$_GET['Condition']  = $_GET['Condi'];
							$arryVendorPrice=$objItem->GetAvgTransPrice($ArrDetailItemID,$_GET,'');
							$cost[0]['AvgCost'] = $arryVendorPrice[0]['price'];
							}else{
							$_GET['Sku'] = $ArrDetailsku;
							$_GET['Condition']  = $_GET['Condi'];
							$arryVendorPrice=$objItem->GetAvgSerialPrice($ArrDetailItemID,$_GET,'');
							//$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
							$cost[0]['AvgCost'] = $arryVendorPrice[0]['price'];
							}


				//$cost = $objItem->getAvgCostsofPurOrderbyID($ArrDetailsku,$_GET['Condi']);
				//$cost = $objItem->getItemCondionQty($_GET['Sku'],$_GET['Condi']);
			}
			//$cost = $objItem->getAvgCostsofPurOrderbyID($_GET['Sku'],$_GET['Condi']);
			$desProduct[0]['AvgCost'] = (!empty($cost[0]['AvgCost'])) ? $cost[0]['AvgCost']:'';
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

		if(!empty($arryProduct[0])){
		    echo json_encode($arryProduct[0]);exit;
		}
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
                            if(!empty($arrUniqueVal)){
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
			(empty($_GET["CustCode"]))?($_GET["CustCode"]=""):("");
			(empty($_GET["CustId"]))?($_GET["CustId"]=""):("");

			$objCustomer = new Customer();
			$arryCustomer = $objCustomer->GetCustomerAllInformation('',$_GET['CustCode'],'');
			
			$arryContact = $objCustomer->GetCustomerShippingContact($_GET['CustId']);

			$OrderSource = $objCustomer->GetCustomerOrderSource($_GET['CustCode']);

 			$SalesPerson = $venSalesPersonName = $empSalesPersonName = '';

			 if(!empty($arryCustomer[0]['SalesPersonID'])){
          	    $empSalesPersonName = $objConfig->getSalesPersonName($arryCustomer[0]['SalesPersonID'],0);
			    $SalesPerson = $empSalesPersonName;
            }
           if(!empty($arryCustomer[0]['VendorSalesPerson'])){
            	$venSalesPersonName = $objConfig->getSalesPersonName($arryCustomer[0]['VendorSalesPerson'],1);
			    $SalesPerson = $venSalesPersonName;
            }
            if((!empty($empSalesPersonName)) && (!empty($venSalesPersonName))){
            	 $SalesPerson = $empSalesPersonName.",".$venSalesPersonName;
            }
             $arryCustomer[0]['SalesPerson'] = $SalesPerson;
             $arryCustomer[0]['SalesPersonName'] = $empSalesPersonName;
             $arryCustomer[0]['vendorSalesPersonName'] = $venSalesPersonName;
			//end code here
			if($arryCustomer[0]['CustomerName']!=''){ 
			    $arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerName'];
			}else{ 
			    $arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerCompany'];
			}

		if(empty($arryCustomer[0]['Currency'])){ 
			$arryCustomer[0]['Currency'] = $_SESSION['ConfigCurrency'];
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
            $arryCustomer[0]['OrderSource']=$OrderSource;
            $arryCustomer[0]['shipList']=$shipList;
		$arryCustomer[0]['Address']=htmlentities($arryCustomer[0]['Address'], ENT_IGNORE);
		$arryCustomer[0]['sAddress']=htmlentities($arryCustomer[0]['sAddress'], ENT_IGNORE);

			echo json_encode($arryCustomer[0]);exit;

			break;
			exit;		


		case 'CustomerName':
			(empty($_GET["CustCode"]))?($_GET["CustCode"]=""):("");
			(empty($_GET["CustId"]))?($_GET["CustId"]=""):("");
		
		 	$SalesPerson = $venSalesPersonName = $empSalesPersonName = '';

			$objCustomer = new Customer();

			$arryName = explode("-", $_GET['CustName']);
			if(!empty($arryName[1])){ 
				$CustName = $arryName[1];//CustCode
			}else{
				$Config["CustNameAlso"] = 1;
				$CustName = $_GET['CustName'];
			}
			$arryCustomer = $objCustomer->GetCustomerAllInformation('',$CustName,'');
			if(!empty($arryCustomer[0]['Cid'])){	
				$OrderSource = $objCustomer->GetCustomerOrderSource($arryCustomer[0]['CustCode']);
				$arryContact = $objCustomer->GetCustomerShippingContact($arryCustomer[0]['Cid']);
				if(!empty($arryCustomer[0]['SalesPersonID'])){
				$empSalesPersonName = $objConfig->getSalesPersonName($arryCustomer[0]['SalesPersonID'],0);
				$SalesPerson = $empSalesPersonName;
				}
				if(!empty($arryCustomer[0]['VendorSalesPerson'])){
				$venSalesPersonName = $objConfig->getSalesPersonName($arryCustomer[0]['VendorSalesPerson'],1);
				$SalesPerson = $venSalesPersonName;
				}
				if((!empty($empSalesPersonName)) && (!empty($venSalesPersonName))){
				$SalesPerson = $empSalesPersonName.",".$venSalesPersonName;
				}
				$arryCustomer[0]['SalesPerson'] = $SalesPerson;
				$arryCustomer[0]['SalesPersonName'] = $empSalesPersonName;
				$arryCustomer[0]['vendorSalesPersonName'] = $venSalesPersonName;
				//end code here
				if($arryCustomer[0]['CustomerName']!=''){ 
				$arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerName'];
				}else{ 
				$arryCustomer[0]['CustomerName'] = $arryCustomer[0]['CustomerCompany'];
				}

				if(empty($arryCustomer[0]['Currency'])){ 
					$arryCustomer[0]['Currency'] = $_SESSION['ConfigCurrency'];
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
			     $arryCustomer[0]['OrderSource']=$OrderSource;
			    $arryCustomer[0]['shipList']=$shipList;
			}

			if(!empty($arryCustomer[0])){ 
				$arryCustomer[0]['Address']=htmlentities($arryCustomer[0]['Address'], ENT_IGNORE);
				$arryCustomer[0]['sAddress']=htmlentities($arryCustomer[0]['sAddress'], ENT_IGNORE);
				echo json_encode($arryCustomer[0]);exit;
			}
			break;
			exit;		

 case 'shippAddress':

    $objCustomer = new Customer();
    $arryContact = $objCustomer->GetCustomerAddressBook($_GET['CustID'],$_GET['ShipId']);

#print_r($arryContact);
    #$arr = array_map('utf8_encode', $arryContact[0]);
    echo json_encode($arryContact[0]);exit;

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
                           if($arrySpiffSettings[0]['GLAccountTo'] > 0 && $arrySpiffSettings[0]['GLAccountFrom'] > 0 && !empty($arrySpiffSettings[0]['PaymentTerm'])){
                               echo 1;exit;
                           }else{
                                echo 0;exit;
                           }
			

			break;
			exit;	

		case 'TaxRateAddress':
			if(!empty($country_id)){
				(empty($state_id))?($state_id=""):("");

				$objTax=new tax();
				$arrySaleTax = $objTax->GetTaxByLocation(1,$country_id,$state_id);
				if(!empty($arrySaleTax)){

					$arrRate = explode(":",$_GET['OldTaxRate']);

					$AjaxHtml = '<select name="TaxRate" id="TaxRate" class="inputbox" onchange="Javascript: freightSett(this.value);"  ><option value="0">None</option>';
					for($i=0;$i<sizeof($arrySaleTax);$i++) {

					$Selected = ($arrRate[0] == $arrySaleTax[$i]['RateId'] && $arrRate[2] == $arrySaleTax[$i]['TaxRate'])?(" Selected"):("");

					$AjaxHtml .= "<option freight_tax='".$arrySaleTax[$i]['FreightTax']."' ".$Selected." value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['RateDescription'].":".$arrySaleTax[$i]['TaxRate']."' >
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

                    if(!empty($arryAlias[0]["ItemID"]))
                    {
                        $alias = 1;
                        $arryProduct=$objItem->GetItemById($arryAlias[0]["ItemID"]);
                        $arryProduct[0]['Sku'] = $arryAlias[0]['ItemAliasCode'];
                        $arryProduct[0]['description'] = $arryAlias[0]['description'];
			$arryProduct[0]['evaluationType'] = $arryAlias[0]['evaluationType'];
			$arryProduct[0]['ItemID'] = $arryAlias[0]['ItemID'];
			//$arryProduct[0]['itemType'] = $arryAlias[0]['itemType'];
                    }    
                }
                //End//
			
		if(empty($arryProduct[0]['ItemID'])) $arryProduct[0]['ItemID']='';	
		if(empty($arryProduct[0]['itemType'])) $arryProduct[0]['itemType']='';	
				
			$arryProduct[0]['price'] = '0.00';
			$arryProduct[0]['purchasePrice'] = '0.00';
                
                 //By Chetan 9sep// 
                if(!isset($alias))
                {
                    $arryRequired = $objItem->GetRequiredItem($arryProduct[0]['ItemID'],'');
                    $NumRequiredItem = sizeof($arryRequired);
                    $RequiredItem = '';			
                    if($NumRequiredItem>0){
                            foreach($arryRequired as $key=>$values_req){

					(empty($values_req["qty"]))?($values_req["qty"]=""):("");
					(empty($values_req["sell_price"]))?($values_req["sell_price"]=""):("");

                                    $RequiredItem .= stripslashes($values_req["item_id"]).'|'.stripslashes($values_req["sku"]).'|'.stripslashes($values_req["description"]).'|'.stripslashes($values_req["qty"]).'|'.stripslashes($values_req["qty_on_hand"]).'|'.stripslashes($values_req["sell_price"]).'#';
                            }
                            $RequiredItem = rtrim($RequiredItem,"#");
                    }
                }else{
                    
                    $arryRequired = $objItem->getAliasRequiredItemByIds($arryProduct[0]['ItemID'],$arryAlias[0]['AliasID']);
                    $NumRequiredItem = sizeof($arryRequired);
                    $RequiredItem = '';			
                    if($NumRequiredItem>0){
                            foreach($arryRequired as $key=>$valuesAReq){

				(empty($valuesAReq["qty"]))?($valuesAReq["qty"]=""):("");
				(empty($valuesAReq["sell_price"]))?($valuesAReq["sell_price"]=""):("");

                                    $RequiredItem .= stripslashes($valuesAReq["item_id"]).'|'.stripslashes($valuesAReq["sku"]).'|'.stripslashes($valuesAReq["description"]).'|'.stripslashes($valuesAReq["qty"]).'|'.stripslashes($valuesAReq["qty_on_hand"]).'|'.stripslashes($valuesAReq["sell_price"]).'#';
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

		//By Chetan 22sep//update 11May2017 by chetan// 
                //if(!isset($alias))
                //{
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
			$KitItems='';
                    if(count($arryKit)>0){
                            foreach($arryKit as $key=>$values){
$sellPr = '0.00';
                                    $KitItems .= stripslashes($values["item_id"]).'|'.stripslashes($values["Sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.$sellPr.'#';
                            }
                            $KitItems = rtrim($KitItems,"#");
                    }

                    $arryProduct[0]['KitItemsCount'] = (count($arryKit)) ? count($arryKit) : '0'; 
                    $arryProduct[0]['KitItems'] = (count($arryKit)) ? $KitItems : '';

                    //End//
                //}            
                
                //End//


		echo json_encode($arryProduct[0]);exit;

		break;
		exit;  
	case 'SearchBomCode':
		$objItem=new items(); 
		$arryProduct=$objItem->checkItemSku($_GET['key']);

	

                    $arryOption = $objItem->getOptionCode($arryProduct[0]["ItemID"]);
                    if(count($arryOption) > 0 && $arryProduct[0]["itemType"] == 'Non Kit'){  

                        $arryProduct[0]['showPopUp'] = 'y';
                    }
 if($arryProduct[0]["itemType"] == 'Non Kit'){  
                    $arryKit = $objItem->GetKitItem($arryProduct[0]["ItemID"]);
                    if(count($arryKit)>0){
			    $KitItems = '';
                            foreach($arryKit as $key=>$values){
$sellPr = '0.00';
                                    $KitItems .= stripslashes($values["item_id"]).'|'.stripslashes($values["Sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.$sellPr.'#';
                            }
                            $KitItems = rtrim($KitItems,"#");
                    }

                    $arryProduct[0]['KitItemsCount'] = (count($arryKit)) ? count($arryKit) : '0'; 
                    $arryProduct[0]['KitItems'] = (count($arryKit)) ? $KitItems : '';
}else{

$arryProduct ='';
}
                    //End//
                //}            
                
                //End//


		echo json_encode($arryProduct[0]);exit;

		break;
		exit;

	
	case 'SelectItem' :
		(empty($_GET["str"]))?($_GET["str"]=""):("");
		 $pagerLink='';
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
                                                         <td width="8%"  class="head1">Total Qty</td>
                                                        <td width="12%"  class="head1">Taxable</td>
                                                    </tr>';
                                if (is_array($arryProduct) && count($arryProduct) > 0) {
                                    $flag = true;
                                    $Line = 0;
                                    foreach($arryProduct as $key => $values) {
                                        $flag = !$flag;
                                        $Line++;
																				$arryCondQty=$objItem->getCountItemCondion($values['Sku'],'');


                                        if (empty($values["Taxable"])){ $values["Taxable"] = "No"; }
                                                 $arryOption = $objItem->getOptionCode($values["ItemID"]);//By Chetan 22Sep//

						$AliasNum=0;

                                                if(isset($arryAlias)) $AliasNum = sizeof($arryAlias);
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
                                    <td>'.stripslashes($arryCondQty[0]['totQty']).'</td>
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

 //*****************************************Amit Singh**************************************
          
            if(!empty($_GET['price_id']) && !empty($_GET['row'])){
                
                $objItem=new items(); 
               
              $arryItmPrice = $objItem->GetAttributPrice($_GET['price_id']);
                echo json_encode($arryItmPrice[0]);exit;
                
            }
            
            
        //*********************************************************************************************


//*****************************************Sanjiv Singh**************************************
            if($_POST['Action']=='AddComment'){ 
            	
            	if(empty($Config['TodayDate'])) $Config['TodayDate'] = $_SESSION['TodayDate'];
            	
            	require_once($Prefix."classes/finance.account.class.php");
            	$objBankAccount = new BankAccount();
            	
            	if($_POST['module_type']>0) {
            		
            		$_POST['master_comment_id'] = $_POST['module_type'];
            		echo $cmtID = $objBankAccount->AddComment($_POST); 
            		if(!empty($_POST['order_id']) && $cmtID){
            			$comments = $_POST['MultiComment'].'##'.$cmtID;
            			$objBankAccount->updateSalesOrderComment($comments, $_POST['order_id']);
            		}
            		exit;
            		
            	}else{ 
            		
	            	$_POST['module_type'] = 'sales';
	            	$_POST['type'] = 'custom';
	            	if($_POST['comment']){
	            	$mstcmtID = $objBankAccount->AddMasterComment($_POST);
	            	$_POST['master_comment_id'] = $mstcmtID;
	            	$cmtID = $objBankAccount->AddComment($_POST);
	            	if(!empty($_POST['order_id']) && $cmtID){
		            	$comments = $_POST['MultiComment'].'##'.$cmtID;
		            	$objBankAccount->updateSalesOrderComment($comments, $_POST['order_id']);
	            	}
	            	echo $cmtID;
	            	}else 
	            	echo 0;
	            	
            	}
            	exit;
            
            }
            
            if($_POST['Action']=='DeleteComment'){
            	if(!empty($_POST['commentID'])){
            		require_once($Prefix."classes/finance.account.class.php");
            		$objBankAccount = new BankAccount();
            		$objBankAccount->DeleteComment((int) $_POST['commentID'],(int) $_POST['masterCommentID']); 
            		$comments = str_replace('##'.$_POST['commentID'],'', $_POST['MultiComment']);
            		$objBankAccount->updateSalesOrderComment($comments, $_POST['order_id']);
            		echo 1;
            	}else{
            		echo 0;
            	}
            	exit;
            }


	// ali 10 may 2018//
            if($_POST['action']=='ShippingAccountCustomer'){
                $objCustomer = new Customer();
                $arryShipAccount=$objCustomer->ListCustShipAccount($_POST['Type'],$_POST['CustID']);
                //echo (!empty($arryShipAccount)) ? $arryShipAccount[0]['api_account_number'] : '';
		echo "<option>--- Select ---</option>";
		foreach($arryShipAccount as $key=>$values){
		     $sel = ($values['defaultVal']==1)?("selected"):(""); 
		    echo "<option value='".$values['api_account_number']."' ".$sel.">".$values['api_account_number']."</option>";
		    
		}
		echo "<option value='Add New'>Add New</option>";
            }
            // ali 10 may 2018//
            
             if($_POST['action']=='ShippingAccountWarehouse'){
			(empty($_POST['SuppCode']))?($_POST['SuppCode']=""):("");  
                   $objShipment = new shipment();
                   #$arryShipAccount=$objCustomer->ListCustShipAccount($_POST['Type'],$_POST['SuppCode']);
                   $arryShipAccount=$objShipment->ListShipAccount($_POST['Type'],$_POST['SuppCode']);
                   $res=array();
                           $option = "<option>--- Select ---</option>";
                           foreach($arryShipAccount as $key=>$values){
                               $sel = ($values['defaultVal']==1)?("selected"):(""); if($sel=='selected'){    
                               $vendor = $values['SuppCode'];                     
                                }
                               $option .="<option value='".$values['api_account_number']."' ".$sel.">".$values['api_account_number']."</option>";
                           }
                           $option .= "<option value='Add New'>Add New</option>";
                           
                           $res[0]['option'] = $option;
                           $res[0]['vendor'] = $vendor;
                           
                           echo json_encode($res[0]); exit;
          }
            
              if($_POST['action']=='CustomerPO'){
                $objSale = new sale();
                $arryCustomerPO=$objSale->checkCustomerPO($_POST['CustomerPO']);
                
                if($arryCustomerPO==1){
                echo $_POST['CustomerPO']." matches another sales order. ";
                
                }
                //echo (!empty($arryShipAccount)) ? $arryShipAccount[0]['api_account_number'] : '';
		
            }
            
//*********************************************************************************************
//added by nisha on 24 july 2018
        if($_POST['action']=='GetCommisionPercentage')  {
            require_once($Prefix."classes/employee.class.php");
            $objEmployee     = new Employee();  

	    $empIds = (!empty($_POST['empIds']))?($_POST['empIds']):("");
	    $Type = (!empty($_POST['Type']))?($_POST['Type']):("");
	    $vendIds = (!empty($_POST['vendIds']))?($_POST['vendIds']):("");
	    $prevVendSales = (!empty($_POST['prevVendSales']))?($_POST['prevVendSales']):("");
	    $prevSales = (!empty($_POST['prevSales']))?($_POST['prevSales']):("");

           // echo $empIds; echo "<br/>"; echo $Type; echo "<br/>"; echo $prevType; echo "<br/>"; echo $prevSales; exit;
            $totalPercentage = $objEmployee->GetCommisionPercentage($empIds,$Type,$vendIds,$prevVendSales,$prevSales);
		    echo json_encode($totalPercentage);exit;
        }
 // added by nisha on 10 sept 2018
  if($_POST['action']=='updateCommisionPercentage')  {
  	$objCustomer = new Customer();
  	$commission_per = $_POST['commission_per'];
  	$id             = $_POST['id'];
  	if(!empty($id)){
      $objCustomerCommPer = $objCustomer->updateCustomerSaleCommission($id,$commission_per);
      $result = array("msg"=>"Sales Person Commission has been updated successfully.");
  	}
  	else
  	{
  		 $result = array("msg"=>"Some Error Occured..Please Try Again.");

  	}
   echo json_encode($result); exit;
    
  }     


?>
