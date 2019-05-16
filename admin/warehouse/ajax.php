<?

session_start();
date_default_timezone_set('America/New_York');
$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix . "includes/function.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix."classes/company.class.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix . "classes/leave.class.php");
require_once($Prefix . "classes/time.class.php");
require_once($Prefix . "classes/bom.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/rma.sales.class.php"); //by ravi 26-01-17
require_once($Prefix."classes/sales.quote.order.class.php"); //by ravi 26-01-17
	require_once($Prefix ."classes/pager.ajax.php");
$objrmasale = new rmasale();
$objPager=new pager();
$objsale = new sale();                         //by ravi 26-01-17
$objConfig = new admin();



if(empty($_SERVER['HTTP_REFERER'])){
		//echo 'Protected.';exit;
	}

	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}
 
/* * ******Connecting to main database******** */
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */
$objCompany=new company(); 
$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
$Config['AdminEmail'] = $arryCompany[0]['Email'];
$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
include("../includes/common.php");


/* if($_GET['ware_name']){
  $objWarehouse = new warehouse();
  $order_data = $objWarehouse->getOrderData($_GET['ware_name']);
  //echo $_GET['ware_name'];
  $htmldata = '<select id="oderdata">';
  foreach($order_data as $odata):
  echo '<option value="'.$odata[''].'"></option>';
  endforeach;

  } */

CleanGet();

	(empty($_GET['action']))?($_GET['action']=""):("");
	(empty($_POST['Action']))?($_POST['Action']=""):("");

