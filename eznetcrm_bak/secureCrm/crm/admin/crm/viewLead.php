<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("language/en_lead.php");
$ModuleName = "Lead";
$objLead = new lead();
$objFilter = new filter();
$objGroup = new group();

$RedirectUrl = "viewLead.php?curP=" . $_GET['curP'] . "&module=lead";

if ($_POST) {
    if (sizeof($_POST['leadID'] > 0)) {
        $lead = implode(",", $_POST['leadID']);
        $_SESSION['mess_lead'] = LEAD_REMOVE_MULTIPLE;
        $objLead->deleteLead($lead);
        header("location:" . $RedirectUrl);
        exit;
    }
}

/* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewLead.php?module=lead");
    exit;
}

/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "" ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
    
    
    
    if ($_GET["customview"] == 'All'  ) {
    $arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
   
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
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
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
        $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}



/* * ******************************************** */




$num = $objLead->numRows();

$pagerLink = $objPager->getPager($arryLead, $RecordsPerPage, $_GET['curP']);
(count($arryLead) > 0) ? ($arryLead = $objPager->getPageRecords()) : ("");

require_once("../includes/footer.php");
?>
