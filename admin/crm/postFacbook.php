<?php 




//ini_set('display_errors','1');
$ThisPageName = 'facebook.php';
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
	 
	 
	//$url = "/me/likes/775524905857737";
//$feed = $facebook->api($url,'GET');
//echo "<pre>";print_r($feed);die;
	 
	if($user){
//==================== Single query method ======================================
	try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	}catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
		
	}
 //==================== Single query method ends =================================
   }
   

 if(empty($user)){
 $errMsg = "Please log into Facebook. After that you can Post on facebook";
 } 
	 if(isset($_POST['Submit']) && (!empty($user))) {
		 //echo "<pre>";print_r()$_POST
		 
	$imageurl=$imagename='';
	
	 if(!empty($_FILES['picture_one'])){
		    $supportext=array('jpg','jpeg','png');
			$imagename = $_FILES['picture_one']['name'];
			$ext = pathinfo($imagename, PATHINFO_EXTENSION);
			if(!in_array($ext,$supportext)){
				$_SESSION['mess_social']='<div class="error">Please Upload Only PNG,JPG,JPEG Image</div>';
				 header('Location: ' . _SiteUrl.'admin/crm/postFacbook.php'); die;
			}
			$path=_ROOT.'/admin/crm/upload/socialimages/';
			$imagename=time().$imagename;
			  if(@move_uploaded_file($_FILES['picture_one']['tmp_name'], $path.$imagename)){
			
			  //$imageurl=file_get_contents(_SiteUrl.'admin/crm/upload/socialimages/'.$imagename);
			  $imageurl=_SiteUrl.'admin/crm/upload/socialimages/'.$imagename;
			  
			  }
		}
		
	 
			$params = array(
			"access_token" => $access_token, // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
			"message" =>  !empty($_POST['message'])?$_POST['message']:'',
			"link" =>  !empty($_POST['link'])?$_POST['link']:'',			
			"name" =>  !empty($_POST['name'])?$_POST['name']:'',
			"caption" =>  !empty($_POST['caption'])?$_POST['caption']:'',
			"description" => !empty($_POST['description'])?$_POST['description']:''
			);
			
			if(!empty($imageurl)){
				$params['picture']=$imageurl;
			}		
			$data['social_type']='facebook';
			$data['media']=$imageurl;
			$data['description']=!empty($_POST['description'])?$_POST['description']:'';
			$data['caption']=!empty($_POST['caption'])?$_POST['caption']:'';
			$data['link']=!empty($_POST['link'])?$_POST['link']:'';
			$data['name']=!empty($_POST['name'])?$_POST['name']:'';
			$data['post']=!empty($_POST['message'])?$_POST['message']:'';
		
		 
			try {
		
			 // $ret = $facebook->api('/100000551541052/feed/allow/100001679804091', 'POST', $params);
			  $ret = $facebook->api('/me/feed/', 'POST', $params);			  
			  if(!empty($ret['id'])){
			  	  $data['post_id']=$ret['id'];
				  $objsocialcrm->InsertSocialpost($data);
				  $_SESSION['mess_social']='<div class="success">Successfully posted to Facebook</div>';
				 header('Location: ' . _SiteUrl.'admin/crm/postFacbook.php'); die;		 
				  
			  }
			} catch(Exception $e) {		
			  $errMsg =  $e->getMessage();
			  	 $_SESSION['mess_social']='<div class="error">'.$errMsg.'</div>';
			}
	 }
		
		/*
				 // Save your method calls into an array
				$queries = array(
					array('method' => 'GET', 'relative_url' => '/'.$user),
					array('method' => 'GET', 'relative_url' => '/'.$user.'/friends'),
					array('method' => 'GET', 'relative_url' => '/'.$user.'/groups'),
					array('method' => 'GET', 'relative_url' => '/'.$user.'/likes'),
					);

				// POST your queries to the batch endpoint on the graph.
				try{
					$batchResponse = $facebook->api('?batch='.json_encode($queries), 'POST');
				}catch(Exception $o){
					error_log($o);
				}

				//Return values are indexed in order of the original array, content is in ['body'] as a JSON
				//string. Decode for use as a PHP array.
				$user_info		= json_decode($batchResponse[0]['body'], TRUE);
				$friends_list	= json_decode($batchResponse[1]['body'], TRUE);
				$groups			= json_decode($batchResponse[2]['body'], TRUE);
				$pages			= json_decode($batchResponse[3]['body'], TRUE);
			//========= Batch requests over the Facebook Graph API using the PHP-SDK ends =====
		 
	      if($_POST['message'] || $_POST['link'] || $_POST['picture']) {
			  
			echo "i am here";die;
			$body = array(
				'message'		=> $_POST['message'],
				'link'			=> $_POST['link'],
				'picture'		=> $_POST['picture'],
				'name'			=> $_POST['name'],
				'caption'		=> $_POST['caption'],
				'description'	=> $_POST['description'],
				);

			$batchPost=array();

			$i=1;
			$flag=1;
			foreach($_POST as $key => $value) {
				//if(strpos($key,"id_") === 0) {
					
					 echo "asdasda"."<pre>";print_r($batchPost);die;
					$batchPost[] = array('method' => 'POST', 'relative_url' => "/$value/feed", 'body' => http_build_query($body));
					echo "asdasda"."<pre>";print_r($batchPost);die;
					
					if($i++ == 1) {
						try{
							$multiPostResponse = $facebook->api('?batch='.urlencode(json_encode($batchPost)), 'POST');							
						}catch(FacebookApiException $e){
							error_log($e);
							echo("Batch Post Failed");
							exit();
						}
						$flag=0;
						unset($batchPost);
						$i=1;
					}
				}
			//}
			if(isset($batchPost) && count($batchPost) > 0 ) {
				try{
					$multiPostResponse = $facebook->api('?batch='.urlencode(json_encode($batchPost)), 'POST');
				}catch(FacebookApiException $e){
					error_log($e);
					echo("Batch Post Failed");
					exit();
				}
				$flag=0;
			}

		}
		else {
			$flag=2;
		}
	
	*/
	
	 
	 
	 
	require_once("../includes/footer.php"); 
?>


