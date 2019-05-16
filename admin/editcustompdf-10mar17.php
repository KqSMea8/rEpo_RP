<?php

if ($_GET['pop'] == 1)
    $HideNavigation = 1;$SetFullPage = 1;
/* * *********************************************** */
$ModuleDepName = $_GET['ModuleDepName'];

if ($ModuleDepName == 'Sales') {
    $ThisPageName = 'viewSalesQuoteOrder.php';
} elseif ($ModuleDepName == 'Purchase') {
    $ThisPageName = 'viewPO.php';
} elseif ($ModuleDepName == 'SalesInvoice') {
    $ThisPageName = 'viewInvoice.php';
} elseif ($ModuleDepName == 'PurchaseInvoice') {
    //$ThisPageName = 'viewVendorInvoiceEntry.php';
 $ThisPageName = 'viewPoCreditNote.php';
    
} elseif ($ModuleDepName == 'SalesRMA') {

    $ThisPageName = 'viewRma.php';
} elseif ($ModuleDepName == 'PurchaseRMA') {

    $ThisPageName = 'viewRma.php';
} elseif ($ModuleDepName == 'SalesCreditMemo') {
//die('dd');
    $ThisPageName = 'viewCreditNote.php';
} elseif ($ModuleDepName == 'PurchaseCreditMemo') {
//die('dd');
    $ThisPageName = 'viewPoCreditNote.php';
}
elseif ($ModuleDepName == 'WhouseCustomerRMA') {
//die('dd');
    $ThisPageName = 'viewSalesReturn.php';
}
elseif ($ModuleDepName == 'WhouseVendorRMA') {
//die('dd');
    $ThisPageName = 'viewPoRma.php';
}
elseif ($ModuleDepName == 'WhousePOReceipt') {
//die('dd');
    $ThisPageName = 'viewPoReceipt.php';
}
$Config['ModuleDepName'] = $ModuleDepName;
//viewRma.php
//echo $ThisPageName;die;
/* * *********************************************** */
$Prefix = "../";
include_once("includes/header.php");
require_once($Prefix . "classes/employee.class.php");//feb-28-2k17
$objEmp=new employee();//feb-28-2k17

$module = $_GET['module'];

