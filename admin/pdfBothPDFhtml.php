<?php

require_once("includes/settings.php");
/* * *Module PDF data ** */
$ModDepName = $_GET['ModuleDepName'];

(empty($_GET['print']))?($_GET['print']=""):("");
(empty($_GET['editpdftemp']))?($_GET['editpdftemp']=""):("");
(empty($_GET['attachfile']))?($_GET['attachfile']=""):("");
(empty($Cmpanyimg))?($Cmpanyimg=""):("");
(empty($informationdata))?($informationdata=""):("");
(empty($height1))?($height1=""):("");
(empty($height28))?($height28=""):("");
(empty($html1))?($html1=""):("");

(empty($informationdataSales))?($informationdataSales=""):("");
(empty($TransatonDataHead))?($TransatonDataHead=""):("");
(empty($TransatonDataVal))?($TransatonDataVal=""):("");


if ($ModDepName == 'printboth') {
    $pdfbotharry = array('PdfPO' => $_GET['po'], 'PdfSO' => $_GET['sop']);
//print_r($a);
    foreach ($pdfbotharry as $key => $values) {
        if ($key == 'PdfPO') {
            $ModDepNameBoth = 'Purchase';
            $_GET['module'] = 'Order';
            $_GET['o'] = $_GET['po'];
            require_once("purchasing/pdfPOList.php");
            /*             * html generate code start* */
            $SerialHead = '';
            /*             * **start code for dynamic pdf** */
            require_once("includes/pdfBothPDF_dynamicdata.php");
            require_once("includes/pdfBothPDF_dynamichtmldata.php");
            /*             * **end code for dynamic pdf*** */

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
 <div><table id="mainTable" >';
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
<td colspan=2  style="width:100%;margin-top:6px;">';
$html.=$PayDataShow;
$html.='</td>
</tr>
 
  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
            $html.=$LineItem;
            $html.='</td>
 </tr>';
 $html.=$LineItem1;
 
 $html.='</table>
 </div>
 <div style="width:635px; '.$height1.'"></div>
 <div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 0px; left: 10px; ">
 <table id="mainTable">
 <tr>
<td>';
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
 	<td  style="width:100%; margin:10px 0;text-align:center;"  >
	    <p>'.$FooterContent.'</p>
 		<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table></div>';

            //echo $html;
            /*             * html generate code End* */
        } else {
            if(!empty($_GET['sop'])){
            $ModDepNameBoth = 'Sales';
            $_GET['module'] = 'Order';
            $_GET['o'] = '';
            //$_GET['sop']=$values;
            require_once("sales/pdfSOList.php");
            /*             * html generate code start* */
            $SerialHead = '';
            /*             * **start code for dynamic pdf** */
            require_once("includes/pdfBothPDF_dynamicdata.php");
            require_once("includes/pdfBothPDF_dynamichtmldataSales.php");
            /*             * **end code for dynamic pdf*** */
			if($NumLine==1){
				$marginTopFooter='padding-top:250px;';
			}

            $html1 = '
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
 <div style="page-break-after: always;"><table id="mainTable">';
 $html1.='<tr><td style="width:100%;text-align:center;font-weight: bold; font-size: 17px;" colspan="2">'.$Title.'</td></tr>
 	<tr>';
 	
            if ($CompanyAlign == 'right' && $informationAlign == 'left') {
                $html1.=$TitleShowSales;
            } else {
                $html1.=$companyInfoShow;
            }
            if ($CompanyAlign == 'right' && $informationAlign == 'left') {
                $html1.=$companyInfoShow;
            } else {
                $html1.=$TitleShowSales;
            }
            $html1.='</tr>
        <tr>';
            $html1.='<td style="vertical-align:top;">';
            if ($CompanyAlign == 'right' && $informationAlign == 'left') {
                $html1.=$informationdataSales;
            } else {
                $html1.=$Cmpanyimg;
            }
            $html1.='</td>';

            $html1.='<td style="vertical-align:top;">';
            if ($CompanyAlign == 'right' && $informationAlign == 'left') {
                $html1.=$Cmpanyimg;
            } else {
                $html1.=$informationdataSales;
            }
            $html1.='</td>
 </tr>
 <tr>
 	<td style="width:210px; margin-top:30px; padding:0px; border:1px solid #e3e3e3;">';
            if ($BillingAlign == 'right' && $ShippingAlign == 'left') {
                $html1.=$AddressBSales;
            } else {
                $html1.=$AddressASales;
            }
            $html1.='</td>
 	<td style="width:320px; height:auto; margin-top:15px; padding:0px; border:1px solid #e3e3e3;">';
            if ($BillingAlign == 'right' && $ShippingAlign == 'left') {
                $html1.=$AddressASales;
            } else {
                $html1.=$AddressBSales;
            }
            $html1.='</td>
 </tr>
 <tr>
<td colspan=2  style="width:100%;margin-top:6px;">';
$html1.=$PayDataShow;
$html1.='</td>
</tr>';
/**new add 28-6-17***/
$html1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;">
    <td colspan="2"  style="width:100%; '.$height28.' margin:0px;padding:0px;">';
$html1.=$TransatonDataHead;
$html1.='</td>
 </tr>';
 $html1.=$TransatonDataVal;
/**new add 28-6-17***/
 
  $html1.='<tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
            $html1.=$LineItemSales;
            $html1.='</td>
 </tr>';
 $html1.=$LineItemSales1;
 $html1.='<tr>
<td colspan=2><div style="width:635px; '.$marginTopFooter.'"></div>';

            $html1.='<table style="width:100%" >
                            <tr>

                                <td style="float:left; width:366px; border:1px solid #e3e3e3;" >';
            $html1.=$specialNotesSales;

            $html1.='</td>

                                <td style="float:right; width:47%;  vertical-align: text-top;" align="right">';

            $html1.=$TotalDataShowSales;

            $html1.='</td>
                            </tr>	
                        </table>';
            $html1.='</td>
 </tr>

  <tr>
 	<td colspan=2 style="width:100%; margin:10px 0;text-align:center;"  >
	     <p>'.$FooterContent.'</p>
 		<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table></div>';

            //echo $html;
            /*             * html generate code End* */
            //echo '<pre>';print_r($arrySale);
            //echo $html1;die('sales');
        }//emptyif
        else{
            $html1='';
        }
            }
        //$html.=$html;
        $html.=$html1;
    }
}
/* * *Module PDF data ** */
echo $html;
//die('iii');
//$html='<h1>.testtstststtsts.</h1>';
//echo $html;
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
    if (($_GET['print'] == 'print') || ($ModDepName == 'printboth')) {
        //echo $html; die;
        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
        exit;
    }
    $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

