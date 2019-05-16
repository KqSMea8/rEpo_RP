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

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '211257059004768',
  'secret' => '665bfd2c2b00202414ee26933d839756',
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
	
	
	 $user_id =  array();
	 if(count($results)>0){
		 $paging = $results->paging; 
		 foreach($results->data as $val){
			 $user_id[] = $val->id;   // get all profile id
			   
		 } 
	 }
	 
	 // get profile 
     if(count($user_id)>0){
		 foreach($user_id as $userid){
	        $search_user['userdata'][] = $facebook->api('/'.$userid);
	    }
		$search_user['paging'] =  $paging;
	 }
	 
}

$results=$search_user['userdata'];
$savedata=$res=$addedleadCrm=$socialids=array();
if(!empty($_POST['userid']) AND !empty($results)){
	CleanPost(); 
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


require_once("../includes/footer.php"); 
?>






