<?php
$FancyBox=1;
require_once("../../define.php");
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
//Start for search

if(isset($_REQUEST['submit']))
{
        //echo '<pre>';print_r($_SESSION);die;
	$acc_tocken=$_SESSION['accessToken'];
	$q=$_GET['q'];
	//$Surl="https://api.instagram.com/v1/users/search?q=$q&scope=public_content&access_token=$acc_tocken";
        $Surl="https://api.instagram.com/v1/users/search?q=$q&access_token=$acc_tocken";
        //echo $Surl;
	$res=file_get_contents($Surl);
	$Dres=json_decode($res);//print_r($Dres);
	//foreach($Dres->data as $g){echo $g->full_name;}
}

//end code for search

#get customers data for Instagram
$arg_cust_instagram =array();
$arg_cust_instagram['table'] = "s_customers";
$arg_cust_instagram['where']= "InstagramID <> ''";
$arg_cust_instagram['fields']= "InstagramID";
$customer_result =  $objsocialcrm->GetAllData($arg_cust_instagram);
//print_r($customer_result);

#get contact data for Instagram
$arg_cust_instagram =array();
$arg_cust_instagram['table'] = "s_address_book";
$arg_cust_instagram['where']= "InstagramID <> ''";
$arg_cust_instagram['fields']= "InstagramID";
$contact_result =  $objsocialcrm->GetAllData($arg_cust_instagram);
//print_r($contact_result);


$all_result =  array_merge($customer_result,$contact_result);

//print_r($_POST);
//print_r($_POST);

if($_POST)
{
	CleanPost(); 

	$type = $_POST['action-type'];
        $uder_id=$_POST['userid'][0];
        $name=$_POST['full_name']; 
        //echo $uder_id;
		//echo $name;die;
        //echo $type;die;
		//$post_data = $results[$_POST['userid'][0]];       
        //print_r($post_data);die;
		$userexist=$objsocialcrm->checkUserexist($uder_id,$type);
        //print_r($userexist);die;
		
		# check customer or contact
		if($type=="add_customer")
		{
			if($userexist==true)
			{
		         $data['FirstName']=$name;
                        //print_r($data['FirstName']);die('hello');
		         $data['InstagramID']=$uder_id;
                         $data['RigisterType']='instagram';
                        //$data['GOOGLEInfo'] =  serialize(array('ID'=>$post_data['first_name'],'FirstName'=>$post_data['last_name'],
							//'LastName'=>$post_data['last_name'],'FullName'=>$post_data['name'],'Gender'=>$post_data['gender']));
                        //print_r($data['GoogleID']);die;	
				//echo "<pre>";print_r($data);die;
				$addCustId=$objsocialcrm->SaveSocialData($data,$type);
                        //print_r($addCustId);die;
			}
		}
		else
		{
			if($userexist==true)
			{
				//echo 'hello chu';
				$data['InstagramID']=$uder_id;
                                $data['FirstName']=$name;
                                $data['RigisterType']='instagram';
                                $data['CrmContact']='1';
                //print_r($data);die;
		$addCustId=$objsocialcrm->SaveSocialData($data,$type);
                 //print_r($addCustId);die;
			}	
		}
		
		
		if($addCustId)
		{
                    //echo 'hello';
			$_SESSION['mess_social']='<div class="success">Added Successfully</div>';
			header('Location:' ._SiteUrl.'admin/crm/instagram.php?'.$_SERVER['QUERY_STRING']); 
			die;
		
		}
		else
		{
			$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
			header('Location:' ._SiteUrl.'admin/crm/instagram.php?'.$_SERVER['QUERY_STRING']); 
			die;

		}	
		//$AddID = $objCustomer->addCustomerAddress($_POST,$addCustId,'contact');
}
require_once("../includes/footer.php"); 
?>
