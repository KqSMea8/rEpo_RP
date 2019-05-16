<?php 
$HideNavigation=1;
include_once("../includes/header.php");
require_once($Prefix."classes/dbfunction.class.php");

if(empty($_GET['name']) OR empty($_GET['ext']))
die('You have no permission');

			 require_once($Prefix."classes/phone.class.php");		
			 $objphone=new phone();
			 $getcallsetting=$objphone->GetcallSetting();
		 	 $Config['DbName'] = $Config['DbMain'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 $server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
			 $server_id	= $getcallsetting[0]->server_id;
			 $objphone->server_id	= $server_data[0]->server_ip;
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect(); 
			 
			$id=$_GET['name'];
			
			if(!empty($_POST)){
			
			if(!empty($_POST['email'])){
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."sharevoicemail.htm");
			$subject  = "Voice Mail";			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			//$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			//$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

		//	$contents = str_replace("[FULLNAME]",$UserName, $contents);
		//	$contents = str_replace("[EMAIL]",$Email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
		//	$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);		
			if(!empty($_POST['message'])){	
			
				$message =!empty($_POST['message'])?$_POST['message']:' ';				
			}
			$contents = str_replace("[MESSAGE]",$message, $contents); 
			$link='<a href="https://'.$server_data[0]->server_ip.'/webservice/acl_voicemail.php?action=download&name='.$id.'&ext='.$_GET['ext'].'">Click Here</a>';
			
			$contents = str_replace("[CONTENT]",$link, $contents); 
			
			
				 $mail = new MyMailer();
		        $mail->IsMail();
		        $mail->AddAddress($_POST['email']);
		        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
		        $mail->Subject = $Config['SiteName'] . " - Voice Mail";
		        $mail->IsHTML(true);
		       $mail->Body = $contents;		    
		        # echo $arryRow[0]['Email'] . $Config['AdminEmail'] . $contents;exit;
		        if($Config['Online'] == 1) {
		            $mail->Send();
		        }
		        $_SESSION['mess_phone']='Share successfully';
		        header('Location: ' . _SiteUrl.'admin/crm/shareVoiceEmail.php?name='.$id.'&ext='.$_GET['ext']); die;
			}else{
			 $_SESSION['mess_phone']='Please enter email id';
			}
			}else{
			
				
			}
			
require_once("../includes/footer.php"); 	 
?>


