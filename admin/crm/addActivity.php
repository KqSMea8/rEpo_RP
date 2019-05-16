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

	//By chetan 24Nov//
        require_once($Prefix."classes/field.class.php");
        require_once($Prefix."classes/sales.customer.class.php");
        
	
	$objField=new field();
        $objCustomer=new Customer(); 
        
        
        $arryHead=$objField->getHead('',136,1);
        //End//
	
	$ModuleName = "Activity";

if(isset($_POST['parent_type']) && $_POST['parent_type'] == 'Opportunity'){
		$RedirectURL = "vOpportunity.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=Opportunity&tab=Event";
		$_POST['OpprtunityID'] = $_POST['parentID'];
		$_POST['RelatedType'] = 'Opportunity';
}
if(isset($_POST['parent_type']) && $_POST['parent_type'] == 'lead'){
	$RedirectURL = "vLead.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=lead&tab=Event";
	$_POST['LeadID'] = $_POST['parentID'];
	$_POST['RelatedType'] = 'Lead';
	$_POST['parent_type'] = 'Lead';
}
if(isset($_POST['parent_type']) && $_POST['parent_type'] == 'Ticket'){
	$RedirectURL = "vTicket.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=".$_POST['parent_type']."&tab=Event";
	$_POST['TicketID'] = $_POST['parentID'];
	$_POST['RelatedType'] = 'Ticket';
}

if(isset($_POST['parent_type']) && $_POST['parent_type'] == 'Quote'){
	$RedirectURL = "vQuote.php?view=".$_GET['parentID']."&curP=".$_GET['curP']."&module=".$_POST['parent_type']."&tab=Event";

	$_POST['QuoteID'] = $_POST['parentID'];
	$_POST['RelatedType'] = 'Quote';
}

	$objCommon=new common();
	$objLead=new lead();
        $objGroup=new Group();
        $objActivity=new activity();
	$objEmployee=new employee();
	
		if($_POST){
			/*******************/
			$description = addslashes($_POST['description']);
			CleanPost(); 
			$_POST['description'] = $description;
			/*******************/

			$ImageId = $objActivity->AddActivity($_POST); 
			//$_SESSION['mess_activity'] = ACT_ADD;

			$_POST['activityID'] = $ImageId;
			$objActivity->addActivityEmp($_POST);
			$objActivity->addAssignEmp($_POST);

			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';


		}
	

	//By chetan 24Nov//
            if(isset($arryActivity[0]['AssignType']) && $arryActivity[0]['AssignType'] == "Users"){
			$classUser = 'style="display:block;"';
			$classGroup = 'style="display:none;"';
			$arryEmp=$objLead->GetAssigneeUser($arryActivity[0]['assignedTo']);
			$return_array = array();
			for ($i=0;$i<sizeof($arryEmp);$i++) {


				$row_array['id'] = $arryEmp[$i]['EmpID'];
				$row_array['name'] =$arryEmp[$i]['UserName'];
				$row_array['department'] =$arryEmp[$i]['emp_dep'];
				$row_array['designation'] = $arryEmp[$i]['JobTitle'];
				if($arryEmp[$i]['Image']==''){
				$row_array['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
				}else{
				$row_array['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$arryEmp[$i]['Image']."";
				}

				array_push($return_array,$row_array);
			}

				$json_response= json_encode($return_array);
		 }elseif(isset($arryActivity[0]['AssignType']) && $arryActivity[0]['AssignType'] == "Group"){
			$classUser = 'style="display:none;"';
			$classGroup = 'style="display:block;"';
		}else{
                $classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';
}
        $arryCustomer = $objCustomer->GetCustomerList();
        //End//
	

	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryOpportunity=$objLead->GetOpportunity('',1);
	$arryCampaign=$objLead->GetCampaign('',1);
	$arrySerch=$objLead->GetLead($id=0,1);
	$arryGroup = $objGroup->getGroup("",1);

	require_once("../includes/footer.php"); 
?>

