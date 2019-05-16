<?php

$FancyBox = 1;
/* * *********************************************** */
$ThisPageName = 'viewLead.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/employee.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix."classes/field.class.php");
$ModuleName = "Lead";
$RedirectURL = "viewLead.php?curP=" . $_GET['curP'] . "&module=" . $_GET["module"];




/***********************/
$Config['Junk']=0;
if($_GET['module']=='junk'){
	$Config['vAllRecord']=1;
	$Config['Junk']=1;
}
/***********************/


$_GET['edit'] = (int)$_GET['edit'];



if (empty($_GET['tab']))
    $_GET['tab'] = "Summary";

$EditUrl = "editLead.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&module=" . $_GET["module"] . "&tab=";

$vUrl = "vLead.php?view=" . $_GET["edit"] . "&module=" . $_GET["module"] . "&curP=" . $_GET["curP"] . "&tab=";

$objLead = new lead();
$objRegion = new region();
$objEmployee = new employee();
$objCommon = new common();
$objGroup = new group();
$objField = new field();

/* * *******  Multiple Actions To Perform ********* */
if (!empty($_GET['multiple_action_id'])) {
    $multiple_action_id = rtrim($_GET['multiple_action_id'], ",");

    $mulArray = explode(",", $multiple_action_id);

    switch ($_GET['multipleAction']) {
        case 'delete':
            foreach ($mulArray as $del_id) {
                $objLead->RemoveLead($del_id);
            }
            $_SESSION['mess_lead'] = LEAD_REMOVE;
            break;
        case 'active':
            $objLead->MultipleLeadStatus($multiple_action_id, 1);
            $_SESSION['mess_lead'] = LEAD_REMOVE;
            break;
        case 'inactive':
            $objLead->MultipleLeadStatus($multiple_action_id, 0);
            $_SESSION['mess_lead'] = LEAD_REMOVE;
            break;
    }
    header("location: " . $RedirectURL);
    exit;
}

/* * **********************  End Multiple Actions ************** */



if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_lead'] = LEAD_REMOVE;
    $objLead->RemoveLead($_GET['del_id']);
    header("Location:" . $RedirectURL);
}


if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_lead'] = LEAD_STATUS;
    $objLead->changeLeadStatus($_GET['active_id']);
    header("Location:" . $RedirectURL);
}

/* * ************************************************************ */

if ($_POST) {

/*******************/
CleanPost(); 
/*******************/
//For array to string conversion by niraj 10feb16
	array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
      //End array to string conversion by niraj
    if (!empty($_POST['leadID'])) {
        $ImageId = $_POST['leadID'];

        /*         * ************************ */
        switch ($_GET['tab']) {
            case 'Lead':
                $objLead->UpdateLead($_POST);

		$fieldIDs=$fieldNames='';
                if(!empty($_POST['fieldIds'])) $fieldIDs = explode(',',$_POST['fieldIds']);
                if(!empty($_POST['fields'])) $fieldNames = explode(',',$_POST['fields']);
                
		$objField->updateModuleForm($_POST,$ImageId,$fieldIDs,$fieldNames);
                //End//
                $_SESSION['mess_lead'] = LEAD_UPDATED;
 
                break;
        }
        /*         * ************************ */
    } else {
      	
        $ImageId = $objLead->AddLead($_POST);
        $_SESSION['mess_lead'] = LEAD_ADDED;
        if (!empty($ImageId)) {

            $objLead->UpdateCreater($_POST, "c_lead", "leadID", $ImageId);
        }
 
	$fieldIDs=$fieldNames='';

        if(!empty($_POST['fieldIds'])) $fieldIDs = explode(',',$_POST['fieldIds']); 
        if(!empty($_POST['fields']))  $fieldNames = explode(',',$_POST['fields']); 
	if($ImageId>0){
		$objField->updateModuleForm($_POST,$ImageId,$fieldIDs,$fieldNames);
	}
 	 
       
    }

    $_POST['leadID'] = $ImageId;





    /*     * ****************ADD COUNTRY/STATE/CITY NAME**************** */
    $Config['DbName'] = $Config['DbMain'];
    $objConfig->dbName = $Config['DbName'];
    $objConfig->connect();
    /*     * ******************************** */

    $arryCountry = $objRegion->GetCountryName($_POST['country_id']);
    $arryRgn['Country'] = stripslashes($arryCountry[0]["name"]);

    if (!empty($_POST['main_state_id'])) {
        $arryState = $objRegion->getStateName($_POST['main_state_id']);
        $arryRgn['State'] = stripslashes($arryState[0]["name"]);
    } else if (!empty($_POST['OtherState'])) {
        $arryRgn['State'] = $_POST['OtherState'];
    }

    if (!empty($_POST['main_city_id'])) {
        $arryCity = $objRegion->getCityName($_POST['main_city_id']);
        $arryRgn['City'] = stripslashes($arryCity[0]["name"]);
    } else if (!empty($_POST['OtherCity'])) {
        $arryRgn['City'] = $_POST['OtherCity'];
    }

    /*     * ******************************** */
    $Config['DbName'] = $_SESSION['CmpDatabase'];
    $objConfig->dbName = $Config['DbName'];
    $objConfig->connect();

    $objLead->UpdateCountyStateCity($arryRgn, $_POST['leadID']);

    /*     * ************END COUNTRY NAME******************** */




    if (!empty($_GET['edit'])) {
        header("Location:" . $vUrl);
        exit;
    } else {
        header("Location:" . $RedirectURL);
        exit;
    }
}


