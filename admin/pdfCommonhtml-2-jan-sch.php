<?php

require_once("includes/settings.php");

/*
if(!empty($parameters['ModuleDepName']) && !empty($parameters['o'])){
	$_GET['ModuleDepName']=$parameters['ModuleDepName'];
	$_GET['o']=$parameters['o'];
	$_GET['module']=$parameters['module'];
	$_GET['attachfile']=$parameters['attachfile'];

	$prefix='/var/www/html/erp/';
	$Config['CronJob'] = '1';
   	require_once($prefix."includes/config.php");
    	require_once($prefix."includes/function.php");
	require_once($prefix."classes/dbClass.php");
	require_once($prefix."classes/region.class.php");
	require_once($prefix."classes/admin.class.php");	
	require_once($prefix."classes/configure.class.php");	
	$objConfig=new admin();

	$Config['DbName'] = 'erp_sakshay';
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();	
}*/




/* * *Module PDF data ** */
$ModDepName = $_GET['ModuleDepName'];
if ($ModDepName == 'Sales') {

    require_once("sales/pdfSOList.php");
    $savefileUrl = "sales/upload/pdf/";
} else if ($ModDepName == 'Purchase') {
    require_once("purchasing/pdfPOList.php");
    $savefileUrl = "purchasing/upload/pdf/";
} elseif ($ModDepName == 'SalesInvoice') {
    require_once("finance/pdfInvoiceList.php");
	$savefileUrl = "finance/upload/pdf/";
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
}

/* * *Module PDF data ** */
$SerialHead = '';
/* * **start code for dynamic pdf** */
//require_once("includes/pdf_common_dynamicdata.php");
//require_once("includes/pdf_common_dynamichtmldata.php");
require_once("includes/pdf_common_dynamicdata.php");
require_once("includes/pdf_common_dynamicItem.php");        //New added//
require_once("includes/pdf_common_dynamichtmldata.php");
require_once("comman_pdf_header.php");                  
/* * **end code for dynamic pdf*** */

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
    //$html.=$Cmpanyimg;
} else {
    $html.=$informationdata;
}
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
<td colspan=2  style="width:100%; margin-top:6px;margin-bottom:6px; ">';
$html.=$PayDataShow;
$html.='</td>
</tr>
 
  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$LineItem;
$html.='</td>
 </tr>
 <tr>
<td colspan=2>';
$html.='<table style="width:100%" >
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
 </tr>';
 

 
 
/*$html.=' <tr>
 	<td colspan=2 >
 		<table style="width:100%" >
 			<tr>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Name</td>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Signature</td>
 				<td style="width:33%; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Date</td>
 				
 			</tr>
 		</table>
 	</td>
 </tr>';*/
 
 
 $html.=' <tr>
 	<td colspan=2 style="width:100%; margin:10px 0;text-align:center;"  >
 		<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table>';
if ($ModDepName == 'printboth' && $_GET['t'] == 1) {
    echo $html.=$html;
} else {
    echo $html;
}

//$html='<h1>.testtstststtsts.</h1>';
if($_GET['this']==1){
 exit;
}
$content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
// convert in PDF
require_once("includes/htmltopdf/html2pdf.class.php");

try { //echo $content;
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    /*     * code for Dynamic pdf name download link * */
    // $nn=date('F-Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
    /*     * code for Dynamic pdf name download link * */
    //$nn=$arrySale[0][$ModuleID];

    /*     * code for PDf Priview * */
    if ($_GET['editpdftemp'] == '1') {
        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
//            $html2pdf->stream('Sales-'.$nn.'.pdf');
    }


    /*     * code for download link * */
    if ($_GET['attachfile'] == '1') {
        chmod($savefileUrl, 0777);
        $html2pdf->Output($savefileUrl . $ModDepName . '-' . $ModulePDFID . '.pdf', 'F');    // Save file to dir
    }
    $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

