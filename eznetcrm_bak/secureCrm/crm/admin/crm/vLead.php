<?php 
	/**************************************************/
	$ThisPageName = 'viewLead.php';  if($_GET['pop'] == 1){  $HideNavigation = 1; }
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");
	include_once("language/en_lead.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/company.class.php");
        require_once($Prefix."classes/group.class.php");

        $Module="Lead";
	$objLead=new lead();
	$objEmployee=new employee();
	$objContact=new contact();
	$objCommon=new common();
	$objCompany=new company();
        $objActivity = new activity();
        $objGroup=new group();
	
	$ModuleName = "Lead";
	$RedirectURL = "viewLead.php?module=".$_GET["module"]."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Lead";

	$EditUrl = "editLead.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vLead.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	
	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";
			if($_GET['tab']=="Task" || $_GET['tab']=="Event"){
				$AddRef="editActivity.php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
			}else{

            $AddRef="edit".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
			$SelectRef="view".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
        $ViewUrl = "vLead.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
			}

	
	
	
	
	/************************/
	if($_POST){
		if($_POST['Comment']!=''){
			$_POST['parentID']=$_GET['view'];
			$_POST['parent_type']=$_GET['module'];
			$_POST['commented_by']=$_SESSION['AdminType'];
			$_POST['commented_id']=$_SESSION['AdminID'];
			$LastID = $objLead->AddComment($_POST);
			header("location:".$ViewUrl."Comments");
			exit;
	         }
	/************************/

		if($_POST['OpportunityName']!=''){
		   $LastID = $objLead->AddOpportunity($_POST);
			if(!empty($LastID)){
			   $oppID = $objLead->ConvertLead($_POST['LeadID'],1, $LastID);
			}	 
		      header("location:viewOpportunity.php?module=Opportunity");
		      exit;
		}else{
		      header("location:".$ViewUrl);
		      exit;
		}
		}
		if($_GET['select_del_id'] && !empty($_GET['select_del_id'])){
		    $_SESSION['mess_ticket'] = LEAD_REMOVE;
		    $objLead->RemoveSelectCompaign($_REQUEST['select_del_id']);
		    header("Location:".$ViewUrl.$_GET['tab']);
		}


		if (!empty($_GET['view'])) {
			$arryLead = $objLead->GetLead($_GET['view'],'');
			$LeadID   = $_REQUEST['view'];
			if(!empty($arryLead[0]['AssignTo'])){	
				$arrySupervisor = $objEmployee->GetEmployeeBrief($arryLead[0]['AssignTo']);
			}
			if($arryLead[0]['created_by']=='admin'){
				if($arryLead[0]['created_id']>0){
				$createdEMP[0]['UserName']="Administrator";
				}
				}else{
				$createdEMP=  $objEmployee->GetEmployeeBrief($arryLead[0]['created_id']);
				}

		}

		if(empty($arryLead[0]['leadID'])) {
			header('location:'.$RedirectURL);
			exit;
		}
		/*****************/
		/*****************/
	if($Config['vAllRecord']!=1){
		if($arryLead[0]['AssignTo'] !=''){
		$arrAssigned = explode(",",$arryLead[0]['AssignTo']);
	}
	if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryLead[0]['created_id'] != $_SESSION['AdminID']){				
		header('location:'.$RedirectURL);
		exit;
	}
	}
		/*****************/
		/*****************/
/************************************************/
                
               if($arryLead[0]['AssignTo']  >0){  
	if($arryLead[0]['AssignType'] == 'Group'){ 
		$assignee = $arryLead[0]['AssignTo']; 
		$arryGrp = $objGroup->getGroup($arryLead[0]['GroupID'],1);

		$AssignName = $arryGrp[0]['group_name'];
		$arryAssignee = $objLead->GetAssigneeUser($arryLead[0]['AssignTo']);
	} else{ 
		$assignee = $arryLead[0]['AssignTo'];
		$arryAssignee = $objLead->GetAssigneeUser($arryLead[0]['AssignTo']);
		$AssignName = $arryAssignee[0]['UserName'];
	}
               }
/************************************************/





		if($_GET['tab']=="Event"){

                if($_GET['act_id'] && !empty($_GET['act_id'])){
			$_SESSION['mess_Event'] =EVENT_REMOVE;
			$objActivity->deleteActivity($_GET['act_id']);
			header("Location:vLead.php?view=".$_GET['view']."&module=lead&tab=".$_GET['tab']);
		}


		  $arryActivity=$objActivity->ListActivity('','lead',$_GET['view'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		  $num=$objActivity->numRows();
		  $pagerLink=$objPager->getPager($arryActivity,$RecordsPerPage,$_GET['curP']);
		  ( count($arryActivity)>0)?($arryActivity=$objPager->getPageRecords()):("");

		}
	

		$arryDepartment = $objConfigure->GetDepartment();
		$_GET['Status']=1; $_GET['Division']=5;
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
		$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
		$arryIndustry = $objCommon->GetCrmAttribute('Industry','');
		$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');
	
		/*******Connecting to main database********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		if($arryLead[0]['country_id']>0){
		$arryCountryName = $objRegion->GetCountryName($arryLead[0]['country_id']);
		$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

			if(!empty($arryLead[0]['state_id'])) {
			   $arryState = $objRegion->getStateName($arryLead[0]['state_id']);
			   $StateName = stripslashes($arryState[0]["name"]);
			}else if(!empty($arryLead[0]['OtherState'])){
			   $StateName = stripslashes($arryLead[0]['OtherState']);
			}

				if(!empty($arryLead[0]['city_id'])) {
				  $arryCity = $objRegion->getCityName($arryLead[0]['city_id']);
				  $CityName = stripslashes($arryCity[0]["name"]);
				}else if(!empty($arryLead[0]['OtherCity'])){
				  $CityName = stripslashes($arryLead[0]['OtherCity']);
				}
	       /********Connecting to main database*********/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/

	require_once("../includes/footer.php"); 	 
?>


