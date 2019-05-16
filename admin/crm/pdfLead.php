<?	require_once("../includes/pdf_comman.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("includes/FieldArray.php");
	if($AttachFlag!=1)
	{
		require_once($Prefix."classes/lead.class.php");
	}

	$objLead=new lead();
	$objGroup = new group();

	
	$arryLead=$objLead->ListLead('',$_GET['key'],$_GET['sortby'],$_GET['asc']);

	//echo "<pre>";print_r($arryLead);exit;

	$NumLine = sizeof($arryLead);

	$ModuleName =ucfirst($_GET['module']);

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
   
        $Head1 ='<b>Lead Name </b>';$Head2 ='<b>Company </b>'; $Head3 = '<b>Phone </b>'; $Head4 = '<b>Primary Email</b>';  $Head5 = '<b>Sales Person</b>';$Head6 = '<b>Status</b>';$Head7 = '<b>Created Date</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5;$arryDef[$i][$Head6]=$Head6; $arryDef[$i][$Head7]=$Head7;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryLead[$Count]["LeadName"]);
			$arryDef[$i][$Head2] = stripslashes($arryLead[$Count]["company"]);
			$arryDef[$i] [$Head3]= stripslashes($arryLead[$Count]["LandlineNumber"]);
			$arryDef[$i][$Head4] = stripslashes($arryLead[$Count]["primary_email"]);
			$salesPerson="";
			if($arryLead[$Count]['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryLead[$Count]['AssignTo']);
	
			  		if(!empty($arryAssignee)) {
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                         }
				$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if($arryLead[$Count]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryLead[$Count]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                                $arryDef[$i][$Head5] =$AssignName;
		}
			else 
			{
			$arryDef[$i][$Head5] = stripslashes($arryLead[$Count]["UserName"]);
			}
		
			$arryDef[$i][$Head6] = stripslashes($arryLead[$Count]["lead_status"]);
			$arryDef[$i][$Head7] = stripslashes($arryLead[$Count]["UpdatedDate"]);
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'70'),$Head2=>array('justification'=>'left','width'=>'60'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'90'),$Head5=>array('justification'=>'left','width'=>'95'),$Head6=>array('justification'=>'left','width'=>'60'),$Head7=>array('justification'=>'right','width'=>'65')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }

 
	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'."Lead.pdf";
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
