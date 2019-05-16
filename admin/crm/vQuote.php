<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewQuote.php'; $EditPage = 1;
if(!empty($_GET['pop']))$HideNavigation = 1;
    /**************************************************/
   
	require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");//By chetan//
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");//By chetan//
        require_once($Prefix."classes/event.class.php");
        require_once($Prefix."classes/field.class.php");//By Chetan//

	$_GET['view'] = (int)$_GET['view'];

$Module = "Quotes";
$RedirectURL = "viewQuote.php?curP=".$_GET['curP']."&module=".$_GET["module"];

$_SESSION['DateFormat'] = $Config['DateFormat'];
/*if($_SESSION['CmpID']==228){
$DownloadUrl = "pdfQuoteAvtech.php?o=".$_GET["view"]."&module=".$_GET["module"]; 
}else{
$DownloadUrl = "pdfQuote.php?o=".$_GET["view"]."&module=".$_GET["module"]; 
}*/
//Added on 8May2018 by saiyed//
$ModuleDepName = "Quote";
$DownloadUrl = "../pdfCommonhtml.php?o=" . $_GET["view"] . "&ModuleDepName=" . $ModuleDepName;
//End//

if(empty($_GET['tab'])) $_GET['tab']="Quote";

$EditUrl = "editQuote.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&module=".$_GET["module"]."&tab="; 

if(empty($_GET['tab'])) $_GET['tab']="Quote";

$EditUrl = "editQuote.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
$ViewUrl = "vQuote.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 

$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";
if($_GET['tab']=="Task" || $_GET['tab']=="Event"){
$AddRef="editActivity.php?module=".$_GET['tab']."&parent_type=Quote&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
}else{

$AddRef="edit".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=Quote&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
$SelectRef="view".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=Quote&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
$ViewUrl = "vQuote.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
}
	
	$objGroup = new group();
	$objLead=new lead();
	$objQuote=new quote();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCommon=new common();
	$objCustomer=new Customer(); 
	$objActivity=new activity(); 
	$objField = new field();//By Chetan//
        
        
        $arryHead=$objField->getHead('',$ModuleParentID,1);//By Chetan//
        
        	

	if(!empty($_POST['ConvertOrderID'])) {
		CleanPost();
		$objQuote->CrmQuoteToSaleOrder($_POST['ConvertOrderID'],$_POST['SaleID']);
		$_SESSION['mess_quote'] = QUOTE_TO_SO_CONVERTED;
		header("Location:".$RedirectURL);
		exit;
	 }	

	/*if($_GET['select_del_id'] && !empty($_GET['select_del_id'])){
		$_SESSION['mess_ticket'] = LEAD_REMOVE;
		$objLead->RemoveSelectCompaign($_GET['select_del_id']);
		header("Location:".$ViewUrl.$_GET['tab']);
	}*/



	if (!empty($_GET['view'])) {
                $arryQuote = $objQuote->GetQuote($_GET['view'],'');
                $PageHeading = 'View quote for subject: '.stripslashes($arryQuote[0]['subject']);
               
		if($arryQuote[0]['OpportunityID']>0){
			$arryOpp = $objLead->GetOpportunity($arryQuote[0]['OpportunityID'],'');
		}
		$OpportunityName = (!empty($arryOpp[0]['OpportunityName']))?(stripslashes($arryOpp[0]['OpportunityName'])):(stripslashes($arryQuote[0]['opportunityName']));


		if($arryQuote[0]['CustID']>0){
			$arryCustomer = $objCustomer->GetCustomer($arryQuote[0]['CustID'],'','');
		}
		$CustomerName = (!empty($arryCustomer[0]['FullName']))?(stripslashes($arryCustomer[0]['FullName'])):(stripslashes($arryQuote[0]['CustomerName']));




		if($arryQuote[0]['AssignType'] == 'Group'){ 
			$assignee = $arryQuote[0]['assignTo']; 
			$arryGrp = $objGroup->getGroup($arryQuote[0]['GroupID'],1);
			$AssignName = $arryGrp[0]['group_name'];
			$arryAssignee = $objQuote->GetAssignee($arryQuote[0]['assignTo']);

		} else if(!empty($arryQuote[0]['assignTo'])){ 
			$assignee = $arryQuote[0]['assignTo'];
			$arryAssignee = $objQuote->GetAssignee($arryQuote[0]['assignTo']);
			$AssignName = $arryAssignee[0]['UserName'];
		}

		$arryQuoteAdd = $objQuote->GetQuoteAddress($_GET['view'],'');

                $OrderID = $arryQuote[0]['quoteid'];
		if($OrderID>0){
			$arryQuoteProduct = $objQuote->GetQuoteItem($OrderID);
			$NumLine = sizeof($arryQuoteProduct);
		}


/*
		$arryQuote = $objQuote->GetQuote($_GET['view'],'');

		$arryQuoteAdd = $objQuote->GetQuoteAddress($_GET['view'],'');

		
		$arryQuoteProduct = $objQuote->GetQuoteProduct($_GET['view'],'');*/

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
			header("Location:vQuote.php?view=".$_GET['view']."&module=".$_GET['module']."&tab=".$_GET['tab']);
			}


		 $arryActivity=$objActivity->ListActivity('',$_GET['module'],$_GET['view'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		  $num=$objActivity->numRows();
		  $pagerLink=$objPager->getPager($arryActivity,$RecordsPerPage,$_GET['curP']);
		  ( count($arryActivity)>0)?($arryActivity=$objPager->getPageRecords()):("");

		}
	

		$quoteid   = $_GET['view'];			
	}
		



		if(empty($arryQuote[0]['quoteid'])) {
			header('location:'.$RedirectURL);
			exit;
		}		
		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryQuote[0]['assignTo'] !=''){
				$arrAssigned = explode(",",$arryQuote[0]['assignTo']);
			}
			if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryQuote[0]['AdminID'] != $_SESSION['AdminID']){				
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/





		
	/*if($arryQuote[0]['Status'] != ''){
		$QuoteStatus = $arryQuote[0]['Status'];
	}else{
		$QuoteStatus = 1;
	}*/				
		
	
    	$arryDepartment = $objConfigure->GetDepartment();
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryQuoteStatus = $objCommon->GetCrmAttribute('QuoteStatus','');
	$arryQuoteSource = $objCommon->GetCrmAttribute('QuoteSource','');
	$arryIndustry = $objCommon->GetCrmAttribute('QuoteIndustry','');
	$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');

	$_SESSION['Currency'] = $Config['Currency'];
	/*******************************************/


	/*8May2018by saiyed * **start code for get tempalte name for dynamic pdf by sachin** */
	$_GET['ModuleName'] 	= $ModuleDepName;
	$_GET['Module'] 	= $ModuleDepName;
	$_GET['ModuleId'] 	= $_GET['view'];
	$_GET['listview']	= '1';
	$GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	/*to get default dynamic template*/
	$_GET['setDefautTem']	= '1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	/*End*/

    /*     * **end code for get tempalte name for dynamic pdf by sachin** */


	//$arryCountry = $objRegion->getCountry('','');

	require_once("../includes/footer.php"); 
?>


