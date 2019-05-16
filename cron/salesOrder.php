<?php 		
	$Department = 7; $ThisPage = 'salesOrder.php';	
	require_once("includes/settings.php");



	/*******************************************/
	$FromName = 'ERP Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'parwez005@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron : salesOrder ';
	$contents = 'Cron Content salesOrder ';
	$pp = mail($To, $Subject, $contents, $headers);
	mail("parwez005@gmail.com", $Subject, $contents, $headers);	
	exit;
	/*******************************************/
?>

