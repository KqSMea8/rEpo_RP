<?php
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();

/*************************/
$arryCampaign=$objLead->ListCampaign('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

$filename = "CampainList_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';

echo '<tr align="left"><th>Campaign Name</th><th>Campaign Type</th><th>Campaign Status</th><th>Expected Revenue</th><th>Expected Close Date</th><th>Assign To</th></tr>';

if($num>0)
{
foreach($arryCampaign as $key=>$values)
	{
		/*if($values['Status'] ==1)
		{
			  $status = 'Active';
		 }
		 else
		 {
			  $status = 'InActive';
		 } */


		  $closingdate= ($values['closingdate']>0)?(date($_SESSION['DateFormat'], strtotime($values["closingdate"]))):(" ");
		 
	
	
echo '<tr><td>'.$values['campaignname'].'</td><td>'.$values['campaigntype'].'</td><td>'.$values['campaignstatus'].'</td><td>'.$values['expectedrevenue'].'</td><td>'.$closingdate.'</td><td>'.$values["AssignTo"].'</td></tr>';	
}
}
echo '</table>';
echo "</body>";
echo "</html>";

?>

