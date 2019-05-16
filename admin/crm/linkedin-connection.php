<?php 

$ThisPageName = 'Linkedin.php';
$EditPage = 1;
 /**************************************************
     #echo $ThisPageName;
    /**************************************************/
	require_once("../../define.php");
	require_once("../includes/header.php");
	//ini_set('display_errors',1);
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/group.class.php");
    require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/socialCrm.class.php");
	$objsocialcrm=new socialcrm();
	$Linkedindata=array();
$oauth_token_linkedin=$oauth_token_linkedin='';
$Linkedindata=$objsocialcrm->getSocialUserConnect('linkedin',array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));

$oauth_token_linkedin=$Linkedindata[0]['user_token'];
$oauth_token_secret_linkedin=$Linkedindata[0]['user_token_secret'];

/********************************** Start LinkIdIn Api **************************/
	
 try {
  // include the LinkedIn class
  require_once(_ROOT.'/lib/linkedin/linkedin_3.2.0.class.php');
  
  //echo "<pre>";print_r($_SESSION);
  
  // display constants
  $API_CONFIG = array(
    'appKey'       => '75pnp6i91ecr8l',
	  'appSecret'    => 'rW8BgG9sPpQvaEvi',
	  'callbackUrl'  => 'http://app01.eznetcrm.com/erp/admin/crm/postLinkedin.php' 
  );
  define('DEMO_GROUP', '4010474');
  define('DEMO_GROUP_NAME', 'Simple LI Demo');
  define('PORT_HTTP', '80');
  define('PORT_HTTP_SSL', '443');
 define('CONNECTION_COUNT', 20);
  define('PORT_HTTP', '80');
  define('PORT_HTTP_SSL', '443');
  define('UPDATE_COUNT', 10);
  // set index
 // echo LINKEDIN;
  //print_r($_REQUEST[LINKEDIN::_GET_TYPE]);
  $_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';
 
} catch(LinkedInException $e) {
  // exception raised by library call
  echo $e->getMessage();
}


	
	
      $OBJ_linkedin = new LinkedIn($API_CONFIG);
	  //echo $_SESSION['oauth']['linkedin']['access'];
	  $access['oauth_token']=$oauth_token_linkedin;
	  $access['oauth_token_secret']=$oauth_token_secret_linkedin;
	  $access['oauth_expires_in']='5183999';
	  $access['oauth_authorization_expires_in']='5183999';	 
	   /*[oauth_token] =&gt; 2ac0c75e-0263-404b-83b6-56f6ab44dbee
            [oauth_token_secret] =&gt; 363a222a-c68c-44b3-abf5-f7119fdd9cba
            [oauth_expires_in] =&gt; 5183999
            [oauth_authorization_expires_in] =&gt; 5183999*/
     $OBJ_linkedin->setTokenAccess($access);
	// prepare content for sharing
   
   
       $response = $OBJ_linkedin->connections('~/connections');
     

      
   $connections = new SimpleXMLElement($response['linkedin']);      
	
#get customers data  
$arg_cust_linkedin =array();
$arg_cust_linkedin['table'] = "s_customers";
$arg_cust_linkedin['where']= "LinkedinID <> ''";
$arg_cust_linkedin['fields']= "LinkedinID";
$customer_result =  $objsocialcrm->GetAllData($arg_cust_linkedin);


#get contact data 
$arg_cont_linkedin =array();
$arg_cont_linkedin['table'] = "s_address_book";
$arg_cont_linkedin['where']= "LinkedinID <> ''";
$arg_cont_linkedin['fields']= "LinkedinID";
$contact_result =  $objsocialcrm->GetAllData($arg_cont_linkedin);


$all_result =  array_merge($customer_result,$contact_result);



if($_POST){
	CleanPost(); 
     $connections = new SimpleXMLElement($response['linkedin']);
     $results=$connections->person;
     $post_data = $results[(int) $_POST['userid'][0]];
	 $type = $_POST['action-type'];
	 $id = (string) $post_data->{'id'};
	 $userexist =  $objsocialcrm->checkUserexist($id,$type);
	 
	 
	 
# check customer or contact
if($type=="add_customer"){
	if($userexist==true){
	
	$data['FirstName'] = $post_data->{'first-name'};
	$data['LastName'] = $post_data->{'last-name'};
	$data['FullName'] = $post_data->{'first-name'}." ".$post_data->{'last-name'};
	$data['RigisterType'] =  'linkedin';
	$data['CustomerType'] =  'Individual';
	$data['RigisterTypeID'] =  $id;
	$data['LinkedinID'] =  $id;
	//$data['LinkedinInfo'] =  serialize(array('ID'=>$id,'FirstName'=>$data['FirstName'],'LastName'=>$data['LastName'],'Location'=>''));
	
	
	$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
	}
}else{
	if($userexist==true){
	$data['FirstName'] = $post_data->{'first-name'};
	$data['LastName'] = $post_data->{'last-name'};
	$data['FullName'] = $post_data->{'first-name'}." ".$post_data->{'last-name'};
	$data['RigisterType'] =  'linkedin';
	$data['CrmContact'] =  '1';
	$data['RigisterTypeID'] =  $id;
	$data['LinkedinID'] =  $id;
	//$data['LinkedinInfo'] =  serialize(array('ID'=>$id,'FirstName'=>$post_data->{'first-name'},'LastName'=>$post_data->{'last-name'},'FullName'=>$post_data->{'first-name'}." ".$post_data->{'last-name'},'Location'=>$post_data->location->name));
	$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
	}	
}	
	
		if($addCustId){
		$_SESSION['mess_social']='<div class="success">Added Successfully</div>';
		  header('Location: ' ._SiteUrl.'admin/crm/linkedin-connection.php' );
		die;
		}else{
		$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
		  header('Location: ' ._SiteUrl.'admin/crm/linkedin-connection.php' );
		die;

		}
}

	
	
/*
$savedata=$res=$addedleadCrm=$socialids=array();
if(!empty($_POST['userid'])){
   $connections = new SimpleXMLElement($response['linkedin']);
   $results=$connections->person;      
	$addedleadCrm=$objsocialcrm->getSocialLead('linkedin',array('id','social_id'));
	
	if(!empty($addedleadCrm)){
		foreach($addedleadCrm as $addedlead){		
			$socialids[]=$addedlead['social_id'];
		}
	}

	foreach($_POST['userid'] as $id){
			if(!in_array($results[$id]->id,$socialids)){
			$res['social_type']='linkedin';
			$res['social_id']==$results[$id]->id;
			$res['name']=$results[$id]->{'first-name'}.' '.$results[$id]->{'last-name'};
			$res['user_name']=$results[$id]->id;
			$res['location']=$results[$id]->location->name;
			$res['image']=addslashes($results[$id]->{'site-standard-profile-request'}->url);	
			$savedata[]=$res;
			}
	}
}

if(!empty($savedata)){

	$objsocialcrm->InsertMultiUserLead($savedata);
	$_SESSION['mess_social']='<div class="success">Add To CRM  Successfully</div>';
	  header('Location: ' ._SiteUrl.'admin/crm/linkedin-connection.php' ); 
	  die;
	  
}

*/
	
	
	
	
require_once("../includes/footer.php"); 
?>


