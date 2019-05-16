<?
$plusMinus = '+';
$timezoneValue = $plusMinus.'05:30:00';
$arryZone = explode(":",$timezoneValue);
list($hour, $minute, $second) = $arryZone;
$minute = ($minute*100)/60;
$hourMinute = ($hour.'.'.$minute)*3600;

$GMT = strtotime(gmdate("Y-m-d H:i:s"))+$hourMinute;
echo $CurrentDate = date("Y-m-d H:i:s",$GMT);
exit;



/*
date_default_timezone_set('Asia/Calcutta');
echo date("Y-m-d H:i:s");
*/
?>