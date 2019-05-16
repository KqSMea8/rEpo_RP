<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/item.class.php");

		
	$objLead=new lead();
	$objItems=new items();
	$objEmployee=new employee();
	$Module = "Campaign";
		
	
		
	$arryCampaign = $objLead->GetCampaign($_GET['campaignID'],'');
	
    //echo "<pre>";	print_r($arryCampaign);exit;
	if(!empty($arryCampaign[0]['assignedTo']))
		{
		$arryEmp = $objEmployee->GetEmployeeBrief($arryCampaign[0]['assignedTo']);
		//print_r($arryEmp);
		}
		if(!empty($arryCampaign[0]['product']))
			{
					$arryProduct=$objItems->GetItems($arryCampaign[0]['product'],'',1,'');
			}
 

	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	
	     	
	
	
	
	 $Title ="Campaign # ".$arryCampaign[0]['campaignname'];
	 HeaderTextBox($pdf,$Title,$arryCompany);
	//$UpdatedDate = ($arryLead[0]['UpdatedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['UpdatedDate']))):("");
	///$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("");
	$closingdate=($arryCampaign[0]['closingdate']>0)?(date($_SESSION['DateFormat'], strtotime($arryCampaign[0]['closingdate']))):("");

	$product=(stripslashes($arryProduct[0]['description']).' '.stripslashes($arryProduct[0]['Sku']).']');
	
 

	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Campaign Name:", $Head2 => $arryCampaign[0]['campaignname']),
		array($Head1 => "Assigned To :", $Head2 =>  $arryEmp[0]['UserName']),
		array($Head1 => "Campaign Status:", $Head2 => $arryCampaign[0]['campaignstatus']),
		array($Head1 => "Campaign Type:", $Head2 => $arryCampaign[0]['campaigntype']),

		array($Head1 => "Product:", $Head2 =>$product),
		array($Head1 => "Target Audience:", $Head2 => $arryCampaign[0]['targetaudience']),
		array($Head1 => "Expected Close Date:", $Head2 =>$closingdate),
      array($Head1 => "Target Size:", $Head2 => $arryCampaign[0]['targetsize']),
      array($Head1 => "Sponsor:" , $Head2 => $arryCampaign[0]['sponsor']),
		array($Head1 => "Num Sent (%):" , $Head2 => $arryCampaign[0]['numsent']),
		array($Head1 => "Budget Cost: (USD):", $Head2 => $arryCampaign[0]['budgetcost']),
		
		array($Head1 => "Actual Cost: (USD) :", $Head2 => $arryCampaign[0]['actualcost']),
		array($Head1 => "Expected Response:", $Head2 => $arryCampaign[0]['expectedresponse']),
			array($Head1 => "Expected Revenue: (USD) :", $Head2 => $arryCampaign[0]['expectedrevenue']),
		array($Head1 => "Expected Sales Count:", $Head2 => $arryCampaign[0]['expectedsalescount']),
		array($Head1 => "Actual Sales Count:", $Head2 => $arryCampaign[0]['actualsalescount']),
		
			array($Head1 => "Expected Response Count:", $Head2 => $arryCampaign[0]['expectedresponsecount']),
		array($Head1 => "Actual Response Count ::", $Head2 => $arryCampaign[0]['actualresponsecount']),
		
		array($Head1 => "Expected ROI: (USD):", $Head2 => $arryCampaign[0]['expectedroi']),
		array($Head1 => "Actual ROI: (USD) :", $Head2 => $arryCampaign[0]['actualroi']),

		array($Head1 => "Description:" , $Head2 =>$arryCampaign[0]['description'])

		
		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	
	
	
	
	
	
	$file_path = 'upload/pdf/'.$arryCampaign[0]['campaignID'].".pdf";
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



