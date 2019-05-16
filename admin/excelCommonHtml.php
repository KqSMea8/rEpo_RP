<?php
//echo stripslashes(strip_tags($arryCurrentLocation[0]['Address'])).", ".stripslashes($arryCurrentLocation[0]['City']).","; die;
require_once("includes/phpexcel/PHPExcel/IOFactory.php");
$objPHPExcel     = new PHPExcel();

//pr($specialNotes);
//pr($TotalDataShow,1);
$specialNotes_key = array_keys($specialNotesArry);
$specialNotes_values = array_values($specialNotesArry);

$TotalDataShow_key = array_keys($TotalDataShowArry);
$TotalDataShow_values = array_values($TotalDataShowArry);


$Address1_key = array_keys($Address1);
$Address1_values = array_values($Address1);
$Address1_array = explode("<br>",$Address1_values[0]);
 
$Address2_key = array_keys($Address2);
$Address2_values = array_values($Address2);
$Address2_array = explode("<br>",$Address2_values[0]);
 
if(count($Address2_array)>count($Address1_array)) $cnt = count($Address2_array);
else $cnt = count($Address1_array);
//$addr1 = implode(',<br style="mso-data-placement:same-cell;" />',$Address1);
//$addr2 = implode(',<br style="mso-data-placement:same-cell;" />',$Address2);
 

$AddressA ='<table border=".5pt">
		<tr> <td>BILLING</td>   <td>SHIPPING</td> </tr>';
for($sp0=0; $sp0<=$cnt; $sp0++){
		$AddressA .='<tr valign="top">
			<td valign="top">'.$Address1_array[$sp0].'</td> 
					 
			<td valign="top">'.$Address2_array[$sp0].'</td>
		</tr>'; 
 }
 
$AddressA .='</table>';




$AddressB ='<table border=".5pt">
		<tr> <td>SHIPPING</td> 	<td>BILLING</td> </tr>
		';
 for($sp0=0; $sp0<=$cnt; $sp0++){
$AddressB .='<tr valign="top">
		<td valign="top">'.$Address2_array[$sp0].'</td>
				 
			<td valign="top">'.$Address1_array[$sp0].'</td> 
		</tr>'; 
	  }
$AddressB .='
</table>';
 
 

$Totalbottom = '<table align="right">';
for($sp=0; $sp<=4; $sp++){ 
	$Totalbottom .='<tr>';
	$Totalbottom .= '<td align="left">';
	if($sp==0){
		$Totalbottom .= 'Special Notes and Instructions';
	}else if($sp==1) {
		if(!empty($specialNotes_key[$sp])) $Totalbottom .=  $specialNotes_key[$sp] . ' : ' .  $specialNotes_values[$sp];
		else $Totalbottom .=  'Comments : Not specified.';
	}
	$Totalbottom .= '</td>';
	
	$Totalbottom .='<td></td><td></td><td></td><td align="right">' . $TotalDataShow_key[$sp] . '</td>
                    <td>'. $TotalDataShow_values[$sp] .'</td>';
	$Totalbottom .='</tr>';
	
}
$Totalbottom .='</table>';


$specialNotes1 = 'Special Notes and Instructions<br />';
if (!empty($specialNotesArry)) {
	foreach ($specialNotesArry as $key => $value) {
		$specialNotes1.='' . $key . ' : ' . $value . '<br />';
	}
}
$specialNotes1.=$SpecialSigned;
                                      

if (!empty($TotalDataShowArry)) {
	$TotalDataShow1 = '<table align="right">';

	foreach ($TotalDataShowArry as $key => $value)
		$TotalDataShow1 .='<tr>
                                    <td width="83" style="padding:5px 0px 5px 0px; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';">' . $key . '</td>
                                    <td width="82" style="border:1px solid #cacaca;   font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';"><span style="text-align:right;">' . $value . '</span> </td>
                                  </tr>';
		$TotalDataShow1 .='</table>';
}

$marginForSplTotl='20';
//require_once("includes/pdf_common_footermargin.php");
   //<div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 10px; left: 10px; ">
$html = '
 <style>
table br{mso-data-placement:same-cell;}
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
 
