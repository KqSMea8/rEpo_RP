<?php
$FancyBox=1;
$ThisPageName = 'google-plus.php';
$EditPage = 1;

//require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
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
//print_r($_GET);
//if(!empty($_GET['q']) && !empty($_GET['access_token'])) {
  $acc=$_GET['access_token'];
  //echo $acc;
    //echo '<pre>'; print_r($_POST);
   $url ='https://www.googleapis.com/plus/v1/people/me/people/visible?access_token='.$acc;
   //echo $url;
   $plusresults = $objsocialcrm->google_plus($url);
    //echo '<pre>'; print_r($plusresults);
   //$token=$plusresults->nextPageToken;
    //echo '<br> <br><br>Tokenn ';
   //echo $token;
   //echo '<br><br><br> netURL';
   //$urlnextpagetoken=_SiteUrl.'admin/crm/google-plus.php?q='.$name.'&pageToken='.$token.'&access_token='.$access_token;
 
//}
// FOR add and Existing Customer
   
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

if($_POST){
	   
	    $type = $_POST['action-type'];
            $uder_id=$_POST['userid'][0];
            //echo $uder_id;
            //echo $type;die;
		
		//$post_data = $results[$_POST['userid'][0]];
                
                //print_r($post_data);die;
		$userexist =  $objsocialcrm->checkUserexist($uder_id,$type);
                //print_r($userexist);die;
		
		# check customer or contact
		if($type=="add_customer"){
			if($userexist==true){
		
			$data['GoogleID'] =  $uder_id;
                        //print_r($data['GoogleID']);die;
			
			///echo "<pre>";print_r($data);die;
			$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
                        //print_r($addCustId);die;
			}
		}else{
			if($userexist==true){
			
			$data['GoogleID'] =  $uder_id;
			
			$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
                        //print_r($addCustId);die;
			}	
		}
		
		
		if($addCustId){
                    //echo 'hello';
		$_SESSION['mess_social']='<div class="success">Added Successfully</div>';
		header('Location: ' ._SiteUrl.'admin/crm/friends-google-plus.php?'.$_SERVER['QUERY_STRING'] ); 
		die;
		
		}else{

		$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
		header('Location: ' ._SiteUrl.'admin/crm/friends-google-plus.php?'.$_SERVER['QUERY_STRING'] ); 
		die;

		}	
		//$AddID = $objCustomer->addCustomerAddress($_POST,$addCustId,'contact');
}
require_once("../includes/footer.php"); 
?>






