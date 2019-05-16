<?	session_start();

	$Prefix = "../../"; 
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/inv_tax.class.php");	
	require_once($Prefix."classes/MyMailer.php");	
	require_once("language/english.php");
	require_once("../language/english.php");
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
	$objCompany=new company(); 
	$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
	$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
	$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
	$Config['AdminEmail'] = $arryCompany[0]['Email'];
	$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';

	CleanGet();

	(empty($_GET['action']))?($_GET['action']=""):("");
	(empty($_POST['Action']))?($_POST['Action']=""):("");

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

	case 'zipSearch':		
		$objRegion=new region();
		if(!empty($_GET['city_id'])){
			$arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
			for($i=0;$i<sizeof($arryZipcode);$i++) {
				$AjaxHtml .= '<li onclick="set_zip(\''.stripslashes($arryZipcode[$i]['zip_code']).'\')">'.stripslashes($arryZipcode[$i]['zip_code']).'</li>';
			}

		}
		break;


	case 'TaxRateAddress':
		if(!empty($_GET["Country"])){
			$objRegion=new region();
			$arryCountry = $objRegion->GetCountryID($_GET["Country"]);  
			$country_id = $arryCountry[0]['country_id']; //set
			$state_id=0;
			if($country_id>0 && !empty($_GET["State"])){		
				$arryState = $objRegion->GetStateID($_GET["State"], $country_id); 
				$state_id = $arryState[0]['state_id'];//set
			}
		}		             
		//echo $country_id.' : '.$state_id;exit;							
		break;



								
	}
	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}


	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	


	switch($_GET['action']){
		case 'SupplierInfo':
			(empty($_GET['SuppCode']))?($_GET['SuppCode']=""):("");
			(empty($_GET['SuppID']))?($_GET['SuppID']=""):("");
 

			if(!empty($_GET['VendorNameCode'])){
				$arryName = explode("-", $_GET['VendorNameCode']);
				if(!empty($arryName[1])){ 
					$_GET['SuppCode'] = $arryName[1];//SuppCode
				} 
			}


			$objSupplier=new supplier();
			if(!empty($_GET['SuppCode'])){
				$arrySupplier = $objSupplier->GetSupplier('',$_GET['SuppCode'],'');
				if(empty($arrySupplier[0]['Currency'])){ 
					$arrySupplier[0]['Currency'] = $_SESSION['ConfigCurrency'];
				}

			}
 	 
 			if(!empty($_GET['SuppID'])){
				$arryContact = 	$objSupplier->GetVendorShippingContact($_GET['SuppID']);
			}
			
			$shipList='<select name="shipto" class="textbox" id="shipto" onchange="ChangeVanaddress(this.value,\''.$_GET['SuppID'].'\')">';
			
			if(!empty($arryContact)){
			for($count=0;$count<count($arryContact);$count++){
			$address=$arryContact[$count]['Name'].',';
			if($arryContact[$count]['Address']!='') $address .=$arryContact[$count]['Address'].',';
			if($arryContact[$count]['City']!='') $address .=$arryContact[$count]['City'].',';
			if($arryContact[$count]['State']!='') $address .=$arryContact[$count]['State'].',';
			if($arryContact[$count]['Country']!='') $address .=$arryContact[$count]['Country'];
			
			$shipList .='<option  value="'.$arryContact[$count]['AddID'].'">'.$address.'</option>';
			}}
			
			$shipList .='</select>'; 
			$arrySupplier[0]['shipList']=$shipList;

			/// End //////		
			echo json_encode($arrySupplier[0]);exit;

			break;
			exit;
		 // By Rajan 08 Dec //
		case 'VendorAddress':	
			$objSupplier=new supplier();
			$arryContact = $objSupplier->GetVendorShippingContact($_GET['SuppID'],$_GET['ShipId']);
			$arr = array_map('utf8_encode', $arryContact[0]);
			echo json_encode($arr);
	
			break;
			exit;
		//  End /////		

// By rajan 03/02/2016
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
	case 'SerachItemInformationCode':
		
			$objItem=new items(); 
			
			$arryProduct=$objItem->checkItemSku($_GET['key']);
	
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;   


	

		case 'SupplierAddress':
			$objSupplier=new supplier();
			$arrySupplier = $objSupplier->GetSupplierAddressBook($_GET['SuppID'],$_GET['AddID']);	
			echo json_encode($arrySupplier[0]);exit;

			break;
			exit;
                        
                 case 'CustomerInfo':
			$objCustomer = new Customer();
			$arryCustomer = $objCustomer->getCustomerAddressForPO($_GET['CustID']);	
                
                        echo json_encode($arryCustomer[0]);exit;

			break;
			exit;	      


		case 'TaxRateAddress':
			if(!empty($country_id)){
				$objTax=new tax();
				$arrySaleTax = $objTax->GetTaxByLocation(2,$country_id,$state_id);
 
				if(sizeof($arrySaleTax)>0){

					$arrRate = explode(":",$_GET['OldTaxRate']);

					$AjaxHtml = '<select name="TaxRate" id="TaxRate" class="inputbox" onchange="Javascript: freightSett(this.value);" ><option value="0">None</option>';
					for($i=0;$i<sizeof($arrySaleTax);$i++) {

					$Selected = ($arrRate[0] == $arrySaleTax[$i]['RateId'] && $arrRate[2] == $arrySaleTax[$i]['TaxRate'])?(" Selected"):("");

					$AjaxHtml .= "<option freight_tax='".$arrySaleTax[$i]['FreightTax']."' ".$Selected." value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['RateDescription'].":".$arrySaleTax[$i]['TaxRate']."' >
					".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
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


	    //By Chetan//      
                case 'ItemInfo':
			$objItem=new items(); 
			$_GET['AliasID'] = 1;
		$arryProduct=$objItem->checkItemSku($_GET['key']);
 if(empty($arryProduct))
                {
                    $arryAlias = $objItem->checkItemAliasSku($_GET['key']);
                    if(count($arryAlias))
                    {
                        $alias = 1;
                        $arryProduct=$objItem->GetItemById($arryAlias[0]["ItemID"]);
                        $arryProduct[0]['Sku'] = $arryAlias[0]['ItemAliasCode'];
                        $arryProduct[0]['description'] = $arryAlias[0]['description'];
                    }    
                }
			//$arryProduct=$objItem->GetItemsView($_GET);
			if($_GET['proc']=='Purchase'){
				//$arryProduct[0]['price'] = $arryProduct[0]['purchase_cost'];
				if($_GET['SuppCode']!='') {
              				$arryVendorPrice=$objItem->GetPurchaseLastPrice($_GET['SuppCode'],$arryProduct[0]['ItemID'],$_GET['key']);
			$arryProduct[0]['price'] = (!empty($arryVendorPrice[0]['price']))?($arryVendorPrice[0]['price']):('');
         			}else{
				 	$arryProduct[0]['price'] = (!empty($arryProduct[0]['purchase_cost']))?($arryProduct[0]['purchase_cost']):(''); ;
				}
			}else if($_GET['proc']=='Sale'){
				$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
			}else{
				$arryProduct[0]['price'] = 0;
			}

 if(!isset($alias))
                {
			$arryRequired = $objItem->GetRequiredItem($_GET['ItemID'],'');
			$NumRequiredItem = sizeof($arryRequired);
			$RequiredItem = '';			
			if($NumRequiredItem>0){
				foreach($arryRequired as $key=>$values){
					$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
				}
				$RequiredItem = rtrim($RequiredItem,"#");
			}

}else{
                    //By Chetan 8Jan add Sell_price//
                    $arryRequired = $objItem->getAliasRequiredItemByIds($arryProduct[0]['ItemID'],$arryAlias[0]['AliasID']);
                    $NumRequiredItem = sizeof($arryRequired);
                    $RequiredItem = '';			
                    if($NumRequiredItem>0){
                            foreach($arryRequired as $key=>$values){
                                    $RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.stripslashes($values["sell_price"]).'#';
                            }
                            $RequiredItem = rtrim($RequiredItem,"#");
                    }
                }     
			//$arryProduct[0]['RequiredItem'] = $RequiredItem;
			//$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
                        
                        /*By Chetan*/
                      /*  if($_GET['AliasID'])
                        {
                            $arryAliasRequired = $objItem->GetAliasRequiredItem($_GET['AliasID'],'');
                            $NumAliasRequiredItem = sizeof($arryAliasRequired);
                            if($NumAliasRequiredItem>0){
				foreach($arryAliasRequired as $key=>$AliasRequired){
					$AliasRequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["ItemAliasCode"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
				}
				$AliasRequiredItem = rtrim($AliasRequiredItem,"#");
                                $RequiredItem .= '#'.$AliasRequiredItem;
                                $NumRequiredItem = intval($NumRequiredItem + $NumAliasRequiredItem);
                            }   
                        }*/
                       
                        $arryProduct[0]['RequiredItem'] = $RequiredItem;
		$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
                        /*.....*/     
                        
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;

           case 'SerachItemInfoCode': 
			(empty($_GET['SuppCode']))?($_GET['SuppCode']=""):(""); 
			(empty($_GET['key']))?($_GET['key']=""):(""); 
			(empty($_GET['proc']))?($_GET['proc']=""):(""); 

			$objItem=new items(); 
			//$_GET['AliasID'] = 1;
		$arryProduct=$objItem->checkItemSku($_GET['key']);

		if(!empty($arryProduct[0]['valuationType'])){
			$arryProduct[0]['evaluationType'] = $arryProduct[0]['valuationType'];
		}
 
 if(empty($arryProduct))
                {
                    $arryAlias = $objItem->checkItemAliasSku($_GET['key']);
                    if(!empty($arryAlias))
                    {
			$alias = 1;
			$arryProduct=$objItem->GetItemById($arryAlias[0]["ItemID"]);
			$arryProduct[0]['Sku'] = $arryAlias[0]['ItemAliasCode'];
			$arryProduct[0]['description'] = $arryAlias[0]['description'];
			$arryProduct[0]['evaluationType'] = $arryAlias[0]["evaluationType"];
			$arryProduct[0]['ItemID'] = $arryAlias[0]["ItemID"];
                    }    
                }

		if(!isset($arryProduct[0]['evaluationType']))$arryProduct[0]['evaluationType']='';
		if(!isset($arryProduct[0]['ItemID']))$arryProduct[0]['ItemID']='';
		if(!isset($arryProduct[0]['Sku']))$arryProduct[0]['Sku']='';
		if(!isset($arryProduct[0]['sell_price']))$arryProduct[0]['sell_price']='';
		if(!isset($arryProduct[0]['purchase_cost']))$arryProduct[0]['purchase_cost']='';

			//$arryProduct=$objItem->GetItemsView($_GET);
			if($_GET['proc']=='Purchase'){

         if(!empty($_GET['SuppCode'])) {
              //$arryVendorPrice=$objItem->GetPurchaseLastPrice($_GET['SuppCode'],$arryProduct[0]['ItemID'],$_GET['key']);

if($arryProduct[0]['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET,'');
}else if($arryProduct[0]['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET,'');

}else{
$_GET['Sku']  = $arryProduct[0]['Sku'];
$arryVendorPrice=$objItem->GetAvgSerialPrice($arryProduct[0]['ItemID'],$_GET);
//$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
}


							//$arryVendorPrice=$objItem->GetAvgTransPrice($arryProduct[0]['ItemID'],$_GET['key'],'');

if(!empty($arryVendorPrice[0]['price'])){
$arryProduct[0]['price'] = number_format($arryVendorPrice[0]['price'],2);;

}else{
$arryProduct[0]['price'] = 0.00;

}

							//$arryProduct[0]['price'] = $arryVendorPrice[0]['price'];
          }else{

				 $arryProduct[0]['price'] = $arryProduct[0]['purchase_cost'];
				}

			}else if($_GET['proc']=='Sale'){
				$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
			}else{
				$arryProduct[0]['price'] = 0;
			}

 if(!isset($alias))
                {
			$arryRequired = $objItem->GetRequiredItem($arryProduct[0]['ItemID'],'');
			$NumRequiredItem = sizeof($arryRequired);
			$RequiredItem = '';			
			if($NumRequiredItem>0){
				foreach($arryRequired as $key=>$values){
					$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
				}
				$RequiredItem = rtrim($RequiredItem,"#");
			}

}else{
                    //By Chetan 8Jan add Sell_price//
                    $arryRequired = $objItem->getAliasRequiredItemByIds($arryProduct[0]['ItemID'],$arryAlias[0]['AliasID']);
                    $NumRequiredItem = sizeof($arryRequired);
                    $RequiredItem = '';			
                    if($NumRequiredItem>0){
                            foreach($arryRequired as $key=>$values){
                                    $RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'|'.stripslashes($values["sell_price"]).'#';
                            }
                            $RequiredItem = rtrim($RequiredItem,"#");
                    }
                }     
			//$arryProduct[0]['RequiredItem'] = $RequiredItem;
			//$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
                        
                        /*By Chetan*/
                      /*  if($_GET['AliasID'])
                        {
                            $arryAliasRequired = $objItem->GetAliasRequiredItem($_GET['AliasID'],'');
                            $NumAliasRequiredItem = sizeof($arryAliasRequired);
                            if($NumAliasRequiredItem>0){
				foreach($arryAliasRequired as $key=>$AliasRequired){
					$AliasRequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["ItemAliasCode"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
				}
				$AliasRequiredItem = rtrim($AliasRequiredItem,"#");
                                $RequiredItem .= '#'.$AliasRequiredItem;
                                $NumRequiredItem = intval($NumRequiredItem + $NumAliasRequiredItem);
                            }   
                        }*/
                       
                      if(empty($arryProduct[0]['Sku'])){
                       $arryProduct[0]['RequiredItem'] = '';
		                         $arryProduct[0]['NumRequiredItem'] = '';
		                         }else{
                        $arryProduct[0]['RequiredItem'] = $RequiredItem;
		                      $arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
		                      }
                        /*.....*/     
                        
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;             //End//


	}




	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
	
	
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
				$objBankAccount->updatePurchasesOrderComment($comments, $_POST['order_id']);
			}
			exit;
	
		}else{
	
			$_POST['module_type'] = 'purchases';
			$_POST['type'] = 'custom';
			if($_POST['comment']){
				$mstcmtID = $objBankAccount->AddMasterComment($_POST);
				$_POST['master_comment_id'] = $mstcmtID;
				$cmtID = $objBankAccount->AddComment($_POST);
				if(!empty($_POST['order_id']) && $cmtID){
					$comments = $_POST['MultiComment'].'##'.$cmtID;
					$objBankAccount->updatePurchasesOrderComment($comments, $_POST['order_id']);
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
			$objBankAccount->updatePurchasesOrderComment($comments, $_POST['order_id']);
			echo 1;
		}else{
			echo 0;
		}
		exit;
	}
	//*********************************************************************************************
?>
