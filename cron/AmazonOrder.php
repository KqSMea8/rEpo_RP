<?php
	
	$pid = exec('php /var/www/html/erp/cron/ZoomMeeting.php > /dev/null & echo $!;', $output, $return);
	$pid = exec('php /var/www/html/erp/cron/ZoomWebinar.php > /dev/null & echo $!;', $output, $return);	
	$Department = 7; $ThisPage = 'AmazonOrder.php';	
	require_once("includes/settings.php");

	/*$FromName = 'ERP Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'parwez005@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron Final55 : '.$ThisPage;
	$contents = 'Cron Content';
	//$pp = mail($To, $Subject, $contents, $headers);
	mail("sanjiv.singh@vstacks.in", $Subject, $contents, $headers);	
	exit;*/

?>