/*  $html.='<tr><td colspan="3">'.$_SESSION['DisplayName'].'</td></tr> <tr><td style="width:100%;text-align:center;font-weight: bold; font-size: 17px;" align="center" colspan="3">'.$Title.'</td></tr>
 	<tr><tr></tr>'; */
   $html.='<tr><td colspan="3"></td></tr> <tr><td style=" align="center" colspan="3"></td></tr>
 	<tr></tr> <tr>';
if ($CompanyAlign == 'right' && $informationAlign == 'left') {
    $html.='<td></td><td></td><td></td>'.$TitleShow;
} else {
    $html.=strip_tags($companyInfoShow,"<td><span>");
    $cis = 'A';
}
if ($CompanyAlign == 'right' && $informationAlign == 'left') {
    $html.=strip_tags($companyInfoShow,"<td><span>");
    $cis = 'C';
} else {
    $html.='<td></td><td></td><td></td>'.$TitleShow;
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
 <tr> </tr>
 <tr>
 	<td style="width:210px; margin-top:30px; padding:0px; border:1px solid #e3e3e3; vertical-align: top;">';



if ($BillingAlign == 'right' && $ShippingAlign == 'left') {
    $html.=$AddressB;
} else {
    $html.=$AddressA;

}
	


$html.='</td>
 </tr>
 <tr>
<td colspan=1  style="width:100%;margin-top:6px;">';
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
$html.=$LineItem1;
  $html.='<tr>
    <td colspan=2  style="width:100%; margin-top:6px; ">';
$html.=$SerialHead;
$html.='</td>
 </tr>
		

 </table>
 </div>
 <div style="width:635px; '.$height1.'"></div>
 <div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 10px; left: 10px; ">';
$html.=$Totalbottom;
$html.='</td>
 </tr>
		
<tr>
<td style="width:100%; text-align:center;"  >
<p>'.$FooterContent.'</p>
<h3 style="font-size:' . $thanksFontSize . 'px; text-align:center; font-weight:bold; color:' . $specialFieldColor . ';">Thank you for your business!</h3>
</td>
</tr>';
 
$html.='</table></div>';

//echo $html; die;

ob_clean();
$filename = $ModDepName . '-' . $ModulePDFID . '.xlsx';

 // save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $html);
	//pr($tmpfile,1);
// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader

$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
/* foreach($objPHPExcel->getActiveSheet()->getRowDimensions() as $rd) {
	$rd->setRowHeight(-1);
} */
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("500");
//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("500");
//$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("500");

$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
$objPHPExcel->getActiveSheet()->setTitle(substr($filename,0,30)); // Change sheet's title if you want
//$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth("200");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("14");

unlink($tmpfile); // delete temporary file because it isn't needed anymore

$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue($Title);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);

/***************************************************/
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName($_SESSION['DisplayName']);
$objDrawing->setDescription($_SESSION['DisplayName']);
$objPHPExcel->getActiveSheet()->mergeCells($cis.'3:'.$cis.'6');
//Path to signature .jpg file
$objDrawing->setPath($SiteLogo, false);
$objDrawing->setOffsetX(0);                     //setOffsetX works properly
$objDrawing->setOffsetY(0);                     //setOffsetY works properly
$objDrawing->setCoordinates($cis."3");             //set image to cell
//$objDrawing->setWidth(60);
//$objDrawing->setHeight(55);                     //signature height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save

//$objPHPExcel->getActiveSheet()->mergeCells('A7:A8');
$objPHPExcel->getActiveSheet()->getCell($cis.'7')->setValue(stripslashes(trim(preg_replace('/\s\s+/', ' ', $arryCurrentLocation[0]['Address']))).", ".stripslashes($arryCurrentLocation[0]['City']));
$objPHPExcel->getActiveSheet()->getCell($cis.'8')->setValue(stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country'])."-".stripslashes($arryCurrentLocation[0]['ZipCode']));
/***************************************************/

$footerRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 
$objPHPExcel->getActiveSheet()->mergeCells('A'.$footerRow.':E'.$footerRow);
//$objPHPExcel->getActiveSheet()->getCell('A'.$footerRow)->setValue($Title);
$objPHPExcel->getActiveSheet()->getStyle('A'.$footerRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
header('Cache-Control: max-age=0');

// Creates a writer to output the $objPHPExcel's content
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$writer->save('php://output');
exit;
 

?>
