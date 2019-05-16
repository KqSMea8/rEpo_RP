<?
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
require_once($Prefix."classes/dbfunction.class.php");
require_once($Prefix."classes/phone.class.php");
require_once($Prefix."classes/email.class.php");
require_once($Prefix."classes/field.class.php"); //rajan for custom report
require_once($Prefix ."classes/crm.class.php");
require_once($Prefix ."classes/group.class.php");
require_once($Prefix."classes/inv_tax.class.php");
require_once($Prefix."classes/function.class.php"); //added by sanjiv
 
$objConfig = new admin();
$objLead = new lead();
$objEmployee = new employee();
$objphone=new phone();
$objFunction=new functions(); //added by sanjiv

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
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

CleanGet();



if($_POST){
	$_GET['action']=$_POST['action'];
}


switch ($_GET['action']) {
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
		
   case 'calldetail':  


$date_start = date('Y-m-d',strtotime($_GET['fromdate']));
$date_end = date('Y-m-d',strtotime($_GET['todate']));  
if($_GET['AdminType'] != "admin")
$date_end=$date_start;
$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();

  $agents=$html=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=$allcalldetail=$empQuota=array();
			 $getcallsetting=$objphone->GetcallSetting();
		 	 $Config['DbName'] = $Config['DbMain'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 $server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
			 $server_id	= $getcallsetting[0]->server_id;
			 $objphone->server_id	= $server_data[0]->server_ip;
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 
			 
    $agents=$objphone->api('acl_extention.php',array());	
	
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	//$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
		if($regisDat->type=='employee'){		
			$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;
		}elseif($regisDat->type=='admin'){
			$AgentByEmp['admin-'.$regisDat->user_id]=$regisDat->agent_id;
		}
			if($regisDat->type=='employee')
			$saveemp[]=$regisDat->user_id;
			else
			$saveemp[]='admin-'.$regisDat->user_id;
		}
	}
	
	if(!empty($agents)){
		foreach($agents as $agen){	
			$AnameByAid[$agen[0]]=$agen[1];
			$allagentdata[$agen[0]]=$agen;
		}	
	}
	
	  $arryEmployee=$objEmployee->ListEmployee($_GET);
	  $num6=$objEmployee->numRows();

	$pagerLink=$objPager->getPager($arryEmployee,10,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	$empid=0;
	
	//if($_GET['AdminType'] == "admin")
		
	
	$empid=$_GET['empId'];
	if (strpos($empid,'admin-') !== false) {
		$explode_empid =   explode("admin-",$empid);
	   $user_type = 'admin'; 	
       $empid = (int) $explode_empid[1];
    }else{
	   $user_type = 'employee'; 	
       $empid = (int) $empid;
		
	}
	
	if(!empty($empid)){
	$url='acl_cdr.php';	

				
				// $extesion=!empty($allagentdata[$AgentByEmp[$empid]][0])?$allagentdata[$AgentByEmp[$empid]][0]:0;
				$extensions =  $objphone->getEmpExtenstion($empid,$user_type);
				//echo "<pre>";print_r($extensions);die;
				
				if(count($extensions)>0){
					
						$results =  array();
						$extension_array = array();
						$getnumberArray =  array();
						foreach($extensions as $ext){
							 if(!empty($date_start) && !empty($date_end)){
								 $date = array('extension'=>$ext->agent_id,'date_start'=>$date_start,'date_end'=>$date_end);
								//echo "<pre>";print_r($date);die;
								
							 $allcalldetail=$objphone->api($url,$date);
							// echo "<pre>";print_r($allcalldetail);
								if(count($allcalldetail)>0){
									$total = $total+ $allcalldetail->total;
									 
                                     foreach($allcalldetail->cdrs as $num){
										  if($ext->agent_id!=$num[2]){
									     	 $getnumberArray[] =   $num[2];
										  }
									 }									 
								} 
							 }else{
							             $allcalldetail=$objphone->api($url,array('extension'=>$ext->agent_id));
							             if(count($allcalldetail)>0){
										  $total = $total+ $allcalldetail->total;
													foreach($allcalldetail->cdrs as $num){
															if($ext->agent_id!=$num[2]){
															   $getnumberArray[] =   $num[2];
															}
													}								  
										} 
							 }

						}						 
				}

                    $total  = count(array_unique($getnumberArray));				
					$empQuota =	$objphone->getEmpQuota($server_id,$empid);
					
					
					
					$total =(!empty($total)?$total:0);
					$quo= (!empty($empQuota[0]->q_time) AND !empty($empQuota[0]->duration))?$empQuota[0]->q_time.' / '.$empQuota[0]->duration:'---';
					
					$totallink=!empty($total)?'<a  href="callhistory.php?empId='.$_GET['empId'].'&startDate='.$date_start.'&endDate='.$date_end.'" class="Blue fancybox fancybox.iframe" ><img src="images/phoneicon.png" width="50" height="50" alt="Calls" title="Calls"/></a>':'<img src="images/phoneicon.png" width="50" height="50" alt="Calls" title="Calls"/>';
	}
	
	
	
	$html['quota'] .='<table width="100%"><tr><td>Call Quota - </td><td>'.$quo.'</td>
							</tr><tr><td><a  href="ViewVoicemail.php?empId='.base64_encode($_GET['empId']).'&custompopup=yes" class="Blue fancybox fancybox.iframe" ><img src="images/voicemail.png" width="35" height="35" alt="Voice mail" title="Voice mail"/></a></td><td>'.$totallink.'</td>
							</tr></table>';					
	if($_GET['AdminType'] == "admin"){
	$html['usertype']='admin';
	$html['chart'] ='<img src="barcall.php?quota='.$empQuota[0]->q_time.'&total='.$total.'" class="chart-view" alt="Graph">';								
	}else{	
	$html['usertype']='emp';
	$widthper= ($total*100)/$empQuota[0]->q_time;	
	$widthper=!empty($widthper)?$widthper:0;
	$widthper=($widthper>100)?100:$widthper;
	$html['chart'] .='<div class="progress-box-custom">
	<div class="progress-bar-custom">
	<div class="progress-custom" style="width:'.$widthper.'%">
	<span class="count-progress">'.$total.'</span>
	</div><span class="total-progress">'.$empQuota[0]->q_time.'</span></div></div>';	}
	$AjaxHtml=json_encode($html);
   break;
   		
   			


case 'CallCredential':
			if ($_GET['CallUserId'] != '' && $_GET['Password'] != '') {
				 $data = array();
				 $where = array();
				 $data['password'] = $_GET['Password']; 
				 $where['id'] = $_GET['CallUserId'];
				 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
				 $objConfig->dbName = $Config['DbName'];
				 $objConfig->connect();
				$objphone->update('c_callUsers',$data,$where);
				echo "1";
			} else {
				echo "0";
			}
        break;
        exit;
        
		case 'ContactDetail': 
        if($_GET['phone'] != "") {
	         $search_type= array('lead'=>'ListLeadbyphone','Opportunity'=>'ListOpportunitybyphone','Customer'=>'ListCustomerbyphone','Contact'=>'ListContactbyphone'); 
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 
			 foreach($search_type as $key=>$type){
				       $data = $objphone->$type('', $_GET['phone']);	 
					   if(count($data)>0){
					  
						 $data_connect['ID'] =     $data[0]['ID'];
						 $data_connect['Type'] =   $key;
						 $data_connect['Name'] =   $data[0]['Name'];
						 $data_connect['Email'] =  $data[0]['Email'];
						 $data_connect['Mobile'] =  $data[0]['Mobile'];
						 $data_connect['LandlineNumber'] =  $data[0]['LandlineNumber'];
						 echo json_encode($data_connect);
						 exit(); 
					   }	   
			  }
			  echo "0";
              exit(); 			 
		    
        } else {
             echo "0";
             exit(); 
        }
           
        break;
        exit;
		
	    case 'addComments':
	            if(!empty($_POST['comments_id']) && !empty($_POST['from_comments'])){ 
					$data =  array();
					$data['commented_by'] = $_SESSION['AdminType'];
					$data['commented_id'] = $_SESSION['AdminID'];
					$data['parent_type'] = $_POST['comments_type'];
					$data['parentID'] = $_POST['comments_id'];
					$data['Comment'] = $_POST['from_comments'];
					$data['CommentDate'] = date('Y-m-d H:i:s');
					$data['timestamp'] = time();
					
					$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					
					$objphone->insert('c_comments',$data);
					echo "1";
	            }else{
				    $data =  array();
					$data['commented_by'] = $_SESSION['AdminType'];
					$data['commented_id'] = $_SESSION['AdminID'];
					$data['parent_type'] = 'Call';
					$data['parentID'] = '';
					$data['Comment'] = $_POST['from_comments'];
					$data['CommentDate'] = date('Y-m-d H:i:s');
					$data['timestamp'] = time();
					
					$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					
					$objphone->insert('c_comments',$data);
					echo "1";
				}
	      break;
          exit;
		  
		  
	case 'addCountryCode': 
        if($_GET['country_id'] != "") {			
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			    $data =  array();
				$data['phone_country_id'] =   $_GET['country_id'];
				$objphone->update('h_employee', $data, array('EmpID'=>$_SESSION['AdminID']));
				
				echo "1";
				exit(); 			 
		    
        }    
        break;
        exit;



case 'addCallEvent': 		
			$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			    
			$data =  array();
			$data['created_by'] =   $_SESSION['AdminType'];
			$data['created_id'] =   $_SESSION['AdminID'];
			$data['subject'] =      $_GET['subject'];
			$data['startDate'] =    $_GET['startDate'];
			$data['startTime'] =    $_GET['startTime'];
			$data['closeDate'] =    $_GET['closeDate'];
			$data['closeTime'] =    $_GET['closeTime'];
			$data['status'] =       'Planned';
			$data['activityType'] = $_GET['activityType'];
			$data['priority'] =     $_GET['priority'];
			//echo "<pre>";print_r($data);die;
			
			$objphone->insert('c_activity', $data);
			echo "1";
			exit(); 			 
	    break;
        exit;	


 			
        



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

//By Rajan 28Sep//
case'customreportmodulefields':
$objField= new field();
if($_GET['moduleID']>0){
	$results = $objField->getAllCustomFieldByModuleID($_GET['moduleID']);
if (($_GET["moduleID"]=='104')|| ($_GET["moduleID"]=='105')|| ($_GET["moduleID"]=='136')|| ($_GET["moduleID"]=='2015'))
{
		//unset($results->fieldname['sendnotification']);
		$results = array_map(function($arr){
							if(($arr['fieldname']== 'sendnotification') || ($arr['fieldname']== 'reminder')||($arr['fieldname']== 'Notification')||($arr['fieldname']== 'FolderID')||($arr['fieldname']== 'FileName')||($arr['fieldname']== 'Image')   || ($arr['fieldname']== 'Taxable') || ($arr['fieldname']== 'EmpID'))
							{	
								unset($arr);
							}else{
								return $arr;
							}
					},$results);
		$results = array_values(array_filter($results)); 
		
} //print_r($results);die('lol');
if (($_GET["moduleID"]=='102') || ($_GET["moduleID"]=='107') || ($_GET["moduleID"]=='2015'))	
{  
  
 	$AddToarray = array(
               array( "fieldname" => state_id, "fieldid" =>  s_1,"fieldlabel" => State, "type" => text ),
            array( "fieldname" => city_id, "fieldid" =>   c_1,"fieldlabel" => City, "type" => text )       
   );     
        
	$results = array_merge($results, $AddToarray);
	
	if (($_GET["moduleID"]=='2015')){
  	 $AddToarray2 = $objField->getFormField('',48,1);
  	 $results = array_merge($results, $AddToarray2) ;
	}
}


	if(!empty($results)){
		
		$html = '<select class="inputbox" ><option value="">--Select Column--</option>';
		foreach ($results as $key=> $val){
			$html.= '<option data-type="'.$val['type'].'" value="'.$val['fieldid'].'">'.$val['fieldlabel'].'</option>';
		}
		
$html .= '</select>';
	}
} 

echo $html;break;exit;

//End


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
// by rajan
	case 'EditCommented':

        if ($_GET['Comment'] != '') {
            $res = $objLead->AddComment($_GET);
            echo $res;
        }    
        exit;
        break;
        //
        /***code by sachin-may-2017****/
    
    case 'CallLog':
    if ($_GET['callSubject'] != '') {
            $_GET['subject']=$_GET['callSubject'];
        	$callduration=$_GET['callduration'];
        	$time = explode(':', $callduration);
        	//echo $callduration;
        	$timesec=($time[0]*60*60) + ($time[1]*60) + ($time[2]);
        	$_GET['callduration']=$timesec;
        	//echo $timesec.'llkk';
            //echo gmdate("H:i:s", $timesec);
        	//die;
        	$_GET['type']='Call';
            $LastID = $objLead->AddComment($_GET);
    }
    $arryComment = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '','Call');
        
        if (sizeof($arryComment) > 0) {
        $AjaxHtml1='<table id="CallTable" width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall borderall2"><thead>';
 $AjaxHtml1.='<tr align="left">
<th class="head1">Subject</th>
<th class="head1">Call Purpose</th>
<th class="head1">Call Type</th>
<th class="head1">Call Duration</th>
<th class="head1">Date</th>
<th class="head1">Action</th>

</tr></thead><tbody>';
foreach($arryComment as $val){
 $AjaxHtml1.='<tr class="Call_'.$val['CommentID'].'">
          <td >'.$val['subject'].'</td>
          <td >'.$val['callPurpuse'].'</td>
          <td >'.$val['calltype'].'</td>
          <td >'.gmdate("H:i:s", $val['callduration']).'</td>
          <td >'.date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($val['CommentDate'])).'</td>
          <td><a href="javascript:;" style="color:white;"  onclick="Delete_Log(\'Call\',' . $val['CommentID'] . ');" class="button">Delete</a></td>
}
</tr>';
}
$AjaxHtml1.='</tbody></table>';
}
       echo json_encode($AjaxHtml1);exit;
    break;
    exit;
    case 'DeleteLog':
    if ($_GET['commID']!= '') {
            $objLead->RemoveComment($_GET['commID']);
            echo $_GET['commID'];exit;
        }

    break;
    exit;
    case 'ViewEmailLog':
    if ($_GET['commID']!= '') {
    	   
    	    $arryComment = $objLead->GetCommentUser($_GET['commID'], $_GET['view'], '', '', '','Email');
    	     //PR($arryComment);die;
    	     if($arryComment){
    	     $AjaxHtml1='<table width="100%" border="0" cellpadding="0" cellspacing="0" >
 <tr>
          <td align="left" width="10%"   valign="top">Subject  :</td>
          <td  align="left" >'.$arryComment[0]['subject'].'</td>
</tr>
 <tr>
          <td align="left" width="10%"   valign="top">Content:</td>
          <td  align="left" >'.stripslashes($arryComment[0]['Comment']).'</td>
</tr>

</table>';
}
echo json_encode($AjaxHtml1);exit;
            
        }

    break;
    exit;
    /****code by sachin-may-2017****/
    case 'Commented':

        if ($_GET['Comment'] != '') {
            $LastID = $objLead->AddComment($_GET);
        }

        if ($_GET['del_comment'] == 'delete') {
            $objLead->RemoveComment($_GET['commID']);
        }

        //$arryComment = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '');
        $arryComment = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '','Comment');
  

        if (sizeof($arryComment) > 0) {


            $AjaxHtml = ' <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">';

            $AjaxHtml .='<tr>';
            $AjaxHtml .=' <td  valign="top">';

            $AjaxHtml .='<div style="overflow: auto; height: 300px; width: 100%;" >';
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
                }else if ($values['commented_by'] == "Customer") {
                    $admin = "Customer";
                } else {
                    $arryEmp = $objEmployee->GetEmployee($values['commented_id'], 1);

                    // print_r($arryEmp);
                }



                $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px;">' . stripslashes($values['Comment']) . '</div>
						<div valign="top" style="border-bottom: 1px dotted rgb(204, 204, 204); width: 99%; padding-bottom: 5px;" >';
                //if($values['commented_by']!=$_GET['commented_by'])
                if ($values['commented_by'] == "admin") {
                    $AjaxHtml .='<font color="darkred">Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($values['CommentDate'])) . '
		                 </font>';
                } else if ($values['commented_by'] == "Customer") {

 $AjaxHtml .='<font color="darkred">Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($values['CommentDate'])) . '
		                 </font>';
                    //$admin = "Customer";
                } else {

                    $AjaxHtml .='<font color="darkred">Author : ' . $arryEmp[0]['UserName'] . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($values['CommentDate'])) . '
				</font>';
                }

                /* if($values['commented_id']!=$_GET['commented_id']){
                  $AjaxHtml .='<div align="right" ><a href="javascript:;" class="button" style="color:white;"  onclick="reply_comment('.$values['CommentID'].');">Reply</a></div>';

                  } */
                if ($values['commented_by'] == $_GET['commented_by'] && $values['commented_id'] == $_GET['commented_id']) {
                   $AjaxHtml .='<div align="right" ><a href="javascript:;"  onclick="Edit_comment('. $values['CommentID'].',this,\'edit\');" class="edit">Edit</a><a href="javascript:;" style="color:white;"  onclick="Delete_comment(' . $values['CommentID'] . ');" class="button">Delete</a></div>';
                }
                $arryComment2 = $objLead->GetCommentByID('', $values['CommentID']);
                foreach ($arryComment2 as $key => $values2) {


                    $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px; padding-left: 40px;"><font color="darkred">Reply =></font>  ' . stripslashes($values2['Comment']) . '</div>
						<div valign="top"  width: 99%; padding-bottom: 5px; padding-left: 40px;"  >';

                    if ($values2['commented_by'] == "admin") {
                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values2['CommentDate'])) . '
							</font>';
                    } else {
                        $arryEmp2 = $objEmployee->GetEmployee($values2['commented_id'], 1);

                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $arryEmp2[0]['UserName'] . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values2['CommentDate'])) . '
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
                }else if ($values['commented_by'] == "Customer") {
                    $admin = "Customer";
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
                    $AjaxHtml .='<div><font color="darkred"> Comment Date : ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values['CommentDate'])) . '
		                 </font></div><div><font color="darkred">Created By : ' . $admin . ' </font></div>';
                } else if ($values['commented_by'] == "Customer") {
                    $AjaxHtml .='<div><font color="darkred"> Comment Date : ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values['CommentDate'])) . '
		                 </font></div><div><font color="darkred">Created By : ' . $admin . ' </font></div>';
                }else {

                    $AjaxHtml .='<div><font color="darkred"> Comment Date : ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values['CommentDate'])) . '
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
								Author : ' . $admin . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values2['CommentDate'])) . '
							</font>';
                    } else {
                        $arryEmp2 = $objEmployee->GetEmployee($values2['commented_id'], 1);

                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $arryEmp2[0]['UserName'] . ' on ' . date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat'].".", strtotime($values2['CommentDate'])) . '
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
        
       case 'delete_CallEmployee':
       $server_id=$_POST['server_id'];
       $user_id=$_POST['user_id'];
       $agent_id=$_POST['agent_id'];    
       if(empty($server_id) || empty($user_id) || empty($agent_id)){
	       echo 0;
	       exit;
       }
       $objphone->deleteCallEmployee($agent_id,$user_id,$server_id);
        echo 1;
      	exit;	
        break;
        exit;
        
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

	case 'TaxRateAddress':
		if(!empty($country_id)){
			$objTax=new tax();
			$arrySaleTax = $objTax->GetTaxByLocation(1,$country_id,$state_id);
			if(sizeof($arrySaleTax)>0){

				$arrRate = explode(":",$_GET['OldTaxRate']);

				$AjaxHtml = '<select name="TaxRate" id="TaxRate" class="inputbox" onchange="Javascript: freightSett(this.value);" onclick="Javascript: ProcessTotal();"><option value="0">None</option>';
				for($i=0;$i<sizeof($arrySaleTax);$i++) {

				$Selected = ($arrRate[0] == $arrySaleTax[$i]['RateId'] && $arrRate[2] == $arrySaleTax[$i]['TaxRate'])?(" Selected"):("");

				$AjaxHtml .= "<option ".$Selected." value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['RateDescription'].":".$arrySaleTax[$i]['TaxRate']."' >
				".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."%</option>";
				} 
				$AjaxHtml .= '</select>';				
			}

		}		             
							
		break;

	case 'FlagInfo':

		$objLead=new lead();  
		$flag = $objLead->addFlag($_GET); 
		//$arryLead = $objLead->GetLead($LeadID,'');
//print_r($arryLead); exit;

		if($flag == 'Yes'){

		$AjaxHtml = '<img class="flag_red" title="Flag" alt="Flag" src="images/email_flag2.png">';
		}else{
		$AjaxHtml = '<img class="flag_white" title="Flag" alt="Flag" src="images/email_flag.png">';
		}

		  break;
		  exit; 
// By Rajan 22 Dec
	case 'changeStatus':
			
		 	$objLead = new lead();
		 	$leadStatus = $objLead->updateStatus($_GET['status'], $_GET['leadID']);
		 	echo '1';
			break;
			exit;	
	//End	
//bhoodev
case 'OppFlagInfo':

		$objLead=new lead();  
		$flag = $objLead->addOppFlag($_GET); 
		//$arryLead = $objLead->GetLead($LeadID,'');
//print_r($arryLead); exit;

		if($flag == 'Yes'){

		$AjaxHtml = '<img class="flag_red" title="Flag" alt="Flag" src="images/email_flag2.png">';
		}else{
		$AjaxHtml = '<img class="flag_white" title="Flag" alt="Flag" src="images/email_flag.png">';
		}

		  break;
		  exit; 

//End

//bhoodev
case 'TicketFlagInfo':

		$objLead=new lead();  
		$flag = $objLead->addTicketFlag($_GET); 
		//$arryLead = $objLead->GetLead($LeadID,'');
//print_r($arryLead); exit;

		if($flag == 'Yes'){

		$AjaxHtml = '<img class="flag_red" title="Flag" alt="Flag" src="images/email_flag2.png">';
		}else{
		$AjaxHtml = '<img class="flag_white" title="Flag" alt="Flag" src="images/email_flag.png">';
		}

		  break;
		  exit; 

//End

	case 'documentTofolder':
		$objLead=new lead();  
		if($_GET['FolderID']>0 && $_GET['documentID']>0){
			$objLead->DocumentAssignToFolder($_GET['FolderID'],$_GET['documentID']);
		}
		break;
		exit; 

	// Added by karishma for editable field on 12 Jan 2016	
	case 'getField':
		//error_reporting(E_ALL);
		//ini_set('display_errors', true);
		$field=$objConfig->getField($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal'],$_REQUEST['fieldType'],$_REQUEST['selecttbl'],$_REQUEST['selectfield'],$_REQUEST['selectfieldType'],$_REQUEST['relatedField']);
		echo json_encode($field);
		break;
		exit;

	case 'saveField':

		$success=$objConfig->saveField($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal'],$_REQUEST['fieldType'],$_REQUEST['fieldNameVal'],$_REQUEST['relatedField'],$_REQUEST['relatedFieldVal']);
		$arr['issuccess']=0;

		if($success){
			$arr['issuccess']=1;
			if($_REQUEST['fieldName']=='AssignTo' || strtolower($_REQUEST['fieldName'])=='assignedto'){
				if($_REQUEST['tblName']!='s_address_book' && $_REQUEST['tblName']!='c_campaign'){
					$AssignTypeVal=$objConfig->getFieldVal($_REQUEST['tblName'],'AssignType',$_REQUEST['ID'],$_REQUEST['IDVal']);
					if($AssignTypeVal=='Group'){
						$objGroup = new group();
						$GroupVal=$objConfig->getFieldVal($_REQUEST['tblName'],'GroupID',$_REQUEST['ID'],$_REQUEST['IDVal']);
						$arryGrp = $objGroup->getGroup($GroupVal, 1);
						$AssignName = $arryGrp[0]['group_name'];
						$data .= $AssignName.'<br>';
					}
				}

				$savedval=$objConfig->getFieldVal($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal']);
				$arryAssignee = $objLead->GetAssigneeUser($savedval);
				foreach ($arryAssignee as $values) {
					$data .='<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view='.$values['EmpID'].'">'.$values['UserName'].'</a>,<br>';
				}
				$arr['data']=$data;
			}
			elseif($_REQUEST['fieldName']=='country_id'){
				$FieldVal=$objConfig->getFieldVal($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal']);
				$countrydata=$objConfig->GetCountry($FieldVal);
				$arr['data']=$countrydata[0]['attribute_value'];
			}elseif($_REQUEST['fieldName']=='CustID'){
				$FieldVal=$objConfig->getFieldVal($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal']);
				
				$Customerdata=$objConfig->GetCustomerList($FieldVal);
				$arr['data']=$Customerdata[0]['FullName'];
			}elseif($_REQUEST['fieldName']=='CustType'){
				$FieldVal=$objConfig->getFieldVal($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal']);
				if($FieldVal=='o'){
				$FieldVal='Opportunity';	
				}elseif($FieldVal=='c'){
				$FieldVal='Customer';	
				}
				
				$arr['data']=$FieldVal;
			}
			else{
				$data=$objConfig->getFieldVal($_REQUEST['tblName'],$_REQUEST['fieldName'],$_REQUEST['ID'],$_REQUEST['IDVal']);
								
				if($_REQUEST['fieldType']=='date'){
					if($_REQUEST['relatedField']!='' && $_REQUEST['relatedField']!='undefined'){
					$data .=' '.$objConfig->getFieldVal($_REQUEST['tblName'],$_REQUEST['relatedField'],$_REQUEST['ID'],$_REQUEST['IDVal']);	
					$data=date($Config['DateFormat'] . " ".$Config['TimeFormat'], strtotime($data)); 	
					}else{
						$data=date($Config['DateFormat'] , strtotime($data)); 
					}
					
				}
				$arr['data']=$data;
			}
				
		}
		echo json_encode($arr);
		break;
		exit;

		// end by karishma for editable field on 12 Jan 2016
        	
		//By chetan 3March//
                    case 'updateCFSequence': 
                                            $objFld= new field();
                                            $IDsarr = explode(',',$_GET['Ids']);
                                            if(!empty($IDsarr))
                                            {
                                                //$Seq = $objFld -> getsequenceTostart($IDsarr[0],$_GET['headID']);
                                                if($_GET['start'] > 1)
                                                {
                                                    $Idstr = "'" . implode("','", $IDsarr) . "'";
                                                    $leftIds = $objFld -> getLeftFieldIds($Idstr,$_GET['headID'],$_GET['start']-1);
                                                    $LeftIdArr = array_map(function($arr){return $arr['fieldid'];},$leftIds);
                                                    $IDsarr = array_merge($IDsarr,$LeftIdArr);
                                                    $up = $objFld -> updateSequence($IDsarr,$_GET['start']);
                                                }else{echo "sdfg";
                                                    $Idstr = "'" . implode("','", $IDsarr) . "'";
                                                    $leftIds = $objFld -> getLeftFieldIds($Idstr,$_GET['headID']);
                                                    $LeftIdArr = array_map(function($arr){return $arr['fieldid'];},$leftIds);
                                                    $IDsarr = array_merge($IDsarr,$LeftIdArr);
                                                    $up = $objFld -> updateSequence($IDsarr);
                                                }
                                            }
                    //End//		

		 //by chetan on 16Aug//
		case 'getAddforCusticket':	
				$objCustomer = new Customer();
				$ContactInfo = '';
				$arr = array();
				if($_POST['CUSTID']!=''){
					$CustID = $_POST['CUSTID'];
					$arrRes = $objCustomer->GetCustomerBilling($CustID);
					if(!empty($arrRes)){
					$ContactInfo .= '<td align="right" width="25%" valign="top" class="blackbold">Contact:</td><td align="left" width="25%" valign="top"><select class="inputbox"  name="contact_id" id="contact_id">';
						
					if(trim($arrRes[0]['Landline'])!='')
					{
						$contact =  trim($arrRes[0]['Landline']);
					}else{
						$contact =  trim($arrRes[0]['Mobile']);
					}

					foreach($arrRes as $res)
					{	
						if($_POST['sel']==$res["AddID"])
						{ $getit = "selected"; } 
						else { $getit=""; }
						if(trim($res["Address"])!=''){
							$ContactInfo .= '<option '.$getit.' value="'.$res["AddID"].'">'.$res["Address"].'</option>';
						}
					}
					$ContactInfo .= '</select></td>';
					$ContactInfo .= '<td align="right" width="25%" valign="top" class="blackbold">Contact No:</td><td align="left" width="25%" valign="top"><input readonly class="inputbox" type="text" name="contact_no" id="contact_no" value="'.$contact.'" ></td>';
					$ContactInfo  = '<tr id="CustAddinfo">'.$ContactInfo.''.$ContNo.'</tr>';
					}
					$arr['Email'] 	= $arrRes['Email'];
					$arr['Add'] 	= $ContactInfo;
				}
										
				echo json_encode($arr);
				break;
				exit;

		case 'getNofor':	
				$objCustomer = new Customer();				
				if($_POST['CONTID']!=''){
					$ContID = $_POST['CONTID'];
					$arrRes = $objCustomer->GetAddressBook($ContID);
					if(!empty($arrRes)){		
						if(trim($arrRes[0]['Landline'])!='')
						{
							echo  trim($arrRes[0]['Landline']);
						}else{
							echo  trim($arrRes[0]['Mobile']);
						}
					}									
				}														 
				break;
				exit;


			case 'processCheck':

			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			//$objProduct=new product();
				
			$arr = array();
			$PID = $objConfig->getPID('crm',$_GET['taskmsg']);

			(!isset($PID[0]['PID']))?($PID[0]['PID']=""):("");


			if($ID = $PID[0]['PID']){
				$statusPID = $objConfig->isRunning($ID);
				if($statusPID){
					$arr['msgStsus'] = 2;
					$arr['status'] = 1;
				}else{
					$objConfig->removePID('crm',$_GET['taskmsg'],$ID);
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


		//End//			
		//Added by chetan on 23Jan2017//
		case 'OppAddInfo':	
				$objLead=new lead(); 				
				if($_GET['OppID']!=''){
					$arrRes = $objLead->GetOpportunity($_GET['OppID']);
					if(!empty($arrRes)){		
						echo json_encode($arrRes[0]);
					}else{
						echo json_encode(array());
					}												
				}														 
				break;
				exit;
		//End//

}

if (!empty($AjaxHtml)) {
    echo $AjaxHtml;
    exit;
}


if($_POST['action']=='composeMail'){	
	/*******************/
	$mailcontent = $_POST['mailcontent'];
	CleanPost(); 
	$_POST['mailcontent'] = $mailcontent;
	/*******************/

	$objEmail=new email();
	if(strlen($_POST['mailcontent']) > 18 || !empty($_POST['Subject']) || !empty($_POST['recipients']) || !empty($_POST['Bcc']) || !empty($_POST['Cc'])){
		echo $objEmail->saveToDarft($_POST);
	}else{
		echo 'null';
	}
}
if($_POST['actionn']=='checkFolderName'){
        CleanPost(); 
	$objEmail=new email();
        
        //echo $_POST['foldername'].'----'.$_POST['AdminId'].'==='.$_POST['CompId'];exit;
         echo $FolderNumCount=$objEmail->CheckFolderName($_POST['foldername'],$_POST['folderid'],$_POST['AdminId'],$_POST['CompId']);
         
	
}
if($_POST['actionn1']=='AddFolderName'){
      
	$objEmail=new email();
        
        $newfolderId=$objEmail->AddEmailFolderNameAjax($_POST);
        
        if($newfolderId > 0)
        {
        
        $FolderList=$objEmail->ListFolderName('',$_SESSION[AdminID],$_SESSION[CmpID]);
        
        
        $innnerHtml='<select name="FolderID" id="FolderID" class="inputbox" onchange="CreateFolderdropdown(this.value);"><option value="NotSelected">Choose Folder</option><option value="CreateFolder">Create Folder</option><option value="Inbox" >Inbox</option><option value="Spam" >Spam</option>';
         
        for($i=0;$i<sizeof($FolderList);$i++) {
                                            
               
             if($newfolderId==$FolderList[$i]["FolderId"])
             { $sel_val="selected";} 
             else {
                $sel_val="";
             }
             $innnerHtml.='<option value="'.$FolderList[$i]["FolderId"].'" '.$sel_val.' >'.$FolderList[$i]["FolderName"].'</option>';
                                        
         }
        echo $innnerHtml.='</select>';
        
       } 
         
   
         
	
}

 if($_POST['create_folder']=='checkFolderName'){
        CleanPost(); 
         echo $FolderNumCount=$objConfig->CheckDynamicFolderName($_POST['foldername'],$_POST['folderid'],$_POST['AdminId'],$_POST['CompId'],$_POST['ModuleID']);
}  

/*if($_POST['BackgroundExec']=='Lead'){
		$_SESSION['process'] = 'temp';
        CleanPost();
        $arr = array(); 
        if(isRunning($_POST['pid'])){
         	$arr['count'] = $objLead->CountForImport(); 
         	$arr['status'] = 1;
         	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],1);
        }else{
        	$arr['count'] = $objLead->CountForImport(); 
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
}*/

//updated by chetan for Customer import on 23 Sep. 2016//
if($_POST['BackgroundExec']=='Lead' || $_POST['BackgroundExec']=='Customer'){
		$_SESSION['process'] = 'temp';
        CleanPost();
        $arr = array(); 
	$objCustomer=new Customer();
        if(isRunning($_POST['pid'])){
         	$arr['count'] = ($_POST['BackgroundExec']=='Lead') ? $objLead->CountForImport() : $objCustomer->CountForImport();
         	$arr['status'] = 1;
         	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],1);
        }else{
         	$arr['count'] = ($_POST['BackgroundExec']=='Lead') ? $objLead->CountForImport() : $objCustomer->CountForImport();
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

/**************Drop box and google drive by sanjeev 4 feb 2016*********/


if($_POST['drivedownloadUrl']){

    $accessToken = $_POST['accessToken'];
    $downloadUrl = $_POST['drivedownloadUrl'];
    unset($_SESSION['googleDriveFileName']);
    
    $ext = $_POST['fileExtension'];
    $fileTitle = preg_replace('/\\.[^.\\s]{3,4}$/', '', $_POST['title']);
    $fileTitle = preg_replace( '/\s*/m', '', $fileTitle);
    $fileName = $fileTitle.time().'.'.$ext;
	
    $FileCheck = array('name'=>$fileName,'error'=>0);
    $FileArray = $objFunction->CheckUploadedFile($FileCheck,"Document");	
    
    if(empty($FileArray['ErrorMsg'])){
    	
    // Create a stream
    $opts = array(
    'http'=>array(
    'method'=>"GET",
    'header' => "Authorization: Bearer " . $accessToken                 
    )
    );
    $context = stream_context_create($opts);

    try {
            $content = file_get_contents($downloadUrl, false, $context);
            
            if (!empty($content)) 
            {	
                #$MainDir = "upload/Document/".$_SESSION['CmpID']."/";	
		$MainDir = $Config['FileUploadDir'].$Config['C_DocumentDir'];					
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}
				$documentDestination = $MainDir.$fileName;
            	file_put_contents("$documentDestination",$content);
				chmod("$documentDestination",0777);
				if(!empty($_POST['NewFile']) && file_exists($_POST['NewFile'])){
					$OldFileSize = filesize($_POST['NewFile'])/1024; //KB
					unlink($_POST['NewFile']);		
				}
		$_SESSION['dropBoxFileName'] = '';
            	$_SESSION['googleDriveFileName'] = $fileName;
                $Dresult  = array('fileName' => $fileName, 'fileUrl'=>$documentDestination, 'flag'=>1, 'msg'=>'File uploaded Successfully.');
            } else {
               $Dresult = array('msg' => 'Could not able to fetch file contents form google drive.Please choose different file!!','flag'=>0);
            }
    }catch (Exception $e) {
             $Derr = 'Caught exception: '.  $e->getMessage(). "\n";
    		 $Dresult = array('msg' => $Derr,'flag'=>0);
    }
	}else{
	    $Dresult = array('msg' => $FileArray['ErrorMsg'],'flag'=>0);
    }
    
    echo json_encode($Dresult);
    exit;
}

if($_POST['dropboxdownloadUrl']){

    $downloadUrl = $_POST['dropboxdownloadUrl'];
    $fileName = preg_replace( '/\s*/m', '', $_POST['fileName']);	
    $fileName = time().$fileName;
    unset($_SESSION['dropBoxFileName']);
	
    $FileCheck = array('name'=>$fileName,'error'=>0);
    $FileArray = $objFunction->CheckUploadedFile($FileCheck,"Document");	
    
    if(empty($FileArray['ErrorMsg'])){
    	
		try {
				$content = file_get_contents($downloadUrl, false, $context);

				if (!empty($content)) 
				{	
					#$MainDir = "upload/Document/".$_SESSION['CmpID']."/";				
					$MainDir = $Config['FileUploadDir'].$Config['C_DocumentDir'];
		
					if (!is_dir($MainDir)) {
						mkdir($MainDir);
						chmod($MainDir,0777);
					}
					$documentDestination = $MainDir.$fileName;
					file_put_contents("$documentDestination",$content);
					chmod("$documentDestination",0777);
					if(!empty($_POST['NewFile']) && file_exists($_POST['NewFile'])){
						$OldFileSize = filesize($_POST['NewFile'])/1024; //KB
						unlink($_POST['NewFile']);		
					}
					$_SESSION['googleDriveFileName'] = '';
					$_SESSION['dropBoxFileName'] = $fileName;
					$Dresult  = array('fileName' => $fileName, 'fileUrl'=>$documentDestination, 'flag'=>1, 'msg'=>'File uploaded Successfully.');
				} else {
				   $Dresult = array('msg' => 'Could not able to fetch file contents form google drive.Please choose different file!!','flag'=>0);
				}
		}catch (Exception $e) {
				 $Derr = 'Caught exception: '.  $e->getMessage(). "\n";
				 $Dresult = array('msg' => $Derr,'flag'=>0);
		}
    }else{
	    $Dresult = array('msg' => $FileArray['ErrorMsg'],'flag'=>0);
    }
    echo json_encode($Dresult);
    exit;
}




/*********End **************************************/
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
/*******code by sachin 12-5-17*******/
if($_POST['EmailSubject']){
	CleanGet();
	CleanPost(); 
	//PR($_POST);
	//PR($_GET);

    
        if ($_POST['EmailSubject'] != '') {
        	$_GET['subject']=$_POST['EmailSubject'];
        	$_GET['Comment']=urldecode($_POST['EmailContent']);
        	$_GET['type']='Email';
        	//PR($_GET);die;
            $LastID = $objLead->AddComment($_GET);
        }
        $arryComment = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '','Email');
        
        if (sizeof($arryComment) > 0) {
        $AjaxHtml1='<table id="EmailTable" width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall borderall2"><thead>';
 $AjaxHtml1.='<tr align="left">
<th class="head1">Subject</th>
<th class="head1">Content</th>
<th class="head1">Date</th>
<th class="head1">Action</th>
</tr></thead><tbody>';
foreach($arryComment as $val){
	$DataContentlen=strlen($val['Comment']);
	$CommentID=$val['CommentID'];
	
	$DataContent = stripslashes($val['Comment']); 
if($DataContentlen>250){  
$DataContent = substr(stripslashes($val['Comment']),0,300); 
$DataContent =$DataContent.'....&nbsp;<a href="javascript:;" style="color:white;"  onclick="ViewEmail_Log(\'Email\', '.$CommentID.');" class="button">View More</a>';
}

 $AjaxHtml1.='<tr class="Email_'.$val['CommentID'].'">
          <td width="15%">'.$val['subject'].'</td>
          <td width="50%">'.$DataContent.'</td>
          <td width="15%">'.date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($val['CommentDate'])).'</td>
          <td width="20%"><a href="javascript:;" style="color:white;"  onclick="Delete_Log(\'Email\',' . $val['CommentID'] . ');" class="button">Delete</a></td>

</tr>';
}
$AjaxHtml1.='</tbody></table>';
}
       echo json_encode($AjaxHtml1);exit;
        break;
        exit;

}
/*******code by sachin 12-5-17*******/
/**** added by nisha for salesPersonTypeData ----*/
if($_POST['action']=="SalesPersonData"){

    $_POST['Status'] = 1;
    $_POST['Division'] = '5,7';
$arryEmployeeCRM = $objEmployee->GetEmployeeList($_POST);
	$AjaxHtml="";
	foreach($arryEmployeeCRM as $key=>$emp){
	$AjaxHtml .= "<option value=".$emp['EmpID'].">".stripslashes($emp['UserName'])."
				</option>";	
	}
	echo $AjaxHtml; exit;
}
?>
