<script>
function SaveSocialData(obj, id, type){
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	}

</script>
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='fullcalendar/css-Twitter.css' rel='stylesheet' />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
       
		
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}
                

          .twlogout {
    
    margin-top: 43px;
    
}
.twlist {display: inline-block;
    float: right;
    margin-top: -6px;}
</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />

</head>
<body>


<script>
jQuery(document).ready(function() {
    
$("#opener").click(function() {
	jQuery("#dialog").dialog(opt).dialog("open");
});
});

function addtocrm(iduser) {
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 415,
        height:150,
        title: 'Add User'
       };
	 
	var divID =  ".adduser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	
}

function addtoexistingcrm(iduser) {
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 415,
        height:150,
        title: 'Add Existing User'
       };
	var divID =  ".addexistinguser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	   
}	   
</script>

<div id="Event" >
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td align="left"><div class="had">Twitter</div></td>
              <td align="right" class="twlist">		
	      <a class="fancybox add_quick" href="viewTwitterPost.php" style="width: 83%;">Tweet List</a>
	      <a style="display:none;" class="add" href="viewTwitterContact.php">Contact List</a>
	  
	 	 </td>
</tr>
 <tr>
  <td align="left">		
	  <?php    echo '</ul>';
	echo '<ul class="header-user-board">';
	$i=0;
	if(!empty($twitterdata[0])){	
	echo '<li>';
	echo '<div class="image-box" style="display:none"><img src="'.$twitterdata[0]['image'].'"></div>';

	
	echo '<div class="logout" style="margin-top: -43px;"><a href="'._SiteUrl.'admin/crm/Twitter.php?action=disassociate&id='.$twitterdata[0]['id'].'"><button class="twlogout" onclick="javascript:logout();"></button></a></div>';
        echo '<div class="name">'.$twitterdata[0]['name'].'!</div>';
	echo '</li>';
	}
	echo '</ul>';?>
	      
	 	 </td>
 </tr>

<tr>
    <td  align="center" valign="top" >
    
    <?php if(!empty($settings['oauth_access_token']) AND !empty($settings['oauth_access_token_secret'])){?>
			
			<? if (!empty($_SESSION['mess_social'])) {?>
			<div>
			<span  align="center"  class="message"  >
				<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
			</span>
			</div>
			<? } ?>
<form name="form1" action=""  method="post" id="socialfrom" enctype="multipart/form-data">
<div> 

<?php 

if(!empty($results->users)){
	echo '<h2 class="search-result">Follower List:</h2>';
	echo '<ul class="user-list">';
	$i=0;
	foreach($results->users as $result){	
	echo '<li>';
	echo '<div class="top"><div class="pfname"><a href="https://twitter.com/'.$result->screen_name.'" target="_blank">&nbsp;'.$result->name.'</a></div><div class="image-set" align="center"><span class="pimg"><img src="'.str_replace('normal', 'bigger',$result->profile_image_url).'"></span>';
            echo '</div>';
	echo '<div class="detail-box"><div class="pbtn"><span class="view-profiletw"><a href="https://twitter.com/'.$result->screen_name.'" target="_blank" title="View Twitter Profile"></a></span>
	
	<span class="add-profile"><a href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')" title="Add New"></a></span>
	<span class="exiting-profile"><a href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')" title="Add Existing"></a></span>';
	 
	 if(in_array($result->id,$all_result)){
		echo  '<input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px;">';
	}
    echo '</div></div></div>';
	echo '<div class="down"><div class="plable-data">';
	
	echo '<div class="pdata"><div class="plable"><label>Screen Name </label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->screen_name.'</div></div>';
	echo '<div class="pdata"><div class="plable"><label>Location </label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->location.'</div></div>';
	echo '<div class="pdata"><div class="plable"><label>followers count </label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->followers_count.'</div></div>';	
	echo '<div class="pdata"><div class="plable"><label>friends count </label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->friends_count.'</div></div></div></div>';
	# start for Existing			
		echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
		if(in_array($result->id,$contact_result)){	
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
		} else{ 
		echo '<a href="searchContact.php?type=twitter&sid='.$result->id.'&FullName='.$result->name.'&Location='.$result->location.'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
		}

		if(in_array($result->id,$customer_result)){
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
		}else{	
		echo '<a href="searchCustomer.php?type=twitter&sid='.$result->id.'&FullName='.$result->name.'&Location='.$result->location.'"  class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
		}
		echo'</div></div>';
# start for new 		
			echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
			if(in_array($result->id,$contact_result)){			  
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

			}else{
			echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
			}

			if(in_array($result->id,$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
			}else{

			echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
			}
			echo  '</div></div>';	
	
	echo '</li>';
	$i++;
	
	}
	echo '</ul>';
	echo '<div class="form-action">
	<input type="hidden" class="userid-set" name="userid[]">
	<input type="hidden" class="action-type" name="action-type">
	<input style="display:none;" type="submit" value="Add Contact" style="display:none;"/></div>';
	

}?>

</div>
<?php }else{

echo '<div class="twitter-login-button"><div class="social-login-box"><a href="'._SiteUrl.'admin/crm/Twitter.php?action=redirect"><img src="images/LoginTwitter.png"></a></div></div>';

}

?>
</td>
   </tr>

   </form>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>

