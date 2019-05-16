<?	
require_once("../includes/pdf_comman.php");
require_once($Prefix."classes/lead.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();
$ModuleName = "Campaign";
$objLead = new lead();


	$arryCampaign=$objLead->ListCampaign('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	
//echo "<pre>";print_r($arryCampaign);exit;

	$NumLine = sizeof($arryCampaign);

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
   
        $Head1 ='<b>Campaign Name</b>';$Head2 ='<b>Campaign Type</b>'; $Head3 = '<b>Campaign Status</b>'; $Head4 = '<b>Expected Revenue [USD]</b>';$Head5= '<b> 	Expected Close Date</b>';$Head6 = '<b> 	Assign To</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5;$arryDef[$i][$Head6]=$Head6;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryCampaign[$Count]["campaignname"]);
			$arryDef[$i][$Head2] = stripslashes($arryCampaign[$Count]["campaigntype"]);
			$arryDef[$i] [$Head3]= stripslashes($arryCampaign[$Count]["campaignstatus"]);
			$arryDef[$i] [$Head4]= stripslashes($arryCampaign[$Count]["expectedrevenue"]);
			
			
				
			$closingdate=($arryCampaign[$Count]["closingdate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryCampaign[$Count]["closingdate"]))):("");
			$arryDef[$i] [$Head5]=$closingdate;
			$arryDef[$i] [$Head6]= stripslashes($arryCampaign[$Count]["AssignTo"]);
			
					
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'100'),$Head2=>array('justification'=>'left','width'=>'90'),$Head3=>array('justification'=>'left','width'=>'100'),$Head4=>array('justification'=>'left','width'=>'90')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }


	/***********************************/
	$file_path = 'upload/pdf/'."CampaignListpdf.pdf";
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