switch ($_GET['action']) {
    case 'delete_file':
        if ($_GET['file_path'] != '') {
            unlink($_GET['file_path']);
            echo "1";
        } else {
            echo "0";
        }
        break;
        exit;
    case 'currency':
        $objRegion = new region();
        $arryCurrency = $objRegion->getCurrency($_GET['currency_id'], '');
        echo $StoreCurrency = $arryCurrency[0]['symbol_left'] . $arryCurrency[0]['symbol_right'];
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
			$numCity=0;
			if($_GET['country_id']>0){ 
				if(!empty($_GET['ByCountry'])){
					$arryCity = $objRegion->getCityList('', $_GET['country_id']);
					$numCity = sizeof($arryCity);
				}else if($_GET['state_id']>0){ 
					$arryCity = $objRegion->getCityList($_GET['state_id'], $_GET['country_id']);
					$numCity = sizeof($arryCity);
				}
			} 

				$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				$CitySelected='';
				if(!empty($numCity)){
				$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);
				
				for($i=0;$i<$numCity;$i++) {
				
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
        $objRegion = new region();
        if ($_GET['country_id'] == "0") {
            $AjaxHtml = '<select name="State" id="state_id"  onclick="Javascript: GetStateId();" class="multiselect" multiple size="7">';

            $AjaxHtml .= '<option value="0">All States</option>';

            $AjaxHtml .= '</select>';
        } else {
            $arryState = $objRegion->getStateByCountry($_GET['country_id']);

            $AjaxHtml = '<select name="State" id="state_id" class="multiselect" multiple size="7"  onclick="Javascript: GetStateId();">';

            if ($_GET['select'] == 1) {
                $AjaxHtml .= '<option value="0">All States</option>';
            }

            $StateSelected = (!empty($_GET['current_state'])) ? ($_GET['current_state']) : ($arryState[0]['state_id']);

            for ($i = 0; $i < sizeof($arryState); $i++) {

                $Selected = ($_GET['current_state'] == $arryState[$i]['state_id']) ? (" Selected") : ("");

                $AjaxHtml .= '<option value="' . $arryState[$i]['state_id'] . '" ' . $Selected . '>' . stripslashes($arryState[$i]['name']) . '</option>';
            }

            $Selected = ($_GET['current_state'] == '0') ? (" Selected") : ("");
            if ($_GET['other'] == 1) {
                $AjaxHtml .= '<option value="0" ' . $Selected . '>Other</option>';
            } else if (sizeof($arryState) <= 0) {
                $AjaxHtml .= '<option value="">No state found.</option>';
            }

            $AjaxHtml .= '</select>';
        }




        break;


    case 'zipSearch':
        $objRegion = new region();
	(!isset($AjaxHtml))?($AjaxHtml=""):("");

        if (!empty($_GET['city_id'])) {
            $arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
            for ($i = 0; $i < sizeof($arryZipcode); $i++) {
                $AjaxHtml .= '<li onclick="set_zip(\'' . stripslashes($arryZipcode[$i]['zip_code']) . '\')">' . stripslashes($arryZipcode[$i]['zip_code']) . '</li>';
            }
        }
        break;



    case 'taxstate':
        $objRegion = new region();

        $arryState = $objRegion->getStateByCountry($_GET['country_id']);

        $AjaxHtml = '<select name="State" id="state_id" class="inputbox"   onclick="Javascript: SetMainStateId();">';

        if ($_GET['select'] == 1) {
            $AjaxHtml .= '<option value="0">All States</option>';
        }

        $StateSelected = (!empty($_GET['current_state'])) ? ($_GET['current_state']) : ($arryState[0]['state_id']);

        for ($i = 0; $i < sizeof($arryState); $i++) {

            $Selected = ($_GET['current_state'] == $arryState[$i]['state_id']) ? (" Selected") : ("");

            $AjaxHtml .= '<option value="' . $arryState[$i]['state_id'] . '" ' . $Selected . '>' . stripslashes($arryState[$i]['name']) . '</option>';
        }

        $Selected = ($_GET['current_state'] == '0') ? (" Selected") : ("");
        if ($_GET['other'] == 1) {
            $AjaxHtml .= '<option value="0" ' . $Selected . '>Other</option>';
        } else if (sizeof($arryState) <= 0) {
            $AjaxHtml .= '<option value="">No state found.</option>';
        }

        $AjaxHtml .= '</select>';


        break;
}

if (!empty($AjaxHtml)) {
    echo $AjaxHtml;
    exit;
}


/* * ******Connecting to main database******** */
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */




switch ($_GET['action']) {
    case 'WarehouseInfo':
        $objWarehouse = new warehouse();
        $arryWarehouse = $objWarehouse->GetWarehouse($_GET['WID']);
        echo json_encode($arryWarehouse[0]);
        exit;

        break;
        exit;



    case 'BinInfo':
        $objWarehouse = new warehouse();
        $arryWarehouse = $objWarehouse->GetWarehouseBin($_GET['WID']);
        echo json_encode($arryWarehouse[0]);
        exit;

        break;
        exit;

    case 'ItemInfo':
        $objItem = new items();
        $_GET['Status'] = 1;
        $arryProduct = $objItem->GetItemsView($_GET);
        if ($_GET['proc'] == 'Purchase') {
            $arryProduct[0]['price'] = $arryProduct[0]['purchase_cost'];
        } else if ($_GET['proc'] == 'Sale') {
            $arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
        } else {
            $arryProduct[0]['price'] = 0;
        }
        $arryRequired = $objItem->GetRequiredItem($_GET['ItemID'], '');
        $NumRequiredItem = sizeof($arryRequired);
        $RequiredItem = '';
        if ($NumRequiredItem > 0) {
            foreach ($arryRequired as $key => $values) {
                $RequiredItem .= stripslashes($values["item_id"]) . '|' . stripslashes($values["sku"]) . '|' . stripslashes($values["description"]) . '|' . stripslashes($values["qty"]) . '#';
            }
            $RequiredItem = rtrim($RequiredItem, "#");
        }
        $arryProduct[0]['RequiredItem'] = $RequiredItem;
        $arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
        echo json_encode($arryProduct[0]);
        exit;

        break;
        exit;
case 'BomInfo':
        	$objBom=new bom();
if(!empty($_GET['bomID']) && $_GET['bomID']>0){
        $arryProduct = $objBom->ListBOM($_GET['bomID'],'','','','');
}
       
        echo json_encode($arryProduct[0]);
        exit;

        break;
        exit;
    case 'bin':

        $objWarehouse = new warehouse();

        $arryBin = $objWarehouse->getBinByWarehouse($_GET['warehouse_id']);

        $AjaxHtml = '<select name="Bin" id="bin_id" class="inputbox"   onclick="Javascript: SetMainBinId();">';

        if ($_GET['select'] == 1) {
            $AjaxHtml .= '<option value="">Select Bin Location</option>';
        }

        $StateSelected = (!empty($_GET['current_bin'])) ? ($_GET['current_bin']) : ($arryState[0]['bin_id']);

        for ($i = 0; $i < sizeof($arryBin); $i++) {

            $Selected = ($_GET['current_bin'] == $arryBin[$i]['binid']) ? (" Selected") : ("");
            $AjaxHtml .= '<option value="' . $arryBin[$i]['binid'] . '" ' . $Selected . '>' . stripslashes($arryBin[$i]['binlocation_name']) . '</option>';
        }

        $Selected = ($_GET['current_bin'] == '0') ? (" Selected") : ("");
        if ($_GET['other'] == 1) {
            $AjaxHtml .= '<option value="0" ' . $Selected . '>Other</option>';
        } else if (sizeof($arryBin) <= 0) {
            $AjaxHtml .= '<option value=""><span class="no_record">No Bin Location found.</span></option>';
        }

        $AjaxHtml .= '</select>';


        break;
 case 'checkSerialNumber':  
                    $objWarehouse = new warehouse();                    
                    $allserials = stripslashes($_GET['allSerialNo']);
                    $exist = '';
                    if($allserials!='')
                    {
                        if(strstr($allserials,','))
                        {
                            $arr = explode(',',$allserials);
                            foreach($arr as $str)
                            {
                                $res = $objWarehouse->checktoExistSerialno($str,$_GET['Sku']);
                                if($res)
                                {
                                    $exist.=$str.',';
                                }    
                            }    
                        }else{
                            $res = $objWarehouse->checktoExistSerialno($allserials,$_GET['Sku']);
                            if($res)
                            {
                                $exist.=$allserials.',';
                            }    
                        }
                    $exist = array_filter(explode(',',$exist));
                    $AjaxHtml44 = implode(',',$exist);    
                    break;
                    }
        //End///
echo $AjaxHtml44; exit;

case 'checkSelSerialNo':  
		$objWarehouse = new warehouse();     
 		 
		(empty($_GET['Sku']))?($_GET['Sku']=""):("");
 		(empty($_GET['SelSerialNo']))?($_GET['SelSerialNo']=""):("");
		(empty($_GET['Condition']))?($_GET['Condition']=""):("");
		(empty($_GET['warehouse']))?($_GET['warehouse']=""):("");
 
		$allserials = stripslashes($_GET['SelSerialNo']);
		 
		$exist = '';
		/*********Update Delete serial by bhoodev 18jan2016 *************/
						if(!empty($_GET['delSer'])){
								$objWarehouse->UpdateSerialno($_GET['delSer'],$_GET['Sku'],$_GET['Condition'],0);
						}

					if(!empty($_GET['addSer'])){
							$resSr = $objWarehouse->GetSerialno($_GET['addSer'],$_GET['Sku'],$_GET['Condition'],$_GET['warehouse']);
							if(empty($resSr[0]['UsedSerial'])){
									//$objWarehouse->UpdateSerialno($_GET['addSer'],$_GET['Sku'],$_GET['Condition'],1);
							}else{
								 $rest[0]['Used'] =1;
							}
					}
		/*******************End*******************************************/
		/*
		  if(!empty($allserials)){
				$SelSerialNo = explode(',',$_GET['SelSerialNo']); 
				for($i=0; $i<sizeof($SelSerialNo); $i++){
					$res = $objWarehouse->GetSerialno($SelSerialNo[$i],$_GET['Sku'],$_GET['Condition']);
					#echo $res[0]['UnitCost']."+=";
					$reslt += $res[0]['UnitCost'];
				}

				#print_r( $res); exit;
				$rest[0]['UnitCost'] = $reslt;        
		}*/
 
if(!empty($_GET['SelSerialNoRm'])){
	$SelSerialNoRm = stripslashes($_GET['SelSerialNoRm']);
			//$SelSerialNo = explode(',',$_GET['SelSerialNo']); 
			//print_R($SelSerialNo);die;
			//$reslt= $objWarehouse->GetSerialnoArray($SelSerialNo,$_GET['Sku'],$_GET['Condition']);	
$reslt = $objWarehouse->GetSerialno($SelSerialNoRm,$_GET['Sku'],$_GET['Condition'],$_GET['warehouse']);								
			$reslt=$reslt[0]['UnitCost'];						
	$rest[0]['UnitCost'] = $reslt;        
	}
/*Update by ravi 6 feb2017*/

 
	if(!empty($allserials)){
			$SelSerialNo = explode(',',$_GET['SelSerialNo']); 
			//print_R($SelSerialNo);die;
      $noSr =count($SelSerialNo);
			$reslt= $objWarehouse->GetSerialnoArray($SelSerialNo,$_GET['Sku'],$_GET['Condition'],$_GET['warehouse']);									
			$reslt=$reslt[0]['sum']/$noSr;						
	$rest[0]['UnitCost'] = $reslt;        
	}
/*End*/

		echo json_encode($rest[0]);
		exit;
 
case 'addSelSerialNo':
$data=array();
$responce=array();

$detail=$objrmasale->getSerialDetails($_GET['Sku'],$_GET['condition'],array($_GET['refserial']));

if(!empty($detail[0])){
$data=$detail[0];
$data['ReceiptDate']='';
$data['type']='';
$data['adjustment_no']='';
$data['serialNumber']=$_GET['SelSerialNo'];
$data['UsedSerial']=0;
$objrmasale->SaveItemSerial($data);
$responce=$data;

}

 echo json_encode($responce);
        exit;

break;
case 'SelectAllSerialNo':  
		$objWarehouse = new warehouse();     
		#echo $_GET['SelSerialNo']; exit;    
		$allserials = stripslashes($_GET['SelSerialNo']);
		$exist = '';
		
		if($allserials!=''){
				$SelSerialNo = explode(',',$_GET['SelSerialNo']); 
				for($i=0; $i<sizeof($SelSerialNo); $i++){
					$objWarehouse->UpdateSerialno($SelSerialNo[$i],$_GET['Sku'],$_GET['Condition'],0);
				}

				#print_r( $res); exit;
				$rest[0]['res'] = 'true';        
		}
		echo json_encode($rest[0]);
		exit;


        break;
        exit;

case 'searchSerialNo':  
		$objSale = new sale();     
 
		if(!empty($_GET['SerialNo'])){
			$arrySerial = $objSale->SearchSerialNumber($_GET);

			if(empty($arrySerial[0]['serialID'])){
				$arrySerialNumber[0]['NoSerial'] =0;
			}else{
				$arrySerialNumber = $arrySerial;
			}

		}else{
			$arrySerialNumber[0]['NoSerial'] =0;
		}
		
		echo json_encode($arrySerialNumber[0]);
		exit;
break;
       exit; 


case 'ClearSerial':  
				$objSale = new sale();     

				if(!empty($_GET['LineID'])){
				$objSale->UpdateSerialNumber($_GET);

				$arrySerialNumber[0]['Status']=1;
				}
		echo json_encode($arrySerialNumber[0]);
		exit;
		break;
		exit; 

case 'SelectAllSerial':  
		$objSale = new sale();     
	
$Config['Condition'] = $_GET['condition']; 
$Config['warehouse'] = $_GET['WID'];
$Config['LineID'] =$_GET['LineID'];
$Config['StartPage'] = 0;
$Config['Totalqty'] =$_GET['Totalqty'];
$Config['binid'] =$_GET['binid'];
$arrySerialNumber = $objSale->selectallSerialNumberForItem($_GET['Sku'],$_GET['condition'],$_GET['WID'],$_GET['LineID']);

$serialData = array();
//foreach ($arrySerialNumber as $key => $values) { 
		 //$arrySerialNumber[0]['serial'];
 //$arrySerialNumber[0]['Cost'] = $arrySerialNumber[0]['UnitCost']/$_GET['Totalqty'];

foreach ($arrySerialNumber as $key => $values) {

$serialData[]=$values['serialNumber'];

}

$serial[0]['Serial']= implode(',',$serialData);
$serial[0]['Serial']=rtrim($serial[0]['Serial'],',');
		
		echo json_encode($serial[0]);
		exit;
break;
       exit; 

case 'SetMultiShipment':  
		$objShipment = new shipment();
		
		if(!empty($_GET['OrderIDs'])){
			$arryDetail = $objShipment->GetCutomerShipment($_GET['CustCode'],'',$_GET['OrderIDs'],'');

			 $AjaxHtml = '<table width="100%" class="" border="0" align="center" cellpadding="0" cellspacing="1" >	
				    <tr align="left"  >					
				      <td  class="heading" >Shipment Date</td>
				      <td  width="20%"   class="heading"  >Shipment #</td>
				      <td width="20%"  class="heading"  >SO #</td>
				      <td width="15%"   class="heading" >Amount</td>
				      <td width="10%"  class="heading" >Currency</td>
				  </tr>';

			foreach($arryDetail as $key=>$values){

				$ShippedDate='';
				if($values['ShippedDate']>0) 
		  			 $ShippedDate = date($_SESSION['DateFormat'], strtotime($values['ShippedDate']));				

				$AjaxHtml .= '<tr align="left" class="itembg">
					      <td>'.$ShippedDate.'</td>
					      <td>'.$values["ShippingID"].'</td>
					      <td><a class="fancybox po fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so='.$values['SaleID'].'">'.$values['SaleID'].'</a></td>
					      <td   >'.$values['TotalAmount'].'</td>
					      <td   >'.$values['CustomerCurrency'].'</td>
					</tr>';
			}

		 	$AjaxHtml .= '</table>';
		}

        break;
        exit;
case 'serialList': 
            
           // $serial_value_sel = explode(",",$_GET['SerialValue']);           
            //$serial_value_sel=array_map('trim',$serial_value_sel);

(empty($_GET['sku']))?($_GET['sku']=""):("");
(empty($_GET['SerialValue']))?($_GET['SerialValue']=""):("");


if(!empty($_GET['sku'])){

if(!empty($_GET['MainSku'])){
$_GET['sku'] =$_GET['MainSku'];
}
$SelSerialNumber = $_GET['SerialValue'];
$Config['Condition'] = $_GET['cond'];
$Config['warehouse'] = $_GET['WID'];
$Config['LineID'] =$_GET['LineID'];
$Config['OrderID'] =$_GET['OrderID'];

$objSale = new sale();
//$Config['RecordsPerPage'] = 100;

//$arrySerialcount = $objSale->selectSerialNumberForItem($_GET['sku']);
//$Config['RecordsPerPage'] = 200;
	$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);
$num = sizeof($arrySerialNumber);
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
       $arryCount=$objSale->selectSerialNumberForItem($_GET['sku']);
$numCont=$arryCount[0]['NumCount'];	

$pagerLink=$objPager->getPaging($numCont,$Config['RecordsPerPage'],$_GET['curP'],$_GET['module']);



	 //$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);

	/*******Count Records**********/	

if($num>0){
	 if($num>0){$AjaxHtml  .= '<div><table><tr align="left"  class="'.$class.'" ><td   id="td_pager" align="left"> Pages: '.$pagerLink.'</td></tr>';}
		     }else{
		    	$AjaxHtml  .= '<tr align="center" >
		      		<td  class="no_record">NO RECORDS</td>
		    		</tr>';
		     }
			$AjaxHtml  .= '</table></div>';

}
$AjaxHtml .='<div class="serial-list">
        <h4>Serial List</h4>';
             $serial_value_sel = explode(",",$_GET['SerialValue']);           
            $serial_value_sel=array_map('trim',$serial_value_sel);
            $selectedSerial=array();
       
         $AjaxHtml .='<ul>';
             foreach($arrySerialNumber as $value){             
                $class="";
                if(in_array($value['serialNumber'],$serial_value_sel)){
                  $class="disable";
                  $selectedSerial[] =$value;
                }
								if($value['UsedSerial']==1) $class="disable"; 
             
              $AjaxHtml .='<li data-unitcost="'.$value['UnitCost'].'" data-serial="'.$value['serialNumber'].'" class="serialclass-'. $value['serialNumber'].' serial-li '.$class.' ">
              <label><span>Serial Number</span> : '.$value['serialNumber'].'</label>';
               if(!empty($value['UnitCost'])){
              $AjaxHtml .='<label><span>Unit Cost</span> : '.$value['UnitCost'].'</label>';
                }
                if(!empty($value['description'])){
                  $AjaxHtml .='<label><span>Description</span> : '.$value['description'].'</label>';
                    }
            $AjaxHtml .=' </li>';
              }

         $AjaxHtml .='</ul>';
 $AjaxHtml .='</div>';

$AjaxHtml .='<div class="serial-selected">
          <h4>Serial Selected</h4>
           <ul>';
             if(!empty($selectedSerial )){foreach($selectedSerial as $value){
             $AjaxHtml .='<li data-serial="'.$value['serialNumber'].'" data-unitcost="'.$value['UnitCost'].'" class="serial-selected-li"><label ><label><span>Serial Number</span> : '.$value['serialNumber'].'</label>';
 if(!empty($value['UnitCost'])){
              $AjaxHtml .='<label><span>Unit Cost</span> : '.$value['UnitCost'].'</label>';
                }
if(!empty($value['description'])){
                  $AjaxHtml .='<label><span>Description</span> : '.$value['description'].'</label>';
                    }
$AjaxHtml .='</li>';
             }}

          $AjaxHtml .='</ul>
        </div>';

#echo $AjaxHtml;


 break;




}

