<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/event.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/lead.class.php");
$ModuleName = $_GET['module'];
$objActivity = new activity();
$objCommon = new common();
$objFilter = new filter();
$objLead = new lead();

//($_GET['st'] == '') ? ($_GET['st'] = 1) : ("");

($_GET['mode'] == '') ? ($_GET['mode'] = "Event") : ("");


if ($_GET['parent_type'] != '' && $_GET['parentID'] != '') {


    $AddUrl = "editActivity.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewActivity.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    //$AddUrl = "editActivity.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
    //echo $AddUrl;  exit;
} else {
    $AddUrl = "editActivity.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewActivity.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
}

/* * ************************************************************ */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewActivity.php?module=Activity");
    exit;
}

/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "" && $_GET['key'] == "" && $_GET['FromDate'] == "" && $_GET['ToDate'] == ""){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0 && $_GET['key'] == "" && $_GET['FromDate'] == "" && $_GET['ToDate'] == ""){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
 
/*********************Set Defult ************/
if ($_GET["customview"] == 'All' ) {
    
    $arryActivity = $objActivity->GetActivityList($_GET);
    
} else {
    
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
        #echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul) {

            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'AssignTo' || $colRul['columnname'] == 'assignTo' || $colRul['columnname'] == 'assignedTo') {
                    $comparator = 'like';


                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo' || $colRul['columnname'] == 'assignTo' || $colRul['columnname'] == 'assignedTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'in') {
                $comparator = 'in';

                $arrVal = explode(",", $colRul['value']);

                $FinalVal = '';
                foreach ($arrVal as $tempVal) {
                    $FinalVal .= "'" . trim($tempVal) . "',";
                }
                $FinalVal = rtrim($FinalVal, ",");
                $setValue = trim($FinalVal);

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        $arryActivity = $objActivity->CustomActivity($colValue, $colRule);
    }
}
/* * *********************************************************** */







#$arryActivity = $objActivity->GetActivityList($_GET);



$num = $objActivity->numRows();

$pagerLink = $objPager->getPager($arryActivity, $RecordsPerPage, $_GET['curP']);
(count($arryActivity) > 0) ? ($arryActivity = $objPager->getPageRecords()) : ("");



require_once("../includes/footer.php");
?>
