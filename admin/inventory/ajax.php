<?	session_start();
	$Prefix = "../../"; 
	require_once($Prefix."includes/config.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/paging.class.php");   
	require_once($Prefix."classes/custom_search.class.php");    
	require_once($Prefix."classes/function.class.php");
	require_once("../language/english.php");

	if(empty($_SERVER['HTTP_REFERER'])){
		//echo 'Protected.';exit;
	}
	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}

    (empty($AvgCost))?($AvgCost="0.00"):(""); 

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
	include("../includes/common.php");


 	(empty($_GET['action']))?($_GET['action']=""):("");
	(empty($_POST['action']))?($_POST['action']=""):("");
 

	switch($_GET['action']){
		case 'delete_upload_file':
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








								
	}
	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}



	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/


	switch($_GET['action']){
            
          
		case 'ItemInfo':
			(empty($_GET['proc']))?($_GET['proc']=""):("");


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
           case 'SearchBomCode':
			$objItem=new items(); 
			$_GET['proc']='Sale';
			$_GET['Status'] = 1;
			$objBom = new bom();
			if(!isset($_GET['ItemID'])) $_GET['ItemID']='';


				$arryProduct=$objItem->GetBOMItemsSelect($_GET);

				if(!empty($arryProduct[0]['ItemID'])){
					if($_GET['proc']=='Purchase'){
						$arryProduct[0]['price'] = $arryProduct[0]['purchase_cost'];
					}else if($_GET['proc']=='Sale'){
						$arryProduct[0]['price'] = $arryProduct[0]['sell_price'];
					}else{
						$arryProduct[0]['price'] = 0;
					}

				}

				$arryRequired = $objItem->GetRequiredItem($_GET['ItemID'],'');
				$NumRequiredItem = sizeof($arryRequired);
				$RequiredItem = '';			
				/*if($NumRequiredItem>0){
					foreach($arryRequired as $key=>$values){
						$RequiredItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
					}
					$RequiredItem = rtrim($RequiredItem,"#");
				}
				$arryProduct[0]['RequiredItem'] = $RequiredItem;*/
				$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
                              
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;	
 case 'SearchBillNumber':
			$objItem=new items(); 
			$_GET['proc']='Sale';
			$_GET['Status'] = 1;
			$objBom = new bom();
			
			(empty($_GET['ItemID'])) ? ($_GET['ItemID']='') : (""); 

				$arryProduct=$objItem->GetBOMItemsSelect($_GET);
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

/*****************************BOM****************************/
	case 'BillNumberCode':

		$objBom = new bom();
		$arryProduct=$objBom->ListBOM('',$_GET['key'],'b.Sku','','');

		/*if($arryProduct[0]['bomID']>0){
			$arryBomItem = $objBom->GetBOMStock($arryProduct[0]['bomID'],'');

		$NumBomItem = sizeof($arryBomItem);
$BomItem = '';			
				if($NumBomItem>0){
					foreach($arryBomItem as $key=>$values){
						$BomItem .= stripslashes($values["item_id"]).'|'.stripslashes($values["sku"]).'|'.stripslashes($values["description"]).'|'.stripslashes($values["bom_qty"]).'|'.stripslashes($values["qty_on_hand"]).'#';
					}
					$BomItem = rtrim($BomItem,"#");
				}
		}
				$arryProduct[0]['BomItem'] = $BomItem;
				$arryProduct[0]['NumBOMItem'] = $NumBomItem;*/
		if(!empty($arryProduct[0])){
	           echo json_encode($arryProduct[0]);exit;
		}

	break;
	exit;
/*************************************/		

           case 'ReqItemCode':
			$objItem=new items(); 
			//$_GET['proc']=='Sale';
			$_GET['Status'] = 1;
			$arryProduct=$objItem->GetBOMItemsSelect($_GET);
			
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;		




                


	case 'Getwritedata':
			$objItem=new items(); 
if($_GET['type']!=''){
			  if($_GET['type'] == 'Group' && !empty($_GET['CategoryID'])){ 
				$arryProduct =$objItem->getAllCatItemsQtyandCostById($_GET['CategoryID']);
				 
			  }else if($_GET['type'] == 'Inventory') {
			 	$arryProduct = $objItem->getAllinvqtyandcost();
			  }

$arryQty = $objItem->GetAvgSerialPrice('',$_GET);
$arryProduct[0]['price'] = $arryQty[0]['price'];
$arryProduct[0]['TotQty'] =$arryQty[0]['TotQty'];
$arryProduct[0]['TotCost'] = $arryQty[0]['TotCost'];

}
        	echo json_encode($arryProduct[0]);exit;
        	
        		break;
			exit;	

case 'SelectItem' :
			$objItem=new items();   
                                $objPager = new pager();
                                $arr = array('page'=>$_GET['page']);
                                $_GET['Status'] = 1;
                                if($_GET['str']=='')
                                {
                                    $arryProduct = $objItem->GetItemsViewForSale($_GET);
                                }else{
                                    $arryProduct = $objItem->checkItemSku($_GET['str']);
                                }  
                                $num=$objItem->numRows();
                                $arrayConfig = $objConfig->GetSiteSettings(1);	
                                $RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];
                                if($RecordsPerPage == 10)
                                {
                                    $RecordsPerPage = $RecordsPerPage;
                                }
                                else{
                                    $RecordsPerPage = 10;
                                }
                                
                                $pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
                                (count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 
                             $AjaxHtml =  '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                        <td align="center" height="20">
                                            <div id="msg_div" class="redmsg"></div>
                                        </td>
                                    </tr>	

                                    <tr>
                                        <td align="right" valign="top">
                                            <form name="frmSrch" id="frmSrch" action="" method="post">
                                                <input type="text" id="search" placeholder="SEARCH KEYWORD" class="textbox autocomplete" size="20" maxlength="30" value="">&nbsp;<input type="button" id="go" value="Go" class="search_button">
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
                                                        <td width="20%" class="head1" >Purchase Cost ['.$Config['Currency'].'] </td>
                                                        <td width="16%" class="head1" >Sale Price ['.$Config['Currency'].']</td>
                                                        <td width="12%" class="head1" >Qty on Hand</td>
                                                        <td width="12%"  class="head1">Taxable</td>
                                                    </tr>';
                                if (is_array($arryProduct) && count($arryProduct) > 0) {
                                    $flag = true;
                                    $Line = 0;
                                    foreach($arryProduct as $key => $values) {
                                        $flag = !$flag;
                                        $Line++;
                                        if (empty($values["Taxable"])){ $values["Taxable"] = "No"; }
                                                 $arryOption = $objItem->getOptionCode($values["ItemID"]);//By Chetan 22Sep//
                                                $AliasNum = sizeof($arryAlias);
                                                $compo = $objItem->GetKitItem($values["ItemID"]);   //By Chetan 14Aug//
                                                
                                        
                           $AjaxHtml .= '<tr align="left" valign="middle" bgcolor="'.$bgcolor.'">
                                    <td>';
                                    
                                        if(count($arryOption) > 0  && $values['itemType'] == 'Kit'){ //By Chetan 22Sep//
                            $AjaxHtml .=   '<a class="fancybox fancybox.iframe" title="Click to select"  href="getOptionCode.php?ItemID='.$values["ItemID"].'&key='.$values["Sku"].'&id='.$_GET["id"].'&proc='.$_GET["proc"].'" >'.$values["Sku"].'</a>';
                                        } else { 
                                        if(count($compo) > 0 && $values['itemType'] == 'Kit'){
                                           
                            $AjaxHtml .=   '<a onclick="$(\'#compo'.$Line.'\').show();" href="Javascript:void(0)" title="Click to select" >'.$values["Sku"].'</a>';
                                        }else{
                            $AjaxHtml .=   '<a href="Javascript:void(0);" title="Click to select" onclick="Javascript:SetCode(\''.$values["ItemID"].'\',\''.$values["Sku"].'\');" >'.$values["Sku"].'</a>';
                                //  
                                        
                                        }//End//
                                        }
                                    
                            $AjaxHtml .=     '</td>
                                    <td>'.stripslashes($values['description']).'</td>
                                    <td>'.number_format($values['purchase_cost'], 2).'</td>
                                    <td>'.number_format($values['sell_price'], 2).'</td>
                                    <td>'.stripslashes($values['qty_on_hand']).'</td>
                                    <td>'.stripslashes($values['Taxable']).'</td>
                                </tr>';
                                  
				if(count($compo) > 0 && $values['itemType'] == 'Kit' && ($values["bill_option"] != "Yes" || $values["bill_option"] == "") && $AliasNum == 0){
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

/***************Component Item***********************************/

case 'SelectComponentItem' :
			$objItem=new items();   
                                $objPager = new pager();
                                $arr = array('page'=>$_GET['page']);
                                $_GET['Status'] = 1;
                                if($_GET['str']=='')
                                {
                                    $arryProduct = $objItem->GetItemsViewForSale($_GET);
                                }else{
                                    $arryProduct = $objItem->checkItemSku($_GET['str']);
                                }  
                                $num=$objItem->numRows();
                                $arrayConfig = $objConfig->GetSiteSettings(1);	
                                $RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];
                                if($RecordsPerPage == 10)
                                {
                                    $RecordsPerPage = $RecordsPerPage;
                                }
                                else{
                                    $RecordsPerPage = 10;
                                }
                                
                                $pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
                                (count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 
                             $AjaxHtml =  '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                        <td align="center" height="20">
                                            <div id="msg_div" class="redmsg"></div>
                                        </td>
                                    </tr>	

                                    <tr>
                                        <td align="right" valign="top">
                                            <form name="frmSrch" id="frmSrch" action="" method="post">
                                                <input type="text" id="search" placeholder="SEARCH KEYWORD" class="textbox autocomplete" size="20" maxlength="30" value="">&nbsp;<input type="button" id="go" value="Go" class="search_button">
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
                                                        <td width="20%" class="head1" >Purchase Cost ['.$Config['Currency'].'] </td>
                                                        <td width="16%" class="head1" >Sale Price ['.$Config['Currency'].']</td>
                                                        <td width="12%" class="head1" >Qty on Hand</td>
                                                        <td width="12%"  class="head1">Taxable</td>
                                                    </tr>';
                                if (is_array($arryProduct) && count($arryProduct) > 0) {
                                    $flag = true;
                                    $Line = 0;
                                    foreach($arryProduct as $key => $values) {
                                        $flag = !$flag;
                                        $Line++;
                                        if (empty($values["Taxable"])){ $values["Taxable"] = "No"; }
                                                 $arryOption = $objItem->getOptionCode($values["ItemID"]);//By Chetan 22Sep//
                                                $AliasNum = sizeof($arryAlias);
                                                $compo = $objItem->GetKitItem($values["ItemID"]);   //By Chetan 14Aug//
                                                
                                        
                           $AjaxHtml .= '<tr align="left" valign="middle" bgcolor="'.$bgcolor.'">
                                    <td>';
                                    
                                        if(count($arryOption) > 0  && $values['itemType'] == 'Kit'){ //By Chetan 22Sep//
                            $AjaxHtml .=   '<a class="fancybox fancybox.iframe" title="Click to select"  href="getOptionCode.php?ItemID='.$values["ItemID"].'&key='.$values["Sku"].'&id='.$_GET["id"].'&proc='.$_GET["proc"].'" >'.$values["Sku"].'</a>';
                                        } else { 
                                        if(count($compo) > 0 && $values['itemType'] == 'Kit'){
                                           
                            $AjaxHtml .=   '<a onclick="$(\'#compo'.$Line.'\').show();" href="Javascript:void(0)" title="Click to select" >'.$values["Sku"].'</a>';
                                        }else{
                            $AjaxHtml .=   '<a href="Javascript:void(0);" title="Click to select" onclick="Javascript:SetCode(\''.$values["ItemID"].'\',\''.$values["Sku"].'\');" >'.$values["Sku"].'</a>';
                                //  
                                        
                                        }//End//
                                        }
                                    
                            $AjaxHtml .=     '</td>
                                    <td>'.stripslashes($values['description']).'</td>
                                    <td>'.number_format($values['purchase_cost'], 2).'</td>
                                    <td>'.number_format($values['sell_price'], 2).'</td>
                                    <td>'.stripslashes($values['qty_on_hand']).'</td>
                                    <td>'.stripslashes($values['Taxable']).'</td>
                                </tr>';
                                  
				if(count($compo) > 0 && $values['itemType'] == 'Kit' && ($values["bill_option"] != "Yes" || $values["bill_option"] == "") && $AliasNum == 0){
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


/**********************End*****************************************/

	      

	 case 'Generation':

	 
			$objItem = new items();
            $ModelValue=rtrim($_GET['ModelId'],',') ;         
			//echo $ModelValue;exit(); 
				$ArrGetGen = $objItem->GetGenrationBasedOnModel($ModelValue);
         
			$num = sizeof($ArrGetGen);
			
	           for($i=0;$i<$num;$i++)
	            {
	            	 $strGen .= $ArrGetGen[$i]['Generation'].",";
		

				}
				
				
		$arr = explode(',',rtrim($strGen,','));
		$GenN=array_unique($arr);
		sort($GenN);


		$GValue=$_GET['GenVal'] ;
		$arrr = explode(',',rtrim($GValue,','));
		$GenValue=array_unique($arrr);
                 
		$Linegen='';
		$Line=0;	
$AjaxHtml = '<table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>';
                      
                foreach($GenN as $gen)
                  { 
                    if(!empty($gen))
                    {
                    $Linegen +=$GenN[$j]+',';	
                    $checkedsel = (in_array($gen, $GenValue))?("checked"):("");	
                $AjaxHtml.='<td align="left"  valign="top" width="220" height="20">
                
				<input  type="checkbox" '.$checkedsel.' name="Generation"  id="Generation'.$Line.'" value="'.$gen.'" onclick="Javascript:CheckGeneration();">'.$gen.'


											
			</td>';
               // $Linegen=$j+1;
              //  $AjaxHtml .= '<input type="hidden" name="Generationid" id="Generationid" value="'.$Linegen.'" >';
               // $Linegen=$j+0;
                	$Line=$Line+1; 
                    }
					}	
					  
         	$AjaxHtml .='</tr> </table>';
         
			$AjaxHtml .= '<input type="hidden" name="Generationid" id="Generationid" value="'.sizeof($GenN).'" >';
						
		echo $AjaxHtml; exit;
			
                      
         

			
			//}
			 break;
			 exit; 

			   case 'GetGenVal':
                 //$objItem = new items();
            $GenVal=$_GET['GenValue'] ;  

            echo	print_r($GenVal);exit; 
			//echo $GenVal;exit(); 
                 
                // echo $AjaxHtml; exit;
			
                      
         

			
			//}
			 break;
			 exit;     

case 'EditGeneration':

	 
			$objItem = new items();
            $ModelValue=rtrim($_GET['ModelId'],',') ;         
			//echo $ModelValue;exit(); 
				$ArrGetGen = $objItem->GetGenrationBasedOnModel($ModelValue);
         
			$num = sizeof($ArrGetGen);
			
	           for($i=0;$i<$num;$i++)
	            {
	            	 $strGen .= $ArrGetGen[$i]['Generation'].",";
		

				}
				
				
		$arr = explode(',',rtrim($strGen,','));
		$GenN=array_unique($arr);
		sort($GenN);


		$GValue=$_GET['GenVal'] ;
		$arrr = explode(',',rtrim($GValue,','));
		$GenValue=array_unique($arrr);
                 
		$Linegen='';
		$Line=0;	
$AjaxHtml = '<table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>';
                      
                foreach($GenN as $gen)
                  { 
                    if(!empty($gen))
                    {
                    $Linegen +=$GenN[$j]+',';	
                    $checkedsel = (in_array($gen, $GenValue))?("checked"):("");	
                $AjaxHtml.='<td align="left"  valign="top" width="220" height="20">
                
				<input  type="checkbox" '.$checkedsel.' name="Generation"  id="Generation'.$Line.'" value="'.$gen.'" onchange="Javascript:return EditCheckGeneration(this.value);">'.$gen.'


											
			</td>';
               // $Linegen=$j+1;
              //  $AjaxHtml .= '<input type="hidden" name="Generationid" id="Generationid" value="'.$Linegen.'" >';
               // $Linegen=$j+0;
                	$Line=$Line+1; 
                    }
					}	
					  
         	$AjaxHtml .='</tr> </table>';
         
			$AjaxHtml .= '<input type="hidden" name="Generationid" id="Generationid" value="'.sizeof($GenN).'" >';
						
		echo $AjaxHtml; exit;
			
                      
         

			
			//}
			 break;
			 exit; 

			   case 'GetGenVal':
                 //$objItem = new items();
            $GenVal=$_GET['GenValue'] ;  

            echo	print_r($GenVal);exit; 
			//echo $GenVal;exit(); 
                 
                // echo $AjaxHtml; exit;
			
                      
         

			
			//}
			 break;
			 exit;  
			 
			 
			  case 'DisplayVal':
   
     $objItem=new items();
     (empty($_GET['c'])) ? ($_GET['c']='') : (""); 
     (empty($_GET['CatID'])) ? ($_GET['CatID']='') : (""); 
     (empty($_GET['Sku'])) ? ($_GET['Sku']='') : (""); 
     (empty($totalValue)) ? ($totalValue='') : (""); 
     (empty($toalQty)) ? ($toalQty='') : (""); 

     $_GET['Status']=1;
     $arryCat=$objItem->categoryChild($_GET['CatID']);
     $result =array(); 
     $_GET['InData'] = $arryCat.$_GET['CatID'];
     $_GET['InData'] = preg_replace('/^,+|,+$/', '', $_GET['InData']);
     $_GET['CatID'] ='';
       

        $arryQuant=$objItem->GetSerialqtyAvg($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$_GET["Sku"],$_GET['InData']);
       
       #pr($arryQuant);
	//$arryProduct=$objItem->GetItemsView($_GET);
	
	$num=$objItem->numRows();
        
        $Data ='<td  colspan="3" class="no_record"><table '.$table_bg.' id="list_table" >
                 <tr align="left">
                 <td width="20%" class="head1">Sku</td>
                 <td class="head1" width="10%" >Condition</td>
                 <td class="head1" width="10%" >Quantity</td>
                 <td class="head1" width="10%" >Cost</td>
                 <td class="head1" align="right" >Total Cost</td>
               </tr>';


         if (!empty($arryQuant)) {
                $flag = true;
                $Line = 0;

                foreach ($arryQuant as $key => $values) {
                       $flag = !$flag;
                       $bgcolor=($flag)?(""):("#FAFAFA");
                       $Line++;
                       $qtyonhand=0;
			(empty($values["ItemID"])) ? ($values["ItemID"]='') : (""); 
			#$Qty = $objItem->getserialqtybycat($values["Sku"],$values['Condition']);

                       $Unitcost = ($values['srQt']>0)?($values['conAmt']/$values['srQt']):(0) ;
                       $qtyonhand = $values['srQt'];
                       $totalamount = $Unitcost * $qtyonhand; 
                       $totalValue +=$totalamount; 
                       $toalQty += $qtyonhand;    
                       $Data .='<tr align="left" valign="middle" bgcolor="'.$bgcolor.'">
                       <td><a href="Javascript:void(0)" onclick="Javascript:SetItemCode('.$values["ItemID"].','.$values["Sku"].');">'.$values["Sku"].'</a></td>
                        <td>'.$values['Condition'].'</td>
                       <td>'.$values['srQt'].'</td>
                       <td>'.number_format($Unitcost,2).'</td>
                       <td align="right">'. number_format($totalamount,2).'</td>
                       </tr>';
                }


                $Data .='</table></td>';
         }  
         
echo json_encode($Data);  exit; 
			 
			  break;
			 exit; 
			 
			 

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}



	//By chetan 11Mar//
        case'customsearchmodulefields':
					$objCS= new customsearch();
					if($_GET['moduleID']>0){ 
					$results = $objCS->getAllFldFrTableByModID($_GET['moduleID']);
                                        
					if(!empty($results)){
					
						$html = '<select class="inputbox" ><option value="">--Select Column--</option>';
						foreach ($results as $key=> $val){
							$html.= '<option data-type="'.$val['type'].'" value="'.$val['fieldname'].'">'.$val['fieldlabel'].' </option>';
						}
						
                                        $html .= '</select>';
						}
					} 

					echo $html;exit;
        
        
        
        //End//

	 //By chetan 11Mar//
                case'customsrchmodfldsToDisplay':
					$objCS= new customsearch();
					if($_GET['moduleID']>0){ 
					$results = $objCS->getAllFldFrTableByModID($_GET['moduleID'],'3');
                                        
					if(!empty($results)){
					
						$html = '<select class="inputbox" ><option value="">--Select Column--</option>';
						foreach ($results as $key=> $val){
							$html.= '<option value="'.$val['fieldname'].'">'.$val['fieldlabel'].' </option>';
						}
						
                                        $html .= '</select>';
						}
					} 

					echo $html;exit;
        
        
        
        //End//


		//by chetan 23Jan 2017//updated by chetan 21Sep2017// 
		case'getCSItemonCondition': 

				$strSkuID='';
				$objItem=new items();
				$csearch = new customsearch(); 
				$arr = array();

				(empty($_POST['sku']))?($_POST['sku']=""):("");   
				(empty($_POST['condition']))?($_POST['condition']=""):("");   
				(empty($_POST['qty']))?($_POST['qty']=""):("");   
				(empty($_POST['WID']))?($_POST['WID']=""):("");  
				(empty($_POST['ItemID']))?($_POST['ItemID']=""):("");  
 				(empty($_POST['serial']))?($_POST['serial']=""):("");  
				$QTY = 1;

				$arryCondQty=$objItem->getItemCondion($_POST['sku'],$_POST['condition']);
				$numQty =count($arryCondQty);

				if($_POST['qty']>1){
					$QTY = $_POST['qty'];
				} 

				 
				$AjaxHtml='';
				//updated by chetan on 21Sep2017//
				$pairQty = $csearch->pairQuantNo($_POST,$_POST['condition'],'',$_POST['WID']);  
				//$CompAvgCost = $csearch->pairQuantNo($_POST,$_POST['condition'],'avgcost',$_POST['WID']);
				$CompAvgCost = $csearch->fullKitscost($_POST,$_POST['condition'], $_POST['WID']);
				//End// 					
				//added by chetan on 21Sep2017//
				$optionsArr = $objItem->getOptionCode($_POST['ItemID']);

				$AvgCostPrice=0;

				if(empty($optionsArr))
				{	
					if (is_array($arryCondQty) && $numQty > 0) 						{					
						$CondQty = $arryCondQty[0];
						$ItemDtl = $objItem->GetItemById($_POST['ItemID']);
						$AvgCost = $csearch->compItemTableHtml($_POST['condition'],$ItemDtl[0],$arr, $_POST['WID']);	

						if(!empty($AvgCost[0]['price'])){
							$AvgCostPrice = $AvgCost[0]['price'];
						} 				
					}					
 
					$avgcst = $AvgCostPrice + floatval($CompAvgCost);
				}else{
					$avgcst = $CompAvgCost;
				}				
				//End//
				
				if(empty($CondQty['condition_qty'])) $CondQty['condition_qty']=0;

				$arr['qty'] = (int)$CondQty['condition_qty'] + (int)$pairQty;
				$arr['avgcost'] = $avgcst*$QTY; //added by chetan on 21Sep2017//
                                
				$condqty = !empty($arr['qty']) ? ((int)$arr['qty'])  : '0';
				$AjaxHtml .= "<td>$condqty</td>";
				$AjaxHtml .= '<td>'.number_format($arr['avgcost'],2).'  '.$Config['Currency'].'<input type="hidden" name="avgcost" id="avgcost" value="'.$arr['avgcost'].'"></td>';
			 	/*}else{//updated by chetan on 21Sep2017//
				$arr['qty'] = (($pairQty) ? (int)$pairQty  : 0);
				$arr['avgcost'] = (($CompAvgCost) ? $CompAvgCost  : 0); 
				$AjaxHtml .= '<td>'.$arr['qty'].'</td><td>'.number_format($arr['avgcost'],2).'  '.$Config['Currency'].'<input type="hidden" name="avgcost" id="avgcost" value="'.$arr['avgcost'].'"></td>';
				//END//
				}*/
					
				if($_POST['serial']==1){ 
					$AjaxHtml .= '<td  width="20%"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku='.$_POST['sku'].'&pop=1&Condition='.$_POST['condition'].'&WID='.$_POST['WID'].'"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>';
				}	
					$arr['html'] = $AjaxHtml;
				echo json_encode($arr);exit;

		//End//

        }
(empty($_POST['action']))?($_POST['action']=""):("");

if($_POST['action'] == 'checkSerialNumber'){
			$objBom = new bom();
                         $strSkuID='';
			if(!empty($_POST['allSerialNo'])){
													$allSerialNo = $_POST['allSerialNo'];
													$allserdesc = $_POST['allserdesc'];
													$allserPrice = $_POST['allserPrice'];
													 
$Conditi = (!empty($_POST['Conditi']))?($_POST['Conditi']):("");


                            $explodeSerialNo = explode("|",$allSerialNo);
                           #echo "<pre>";
                           #print_r($explodeSerialNo);exit;
//$strSkuID = array();
                            foreach ($explodeSerialNo as $serialNumber){ 
                               
                                $SkuID = $objBom->checkSerialDisassemble($serialNumber,$_POST['Sku'],$Conditi);
                                if(!empty($SkuID)){
                                   $strSkuID .= $serialNumber."|";
                                }
                            }


 
                        echo $AjaxHtml = rtrim($strSkuID,"|"); exit;
			
			}
			 break;
			 exit; 
}





//added by chetan for import on 29Aug2017//

if(isset($_POST['BackgroundExec']) && $_POST['BackgroundExec'] == 'Item'){
	$_SESSION['process'] = 'temp';
        CleanPost();
        $arr = array(); 
	$objItem = new items();
        if(isRunning($_POST['pid'])){
         	$arr['count'] = $objItem->CountForImport();
         	$arr['status'] = 1;
         	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],1);
        }else{
         	$arr['count'] = $objItem->CountForImport();
        	$arr['status'] = 0;
        	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],0);
        }
	
	if($arr['count']==0 && $arr['status']==0 && $arr['per']==0){
		unset($_SESSION['TotalImport']);
		unset($_SESSION['EXCEL_TOTAL']);
		unset($_SESSION['process']);
		unset($_SESSION['pid']); 
	}
	
        echo json_encode($arr);
        exit;
}

function isRunning($pid){
    try{
        $result = shell_exec(sprintf("ps %d", $pid));
        if( count(preg_split("/\n/", $result)) > 2){
            return true;
        }
    }catch(Exception $e){}

    return false;
}

function percentageCountForExcel($count,$totalCount,$status){
	if($status){
		if($count==0) $perc = 11; 
		else if($totalCount==$count) $perc = 100; 
		else $perc = ceil(($count*100)/$totalCount);
	}else{
		if($count>0) $perc = 100;
		else $perc = 0;
	}
	return $perc;
}
//End//

 
?>
			 
