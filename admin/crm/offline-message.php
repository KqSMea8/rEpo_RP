<?php 	/**************************************************/
	$ThisPageName = 'offline-message.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");	
	require_once($Prefix."classes/lead.class.php");	
	require_once($Prefix."classes/user.class.php");
	$ModuleName = "Offline Message";	
	$lis='';
	$objLead= new lead();
	
	$chatroles=$chatrole=array();
	$licence=$objchat->chatCurl('getcompanylicence',array('companyid'=>$_SESSION['CmpID'],'server'=>$_SERVER['HTTP_HOST']));
	if(!empty($licence)){	
		$lis_data=json_decode($licence);
		$lis=$lis_data->licence;
	}	
	if($_SESSION['AdminType']=='admin'){
			$chatrole=array('Sales','Support');
		}else{
			$chatroles=$objchat->getchatrole($_SESSION['AdminID']);
			if(!empty($chatroles)){
				
				foreach($chatroles as $chatrol){
					
					$chatrole[]=$chatrol->rolename;
				}
			}
			
		}
		
	if(!empty($_POST['mode']) && !empty($_POST['refid'])) {	
			CleanPost(); 	
				$messagedetail=$objchat->chatCurl('api/offlinemessagebyid',array('lis'=>$lis,'id'=>$_POST['refid']));
				if(!empty($messagedetail)){				
					$messageres=json_decode($messagedetail);
					$messageres=$messageres->offlinemessage[0];				
				}				
				if($_POST['mode']=='Ticket'){
					$data['title'] =$_POST['title'];
					$data['assign'] ='User';
					$data['AssignToGroup'] ='';
					$data['AssignToUser'] =$_SESSION['AdminID'];
					$data['Status'] ='Open';
					$data['priority'] ='Low';
					$data['category'] ='Other Problem';
					$data['description'] = $messageres->msg;
					$data['solution'] ='';		
					$data['created_by'] ='employee';
					$data['created_id'] =$_SESSION['AdminID'];	
					$data['module'] ='Ticket';										
					$objLead->AddTicket($data);
					$objchat->chatCurl('api/offlinemessageUpdate',array('lis'=>$lis,'id'=>$_POST['refid'],'status'=>'close'));
					$objchat->redirect('offline-message.php');
				}elseif($_POST['mode']=='Lead'){					
					$data['type'] = 'Individual';
					$data['FirstName'] = $messageres->name; 
					$data['LastName'] = '' ;
					$data['primary_email'] = $messageres->email;
					$data['lead_source'] = 'Other'; 
					$data['lead_status'] = 'Contacted'; 
					$data['LeadDate'] = date('Y-m-d',strtotime($messageres->date)); 
					$data['assign'] =	'User'; 
					$data['AssignToUser'] =$_SESSION['AdminID'];
					$data['Mobile'] =  $messageres->phone;
					$data['description'] =  $messageres->msg;
					$data['designation']=$_POST['title'];
					$objLead->AddLead($data);
					$objchat->chatCurl('api/offlinemessageUpdate',array('lis'=>$lis,'id'=>$_POST['refid'],'status'=>'close'));
					$objchat->redirect('offline-message.php');
				}
		
	}

			if(!empty($lis) AND !empty($chatrole)){
				$ch=implode(',',$chatrole)	;
				$server_output=$objchat->chatCurl('api/offlinemessagebytype',array('lis'=>$lis,'type'=>$ch));			
			}
			$responce=array();
			if(!empty($server_output)){
				$responce=json_decode($server_output);
			}
			$responce->offlinemessage;
		
		
		
	
	?>
<?php require_once("../includes/footer.php"); 	
?>
