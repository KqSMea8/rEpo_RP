<?php $FancyBox=1;
 /**************************************************/
   $ThisPageName = 'viewLead.php';  $HideNavigation = 1;
    /**************************************************/
   
	require_once("../includes/header.php");

	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/group.class.php");

	
	
	$ModuleName = "Activity";

if($_POST['parent_type'] == 'Opportunity'){
		$RedirectURL = "vOpportunity.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=Opportunity&tab=Event";
		$_POST['OpprtunityID'] = $_POST['parentID'];
		$_POST['RelatedType'] = 'Opportunity';
}
if($_POST['parent_type'] == 'lead'){
	$RedirectURL = "vLead.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=lead&tab=Event";
	$_POST['LeadID'] = $_POST['parentID'];
	$_POST['RelatedType'] = 'Lead';
	$_POST['parent_type'] = 'Lead';
}
if($_POST['parent_type'] == 'Ticket'){
	$RedirectURL = "vTicket.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=".$_POST['parent_type']."&tab=Event";
	$_POST['TicketID'] = $_POST['parentID'];
	$_POST['RelatedType'] = 'Ticket';
}

if($_POST['parent_type'] == 'Quote'){
	$RedirectURL = "vQuote.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=".$_POST['parent_type']."&tab=Event";

	$_POST['QuoteID'] = $_POST['parentID'];
	$_POST['RelatedType'] = 'Quote';
}

	$objCommon=new common();
	$objLead=new lead();
        $objGroup=new Group();
        $objActivity=new activity();
	$objEmployee=new employee();
	
		if ($_POST) {
		

			$ImageId = $objActivity->AddActivity($_POST); 
			$_SESSION['mess_activity'] = ACT_ADD;

			$_POST['activityID'] = $ImageId;
			$objActivity->addActivityEmp($_POST);
			$objActivity->addAssignEmp($_POST);

			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';


		}

	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryOpportunity=$objLead->GetOpportunity('',1);
	$arryCampaign=$objLead->GetCampaign('',1);
	$arrySerch=$objLead->GetLead($id=0,1);
	$arryGroup = $objGroup->getGroup("",1);

	require_once("../includes/footer.php"); 
?>

