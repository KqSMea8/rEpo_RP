<?php

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix."classes/finance.report.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("includes/FieldArray.php");
$ModuleName = "Sales";
$objSale = new sale();
$objFilter = new filter();
$objBankAccount = new BankAccount();
$objTransaction=new transaction();
$objReport = new report();
(empty($_GET['module'])) ? ($_GET['module'] = "POPayments") : ("");
$ModuleName = "Sales Invoice";

$ViewUrl = "viewPurchasePayments.php";
$ViewUrl = "vInvoice.php?curP=" . $_GET['curP'];
$RedirectURL = "viewPurchasePayments.php?curP=". $_GET['curP'];
$ModuleIDTitle = "Invoice/Credit Memo #";
$ModuleID = "InvoiceID";
$module="Vendor Payment";
$SendUrl = "sendVendorPayments.php?curP=".$_GET['curP'];
$SendUrlPay = "sendPayVendorPayments.php?curP=".$_GET['curP'];
/* * ********************** */



if(!empty($_GET['del_payment'])) {
	$_SESSION['mess_Invoice'] = PAYMENT_REMOVED;
	$objReport->DeleteTransaction($_GET['del_payment']);
	$objReport->deleteVendorPayment($_GET['del_payment']);
	header("location:" . $RedirectURL);
	exit;
}



/* * *******CODE FOR POST TO GL************************************* */

if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {

	   CleanPost();
    foreach ($_POST['posttogl'] as $PaymentID) {

        $objBankAccount->commonPostToGL($PaymentID,'','',$_POST['PostToGLDate']);
    }

    $_SESSION['mess_Invoice'] = AP_POSTED_TO_GL_AACOUNT;
    header("Location:" . $RedirectURL);
    exit;
}

/* * *******END CODE*********************************** */
/* * *******************Custom Filter *********** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:" . $ThisPageName);
    exit;
}


/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "") {
    $Config['DefaultActive'] = 1;
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



            if ($colRul['columnname'] == 'EntryType') {

                $colRul['value'] = str_replace(" ", "_", strtolower($colRul['value']));
            }

            if ($colRul['comparator'] == 'e') {


                $comparator = '=';
                if ($colRul['columnname'] == 'InvoicePaid') {
                    if (strtolower($colRul['value']) == "paid") {
                        $colv = 1;
                    } else if (strtolower($colRul['value']) == "partially paid" || strtolower($colRul['value']) == 'part paid') {
                        $colv = 2;
                        unset($Config['DefaultActive']);
                    } else {
                        $colv = 0;
                        unset($Config['DefaultActive']);
                    }
                    $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colv) . "'   ";
                } else if ($colRul['columnname'] == 'SuppCompany') {

                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                 if ($colRul['columnname'] == 'InvoicePaid') {
                    if (strtolower($colRul['value']) == "paid") {
                        $colv = 1;
                    } else if (strtolower($colRul['value']) == "partially paid" || strtolower($colRul['value']) == 'part paid') {
                        $colv = 2;
                        unset($Config['DefaultActive']);
                    } else {
                        $colv = 0;
                        unset($Config['DefaultActive']);
                    }
                    $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colv) . "'   ";
                } else if ($colRul['columnname'] == 'SuppCompany') {

                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';
                if ($colRul['columnname'] == 'InvoicePaid' || $colRul['columnname'] == 'CustomerName') {
                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                #$colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                if ($colRul['columnname'] == 'InvoicePaid' || $colRul['columnname'] == 'CustomerName') {
                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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


                if ($colRul['columnname'] == 'InvoicePaid' || $colRul['columnname'] == 'CustomerName' || $colRul['columnname'] == 'SuppCompany') {
                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                } else {
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                }

                # $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");

        $_GET['rule'] = $colRule;
        // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/* * **************************End Custom Filter*************************************** */


	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPaymentInvoice = $objBankAccount->ListPaidPaymentInvoice($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objBankAccount->ListPaidPaymentInvoice($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);



require_once("../includes/footer.php");
?>


