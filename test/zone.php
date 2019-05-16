<?
date_default_timezone_set('Asia/Calcutta');
$date = new DateTime();
$date->setTimezone(new DateTimeZone('GMT'));

echo date("l jS \of F Y h:i:s A");

?>