<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/crm.class.php");

$ModuleName = "Ticket";
$objLead = new lead();
$objGroup = new group();
$objCommon = new common();
$objFilter = new filter();


if ($_GET['parent_type'] != '' && $_GET['parentID'] != '') {

    $AddUrl = "editTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $vTicket = "vTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&view=";
    $editTicket = "editTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&edit=";
    $DelTicket = "editTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&del_id=";
} else {
    $AddUrl = "editTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $vTicket = "vTicket.php?module=" . $_GET["module"] . "&view=";
    $editTicket = "editTicket.php?module=" . $_GET["module"] . "&edit=";
    $DelTicket = "editTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"] . "&del_id=";
}

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewTicket.php?module=Ticket");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "") {

    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}
if ($_GET["customview"] == 'All') {
    $arryTicket = $objLead->ListTicket($_GET);
} else {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"]);
    $arryQuery = $objFilter->getFileter($_GET["customview"]);
    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");
	
        foreach ($arryQuery as $colRul) {

            if ($colRul['comparator'] == 'e') {

                if ($colRul['columnname'] == 'AssignedTo') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }
            if ($colRul['comparator'] == 'n') {
                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignedTo') {
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
        $arryTicket = $objLead->CustomTicket($colValue, $colRule);
    }
}
$num = $objLead->numRows();
$pagerLink = $objPager->getPager($arryTicket, $RecordsPerPage, $_GET['curP']);
(count($arryTicket) > 0) ? ($arryTicket = $objPager->getPageRecords()) : ("");

$arryTicketStatus = $objCommon->GetCrmAttribute('TicketStatus', '');



require_once("../includes/footer.php");
?>


