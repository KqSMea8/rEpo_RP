<?

session_start();
$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix . "includes/function.php");
require_once("../includes/settings.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/employee.class.php");
require_once($Prefix . "classes/event.class.php");
require_once($Prefix."classes/territory.class.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix."classes/sales.customer.class.php");

$objConfig = new admin();
$objLead = new lead();
$objEmployee = new employee();

/* * ******Connecting to main database******** */
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */
CleanGet();
switch ($_GET['action']) {
    case 'delete_file':
        if ($_GET['file_path'] != '') {
            $objConfigure->UpdateStorage($_GET['file_path'], 0, 1);
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
        $objRegion = new region();
        $arryState = $objRegion->getStateByCountry($_GET['country_id']);

        $AjaxHtml = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';

        if ($_GET['select'] == 1) {
            $AjaxHtml .= '<option value="">--- Select State ---</option>';
        }

        $StateSelected = (!empty($_GET['current_state'])) ? ($_GET['current_state']) : ($arryState[0]['state_id']);
        if ($_GET['country_id'] != '') {
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
        } else {
            $AjaxHtml .= '<option value="">No state found.</option>';
        }
        $AjaxHtml .= '</select>';



        $AjaxHtml .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="' . $StateSelected . '">';

        break;


    case 'city':
        $objRegion = new region();
        $arryCity = $objRegion->getCityByState($_GET['state_id']);

        $AjaxHtml = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';

        if ($_GET['select'] == 1) {
            $AjaxHtml .= '<option value="">--- Select City ---</option>';
        }


        $CitySelected = (!empty($_GET['current_city'])) ? ($_GET['current_city']) : ($arryCity[0]['city_id']);
        if ($_GET['state_id'] != '') {
            for ($i = 0; $i < sizeof($arryCity); $i++) {

                $Selected = ($_GET['current_city'] == $arryCity[$i]['city_id']) ? (" Selected") : ("");
                $strName = $arryCity[$i]['name'];

                // $strName=preg_replace('/[^A-Za-z0-9\-]/', '', $strName);

                $AjaxHtml .= '<option value="' . $arryCity[$i]['city_id'] . '" ' . $Selected . '>' . htmlentities($arryCity[$i]['name'], ENT_IGNORE) . '</option>';
            }

            $Selected = ($_GET['current_city'] == '0') ? (" Selected") : ("");
            if ($_GET['other'] == 1) {
                $AjaxHtml .= '<option value="0" ' . $Selected . '>Other</option>';
            } else if (sizeof($arryCity) <= 0) {
                $AjaxHtml .= '<option value="">No city found.</option>';
            }
        } else {
            $AjaxHtml .= '<option value="">No City found.</option>';
        }

        $AjaxHtml .= '</select>';


        $AjaxHtml .= '<input type="hidden" name="ajax_city_id" id="ajax_city_id" value="' . $CitySelected . '">';

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


if (!empty($AjaxHtml)) {
    echo $AjaxHtml;
    exit;
}


/* * ******Connecting to main database******** */
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */

//echo $_GET['action'];
switch ($_GET['action']) {

	case 'CustomerInfo':
			$objCustomer = new Customer();
			$arryCustomer = $objCustomer->GetCustomerAllInformation('',$_GET['CustCode'],'');	
			echo json_encode($arryCustomer[0]);exit;

			break;
			exit;	

 	case 'ItemInfo':
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
            
                         //Get Kit Item
                            $arryKit = $objItem->GetKitItem($_GET['ItemID']);
                            $NumKiItem = sizeof($arryKit);
                            
                            
                         //Get Option Code Item Item
                            if($_GET['optionID'] > 0){
                                $arryOptionCodeItem = $objItem->GetOptionCodeItem($_GET['optionID']);
                                $NumOptionCodeItem = sizeof($arryOptionCodeItem);

                            }
                         /************ARRAy MERGE****************************************************************************/
                                 
                            
                             if($NumRequiredItem > 0 && $NumKiItem > 0 && empty($_GET['optionID'])){ 
                                $RequiredItemAndKitItemArry = array_merge($arryRequired,$arryKit);  
                              }else if($NumKiItem > 0 && empty($_GET['optionID'])){
                                   $RequiredItemAndKitItemArry = $arryKit;  
                              }else{
                                  $RequiredItemAndKitItemArry = $arryRequired; 
                              }
                              
                              
                              //Merge Option Item
                              
                              if($NumOptionCodeItem > 0){
                                  $RequiredItemAndKitItemArry = array_merge($RequiredItemAndKitItemArry,$arryOptionCodeItem);
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
			}
                              
                
                           
                       /********************************************************************************/
                            
                     
                        
			$arryProduct[0]['RequiredItem'] = $RequiredItem;
			$arryProduct[0]['NumRequiredItem'] = $NumRequiredItem;
                
			echo json_encode($arryProduct[0]);exit;

			break;
			exit;


    case 'LeadAddressInfo':
        $objLead = new lead();

        $arryLead = $objLead->GetLead($_GET['LeadID'], '');

        if ($arryLead[0]['leadID'] > 0) {

            /*             * *****Connecting to main database******* */
            $Config['DbName'] = $Config['DbMain'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();
            /*             * **************************************** */
            if ($arryLead[0]['country_id'] > 0) {
                $arryCountryName = $objRegion->GetCountryName($arryLead[0]['country_id']);
                $CountryName = stripslashes($arryCountryName[0]["name"]);
            }

            if (!empty($arryLead[0]['state_id'])) {
                $arryState = $objRegion->getStateName($arryLead[0]['state_id']);
                $StateName = stripslashes($arryState[0]["name"]);
            } else if (!empty($arryLead[0]['OtherState'])) {
                $StateName = stripslashes($arryLead[0]['OtherState']);
            }

            if (!empty($arryLead[0]['city_id'])) {
                $arryCity = $objRegion->getCityName($arryLead[0]['city_id']);
                $CityName = stripslashes($arryCity[0]["name"]);
            } else if (!empty($arryLead[0]['OtherCity'])) {
                $CityName = stripslashes($arryLead[0]['OtherCity']);
            }

            $arryLead[0]['CityName'] = $CityName;
            $arryLead[0]['StateName'] = $StateName;
            $arryLead[0]['CountryName'] = $CountryName;
        } else {
            $arryLead[0]['Address'] = '';
            $arryLead[0]['CityName'] = '';
            $arryLead[0]['StateName'] = '';
            $arryLead[0]['CountryName'] = '';
            $arryLead[0]['ZipCode'] = '';
        }


        echo json_encode($arryLead[0]);
        exit;

        break;
        exit;

    case 'Cmnt':

        $LastID = $objLead->AddComment($_GET);
        //print_r($_GET);
        exit;
        break;
    
    
    /***************FOR GET TERRITORY**********************************/
    
        case 'getTerritory':
            
                $objTerritory=new territory();
               
                    $arryTerritory = $objTerritory->getTerritoryByCountryID($_GET['country']);

                    $AjaxHtml = '<option value="">--- Select ---</option>';

                   
                    if ($_GET['country'] > 0) {
                            for ($i = 0; $i < sizeof($arryTerritory); $i++) {

                            $Selected = ($_GET['current_territory'] == $arryTerritory[$i]['TerritoryID']) ? (" Selected") : ("");

                                $AjaxHtml .= '<option value="' . $arryTerritory[$i]['TerritoryID'] . '" ' . $Selected . '>' . stripslashes($arryTerritory[$i]['Name']) . '</option>';
                            }


                            //$Selected = ($_GET['current_territory'] == '0') ? (" Selected") : ("");
    
                    } else {
                         $AjaxHtml = '<option value="">--- Select ---</option>';
                    }
                    
                    echo $AjaxHtml;exit;
                   
                    
                
        exit;
        break;
        
         case 'assignTerritoryManager':
            
                $objTerritory=new territory();
               
                    if($_GET['TRID'] > 0 && $_GET['SalesPersonID'] > 0){
                        
                        $TRID = $_GET['TRID'];
                        $SalesPersonID = $_GET['SalesPersonID'];
                        $SalesPerson = $_GET['SalesPerson'];
                        $arryTerritory = $objTerritory->addTerritoryManager($TRID,$SalesPersonID,$SalesPerson);
                        $_SESSION['mess_territory'] = MSG_TERRITORY_MANAGER_ASSIGN;
                    }
                   echo $arryTerritory;exit;
                    
                
            exit;
            break;
        
         case 'checkTerritory':
            
                $objTerritory=new territory();
                if($_GET['TerritoryID'] > 0){
                   
                    $rowTerritory = $objTerritory->checkTerritory($_GET['TerritoryID']);
    
                    if(isset($rowTerritory)){
                        echo 1;
                        exit;
                   }else{
                       echo 0;
                       exit;
                   }
                }
        exit;
        break;
    
    
    /****************END TERRITORY***********************************/
    

    case 'Convert':
        $objLead = new lead();
        if ($_GET['Contact'] == 1) {
            if ($_GET['FirstName'] == '') {
                echo "Please Enter First Name.";
            } elseif ($_GET['LastName'] == '') {
                echo "Please Enter Last Name.";
            } else {
                echo "Contact has been added.";
            }
        } elseif ($_GET['Opportunity'] == 1) {
            if ($_GET['Opportunity_name'] == '') {
                echo "Please enter Opportunity name";
            } elseif ($_GET['Close_Date'] == '') {
                echo "Please enter Close Date";
            } else {
                $LastID = $objLead->ConvertLead($_GET['LeadID'], 0);
                echo "Lead has been converted.";
            }
        } else {
            echo "Please choose one option.";
        }

        exit;
        break;


    case 'AjaxEvent':
        $objActivity = new activity();
        $objActivity->updateDragActivity($_GET);
        exit;
        break;

    case 'Commented':

        if ($_GET['Comment'] != '') {
            $LastID = $objLead->AddComment($_GET);
        }

        if ($_GET['del_comment'] == 'delete') {
            $objLead->RemoveComment($_GET['commID']);
        }

        $arryComment = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '');
  

        if (sizeof($arryComment) > 0) {


            $AjaxHtml = ' <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">';

            $AjaxHtml .='<tr>';
            $AjaxHtml .=' <td  valign="top">';

            $AjaxHtml .='<div style="overflow: auto; height: 420px; width: 100%;" >';
            foreach ($arryComment as $key => $values) {

                $stamp = $values['timestamp'];
                $diff = $time - $stamp;



                switch ($diff) {
                    case ($diff < 60):
                        $count = $diff;
                        $int = "seconds";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 && $diff < 3600):
                        $count = floor($diff / 60);
                        $int = "minutes";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 3600 && $diff < 60 * 60 * 24):
                        $count = floor($diff / 3600);
                        $int = "hours";
                        //echo  $count;
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 && $diff < 60 * 60 * 24 * 7):
                        $count = floor($diff / (60 * 60 * 24));

                        $int = "days";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 * 7 && $diff < 60 * 60 * 24 * 30):
                        $count = floor($diff / (60 * 60 * 24 * 7));
                        $int = "weeks";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 * 30 && $diff < 60 * 60 * 24 * 365):
                        $count = floor($diff / (60 * 60 * 24 * 30));
                        $int = "months";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 * 30 * 365 && $diff < 60 * 60 * 24 * 365 * 100):
                        $count = floor($diff / (60 * 60 * 24 * 7 * 30 * 365));
                        $int = "years";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;
                }

                if ($values['commented_by'] == "admin") {
                    $admin = "Administrator";
                } else {
                    $arryEmp = $objEmployee->GetEmployee($values['commented_id'], 1);

                    // print_r($arryEmp);
                }



                $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px;">' . stripslashes($values['Comment']) . '</div>
						<div valign="top" style="border-bottom: 1px dotted rgb(204, 204, 204); width: 99%; padding-bottom: 5px;" >';
                //if($values['commented_by']!=$_GET['commented_by'])
                if ($values['commented_by'] == "admin") {
                    $AjaxHtml .='<font color="darkred">Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values['CommentDate'])) . '
		                 </font>';
                } else {

                    $AjaxHtml .='<font color="darkred">Author : ' . $arryEmp[0]['UserName'] . ' on ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values['CommentDate'])) . '
				</font>';
                }

                /* if($values['commented_id']!=$_GET['commented_id']){
                  $AjaxHtml .='<div align="right" ><a href="javascript:;" class="button" style="color:white;"  onclick="reply_comment('.$values['CommentID'].');">Reply</a></div>';

                  } */
                if ($values['commented_by'] == $_GET['commented_by'] && $values['commented_id'] == $_GET['commented_id']) {
                    $AjaxHtml .='<div align="right" ><a href="javascript:;" style="color:white;"  onclick="Delete_comment(' . $values['CommentID'] . ');" class="button">Delete</a></div>';
                }
                $arryComment2 = $objLead->GetCommentByID('', $values['CommentID']);
                foreach ($arryComment2 as $key => $values2) {


                    $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px; padding-left: 40px;"><font color="darkred">Reply =></font>  ' . stripslashes($values2['Comment']) . '</div>
						<div valign="top"  width: 99%; padding-bottom: 5px; padding-left: 40px;"  >';

                    if ($values2['commented_by'] == "admin") {
                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values2['CommentDate'])) . '
							</font>';
                    } else {
                        $arryEmp2 = $objEmployee->GetEmployee($values2['commented_id'], 1);

                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $arryEmp2[0]['UserName'] . ' on ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values2['CommentDate'])) . '
							</font>';
                    }


                    $AjaxHtml .='</div>';

                    if ($values2['commented_id'] != $_GET['commented_id']) {
                        $AjaxHtml .='<div align="right" ><a href="javascript:;" class="button" style="color:white;"  onclick="reply_comment(' . $values2['CommentID'] . ');">Reply</a></div>';
                    }
                    if ($values2['commented_by'] == $_GET['commented_by'] && $values2['commented_id'] == $_GET['commented_id']) {
                        $AjaxHtml .='<div align="right" ><a href="javascript:;" style="color:white;"  onclick="Delete_comment(' . $values2['CommentID'] . ');" class="button">Delete</a></div>';
                    }
                }


                $AjaxHtml .='<div id="reply_' . $values['CommentID'] . '" style="display:none;" >
							<form name="form1" id="frm" action="" method="post" enctype="multipart/form-data">
													<table width="100%" border="0" cellpadding="5" cellspacing="0" >

														  <tr>
															  <td align="right"    valign="top">Reply  :</td>
															  <td  align="left" >
															   <textarea name="Com" style="width:800px;" type="text" class="textarea" id="Com"></textarea>	 </td>
														   </tr>
															 <tr>
																  <td align="center" colspan="2"   > 
																  <input type="hidden" name="parent"  id="parent" value="' . $values['CommentID'] . '"  />
																  <input name="Submit" style="margin-left:710px;" type="button" class="button" id="Reply" value="Reply" onclick="javascript:reply_submit();"  /> 
																  </td>     
															</tr>
															</table>
													</form>
