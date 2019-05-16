<?	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
	include_once("includes/FieldArray.php");

	$ModuleName = "Opportunity";
	$objLead = new lead();
	$objGroup = new group();
	$arryOpportunity = $objLead->ListOpportunity('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
	
	 
   // echo "<pre>";print_r($arryOpportunity);exit;
	//$arryLead=$objLead->ListLead('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
  
	$NumLine = sizeof($arryOpportunity);

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
   
        $Head1 ='<b>Opportunity Name </b>';$Head2 ='<b>Sales Stage </b>'; $Head3 = '<b>Lead Source </b>'; $Head4 = '<b>Created Date</b>';  $Head5 = '<b>Expected Close Date</b>';$Head6 = '<b>Assign To</b>'; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5;$arryDef[$i][$Head6]=$Head6;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryOpportunity[$Count]["OpportunityName"]);
			$arryDef[$i][$Head2] = stripslashes($arryOpportunity[$Count]["SalesStage"]);
			$arryDef[$i] [$Head3]= stripslashes($arryOpportunity[$Count]["lead_source"]);
			//$arryDef[$i][$Head4] = stripslashes($arryOpportunity[$Count]["AddedDate"]);
			$arryDef[$i][$Head4]= ($arryOpportunity[$Count]['AddedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryOpportunity[$Count]["AddedDate"]))):("Not specified");
			
			//$arryDef[$i][$Head5] = stripslashes($arryOpportunity[$Count]["CloseDate"]);
			
			
			$arryDef[$i][$Head5]= ($arryOpportunity[$Count]['CloseDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryOpportunity[$Count]["CloseDate"]))):("Not specified");
	//$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("Not specified");
			
			
			
			
		//$arryDef[$i][$Head6] = stripslashes($arryOpportunity[$Count]["UserName"]);
			
			$salesPerson="";
			if($arryOpportunity[$Count]['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryOpportunity[$Count]['AssignTo']);
	
			  		if(!empty($arryAssignee)) {
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                       }
				$arryDef[$i][$Head6] =$salesPerson;
				
			}
			else if($arryOpportunity[$Count]['AssignType']=='Group')
                                           {
                                       $AssignName='';
					if(!empty($arryLead[$Count]['GroupID'])){
                                            $arryGrp = $objGroup->getGroup($arryLead[$Count]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
					}
                                                $arryDef[$i][$Head6] =$AssignName;
		}
			else 
			{
			$arryDef[$i][$Head6] = stripslashes($arryOpportunity[$Count]["UserName"]);
			}
		
			
			
			
		
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'80'),$Head2=>array('justification'=>'left','width'=>'100'),$Head3=>array('justification'=>'left','width'=>'70'),$Head4=>array('justification'=>'left','width'=>'70'),$Head5=>array('justification'=>'left','width'=>'70'),$Head6=>array('justification'=>'left','width'=>'110')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }

 
	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/Opportunity.pdf';
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
