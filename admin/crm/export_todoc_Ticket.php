<?php  	
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/group.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();
$objGroup=new group();
/*************************/
$arryTicket=$objLead->ListTicket($_GET);
$num=$objLead->numRows();

/*$pagerLink=$objPager->getPager($arryOpportunity,$RecordsPerPage,$_GET['curP']);
(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");
/*************************/

$filename = "TicketList_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="1" width="100%">';


echo '<tr align="left"><th>Title</th><th>AssignTo</th><th>Status</th><th>Created On</th></tr>';

if($num>0)
{
	
	
	foreach($arryTicket as $key=>$values)
	{

            $AssignTo = '';
		
		if($values['AssignType'] == 'Group') 
		{ 
			$arryGrp = $objGroup->getGroup($values['GroupID'],1);
			$AssignTo .= $arryGrp[0]['group_name'];
		}
		 else if(!empty($values['AssignedTo']))
		 { 
			$assignee = $values['AssignedTo'];
			$arryAssignee = $objLead->GetAssigneeUser($values['AssignedTo']);
			
		    foreach($arryAssignee as $values2)
		     {
			$AssignTo .= $values2['UserName'].', ';
		    }
		}
		$AssignTo = rtrim($AssignTo,",");
		

echo '<tr><td>'.$values["title"].'</td><td>'.$AssignTo.'</td><td>'.$values["Status"].'</td><td>'.date($Config['DateFormat'],strtotime($values["ticketDate"])).'</td></tr>';

	}
}



echo '</table>';
echo "</body>";
echo "</html>";
?>
