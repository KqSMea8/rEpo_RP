<?php

$FancyBox = 1;

include_once("../includes/header.php");
require_once($Prefix . "classes/quote.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/lead.class.php");


$ModuleName = $_GET['module'];
$objQuote = new quote();
$objFilter = new filter();
$objLead = new lead();




if ($_GET['parent_type'] != '' && $_GET['parentID'] != '') {

    $AddUrl = "editQuote.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewQuote.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
} else {
    $AddUrl = "editQuote.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewQuote.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
}
$SendUrl = "sendSO.php?module=" . $module . "&curP=" . $_GET['curP'];



if ($_GET['search_Status'] != 'All' && $_GET['sortby'] == '' && empty($_GET['search'])) {
    $_GET['key'] = 'Created';
    $_GET['sortby'] = 'q.quotestage';
}



/* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewQuote.php?module=Quote");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "") {
#$objFilter->deleteFilter($arryDefult[0]['cvid']);
    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}
if ($_GET["customview"] == 'All') {
    $arryQuote = $objQuote->ListQuote('', $_GET['parent_type'], $_GET['parentID'], $_GET['key'], $_GET['sortby'], $_GET['asc']);
} else {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);

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
                if ($colRul['columnname'] == 'AssignedTo' || $colRul['columnname'] == 'assignTo' || $colRul['columnname'] == 'assignedTo') {
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
        $arryQuote = $objQuote->CustomQuote($colValue, $colRule);
    }
}



/* * ******************************************** */








$num = $objQuote->numRows();

$pagerLink = $objPager->getPager($arryQuote, $RecordsPerPage, $_GET['curP']);
(count($arryQuote) > 0) ? ($arryQuote = $objPager->getPageRecords()) : ("");



require_once("../includes/footer.php");
?>
