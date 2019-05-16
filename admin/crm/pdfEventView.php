<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

	require_once($Prefix."classes/event.class.php");
		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix."classes/region.class.php");
		require_once($Prefix."classes/employee.class.php");
		require_once($Prefix."classes/group.class.php");
		require_once($Prefix."classes/sales.customer.class.php");	
	
	  $ModuleName = "Activity";
		
	$objActivity=new activity();
	$objLead=new lead();
	$objRegion=new region();
	$objEmployee=new employee();
        $objGroup=new group();
	$objCustomer=new Customer(); 
		
	 $arryActivity = $objActivity->GetActivity($_GET['activityID'],'');
	 //echo "<pre>";	print_r($arryActivity);
	
	 //$arryContact = $objCustomer->GetContactAddress($_GET['CustID'],'');
		$CustomerFullName='';$Campaign='';
		if(!empty($arryActivity[0]['CustID']))
		{
			$arryCustomer = $objCustomer->GetCustomer($arryActivity[0]['CustID'],'','');
			$CustomerFullName = (!empty($arryCustomer[0]['FullName']))?($arryCustomer[0]['FullName']):('');
		}

		if(!empty($arryActivity[0]['CampaignID']))
		{
			$arryCampaign = $objLead->GetCampaign($arryActivity[0]['CampaignID'],'');
			$Campaign = (!empty($arryCampaign[0]['campaignname']))?($arryCampaign[0]['campaignname']):('');
		}

 
		
		
		$salesPerson="";
			if($arryActivity[0]['AssignType']=="User")
			{
		
				$arryAssignee = $objLead->GetAssigneeUser($arryActivity[0]['assignedTo']);
				
	
			  
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                    
				$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if($arryActivity[0]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryActivity[0]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                               $salesPerson=$AssignName;
		}
			else if(!empty($arryLead[0]["UserName"]))
			{
			$salesPerson= stripslashes($arryLead[0]["UserName"]);
			}
		
		
	  
		
		
		//$arryEmployee = $objEmployee->GetEmployeeBrief($arryActivity[0]['AssignTo']);
	//$arryLead =$objLead->GetLead($_GET['leadid'],'');
	//echo "<pre>";print_r($arryCustomer);exit;
	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	 $Title =" Event";
	 HeaderTextBox($pdf,$Title,$arryCompany);
	 $startDate=($arryActivity[0]["startDate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryActivity[0]["startDate"]))):("");
	 $closeDate=($arryActivity[0]["closeDate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryActivity[0]["closeDate"]))):("");
	//$UpdatedDate = ($arryLead[0]['UpdatedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['UpdatedDate']))):("");
	///$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("");
	//$LastContactDate=($arryLead[0]['LastContactDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LastContactDate']))):("");




 if($arryActivity[0]['reminder']==1)
        {

$reminder="Yes";
}
else
{
$reminder="No";
}

 if($arryActivity[0]['Notification']==1)
 { $Notification="Yes";
 }
 else
 {
 	$Notification="No";
 }
 	   $ActUrl='';
           $arryActEmp=$objActivity->getActivityEmp2($_GET['activityID'],'');
			foreach($arryActEmp as $values)
			{
			  $ActUrl .=$values['UserName']. ", ";
			}
		
if($arryActivity[0]['EntryType'] == "recurring")

{
$EntryType= "Recurring";
}
                 else
                 { 
                 	
                 $EntryType="One Time";
                 }


	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Entry Type:", $Head2 => $EntryType),
		array($Head1 => "Subject:", $Head2 =>  $arryActivity[0]['subject']),
		array($Head1 => "Assigned To:", $Head2 =>$salesPerson),
		array($Head1 => "Start Date & Time:", $Head2 =>$startDate." " .$arryActivity[0]["startTime"]),
	
		array($Head1 => "Close Date & Time :", $Head2 => $closeDate." " .$arryActivity[0]["closeTime"]),
		array($Head1 => "Status:", $Head2 =>$arryActivity[0]['status']),
		array($Head1 => "Customer:", $Head2 => $CustomerFullName),
      array($Head1 => "Activity Type:", $Head2 => $arryActivity[0]['activityType']),
      array($Head1 => "Priority:" , $Head2 => $arryActivity[0]['priority']),
		array($Head1 => "Send Notification:" , $Head2 =>$Notification),
		array($Head1 => "Location :", $Head2 => $arryActivity[0]['location']),
		
		array($Head1 => "Visibility:", $Head2 => $arryActivity[0]['visibility']),
		array($Head1 => "Reminder:", $Head2 => $reminder),
		
		
		array($Head1 => "Invite Users:", $Head2 =>$ActUrl),
		array($Head1 => "Related Type:", $Head2 => $arryActivity[0]['RelatedType']),

		array($Head1 => "Campaign :", $Head2 => $Campaign),
		array($Head1 => "Description:", $Head2 => $arryActivity[0]['description']),
	
	); 
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	
	$file_path = 'upload/pdf/'.$_GET['activityID'].".pdf";
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



