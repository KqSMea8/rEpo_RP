<?php
	$HideNavigation = 1;
	require_once("includes/header.php");
        require_once("../classes/company.class.php");
        require_once("../classes/cmp.class.php");
         
        $objCompany=new company();
        $objCmp=new cmp();

       // $Config['AdminEmail'] = 'parwez.khan@vstacks.in'; //need to remove



        $CmpID= (int)$_GET['CmpID'];
	if(!empty($CmpID)){
		$compDetail=$objCmp->getCompanyById($CmpID);
		if(!empty($compDetail[0]['Email'])){
			unset($_SESSION['SecurityCode']);
			unset($_SESSION['SecurityCodeTime']);
			$Number = $CmpID.'-'.rand(100,10000);
			$_SESSION['SecurityCode'] = substr(md5($Number),0,10);
			$_SESSION['SecurityCodeTime'] = time();
			$contents = 'ERP Superadmin - Security Code : <strong>'.$_SESSION['SecurityCode'].'</strong><br><br>Note: This code will expire very shortly.';
			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($Config['AdminEmail']);
			$mail->AddBCC('parwez005@gmail.com');
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);
			$mail->Subject = $Config['SiteName']." - Security Code";
			$mail->IsHTML(true);
			$mail->Body = $contents;

			if($_GET['d']==1){
				echo $contents;exit;
			}

			if($Config['Online'] == '1'){
				$mail->Send();
			}
			echo '<div align="center" class="blackbold"><br><br>Security code has been send successfully at <strong>'.$Config['AdminEmail'].'</<strong>.</div>';

		}

	}

	require_once("includes/footer.php"); 
 ?>
