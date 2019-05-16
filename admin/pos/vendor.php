<?php 
 	include_once("../includes/header.php");
	require_once("classes/order.class.php");
	 require_once("classes/user.class.php"); 
	$objorder=new order();
    
   
	$db = new dbFunction();
	$ObjUser = new user();
	
	
	$cmpId  = $_SESSION['CmpID'];
	$objConfig->dbName = $Config['DbMain'];
    $objConfig->connect();
	

	
	
    $Config['RecordsPerPage'] = $RecordsPerPage;
    $getvendorByCompnay =    $objorder->getvendorByCompnayID(array('cmpId'=>$cmpId,'user_type'=>'vendorpos','isvendor_admin'=>'Yes'));
    $getvendorByCompnayID =    $getvendorByCompnay['result'];
	
	$num = $count =$getvendorByCompnay['totalCount'];
	$pagerLink=$objPager->getPaging($count,$Config['RecordsPerPage'],$_GET['curP']);
	
	
	//delete
	if(!empty($_REQUEST['del_id'])){
		
		
		//$objConfig->dbName = $Config['DbMain'];
		//$objConfig->connect();	
		$user =  $ObjUser->getResult('company_user_pos',array('id'=>trim($_REQUEST['del_id']),'comId'=>$_SESSION['CmpID']));
		
		if(count($user)>0){
			$db->delete('company_user_pos',array('id'=>trim($_REQUEST['del_id'])));
			
			$objConfig->dbName = $Config['DbName'];
		    $objConfig->connect();
			$db->delete('e_customers',array('Cid'=>trim($user[0]['ref_id'])));
			
			$_SESSION['mess_ship'] = 'User delete successfully.';
			header("location:vendor.php");
			exit();
		}else{
			$_SESSION['mess_ship'] = 'Sorry something went wrong please try again.';
			header("location:vendor.php");
			exit();
			
		}
		
	}
	
	
    require_once("../includes/footer.php");
  
?>
