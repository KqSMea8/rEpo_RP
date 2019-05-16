<?	
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	require_once("classes/MyMailer3.php");
	echo '<pre>';
	$FromName = 'ERP Admin';
	$FromEmail = 'source005@gmail.com';

	
	$To = 'parwez005@gmail.com';

	$contents = $contents.'final mailer smtp content';


	$mail = new MyMailer();
	$mail->isMail();
	$mail->AddAddress($To);
	
	$mail->sender($FromName, $FromEmail);   
	$mail->Subject = 'php mailer smtp';
	$mail->IsHTML(true);
	$mail->Body = $contents;   

	//print_r($mail);exit;
 
	echo $mail->Send();exit;	

	echo '<br>Php Mail Sent';
?>
