<?php 
include_once("includes/header.php");	
 
	require_once("../lib/hostbillapi/class.hbwrapper.php");
	require_once("../classes/hostbill.class.php");


	 $objhostbill=new hostbill(array('yes'));	 	

	if(!empty($_POST['hostbillconfigsubmit'])){
		if(!empty($_POST['id']) AND !empty($_POST['key']) AND !empty($_POST['ip']) AND !empty($_POST['api_url'])){
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['id']),array('meta_key'=>'api_id'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['key']),array('meta_key'=>'api_key'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['ip']),array('meta_key'=>'ip'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['api_url']),array('meta_key'=>'api_url'));
						
			$_SESSION['mess_hostbill']='Update Successfully';
			$objchat->redirect('hostbillsetting.php');
		}elsE{		
		$_SESSION['mess_hostbill']='Please fill required field.';
		}
	}
	$hostbillConfig=array();
	$hostbillConfig=$objhostbill->GetTempHostbillSetting();
	 
	
require_once("includes/footer.php");	


	
?>