if (!empty($_GET['edit'])) {
    $arryLead = $objLead->GetLead($_GET['edit'], '');
    $PageHeading = 'Edit lead Detail for: '.stripslashes($arryLead[0]['FirstName']);
    $arryLeadDetail = $objLead->GetLeadDetail($_GET['edit'], '');
    $leadID = $_GET['edit'];

    if (empty($arryLead[0]['leadID'])) {
        header('location:' . $RedirectURL);
        exit;
    }


/****************/
if($Config['vAllRecord']!=1){
	if($arryLead[0]['AssignTo'] !=''){
		$arrAssigned = explode(",",$arryLead[0]['AssignTo']);
	}
	if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryLead[0]['created_id'] != $_SESSION['AdminID']){				
		header('location:'.$RedirectURL);
		exit;
	}
}
/****************/
    if ($arryLead[0]['AssignType'] == "Users" || $arryLead[0]['AssignType'] == '') {
		$arryEmp = array();
        $classUser = 'style="display:block;"';
        $classGroup = 'style="display:none;"';
        if ($arryLead[0]['AssignTo'] != '') {
            #echo $arryLead[0]['AssignTo']; exit;
            $arryEmp = $objLead->GetAssigneeUser($arryLead[0]['AssignTo']);
        }
        $return_array = array();
        for ($i = 0; $i < sizeof($arryEmp); $i++) {
            $row_array2['id'] = $arryEmp[$i]['EmpID'];
            $row_array2['name'] = $arryEmp[$i]['UserName'];
            $row_array2['department'] = $arryEmp[$i]['emp_dep'];
            $row_array2['designation'] = $arryEmp[$i]['JobTitle'];
			$arryEmp[$i]['Image'] = (isset($arryEmp[$i]['Image'])) ? $arryEmp[$i]['Image'] : '';
            if($arryEmp[$i]['Image'] == '') {
                $row_array2['url'] = "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
            } else {
                $row_array2['url'] = "resizeimage.php?w=50&h=50&img=../hrms/upload/employee/" . $_SESSION['CmpID'] . "/" . $arryEmp[$i]['Image'] . "";
            }

            array_push($return_array, $row_array2);
        }
        $json_response2 = json_encode($return_array);
    } elseif ($arryLead[0]['AssignType'] == "Group") {
        $classUser = 'style="display:none;"';
        $classGroup = 'style="display:block;"';
    } else {
        $classUser = 'style="display:block;"';
        $classGroup = 'style="display:none;"';
    }
    /*  if($arryTicket[0]['AssignType'] == 'Group'){ 
      $assignee = $arryTicket[0]['assignTo'];
      } else{
      $assignee = $arryTicket[0]['assignTo'];
      } */
} else {

    $classUser = 'style="display:block;"';
    $classGroup = 'style="display:none;"';
}



/* * ************** */




/*if (!empty($arryLead) && $arryLead[0]['Status'] != '') {
    $LeadStatus = $arryLead[0]['Status'];
} else {
    $LeadStatus = 1;
}*/

$arryGroup = $objGroup->getGroup("", 1);
$arryDepartment = $objConfigure->GetDepartment();
$_GET['Status'] = 1;
$_GET['Division'] = 5;
$arryEmployee = $objEmployee->GetEmployeeList($_GET);
$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus', '');
$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');
$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage', '');
$arrrating= $objLead->Getrating();
$arryHead=$objField->getHead('',$ModuleParentID,1);

/* * *****Connecting to main database******* */
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */
if (!empty($arryLead) && $arryLead[0]['country_id'] > 0) {
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
    $CityName = stripslashes($arryEmployee[0]['OtherCity']);
}

/* * **************************************** */

//$arryCountry = $objRegion->getCountry('','');
/******Connecting to company database********/
 $Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
/******************************************/


$ArrCustomFields = $objField->getAllCustomFieldByModule($_GET['module']);
$ArrField = array_map(function($a) {
					  return $a['fieldid'];
					}, $ArrCustomFields);
$ArrFieldName = array_map(function($a) {
					  return $a['fieldname'];
					}, $ArrCustomFields);

$StrField = join(',',  $ArrField);
$StrFieldName = join(',',  $ArrFieldName);


require_once("../includes/footer.php");
?>


