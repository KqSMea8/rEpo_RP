<?	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/lead.class.php");
	include_once("includes/FieldArray.php");

	$objLead=new lead();

	(empty($_GET['parent_type']))?($_GET['parent_type']=""):(""); 
	(empty($_GET['parentID']))?($_GET['parentID']=""):(""); 

	$arryDocument=$objLead->ListDocument('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$NumLine = sizeof($arryDocument);

	$ModuleName =$_GET['module'];

  /*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,40,40);

	
	 $Title = $ModuleName;
	HeaderTextBox($pdf,$Title,$arryCompany);
      
	//$YCordLine = $pdf->y-5; 
      
	$pdf->line(50,$YCordLine,92,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0)
    {
   
        $Head1 ='<b>Title</b>';$Head2 ='<b>Description</b>'; $Head3 = '<b> 	Created On</b>'; $Head4 = '<b>Status</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryDocument[$Count]["title"]);
			$arryDef[$i][$Head2] = stripslashes($arryDocument[$Count]["description"]);
			
			
			//$arryDef[$i] [$Head3]= stripslashes($arryDocument[$Count]["AddedDate"]);
			
				
			$AddedDate=($arryDocument[$Count]["AddedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryDocument[$Count]["AddedDate"]))):("");
			$arryDef[$i] [$Head3]=$AddedDate;
			
			if( stripslashes($arryDocument[$Count]["Status"])==1)
			{
			$Status="Active";	
			}
			
			else 
			{
				$Status="InActive";
			}
			$arryDef[$i][$Head4] =$Status;
					
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'125'),$Head2=>array('justification'=>'left','width'=>'160'),$Head3=>array('justification'=>'left','width'=>'120'),$Head4=>array('justification'=>'left','width'=>'100')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }

 
	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/Documents.pdf';
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


