<?php

(!$_GET['a'])?($_GET['a']=$_SERVER['REMOTE_ADDR']):(""); 

if(!empty($_GET['a'])){
	echo $_GET['a'].' : '.md5(md5(trim($_GET['a']))); 
}

exit;

include('../classes/class.pdf.php');
include ('../classes/class.ezpdf.php');
include('../includes/pdf_function.php');
/********************************/

$pdf = new Creport('LETTER','portrait');
$pdf->selectFont('../fonts/Helvetica.afm');
$pdf->ezSetMargins(120,117,50,50);

FooterTextBox($pdf);

//TitlePage($arry, $pdf);
//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

 $Title = 'PO Number # : PO00025';
 HeaderTextBox($pdf,$Title);
/***********************************/
$Head1 = 'SITE INFORMATION'; $Head2 = 'APPLICANT INFORMATION';
	$data = array(
		array($Head1 => "REGISTRATION#:   <b>34854389</b>          EPA ID:   <b>".$arrySite['EPANO']."</b>", $Head2 => "NAME:   <b>Parwez</b>"),
		array($Head1 => "TNRCC ID #:     <b>34345435</b>", $Head2 => "ADDRESS:  <b>A-83, Noida</b>"),
		array($Head1 => "NAME:     <b>345435435</b>", $Head2 => "                    <b>".$OCityState."</b>"),
		array($Head1 => "ADDRESS:   <b>".$arrySite['SADDRESS']."</b>", $Head2 => "PHONE:  <b>".$arryOwn['OPHONE']."</b>"),
		array($Head1 => "                      <b>".$arrySite['SCITY'].", ".$arrySite['SST']." ".$arrySite['SZIP']."</b>", $Head2 => "")
	);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'250')), 'shaded'=>0, 'showLines'=>1 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>0, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);


	$pdf->ezNewPage();

    $pdf->ezSetDy(-32);
	$data = array(
		array($Head1 => "EDWARDS ID#:     <b>".$SiteID."</b>", $Head2 => "NAME:  <b>".$arrySite['OWNNAME']."</b>"),
		array($Head1 => "ENTITY ID#:   <b>".$arrySite['REGENTNO']."</b>", $Head2 => "ADDRESS:   <b>".$arrySite['OWNADD']."</b>"),
		array($Head1 => "NAME:   <b>".$arrySite['REGENT']."</b>", $Head2 => "CITY:   <b>".$arrySite['OWNCITY']."</b>"),
		array($Head1 => "ADDRESS:   <b>".$arrySite['REGADD']."</b>", $Head2 => "STATE:   <b>".$arrySite['OWNST']."</b>"),
		array($Head1 => "CITY:   <b>".$arrySite['REGCITY']."</b>", $Head2 => "ZIPCODE:   <b>".$arrySite['OWNZIP']."</b>"),
		array($Head1 => "ZIPCODE:   <b>".$arrySite['REGZIP']."</b>", $Head2 => ""),
		array($Head1 => "COUNTY:   <b>".$arrySite['REGCNTY']."</b>", $Head2 => "")
	);
    $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'280')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>0, 'rowGap'=>2) );
    $pdf->setStrokeColor(0,0,0,1);

$pdf->ezNewPage();
$pdf->ezNewPage();
/***********************************/
$pdf->ezStream();
/*
// or write to a file
$file_path = 'test.pdf';
$pdfcode = $pdf->output();
$fp=fopen($file_path,'wb');
fwrite($fp,$pdfcode);
fclose($fp);
echo '<a href="'.$file_path.'">Click here to download Pdf</a>';
*/
?>