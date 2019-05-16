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
$filename = "Opportunity_List_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';


echo '<tr align="left"><th>Opportunity Name</th><th>Sales Stage</th><th>Lead Source</th><th>Created Date</th><th>Expected Close Date</th><th>Assign TO</th><th>Status</th></tr>';

if($num>0)
{
	$salesPerson="";
	$Status="";
	foreach($arryOpportunity as $key=>$values)
	{
	      
             //$UserName=$values["FirstName"]." ".$values["LastName"];   // ABid

           $AddedDate= ($values['AddedDate']>0)?(date($_SESSION['DateFormat'], strtotime($values["AddedDate"]))):(" ");
			$CloseDate= ($values['CloseDate']>0)?(date($_SESSION['DateFormat'], strtotime($values["CloseDate"]))):("");
			if($values['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
	
			  		if(!empty($arryAssignee)) {
                                                    foreach ($arryAssignee as $key => $values1)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values1['UserName']. ",";
                                                    
                                                        
                                                    }	
					}			
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
	    if($values['Status'] ==1)
		 {
			  $Status = 'Active';
		 }
		 else
		 {
			  $Status = 'InActive';
		 }
		

echo '<tr><td>'.$values['OpportunityName'].'</td><td>'.$values['SalesStage'].'</td><td>'.$values['lead_source'].'</td><td>'.$AddedDate.'</td><td>'.$CloseDate.'</td><td>'.$salesPerson.'</td><td>'.$Status.'</td></tr>';
	$salesPerson="";
	}
}



echo '</table>';
echo "</body>";
echo "</html>";
?>
