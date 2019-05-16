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


/*************************/

if($_GET['flage']==1)
{
$filename = "LeadList_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";
$del="\t";
$delm="\t";
}
else if($_GET['flage']==2)
{
	$filename = "LeadList_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";
	$del=",";
	$delm=",";
}

//$filename = "LeadList_".date('d-m-Y').".xls";
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

	$header = "Lead Name $del Company $del Phone $del PrimaryEmail $del Status $del Created Date";

	$data = '';
	foreach($arryLead as $key=>$values){


		$CreatedDate = ($values['UpdatedDate']>0)?(date($Config['DateFormat'], strtotime($values['UpdatedDate']))):(NOT_SPECIFIED);
		$GetDate = "\"" . $CreatedDate . "\"";
   $name=stripslashes($values["FirstName"])." ".stripslashes($values["LastName"]);

 $FullName = "\"" . $name . "\"";
 $company=stripslashes($values["company"]);
 $companyName = "\"" . $company . "\"";
 $LandlineNumber=stripslashes($values["LandlineNumber"]);
  $PhoneNumber = "\"" . $LandlineNumber . "\"";
 
		$line = $FullName.$delm.$companyName.$delm.$PhoneNumber.$delm.stripslashes($values['primary_email']).$delm.stripslashes($values["lead_status"]).$delm.$GetDate.$delm;

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data";         

}else{
	echo "No record found.";
}
exit;
?>

