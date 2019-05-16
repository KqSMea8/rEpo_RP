<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix . "classes/group.class.php");
         require_once($Prefix . "classes/filter.class.php");
         require_once($Prefix."classes/sales.customer.class.php");
		$objLead=new lead();
		$objGroup = new group();
		$objCustomer=new  Customer();
	$arryTicket = $objLead->GetTicket($_GET['TicketID'],'');
//echo	print_r($arryTicket);
	
		if(!empty($arryTicket[0]['CustID']))
		{
			$arryCustomer = $objCustomer->GetCustomer($arryTicket[0]['CustID'],'','');
		}
	//$arryLead =$objLead->GetLead($_GET['leadid'],'');
	//echo "<pre>";print_r($arryLead);exit;
	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	
	      $salesPerson="";
			if($arryTicket[0]['AssignType']=="Users")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryTicket[0]['AssignedTo']);
	
			  		if(!empty($arryAssignee)){
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                        }
				//$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if($arryTicket[0]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryLead[0]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                               $salesPerson=$AssignName;
		}
			else 
			{
			//$salesPerson= stripslashes($arryTicket[0]["UserName"]);
			}
	
	
	
	
	 $Title ="Ticket # ".stripslashes($arryTicket[0]['title']);
	 HeaderTextBox($pdf,$Title,$arryCompany);
	//$UpdatedDate = ($arryLead[0]['UpdatedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['UpdatedDate']))):("");
	///$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("");
	//$LastContactDate=($arryLead[0]['LastContactDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LastContactDate']))):("");

	$fullName = (isset($arryCustomer[0]['FullName'])) ? stripslashes($arryCustomer[0]['FullName']) : '';
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Title :", $Head2 => stripslashes($arryTicket[0]['title'])),
		array($Head1 => "Assigned To :", $Head2 => rtrim($salesPerson,', ')),
		array($Head1 => "Ticket Status  :", $Head2 => $arryTicket[0]['Status']),
		array($Head1 => "Priority :", $Head2 => $arryTicket[0]['priority']),
		array($Head1 => "Ticket Category :", $Head2 => $arryTicket[0]['category']),
		array($Head1 => "Days :", $Head2 => $arryTicket[0]['day']),
		array($Head1 => "Hours :", $Head2 => $arryTicket[0]['hours']),
		array($Head1 => "Customer :", $Head2 => $fullName),

		array($Head1 => "Description  :" , $Head2 => $arryTicket[0]['description']),
		array($Head1 => "Ticket Resolution(Solution) :", $Head2 => $arryTicket[0]['solution']),
		

	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	
	unset($data);

	
	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	
	$file_path = 'upload/pdf/'.$arryTicket[0]['TicketID'].".pdf";
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