</div>
						</div>
						';
            }
            $AjaxHtml .=' </div></td></tr></table>';
        } else {
            $AjaxHtml = '<font color="darkred">
								No Comments.
							</font>';
        }
        break;

    case 'relatedTo':

        if ($_GET['module'] == "Lead") {
            $SearchKey = $_GET['RelatedType'];
            $arrySerch = $objLead->ListSearchLead($id = 0, $SearchKey, $SortBy, $AscDesc);
            for ($i = 0; $i < sizeof($arrySerch); $i++) {
                if ($arrySerch[$i]['FirstName'] == $SearchKey) {
                    echo $arrySerch[$i]['FirstName'];
                } else {
                    echo "No result found";
                    exit;
                }
            }
        } else if ($_GET['module'] == "Opportunity") {
            echo "dev";
        } else if ($_GET['module'] == "Lead") {
            echo "me";
        } else if ($_GET['module'] == "Lead") {
            
        } else {
            echo "No Result";
        }

        break;
        
        
        case 'CustCommented':

        if ($_GET['Comment'] != '') {
            $LastID = $objLead->AddComment($_GET);
        }

        if ($_GET['del_comment'] == 'delete') {
            $objLead->RemoveComment($_GET['commID']);
        }

        $arryComment = $objLead->GetCommentList($_GET);

              
        if (sizeof($arryComment) > 0) {


            $AjaxHtml = ' <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">';

            $AjaxHtml .='<tr>';
            $AjaxHtml .=' <td  valign="top">';

            $AjaxHtml .='<div style="overflow: auto; height: 420px; width: 100%;" >';
            foreach ($arryComment as $key => $values) {

                $stamp = $values['timestamp'];
                $diff = $time - $stamp;



                switch ($diff) {
                    case ($diff < 60):
                        $count = $diff;
                        $int = "seconds";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 && $diff < 3600):
                        $count = floor($diff / 60);
                        $int = "minutes";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 3600 && $diff < 60 * 60 * 24):
                        $count = floor($diff / 3600);
                        $int = "hours";
                        //echo  $count;
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 && $diff < 60 * 60 * 24 * 7):
                        $count = floor($diff / (60 * 60 * 24));

                        $int = "days";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 * 7 && $diff < 60 * 60 * 24 * 30):
                        $count = floor($diff / (60 * 60 * 24 * 7));
                        $int = "weeks";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 * 30 && $diff < 60 * 60 * 24 * 365):
                        $count = floor($diff / (60 * 60 * 24 * 30));
                        $int = "months";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;

                    case ($diff >= 60 * 60 * 24 * 30 * 365 && $diff < 60 * 60 * 24 * 365 * 100):
                        $count = floor($diff / (60 * 60 * 24 * 7 * 30 * 365));
                        $int = "years";
                        if ($count == 1) {
                            $int = substr($int, 0, -1);
                        }
                        break;
                }

                if ($values['commented_by'] == "admin") {
                    $admin = "Administrator";
                } else {
                    $arryEmp = $objEmployee->GetEmployee($values['commented_id'], 1);

                    // print_r($arryEmp);
                }

  /*if($values['parent_type'] == 'Customer'){
                    $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px;"><font color="darkred">Comment type : Opportunity </font></div>';
                    
                }else{
                    
                   $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px;"><font color="darkred">Comment type : '.ucfirst($values['parent_type']).' </font></div>'; 
                }*/

                $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px;">' . stripslashes($values['Comment']) . '</div>
						<div valign="top" style="border-bottom: 1px dotted rgb(204, 204, 204); width: 99%; padding-bottom: 5px;" >';
                //if($values['commented_by']!=$_GET['commented_by'])
                #$AjaxHtml .='<div><font color="darkred"> Subject :' . stripslashes($values['Comment']) . '</font></div>';
              
                if ($values['commented_by'] == "admin") {
                    $AjaxHtml .='<div><font color="darkred"> Comment Date : ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values['CommentDate'])) . '
		                 </font></div><div><font color="darkred">Created By : ' . $admin . ' </font></div>';
                } else {

                    $AjaxHtml .='<div><font color="darkred"> Comment Date : ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values['CommentDate'])) . '
		                 </font></div><div><font color="darkred">Created By : ' . $arryEmp[0]['UserName'] . ' </font></div> ';
                }

                /* if($values['commented_id']!=$_GET['commented_id']){
                  $AjaxHtml .='<div align="right" ><a href="javascript:;" class="button" style="color:white;"  onclick="reply_comment('.$values['CommentID'].');">Reply</a></div>';

                  } */
                if ($values['commented_by'] == $_GET['commented_by'] && $values['commented_id'] == $_GET['commented_id']) {
                    $AjaxHtml .='<div align="right" ><a href="javascript:;" style="color:white;"  onclick="Delete_comment(' . $values['CommentID'] . ');" class="button">Delete</a></div>';
                }
                $arryComment2 = $objLead->GetCommentByID('', $values['CommentID']);
                foreach ($arryComment2 as $key => $values2) {


                    $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px; padding-left: 40px;"><font color="darkred">Reply =></font>  ' . stripslashes($values2['Comment']) . '</div>
						<div valign="top"  width: 99%; padding-bottom: 5px; padding-left: 40px;"  >';

                    if ($values2['commented_by'] == "admin") {
                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values2['CommentDate'])) . '
							</font>';
                    } else {
                        $arryEmp2 = $objEmployee->GetEmployee($values2['commented_id'], 1);

                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $arryEmp2[0]['UserName'] . ' on ' . date($Config['DateFormat'] . "  ,h:i:a.", strtotime($values2['CommentDate'])) . '
							</font>';
                    }


                    $AjaxHtml .='</div>';

                    if ($values2['commented_id'] != $_GET['commented_id']) {
                        $AjaxHtml .='<div align="right" ><a href="javascript:;" class="button" style="color:white;"  onclick="reply_comment(' . $values2['CommentID'] . ');">Reply</a></div>';
                    }
                    if ($values2['commented_by'] == $_GET['commented_by'] && $values2['commented_id'] == $_GET['commented_id']) {
                        $AjaxHtml .='<div align="right" ><a href="javascript:;" style="color:white;"  onclick="Delete_comment(' . $values2['CommentID'] . ');" class="button">Delete</a></div>';
                    }
                }


                $AjaxHtml .='<div id="reply_' . $values['CommentID'] . '" style="display:none;" >
							<form name="form1" id="frm" action="" method="post" enctype="multipart/form-data">
													<table width="100%" border="0" cellpadding="5" cellspacing="0" >

														  <tr>
															  <td align="right"    valign="top">Reply  :</td>
															  <td  align="left" >
															   <textarea name="Com" style="width:800px;" type="text" class="textarea" id="Com"></textarea>	 </td>
														   </tr>
															 <tr>
																  <td align="center" colspan="2"   > 
																  <input type="hidden" name="parent"  id="parent" value="' . $values['CommentID'] . '"  />
																  <input name="Submit" style="margin-left:710px;" type="button" class="button" id="Reply" value="Reply" onclick="javascript:reply_submit();"  /> 
																  </td>     
															</tr>
															</table>
													</form>
</div>
						</div>
						';
            }
            $AjaxHtml .=' </div></td></tr></table>';
        } else {
            $AjaxHtml = '<font color="darkred">
								No Comments.
							</font>';
        }
        break; 
        
}

if (!empty($AjaxHtml)) {
    echo $AjaxHtml;
    exit;
}
?>
