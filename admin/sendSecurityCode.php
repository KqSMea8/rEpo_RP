<?php
	$HideNavigation = 1; $SecurityPage=1;
	require_once("includes/header.php");
      
	echo '<script>RestrictIframe();</script>';	

	if($_SESSION['AdminType'] == "admin"){	
		$ToEmail = $_SESSION['AdminEmail'];
		$UserID = $_SESSION['CmpID'];
	}else{
		$ToEmail = $_SESSION['EmpEmail'];
		$UserID = $_SESSION['UserID'];
	}		
	unset($_SESSION['EmailSecurityCode']);
	unset($_SESSION['EmailSecurityCodeTime']);
	$Number = $UserID.'-'.rand(100,10000);
	$_SESSION['EmailSecurityCode'] = substr(md5($Number),0,10);
	$_SESSION['EmailSecurityCodeTime'] = time();
	$contents = $Config['SiteName'].' Admin :: Security Code for Email Verification : <strong>'.$_SESSION['EmailSecurityCode'].'</strong><br><br>Note: This code will expire very shortly.';
	$mail = new MyMailer();
	$mail->IsMail();
	$mail->AddAddress($ToEmail);
	$mail->sender($Config['SiteName'], $Config['AdminEmail']);
	$mail->Subject = $Config['SiteName']." :: Security Code for Email Verification";
	$mail->IsHTML(true);
	$mail->Body = $contents;
	#echo $ToEmail.' '.$Config['SiteName'].' '.$Config['AdminEmail'].$contents; die;
	if($_GET['d']==1){
		echo $contents;exit;
	}
	if($Config['Online'] == '1'){
		$mail->Send();
	}
	echo '<div align="center" class="greenmsg"><br><br>Security code has been send successfully at <strong>'.$ToEmail.'</<strong>.</div>';

    	require_once("includes/footer.php"); 
 ?>
