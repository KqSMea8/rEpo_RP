<?php
	/**************************************************/
	$ThisPageName = 'vendor.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	$ModuleTitle = "Add Vendor";
	
	//require_once("classes/dbfunction.class.php"); 
	require_once("classes/user.class.php"); 
	require_once("classes/order.class.php"); 
	$db = new dbFunction();
	$ObjUser = new user();
	$ObjOrder = new order();
	//$ObjPlan = new plan();
	
  

                
   
   
  
  if(!empty($_REQUEST['edit']) && empty($_POST)){
		$objConfig->dbName = $Config['DbMain'];
		$objConfig->connect();	
		$user =  $ObjUser->getResult('company_user_pos',array('id'=>trim($_REQUEST['edit']),'comId'=>$_SESSION['CmpID']));	
		if(count($user)==0){
			$_SESSION['msg_error'] = 'Invailid Request.';
			header("location:vendor.php");
			exit();
		}
   
      	
	}
  
  
	
if(!empty($_POST) && trim($_POST['Submit'])=="Submit"){
	
	
	   if(empty(trim($_POST['inputEmail']))){
				    $_SESSION['msg_error'] = 'Please enter email address.';
					header("location:addvendor.php");
		            exit();
				   
			   }
			   
			    $checkEmail =  $ObjUser->checkEmail(trim($_POST['inputEmail']));
			    if(count($checkEmail)>0){
					$_SESSION['msg_error'] = 'Email already exist.';
					header("location:addvendor.php");
		            exit();
				}
		   
		   
		   $data['customers']['FirstName'] = trim($_POST['inputFirstName']); 
		   $data['customers']['LastName'] = trim($_POST['inputLastName']); 
		   $data['customers']['Email'] = trim($_POST['inputEmail']); 
		   $data['customers']['Address1'] = $_POST['inputAddress']; 
		   $data['customers']['status'] = trim($_POST['inputStatus']); 
		  // $data['customers']['Phone'] = $_POST['inputPhone']; 
		   //$data['customers']['gender'] =  $_POST['inputGender']; 
		   $data['customers']['password'] = md5($_POST['password']); 
		   
		   $data['customers']['Country'] = $_POST['Country']; 
		   $data['customers']['State'] = $_POST['state_id'];
		   $data['customers']['City'] = $_POST['city_id'];
		  
          $data['customers']['custType'] = "vendorpos"; 
		  $data['customers']['Parent'] = 0;
		  $data['customers']['CreatedDate'] = date('Y-m-d H:i:s'); 
		    $db->insert('e_customers',  $data['customers']);
		   $ref_id =  $lastId= mysql_insert_id();
		   
		   
		   
		   
		   
		   
		   // start add user permission 
				
				$permissionData1['module_id']   = 1;
				$permissionData1['user_id']   = $ref_id;
				
				$permissionData2['module_id']   = 2;
				$permissionData2['user_id']   = $ref_id;
				
				$permissionData3['module_id']   = 3;
				$permissionData3['user_id']   = $ref_id;
				
				$permissionData4['module_id']   = 4;
				$permissionData4['user_id']   = $ref_id;
				
				$permissionData5['module_id']   = 5;
				$permissionData5['user_id']   = $ref_id;
				
				$permissionData6['module_id']   = 6;
				$permissionData6['user_id']   = $ref_id;
				
				
				
				$permissionData8['module_id']   = 30;
				$permissionData8['user_id']   = $ref_id;

                $db->insert('pos_module_user',  $permissionData1);
				$db->insert('pos_module_user',  $permissionData2);
				$db->insert('pos_module_user',  $permissionData3);
				$db->insert('pos_module_user',  $permissionData4);
				$db->insert('pos_module_user',  $permissionData5);
				$db->insert('pos_module_user',  $permissionData6);
				//$db->insert('pos_module_user',  $permissionData7);
				$db->insert('pos_module_user',  $permissionData8);
			
			// end  add user permission 
		   
		   
		   // add plan 
		        $plan_id= 1;
		        $planData=$ObjOrder->getPlans($plan_id);
				$planData[0]['elements']=$ObjOrder->getplanelements($plan_id);
		        $data['dealer_subscription']['payment_status'] = 'Completed';
				$data['dealer_subscription']['txnId'] ="";
				$data['dealer_subscription']['subscr_id'] = "";
				$data['dealer_subscription']['vendor_id'] = $ref_id;
				$data['dealer_subscription']['plan_id'] = $plan_id;
				$data['dealer_subscription']['plandata'] = serialize($planData[0]);
				$data['dealer_subscription']['amount'] = 0;
				$data['dealer_subscription']['paymentDate'] = date('Y-m-d h:i:s');
				$data['dealer_subscription']['is_active'] = '1';
				$data['dealer_subscription']['renewDate'] =date('Y-m-d h:i:s', strtotime("+30 days"));
				$data['dealer_subscription']['expireDate'] =date('Y-m-d h:i:s', strtotime("+30 days"));
				$data['dealer_subscription']['currency_code'] = 'USD';
				$db->insert('pos_dealer_subscription',  $data['dealer_subscription']);
		   
		   
		   
		   // end plan
		   
		   
		   
		   $data['user']['fname'] = trim($_POST['inputFirstName']); 
		   $data['user']['lname'] = trim($_POST['inputLastName']); 
		   $data['user']['user_name'] = trim($_POST['inputEmail']); 
		   $data['user']['password'] = md5($_POST['password']); 
		   $data['user']['address1'] = $_POST['inputAddress']; 
		  
		   if($_POST['inputStatus']=="Yes"){
		   $data['user']['status'] = '1'; 		   
		   }else{
		   $data['user']['status'] = '0';    
		   }
					   
		   $data['user']['country'] = $_POST['Country']; 
		   $data['user']['state'] = $_POST['state_id'];
		   $data['user']['city'] = $_POST['city_id'];
		   $data['user']['user_type'] = "vendorpos"; 
		   $data['user']['ref_id'] =  $lastId;
		   $data['user']['comId'] =  $_SESSION['CmpID']; 
		   $data['user']['isvendor_admin'] =  'Yes'; 
		  
		    $objConfig->dbName = $Config['DbMain'];
		    $objConfig->connect();
	        $db->insert('company_user_pos',  $data['user']);
			
			
			
				
			
			//$objConfig->addSetting(array('vendor_id'=>$_SESSION['vendorId'])); //update setting
		    $_SESSION['mess_ship'] = 'Vendor has been added successfully.';
			header("location:vendor.php");
			exit();
		  
	
}elseif(!empty($_POST) && trim($_POST['Submit'])=="Update"){
	
	    $objConfig->dbName = $Config['DbMain'];
		$objConfig->connect();	
		$user =  $ObjUser->getResult('company_user_pos',array('id'=>trim($_POST['edit']),'comId'=>$_SESSION['CmpID']));
		if(count($user)==0){
			$_SESSION['msg_error'] = 'Invailid Request.';
			header("location:vendor.php");
			exit();
		}
		
		   $refId = $user[0]['ref_id'];
		
          $data['customers']['FirstName'] = trim($_POST['inputFirstName']); 
		   $data['customers']['LastName'] = trim($_POST['inputLastName']); 
		  // $data['customers']['Email'] = $_POST['inputEmail']; 
		   $data['customers']['Address1'] = $_POST['inputAddress']; 
		   $data['customers']['status'] = $_POST['inputStatus']; 
		  // $data['customers']['Phone'] = $_POST['inputPhone']; 
		   //$data['customers']['gender'] =  $_POST['inputGender']; 
		   
		    if(!empty($_POST['password'])){
		       $data['customers']['password'] = md5($_POST['password']); 
			}
		   $data['customers']['Country'] = $_POST['Country']; 
		   $data['customers']['State'] = $_POST['state_id'];
		   $data['customers']['City'] = $_POST['city_id'];
		   $objConfig->dbName = $Config['DbName'];
		   $objConfig->connect();
		  $db->update('e_customers',  $data['customers'], array('Cid'=>$refId));
		  
		   
		   
		   
		   $data['user']['fname'] = trim($_POST['inputFirstName']); 
		   $data['user']['lname'] = trim($_POST['inputLastName']); 
		   //$data['user']['user_name'] = $_POST['inputEmail']; 
		    if(!empty($_POST['password'])){
		      $data['user']['password'] = md5($_POST['password']); 
			}
		   $data['user']['address1'] = $_POST['inputAddress']; 
		  
		   if($_POST['inputStatus']=="Yes"){
		   $data['user']['status'] = '1'; 		   
		   }else{
		   $data['user']['status'] = '0';    
		   }
					   
		   $data['user']['country'] = $_POST['Country']; 
		   $data['user']['state'] = $_POST['state_id'];
		   $data['user']['city'] = $_POST['city_id'];
		   //$data['user']['user_type'] = "vendorpos"; 
		 //  $data['user']['ref_id'] =  $lastId;
		   //$data['user']['comId'] =  $_SESSION['CmpID']; 
		  // $data['user']['isvendor_admin'] =  'Yes'; 
		  
		    $objConfig->dbName = $Config['DbMain'];
		    $objConfig->connect();
	        $db->update('company_user_pos',  $data['user'],array('id'=>$_POST['edit']));
			//$objConfig->addSetting(array('vendor_id'=>$_SESSION['vendorId'])); //update setting
		    $_SESSION['mess_ship'] = 'Vendor has been update successfully.';
			header("location:vendor.php");
			exit();



}	

 require_once("../includes/footer.php"); 
 
 
 ?>
