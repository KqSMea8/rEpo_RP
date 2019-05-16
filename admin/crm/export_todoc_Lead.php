<?php
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/group.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();
$objGroup=new group();

/*************************/
$arryLead=$objLead->ListLead('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

$filename = "Lead_List_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';


echo '<tr align="left"><th>Lead Name</th><th>Company</th><th>Phone</th><th>PrimaryEmail</th><th>Status</th><th>Created Date</th></tr>';

if($num>0){
	foreach($arryLead as $key=>$values){


		$CreatedDate = ($values['UpdatedDate']>0)?(date($Config['DateFormat'], strtotime($values['UpdatedDate']))):("");
		$GetDate = "\"" . $CreatedDate . "\"";
   $name=stripslashes($values["FirstName"])." ".stripslashes($values["LastName"]);

 $FullName = "\"" . $name . "\"";
 $company=stripslashes($values["company"]);
 $companyName = "\"" . $company . "\"";
 $LandlineNumber=stripslashes($values["LandlineNumber"]);
  $PhoneNumber = "\"" . $LandlineNumber . "\"";

echo '<tr><td>'.$name.'</td><td>'.$company.'</td><td>'.$LandlineNumber.'</td><td>'.$values['primary_email'].'</td><td>'.$values["lead_status"].'</td><td>'.$CreatedDate.'</td></tr>';
	}
}



echo '</table>';
echo "</body>";
echo "</html>";
?>
