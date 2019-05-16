<?php  	
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
include_once("includes/FieldArray.php");

	$ModuleName = "Opportunity";
	$objLead = new lead();
	$objGroup = new group();

/*************************/
$arryOpportunity=$objLead->ListOpportunity('',$_GET['key'],$_GET['sortby'],$_GET['asc']);

//echo "<pre>";print_r($arryOpportunity);

$num=$objLead->numRows();

/*$pagerLink=$objPager->getPager($arryOpportunity,$RecordsPerPage,$_GET['curP']);
(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");
/*************************/
if($_GET['flage']==1)
{
$filename = "Opportunity_List_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";
$del="\t";
$delm="\t";
}
else if($_GET['flage']==2)
{
	$filename = "Opportunity_List_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";
	$del=",";
	$delm=",";
}

//$filename = "Opportunity_List_".date('d-m-Y').".xls";
if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: $contanttype");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	
	$header = "Opportunity Name $delm Sales Stage $delm Lead Source $delm Created Date $delm Expected Close Date $delm Assign TO $delm Status";

	$data = '';
	$salesPerson="";
	$Status="";
	foreach($arryOpportunity as $key=>$values)
	{  
		
            #$UserName=$values["FirstName"]." ".$values["LastName"];  


           $AddedDate= ($values['AddedDate']>0)?(date($_SESSION['DateFormat'], strtotime($values["AddedDate"]))):(" ");
			
	
			//echo $AddedDate;exit;
			
			$CloseDate= ($values['CloseDate']>0)?(date($_SESSION['DateFormat'], strtotime($values["CloseDate"]))):("");
	//$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("Not specified");
			
			
			
			
		//$arryDef[$i][$Head6] = stripslashes($arryOpportunity[$Count]["UserName"]);
			
			
			if($values['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
	
			  		if(!empty($arryAssignee)) {
                                                    foreach ($arryAssignee as $key => $values1)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values1['UserName']. ",";
                                                    
                                                        
                                                    }
                                       }
				//$salesPerson =$salesPerson;
				
			}
			else if($values['AssignType']=='Group')
                                           {
                                       

                                               $arryGrp = $objGroup->getGroup($values['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                                $salesPerson=$AssignName;
                                                 
		                                      }
			else 
			{
			$salesPerson= stripslashes($values["UserName"]);
			}


		//$line = 	$values["OpportunityID"]."\t".$values["LeadID"]."\t".stripslashes($values['OpportunityName'])."\t".stripslashes($values['SalesStage'])."\t".stripslashes($values['lead_source'])."\t".date($Config['DateFormat'],strtotime($values["CloseDate"]))."\t".stripslashes($values["AssignTo"])."\t".$status."\n";
	    if($values['Status'] ==1)
		 {
			  $Status = 'Active';
		 }
		 else
		 {
			  $Status = 'InActive';
		 }
			
			
		$line = 
			"\"".$values['OpportunityName']."\"".$delm."\"".$values['SalesStage']."\"".$delm."\"".$values['lead_source']."\"".$delm."\"".$AddedDate."\"".$delm."\"".$values['CloseDate']."\"".$delm."\"".$salesPerson."\"".$delm."\"".$Status."\""."\n";

		$data .= trim($line)."\n";
		$salesPerson="";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

