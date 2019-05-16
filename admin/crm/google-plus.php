<?php
$FancyBox=1;
//require_once("../../define.php");
require_once("../includes/header.php");
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

//echo _SiteUrl;die;
$frndurl='';
if(!empty($_GET['q']) && !empty($_GET['access_token'])) {
	
    //echo '<pre>'; print_r($_POST);
    $name=$_GET['q'];
    $access_token=$_GET['access_token'];
    $frndurl='friends-google-plus.php?access_token='.$access_token;
    $url='https://www.googleapis.com/plus/v1/people?query='.$name;
     if(!empty($_GET['pageToken']))
      $url .= '&pageToken='.$_GET['pageToken']; 
    
     $url .='&access_token='.$access_token;
     $url .='&maxResults=12';
     
    //$url='https://www.googleapis.com/plus/v1/activities?query='.$name.'&access_token='.$access_token;
    //echo $url;
    //ini_set('display_errors',1);
   $plusresults = $objsocialcrm->google_plus($url);
    //echo '<pre>'; print_r($plusresults);
   $token=$plusresults->nextPageToken;
    //echo '<br> <br><br>Tokenn ';
   //echo $token;
   //echo '<br><br><br> netURL';
  
   $urlnextpagetoken=_SiteUrl.'admin/crm/google-plus.php?q='.$name.'&pageToken='.$token.'&access_token='.$access_token;
 
}

#get customers data for Google Plus
$arg_cust_google =array();
$arg_cust_google['table'] = "s_customers";
$arg_cust_google['where']= "GoogleID <> ''";
$arg_cust_google['fields']= "GoogleID";
$customer_result =  $objsocialcrm->GetAllData($arg_cust_google);
//print_r($customer_result);


#get contact data for Google Plus
$arg_cont_google =array();
$arg_cont_google['table'] = "s_address_book";
$arg_cont_google['where']= "GoogleID <> ''";
$arg_cont_google['fields']= "GoogleID";
$contact_result =  $objsocialcrm->GetAllData($arg_cont_google);


$all_result =  array_merge($customer_result,$contact_result);

//print_r($_POST);
//print_r($_POST);

if($_POST){
	    //print_r($_POST);die;
	    $type = $_POST['action-type'];
            $uder_id=$_POST['userid'][0];
            $name=$_POST[displayname]; 
            //echo $uder_id;
            //echo $type;die;
		
		//$post_data = $results[$_POST['userid'][0]];
                
                //print_r($post_data);die;
		$userexist =  $objsocialcrm->checkUserexist($uder_id,$type);
                //print_r($userexist);die;
		
		# check customer or contact
		if($type=="add_customer"){
			if($userexist==true){
		        $data['FirstName'] = $name;
                        //print_r($data['FirstName']);die('hello');
			$data['GoogleID'] =  $uder_id;
                        $data['RigisterType'] =  'google';
                        //$data['GOOGLEInfo'] =  serialize(array('ID'=>$post_data['first_name'],'FirstName'=>$post_data['last_name'],'LastName'=>$post_data['last_name'],'FullName'=>$post_data['name'],'Gender'=>$post_data['gender']));
                        //print_r($data['GoogleID']);die;
			
			///echo "<pre>";print_r($data);die;
			$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
                        //print_r($addCustId);die;
			}
		}else{
			if($userexist==true){
			
			$data['GoogleID'] =  $uder_id;
                        $data['FirstName'] = $name;
                        $data['RigisterType'] =  'google';
                        $data['CrmContact'] =  '1';
			
			$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
                        //print_r($addCustId);die;
			}	
		}
		
		
		if($addCustId){
                    //echo 'hello';
		$_SESSION['mess_social']='<div class="success">Added Successfully</div>';
		header('Location: ' ._SiteUrl.'admin/crm/google-plus.php?'.$_SERVER['QUERY_STRING'] ); 
		die;
		
		}else{

		$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
		header('Location: ' ._SiteUrl.'admin/crm/google-plus.php?'.$_SERVER['QUERY_STRING'] ); 
		die;

		}	
		//$AddID = $objCustomer->addCustomerAddress($_POST,$addCustId,'contact');
}

require_once("../includes/footer.php"); 
?>






