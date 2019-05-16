<?	
	require_once("classes/MyMailer.php");

	$FromName = 'ERP Admin';
	$FromEmail = 'abid786raza@gmail.com';

	$To = 'parwez.khan@vstacks.in';
	$CC = 'parwez005@gmail.com';

	$contents = 'hi test <b>content</b><br><br>';

	
	/*$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();
	
	$Subject = 'simple mailer';

	
	//$pp = mail($To, $Subject, $contents, $headers);
	if($pp) echo 'Simple Mail Sent';
	else echo 'Error: Mail not sent.<br><br>';
	 /******************/
	$contents = $contents.'final33 ';

	$mail = new MyMailer();
	$mail->IsMail();
	$mail->Sender;
	$mail->AddAddress($To);
	$mail->AddCC($CC);
	$mail->sender($FromName, $FromEmail);   
	$mail->Subject = 'php live : '.$_GET['test'];
	$mail->IsHTML(true);
	$mail->Body = $contents;    
	echo $mail->Send();	

	//echo '<br>Php Mail Sent';
?>