$PdfUrl = "pdfCommonhtml.php";
if ($ModuleDepName == 'Sales') {
    //die('tt');

    $ModuleName = "Sale " . $_GET['module'];
    //$PdfUrl="sales/pdfSOhtml.php";
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";

    $RedirectURL = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $EditUrl = "editSalesQuoteOrder.php?edit=" . $_GET["view"] . "&module=" . $module . "&curP=" . $_GET["curP"];
    $DownloadUrl = "pdfSO.php?o=" . $_GET["view"] . "&module=" . $module;
    $editsalespdf = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view" . $_GET["view"];
    $AddredirectURL = "sales/vSalesQuoteOrder.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $convertUrl = "sales/vSalesQuoteOrder.php?module=" . $module . "&curP=" . $_GET["curP"] . "&view=" . $_GET["view"] . "&convert=1";
    //$PdfUrl="pdfCommonhtml.php?o";
} else if ($ModuleDepName == 'Purchase') {
    $ModuleName = "Purchase " . $_GET['module'];
    //$PdfUrl="purchasing/pdfPOhtml.php";
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";



    $RedirectURL = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $AddredirectURL = "purchasing/vPO.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $convertUrl = "purchasing/vPO.php?module=" . $module . "&curP=" . $_GET["curP"] . "&view=" . $_GET["view"] . "&convert=1";
    //$PdfUrl="pdfCommonhtml.php?o";
} else if ($ModuleDepName == 'SalesInvoice') {
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "finance/vInvoice.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
    //$PdfUrl="pdfCommonhtml.php?IN";
} else if ($ModuleDepName == 'PurchaseInvoice') {
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "finance/vPoInvoice.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&po=" . $_GET["po"] . "&IE=" . $_GET["IE"];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
} else if ($ModuleDepName == 'SalesRMA') {

    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "sales/vRma.php?view=" . $_GET['view'] . "&curP=" . $_GET['curP'] . "&rtn=" . $_GET['rtn'] . "&Module=" . $_GET['Module'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
} else if ($ModuleDepName == 'PurchaseRMA') {

    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "purchasing/vRma.php?view=" . $_GET['view'] . "&curP=" . $_GET['curP'] . "&po=" . $_GET['po'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
} else if ($ModuleDepName == 'SalesCreditMemo') {

    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "finance/vCreditNote.php?curP=" . $_GET['curP'] . "&view=" . $_GET['view'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "CreditMemo";
} else if ($ModuleDepName == 'PurchaseCreditMemo') {

    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "finance/vPoCreditNote.php?curP=" . $_GET['curP'] . "&view=" . $_GET['view'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "CreditMemo";
}

elseif ($ModuleDepName == 'SalesCashReceipt') {
    //
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "finance/receiveInvoiceHistory.php?curP=" . $_GET['curP'] . "&edit=".$_GET["view"]."&InvoiceID=".$_GET["InvoiceID"]."&IE=".$_GET["IE"];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&IE=".$_GET["IE"];
    $ModuleName = "CashReceipt";
}

elseif ($ModuleDepName == 'WhouseVendorRMA') {
    //
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "warehouse/vPoRma.php?view=".$_GET['view']."&curP=".$_GET['curP']."&rcpt=".$_GET['rcpt'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&IE=".$_GET["IE"];
    $ModuleName = "VendorRMA";
}

elseif ($ModuleDepName == 'WhousePOReceipt') {
    //
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "warehouse/vPoReceipt.php?view=".$_GET['view']."&curP=".$_GET['curP']."&po=".$_GET['po'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&po=".$_GET['po'];
    $ModuleName = "VendorRMA";
}

elseif ($ModuleDepName == 'WhouseCustomerRMA') {
    //
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "warehouse/vSalesReturn.php?view=".$_GET['view']."&curP=".$_GET['curP']."&rcpt=".$_GET['rcpt'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&po=".$_GET['po'];
    $ModuleName = "VendorRMA";
}
/* * code by sachin 17-11* */
//echo '<pre>'; print_r($arryCompany);die;
if (!empty($_GET['view']) && !empty($_GET['tempid'])) {
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName . $_GET['module'];
    $_GET['ModuleId'] = $_GET['view'];
    $_GET['id'] = $_GET['tempid'];
    $_GET['listview']='1';
    /****feb-28-2K17****/
    $GetPFdTempalteVal = $objConfig->GetSalesPdfTemplate($_GET);
    //PR($GetPFdTempalteVal);
    if(trim($GetPFdTempalteVal[0]['UserType'])=='admin'){
        
        $createdBy='Admin';
    }
    else{

        $GetEmpDetails=$objEmp->GetEmployee($GetPFdTempalteVal[0]['AdminID'],'');
        //PR($GetEmpDetails);
        $createdBy=$GetEmpDetails[0]['UserName'];
    }
     /****feb-28-2K17****/
    
    //$ttt=$objEmp->GetEmployee($GetEmployeeBrief[0]['AdminID'],'');
    
    //PR($GetEmpDetails);die;
    //echo '<pre>'; print_r($GetPFdTempalteVal); die;
}

if ($GetPFdTempalteVal[0]['id'] > 0) {
    if (($_POST['Update'] == 'Update') && !empty($_GET['view'])) {
        
        $_POST['ModuleName'] = $ModuleDepName;
        //echo '<pre>'; print_r($_POST);die;
        if($_POST['Deftformult']==1){
        
        //$_POST['defaultFor']=$defltmultVal;
        $_POST['createdBy']=$GetPFdTempalteVal[0]['AdminID'];
        }
        //PR($_POST);die;
        $objConfig->UpdateSalesPdfTempalte($_POST);
        $_SESSION['mess_Sale'] = PDF_TEMPLATE_UPDATED;
        header("Location:" . $RedirectURL);
        exit;
    }
} else {

    if (($_POST['Save'] == 'Save') && !empty($_GET['view'])) {
        //echo '<pre>'; print_r($_POST);die('add');
        if (!empty($_POST['TemplateName'])) {
            $_POST['ModuleName'] = $ModuleDepName;
            $objConfig->SaveSalesPdfTempalte($_POST);
            $_SESSION['mess_Sale'] = PDF_TEMPLATE_ADDED;
            header("Location:" . $AddredirectURL);
            exit;
        } else {

            $_SESSION['mess_dynamicpdf'] = "Please Enter Template Name";
            header("Location:" . $RedirectURL);
            exit;
        }
    }
}

/* * code by sachin 17-11* */
//code for delete tempname
if (!empty($_GET['Deltempid']) && !empty($_GET['view'])) {
    $DeleteArray = array();
    $DeleteArray = array('ModuleName' => $ModuleDepName, 'Module' => $ModuleDepName . $module, 'ModuleId' => $_GET['view'], 'id' => $_GET['Deltempid']);
    $objConfig->DeleteTemplateName($DeleteArray);
    $_SESSION['mess_Sale'] = "PDF Template has been removed successfully.";
    header("Location:" . $AddredirectURL);
    exit;
}

/* * code by sachin 16-11* */
$col = '12';
$FieldFontSize = 'Field Font Size :';
$FieldAlign = 'Field Align :';
$TabFontSize = 'Heading Font Size :';
$TabAlign = 'Heading Align :';
$Tab = 'Heading :';
$ItemHeading = 'Item Heading :';
$ItemFontSize = 'Item Font Size :';
//$FieldSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,22);
$FieldSizeArry = array(9, 10, 11, 12, 13, 14);
//$HeadingSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,22,24,25,26);
//$HeadingSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,21,22);
$HeadingSizeArry = array(14, 15, 16, 17, 18, 19, 20, 21, 22);
$lineItemHeadFontSize = array(8, 9, 10, 11, 12);
$borderarry = array('Yes' => '1', 'No' => '0');
$AlignArry = array('Left', 'Right');
//$AlignArryTitle=array('left','right','center');
$AlignArryTitle = array('Left' => 'left', 'Right' => 'right');
$Color = array('Red' => '#ff0000', 'Blue' => '#004269', 'Purple' => '#800080', 'Black' => '#000000', 'white' => '#fff', 'Green' => '#266A2E', 'Grey' => '#d3d3d3', 'Pink' => '#C71585', 'Yellow' => '#FFFF00');
$logosize = array(100, 150, 200);
$HeadingArry = array('Bold' => 'bold', 'Normal' => 'normal');
$showHideArray=array('Show'=>'show','Hide'=>'hide');
$PublicPvtArry=array('Public'=>'0','Private'=>'1');//feb-27-17
$FieldFontSizeName = 'FieldFontSize';
$FieldAlignName = 'FieldAlign';
$HeadingFontSizeName = 'HeadingFontSize';
$HeadingAlignName = 'HeadingAlign';
$HeadingName = 'Heading';
$ItemHeadingName = 'Heading';
$ItemFontSizeName = 'FontSize';
/* * code by sachin 16-11* */
require_once("includes/footer.php");
?>


