<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/group.class.php");
$ModuleName = "Opportunity";
$objLead = new lead();
$objCommon = new common();
$objFilter = new filter();
$objGroup = new group();


/* * ******************************************** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewOpportunity.php?module=Opportunity");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "" && $_GET['key']=='') {
    $Config['DefaultActive'] = 1;	
    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0 && $_GET['key']=='') {
    $_GET['customview'] = $_GET['customview'];
} else {
    $_GET["customview"] = 'All';
}



if ($_GET["customview"] == 'All') {
    $arryOpportunity = $objLead->ListOpportunity('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
} else {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);

   if ($arryDefult[0]['setdefault'] == 1) {
	$Config['DefaultActive'] = 1;
   }




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
                    $colRule .= $colRul['column_condition'] . " p. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                }elseif ($colRul['columnname'] == 'Status') {
			
                    $comparator = '=';
                   if( ucfirst($colRul['value']) == "Active"){ $colv = 1; }else{ $colv = 0; unset($Config['DefaultActive']);}
                   $colRule .= $colRul['column_condition'] . " p. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colv) . "'   ";
                   
                    //$colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colv) . "%'   ";
                }  else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " p. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                
                 
                
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " p. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                }elseif ($colRul['columnname'] == 'Status') {
                    $comparator = '!=';
                   if( ucfirst($colRul['value']) == "Active"){ $colv = 1; }else{ $colv = 0;}
                   $colRule .= $colRul['column_condition'] . "  p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colv) . "'   ";
                   
                    //$colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colv) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " p. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . "  p. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . "  p. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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

                $colRule .= $colRul['column_condition'] . "  p. " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        #echo $colRule;
        $arryOpportunity = $objLead->CustomOpprotunity($colValue, $colRule);
    }
}




/* * ******************************************* */



$num = $objLead->numRows();

$pagerLink = $objPager->getPager($arryOpportunity, $RecordsPerPage, $_GET['curP']);
(count($arryOpportunity) > 0) ? ($arryOpportunity = $objPager->getPageRecords()) : ("");
$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');


require_once("../includes/footer.php");
?>


