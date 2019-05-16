<?php  	
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/quote.class.php");
include_once("includes/FieldArray.php");
$objQuote=new quote();

/*************************/

$arryQuote=$objQuote->ListQuote('',$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);

/*************************/
$num=$objQuote->numRows();

/*$pagerLink=$objPager->getPager($arryOpportunity,$RecordsPerPage,$_GET['curP']);
(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");
/*************************/

$filename = "Quotes_List_".date('d-m-Y').".doc";
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$filename");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo '<table cellpadding="0" cellspacing="0" border="1" width="100%">';


echo '<tr align="left"><th>Subject</th><th>Quote Stage</th><th>Opportunity Name</th><th>Valid Till</th><th>Total</th><th>Created Date</th></tr>';

if($num>0)
{
	
	
	foreach($arryQuote as $key=>$values)
	{

         $total_ammount= stripslashes($values["TotalAmount"]) ." ".$values['CustomerCurrency'];
$validtill = ($values['validtill']>0)?(date($Config['DateFormat'], strtotime($values['validtill']))):(" ");
$PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):(" ");;
//$PostedDate = date($Config['DateFormat'] , strtotime($values["PostedDate"]));

//$validtill =$values["validtill"];
//$PostedDate =$values["PostedDate"];

       //$assignee = stripslashes($values["UserName"]) .$Comma.$values["Department"]; // Abid

echo '<tr><td>'.$values["subject"].'</td><td>'.$values['quotestage'].'</td><td>'.$values["opportunityName"].'</td><td>'.$validtill.'</td><td>'.$total_ammount.'</td><td>'.$PostedDate.'</td></tr>';

	}
}



echo '</table>';
echo "</body>";
echo "</html>";
?>
