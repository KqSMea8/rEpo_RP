<?php
ob_start();
	session_start();
   	require_once("../includes/config.php");
    require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/region.class.php");
	require_once("../classes/admin.class.php");	
	require_once("../classes/user.class.php");	
	require_once("../classes/configure.class.php");	
	require_once("../classes/territory.class.php");
	require_once("../classes/sales.customer.class.php");
	require_once("../lib/hostbillapi/class.hbwrapper.php");
	require_once("../classes/hostbill.class.php");
	require_once("language/english.php");
	$objConfig=new admin();
	//ini_set('display_errors',1);
	if(empty($_SERVER['HTTP_REFERER'])){
		//echo 'Protected.';exit;
	}
	
	 $url = 'http://199.227.27.208/hostbillapi/';
	
  /*	$post = array(
      'api_id' => '1ad963008940028456bf',
      'api_key' => 'b8e901eba242eae0c485',
      'call' => 'getClients',
   );*/
	// print_r($_SESSION);die;
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();	
	 $objhostbill=new hostbill();
	 if(!empty($_REQUEST['process'])){
	 switch($_REQUEST['process']){
	 		case 'importorder':
	 			$objhostbill->importorderProcess();
	 		break;
	 		case 'importclinetTmp':
	 		$customersrefid=$objhostbill->GetTempHostbillCustomer();	 	
	 		$page=$objhostbill->GetTempHostbillSetting('customer_temp_import');
	 		$cpage=(!empty($page) AND !is_array($page))?$page:0;
	 		
	 		$customers=$objhostbill->importclinetTmp($cpage);
	 			
	 	
			for($i=($customers['sorter']['totalpages']-1); $i>=$cpage; $i--)
			 	{		 	
			 		$customers=$objhostbill->importclinetTmp($i);
					if(!empty($customers['clients'])){
					foreach ($customers['clients'] as $clients){

					if(in_array($clients['id'],$customersrefid)){
							continue;					
					}
						$data=array();
				 		$data['firstname']=$clients['firstname'];
				 		$data['lastname']=$clients['lastname'];
				 		$data['datecreated']=$clients['datecreated'];
				 		$data['email']=$clients['email'];
				 		$data['companyname']=$clients['companyname'];
				 		$data['services']=$clients['services'];
				 		$data['hostbill_userid']=$clients['id'];
				 		
				 		
				 		$objhostbill->insert('s_hostbill_customer_tmp',$data);
					}
					
					}
			 		
			 	}
				$objhostbill->update('s_hostbill_setting',array('meta_value'=>$customers['sorter']['totalpages']),array('meta_key'=>'customer_temp_import'));
	 		break;
	 		case 'importAccountTmp':
	 		ini_set('display_errors',1);
	 		$accountefid=$objhostbill->GetTempHostbillAccount();	 	
	 		
	 		$page=$objhostbill->GetTempHostbillSetting('account_temp_import');
	 		
	 		$cpage=(!empty($page) AND !is_array($page))?$page:0;
	 		
	 		$account=$objhostbill->getAccountlist($cpage);
	 		//print_r($account);die;
	 	
			for($i=($account['sorter']['totalpages']-1); $i>=$cpage; $i--)
			 	{		 	
			 		$account=$objhostbill->getAccountlist($i);
					if(!empty($account['accounts'])){
					foreach ($account['accounts'] as $accou){
							if(in_array($accou['id'],$accountefid)){
									continue;					
							}
							$itemdetail=array();
						$itemdetail=	$objhostbill->getItemDetail($accou['id']);
						$data=array();
				 		$data['manual']=$accou['manual'];
				 		$data['domain']=$accou['domain'];
				 		$data['billingcycle']=$accou['billingcycle'];
				 		$data['status']=$accou['status'];
				 		$data['total']=$accou['total'];
				 		$data['next_due']=$accou['next_due'];
				 		$data['name']=$accou['name'];				
				 		$data['type']=$accou['type'];				
				 		$data['lastname']=$accou['lastname'];				
				 		$data['firstname']=$accou['firstname'];				
				 		$data['client_id']=$accou['client_id'];				
				 		$data['currency_id']=$accou['currency_id'];	
				 		$data['paytype']=$accou['paytype'];		
				 		$data['account_id']=$accou['id'];			
				 		$data['product_id']=$itemdetail['details']['product_id'];			
				 		$data['product_name']=$itemdetail['details']['product_name'];		 		
				 		$objhostbill->insert('s_hostbill_Account_tmp',$data);
				 		$accountefid[]=$accou['id'];
					}
					
					}
			 		
			 	}
				$objhostbill->update('s_hostbill_setting',array('meta_value'=>$customers['sorter']['totalpages']),array('meta_key'=>'account_temp_import'));
	 			exit;
				break;
	 		
	 		case 'Importinvoice':
	 			//	print_r($Config);die;
	 			$objhostbill->importInvoiceProcess();
	 			$_SESSION['mess_phone']='Process has been completed';
	 			header("Location:".'finance/hostbillCustomer.php');
				exit;		
	 			die();
	 		break;
	 		
	 		case 'itemDetail':	 		
	 		$a=$objhostbill->itemdetail(713);
	 		pr($a,1);
	 		echo 'asdasd';
	 		break;
	 		
	 		case 'getProductDetails':	 		
	 		$a=$objhostbill->HostbillgetProductDetails(713);
	 		pr($a,1);
	 		echo 'asdasd';
	 		break;
	 		case 'getServerDetails':	 		
	 		$a=$objhostbill->HostbillgetServerDetails(713);
	 		pr($a,1);
	 		echo 'asdasd';
	 		break;
	 		case 'getAddonDetails':	 		
	 		$a=$objhostbill->HostbillgetAddonDetails(713);
	 		pr($a,1);
	 		echo 'asdasd';
	 		break;
	 
	 }
	 
	 }
	
  
 
	
	

	
	?>
