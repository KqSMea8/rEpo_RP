<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
		$objLead=new lead();
		$objGroup = new group();

	$arryLead =$objLead->GetLead($_GET['leadid'],'');
	//echo "<pre>";print_r($arryLead);exit;
	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	
	$salesPerson="";
			if($arryLead[0]['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryLead[0]['AssignTo']);
	
			  
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                    
				$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if($arryLead[0]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryLead[0]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                               $salesPerson=$AssignName;
		}
			else 
			{
			$salesPerson= stripslashes($arryLead[0]["UserName"]);
			}
	
	
	
	
	 $Title ="Lead # ".$arryLead[0]['LeadName'];
	 HeaderTextBox($pdf,$Title,$arryCompany);
	$UpdatedDate = ($arryLead[0]['UpdatedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['UpdatedDate']))):("");
	$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("");
	$LastContactDate=($arryLead[0]['LastContactDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LastContactDate']))):("");


	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Lead Name :", $Head2 => $arryLead[0]['LeadName']),
		array($Head1 => "Created Date :", $Head2 => $UpdatedDate),
		array($Head1 => "Type :", $Head2 => $arryLead[0]['type']),
		array($Head1 => "Company :", $Head2 => $arryLead[0]['company']),
		array($Head1 => "Email :", $Head2 => $arryLead[0]['primary_email']),
		array($Head1 => "Title :", $Head2 => $arryLead[0]['designation']),
		array($Head1 => "Product Price(".$arryLead[0]['Currency'].") :", $Head2 => $arryLead[0]['product_price']),
		
	
		array($Head1 => "Website :", $Head2 => $arryLead[0]['Website']),
		array($Head1 => "Industry :", $Head2 => $arryLead[0]['Industry']),
		array($Head1 => "Annual Revenue(".$arryLead[0]['Currency'].") :", $Head2 => $arryLead[0]['AnnualRevenue']),
		array($Head1 => "Number of Employee :" , $Head2 => $arryLead[0]['NumEmployee']),
		array($Head1 => "Lead Source :", $Head2 => $arryLead[0]['lead_source']),
			
		
		//array($Head1 => "Assign To  :", $Head2 => $arryLead[0]['AssignTo']),
		
		array($Head1 => "Assign To  :", $Head2 =>$salesPerson),
		
		array($Head1 => "Status :", $Head2 => $arryLead[0]['lead_status']),
		array($Head1 => "Lead Date :", $Head2 =>$LeadDate),
		array($Head1 => "Last Contact Date :", $Head2 =>$LastContactDate)
		//array($Head1 => "Description :", $Head2 => stripslashes($arryLead[0]['description'])),



		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	

	$Head1 = '<b>'."Address Details".'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,125,$YCordLine);
	//$pdf->line(325,$YCordLine,405,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryLead[0]['Address']));
	
	
	unset($data);

	if(!empty($arryLead[0]['CustomerCompany']))  $data[][$Head1] = stripslashes($arryLead[0]['CustomerCompany']);
	if(!empty($Address))  $data[][$Head1] =  $Address.",";
	if(!empty($arryLead[0]['CountryName']))  $data[][$Head1] = stripslashes($arryLead[0]['CityName']).", ".stripslashes($arryLead[0]['StateName']).",\n".stripslashes($arryLead[0]['CountryName'])."-".stripslashes($arryLead[0]['ZipCode']).  "\nMobile No: ".stripslashes($arryLead[0]['Mobile'])."\nLandlineNumber: ".stripslashes($arryLead[0]['LandlineNumber']);

	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	
	
	
	
	$file_path = 'upload/pdf/'.$arryLead[0]['leadID'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1)
	{
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>
