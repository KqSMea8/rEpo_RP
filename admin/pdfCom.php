<?php

if (empty($pdfbycmd)) {
    require_once("includes/settings.php");
    $Prefix1 = '';
//echo 'test';die;
}
//echo $Prefix1."includes/htmltopdf/html2pdf.class.php";exit;

require($Prefix1."includes/htmltopdf/html2pdf.class.php");
//die('ttt');
/* * *Module PDF data ** */
$ModDepName = $_GET['ModuleDepName'];
if ($ModDepName == 'Sales') {

    require_once("sales/pdfSOList.php");
    $savefileUrl = "sales/upload/pdf/";
} else if ($ModDepName == 'Purchase') {
    require_once("purchasing/pdfPOList.php");
    $savefileUrl = "purchasing/upload/pdf/";
} elseif ($ModDepName == 'SalesInvoice') {
    require($Prefix1."finance/pdfInvoiceList.php");
} elseif ($ModDepName == 'PurchaseInvoice') {
    require_once("finance/pdfPoInvoiceList.php");
} else if ($ModDepName == 'SalesRMA') {
    //echo $ModDepName;die('hfhfh');
    require_once("sales/pdfRmaList.php");
} else if ($ModDepName == 'PurchaseRMA') {
    //echo $ModDepName;die('hfhfh');
    require_once("purchasing/pdfRmaList.php");
} else if ($ModDepName == 'SalesCreditMemo') {
    require_once("finance/pdfCreditNoteList.php");
    $savefileUrl = "finance/upload/pdf/";
} else if ($ModDepName == 'PurchaseCreditMemo') {
    require_once("finance/pdfPoCreditNoteList.php");
    $savefileUrl = "finance/upload/pdf/";
} else if ($ModDepName == 'SalesCashReceipt') {
    require_once("finance/pdf_case_reciept_List.php");
    $savefileUrl = "finance/upload/pdf/";
} else if ($ModDepName == 'WhouseBatchMgt') {
    //die('ddd');
    require_once("warehouse/pdfShipmentList.php");
    //$savefileUrl = "";
} else if ($ModDepName == 'WhouseVendorRMA') {
    //die('ddd');
    require_once("warehouse/pdfPoRmaList.php");
    //$savefileUrl = "";
}

/* * *Module PDF data ** pdf_case_reciept_List */
$SerialHead = '';
$PaymentHistoryHead = '';
$PaymentHistoryHeadName = '';
/* * **start code for dynamic pdf** */

require($Prefix1 . "includes/pdf_common_dynamicdata.php");
require($Prefix1 . "includes/pdf_common_dynamicItem.php");
require($Prefix1 . "includes/pdf_common_dynamichtmldata.php");
require($Prefix1 . "comman_pdf_header.php");

/* * **end code for dynamic pdf*** */
if (!empty($pdfbycmd)) {
ob_start();
}

$html = '
 <style>
table#mainTable{
 	width:635px;
 	margin-left:35px;
 	margin-top:30px;
        font-family:Arial, Helvetica, sans-serif; 
        color:#000000; 
        font-size:12px;
        font-weight:500;
        img border:none;
 }
 </style>
 <table id="mainTable">
 	<tr>';
if ($CompanyAlign == 'right' && $informationAlign == 'left') {
    $html.=$TitleShow;
} else {
    $html.=$companyInfoShow;
}
if ($CompanyAlign == 'right' && $informationAlign == 'left') {
    $html.=$companyInfoShow;
} else {
    $html.=$TitleShow;
}
$html.='</tr>
        <tr>';
$html.='<td style="vertical-align:top;">';
if ($CompanyAlign == 'right' && $informationAlign == 'left') {
    $html.=$informationdata;
} else {
    $html.=$Cmpanyimg;
}
$html.='</td>';

$html.='<td style="vertical-align:top;">';
if ($CompanyAlign == 'right' && $informationAlign == 'left') {
    $html.=$Cmpanyimg;
} else {
    $html.=$informationdata;
}
$html.='</td>
 </tr>
 <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; font-weight:bold; ">';
$html.=$PaymentHistoryHeadName;
$html.='</td>
 </tr>
 <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$PaymentHistoryHead;
$html.='</td>
 </tr>
 <tr>
 	<td style="width:210px; margin-top:30px; padding:0px; border:1px solid #e3e3e3;">';
if ($BillingAlign == 'right' && $ShippingAlign == 'left') {
    $html.=$AddressB;
} else {
    $html.=$AddressA;
}
$html.='</td>
 	<td style="width:320px; height:auto; margin-top:15px; padding:0px; border:1px solid #e3e3e3;">';
if ($BillingAlign == 'right' && $ShippingAlign == 'left') {
    $html.=$AddressA;
} else {
    $html.=$AddressB;
}
$html.='</td>
 </tr>
 
 
  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$LineItem;
$html.='</td>
 </tr>
 <tr>
<td colspan=2>';
$html.='<table style="width:100%">
                            <tr>

                                <td style="float:left; width:366px; border:1px solid #e3e3e3;" >';
$html.=$specialNotes;

$html.='</td>

                                <td style="float:right; width:47%;  vertical-align: text-top;" align="right">';

$html.=$TotalDataShow;

$html.='</td>
                            </tr>	
                        </table>';
$html.='</td>
 </tr>
 
  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$SerialHead;
$html.='</td>
 </tr>
 
 <tr>
 <td colspan=2 style="width:100%; margin-top:10px; text-align:center">
 	<p style="text-align:center; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">' . $FooterContent . '</p>
 </td>
 </tr>
 

 
 
 <tr>
 	<td colspan=2 >
 		<table style="width:100%" >
 			<tr>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Name</td>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Signature</td>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Date</td>
 				
 			</tr>
 		</table>
 	</td>
 </tr>
 
 
  <tr>
 	<td colspan=2 style="width:100%; margin:10px 0;text-align:center;">
 		<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table>';

echo $html;

//ini_set("display_errors", "1");

// convert in PDF
$content = ob_get_contents();


try { //echo $content;
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    /*     * code for Dynamic pdf name download link * */
    // $nn=date('F-Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
    /*     * code for Dynamic pdf name download link * */
    //$nn=$arrySale[0][$ModuleID];
ob_end_clean();
    /*     * code for PDf Priview * */
    if ($_GET['editpdftemp'] == '1') {
        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
        //ob_end_clean();
//            $html2pdf->stream('Sales-'.$nn.'.pdf');
    }


    /*     * code for download link * */
    else if ($_GET['attachfile'] == '1') {
        //die('yy');
        ///echo $ModulePDFID;
        //chmod($savefileUrl, 0777);
        //error_reporting(E_ALL);
        $html2pdf->Output($savefileUrl . $ModDepName . '-' . $ModulePDFID . '.pdf', 'F');    // Save file to dir
        
        //ob_end_clean();
    }
    else {
        //ob_end_clean();
        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    
    }
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

$content = ob_get_clean();
ob_flush();
flush();
?>

