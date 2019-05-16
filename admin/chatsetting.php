<?php 
/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/

include_once("includes/header.php");	
	if(!empty($_POST['ganerate'])){
		$licence=$objchat->chatCurl('companyregister',array('companyid'=>$_SESSION['CmpID'],'server'=>$_SERVER['HTTP_HOST']));
		//print_r(array('companyid'=>$_SESSION['CmpID'],'server'=>$_SERVER['HTTP_HOST']));
	
		if(!empty($licence))		
			$licence=json_decode($licence);
		
			
		if(!empty($licence->message)){
			$_SESSION['mess_chat']=$licence->message;
			header("location: chatsetting.php");
			exit;
		}
	}
	if(!empty($_POST['idealtimesubmit'])){
		if(!empty($_POST['idealtime'])){
			$time=	$_POST['idealtime'];
			$objchat->getIdealTimeUpdate($time);
			$_SESSION['mess_chat']='Update Successfully';
			$objchat->redirect('chatsetting.php');
		}elsE{		
		$_SESSION['mess_chat']='Please Enter Time';
		}
	}
	
	
	$licence='';	

	$licence=$objchat->chatCurl('getcompanylicence',array('companyid'=>$_SESSION['CmpID'],'server'=>$_SERVER['HTTP_HOST']));
	
	if(!empty($licence))
	{
		$licence=json_decode($licence);
	}
	$idealtime=$objchat->getIdealTime();

	
	

require_once("includes/footer.php");	


	
?>



