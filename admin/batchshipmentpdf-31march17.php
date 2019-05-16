<?php 

require_once("includes/settings.php");
require_once("../classes/warehouse.class.php");
require_once("../classes/warehouse.shipment.class.php");
require_once("../classes/sales.quote.order.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require("includes/htmltopdf/html2pdf.class.php");
$objSale = new sale();
$objShipment = new shipment();
$objCustomer = new Customer();
$objWarehouse = new warehouse();
$savefileUrl = "upload/batchpdf/".$_SESSION['CmpID']."/";
if (!is_dir($savefileUrl)) {
mkdir($savefileUrl);
chmod($savefileUrl,0777);
}

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

$ModDepName = 'BatchShipment';
$shipIds = array();
if (!empty($batchidarray)) {
  
    foreach ($batchidarray as $values) {

       $_GET['SHIP'] = $values['OrderID'];
        
        require("warehouse/pdfShipmentList.php");
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
ob_start();
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
 <div style="page-break-after: always;"><table id="mainTable">
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
 
 </table></div>';
   // $html1.=$html;
    echo $html; 

	/* * *Module PDF data ** */

	$content = ob_get_contents();
	try
	{
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output($savefileUrl . $ModDepName . '-' . $ModulePDFID . '.pdf', 'F');    // Save file to dir
	}
	catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
	}

	$content = ob_get_clean();
	ob_flush();
	flush();

	array_push($shipIds,$ModulePDFID);
	}
}
else {
    header("Location:".$RedirectURL);
    exit;
}

if (!empty($shipIds)) 
{
    
    foreach($shipIds as $shipId)
    {
       // $ModuleDepName = 'SalesInvoice';
        $file_path = 'upload/batchpdf/'.$_SESSION['CmpID'].'/' . $ModDepName . '-' .$shipId . '.pdf';
        $attachment = getcwd() . "/" . $file_path;
	//chmod($attachment, 0755);
        $arr = $objWarehouse->sendBatchPdfOnMail($shipId,$attachment);
	unlink($file_path); 
    }
}

echo '<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script><script type="text/javascript">$(function(){setTimeout(function(){ document.location.href="warehouse/batchclose.php?email=success"; }, 1000);});</script>';



?>

