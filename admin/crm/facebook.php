<?php
$FancyBox=1;

require_once("../../define.php");
require_once("../includes/header.php");
ini_set('display_errors',1);
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/event.class.php");
require_once($Prefix."classes/group.class.php");
require_once($Prefix."classes/crm.class.php");
require_once($Prefix."classes/socialCrm.class.php");
require_once($Prefix."classes/sales.customer.class.php");

// start facebook library
require_once(_ROOT."/lib/facebook/src/facebookSearcher.class.php");
require_once(_ROOT."/lib/facebook/src/facebook.php");
// end facebook library
$objLead=new lead();
$objGroup=new group();
$objCommon=new common();
$objActivity=new activity();
$objRegion=new region();
$objEmployee=new employee();
$objsocialcrm=new socialcrm();
// AppId='211257059004768',secret='665bfd2c2b00202414ee26933d839756',
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '1608313902793535',
  'secret' => '2feb7cd1178672150038ab7194284cb3'
));

if(!empty($_GET['q']) && !empty($_GET['access_token'])){
	
    $searcher = new facebookSearcher();
	$searcher->setAccessToken($_GET['access_token']);
	
	if(!empty($_GET['offset'])){
		$searcher->setOffset($_GET['offset']);
	}
	
	if(!empty($_GET['__after_id'])){
		$searcher->setAfterid($_GET['__after_id']);
	}
	
    $searcher->setQuery($_GET['q'])
                ->setType('user')
                ->setLimit(12);
							
    $results = $searcher->fetchResults();
	//print_r($results);
	
	 $user_id =  array();
	 if(count($results)>0){
		 $paging = $results->paging; 
		 foreach($results->data as $val){
			 $user_id[] = $val->id;   // get all profile id
			   
		 } 
	 }
	 //print_r($user_id);$i=0;
	 // get profile 
     if(count($user_id)>0){
		 foreach($user_id as $userid){ 
	        $search_user['userdata'][] = $facebook->api('/'.$userid.'?fields=name,first_name,link,id,gender');//gender,birthday,age_range,cover,about,email,education,first_name,last_name,link
	    }
		$search_user['paging'] =  $paging;
	 }
	 $results=$search_user['userdata'];
//print_r($search_user);
}


$savedata=$res=$addedleadCrm=$socialids=array();

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
	
	    $type = $_POST['action-type'];
		
		$post_data = $results[$_POST['userid'][0]];
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
		header('Location: ' ._SiteUrl.'admin/crm/facebook.php?'.$_SERVER['QUERY_STRING'] ); 
		die;
		
		}else{

		$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
		header('Location: ' ._SiteUrl.'admin/crm/facebook.php?'.$_SERVER['QUERY_STRING'] ); 
		die;

		}	
		//$AddID = $objCustomer->addCustomerAddress($_POST,$addCustId,'contact');
}


/*
$results=$search_user['userdata'];
$savedata=$res=$addedleadCrm=$socialids=array();

if(!empty($_POST['userid']) AND !empty($results)){
	$addedleadCrm=$objsocialcrm->getSocialLead('facebook',array('id','social_id'));
	
	if(!empty($addedleadCrm)){
		foreach($addedleadCrm as $addedlead){		
			$socialids[]=$addedlead['social_id'];
		}
	}

	foreach($_POST['userid'] as $id){
			if(!in_array($results[$id]->id,$socialids)){
			$res['social_type']='facebook';
			$res['social_id']=$results[$id]['id'];
			$res['name']=$results[$id]['name'];
			$res['user_name']=$results[$id]['username'];
			$res['location']='';
			$res['image']='https://graph.facebook.com/'.$results[$id]['id'].'/picture';	
			$savedata[]=$res;
			}
	}
}

if(!empty($savedata)){

	$objsocialcrm->InsertMultiUserLead($savedata);
		$_SESSION['mess_social']='<div class="success">Add To CRM  Successfully</div>';
	header('Location: ' ._SiteUrl.'admin/crm/facebook.php?'.$_SERVER['QUERY_STRING'] ); 
	  die;
}
*/

require_once("../includes/footer.php"); 
?>






