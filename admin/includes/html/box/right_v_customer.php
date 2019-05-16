<? if (!empty($_GET['view'])) { ?>
<div class="right-search">
    <h4><span class="icon"></span>
    <?php 
$titleImg = stripslashes(ucfirst($arryCustomer[0]['CustomerName']));
	echo $titleImg;
	 ?>
	
	
	</h4>
<div class="right_box">




  <div id="imgGal">

  <?php 
 
 

 
if($arryCustomer[0]['Image'] !='' && IsFileExist($Config['CustomerDir'],$arryCustomer[0]['Image']) ){ 	$ImageExist = 1;
 

	$PreviewArray['Folder'] = $Config['CustomerDir'];
	$PreviewArray['FileName'] = $arryCustomer[0]['Image']; 
	$PreviewArray['NoImage'] = $Prefix."images/nouser.gif";
	$PreviewArray['FileTitle'] = stripslashes($arryCustomer[0]['CustomerName']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
	echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';

}else{




   if(!empty($arryCustomer[0]['FacebookID']))
   $img='https://graph.facebook.com/'.$arryCustomer[0]['FacebookID'].'/picture';
   elseif(!empty($arryCustomer[0]['TwitterID'])){
   		require_once($Prefix."classes/socialCrm.class.php");
		
   		require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");
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
	        if(!empty($oauth_token)){
			$url="https://api.twitter.com/1.1/users/show.json";
			$getfield = '?user_id='.$userid;
			$requestMethod = 'GET';
			$twitter = new TwitterAPIExchange($settings);


			$aaa= $twitter->setGetfield($getfield)
			->buildOauth($url, $requestMethod)
			->performRequest();           
			$results=json_decode($aaa);


			$data = (array) $results;



			$data['image']=$data['profile_image_url'];
			if(!empty($data['profile_image_url']))
			$img=$data['profile_image_url'];
			else
			$img='images/nouser.gif';
		}else{
			$img='images/nouser.gif';
		}

	
		
   }
   else 
     $img='images/nouser.gif';
   ?>
    <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=<?php echo $img;?>" title="<?=$titleImg?>" /></div>
    <? } ?>

	  
	  
    </div>
	
	
<ul class="rightlink">	

	<?  
	include('../includes/html/box/right_v.php');		

	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){ 
		$arryRightMenuSales = $objConfigure->getRightMenuByDepId(8,$MainModuleID,2);
	
    		foreach($arryRightMenuSales as $arryRightM){ $LineRight++; ?>        	
			 <li <?=($_GET['tab']==$arryRightM['Link'])?("class='active'"):("");?>><a href="<?=$ViewUrl?><?=$arryRightM['Link'];?>" id="caption<?=$LineRight?>"><?=$arryRightM['Module'];?></a>			
			 
			 </li>    
   		<?php } ?>
	<? } ?>



<!--
	<li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$ViewUrl?>general">General Information</a></li>  
	<li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$ViewUrl?>contacts">Contacts</a></li>
	<li <?=($_GET['tab']=="social")?("class='active'"):("");?>><a href="<?=$ViewUrl?>social">Social Information</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$ViewUrl?>bank">Bank Details</a></li>
	<li <?=($_GET['tab']=="card")?("class='active'"):("");?>><a href="<?=$ViewUrl?>card">Credit Cards</a></li>
	<li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$ViewUrl?>billing">Billing Address</a></li>
	<li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$ViewUrl?>shipping">Shipping Address</a></li>
	<li <?=($_GET['tab']=="slaesPerson")?("class='active'"):("");?>><a href="<?=$ViewUrl?>slaesPerson">Sales Person</a></li>

<? 
if(empty($arryCompany[0]["Department"]) || substr_count($arryCompany[0]['Department'],8)==1){
?>
	<li <?=($_GET['tab']=="so")?("class='active'"):("");?>><a href="<?=$ViewUrl?>so">Sales Orders</a></li>
	<li <?=($_GET['tab']=="invoice")?("class='active'"):("");?>><a href="<?=$ViewUrl?>invoice">Invoices</a></li>
	<li <?=($_GET['tab']=="purchase")?("class='active'"):("");?>><a href="<?=$ViewUrl?>purchase">Purchase History</a></li>
	<li <?=($_GET['tab']=="linkvendor")?("class='active'"):("");?>><a href="<?=$ViewUrl?>linkvendor">Linked Vendor</a></li>
<? } ?>
-->

<? if($Config['CurrentDepID']==5){?>
	<li <?=($_GET['tab']=="comment")?("class='active'"):("");?>><a href="<?=$ViewUrl?>comment">Comments</a></li>
	<? if(in_array('104',$arryMainMenu)){?>
	<li <?=($_GET['tab']=="ticket")?("class='active'"):("");?>><a href="<?=$ViewUrl?>ticket">Tickets</a></li>
	<? } if(in_array('136',$arryMainMenu)){?>
	<li <?=($_GET['tab']=="event")?("class='active'"):("");?>><a href="<?=$ViewUrl?>event">Event / Task</a></li>
	<? } if(in_array('105',$arryMainMenu)){?>
	<li <?=($_GET['tab']=="document")?("class='active'"):("");?>><a href="<?=$ViewUrl?>document">Documents</a></li>
	<? } if(in_array('108',$arryMainMenu)){?>
	<li <?=($_GET['tab']=="quote")?("class='active'"):("");?>><a href="<?=$ViewUrl?>quote">Quotes</a></li>	
	<? }?>
<? }?>


<? if(empty($arryCompany[0]["Department"]) || substr_count($arryCompany[0]['Department'],5)==1){ 
	$EmailActive=$objConfig->isEmailActive(); 
	if($EmailActive==1){
?>
	<li <?=($_GET['tab']=="Email")?("class='active'"):("");?>><a href="vCustomer.php?view=<?=$_GET['view']?>&tab=Email">Email</a></li>
<? }}?>


	</ul>
  </div>
</div>

<? }else{
	$SetInnerWidth=1;
} ?>
