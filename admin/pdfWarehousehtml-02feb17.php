<?php

require_once("includes/settings.php");
require_once("../classes/warehouse.shipment.class.php");
require_once("../classes/sales.quote.order.class.php");
require("includes/htmltopdf/html2pdf.class.php");
$objSale = new sale();
$objShipment = new shipment();
/* * *Module PDF data ** */
//echo $Prefix.die('shibaat');
$RedirectURL = "warehouse/viewbatchmgmt.php?curP=".$_GET['curP'];
if(!empty($_GET['batchId'])){
$batchidarray = $objShipment->GetBatchShippment($_GET['batchId']);
}
else{
    header("Location:".$RedirectURL);
    exit;
}
//echo '<pre>'; print_r($batchidarray);die;
$ModDepName = $_GET['ModuleDepName'];
if (!empty($batchidarray)) {
    //$i=0;
    foreach ($batchidarray as $values) {

        //$ModDepNameBoth = 'Purchase';
        //$_GET['module'] = 'Order';
       $_GET['o'] = $values['OrderID'];
        //echo $values;die('fff');
        require("finance/pdfInvoiceList.php");
        /*         * html generate code start* */
        /*         * *Module PDF data ** pdf_case_reciept_List */
        $SerialHead = '';
        $PaymentHistoryHead = '';
        $PaymentHistoryHeadName = '';
        /*         * **start code for dynamic pdf** */

        require("includes/pdf_common_dynamicdata.php");
        require("includes/pdf_warehouse_dynamicItem.php");
        require("includes/pdf_common_dynamichtmldata.php");
        require("comman_pdf_header.php");

        /*         * **end code for dynamic pdf*** */
        /*         * **end code for dynamic pdf*** */
//ob_start();
        //<div style="page-break-after: always;">
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
 <div style="page-break-after: always;">
 <div><table id="mainTable">';
$html.='<tr><td style="width:100%;text-align:center;font-weight: bold; font-size: 17px;" colspan="2">'.$Title.'</td></tr>
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
<td colspan=2  style="width:100%;margin-top:6px;">';
$html.=$PayDataShow;
$html.='</td>
</tr>

  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px;">';
$html.=$LineItem;
$html.='</td>
 </tr>
 </table>
 </div>
 <div>
 <table id="mainTable">
 <tr>
<td>';
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
 </tr>';
 
 /* <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$SerialHead;
$html.='</td>
 </tr>*/
 
 
 $html.='<tr>
 <td style="width:100%; margin-top:10px; text-align:center">
 	<p style="text-align:center; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">' . $FooterContent . '</p>
 </td>
 </tr>';
 

 
 
/* <tr>
 	<td colspan=2 >
 		<table style="width:100%" >
 			<tr>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Name</td>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Signature</td>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Date</td>
 				
 			</tr>
 		</table>
 	</td>
 </tr>*/
 
 
  $html.='<tr>
 	<td style="width:100%; margin:10px 0;text-align:center;">
 		<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table></div></div>';
 //
    $html1.=$html;
        //echo $html;die;
    }
}
else {
    header("Location:".$RedirectURL);
    exit;
}
//echo $html1;
//die('toop');
/* * *Module PDF data ** */
//echo $html;
$content = ob_get_contents();
//die('iii');
//$html='<h1>.testtstststtsts.</h1>';
echo $html1;
$content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
// convert in PDF
//require_once("includes/htmltopdf/html2pdf.class.php");

try { //echo $content;
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    /*     * code for Dynamic pdf name download link * */
    // $nn=date('F-Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
    /*     * code for Dynamic pdf name download link * */
    //$nn=$arrySale[0][$ModuleID];

    /*     * code for PDf Priview * */
//    if ($_GET['editpdftemp'] == '1') {
//        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
////            $html2pdf->stream('Sales-'.$nn.'.pdf');
//    }
//
//
//    /*     * code for download link * */
//    if ($_GET['attachfile'] == '1') {
//        chmod($savefileUrl, 0777);
//        $html2pdf->Output($savefileUrl . $ModDepName . '-' . $ModulePDFID . '.pdf', 'F');    // Save file to dir
//    }
//    if (($_GET['print'] == 'print') || ($ModDepName == 'printboth')) {
//        //echo $html; 
//        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
//        exit;
//    }
    //$html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
    //$html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf'); 
$html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

