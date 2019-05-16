<?php
//    /usr/bin/php /var/www/html/erp/admin/pdfCommon.php 29563 Sales Quote 37 erp_DemoVstacks 212
//  /usr/bin/php /var/www/html/erp/admin/pdfCommon.php 29074 SalesInvoice Invoice 37 erp_DemoVstacks

$argv['0']='pdfCommon.php';
$argv['1']=29694;
$argv['2']='SalesInvoice';
$argv['3']='Invoice';
$argv['4']='37';
$argv['5']='erp_DemoVstacks';

if(!empty($argv['0']) && !empty($argv['1']) && !empty($argv['2'])){

	ob_start();
	session_start();

	ini_set('display_errors',0);
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED); 
	$_GET['o']=$argv['1'];
	$_GET['ModuleDepName']=$argv['2'];	
	$_GET['module']=$argv['3'];
	$_GET['attachfile']=1;
	$_GET['tempid'] = $argv['6']; 	//12Mar18 by chetan//
	//if($_GET['tempid']!=''){ $_GET['module'] = '';  }//12Mar18 by chetan//
	$CmpID = $argv['4'];
	$DbName = $argv['5'];
	$RootDir = '/var/www/html/'; 
	$Prefix = $RootDir.'erp/'; 
	//$Prefix ='../';
	$Config['CronJob'] = '1'; 
	$_SESSION['CmpID'] =$CmpID;
   	require_once($Prefix."includes/config.php"); 
    require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/region.class.php");	
	
	$PrefixTemp = $Prefix.'admin/';	
	require_once($PrefixTemp."language/english.php");
	
	$objConfig=new admin();
	$objConfigure=new configure();
	$objCompany=new company(); 
	$objRegion=new region();
	$arryCompany = $objCompany->GetCompanyBrief($CmpID);
	
	include($PrefixTemp."includes/common.php");

	$Config['FileUploadDir'] = $RootDir."upload/".$CmpID."/";

	if(!empty($arryCompany[0]['currency_id'])){
		$arrySelCurrency = $objRegion->getCurrency($arryCompany[0]['currency_id'],'');
		if(!empty($arrySelCurrency[0]['code']))$Config['Currency'] = $arrySelCurrency[0]['code'];
 	}

	/***************/
	$Config['DbName'] = $DbName;
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();	
	/***************/

	
	$arryCurrentLocation = $objConfigure->GetLocation(1,'');


	/****************************/		
	if($CmpID=='572'){ //otep
		$TaxCaption = $objConfigure->getSettingCaption('SalesTaxAccount');
	}else{
		$TaxCaption = 'Tax';
	}		 
	/****************************/


}else{
	require_once("includes/settings.php");	
	$PrefixTemp = '';
}

$LineItem1='';
$LineItem='';
$AddressA=$AddressB='';
$InvoiceStatus='';

 (empty($_GET['attachfile']))?($_GET['attachfile']=""):("");
(empty($_GET['editpdftemp']))?($_GET['editpdftemp']=""):("");
(empty($_GET['dwntype']))?($_GET['dwntype']=""):("");
(empty($Cmpanyimg))?($Cmpanyimg=""):("");
(empty($informationdata))?($informationdata=""):("");
(empty($PayDataShow))?($PayDataShow=""):("");
(empty($height28))?($height28=""):("");
(empty($TransatonDataHead))?($TransatonDataHead=""):("");
(empty($TransatonDataVal))?($TransatonDataVal=""):("");
(empty($_GET['this']))?($_GET['this']=""):("");