if($_POST['allAsmSerialNumber']!='' && $_POST['action']=='allAsmSerialNumber'){
 
 #print_r($_POST); exit;
           $objWarehouse = new warehouse();
           $rest2 =array();
           $SelSerialNo = explode(',',$_POST['allAsmSerialNumber']); 
           for($i=0; $i<sizeof($SelSerialNo); $i++){
              $re2s = $objWarehouse->GetSerialno($SelSerialNo[$i],$_POST['Sku'],$_POST['Condition']);
              #echo $res[0]['UnitCost']."+=";
              $reslt2 += $re2s[0]['UnitCost'];
           }
            $rest2[0]['UnitCost'] = $reslt2;

          # echo $reslt; exit;
echo json_encode($rest2[0]);
		exit;
      }


if($_POST['action']='serialList'){

$AjaxHtml='';
(!isset($_POST['curP']))?($_POST['curP']=1):(""); 

(!isset($_POST['SerialValue']))?($_POST['SerialValue']=""):(""); 

	$Config['RecordsPerPage'] = 1000;
	$Config['StartPage'] = ($_POST['curP']-1)*$Config['RecordsPerPage'];
if(!empty($_POST['sku'])){

if(!empty($_POST['MainSku'])){
$_POST['sku'] =$_POST['MainSku'];
}
$SelSerialNumber = $_POST['SerialValue'];
$Config['Condition'] = $_POST['cond'];
$Config['warehouse'] = $_POST['WID'];
$Config['LineID'] =$_POST['LineID'];
$Config['OrderID'] =$_POST['OrderID'];
$Config['binid'] =$_POST['binid'];

$objSale = new sale();

	$arrySerialNumber = $objSale->selectSerialNumberForItem($_POST['sku']);
$num = sizeof($arrySerialNumber);
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
       $arryCount=$objSale->selectSerialNumberForItem($_POST['sku']);
$numCont=$arryCount[0]['NumCount'];	

(!isset($_POST['module']))?($_POST['module']=''):(""); 
(!isset($class))?($class=''):(""); 
 

$pagerLink=$objPager->getPaging($numCont,$Config['RecordsPerPage'],$_POST['curP'],$_POST['module']);



	 //$arrySerialNumber = $objSale->selectSerialNumberForItem($_GET['sku']);

	/*******Count Records**********/	

if($num>0){
	 if($num>0){$AjaxHtml  .= '<div><table><tr align="left"  class="'.$class.'" ><td   id="td_pager" align="left"> Pages: '.$pagerLink.'</td></tr>';}
		     }else{
		    	$AjaxHtml  .= '<tr align="center" >
		      		<td  class="no_record">NO RECORDS</td>
		    		</tr>';
		     }
			$AjaxHtml  .= '</table></div>';

}

 
$AjaxHtml .='<div class="serial-list">
        <h4>Serial List</h4>';
             $serial_value_sel = explode(",",$_POST['SerialValue']);           
            $serial_value_sel=array_map('trim',$serial_value_sel);
            $selectedSerial=array();
       
         $AjaxHtml .='<ul>';
	 if(!empty($arrySerialNumber)){
             foreach($arrySerialNumber as $value){             
                $class="";
                if(in_array($value['serialNumber'],$serial_value_sel)){
                  //$class="disable";
                  $selectedSerial[] =$value;
                }
								if($value['UsedSerial']==1) $class="disable"; 
             
              $AjaxHtml .='<li data-unitcost="'.$value['UnitCost'].'" data-serial="'.$value['serialNumber'].'" class="serialclass-'. $value['serialNumber'].' serial-li '.$class.' ">
              <label><span>Serial Number</span> : '.$value['serialNumber'].'</label>';
               if(!empty($value['UnitCost'])){
              $AjaxHtml .='<label><span>Unit Cost</span> : '.$value['UnitCost'].'</label>';
                }
                if(!empty($value['description'])){
                  $AjaxHtml .='<label><span>Description</span> : '.$value['description'].'</label>';
                    }
            $AjaxHtml .=' </li>';
              }
	  }

         $AjaxHtml .='</ul>';
 $AjaxHtml .='</div>';


 $AjaxHtml .='<div class="serial-selected"><h4>Serial Selected</h4><ul>';
            if(!empty($selectedSerial )){
$i=1;
foreach($selectedSerial as $value2){
            if($value2['UsedSerial']==1) $class="disable"; 
              $AjaxHtml .='<li data-unitcost="'.$value2['UnitCost'].'" data-serial="'.$value2['serialNumber'].'" class=" serial-selected-li '.$class.' ">
              <label><span>Serial Number</span> : '.$value2['serialNumber'].'</label>';
               if(!empty($value2['UnitCost'])){
              $AjaxHtml .='<label><span>Unit Cost</span> : '.$value2['UnitCost'].'</label><span class="serial-close"></span>';
                }
                if(!empty($value['description'])){
                  $AjaxHtml .='<label><span>Description</span> : '.$value2['description'].'</label>';
                    }
            $AjaxHtml .=' </li>';
            $i++;  
             }}

         $AjaxHtml .=' </ul>';
        $AjaxHtml .='</div>';



echo $AjaxHtml; exit;


         

//$res[0]['list'] = $AjaxHtml;


 




}





?>
