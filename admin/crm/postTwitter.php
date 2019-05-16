<?php 

$ThisPageName = 'Twitter.php';
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
		
	require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");
	require_once($Prefix."classes/socialCrm.class.php");
/********************************** Start Twitter Api **************************/
	require_once(_ROOT.'/lib/twitter/twitteroauth.php');
	require_once(_ROOT.'/lib/twitter/Twitterconfig.php');
	$oauth_token_secret=$oauth_token='';
	$objsocialcrm=new socialcrm();
	$data=$twitterdata=array();	
	$twitterdata=$objsocialcrm->getSocialUserConnect('twitter',array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));
	$oauth_token=$twitterdata[0]['user_token'];
	$oauth_token_secret=$twitterdata[0]['user_token_secret'];
	$settings = array(
    'oauth_access_token' =>$oauth_token,
    'oauth_access_token_secret' => $oauth_token_secret,
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);


$results=array();
/*
$page=!empty($_GET['page'])?$_GET['page']:1;
if(!empty($_GET['q'])){
$url="https://api.twitter.com/1.1/users/search.json";
$getfield = '?q='.urlencode($_GET['q']).'&amp;page='.$page.'&amp;include_entities=true';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
            
           $results=json_decode($aaa);
           
}*/



             
              
	 if (!empty($_POST)) {
	 
		$url = 'https://api.twitter.com/1.1/statuses/update_with_media.json';
		$requestMethod = 'POST';
		$supportext=array('jpg','jpeg','png');
		$imageurl='';
		/** POST fields required by the URL above. See relevant docs as above **/
			$errorvalidate=array();
		/*	if(empty($_FILES['picture']['name']))
			{
				$errorvalidate['picture']='Please Select Image';			
			}*/
			if(empty($_POST['message'])){
			$errorvalidate['message']='Please Enter Message';	
			
			}
			if(empty($errorvalidate)){
		if(!empty($_FILES['picture']['name'])){
		
			$imagename = $_FILES['picture']['name'];
			$ext = pathinfo($imagename, PATHINFO_EXTENSION);
			if(!in_array($ext,$supportext)){
				$_SESSION['mess_social']='<div class="error">Please Upload Only PNG,JPG,JPEG Image</div>';
				 header('Location: ' . _SiteUrl.'admin/crm/postTwitter.php'); die;
			}
			$path=_ROOT.'/admin/crm/upload/socialimages/';
			$imagename=time().$imagename;
			  if(@move_uploaded_file($_FILES['picture']['tmp_name'], $path.$imagename)){
			
			  $imageurl=file_get_contents(_SiteUrl.'admin/crm/upload/socialimages/'.$imagename);
			  
			  }
		}
		
		if(empty($_FILES['picture']['name'])){
			$url = 'https://api.twitter.com/1.1/statuses/update.json';		
		
		}
		
		
		$postfields = array(
		    'status' => $_POST['message'], 		  
		);		
		if(!empty($imageurl))
		$postfields['media[]']=$imageurl;
		/** Perform a POST request and echo the response **/
		$twitter = new TwitterAPIExchange($settings);
		$results= $twitter->buildOauth($url, $requestMethod)
		             ->setPostfields($postfields)
		             ->performRequest();	
		$data=array();
		$results=json_decode($results);	
		
		if(!empty($results->id)){
		$data['social_type']='twitter';
		$data['post_id']=$results->id;
		$data['post']=!empty($_POST['message'])?addslashes($_POST['message']):'';
		$medias=array();
		$posturl='';
		if(!empty($results->entities->media)){
		$posturl=$results->entities->media[0]->expanded_url;
		foreach($results->entities->media as $media){
			$medias[]=$media->media_url;
		
		}
			if(!empty($medias))
			$medias=implode('~~@!~',$medias);
			else 
			$medias='';
		}
		$data['media']=$medias;
		$data['description']='';
		$data['caption']='';
		$data['link']=!empty($posturl)?$posturl:'';
		$objsocialcrm->InsertSocialpost($data);
		$_SESSION['mess_social']='<div class="success">Tweet Successfully</div>';
		 header('Location: ' . _SiteUrl.'admin/crm/postTwitter.php'); die;	
		}else{
			$_SESSION['mess_social']='<div class="error">Failed to Tweet</div>';
		
		}  
	}else{
		$_SESSION['mess_social']='<div class="error">Please Fill Requried Field</div>';
		}
		
	 }
	require_once("../includes/footer.php"); 
?>


