<?php

include_once("../includes/header.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix."classes/finance.report.class.php");
require_once($Prefix . "classes/supplier.class.php");
require_once($Prefix . "classes/finance.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("includes/FieldArray.php");
(empty($_GET['module'])) ? ($_GET['module'] = "Receipt") : ("");

$objFilter = new filter();

$objSale = new sale();
$objBankAccount = new BankAccount();
$objReport = new report();
$objSupplier = new supplier();
$objCommon = new common();
$objTransaction=new transaction();
$ModuleName = "Sales Invoice";
$module="Cash Receipt";
$SendUrl = "sendcashreceipt.php?curP=".$_GET['curP'];

$ViewUrl = "viewSalesPayments.php";
$AddUrl = "editInvoice.php";
$EditUrl = "editInvoice.php?curP=" . $_GET['curP'];
$ViewUrl = "vInvoice.php?curP=" . $_GET['curP'];
$RedirectURL = "viewSalesPayments.php?curP=" . $_GET['curP'];
$ModuleIDTitle = "Invoice Number";
$ModuleID = "InvoiceID";
/* * ********************** */





if(!empty($_GET['del_payment'])) {
	$_SESSION['mess_Invoice'] = PAYMENT_REMOVED;
	$objReport->DeleteTransaction($_GET['del_payment']);
	$objReport->deleteCustomerPayment($_GET['del_payment']);
	header("location:" . $RedirectURL);
	exit;
}





//Get Spiff settings data

$arrySpiffSettings = $objCommon->getSpiffSettings($spiffID = 1);

/* * *******CODE FOR POST TO GL************************************* */

if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) 
{
	   CleanPost();

    foreach ($_POST['posttogl'] as $posttoglData)
     {

        $posttoglDataExplode = explode("#", $posttoglData);

        $PaymentID = $posttoglDataExplode[0];
        $SaleID = $posttoglDataExplode[1];
        $InvoiceEntry = $posttoglDataExplode[2];
        
        $arrySpiff = $objBankAccount->getSpiffData($SaleID);

        if ($arrySpiff[0]['Spiff'] == "Yes" && $arrySpiff[0]['SpiffAmount'] > 0)
         {

            $orderAmount = $objBankAccount->GetOrderTotalPaymentAmntForSale($SaleID);
          }

        $postGLOrderAmnt = $objBankAccount->commonPostToGL($PaymentID, $SaleID, $InvoiceEntry,$_POST['gldate']);

        //echo "=>".$orderAmount."==>".$postGLOrderAmnt;exit;


        if (intval($postGLOrderAmnt) >= intval($orderAmount) && intval($orderAmount) > 0 && $arrySpiff[0]['Spiff'] == "Yes") 
        {


            /*             * ********************GET VENDOR DATA****************************************************** */

            $spiffContact = $arrySpiff[0]['SpiffContact'];
            //echo "=>".$spiffContact;
            $ContactInfoStrip = str_replace("<br>", "", $spiffContact);
            $ContactInfoStrip = str_replace(",", "", $ContactInfoStrip);
            $ContactInfoStrip = str_replace("-", "", $ContactInfoStrip);
            $ExplodespiffContact = explode("|", $ContactInfoStrip);
            //echo '<pre>';print_r($ExplodespiffContact);

            $fullName = $ExplodespiffContact[0];
            $explodeFullName = explode(" ", $fullName);
            $FirstName = $explodeFullName[0];
            $LastName = $explodeFullName[1];

            $arrySupplier = array();
            $arryRgn = array();
            $arrySupplier['FirstName'] = trim($FirstName);
            $arrySupplier['LastName'] = trim($LastName);
            $arrySupplier['Address'] = trim($ExplodespiffContact[1]);
            $arrySupplier['City'] = trim($ExplodespiffContact[2]);
            $arrySupplier['State'] = trim($ExplodespiffContact[3]);
            $arrySupplier['OtherCity'] = trim($ExplodespiffContact[2]);
            $arrySupplier['OtherState'] = trim($ExplodespiffContact[3]);
            $arrySupplier['Country'] = trim($ExplodespiffContact[4]);
            $arrySupplier['ZipCode'] = trim($ExplodespiffContact[5]);
            $arrySupplier['Mobile'] = trim($ExplodespiffContact[7]);
            $arrySupplier['Landline'] = trim($ExplodespiffContact[9]);
            $arrySupplier['Fax'] = trim($ExplodespiffContact[11]);
            $arrySupplier['Email'] = trim($ExplodespiffContact[13]);
            $arrySupplier['Status'] = '1';
            $arrySupplier['Currency'] = $Config['Currency'];
            $arrySupplier['CustomerVendor'] = '1';

            $arryRgn['City'] = trim($ExplodespiffContact[2]);
            $arryRgn['State'] = trim($ExplodespiffContact[3]);
            $arryRgn['Country'] = trim($ExplodespiffContact[4]);

            /*             * ****************************************connect main database******************************** */
            $Config['DbName'] = $Config['DbMain'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();

            if (!empty($arrySupplier['Country']))
             {
                $arryCountry = $objRegion->GetCountryID($arrySupplier['Country']);
                $arrySupplier["country_id"] = $arryCountry[0]['country_id']; //set	
                if ($arrySupplier["country_id"] > 0 && !empty($arrySupplier["OtherState"])) {
                    $arryState = $objRegion->GetStateID($arrySupplier["OtherState"], $arrySupplier['country_id']);
                    $arrySupplier["main_state_id"] = $arryState[0]['state_id']; //set
                }
                if ($arrySupplier["country_id"] > 0 && !empty($arrySupplier["OtherCity"])) {
                    $arryCity = $objRegion->GetCityID($arrySupplier["OtherCity"], $arrySupplier["country_id"]);
                    $arrySupplier["main_city_id"] = $arryCity[0]['city_id']; //set
                }
            }


            /*             * *********************************connect company database****************************************** */

            //echo '<pre>';print_r($arrySupplier);exit;

            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();
            //Check vendor
            $SuppID = $objSupplier->isEmailExistsForCustomerVendor($arrySupplier['Email'], $fullName);

            if ($SuppID > 0) {
                //Update supplier contact address here
                $arrySupplier['SuppID'] = $SuppID;
                $objSupplier->updateSupplierContactAddress($arrySupplier);
                $arrySuppBrief = $objSupplier->GetSupplierBrief($SuppID);
            } else {
                $supplierID = $objSupplier->AddSupplier($arrySupplier);
                //$objSupplier->UpdateCountyStateCity($arryRgn,$supplierID);

                $arrySupplier['PrimaryContact'] = 1;
                $AddID = $objSupplier->addSupplierAddress($arrySupplier, $supplierID, 'contact');
                $objSupplier->UpdateAddCountryStateCity($arryRgn, $AddID);
                $arrySuppBrief = $objSupplier->GetSupplierBrief($supplierID);
            }

            /*             * ***********************************Add Invoice and payment information************************************ */

            $invoicePaymentData = array();

            $invoicePaymentData['TotalAmount'] = $arrySpiff[0]['SpiffAmount'];
            $invoicePaymentData['Amount'] = $arrySpiff[0]['SpiffAmount'];
            $invoicePaymentData['EntryType'] = 'one_time';
            $invoicePaymentData['PaidTo'] = $arrySuppBrief[0]['SuppCode'];
            $invoicePaymentData['GlEntryType'] = 'Single';
            $invoicePaymentData['ExpenseTypeID'] = $arrySpiffSettings[0]['GLAccountTo'];
            $invoicePaymentData['PaymentDate'] = $Config['TodayDate'];
            $invoicePaymentData['PaymentMethod'] = $arrySpiffSettings[0]['PaymentMethod'];
            $invoicePaymentData['BankAccount'] = $arrySpiffSettings[0]['GLAccountFrom'];
            $invoicePaymentData['InvoiceEntry'] = '3';

            $objBankAccount->addOtherExpense($invoicePaymentData);
        }
    }

    $_SESSION['mess_Invoice'] = AR_POSTED_TO_GL_AACOUNT;
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
                if ($colRul['columnname'] == 'InvoicePaid' || $colRul['columnname'] == 'CustomerName') {

                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } elseif ($colRul['columnname'] == 'InvoicePaid' || $colRul['columnname'] == 'CustomerName') {
                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " p." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') 
            {
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


                if ($colRul['columnname'] == 'InvoicePaid' || $colRul['columnname'] == 'CustomerName' ) {
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
$arrySale=$objBankAccount->ListReceivePaymentInvoice($_GET);
/*******Count Records**********/	
$Config['GetNumRecords'] = 1;
$arryCount=$objBankAccount->ListReceivePaymentInvoice($_GET);
$num=$arryCount[0]['NumCount'];	

$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);


$arryCustomerList=$objBankAccount->getCustomerList();

require_once("../includes/footer.php");
?>


