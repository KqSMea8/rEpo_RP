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

$PrefixTemp = '';
$InvoiceStatus='';
$LineItem1='';
$LineItem='';
$AddressA=$AddressB='';
 (empty($_GET['attachfile']))?($_GET['attachfile']=""):("");
(empty($_GET['editpdftemp']))?($_GET['editpdftemp']=""):("");
(empty($_GET['dwntype']))?($_GET['dwntype']=""):("");
(empty($Cmpanyimg))?($Cmpanyimg=""):("");
(empty($informationdata))?($informationdata=""):("");
 (empty($PayDataShow))?($PayDataShow=""):("");
(empty($height28))?($height28=""):("");
(empty($TransatonDataHead))?($TransatonDataHead=""):("");
(empty($TransatonDataVal))?($TransatonDataVal=""):("");
(empty($TotalDataShow))?($TotalDataShow=""):("");
(empty($ModulePDFID))?($ModulePDFID=""):("");
 (empty($_GET['this']))?($_GET['this']=""):("");
 
 $ComShow=0;

$ComponentShowHide = $objConfigure->getSettingVariable('PDF_SHOW');
if($ComponentShowHide=='no'){
   $ComShow=1;
}



/* * *Module PDF data ** */
$ModDepName = $_GET['ModuleDepName'];
if ($ModDepName == 'Sales') {
$Config['ComShow']=(!empty($ComShow))?("1"):("0");
	require_once("sales/pdfSOList.php");
	$PdfDir = ($_GET['module']=='Quote')?($Config['S_Quote']):($Config['S_Order']); 
	$PdfDir = $Config['FileUploadDir'].$PdfDir;
	$TableName = 's_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} else if ($ModDepName == 'Purchase') {
	require_once("purchasing/pdfPOList.php");
	$PdfDir = ($_GET['module']=='Quote')?($Config['P_Quote']):($Config['P_Order']); 
	$PdfDir = $Config['FileUploadDir'].$PdfDir;
	$TableName = 'p_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];	
} elseif ($ModDepName == 'SalesInvoice') {
$Config['ComShow']=(!empty($ComShow))?("1"):("0");
	require_once("finance/pdfInvoiceList.php");
	$PdfDir = $Config['FileUploadDir'].$Config['S_Invoice'];
	$TableName = 's_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} elseif ($ModDepName == 'PurchaseInvoice') {
	require_once("finance/pdfPoInvoiceList.php");
	$PdfDir = $Config['FileUploadDir'].$Config['P_Invoice'];
	$TableName = 'p_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} else if ($ModDepName == 'SalesRMA') {  
$Config['ComShow']=(!empty($ComShow))?("1"):("0"); 
	require_once("sales/pdfRmaList.php");
	$PdfDir = $Config['FileUploadDir'].$Config['S_Rma'];
	$TableName = 's_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} else if ($ModDepName == 'PurchaseRMA') {   
	require_once("purchasing/pdfRmaList.php");	 
	$PdfDir = $Config['FileUploadDir'].$Config['P_Rma'];
	$TableName = 'p_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} else if ($ModDepName == 'SalesCreditMemo') {
$Config['ComShow']=(!empty($ComShow))?("1"):("0");
    require_once("finance/pdfCreditNoteList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Credit'];
    $TableName = 's_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} else if ($ModDepName == 'PurchaseCreditMemo') {
    require_once("finance/pdfPoCreditNoteList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['P_Credit'];
    $TableName = 'p_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
}elseif ($ModDepName == 'SalesInvoiceGl'){
$Config['ComShow']=(!empty($ComShow))?("1"):("0");
	 require_once("finance/pdfInvoiceGlList.php");
	$PdfDir = $Config['FileUploadDir'].$Config['S_Invoice'];
	$TableName = 's_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
} 
/**new code for ware house**/
else if ($ModDepName == 'SalesCashReceipt') {
    require_once("finance/pdf_case_reciept_List.php");
    $savefileUrl = "finance/upload/pdf/";
} else if ($ModDepName == 'WhouseBatchMgt') {  
$Config['ComShow']=(!empty($ComShow))?("1"):("0");   
    require_once("warehouse/pdfShipmentList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Shipment'];
    $TableName = 's_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['SHIP'];
} else if ($ModDepName == 'WhouseVendorRMA') {     
   require_once("warehouse/pdfPoRmaList.php");
   $PdfDir = $Config['FileUploadDir'].$Config['P_Rma'];
   $TableName = 'w_receiptpo'; $OrderIDCol = 'ReceiptID'; $OrderID = $_GET['o'];
}
else if ($ModDepName == 'WhouseCustomerRMA') {     
    require_once("warehouse/pdfWarehouseReturnList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Rma'];
    $TableName = 'w_receipt'; $OrderIDCol = 'ReceiptID'; $OrderID = $_GET['o'];
}
else if ($ModDepName == 'WhousePOReceipt') {    
    require_once("warehouse/pdfPoReceiptList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['P_Receipt'];
    $TableName = 'p_order'; $OrderIDCol = 'OrderID'; $OrderID = $_GET['o'];
}
else if ($ModDepName == 'Quote') {
   
    require_once("crm/pdfvQuoteList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['C_Quote'];
    $TableName = 'c_quotes'; $OrderIDCol = 'quoteid'; $OrderID = $_GET['o'];
}
 
/**********************/
if(!empty($PdfDir)){
	$savefileUrl = $PdfDir;
			
	if (!is_dir($savefileUrl)) {
		mkdir($savefileUrl);
		chmod($savefileUrl,0777);
	}
} else if(!empty($savefileUrl)){
	$savefileUrl = $savefileUrl.$_SESSION['CmpID']."/";						
	if (!is_dir($savefileUrl)) {
		mkdir($savefileUrl);
		chmod($savefileUrl,0777);
	}
}
 
/**********************/

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

// Added by sanjiv

if($_GET['dwntype']=='excel'){
	include 'excelCommonHtml.php';
	exit;
}

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
         
         background-repeat: no-repeat;
         background-position: center 80px;
         background-width: 100%;
         
         
         
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

.oddrow td {
   border-bottom:1px solid #ececec;
}
.evenrow td {  
   border-bottom:1px solid #ececec; 
}
 </style>
 ';

$PaidImg ='<img src="https://www.eznetcrm.com/erp/upload/company/paid.png" style="position:absolute;top:150px;left:240px;">';
$RefundImg ='<img src="https://www.eznetcrm.com/erp/upload/company/refunded.png" style="position:absolute;top:180px;left:240px;">';
 
if($ModDepName == 'SalesInvoice' || $ModDepName == 'SalesInvoiceGl') {
 if ($InvoiceStatus == 'Paid' || $InvoiceStatus == 'Credit Card') {
    $html.='<div><table id="mainTableBackImg">'.$PaidImg;
   }
   else{$html.='<div><table id="mainTable">';}
}
else if($ModDepName == 'Sales') {
   if(strtolower($PaymentTerm)=='credit card' && ($OrderPaid==1 || $OrderPaid==4)){
    $html.='<div><table id="mainTableBackImg">'.$PaidImg;
}
else if(strtolower($PaymentTerm)=='paypal' && $OrderPaid==1){
    $html.='<div><table id="mainTableBackImg">'.$PaidImg;
}
    //echo $PaymentTerm;die;
    else{$html.='<div><table id="mainTable">';}
} else if($ModDepName == 'SalesCreditMemo' && ($OrderPaid=='2' || $OrderPaid=='3')) { 
    $html.='<div><table id="mainTableBackImg">'.$RefundImg;    
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
</tr>';
/**new add 28-6-17***/
$html.='<tr style="vertical-align:  top;  margin:0px;padding:0px;">
    <td colspan="2"  style="width:100%; '.$height28.' margin:0px;padding:0px;">';
$html.=$TransatonDataHead;
$html.='</td>
 </tr>';
 $html.=$TransatonDataVal;
/**new add 28-6-17***/
$height='';
$height28='';
$height1='height:220px;';

if ($ModDepName == 'SalesInvoice') {
    $serialCount1=sizeof($salesInvSerialNo);
    //echo $serialCount1;
 if($NumLine==1 && ($InvoiceStatus == 'Paid' || $InvoiceStatus == 'Credit Card') && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
 elseif($NumLine==2 && ($InvoiceStatus == 'Paid' || $InvoiceStatus == 'Credit Card') && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
 elseif($NumLine==3 && ($InvoiceStatus == 'Paid' || $InvoiceStatus == 'Credit Card') && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
 elseif($NumLine==4 && ($InvoiceStatus == 'Paid' || $InvoiceStatus == 'Credit Card') && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
}
  $html.='<tr style="vertical-align:  top;  margin:0px;padding:0px;">
 	<td colspan="2"  style="width:100%; '.$height28.' margin:0px;padding:0px;">';
$html.=$LineItem;
$html.='</td>
 </tr>';

 //$html.='<tr style="vertical-align:  top;  margin:0px;padding:0px;">';
$html.=$LineItem1;
//$html.='</tr>';


  $html.='<tr>
    <td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$SerialHead;
$html.='</td>
 </tr>
 </table>
 </div>
 <div style="width:635px; '.$height1.'"></div>
 <div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 0px; left: 10px; ">
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
 </tr>';
 
 $html.='<tr>
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
    echo $html;

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
    @ob_end_clean();
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
 
	if(!empty($_GET['tempid'])){
		$temp = '-temp'.$_GET['tempid'];
		$PdfFileName = $ModDepName . '-' . $ModulePDFID .$temp. '.pdf';
		$html2pdf->Output($savefileUrl . $PdfFileName, 'F');   
	}else{
		$PdfFileName = $ModDepName . '-' . $ModulePDFID . '.pdf';        
        	$html2pdf->Output($savefileUrl.$PdfFileName, 'F');     
	}

	 

	/*********ObjectStorage******/
	if($Config['ObjectStorage']=="1"){		
		require_once("../classes/function.class.php");
 		$objFunction=new functions();
		$PdfFolder = str_replace($Config['FileUploadDir'],"",$PdfDir);
		$ResponseArray = $objFunction->MoveObjStorage($savefileUrl, $PdfFolder, $PdfFileName);
		if($ResponseArray['Success']=="1"){
			unlink($savefileUrl.$PdfFileName);			
		}else{
			echo $ResponseArray['ErrorMsg']; die;
		}		
	}
	/***************************/
	
	/***Update PdfFile in DB*************/
	if(!empty($TableName) && !empty($OrderIDCol) && !empty($OrderID)){
		 $sqlPdf = "update ".$TableName." set PdfFile='".$PdfFileName."' where ".$OrderIDCol."='".$OrderID."'";
		mysql_query($sqlPdf);
	}
	/*********************************/

    }
    $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

