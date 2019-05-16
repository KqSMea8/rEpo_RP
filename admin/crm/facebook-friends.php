<?php 
//ini_set('display_errors','1');
$ThisPageName = 'facebook.php';
$EditPage = 1;

 /**************************************************
     #echo $ThisPageName;
    /**************************************************/
	require_once("../../define.php");
	require_once("../includes/header.php");
	ini_set('display_errors','1');
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/crm.class.php");
    	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/socialCrm.class.php");
	//start facebook library
	require_once(_ROOT."/lib/facebook/src/facebookSearcher.class.php");
	require_once(_ROOT."/lib/facebook/src/facebook.php");
	
	$objsocialcrm=new socialcrm();
	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => '1608313902793535',//'211257059004768',
	  'secret' => '2feb7cd1178672150038ab7194284cb3'//'665bfd2c2b00202414ee26933d839756',
	));
	
	// Get User ID
    $user = $facebook->getUser();
	
	
    // get access login
    $access_token = $facebook->getAccessToken(); 
	 
	 //echo $user.'   '.$access_token;
	if($user){

//==================== Single query method ======================================1152069208183389
	try{
		// Proceed knowing you have a logged in user who's authenticated.
		//$user_profile = $facebook->api('/me/friends/?fields=birthday,age_range,cover,about,email,education,first_name,last_name,picture,address');
		//$user_profile = $facebook->api('/me/');
		//echo "<pre>";print_r($user_profile);die;
		//$user_profile = $facebook->api('/me/friends?fields=birthday,name,link,age_range,cover,about,email,education,first_name,last_name,picture,address');
		$user_profile = $facebook->api('/me/friends?fields=birthday,name,link,age_range,cover,first_name,last_name,gender');//Amit singh

		//var_dump($user_profile);
		//$user_profile = $facebook->api('/me/friendlists');
				
				//die;//echo 'test';
				
			
	}catch(FacebookApiException $e){
		//error_log($e);
		//print_r( $e);
		$user = NULL;
		
	}
 //==================== Single query method ends =================================
   }   
 if(empty($user)){
 $errMsg = "Please log into Facebook. After that you can get friends on facebook";
 }
 
 
 
#get customers data for facebook 
$arg_cust_facebook =array();
$arg_cust_facebook['table'] = "s_customers";
$arg_cust_facebook['where']= "FacebookID <> ''";
$arg_cust_facebook['fields']= "FacebookID";
$customer_result =  $objsocialcrm->GetAllData($arg_cust_facebook);


#get contact data for facebook
$arg_cont_facebook =array();
$arg_cont_facebook['table'] = "s_address_book";
$arg_cont_facebook['where']= "FacebookID <> ''";
$arg_cont_facebook['fields']= "FacebookID";
$contact_result =  $objsocialcrm->GetAllData($arg_cont_facebook);

$all_result =  array_merge($customer_result,$contact_result);
 

 if($_POST){

	    $userId =  $user_profile['data'][$_POST['userid'][0]]['id'];
	    $post_data = $facebook->api('/'.$userId);
	    $type = $_POST['action-type'];
		$userexist =  $objsocialcrm->checkUserexist($post_data['id'],$type);
		# check customer or contact
		if($type=="add_customer"){
			if($userexist==true){
			$data['FirstName'] = $post_data['first_name'];
			$data['LastName'] = $post_data['last_name'];
			$data['FullName'] = $post_data['name'];
			$data['Gender'] =  ucfirst($post_data['gender']);
			$data['RigisterType'] =  'facebook';
			$data['CustomerType'] =  'Individual';
			$data['RigisterTypeID'] =  $post_data['id'];
			$data['FacebookID'] =  $post_data['id'];
			$data['FacebookInfo'] =  serialize(array('ID'=>$post_data['first_name'],'FirstName'=>$post_data['last_name'],'LastName'=>$post_data['last_name'],'FullName'=>$post_data['name'],'Gender'=>$post_data['gender']));
			///echo "<pre>";print_r($data);die;
			$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
			}
		}else{
			if($userexist==true){
			$data['FirstName'] = $post_data['first_name'];
			$data['LastName'] = $post_data['last_name'];
			$data['FullName'] = $post_data['name'];
			$data['Gender'] =  ucfirst($post_data['gender']);
			$data['RigisterType'] =  'facebook';
			$data['CrmContact'] =  '1';
			$data['RigisterTypeID'] =  $post_data['id'];
			$data['FacebookID'] =  $post_data['id'];
			$data['FacebookInfo'] =  serialize(array('ID'=>$post_data['first_name'],'FirstName'=>$post_data['last_name'],'LastName'=>$post_data['last_name'],'FullName'=>$post_data['name'],'Gender'=>$post_data['gender']));
			$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
			}	
		}
		
		
		if($addCustId){
		$_SESSION['mess_social']='<div class="success">Added Successfully</div>';
		header('Location: ' ._SiteUrl.'admin/crm/facebook-friends.php' ); 
		die;
		
		}else{

		$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
		header('Location: ' ._SiteUrl.'admin/crm/facebook-friends.php' ); 
		die;

		}	
		//$AddID = $objCustomer->addCustomerAddress($_POST,$addCustId,'contact');
}
 
 
 
 
/*
 $savedata=$res=$addedleadCrm=$socialids=array();
if(!empty($_POST['userid']) AND !empty($user_profile)){
	$addedleadCrm=$objsocialcrm->getSocialLead('facebook',array('id','social_id'));
	
	if(!empty($addedleadCrm)){
		foreach($addedleadCrm as $addedlead){		
			$socialids[]=$addedlead['social_id'];
		}
	}
ini_set('display_errors',1);
	foreach($_POST['userid'] as $id){
	
	$results = $facebook->api('/'.$id);
			if(!in_array($results->id,$socialids)){
			$res['social_type']='facebook';
			$res['social_id']=$results['id'];
			$res['name']=$results['name'];
			$res['user_name']=$results['username'];
			$res['location']='';
			$res['image']='https://graph.facebook.com/'.$results[$id]['id'].'/picture';	
			$savedata[]=$res;
			}
	}
}

if(!empty($savedata)){

	$objsocialcrm->InsertMultiUserLead($savedata);
		$_SESSION['mess_social']='<div class="success">Add To CRM  Successfully</div>';
		header('Location: ' ._SiteUrl.'admin/crm/facebook-friends.php' ); 
	  die;
}
 

*/
	
	 
	 
	require_once("../includes/footer.php"); 
?>


