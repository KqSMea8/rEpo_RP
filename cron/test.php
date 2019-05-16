<?php 		
 	//require_once("../includes/function.php");

	



	/*$StartTime = microtime(true);
	echo "\nStart Time : ".$StartTime." \nProcessing.........\n\n\n\n";*/

	$Department = 7; $ThisPage = 'test.php';	
	require_once("includes/settings.php");
  
	/*sleep(5);
 
	$EndTime = microtime(true);
	$ExecutionTime = $EndTime - $StartTime;

	
	echo "\nEnd Time : ".$EndTime;
	echo "\nTime Spent : ".time_diff(round($ExecutionTime))."\n";
	 */

	die;

	/*******************************************/
	$FromName = 'ERP Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'parwez005@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron : Test ';
	$contents = 'Cron Content salesOrder ';
	$pp = mail($To, $Subject, $contents, $headers);
	mail("kumar.anil5891@gmail.com", $Subject, $contents, $headers);	
	exit;
	/*******************************************/
?>

