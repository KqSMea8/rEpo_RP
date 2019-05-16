<?php 
	/**************************************************/
	$ThisPageName = 'viewOpportunity.php'; 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/event.class.php");
        require_once($Prefix . "classes/group.class.php");
	require_once($Prefix."classes/field.class.php"); //By Chetan//
	 $objField = new field();//By Chetan//
 
	$objLead=new lead();
	$objEmployee=new employee();
	$objCustomer=new Customer();
  	$objActivity = new activity(); 
	$objCommon=new common(); 
        $objGroup = new group();

	$_GET['view'] = (int)$_GET['view'];

	$Module = $callfor = "Opportunity";
	$RedirectURL = "viewOpportunity.php?module=".$_GET["module"]."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Opportunity";

	$EditUrl = "editOpportunity.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vOpportunity.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 

	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";

			 /*****************************
					if($_GET['select_del_id'] && !empty($_GET['select_del_id'])){
							$_SESSION['mess_opp'] = OPP_REMOVE;
							$objLead->RemoveSelectCompaign($_GET['select_del_id']);
							header("Location:".$ViewUrl.$_GET['tab']);
						}
			 /*****************************/
	
	 if(!empty($_GET['convert']) && $_GET['convert']=='y')
        {
            $res = $objCustomer->convertTocustomerOpp($_GET['view']);
            header("Location:".$RedirectURL);
        }



	if (!empty($_GET['view'])) {

		 $objLead->updateAsViewMarked($_GET['view'],'c_opportunity','OpportunityID');

		$arryOpportunity = $objLead->GetOpportunity($_GET['view'],'');
                //echo '<pre>';print_r($arryOpportunity);
                $PageHeading = 'View '.$Module.' detail for '.stripslashes($arryOpportunity[0]['OpportunityName']);

		if(!empty($arryOpportunity[0]['CustID'])){
			$arryCustomer = $objCustomer->GetCustomer($arryOpportunity[0]['CustID'],'','');
		}

        $arryHead=$objField->getHead('',$ModuleParentID,1);//By Chetan//
        $arryHeadLead=$objField->getHead('',102,1);//By Chetan16/6/15//

        /***GET Email Log by sachin***/
				$_GET['type']='Email';
				$_GET['parentID']=$_GET['view'];
	  $_GET['parent_type']=$_GET['module'];
	  $_GET['commented_by']=$_SESSION['AdminType'];
	  $_GET['commented_id']=$_SESSION['AdminID'];
	  $arryEmaillogList = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '','Email');
	  $arryCalllogList = $objLead->GetCommentUser('', $_GET['parentID'], $_GET['parent_type'], '', '','Call');
	  //PR($arryEmaillogList);
				/***GET Email Log by sachin***/

	 /*****************************/
	   if($_GET['tab']=='Campaign'){
		$arryCampaign=$objLead->GetCompaignData($_GET['view'],$_GET['module'],$_GET['tab']);
		 $num=$objLead->numRows();
		$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
		(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
	   }

		/************************************/
		if($_GET['tab']=='Ticket'){
		$arryTicket=$objLead->GetTicketData($_GET['view'],$_GET['module'],$_GET['tab']);
		 $num=$objLead->numRows();
		$pagerLink=$objPager->getPager($arryTicket,$RecordsPerPage,$_GET['curP']);
		(count($arryTicket)>0)?($arryTicket=$objPager->getPageRecords()):("");
		}
       if($_GET['tab']=="Event"){

        if(isset($_GET['act_id']) && !empty($_GET['act_id'])){
			$_SESSION['mess_Event'] =EVENT_REMOVE;
			$objActivity->deleteActivity($_GET['act_id']);
			header("Location:vOpportunity.php?view=".$_GET['view']."&module=".$_GET['module']."&tab=".$_GET['tab']);
		}


		  $arryActivity=$objActivity->ListActivity('',$_GET['module'],$_GET['view'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		  $num=$objActivity->numRows();
		  $pagerLink=$objPager->getPager($arryActivity,$RecordsPerPage,$_GET['curP']);
		  ( count($arryActivity)>0)?($arryActivity=$objPager->getPageRecords()):("");

		}

		$OpportunityID   = $_GET['view'];
		if($arryOpportunity[0]['LeadID']>0){			
			$arryLead = $objLead->GetLead($arryOpportunity[0]['LeadID'],'');
		}
		
		$arrySupervisor = $objEmployee->GetEmployeeBrief($arryOpportunity[0]['AssignTo']);
		//print_r($arryLead);

		
	}


	if(empty($arryOpportunity[0]['OpportunityID'])) {
		header('location:'.$RedirectURL);
		exit;
	}


	/*****************/

	if($Config['vAllRecord']!=1){
		if($arryOpportunity[0]['AssignTo'] !=''){
		   $arrAssigned = explode(",",$arryOpportunity[0]['AssignTo']);
		}
		if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryOpportunity[0]['created_id'] != $_SESSION['AdminID'])  {				
		header('location:'.$RedirectURL);
		exit;
		}
	}



	/*****************/

/************************************************/
$AssignName='';
         if($arryOpportunity[0]['AssignTo']  >0){ 
	if($arryOpportunity[0]['AssignType'] == 'Group'){ 
		$assignee = $arryOpportunity[0]['AssignTo']; 
		$arryGrp = $objGroup->getGroup($arryOpportunity[0]['GroupID'],1);

		$AssignName = $arryGrp[0]['group_name'];
		$arryAssignee = $objLead->GetAssigneeUser($arryOpportunity[0]['AssignTo']);
	} else{ 
		$assignee = $arryOpportunity[0]['AssignTo'];
		$arryAssignee = $objLead->GetAssigneeUser($arryOpportunity[0]['AssignTo']);
		if(!empty($arryAssignee)){
			$AssignName = $arryAssignee[0]['UserName'];
		}
	}
         }
/************************************************/



if($_GET['tab']=='Lead' || $_GET['tab']=='Opportunity'){
	//$arryLead = $arryOpportunity;
	/*******Connecting to main database********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	if($arryOpportunity[0]['country_id']>0){
	$arryCountryName = $objRegion->GetCountryName($arryOpportunity[0]['country_id']);
	$CountryName = stripslashes($arryCountryName[0]["name"]);
	}

	if(!empty($arryOpportunity[0]['state_id'])) {
	$arryState = $objRegion->getStateName($arryOpportunity[0]['state_id']);
	$StateName = stripslashes($arryState[0]["name"]);
	}else if(!empty($arryOpportunity[0]['OtherState'])){
	$StateName = stripslashes($arryOpportunity[0]['OtherState']);
	}

	if(!empty($arryOpportunity[0]['city_id'])) {
	$arryCity = $objRegion->getCityName($arryOpportunity[0]['city_id']);
	$CityName = stripslashes($arryCity[0]["name"]);
	}else if(!empty($arryOpportunity[0]['OtherCity'])){
	$CityName = stripslashes($arryOpportunity[0]['OtherCity']);
	}

}
 

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/


	require_once("../includes/footer.php"); 	 
?>


