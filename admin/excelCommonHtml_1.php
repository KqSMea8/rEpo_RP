<?php
require_once("includes/phpexcel/PHPExcel.php");

$html = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
    <head>
        <meta http-equiv=Content-Type content="text/html; charset=windows-1252"/>
        <meta name=ProgId content=Excel.Sheet/>
        <meta name=Generator content="Microsoft Excel 11"/>
</head>
<body>';
 
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
</tr>';
$height='';
$height1='height:140px;';

if ($ModDepName == 'SalesInvoice') {
    $serialCount1=sizeof($salesInvSerialNo);
    //echo $serialCount1;
 if($NumLine==1 && $InvoiceStatus == 'Paid' && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
 elseif($NumLine==2 && $InvoiceStatus == 'Paid' && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
 elseif($NumLine==3 && $InvoiceStatus == 'Paid' && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
 elseif($NumLine==4 && $InvoiceStatus == 'Paid' && $serialCount1==1){$height='height:600px;'; $height1='height:0px;';}
}
  $html.='<tr style="vertical-align:  top;  margin:0px;padding:0px;">
 	<td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;">';
$html.=$LineItem;
$html.='</td>
 </tr>';
  $html.='<tr>
    <td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$SerialHead;
$html.='</td>
 </tr>
 </table>
 </div>
 <div style="width:635px; '.$height1.'"></div>
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
 </tr>';
 
$html.='</table></div>';

/*
$filename = $ModDepName . '-' . $ModulePDFID . '.xls';

header("Content-Description: File Transfer");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: ".strlen($html));
ob_clean();
flush();


if ($ModDepName == 'printboth' && $_GET['t'] == 1) {
	echo $html.=$html;
} else {
	echo $html;
}

exit;*/
if ($ModDepName == 'printboth' && $_GET['t'] == 1) {
	echo $html.=$html;
} else {
	echo $html;
}

$filename = $ModDepName . '-' . $ModulePDFID . '.xls';

// save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $html);
	//pr($tmpfile,1);
// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
$objPHPExcel     = new PHPExcel();
$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
$objPHPExcel->getActiveSheet()->setTitle('any name you want'); // Change sheet's title if you want

unlink($tmpfile); // delete temporary file because it isn't needed anymore

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
header('Cache-Control: max-age=0');

// Creates a writer to output the $objPHPExcel's content
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$writer->save('php://output');
exit;
?>