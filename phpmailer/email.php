<?	
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	require_once("MyMailer.php");
	echo '<pre>';
	$FromName = 'ERP Admin';
	$FromEmail = 'orders@mkbtechnology.com';

	$CC = 'parwez.khan@vstacks.in';
	$To = 'parwez005@gmail.com';

	$contents = $contents.'final mailer smtp content';

	$mail = new MyMailer();
	$mail->isMail();
	$mail->AddAddress($To);
	//$mail->AddCC($CC);
	$mail->sender($FromName, $FromEmail);   
	$mail->Subject = 'php mailer smtp';
	$mail->IsHTML(true);
	$mail->Body = $contents;   

	//print_r($mail);exit;
 
	echo $mail->Send();exit;	

	echo '<br>Php Mail Sent';
?>
