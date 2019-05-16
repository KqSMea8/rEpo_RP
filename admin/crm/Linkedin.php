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
/********************************** Start Twitter Api **************************/
$objsocialcrm=new socialcrm();
function oauth_session_exists() {
  if((is_array($_SESSION)) && (array_key_exists('oauth', $_SESSION))) {
    return TRUE;
  } else {
    return FALSE;
  }
}	





try {
  // include the LinkedIn class
  require_once(_ROOT.'/lib/linkedin/linkedin_3.2.0.class.php');
  
  // start the session
  if(!session_start()) {
    throw new LinkedInException('This script requires session support, which appears to be disabled according to session_start().');
  }
  
  // display constants
  $API_CONFIG = array(
          'appKey'       => '75pnp6i91ecr8l',
	  'appSecret'    => 'rW8BgG9sPpQvaEvi',
	  'callbackUrl'  => NULL 
  );
  define('DEMO_GROUP', '4010474');
  define('DEMO_GROUP_NAME', 'Simple LI Demo');
  define('PORT_HTTP', '80');
  define('PORT_HTTP_SSL', '443');

  // set index
 

  $_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';

  if($_REQUEST[LINKEDIN::_GET_TYPE]=='initiate'){
   
      /**
       * Handle user initiated LinkedIn connection, create the LinkedIn object.
       */
        
      // check for the correct http protocol (i.e. is this script being served via http or https)
      if($_SERVER['HTTPS'] == 'on') {
        $protocol = 'https';
      } else {
        $protocol = 'http';
      }
      echo $protocol;
      // set the callback url
      $API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
	
     $OBJ_linkedin = new LinkedIn($API_CONFIG);   
	 
      // check for response from LinkedIn
      $_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
      if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
        // LinkedIn hasn't sent us a response, the user is initiating the connection
        
        // send a request for a LinkedIn access token
        $response = $OBJ_linkedin->retrieveTokenRequest(); 
//        print_r($response);
//        die;
        if($response['success'] === TRUE) {
          // store the request token
          $_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
          
          // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.        
          header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
        } else {
          // bad token request
          //$error = "Request token retrieval failed:<br /><br />RESPONSE:<br /><br />" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
          $error = "Request token retrieval failed";
        }
      } else {
      
        // LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
        $response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
		 $profile= $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address,phone-numbers)');     
              $profiledata = new SimpleXMLElement($profile['linkedin']);
              $profiledata =	(array) $profiledata;             
              //echo "<pre>" . print_r($profiledata->SimpleXMLElement, TRUE) . "</pre>";
         
    
      
        if($response['success'] === TRUE) {
      
          // the request went through without an error, gather user's 'access' tokens
          	$data['social_type']='linkedin';
			$data['social_id']=$profiledata['id'];
			$data['name']=$profiledata['first-name'].' '.$profiledata['last-name'];
			$data['user_name']=$profiledata['email-address'];
			$data['location']='';
			$data['image']= $profiledata['picture-url'];
			$data['user_token']=$response['linkedin']['oauth_token'];
			$data['user_token_secret']=$response['linkedin']['oauth_token_secret'];	
		//	print_r($_SESSION['oauth']['linkedin'])
			$check=$objsocialcrm->getSocialUserConnect('linkedin',array('id'));						
			if(empty($check[0]['id']))
			$objsocialcrm->SaveSocialConnect($data);
			else
			$objsocialcrm->UpdateSocialConnect($data,array('id'=>$check[0]['id']));
      
          $_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];
          
          // set the user as authorized for future quick reference
        $_SESSION['oauth']['linkedin']['authorized'] = TRUE;            
          // redirect the user back to the demo page
          header('Location: ' . $_SERVER['PHP_SELF']);
        } else {
          // bad token access
         // echo "Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
          $error = "Request token retrieval failed";
        }
      }
  
  }
 
} catch(LinkedInException $e) {
  // exception raised by library call
  //echo $e->getMessage();
}


$savedata=$res=$addedleadCrm=$socialids=array();
if(!empty($_POST['userid']) AND !empty($results)){
	CleanPost(); 
	$addedleadCrm=$objsocialcrm->getSocialLead('linkedin',array('id','social_id'));
	
	if(!empty($addedleadCrm)){
		foreach($addedleadCrm as $addedlead){		
			$socialids[]=$addedlead['social_id'];
		}
	}

	foreach($_POST['userid'] as $id){
			if(!in_array($results[$id]->id,$socialids)){
			$res['social_type']='linkedin';
			$res['social_id']=$results[$id]->id;
			$res['name']=$results[$id]->name;
			$res['user_name']=$results[$id]->screen_name;
			$res['location']=$results[$id]->location;
			$res['image']=addslashes($results[$id]->profile_image_url);	
			$savedata[]=$res;
			}
	}
}

if(!empty($savedata)){

	$objsocialcrm->InsertMultiUserLead($savedata);
	  header('Location: ' ._SiteUrl.'admin/crm/Twitter.php?q='.$_GET['q'] ); 
	  
}
$Linkedindata=array();
$oauth_token_linkedin=$oauth_token_linkedin='';
$Linkedindata=$objsocialcrm->getSocialUserConnect('linkedin',array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));

$oauth_token_linkedin=$Linkedindata[0]['user_token'];
$oauth_token_secret_linkedin=$Linkedindata[0]['user_token_secret'];

//$addedleadCrm=$objsocialcrm->getSocialLead('twitter',array('id'));
//print_r($addedleadCrm); 
$_GET['Status']=1;$_GET['Division']=5;

require_once("../includes/footer.php"); 
?>






