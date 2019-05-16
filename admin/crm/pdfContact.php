<?	require_once("../includes/pdf_comman.php");
	require_once($Prefix . "classes/group.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	include_once("includes/FieldArray.php");
	$objLead=new lead();
	$objGroup = new group();
	$objCustomer=new Customer();

	 $arryContact=$objCustomer->ListCrmContact($_GET);
	//echo "<pre>";print_r($arryContact);exit;

	$NumLine = sizeof($arryContact);

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
   
        $Head1 ='<b>First Name </b>';$Head2 ='<b>Last Name</b>'; $Head3 = '<b>Email</b>'; $Head4 = '<b>Title</b>';  $Head5 = '<b>Assign To</b>';  $Head6 = '<b>Phone</b>'; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5; $arryDef[$i][$Head6]=$Head6;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryContact[$Count]["FirstName"]);
			$arryDef[$i][$Head2] = stripslashes($arryContact[$Count]["LastName"]);
			$arryDef[$i] [$Head3]= stripslashes($arryContact[$Count]["Email"]);
			$arryDef[$i][$Head4] = stripslashes($arryContact[$Count]["Title"]);
			$salesPerson="";
			if(!empty($arryLead[$Count]['AssignType']) && $arryLead[$Count]['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryLead[$Count]['AssignTo']);
	
			  
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                    
				$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if(!empty($arryLead[$Count]['AssignType']) && $arryLead[$Count]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryLead[$Count]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                                $arryDef[$i][$Head5] =$AssignName;
		}
			else 
			{
			  $UserName = (!empty($arryLead[$Count]["UserName"]))?(stripslashes($arryLead[$Count]["UserName"])):("");
			$arryDef[$i][$Head6] = $UserName;
			}
		
			$arryDef[$i][$Head5] = stripslashes($arryContact[$Count]["AssignTo"]);
			$arryDef[$i][$Head6] = stripslashes($arryContact[$Count]["Mobile"]);
		
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'90'),$Head2=>array('justification'=>'left','width'=>'80'),$Head3=>array('justification'=>'left','width'=>'120'),$Head4=>array('justification'=>'left','width'=>'30'),$Head5=>array('justification'=>'left','width'=>'120'),$Head6=>array('justification'=>'left','width'=>'70')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }


	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'."Contacts.pdf";
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

