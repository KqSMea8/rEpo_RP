<? 
	
	/*******************************************/
	$FromName = 'ERP Cron';
	$FromEmail = 'parwez005@gmail.com';
	$To = 'parwez.khan@sakshay.in';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron Subject';
	$contents = 'Cron Content';
	$pp = mail($To, $Subject, $contents, $headers);
	/*******************************************/

?>
