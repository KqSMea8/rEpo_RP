<?	
	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/quote.class.php");
	include_once("includes/FieldArray.php");
	$objQuote=new quote();
	/*************************/
	
	$arryQuote=$objQuote->ListQuote('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);


	$NumLine = sizeof($arryQuote);
	$ModuleName =$_GET['module'];
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	 $Title = $ModuleName;
	HeaderTextBox($pdf,$Title,$arryCompany);
      
	//$YCordLine = $pdf->y-5; 
      
	$pdf->line(50,$YCordLine,92,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0)
    {
   
      $Head1 ='<b>Subject</b>';$Head2 ='<b>Quote Stage </b>'; $Head3 = '<b>Valid Till</b>'; $Head4 = '<b>Amount</b>';  $Head5 = '<b>Currency</b>'; $Head6 = '<b>Created Date</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5;$arryDef[$i][$Head6]=$Head6;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
          	$arryDef[$i][$Head1] = stripslashes($arryQuote[$Count]["subject"]);
			$arryDef[$i][$Head2] = stripslashes($arryQuote[$Count]["quotestage"]);
			
			
			$validtill=($arryQuote[$Count]["validtill"]>0)?(date($_SESSION['DateFormat'], strtotime($arryQuote[$Count]["validtill"]))):("");
			$arryDef[$i] [$Head3]=$validtill;
			
			
			
			
			$arryDef[$i] [$Head4]= stripslashes($arryQuote[$Count]["TotalAmount"]);
			$arryDef[$i][$Head5] = stripslashes($arryQuote[$Count]["CustomerCurrency"]);
			$PostedDate=($arryQuote[$Count]["PostedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryQuote[$Count]["PostedDate"]))):("");
			
			
			
			$arryDef[$i][$Head6] =$PostedDate;
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'105'),$Head2=>array('justification'=>'left','width'=>'80'),$Head3=>array('justification'=>'left','width'=>'70'),$Head4=>array('justification'=>'left','width'=>'90'),$Head5=>array('justification'=>'left','width'=>'95'),$Head6=>array('justification'=>'left','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }

 
	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/Quotes.pdf';
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	//ECHO $file_path;EXIT;
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1)
	{
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>
