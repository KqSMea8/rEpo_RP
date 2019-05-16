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


$InvoiceStatus='';

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
/**new code for ware house**/
else if ($ModDepName == 'SalesCashReceipt') {
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
else if ($ModDepName == 'WhouseCustomerRMA') {
    //die('ddd');
    require_once("warehouse/pdfWarehouseReturnList.php");
    //$savefileUrl = "";
}
else if ($ModDepName == 'WhousePOReceipt') {
    //die('ddd');
    require_once("warehouse/pdfPoReceiptList.php");
    //$savefileUrl = "";
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
$marginForSplTotl='20';
//require_once("includes/pdf_common_footermargin.php");
   //<div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 10px; left: 10px; ">
$html = '
 <style>
table#mainTable{
 	width:635px;
 	margin-left:20px;
 	margin-top:30px;
        font-family:Arial, Helvetica, sans-serif; 
        color:#000000; 
        font-size:11px;
        font-weight:500;
        img border:none;
        clear:both;
 }

 table#mainTableBackImg{
    width:635px;
    margin-left:20px;
    margin-top:30px;
        font-family:Arial, Helvetica, sans-serif; 
        color:#000000; 
        font-size:11px;
        font-weight:500;
        img border:none;
        clear:both;
        background-image: url(https://www.eznetcrm.com/erp/upload/company/paid.png);
         background-repeat: no-repeat;
         background-position: center center;              
 }

 table#footer{
    width:635px;
  
        font-family:Arial, Helvetica, sans-serif; 
        color:#000000; 
        font-size:11px;
        font-weight:500;
        img border:none;
        clear:both;
 }

 .footer { position: fixed; bottom: 0px; }
 .pagenum:before { content: counter(page); }

 </style>
 ';
 if ($InvoiceStatus == 'Paid') {
    $html.='<div><table id="mainTableBackImg">';
   }
   else{$html.='<div><table id="mainTable">';}
 
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
    //$html.=$Cmpanyimg;
} else {
    $html.=$informationdata;
}
$html.='</td>
 </tr>
 <tr>
 	<td style="width:210px; margin-top:30px; padding:0px; border:1px solid #e3e3e3; vertical-align: top;">';
if ($BillingAlign == 'right' && $ShippingAlign == 'left') {
    $html.=$AddressB;
} else {
    $html.=$AddressA;
}
$html.='</td>
 	<td style="width:320px; height:auto; margin-top:15px; padding:0px; border:1px solid #e3e3e3; vertical-align: top;">';
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
 
  <tr style="vertical-align: top; margin:0px;padding:0px;">
 	<td colspan="2"  style="width:100%; margin:0px;padding:0px;">';
$html.=$LineItem;
$html.='</td>
 </tr>
  <tr>
    <td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$SerialHead;
$html.='</td>
 </tr>
 </table>
 </div>
 <div style="width:635px; height:140px;"></div>
 <div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 10px; left: 10px; ">
 <table id="mainTable">
 <tr>
<td style="width:100%;>';
$html.='<table style="width:100%; margin-top:'.$marginForSplTotl.'px;" >
                            <tr>

                                <td style="float:left; width:366px; border:1px solid #e3e3e3;" >';
$html.=$specialNotes;

$html.='</td>

                                <td style="text-align:right; width:47%;  vertical-align: top;" align="right">';

$html.=$TotalDataShow;

$html.='</td>
                            </tr>	
                        </table>';
$html.='</td>
 </tr>
 
 <tr>
    <td style="width:100%; text-align:center;"  >
        <p>'.$FooterContent.'</p>
        <h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
    </td>
 </tr>';
$html.='</table></div>';
 /*<tr>
 <td colspan=2 style="width:100%; margin-top:5px; text-align:center;clear:both;">
    <p style="text-align:center; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">' . $FooterContent . '</p>
 </td>
 </tr>*/
 

 
 
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

try {

  $html2pdf = new HTML2PDF('P', 'A4', 'de', true, 'UTF-8',array(12, 12, 12, 12));
    /*nnn*/
    $html2pdf->pdf->setAutoPageBreak(false,0);

    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    ob_end_clean();
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

