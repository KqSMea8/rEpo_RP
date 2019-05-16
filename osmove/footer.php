<?
 // select TempPass from company  where CmpID='37'
$TempPass = rand(9,99999);
$sqlPdf = "update company set TempPass='".$TempPass."' where CmpID='37'";
mysql_query($sqlPdf);die;

?>
