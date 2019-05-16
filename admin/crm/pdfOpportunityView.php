<?php	require_once("../includes/pdf_comman.php");
		require_once($Prefix."classes/lead.class.php");	
		require_once($Prefix . "classes/group.class.php");
		require_once($Prefix . "classes/filter.class.php");
		require_once($Prefix."classes/sales.customer.class.php");
		require_once($Prefix."classes/region.class.php");
		$objGroup = new group();
		//$objLead1=new lead();
		$objLead=new lead();
		$objCustomer=new Customer();
		$objRegion=new region();
   		$arryOpportunity = $objLead->GetOpportunity($_GET['OpportunityID'],'');

		if(!empty($arryOpportunity[0]['LeadID']))
		{
			$arryLead =$objLead->GetLead($arryOpportunity[0]['LeadID'],'');
		}
	
		if(empty($arryLead)){
			$arryLead = $objConfigure->GetDefaultArrayValue('c_lead');
		}
	

		$CustomerName='';
		if(!empty($arryOpportunity[0]['CustID']))
		{
			$arryCustomer = $objCustomer->GetCustomer($arryOpportunity[0]['CustID'],'','');

			$CustomerName = !empty($arryCustomer[0]['FullName'])?$arryCustomer[0]['FullName']:"";
		}
		//echo "<pre>";print_r($arryOpportunity);exit;
		//echo "<pre>";print_r($arryLead);exit;
		$pdf = new Creport('a4','portrait');
		$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
		$pdf->ezSetMargins(20,20,50,50);

	
	 $Title ="Opportunity# ".$arryOpportunity[0]['OpportunityName'];
	 HeaderTextBox($pdf,$Title,$arryCompany);
	$OpportunityDate = (isset($arryOpportunity[0]['CloseDate']) && $arryOpportunity[0]['CloseDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryOpportunity[0]['CloseDate']))):("");
	$AddedDate=(isset($arryOpportunity[0]['AddedDate']) && $arryOpportunity[0]['AddedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryOpportunity[0]['AddedDate']))):("");
	$LastContactDate=(isset($arryOpportunity[0]['LastContactDate']) && $arryOpportunity[0]['LastContactDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryOpportunity[0]['LastContactDate']))):("");
	
	//echo $LastContactDate;exit;
	
	
	$salesPerson="";
			if($arryOpportunity[0]['AssignType']=="Users")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryOpportunity[0]['AssignTo']);
	
  										if($arryAssignee){
		                                    foreach ($arryAssignee as $key => $values)
		                                    {                                                 
		                                      $salesPerson .= $values['UserName']. ", ";
		                                      
		                                    }
                        				}
				//$arryDef[0][$Head6] =$salesPerson;
				
			}
			else if($arryOpportunity[0]['AssignType']=='Group')
                                           {
                                       
                                            $arryGrp = $objGroup->getGroup($arryOpportunity[0]['GroupID'], 1);
                                                $salesPerson = $arryGrp[0]['group_name'];
                                               // $arryDef[$i][$Head6] =$AssignName;
		}
			else if(!empty($arryOpportunity[0]["UserName"]))
			{
			$salesPerson = stripslashes($arryOpportunity[0]["UserName"]);
			}
	
	
	
	$salesPerson = rtrim($salesPerson,', ');
	if($arryOpportunity[0]['Status'] == 1) {
           $Status = 'Active';
        }else{
           $Status = 'Inactive';
        }
	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Opportunity Name :", $Head2 => $arryOpportunity[0]['OpportunityName']),
		array($Head1 => "Created Date :", $Head2 =>$AddedDate),
		
		array($Head1 => "Organization Name :", $Head2 => $arryOpportunity[0]['OrgName']),
		array($Head1 => "Amount (DZD) :", $Head2 => $arryOpportunity[0]['Amount']),
		array($Head1 => "Expected Close Date :", $Head2 =>$OpportunityDate),
		array($Head1 => "Sales Stage :", $Head2 => $arryOpportunity[0]['SalesStage']),
		
	
		//array($Head1 => "Assigned To :", $Head2 => $arryOpportunity[0]['UserName']),
		
		array($Head1 => "Assigned To :", $Head2 => $salesPerson),
		
		array($Head1 => "Customer :", $Head2 => $CustomerName),
		array($Head1 => "Lead Source :", $Head2 => $arryOpportunity[0]['lead_source']),
		array($Head1 => "Next Step :" , $Head2 => $arryOpportunity[0]['NextStep']),
		array($Head1 => "Opportunity Type :", $Head2 => $arryOpportunity[0]['OpportunityType']),
		array($Head1 => "Probability (%)  :", $Head2 => $arryOpportunity[0]['Probability']),
		array($Head1 => "Campaign Source  :", $Head2 => $arryOpportunity[0]['Campaign_Source']),
		array($Head1 => "Forecast Amount :", $Head2 => $arryOpportunity[0]['forecast_amount']),
		array($Head1 => "Contact Name :", $Head2 => $arryOpportunity[0]['ContactName']),
		array($Head1 => "Website :", $Head2 => $arryOpportunity[0]['oppsite']),
		array($Head1 => "Status :", $Head2 => $Status),

		array($Head1 => "Lead Date :", $Head2 => $arryLead[0]['LeadDate']),
		array($Head1 => "Last Contact Date :", $Head2 => $arryLead[0]['LastContactDate']),
		array($Head1 => "Industry :", $Head2 => $arryLead[0]['Industry'])
		
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
     //echo print_r($arryLead);
	//if(!empty($arryLead[0]['CustomerCompany']))  $data[][$Head1] = stripslashes($arryLead[0]['CustomerCompany']);
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();

	$CountryName=$StateName=$CityName='';
	if(!empty($arryLead[0]['country_id'])) 
	{
	$arryCountryName = $objRegion->GetCountryName($arryLead[0]['country_id']);
	$CountryName = stripslashes($arryCountryName[0]["name"]);
	}

	if(!empty($arryLead[0]['state_id'])) 
	{
	$arryState = $objRegion->getStateName($arryLead[0]['state_id']);
	$StateName = stripslashes($arryState[0]["name"]);
	}
	else if(!empty($arryLead[0]['OtherState'])){
	$StateName = stripslashes($arryLead[0]['OtherState']);
	}

	if(!empty($arryLead[0]['city_id']))
	 {
	$arryCity = $objRegion->getCityName($arryLead[0]['city_id']);
	$CityName = stripslashes($arryCity[0]["name"]);
	}
	else if(!empty($arryLead[0]['OtherCity']))
	{
	$CityName = stripslashes($arryLead[0]['OtherCity']);
	}
	
	//echo 'jhajdjkkfk';
	
	
	if(!empty($Address))  $data[][$Head1] =  $Address.",";
  $data[][$Head1] =$CityName.", ".$StateName.",\n".$CountryName."-".stripslashes($arryLead[0]['ZipCode'])."\nMobile No: ".stripslashes($arryLead[0]['Mobile'])."\nLandlineNumber: ".stripslashes($arryLead[0]['LandlineNumber']);

	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	
 
	$file_path = 'upload/pdf/'.$arryOpportunity[0]['OpportunityID'].".pdf";
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
