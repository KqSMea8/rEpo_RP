<?php	    
         require_once("../includes/settings.php");
         require_once("../includes/pdf_comman.php");
	     require_once($Prefix."classes/finance.report.class.php");
	     
	     CleanGet();
	     $objReport = new report();
	     $module = 'Invoice';

    $ModuleIDTitle = "Invoice Number"; $PrefixSO = "IN";  $NotExist = NOT_EXIST_INVOICE;
	$ModuleName = $module;

	if(!empty($_GET['IN'])){
		$arryStatement = $objReport->GetStatement($_GET['IN']);
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}
	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(60,20,50,50);
    $Title = $ModuleName." # ".$arryStatement[0]['InvoiceID'];
	HeaderTextBox($pdf,$Title,$arryCompany);
	$pdf->ezSetDy(-5);
	$Head1 = '<b>'.CUSTOMER_ADDRESS.'</b>';
    
	//$YCordLine = $pdf->y-25; 
	//$pdf->line(50,$YCordLine,120,$YCordLine);
	//$pdf->line(324,$YCordLine,402,$YCordLine);
	unset($data);
	if(!empty($arryStatement[0]['CustomerCompany']))  $data[][$Head1] = "Company Name: ".stripslashes($arryStatement[0]['CustomerCompany']);
	if(!empty($arryStatement[0]['Address']))  $data[][$Head1] =  "Address : ".stripslashes($arryStatement[0]['Address']).",";
	if(!empty($arryStatement[0]['City']))  $data[][$Head1] =  "City : ".stripslashes($arryStatement[0]['City']);
	if(!empty($arryStatement[0]['State']))  $data[][$Head1] = "State : ".stripslashes($arryStatement[0]['State']);
	if(!empty($arryStatement[0]['Country']))  $data[][$Head1] = "Country : ".stripslashes($arryStatement[0]['Country']);
	if(!empty($arryStatement[0]['ZipCode']))  $data[][$Head1] = "ZipCode : ".stripslashes($arryStatement[0]['ZipCode']);
    if(!empty($arryStatement[0]['Landline']))  $data[][$Head1] = "Landline : ".stripslashes($arryStatement[0]['Landline']);
    if(!empty($arryStatement[0]['Fax']))  $data[][$Head1] = "Fax : ".stripslashes($arryStatement[0]['Fax']);
	if(!empty($arryStatement[0]['Email']))  $data[][$Head1] = "Email : ".stripslashes($arryStatement[0]['Email']);
	


	$pdf->ezSetDy(-10);
	//$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	//$EndCd = $pdf->y;
	//$RightY = $StartCd - $EndCd;
	$pdf->ezSetDy(-5);

        $Head1 = '<b>Customer</b>';$Head2 = '<b>Invoice Date</b>'; $Head3 = '<b>Invoice Number</b>'; $Head4 = '<b>Balance</b>';
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;
        $data[] = $arryDef[$i];
        $i++;
            $arryDef[$i][$Head1] = stripslashes($arryStatement[0]["CustomerName"]);
            $arryDef[$i][$Head2] = stripslashes($arryStatement[0]["InvoiceDate"]);
            $arryDef[$i][$Head3] = stripslashes($arryStatement[0]["InvoiceID"]);
            $arryDef[$i][$Head4] = number_format($arryStatement[0]["TotalInvoiceAmount"],2);         
            $data[] = $arryDef[$i];
            $TotalAmount = $arryStatement[0]["TotalInvoiceAmount"];
            $i++;
            $TotalAmount = number_format($TotalAmount,2);
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'160'),$Head2=>array('justification'=>'left','width'=>'115'),$Head3=>array('justification'=>'left','width'=>'105'),$Head4=>array('justification'=>'right','width'=>'100')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
        $TotalTxt =  "Total Received Amount : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));


	/***********************************/
	//echo $pdf->ezStream();exit;
  
	// or write to a file

	$file_path = 'upload/pdf/'.$arryStatement[0]['InvoiceID'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);
        if($AttachFlag!=1){
	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;
        }
?>
