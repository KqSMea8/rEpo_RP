<?php
ini_set('display_errors',1);
//echo 'adfasdf';
   require 'lib/hostbillapi/class.hbwrapper.php';; 
  //echo 'third_party/hostbillapi/class.hbwrapper.php';

  HBWrapper::setAPI('http://www.virtualstacks.com/vsvpc/admin/api.php','3affef63db1423e2ab3e','31e95d65f196e715e542',0);
  #HBWrapper::setAPI('http://www.virtualstacks.com/vsvpc/admin/api.php','3affef63db1423e2ab3e','31e95d65f196e715e542',0);
  
  //echo '<pre>';
  //print_r($_SERVER);
  if(!empty($_REQUEST['task'])){
  
 	 switch($_REQUEST['task']){
		 	 case 'getorderdes':
				 $return = HBWrapper::singleton()->getOrders();
   				 echo json_encode($return);
   				 exit;
		 	 break;
		 	 
		 	  case 'getorderdesdetail':
				$params = array('id'=>$_REQUEST['id'] );
			    $return = HBWrapper::singleton()->getOrderDetails($params);
			    echo '<pre>';
			    print_r($return);
			    exit;
		 	 break;
		 	 
		 	 
		 	   case 'getinvoicedetail':
				$params = array('id'=>$_REQUEST['id'] );
   $return = HBWrapper::singleton()->getInvoiceDetails($params);
   echo '<pre>';
   print_r($return);
   exit;
		 	 break;
		 	 case 'getorderdesdetaillist':
		 	 $result=array();
		 	    $return = HBWrapper::setPageNum((int) $_POST['page']);
				$return = HBWrapper::singleton()->getOrders();
   				if(!empty($return['orders'])){
		   				foreach($return['orders'] as $k=>$order){
		   				$params = array('id'=>$order['id']);
   							$orderdetail = HBWrapper::singleton()->getOrderDetails($params);
		   					$return['orders'][$k]['orderdetail']=$orderdetail['details'];
		   				
		   				}
   				
   				}
   				if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
   				print_r($return);
   				
   				}
				 echo json_encode($return);
   				 exit;
				
		 	 break;
		 	 
		 	 case 'getCustomerdetail':
		 	 $cid=$_REQUEST['client_id'];
		 	 	$return = HBWrapper::singleton()->getClientDetails(array('id'=>$cid));
 	 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 	 			echo '<pre>';
   				print_r($return);
   				
   				}
		 	 	 echo json_encode($return);
   				 exit;				
		 	 break;
		 	 case 'getCustomerlist':	
		 	// echo json_encode(array('page'=>$_POST['page']));die;
		 	     $return = HBWrapper::setPageNum((int) $_POST['page']);
		 	 	 $return = HBWrapper::singleton()->getClients();
		 	 	 echo json_encode($return);
   				 exit;				
		 	 break;
		 	 
		 	  case 'getInvoicedetaillist':	
		 	// echo json_encode(array('page'=>$_POST['page']));die;
		 	    	 $return = HBWrapper::setPageNum((int) $_REQUEST['page']);
		 	    	 $param=array();
		 	    	 if($_REQUEST){
		 	    	 	$param=array('list'=>$_REQUEST['list']);
		 	    	 }
		 	 	 $return = HBWrapper::singleton()->getInvoices($param);
		 	 	 
 	 			if(!empty($return['invoices'])){
		   				foreach($return['invoices'] as $k=>$invoice){
		   				$params = array('id'=>$invoice['id']);
   							$invoicedetail = HBWrapper::singleton()->getInvoiceDetails($params);
		   					$return['invoices'][$k]=$invoicedetail['invoice'];
		   				
		   				}
   				
   				}
 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 			 echo '<pre>';
   				print_r($return);
   				die;
   				}
		 	 	 echo json_encode($return);
   				 exit;				
		 	 break;
		 	 
		 	  case 'getDomainDetails':
		 	   $return = HBWrapper::singleton()->getDomainDetails(array('id'=>$_REQUEST['id']));
 	 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				print_r($return);
   				die;
   				}
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	  case 'getProductDetails':
		 	//   $id=$_REQUEST['id'];
		 	   $return = HBWrapper::singleton()->getProductDetails(array('id'=>$_REQUEST['id']));
 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				print_r($return);
   				die;
   				}
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	   case 'getServerDetails':
		 	   $return = HBWrapper::singleton()->getServerDetails(array('id'=>$_REQUEST['id']));
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	 case 'getAddonDetails':
		 	   $return = HBWrapper::singleton()->getAddonDetails(array('id'=>$_REQUEST['id']));
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	  
		 	  case 'getAppGroups':
		 	   $return = HBWrapper::singleton()->getAppGroups();
		 	   print_R($return);
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	   case 'getAddons':
		 	   $return = HBWrapper::singleton()->getAddons();
		 	   print_R($return);
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	   case 'getAppServers':
		 	   $return = HBWrapper::singleton()->getAppServers(array('group'=>$_REQUEST['group']));
		 	   print_R($return);
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	   case 'getProducts':
		 	      $return = HBWrapper::singleton()->getProducts(array('id'=>$_REQUEST['id']));
		 	   //  print_R($return);
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	   case 'getAccounts':
		 	     HBWrapper::setPageNum((int) $_REQUEST['page']);
		 	      $return = HBWrapper::singleton()->getAccounts();		 
		 	       if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				print_r($return);
   				die;
   				}		  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	    case 'getAccountDetails':		 	    
		 	      $return = HBWrapper::singleton()->getAccountDetails(array('id'=>$_REQUEST['id']));
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	  
		 	  case 'getTransactions':		 	    
		 	      $return = HBWrapper::singleton()->getTransactions();
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	  case 'getTransactionsdetail':		 	    
		 	      $return = HBWrapper::singleton()->getTransactionDetails(array('id'=>$_REQUEST['id']));
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				 print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	   case 'getCurrencies':		 	    
		 	      $return = HBWrapper::singleton()->getCurrencies();
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				 print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;

  			case 'getInvoicesPDF':		 	    
		 	      $return = HBWrapper::singleton()->getInvoicesPDF(array('from'=>'2016-04-18','to'=>'2016-04-30'));
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				 print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;
		 	  
		 	  case 'chargeCreditCard':		 	    
		 	      $return = HBWrapper::singleton()->chargeCreditCard(array('id'=>$_REQUEST['id']));
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				 print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;

 			case 'getPaymentModules':		 	    
		 	      $return = HBWrapper::singleton()->getPaymentModules();
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				 print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
		 	  break;

				case 'chargeCreditCard':
 $return = HBWrapper::singleton()->chargeCreditCard(array('id'=>$_REQUEST['id']));
 	 			 if(!empty($_REQUEST['p']) && $_REQUEST['p']=='yes'){
 				 echo '<pre>';
   				 print_r($return);
   				die;
   				}		 	  
		 	    echo json_encode($return);
   				 exit;	
break;
		 	  
 	 
 	 }
  
  
  
  }
  
  // $return = HBWrapper::singleton()->getOrders();
  // echo json_encode($return);
  
  
  
 /* die;
   $url = 'http://www.virtualstacks.com/vsvpc/admin/api.php';
  /* $post = array(
      'api_id' => '1ad963008940028456bf',
      'api_key' => 'b8e901eba242eae0c485',
      'call' => 'getClients',
   );
$post = array(
      'api_id' => '1ad963008940028456bf',
      'api_key' => 'b8e901eba242eae0c485',
      'call' => 'getClients',
   );
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_TIMEOUT, 30);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
   $data = curl_exec($ch);
   curl_close($ch);
  print_r($data);
   $return = json_decode($data, true);
   print_r($return);
   echo 'sdfgsd';*/
?>
