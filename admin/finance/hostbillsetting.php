<?php 
include_once("../includes/header.php");	



	require_once("../../lib/hostbillapi/class.hbwrapper.php");
	require_once("../../classes/hostbill.class.php");


	 $objhostbill=new hostbill(array('yes'));	 	

	 if(!empty($_GET["debugmode"])){
	 	
	 
	 }
	if(isset($_POST['hostbillconfigsubmit'])){
		if(!empty($_POST['id']) AND !empty($_POST['key']) AND !empty($_POST['ip']) AND !empty($_POST['api_url'])){
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['id']),array('meta_key'=>'api_id'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['key']),array('meta_key'=>'api_key'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['ip']),array('meta_key'=>'ip'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['api_url']),array('meta_key'=>'api_url'));

			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['sycnInvoice']),array('meta_key'=>'sycnInvoice'));
			$objhostbill->update('s_hostbill_setting',array('meta_value'=>$_POST['fromdate']),array('meta_key'=>'fromdate'));
			
						
			$_SESSION['mess_hostbill']='Updated Successfully';
			
		}elsE{		
		$_SESSION['mess_hostbill']='Please fill required field.';
		}
	}
	if(isset($_POST['checkapi'])){

		if(!empty($_POST['id']) AND !empty($_POST['key']) AND !empty($_POST['ip']) AND !empty($_POST['api_url'])){


			$objhostbill->api_url=$_POST['api_url'];
			$objhostbill->api_key=$_POST['key'];
			$objhostbill->api_id=$_POST['id'];	
			if($_SESSION["CmpID"]==37){
					//ini_set("display_errors",1);
				//	pr($_POST);
					//die("asdasd");
								
			}

			$responce=$objhostbill->CheckHostbillcredencial();
			
			if(!empty($responce['error'])){
					$_SESSION['mess_hostbill']=$responce['error'][0];	
					$objchat->redirect('hostbillsetting.php');		
					
			}else{
				$_SESSION['mess_hostbill']='Hostbill Authentication Validated Successfully';	
				$objchat->redirect('hostbillsetting.php');		
			
			}
		
		}else{
				$_SESSION['mess_hostbill']='Please fill required field.';
		
		}

	}
	$hostbillConfig=array();
	$hostbillConfig=$objhostbill->GetTempHostbillSetting();
	 
	
require_once("../includes/footer.php");	


	
?>



