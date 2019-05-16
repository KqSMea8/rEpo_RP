<?php
$HideNavigation = 1;
 /**************************************************/
    $ThisPageName = 'viewActivity.php';   if($_GET['pop'] == 1){  $HideNavigation = 1; }
    /**************************************************/

		require_once("../includes/header.php");
		require_once($Prefix."classes/event.class.php");
		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix."classes/region.class.php");
		require_once($Prefix."classes/employee.class.php");
		require_once($Prefix."classes/group.class.php");
		require_once($Prefix."classes/sales.customer.class.php");	
	
	$ModuleName = "Activity";

	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
	$BackUrl = "viewActivity.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$RedirectURL = "viewActivity.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET['curP'];
	$EditUrl = "editActivity.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]; 
	$ViewUrl="vActivity.php?view=".$_GET["view"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]."&tab=";

	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";
	
	$ActionUrl = $EditUrl.$_GET["tab"];
	}else{
	$RedirectURL = "viewActivity.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewActivity.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Activity";
	$ViewUrl="vActivity.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=";
	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";

	$EditUrl = "editActivity.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&mode=".$_GET['mode']."&tab=".$_GET['tab']; 
	$ActionUrl = $EditUrl.$_GET["tab"];
   }
	


	$objActivity=new activity();
	$objLead=new lead();
	$objRegion=new region();
	$objEmployee=new employee();
        $objGroup=new group();
	$objCustomer=new Customer(); 
		/*******************/
		if($_SESSION['AdminType']=='admin'){
		$Admin=$_SESSION['AdminType'];
		}else{
		$Admin=$_SESSION['AdminID'];
		}
		/*******************/

		/*****************************/
	
		/*****************************/

		if (!empty($_GET['view'])) {

		    if($_GET['mode']=="Task"){

		            $detail_head=$_GET['mode'];

		            $none="style='display:none';";
		     }else{
		          $detail_head="Event";
		          $none="";
		 }


	     $arryActivity = $objActivity->GetActivity($_GET['view'],'');
             $PageHeading = 'View Activity for: '.stripslashes($arryActivity[0]['subject']);


		if(!empty($arryActivity[0]['CustID'])){
			$arryCustomer = $objCustomer->GetCustomer($arryActivity[0]['CustID'],'','');
		}






		if($arryActivity[0]['AssignType'] == 'Group'){ 
		      $assignee = $arryActivity[0]['assignedTo']; 
		      $arryGrp = $objGroup->getGroup($arryActivity[0]['GroupID'],1);
                      $AssignName = $arryGrp[0]['group_name'];
		  if($arryActivity[0]['assignedTo']!=''){
		      $arryAssignee = $objLead->GetAssigneeUser($arryActivity[0]['assignedTo']);
		   }
		} else{ 
		   $assignee = $arryActivity[0]['assignedTo'];
			if(!empty($arryActivity[0]['assignedTo'])){
			  $arryAssignee = $objLead->GetAssigneeUser($arryActivity[0]['assignedTo']);
			  $AssignName = $arryAssignee[0]['UserName'];
			}
		 
		}

	//$arryAssignEmp=$objActivity->getAssignEmp($_GET['edit'],'');		 
			$arryActEmp=$objActivity->getActivityEmp2($_GET['view'],'');
			$ActUrl ='';
			foreach($arryActEmp as $values)
			{
			  $ActUrl .= '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['EmpID'].'">'.$values['UserName'].'</a>,';
			}
			  $ActUrl = rtrim($ActUrl,",");

			  $activityID   = $_GET['edit'];

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
			  (count($arryCampaign)>0)?($arryTicket=$objPager->getPageRecords()):("");
			}
        
	}
	



	/************************************/
	/************************************/
	if($arryActivity[0]['RelatedType']!=''){
		$RelatedType=$arryActivity[0]['RelatedType'];

		if($RelatedType=='Opportunity'){
			$RelatedID = $arryActivity[0]['OpprtunityID'];
			if($RelatedID>0){
			$arryOpportunity = $objLead->GetOpportunity($RelatedID,1);
			$RelatedTitle = stripslashes($arryOpportunity[0]['OpportunityName']);
			$RelatedHTML = "<a class='fancybox fancybox.iframe' href='vOpportunity.php?view=".$arryActivity[0]['OpprtunityID']."&&pop=1'>".$RelatedTitle."</a>";
			}
		}else if($RelatedType=='Lead'){
			$RelatedID = $arryActivity[0]['LeadID'];
			if($RelatedID>0){
			$arryLead = $objLead->GetLead($RelatedID,'');
			$RelatedTitle = stripslashes($arryLead[0]['FirstName'])." ".stripslashes($arryLead[0]['LastName']);
			$RelatedHTML = "<a class='fancybox fancybox.iframe' href='vLead.php?view=".$arryActivity[0]['LeadID']."&pop=1'>".$RelatedTitle."</a>";
			}
		}else if($RelatedType=='Campaign'){
			$RelatedID = $arryActivity[0]['CampaignID'];
			if($RelatedID>0){
			$arryCampaign= $objLead->GetCampaign($RelatedID,'');
			$RelatedTitle = stripslashes($arryCampaign[0]['campaignname']);
			$RelatedHTML = "<a class='fancybox fancybox.iframe' href='vCampaign.php?view=".$arryActivity[0]['CampaignID']."&pop=1'>". $RelatedTitle."</a>";
			}
		}else if($RelatedType=='Ticket'){
			$RelatedID = $arryActivity[0]['TicketID'];
			if($RelatedID>0){
			$arryTicket= $objLead->GetTicketBrief($RelatedID,'');
			$RelatedTitle = stripslashes($arryTicket[0]['title']);
			$RelatedHTML = "<a class='fancybox fancybox.iframe' href='vTicket.php?view=".$arryActivity[0]['TicketID']."&pop=1'>". $RelatedTitle."</a>";
			}
		}else if($RelatedType=='Quote'){
			$RelatedID = $arryActivity[0]['QuoteID'];
			if($RelatedID>0){
			$arryQuote= $objLead->GetQuoteBrief($RelatedID,'');
			$RelatedTitle = stripslashes($arryQuote[0]['subject']);
			$RelatedHTML = "<a class='fancybox fancybox.iframe' href='vQuote.php?view=".$arryActivity[0]['QuoteID']."&pop=1'>". $RelatedTitle."</a>";
			}
		}else{
			$RelatedHTML = NOT_SPECIFIED;
		}

	}


	require_once("../includes/footer.php"); 
?>
