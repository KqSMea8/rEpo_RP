<?php 
	include_once("../includes/header.php");
	//require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix . "classes/filter.class.php");
        $objFilter = new filter();
        (empty($_GET['module'])) ? ($_GET['module'] = "Contact") : ("");
	$ModuleName = "Contact";
	//$objContact=new contact();
	$objCustomer=new Customer(); 

/* * *******************Custom Filter *********** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:" . $ThisPageName);
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



if (!empty($_GET["customview"])) {
    #$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);


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

                $comparator = '=';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }


            if ($colRul['comparator'] == 'l') {
                $comparator = '<';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
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
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                }
            }
        }
        $colRule = rtrim($colRule, "  and");

        $_GET['rule'] = $colRule;
        // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/* * **************************End Custom Filter*************************************** */

	$arryContact=$objCustomer->ListCrmContact($_GET);
	$num=$objCustomer->numRows();

	$pagerLink=$objPager->getPager($arryContact,$RecordsPerPage,$_GET['curP']);
	(count($arryContact)>0)?($arryContact=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


