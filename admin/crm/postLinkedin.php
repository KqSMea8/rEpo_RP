<?php 
//ini_set('display_errors',1);
$ThisPageName = 'Linkedin.php';
$EditPage = 1;
 /**************************************************
     #echo $ThisPageName;
    /**************************************************/
	require_once("../../define.php");
	require_once("../includes/header.php");
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

  // set index
 // echo LINKEDIN;
  //print_r($_REQUEST[LINKEDIN::_GET_TYPE]);
  $_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';
 
} catch(LinkedInException $e) {
  // exception raised by library call
  echo $e->getMessage();
}



if($_POST){
	//echo "<pre>";print_r($_POST);die;
	$errorvalidate=array();
		if(empty($_POST['scomment'])){
		$errorvalidate['scomment']='Please Enter Comment';	
		}
		if(empty($_POST['stitle'])){
		$errorvalidate['stitle']='Please Enter Title';	
		}	 
		 if(empty($_POST['sdescription'])){
		$errorvalidate['sdescription']='Please Enter Description';	
		}
	if(empty($errorvalidate)){
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
      $content = array();
      if(!empty($_POST['scomment'])) {
        $content['comment'] = $_POST['scomment'];
      }
      if(!empty($_POST['stitle'])) {
        $content['title'] = $_POST['stitle'];
      }
      if(!empty($_POST['surl'])) {
        $content['submitted-url'] = $_POST['surl'];
      }
	$imageurl='';
	 if(!empty($_FILES['simgurl']['name'])){
		    $supportext=array('jpg','jpeg','png','gif');
			$imagename = $_FILES['simgurl']['name'];
			 $ext = pathinfo($imagename, PATHINFO_EXTENSION);
			if(!in_array($ext,$supportext)){
				$_SESSION['mess_social']='<div class="error">Please Upload Only PNG,JPG,JPEG,GIF Image</div>';
				 header('Location: ' . _SiteUrl.'admin/crm/postLinkedin.php'); die;
			}
			$path=_ROOT.'/admin/crm/upload/socialimages/';
			$imagename=time().$imagename;
			  if(@move_uploaded_file($_FILES['simgurl']['tmp_name'], $path.$imagename)){
			
			  //$imageurl=file_get_contents(_SiteUrl.'admin/crm/upload/socialimages/'.$imagename);
				  $imageurl=_SiteUrl.'admin/crm/upload/socialimages/'.$imagename;
			  
			  }else{
				$_SESSION['mess_social']='<div class="success">Image Upload Failed</div>';
				header('Location: ' . _SiteUrl.'admin/crm/postLinkedin.php'); die;			
			  
			  }
		}
      
      
      if(!empty($imageurl)) {
        $content['submitted-image-url'] = $imageurl;
      }
      if(!empty($_POST['sdescription'])) {
        $content['description'] = $_POST['sdescription'];
      }
      if(!empty($_POST['sprivate'])) {
        $private = TRUE;
      } else {
        $private = FALSE;
      }
	   $private = TRUE;	 
      $response = $OBJ_linkedin->share('new', $content, $private);
      if($response['success'] === TRUE) {
       	 	$linkedindata = new SimpleXMLElement($response['linkedin']);
            $linkedindata =	(array) $linkedindata;           
    		$data['social_type']='linkedin';
			$data['media']=$imageurl;
			$data['description']=!empty($_POST['sdescription'])?$_POST['sdescription']:'';			
			$data['link']=!empty($linkedindata['update-url'])?$linkedindata['update-url']:'';
			$data['caption']=!empty($_POST['surl'])?$_POST['surl']:'';
			$data['name']=!empty($_POST['stitle'])?$_POST['stitle']:'';
			$data['post']=!empty($_POST['scomment'])?$_POST['scomment']:'';
			$data['post_id']=!empty($linkedindata['update-key'])?$linkedindata['update-key']:'';
			$objsocialcrm->InsertSocialpost($data);
			$_SESSION['mess_social']='<div class="success">Post Successfully</div>';
			header('Location: ' . _SiteUrl.'admin/crm/postLinkedin.php'); die;			
       
      } else {
        // an error occured
      //  echo "Error sharing content:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
		$_SESSION['mess_social']='<div class="error">Error sharing content:</div>';
      }
	}else{
		$_SESSION['mess_social']='<div class="error">Please Fill Required Fields</div>';
	
	}
	
}

	
	
	
	
require_once("../includes/footer.php"); 
?>


