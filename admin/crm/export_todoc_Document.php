<?php
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/lead.class.php");
include_once("includes/FieldArray.php");
$objLead=new lead();

/*************************/

$arryDocument=$objLead->ListDocument('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

$filename = "Documents_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");



echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="2" width="100%">';


echo '<tr align="left"><th>Title</th><th>description</th><th>AddedDate</th><th>status</th></tr>';

if($num>0)
{
foreach($arryDocument as $key=>$values)
	{
		if($values['Status'] ==1){
			  $status = 'Active';
			
		 }else{
			  $status = 'InActive';
			    
		 }
		 $AddedDate = ($values['AddedDate']>0)?(date($Config['DateFormat'], strtotime($values['AddedDate']))):("");
	
	
echo '<tr><td>'.$values['title'].'</td><td>'.$values['description'].'</td><td>'.$AddedDate.'</td><td>'.$status.'</td></tr>';	
}
}
echo '</table>';
echo "</body>";
echo "</html>";

?>
