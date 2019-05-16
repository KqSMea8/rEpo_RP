<?php

include_once("../includes/header.php");
require_once($Prefix . "classes/finance.class.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix."classes/finance.account.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/finance.transaction.class.php");
require_once($Prefix."classes/finance.journal.class.php");
require_once($Prefix . "classes/item.class.php");

include_once("includes/FieldArray.php");
$objFilter = new filter();
(empty($_GET['module'])) ? ($_GET['module'] = "Note") : ("");
$ModuleName = "Sales";
$objSale = new sale();
$objTransaction = new transaction();
$objCommon = new common();
$objBankAccount = new BankAccount();
$ModuleName = "Credit Memo";
$ModuleDepName = "SalesCreditMemo";
$SendUrl = "sendCreditNote.php?module=" . $ModuleName . "&curP=" . $_GET['curP'];
$AddUrl = "editCreditNote.php";
$EditUrl = "editCreditNote.php?curP=" . $_GET['curP'];
$ViewUrl = "vCreditNote.php?curP=" . $_GET['curP'];
$RedirectURL = "viewCreditNote.php?curP=" . $_GET['curP'];
/* * *************************** */

$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
$InventoryAR = $objCommon->getSettingVariable('InventoryAR');
$FreightAR = $objCommon->getSettingVariable('FreightAR');
$SalesReturn = $objCommon->getSettingVariable('ArReturn');
$CostOfGoods = $objCommon->getSettingVariable('CostOfGoods');
$SalesTaxAccount = $objCommon->getSettingVariable('SalesTaxAccount');
$ArRestocking  = $objCommon->getSettingVariable('ArRestocking');

$ErrorGlAccount = '';
//if ($Config['TrackInventory'] == 1) {
    if (empty($AccountReceivable) || empty($InventoryAR) || empty($FreightAR) || empty($SalesReturn) || empty($CostOfGoods) || empty($SalesTaxAccount) || empty($ArRestocking)) {
        $ErrorGlAccount = SELECT_GL_AR_ALL;
    }
/*} else {
    if (empty($AccountReceivable) || empty($SalesReturn)) {
        $ErrorGlAccount = SELECT_GL_AR_ALL;
    }
}*/


if ($AccountReceivable > 0 && $AccountReceivable == $SalesReturn) {
    $ErrorGlAccount = SAME_GL_SELECTED_AR;
}




/*******POS Cash Receipt and Journal************************
if(!empty($_GET['PK']=='9678658658658568')) {
	$arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];
        $arryPostData['AccountReceivable'] = $AccountReceivable;
        $arryPostData['InventoryAR'] = $InventoryAR;
        $arryPostData['FreightAR'] = $FreightAR;
        $arryPostData['SalesReturn'] = $SalesReturn;
        $arryPostData['CostOfGoods'] = $CostOfGoods;
        $arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
	$objTransaction->ARCreditMemoPostToGLDummy('', $arryPostData);
	echo 'done';  
	exit;
}
/********END CODE***********************************/





/* * *****CODE FOR POST TO GL*********************** */
if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {
    CleanPost();
    if (!empty($ErrorGlAccount)) {
        $_SESSION['mess_credit'] = $ErrorGlAccount;
    } else {
	if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
		$arryPostData['PosFlag'] = 1;		 
	}

        $arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];
        $arryPostData['AccountReceivable'] = $AccountReceivable;
        $arryPostData['InventoryAR'] = $InventoryAR;
        $arryPostData['FreightAR'] = $FreightAR;
        $arryPostData['SalesReturn'] = $SalesReturn;
        $arryPostData['CostOfGoods'] = $CostOfGoods;
        $arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
	$arryPostData['ArRestocking'] = $ArRestocking;

        foreach ($_POST['posttogl'] as $OrderID) {
            $objTransaction->ARCreditMemoPostToGL($OrderID, $arryPostData);
        }
        $_SESSION['mess_credit'] = CREDIT_MEMO_POSTED_TO_GL_AACOUNT;
    }
    header("Location:" . $RedirectURL);
    exit;
}
/* * ******END CODE********************************** */












/* * *******************Custom Filter *********** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:" . $ThisPageName);
    exit;
}


/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

 
if(!empty($arryDefult[0]['setdefault']) && $_GET['customview'] == "") {

    $_GET['customview'] = $arryDefult[0]['cvid'];
}elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
}else {

    $_GET["customview"] = 'All';
}



if (!empty($_GET["customview"])) {
    #$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);


    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);

	 
    if (!empty($arryColVal)) {
	$colValue=$colRule='';
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

	$colRule='';
        foreach ($arryQuery as $colRul) {

            if ($colRul['columnname'] == 'Status') {

                if (strtolower($colRul['value']) == strtolower(ST_CLR_CREDIT)) {

                    $colRul['value'] = 'Completed';
                } else if (strtolower($colRul['value']) == strtolower(ST_TAX_APP_HOLD)) {
                    $colRul['value'] = 'Open';
                    if ($colRul['comparator'] == 'e') {
                        $colRule .= " and o.tax_auths = 'Yes'  ";
                    } else {

                        $colRule .= " and o.tax_auths != 'Yes'  ";
                    }
                } else if (strtolower($colRul['value']) == strtolower(ST_CREDIT_HOLD)) {
                    $colRul['value'] = 'Open';

                    if ($colRul['comparator'] == 'n') {
                        $colRule .= " and o.tax_auths != 'No'";
                    } else {

                        $colRule .= " and o.tax_auths  = 'No'";
                    }
                }
            } elseif ($colRul['columnname'] == 'EntryType') {

                $colRul['value'] = str_replace(" ", "_", strtolower($colRul['value']));
            }

            if ($colRul['comparator'] == 'e') {

                $comparator = '=';
                $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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

                $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");

        $_GET['rule'] = $colRule;
        // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/* * **************************End Custom Filter*************************************** */


/* * ********************** */
$Config['RecordsPerPage'] = $RecordsPerPage;
$arrySale = $objSale->ListCreditNote($_GET);
/* * *****Count Records********* */
$Config['GetNumRecords'] = 1;
$arryCount = $objSale->ListCreditNote($_GET);
$num = $arryCount[0]['NumCount'];

$pagerLink = $objPager->getPaging($num, $RecordsPerPage, $_GET['curP']);

 


require_once("../includes/footer.php");
?>


