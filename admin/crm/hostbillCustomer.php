<?php 	
	/**************************************************/
	$ThisPageName = 'hostbillCustomer.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."lib/hostbillapi/class.hbwrapper.php");
	require_once($Prefix."classes/hostbill.class.php");
	
	$objEmployee=new employee();
	$objCustomer=new Customer();   // Sales Customer object
	
	//ini_set('display_errors',1);
	$objhostbill=new hostbill();
	//$aaa=$objhostbill->getinvoiceData(0);
//	pr($aaa,1);

	
	
	if(!empty($_GET['del_id'])){
	
		$del_id= (int) base64_decode($_GET['del_id']);
		if($del_id){
		
			$objhostbill->update('s_customers',array('RigisterType'=>'crm','RigisterTypeID'=>''),array('Cid'=>$del_id));
			$_SESSION['mess_phone']='delete successfully.';
				header('Location: hostbillCustomer.php');
				exit;
		}
	
	}
	if(!empty($_POST)){
			if(!empty($_POST['hostbillcid']) AND !empty($_POST['cid'])){				
				$objhostbill->update('s_customers',array('RigisterType'=>'hostbill','RigisterTypeID'=>$_POST['hostbillcid']),array('Cid'=>$_POST['cid']));
				$_SESSION['mess_phone']='Update successfully.';
				header('Location: hostbillCustomer.php');
				exit;
			}
	
	}

	
	$customers=$listcustomer=$selectcustomer=array();
	//$agents=$objphone->api('acl_users.php',array());	
	


	/**********Sales Customer**************/
	$assigneHostbillcustomer=array();
	$customers=$objCustomer->getCustomers($_GET);
	//echo '<pre>';
	//print_r($customers);die;
	if(!empty($customers)){
			foreach($customers as $customer){
					if($customer['RigisterType']=='crm' OR empty($customer['RigisterType'])){
					
						if(!empty($customer['FullName'])){
						$selectcustomer[$customer['Cid']]=$customer['FullName'];	
						}				
					}else if($customer['RigisterType']=='hostbill'){					
						$listcustomer[$customer['Cid']]=array('FullName'=>$customer['FullName'],'CustCode'=>$customer['CustCode'],'Email'=>$customer['Email'],'refid'=>$customer['RigisterTypeID'],'cid'=>$customer['Cid'],);
						$assigneHostbillcustomer[]=$customer['RigisterTypeID'];
					}
			
			}
	
	}
	/*************************/
	
	/**********Hostbill Temp cusomer**************/
	$hostbillClient=$objhostbill->GetTempHostbillCustomer(true);
	
	if(!empty($hostbillClient)){
			foreach($hostbillClient as $Client){				
						$selectClient[$Client['hostbill_userid']]=$Client['firstname'].' '.$Client['lastname'];					
									
						$listClient[$Client['hostbill_userid']]=array('firstname'=>$Client['firstname'],'lastname'=>$Client['lastname'],'email'=>$Client['email']);
					
			
			}
	
	}
	/*************************/
	
	/*  invoice synchronize date */
	
$sql="Select meta_value,meta_key,meta_date FROM s_hostbill_setting WHERE 1=1 AND meta_key='inventory_import_page'";
$synchronizedate=$objhostbill->query($sql);
//	print_R($Config['Url']);
	require_once("../includes/footer.php"); 	
?>


