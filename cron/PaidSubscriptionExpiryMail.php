<?php 
//echo 'hello';
	require_once("includes/common.php");
	$objCmp->SubscriptionExpiryMail();




	/*******************************************
	$FromName = 'ERP Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'parwez005@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron Final : Paid Subscription Expiry Mail';
	$contents = 'Paid Subscription Expiry Mail';
	$pp = mail($To, $Subject, $contents, $headers);
	mail("pankaj.mca13@gmail.com", $Subject, $contents, $headers);	
	exit;
	/*******************************************/
?>

