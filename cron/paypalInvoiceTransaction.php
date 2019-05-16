<?php 
	$Department = 5; $ThisPage = 'paypalInvoiceTransaction.php';	

	require_once("includes/settings.php");

	$FromName = 'Paypal Invoice Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'ravisolanki343@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron Final55 : '.$ThisPage;
	$contents = 'Cron Hostbill Content';
	//$pp = mail($To, $Subject, $contents, $headers);
	//mail($To, $Subject, $contents, $headers);	
	exit;
?>

