<?	require_once("../includes/pdf_comman.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix."classes/lead.class.php");
include_once("includes/FieldArray.php");
	$objLead=new lead();
	$objGroup = new group();


    $arryTicket = $objLead->ListTicket($_GET);
    



	$NumLine = sizeof($arryTicket);

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
   
        $Head1 ='<b>Title</b>';$Head2 ='<b>Assign To</b>'; $Head3 = '<b>Status</b>'; $Head4 = '<b>Created On</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryTicket[$Count]["title"]);
			//$arryDef[$i][$Head2] = stripslashes($arryTicket[$Count]["AssignedTo"]);
			
			$salesPerson="";
			if(stripslashes($arryTicket[$Count]['AssignType'])=="User")
			{
				//echo 'sadsadfsaf';exit;
				$arryAssignee = $objLead->GetAssigneeUser($arryTicket[$Count]['AssignedTo']);
	            //echo "<pre>";print_r($arryAssignee);exit;
			  
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                     $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                                   /// echo $salesPerson;exit;
                                    
				                 $arryDef[$i][$Head2] =$salesPerson;
				
			}
			else if($arryTicket[$Count]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryTicket[$Count]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                                $arryDef[$i][$Head2] =$AssignName;
		}
			
		else 
			{
			$arryDef[$i][$Head2] = stripslashes($arryTicket[$Count]["UserName"]);
			}
		$arryDef[$i] [$Head3]= stripslashes($arryTicket[$Count]["Status"]);
			$arryDef[$i][$Head4]= ($arryTicket[$Count]['ticketDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryTicket[$Count]["ticketDate"]))):(" ");
			//$arryDef[$i][$Head4] = stripslashes($arryTicket[$Count]["ticketDate"]);
		
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'120'),$Head2=>array('justification'=>'left','width'=>'160'),$Head3=>array('justification'=>'left','width'=>'100'),$Head4=>array('justification'=>'left','width'=>'120')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }


	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/Tickets.pdf';
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

