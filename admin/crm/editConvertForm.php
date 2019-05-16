<?php 
	/**************************************************/
	 $HideNavigation = 1;
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
		require_once($Prefix."classes/quote.class.php");
		require_once($Prefix."classes/sales.customer.class.php");
		require_once($Prefix."classes/field.class.php");//By Chetan//


		$Module="Lead";
		$objLead=new lead();
		$objEmployee=new employee();
		$objContact=new contact();
		$objCommon=new common();
		$objCompany=new company();
		$objActivity = new activity();
		$objGroup=new group();
		$objField = new field();//By Chetan//
		$objQuote=new quote();
		$objCustomer=new customer();
	
		$ModuleName = "Lead";
		$RedirectURL = "viewLead.php?module=".$_GET["module"]."&curP=".$_GET['curP'];
		if(empty($_GET['tab'])) $_GET['tab']="Lead";

		$EditUrl = "editLead.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
		$ViewUrl = "vLead.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 

		$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";

/***********************/
$Config['Junk']=0;
if($_GET['module']=='junk'){
	$Config['vAllRecord']=1;
	$Config['Junk']=1;
}
/***********************/

$arryHead=$objField->getHead('',$ModuleParentID,1);//By Chetan//


			if($_GET['tab']=="Task" || $_GET['tab']=="Event"){
				$AddRef="editActivity.php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
			}else{

            $AddRef="edit".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
			$SelectRef="view".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
        $ViewUrl = "vLead.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
			}

	
	
	
	
	/************************/
	if($_POST){
		/*******************/
		$Comment = $_POST['Comment'];
		CleanPost(); 
		$_POST['Comment'] = $Comment;
		/*******************/

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
if($_POST['convert_Id']!=''){
$AddID = $objLead->addConvertContact($_POST,$CustID,"contact");
$hideframe =1;

}
if($_POST['convert_opp']!='' || $_POST['convert_quote']!=''){
$LastID = $objLead->convertOpportunity($_POST);
			if(!empty($LastID)){
				
			   $oppID = $objLead->ConvertLead($_POST['LeadID'],1, $LastID);
			   //$arryOpp = $objLead->GetOpportunity($LastID,'');
			  	
				$_POST['opportunityID'] =$LastID;
				$_POST['CustType'] ='o';

			}
if($_POST['convert_quote']==''){
echo '<script>parent.location="viewOpportunity.php?module=Opportunity"</script>';

}

}



if($_POST['convert_quote']!=''){

$ImageId = $objLead->ConvertQuote($_POST);
echo '<script>parent.location="editQuote.php?edit='.$ImageId.'&module=Quote"</script>';
//header("location:editQuote.php?edit=".$ImageId."&module=Quotes");
		      exit;
			
}

if($hideframe ==1){
echo '<script>parent.location.reload(true);</script>';
}

}

		


		if (!empty($_GET['view'])) {
			$arryLead = $objLead->GetLead($_GET['view'],'');
                        $PageHeading = 'View lead Detail for: '.stripslashes($arryLead[0]['FirstName']);
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
                
            
	
$arryCustomer = $objCustomer->GetCustomerList();
		$arryDepartment = $objConfigure->GetDepartment();
		$_GET['Status']=1; $_GET['Division']=5;
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
		$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
		$arryIndustry = $objCommon->GetCrmAttribute('Industry','');
		$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');
		$arrrating= $objLead->Getrating($arryLead[0]['Rating']);

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


