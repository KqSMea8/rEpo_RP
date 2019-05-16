<?	session_start();
	date_default_timezone_set('America/New_York');
	$Prefix = "../";
    	require_once($Prefix."includes/config.php");
    	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/user.class.php");	
	require_once($Prefix."classes/configure.class.php");	
require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/territory.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/configure.class.php"); 
	require_once($Prefix."classes/function.class.php");
	require_once("language/english.php");
 
	$objConfig=new admin();
	$objConfigure =new configure();//by sachin

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
	include("includes/common.php");
	$AjaxHtml='';

	CleanGet();
	switch($_GET['action']){		
		case 'local_time':
			if($_GET['Timezone']!='' && $_GET['TimezonePlusMinus']!=''){
				$Timezone = $_GET['TimezonePlusMinus'].$_GET['Timezone']; 
				echo '<br>Local Time: <strong>'.getLocalTime($Timezone).'</strong>';
			}
			break;
			exit;
		/****start code by sachin*****/
    		case 'delete_file_Storage':
			if($_GET['file_path']!=''){
				if($_GET['Config']=="1"){
				  $_GET['file_path'] = $Config['FileUploadDir'].$_GET['file_path'];
				} 
 
				$objConfigure=new configure(); 
				$objConfigure->UpdateStorage($_GET['file_path'],'',1);

				/********Connecting to main database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/
				
				$_GET['id']=$_GET['id'];
				$_GET['Module']=$_GET['Module'];
				$_GET['ModuleName']=$_GET['ModuleName'];  
				$returnid=$objConfig->DeleteOrderDocument($_GET);

				
				echo $returnid;exit;
				 
				
				
			}else{
				echo "0";exit;
			}
			break;
    	/****End code by sachin*****/
		case 'remove_file_Storage':  
			if(!empty($_GET['file_dir']) && !empty($_GET['file_name']) ){
				  
				$objFunction=new functions();
				$objFunction->DeleteFileStorage($_GET['file_dir'],$_GET['file_name']);

				/********Connecting to main database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/
				
				$_GET['id']=$_GET['id'];
				$_GET['Module']=$_GET['Module'];
				$_GET['ModuleName']=$_GET['ModuleName'];  
				$returnid=$objConfig->DeleteOrderDocument($_GET);

				
				echo $returnid;exit;
				 
				
				
			}else{
				echo "0";exit;
			}
			break;
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
				}else if($_GET['state_id']>0){ 
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

		
	case 'zipSearch':		
		$objRegion=new region();
		
		if(!empty($_GET['city_id'])){
			$arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
			for($i=0;$i<sizeof($arryZipcode);$i++) {
				$AjaxHtml .= '<li onclick="set_zip(\''.stripslashes($arryZipcode[$i]['zip_code']).'\')">'.stripslashes($arryZipcode[$i]['zip_code']).'</li>';
			}

		}
		break;
								
	case 'SetRegionByZip':		
		$objRegion=new region();
		if(!empty($_GET['ZipCode'])){
			$arryZipcode = $objRegion->getZipCodeByZip($_GET['ZipCode']);
			if(!empty($arryZipcode[0]['zip_code'])){
				echo json_encode($arryZipcode[0]);
			}
			exit;			

		}
		break;



							
	}
	

	/************Shipping Methods*****************/
	/*********************************/
	switch($_GET['action']){
		case 'DHL':

		$objshipment=new shipment();

		$arryshipmentMethod = $objshipment->dhlServiceTypeAll();

		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}

		break;
		exit;

	case 'Fedex':
		$objshipment=new shipment();
		/*$arrysp = $objshipment->ShipFromC($_GET['countryCode']);
		$arryshipmentMethod = $objshipment->fedexServiceType($arrysp[0]['serviceType']);*/
		$arryshipmentMethod = $objshipment->fedexServiceTypeAll();

		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}
		break;
		exit;


	case 'UPS':

		$objshipment=new shipment();

		/*$arrysp = $objshipment->UpsShipFromC($_GET['countryCode']);
		$arryshipmentMethod = $objshipment->upsServiceType($arrysp[0]['serviceType']);*/
		$arryshipmentMethod = $objshipment->upsServiceTypeAll();

		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
			
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");
			
			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}
		break;
		exit;

	case 'USPS':
		$objshipment=new shipment();
		
		$arryshipmentMethod = $objshipment->defaultUSPSShippingMethod();
		
		$AjaxHtml='';

		$AjaxHtml  .= '<option value="">--- Select ---</option>';

		for($i=0;$i<sizeof($arryshipmentMethod);$i++) {
			$Selected = ($_GET['shippval'] == $arryshipmentMethod[$i]['service_value'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryshipmentMethod[$i]['service_value'].'" '.$Selected.'>'.stripslashes($arryshipmentMethod[$i]['service_type']).'</option>';

		}
		break;
		exit;
		
	}


	/*********************************/
	/*********************************/






	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
	

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/



	switch($_GET['action']){		
			
		case 'PageName':
			if(!empty($_GET['PageName']) && !empty($_GET['PageUrl']) && !empty($_SESSION['AdminID']) && !empty($_SESSION['loginID'])){
				$_GET['PageName'] = str_replace("  "," : ",$_GET['PageName']);

				$objUser=new user();		
				$objUser->AddUserLoginPage($_GET);				

			}
			break;
			exit;
		case 'notification_read':
			$Config['CurrentDepID'] = $_GET["depID"];
			$objConfigure=new configure();
			$objConfigure->ReadNotification('');
			break;
			exit;	

		case 'GetTerritoryManager':
			$objTerritory=new territory();
			if($_GET['TerritoryID']!='None'){	
				$TerritoryID = str_replace("None","",$_GET['TerritoryID']);
				$TerritoryID = rtrim($TerritoryID,",");
				$arryEmployee = $objTerritory->GetTerritoryManager($TerritoryID, $_GET['EmpID']);
				$num = sizeof($arryEmployee);
			}
			$AjaxHtml  = '<select name="ManagerID" class="inputbox" id="ManagerID" >';
			
			if($num>0){
				$AjaxHtml  .= '<option value="">--- Select ---</option>';
				for($i=0;$i<$num;$i++) {
					$Selected = ($_GET['OldManagerID'] == $arryEmployee[$i]['AssignTo'])?(" Selected"):("");
					$AjaxHtml  .= '<option value="'.$arryEmployee[$i]['AssignTo'].'" '.$Selected.'>'.stripslashes($arryEmployee[$i]['UserName']).'</option>';
				}

		    }else{
				$AjaxHtml  .= '<option value="">'.NO_MANAGER.'</option>';
			}

			$AjaxHtml  .= '</select>';			

			break;
			exit;	


		case 'GetTerritoryLocation':
			$objTerritory=new territory();
			if($_GET['TerritoryID']!='None'){	
				$TerritoryID = str_replace("None","",$_GET['TerritoryID']);
				$TerritoryID = rtrim($TerritoryID,",");
				
				$arryTerritory = $objTerritory->GetTerritoryRuleMulti($TerritoryID);
				$num = sizeof($arryTerritory);

				if($num>0){
					$AjaxHtml = '<b>Selected Territories Rule: </b>';					
					foreach($arryTerritory as $key=>$values){					
						$AjaxHtml .= '<br><a class="fancybox fancybox.iframe" href="../crm/vTerritoryRule.php?view='.$values['TRID'].'&pop=1">'.stripslashes($values['Name']).'</a> ';				
						
					}
					
				}
			}
						

			break;
			exit;
/*******************************************************/

case 'SelectMultiEmp':
			$objEmployee=new employee();
			//if($_GET['TerritoryID']!='None'){	
				if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
			if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
			if($_GET["selEmpID"]!='') $_GET["selEmpID"] = $_GET["selEmpID"];
				$selEmpID = explode(",",$_GET["selEmpID"]);
				$arryEmployee = $objEmployee->GetEmployeeList($_GET);
				$num = sizeof($arryEmployee);
			//}
			$AjaxHtml  = '<select name="SalesPerson[]" class="inputbox jqmsLoaded" style="width:250px; height:200px;" multiple id="SalesPerson">';
			
			if($num>0){
				//$AjaxHtml  .= '<option value="">--- Select ---</option>';
				for($i=0;$i<$num;$i++) {
					$Selected =  (in_array($arryEmployee[$i]['EmpID'], $selEmpID))?(" Selected"):("");
					$AjaxHtml  .= '<option value="'.$arryEmployee[$i]['EmpID'].'" '.$Selected.'>'.stripslashes($arryEmployee[$i]['UserName']).'</option>';
				}

		    }else{
				$AjaxHtml  .= '<option value="">No sales person found</option>';
			}

			$AjaxHtml  .= '</select>';		

$AjaxHtml  .= '<input type="hidden" name="d" id="d" value="'.$_GET['d'].'" readonly>';
$AjaxHtml  .= '<input type="hidden" name="dv" id="dv" value="'.$_GET['dv'].'" readonly>';

	

			break;
			exit;	



/*******************************************************/
		case 'GetTerritoryLocation55555555':
			$objTerritory=new territory();
			if($_GET['TerritoryID']!='None'){	
				$TerritoryID = str_replace("None","",$_GET['TerritoryID']);
				$TerritoryID = rtrim($TerritoryID,",");
				
				$arryLocation = $objTerritory->GetLocationByTerritory($TerritoryID);
				$num = sizeof($arryLocation);

				if($num>0){
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					$objRegion=new region();

					$AjaxHtml = '<b>Location of Territories: </b>';					
					foreach($arryLocation as $key=>$values){
						$arryCountry = $objRegion->getCountry($values['country'],'');

						if($values['Name']!=$OldName){
							$AjaxHtml .= '<br><b>'.$values['Name'].':</b> ';
						}
						$AjaxHtml .= $arryCountry[0]['name'].', ';

						$OldName = $values['Name'];
					}
					
				}
			}
						

			break;
			exit;

/*****************************************************/
	/*
				rakesh commented code ajax
			*/
			
	case 'Commented':		
   //Array ( [action] => Commented [parentID] => 1487 [parent_type] => Order [commented_by] => admin [commented_id] => 31 [r] => 0.8918271566076478 ) 
   
         $objSale = new sale();
$objEmployee=new employee();
	  
        if (!empty($_GET['Comment'])) { 
            $LastID = $objSale->AddComment($_GET);
        }
	if(empty($_GET['del_comment'])) $_GET['del_comment']='';
        if ($_GET['del_comment'] == 'delete') {
            $objSale->RemoveComment($_GET['commID']);
}
        $arryComment = $objSale->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '');
        if (sizeof($arryComment) > 0) {
            $AjaxHtml = ' <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">';
            $AjaxHtml .='<tr>';
            $AjaxHtml .=' <td  valign="top">';
            $AjaxHtml .='<div style="overflow: auto; height: 300px; width: 100%;" >';
	if(empty($time)) $time=0;
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

$comDat = explode(' ',$values['CommentDate']);
//print_r($comDat);

                $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px;">' . stripslashes($values['Comment']) . '</div>
						<div valign="top" style="border-bottom: 1px dotted rgb(204, 204, 204); width: 99%; padding-bottom: 5px;" >';
                //if($values['commented_by']!=$_GET['commented_by'])
                if ($values['commented_by'] == "admin") {
                    $AjaxHtml .='<font color="darkred">Author : ' . $admin . ' on ' . date($_SESSION['DateFormat'],strtotime($comDat[0])). '  '.date($_SESSION['TimeFormat'],strtotime($values['CommentDate'])).'
		                 </font>';
                } else {
                    $AjaxHtml .='<font color="darkred">Author : ' . $arryEmp[0]['UserName'] . ' on ' . date($_SESSION['DateFormat'],strtotime($comDat[0])). '  '.date($_SESSION['TimeFormat'],strtotime($values['CommentDate'])).'
				</font>';
                }
                /* if($values['commented_id']!=$_GET['commented_id']){
                  $AjaxHtml .='<div align="right" ><a href="javascript:;" class="button" style="color:white;"  onclick="reply_comment('.$values['CommentID'].');">Reply</a></div>';

                  } */
                if ($values['commented_by'] == $_GET['commented_by'] && $values['commented_id'] == $_GET['commented_id']) {
                   $AjaxHtml .='<div align="right" ><a href="javascript:;"  onclick="Edit_comment('. $values['CommentID'].',this,\'edit\');" class="edit">Edit</a><a href="javascript:;" style="color:white;"  onclick="Delete_comment(' . $values['CommentID'] . ');" class="button">Delete</a></div>';
                }
                $arryComment2 = $objSale->GetCommentByID('', $values['CommentID']);
                foreach ($arryComment2 as $key => $values2) {


                    $AjaxHtml .='<div valign="top" style="width: 99%; padding-top: 10px; padding-left: 40px;"><font color="darkred">Reply =></font>  ' . stripslashes($values2['Comment']) . '</div>
						<div valign="top"  width: 99%; padding-bottom: 5px; padding-left: 40px;"  >';

                    if ($values2['commented_by'] == "admin") {
                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $admin . ' on ' . date($_SESSION['DateFormat'],strtotime($comDat[0])). '  '.date($_SESSION['TimeFormat'],strtotime($values['CommentDate'])).'
							</font>';
                    } else {
                        $arryEmp2 = $objEmployee->GetEmployee($values2['commented_id'], 1);

                        $AjaxHtml .='<font color="darkred" style="padding-left: 59px;">
								Author : ' . $arryEmp2[0]['UserName'] . ' on ' . date($_SESSION['DateFormat'],strtotime($comDat[0])). '  '.date($_SESSION['TimeFormat'],strtotime($values['CommentDate'])).'
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
		/////////////////////////////////////////////////////////////	
		
		case 'EditCommented':
		   $objSale = new sale();
        if ($_GET['Comment'] != '') {
            $res = $objSale->AddComment($_GET);
            echo $res;
        }      
        break;
exit;
/*****************************************************/



		case 'CustomerInfo':
			$objCustomer = new Customer();
			$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],'','');
						

			echo json_encode($arryCustomer[0]);exit;

			break;
			exit;	

		case 'CustomerCardInfo':			
			$objCustomer = new Customer();
			$objRegion=new region();
			$arryCard = $objCustomer->GetCard($_GET['CardID'],$_GET['CustID'],'');

			/*
			$arryCardNumber = explode("-",$arryCard[0]["CardNumber"]);
			if($arryCard[0]["CardType"]=='Amex'){
				$arryCard[0]["CardNumberTemp"] = 'xxxx-xxxxxx-'.$arryCardNumber[2];
			}else{
				$arryCard[0]["CardNumberTemp"] = 'xxxx-xxxx-xxxx-'.$arryCardNumber[3];
			}*/
			$arryCard[0]["CardNumberTemp"] = CreditCardNoX($arryCard[0]["CardNumber"],$arryCard[0]["CardType"]);



			/***********************************/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************************/
		
			$arryCountry = $objRegion->GetCountryCode($arryCard[0]['country_id']);
			$arryCard[0]['CountryCode']= stripslashes($arryCountry[0]["code"]);
			if(!empty($arryCard[0]['state_id'])) {
				$arryState = $objRegion->getStateName($arryCard[0]['state_id']);
				$arryCard[0]['State']= stripslashes($arryState[0]["name"]);
			}else if(!empty($arryCard[0]['OtherState'])){
				 $arryCard[0]['State']=stripslashes($arryCard[0]['OtherState']);
			}

			if(!empty($arryCard[0]['city_id'])) {
				$arryCity = $objRegion->getCityName($arryCard[0]['city_id']);
				$arryCard[0]['City']= stripslashes($arryCity[0]["name"]);
			}else if(!empty($arryCard[0]['OtherCity'])){
				 $arryCard[0]['City']=stripslashes($arryCard[0]['OtherCity']);
			}
			/***********************************/


			echo json_encode($arryCard[0]);exit;

			break;

			exit;

		case 'CreditCardInfoPost':			
			$objRegion=new region();			

			/***********************************/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************************/
			$arryData[0]['CountryCode'] ='';
			if(!empty($_GET['country_id'])) {
				$arryCountry = $objRegion->GetCountryCode($_GET['country_id']);
				$arryData[0]['CountryCode']= stripslashes($arryCountry[0]["code"]);
				if(!empty($_GET['state_id'])) {
					$arryState = $objRegion->getStateName($_GET['state_id']);
					$arryData[0]['State']= stripslashes($arryState[0]["name"]);
				}else if(!empty($_GET['OtherState'])){
					 $arryData[0]['State']=stripslashes($_GET['OtherState']);
				}

				if(!empty($_GET['city_id'])) {
					$arryCity = $objRegion->getCityName($_GET['city_id']);
					$arryData[0]['City']= stripslashes($arryCity[0]["name"]);
				}else if(!empty($_GET['OtherCity'])){
					 $arryData[0]['City']=stripslashes($_GET['OtherCity']);
				}
			}
			/***********************************/

			echo json_encode($arryData[0]);exit;

			break;

			exit;

		case 'SetttingGlAccount':
			if(!empty($_GET['GL'])){
				$arryGl = explode("[",$_GET['GL']);	
				if(!empty($arryGl[1])){			 
					$AccountNumber = trim(rtrim($arryGl[1],"]"));
					if(!empty($AccountNumber)){
						$objBankAccount=new BankAccount();
						$arryAccount = $objBankAccount->getAccountByAccountNumber($AccountNumber);
					}
				}
								
			}
			if(empty($arryAccount[0]['BankAccountID'])) $arryAccount[0]['BankAccountID']=0;
	
			echo json_encode($arryAccount[0]);exit;	
			
			break;
			exit;	

		case 'settingRightMenu':
			$objConfigure=new configure();
			$AjaxHtml = $objConfigure->updateByModuleId($_GET['ModuleID'],$_GET['caption']);
			break;
					
	}
	

	


	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	/**************************/
	(empty($_POST['action']))?($_POST['action']=''):(""); 
	(empty($_POST['BackgroundExec']))?($_POST['BackgroundExec']=''):(""); 

	if($_POST['action']=='updateBlockListing'){
		$updateRecordsArray 	= $_POST['recordsArray'];		
		$objConfig->updateBlockOrder($updateRecordsArray);
		exit;
	}else if($_POST['action']=='removeBlock'){
		$idArray 	= explode("_",$_POST['id']);

		if($idArray[1]>0){
			$objConfig->updateBlockStatus($idArray[1],0);
		}
		exit;
	}else if($_POST['action']=='resizeBlock'){
		$idArray 	= explode("_",$_POST['id']);

		if($idArray[1]>0){
			$objConfig->updateBlockSize($idArray[1],$_POST['Width'],$_POST['Height']);
		}
		exit;
	}else if($_POST['action']=='dragBlock'){
		$idArray 	= explode("_",$_POST['id']);

		if($idArray[1]>0){
			$objConfig->updateBlockPosition($idArray[1],$_POST['Top'],$_POST['Left']);
		}
		exit;	
	}else if($_POST['action']=='AddDefaultScreen'){
		 $response = $objConfig->updateScreeStatus();
		 echo $response;exit;
	}

	/***************************/

//For Importing Vendor Excel 21Sep. 2016//
	if($_POST['BackgroundExec']=='Vendor'){
		$_SESSION['process'] = 'temp';
        CleanPost();
        $arr = array(); 
				$objSupplier=new supplier(); 
        if(isRunning($_POST['pid'])){ 
         	$arr['count'] = $objSupplier->CountForImport(); 
         	$arr['status'] = 1;
         	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],1);
        }else{
        	$arr['count'] = $objSupplier->CountForImport(); 
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

   if($_POST['BackgroundExec']=='Customer'){
	$_SESSION['process'] = 'temp';
        CleanPost();
        $arr = array(); 
	$objCustomer=new Customer();
        if(isRunning($_POST['pid'])){
         	$arr['count'] = $objCustomer->CountForImport(); 
         	$arr['status'] = 1;
         	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],1);
        }else{ 
        	$arr['count'] = $objCustomer->CountForImport();
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

//updated by chetan for Customer import on 23 Sep. 2016//
if($_POST['BackgroundExec']=='Lead'){
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

if($_POST['action']=='GetBillingAddress')  {
	(!isset($_POST['status']))?($_POST['status']=""):("");
	(!isset($_POST['AddType']))?($_POST['AddType']=""):("");

	$objCustomer = new Customer();
	if(!empty($_POST['CustID'])){
		$arryContact = $objCustomer->GetShippingBilling($_POST['CustID'],$_POST['AddType'],$_POST['status'],'');        

		#print_r($arryContact);
		#$arr = array_map('utf8_encode', $arryContact[0]);
		echo json_encode($arryContact[0]);exit;
	}
}

?>
