<?php

$FancyBox = 1;
/* * *********************************************** */
$ThisPageName = 'viewOpportunity.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/employee.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/sales.customer.class.php");
require_once($Prefix . "classes/group.class.php");


$ModuleName = "Opportunity";
$RedirectURL = "viewOpportunity.php?curP=" . $_GET['curP'] . "&module=" . $_GET["module"];
if (empty($_GET['tab']))
    $_GET['tab'] = "Summary";

$EditUrl = "editOpportunity.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&module=" . $_GET["module"] . "&tab=";

$vUrl = "vOpportunity.php?view=" . $_GET["edit"] . "&module=" . $_GET["module"] . "&curP=" . $_GET["curP"] . "&tab=";

$objLead = new lead();
$objRegion = new region();
$objEmployee = new employee();
$objCommon = new common();
$objCustomer = new Customer();
$objGroup = new group();

/* * *******  Multiple Actions To Perform ********* */
if (!empty($_GET['multiple_action_id'])) {
    $multiple_action_id = rtrim($_GET['multiple_action_id'], ",");

    $mulArray = explode(",", $multiple_action_id);

    switch ($_GET['multipleAction']) {
        case 'delete':
            foreach ($mulArray as $del_id) {
                $objLead->RemoveLead($del_id);
            }
            $_SESSION['mess_opp'] = OPP_REMOVE;
            break;
        case 'active':
            $objLead->MultipleLeadStatus($multiple_action_id, 1);
            $_SESSION['mess_opp'] = OPP_REMOVE;
            break;
        case 'inactive':
            $objLead->MultipleLeadStatus($multiple_action_id, 0);
            $_SESSION['mess_opp'] = OPP_REMOVE;
            break;
    }
    header("location: " . $RedirectURL);
    exit;
}

/* * **********************  End Multiple Actions ************** */



if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_opp'] = OPP_REMOVE;
    $objLead->RemoveOpportunity($_REQUEST['del_id']);
    header("Location:" . $RedirectURL);
}


if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_opp'] = OPP_STATUS;
    $objLead->changeOpportunityStatus($_REQUEST['active_id']);
    header("Location:" . $RedirectURL);
}

/* * ************************************************************ */

if ($_POST) {

    if (!empty($_POST['OpportunityID'])) {
        $ImageId = $_POST['OpportunityID'];

        /*         * ************************ */

        $objLead->UpdateOpportunity($_POST);
        $_SESSION['mess_opp'] = OPP_UPDATED;
        header("Location:" . $vUrl);
        exit;

        /*         * ************************ */
    } else {
        //if($objLead->isEmailExists($_POST['Email'],'')){
        //$_SESSION['mess_opp'] = $MSG[105];
        //}else{	
        $ImageId = $objLead->AddOpportunity($_POST);
        $_SESSION['mess_opp'] = OPP_ADDED;

        if (!empty($ImageId)) {
            $objLead->UpdateCreater($_POST, "c_opportunity", "OpportunityID", $ImageId);
        }
        //}
    }

    $_POST['leadID'] = $ImageId;


    if (!empty($_GET['edit'])) {
        header("Location:" . $ActionUrl);
        exit;
    } else {
        header("Location:" . $RedirectURL);
        exit;
    }
}


if (!empty($_GET['edit'])) {
    $arryOpportunity = $objLead->GetOpportunity($_GET['edit'], '');
    
    $OpportunityID = $_REQUEST['edit'];

    if ($arryOpportunity[0]['LeadID'] > 0) {
        $arryLead = $objLead->GetLead($arryOpportunity[0]['LeadID'], '');
    }

    if (empty($arryOpportunity[0]['OpportunityID'])) {
        header('location:' . $RedirectURL);
        exit;
    }


    /*     * ************** */
    if($Config['vAllRecord']!=1){
		if($arryOpportunity[0]['AssignTo'] !=''){
		   $arrAssigned = explode(",",$arryOpportunity[0]['AssignTo']);
		}
		if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryOpportunity[0]['created_id'] != $_SESSION['AdminID'])  {				
		header('location:'.$RedirectURL);
		exit;
		}
	}
    /*     * ************** */

 if ($arryOpportunity[0]['AssignType'] == "User" || $arryOpportunity[0]['AssignType'] == '') {

        $classUser = 'style="display:block;"';
        $classGroup = 'style="display:none;"';
        if ($arryOpportunity[0]['AssignTo'] != '') {
            $arryEmp = $objLead->GetAssigneeUser($arryOpportunity[0]['AssignTo']);
        }
        $return_array = array();
        for ($i = 0; $i < sizeof($arryEmp); $i++) {


            $row_array2['id'] = $arryEmp[$i]['EmpID'];
            $row_array2['name'] = $arryEmp[$i]['UserName'];
            $row_array2['department'] = $arryEmp[$i]['emp_dep'];
            $row_array2['designation'] = $arryEmp[$i]['JobTitle'];
            if ($arryEmp[$i]['Image'] == '') {
                $row_array2['url'] = "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
            } else {
                $row_array2['url'] = "resizeimage.php?w=50&h=50&img=../hrms/upload/employee/" . $_SESSION['CmpID'] . "/" . $arryEmp[$i]['Image'] . "";
            }

            array_push($return_array, $row_array2);
        }
        $json_response2 = json_encode($return_array);
    } elseif ($arryOpportunity[0]['AssignType'] == "Group") {
        $classUser = 'style="display:none;"';
        $classGroup = 'style="display:block;"';
    } else {
        $classUser = 'style="display:block;"';
        $classGroup = 'style="display:none;"';
    }
    /*  if($arryOpportunity[0]['AssignType'] == 'Group'){ 
      $assignee = $arryOpportunity[0]['assignTo'];
      } else{
      $assignee = $arryOpportunity[0]['assignTo'];
      } */
} else {

    $classUser = 'style="display:block;"';
    $classGroup = 'style="display:none;"';
}






if ($arryOpportunity[0]['Status'] != '') {
    $OpportunityStatus = $arryOpportunity[0]['Status'];
} else {
    $OpportunityStatus = 1;
}
$arryGroup = $objGroup->getGroup("", 1);
$arryDepartment = $objConfigure->GetDepartment();
$_GET['Status'] = 1;
$_GET['Division'] = 5;
$arryEmployee = $objEmployee->GetEmployeeList($_GET);
$arryCustomer = $objCustomer->GetCustomer('', '', 'Yes');


$arryOppType = $objCommon->GetCrmAttribute('Type', '');
$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');
$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage', '');
//print_r($arrySalesStage);




/* * **************************************** */

//$arryCountry = $objRegion->getCountry('','');

require_once("../includes/footer.php");
?>