/* * *Module PDF data ** */
$ModDepName = $_GET['ModuleDepName'];
if ($ModDepName == 'Sales') {
    require_once($PrefixTemp."sales/pdfSOList.php");
    #$savefileUrl = $PrefixTemp."sales/upload/pdf/";

    $PdfDir = ($_GET['module']=='Quote')?($Config['S_Quote']):($Config['S_Order']); 
    $PdfDir = $Config['FileUploadDir'].$PdfDir;

} else if ($ModDepName == 'Purchase') {
    require_once($PrefixTemp."purchasing/pdfPOList.php");
    #$savefileUrl = $PrefixTemp."purchasing/upload/pdf/";

    $PdfDir = ($_GET['module']=='Quote')?($Config['P_Quote']):($Config['P_Order']); 
    $PdfDir = $Config['FileUploadDir'].$PdfDir;
	
} elseif ($ModDepName == 'SalesInvoice') {  
	require_once($PrefixTemp."finance/pdfInvoiceList.php");
	$_GET['module'] = '';
	$PdfDir = $Config['FileUploadDir'].$Config['S_Invoice'];
	
} elseif ($ModDepName == 'PurchaseInvoice') {
	$_GET['module'] = '';
    require_once($PrefixTemp."finance/pdfPoInvoiceList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['P_Invoice'];
} else if ($ModDepName == 'SalesRMA') {
	$_GET['module'] = '';
    require_once($PrefixTemp."sales/pdfRmaList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Rma'];

} else if ($ModDepName == 'PurchaseRMA') {    
    require_once($PrefixTemp."purchasing/pdfRmaList.php");

    $PdfDir = $Config['FileUploadDir'].$Config['P_Rma'];

} else if ($ModDepName == 'SalesCreditMemo') {
    require_once($PrefixTemp."finance/pdfCreditNoteList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Credit'];
} else if ($ModDepName == 'PurchaseCreditMemo') {
    require_once($PrefixTemp."finance/pdfPoCreditNoteList.php");     
     $PdfDir = $Config['FileUploadDir'].$Config['P_Credit'];

} elseif ($ModDepName == 'SalesInvoiceGl') {  
    require_once($PrefixTemp."finance/pdfInvoiceGlList.php");
	$PdfDir = $Config['FileUploadDir'].$Config['S_Invoice'];
	
} elseif ($ModDepName == 'WhousePOReceipt') {   
    require_once($PrefixTemp."warehouse/pdfPoReceiptList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['P_Receipt']; 
	
} elseif ($ModDepName == 'WhouseBatchMgt') {   
    require_once($PrefixTemp."warehouse/pdfShipmentList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Shipment']; 
	
} else if ($ModDepName == 'WhouseVendorRMA') {     
    require_once($PrefixTemp."warehouse/pdfPoRmaList.php");
   $PdfDir = $Config['FileUploadDir'].$Config['P_Rma'];
}
else if ($ModDepName == 'WhouseCustomerRMA') {     
    require_once($PrefixTemp."warehouse/pdfWarehouseReturnList.php");
    $PdfDir = $Config['FileUploadDir'].$Config['S_Rma'];
}


/**********************/
if(!empty($PdfDir)){

	if (!is_dir($Config['FileUploadDir'])) {
		mkdir($Config['FileUploadDir']);
		chmod($Config['FileUploadDir'],0777);
	}

	$savefileUrl = $PdfDir;
			
	if (!is_dir($savefileUrl)) {
		mkdir($savefileUrl);
		chmod($savefileUrl,0777);
	}
} else if(!empty($savefileUrl)){
	$savefileUrl = $savefileUrl.$CmpID."/";						
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
require_once($PrefixTemp."includes/pdf_common_dynamicdata.php");
require_once($PrefixTemp."includes/pdf_common_dynamicItem.php");        //New added//
require_once($PrefixTemp."includes/pdf_common_dynamichtmldata.php");
require_once($PrefixTemp."comman_pdf_header.php");                  
/* * **end code for dynamic pdf*** */

 
$marginForSplTotl='20';

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
 </style>';

$PaidImg ='<img src="https://www.eznetcrm.com/erp/upload/company/paid.png" style="position:absolute;top:120px;left:240px;">';

 
if($ModDepName == 'SalesInvoice' || $ModDepName == 'SalesInvoiceGl') {
 if ($InvoiceStatus == 'Paid' || $InvoiceStatus == 'Credit Card') {
    $html.='<div><table id="mainTableBackImg">'.$PaidImg;
   }
   else{$html.='<div><table id="mainTable">';}
}
else if($ModDepName == 'Sales') {
   if(strtolower($PaymentTerm)=='credit card' && $OrderPaid==1){
    $html.='<div><table id="mainTableBackImg">'.$PaidImg;
}
else if(strtolower($PaymentTerm)=='paypal' && $OrderPaid==1){
    $html.='<div><table id="mainTableBackImg">'.$PaidImg;
}
    //echo $PaymentTerm;die;
    else{$html.='<div><table id="mainTable">';}
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
    $html.=$Cmpanyimg;
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
<td colspan="2"  style="width:100%;margin-top:6px;">';
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
$height1='height:140px;';

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

                                <td style="float:right; width:47%;  vertical-align: text-top;" align="right">';

$html.=$TotalDataShow;

$html.='</td>
                            </tr>	
                        </table>';
$html.='</td>
 </tr>';
 


 
 $html.=' <tr>
 	<td style="width:100%; margin:10px 0;text-align:center;"  >
    <p>'.$FooterContent.'</p>
 		<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table></div>';
if ($ModDepName == 'printboth' && $_GET['t'] == 1) {
    echo $html.=$html;
} else {
    echo $html;
}

//$html='<h1>.testtstststtsts.</h1>';
//echo $html;
$content = ob_get_clean();
@ob_end_clean(); // close and clean the output buffer.
// convert in PDF
require_once($PrefixTemp."includes/htmltopdf/html2pdf.class.php");

try { //echo $content;
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
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
	//added on 12Mar2018 by chetan//
	if(!empty($_GET['tempid'])){
		$temp = '-temp'.$_GET['tempid'];
		$PdfFileName = $ModDepName . '-' . $ModulePDFID .$temp. '.pdf';
		$html2pdf->Output($savefileUrl . $PdfFileName, 'F');     
	}else{
		$PdfFileName = $ModDepName . '-' . $ModulePDFID . '.pdf'; 
		$html2pdf->Output($savefileUrl . $PdfFileName, 'F');     
	}
	//$html2pdf->Output($savefileUrl . $PdfFileName, 'F');  

	/*********ObjectStorage******/
	if($Config['ObjectStorage']=="1"){		
		require_once($Prefix."classes/function.class.php");
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
   
	echo 'Pdf Generated Successfully.';exit;
    }
    $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

