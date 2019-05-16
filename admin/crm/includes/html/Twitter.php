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
<link href="fullcalendar/search-box.css" type="text/css" rel="stylesheet" media="screen" />
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
                
                                    
                                    
                                 
                                  /* for sexy search box*/
                                               #searchbox
{
background: rgba(117,207,240,0.97);
background: -moz-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(117,207,240,0.97)), color-stop(0%, rgba(117,207,240,0.99)), color-stop(99%, rgba(117,207,240,1)), color-stop(100%, rgba(117,207,240,1)));
background: -webkit-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: -o-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: -ms-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: linear-gradient(to bottom, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#75cff0', endColorstr='#75cff0', GradientType=0 );

    border-radius: 35px;    
    border-width: 1px;
    border-style: solid;
    border-color: #c4d9df #a4c3ca #83afb7;            
    width: 500px;
    height: 35px;
    padding: 10px;
    margin-top: 27px;
   /* margin: 100px auto 50px;*/
    overflow: hidden; /* Clear floats */
}
/*
Below you can see the current result:

Form wrapper styles
Inputs styles
*/
#search, 
#submit {
    float: left;
}

#search {
    padding: 5px 9px;
    height: 23px;
    width: 380px;
    border: 1px solid #a4c3ca;
    font: normal 13px 'trebuchet MS', arial, helvetica;
    background: #fff;
    border-radius: 50px 3px 3px 50px;
    /*box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25) inset, 0 1px 0 rgba(255, 255, 255, 1);*/            
}

/* ----------------------- */

#submit
{       

background: rgba(241,109,34,1);
background: -moz-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,109,34,1)), color-stop(0%, rgba(245,144,31,1)), color-stop(100%, rgba(248,80,50,1)));
background: -webkit-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: -o-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: -ms-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: linear-gradient(to bottom, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f16d22', endColorstr='#f85032', GradientType=0 );

    border-radius: 3px 50px 50px 3px;    
    border-width: 1px;
    border-style: solid;
    /*border-color: #7eba7c #578e57 #447d43;*/
    border-color: #d68356 #f16e22 #f05c23;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.3), 
                0 1px 0 rgba(255, 255, 255, 0.3) inset;
    height: 35px;
    margin: 0 0 0 10px;
    padding: 0;
    width: 90px;
    cursor: pointer;
    font: bold 14px Arial, Helvetica;
    color: #fff;    
    text-shadow: 0 1px 0 rgba(255,255,255,0.5);
}

#submit:hover {       
    
background: rgba(240,47,23,1);
background: -moz-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(240,47,23,1)), color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(248,80,50,1)), color-stop(100%, rgba(245,144,31,1)));
background: -webkit-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: -o-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: -ms-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: linear-gradient(to bottom, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f02f17', endColorstr='#f5901f', GradientType=0 );
}   

#submit:active {       
    /*background: #95d788;*/
    background: rgba(241,109,34,1);
    outline: none;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5) inset;        
}

#submit::-moz-focus-inner {
       border: 0;  /* Small centering fix for Firefox */
}
#search::-webkit-input-placeholder {
   color: #9c9c9c;
   font-style: italic;
}

#search:-moz-placeholder {
   color: #9c9c9c;
   font-style: italic;
}  

#search:-ms-placeholder {
   color: #9c9c9c;
   font-style: italic;
}

input[type="text"] {
                                                    
                            margin-left: 0px !important;
                          margin-top: 0px !important;
                          text-align: left !important;
                                                }
.social-login-box {
    margin-top: -14px;
}                                             

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
        height: 150,
        title: 'Add Existing User'
       };
	var divID =  ".addexistinguser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	   
}	   
</script>
<? if($ModifyLabel==1){?>
<?php if(!empty($settings['oauth_access_token']) AND !empty($settings['oauth_access_token_secret'])){?>
       <a style="float:right;" class="add" href="twitter-follower.php">Follower List</a>
         <a style="float:right;" class="fancybox add_quick" href="viewTwitterPost.php">Tweet List</a>
          <a style="float:right;" class="fancybox add_quick" href="postTwitter.php">Tweet</a>
                    
	     <!-- <a class="add" href="viewTwitterContact.php">Contact List</a> -->
 <?php } } ?>
 

<div id="Event" >
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td><div class="had" style="float: left;">Twitter</div></td></tr>
 <tr>
  <td align="left">		
	  <?php    echo '</ul>';
	echo '<ul class="header-user-board">';
	$i=0;
	
	if(!empty($twitterdata[0]['user_token']) AND !empty($twitterdata[0]['user_token_secret'])){	
	echo '<li>';
	echo '<div class="image-box" style="display:none"><img src="'.$twitterdata[0]['image'].'"></div>';

	
	echo '<div class="logout"><a href="'._SiteUrl.'admin/crm/Twitter.php?action=disassociate&id='.$twitterdata[0]['id'].'"><button onclick="javascript:logout();" class="twlogout" ></button></a></div>';
	echo '<div class="name">'.$twitterdata[0]['name'].'!</div>';				
	echo '</li>';
	}
	echo '</ul>';?>
	      
	 	 </td>
 </tr>
 <?php if(!empty($settings['oauth_access_token']) AND !empty($settings['oauth_access_token_secret'])){?>

<tr>
    <td  align="center" valign="top" >
    
    
			<form action="" method="get" id="searchbox">
				<input id="search" name="q" value="<?php echo !empty($_GET['q'])?$_GET['q']:'Search';?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '<?php echo !empty($_GET['q'])?$_GET['q']:'Search';?>';}">
                                <input id="submit" type="submit" value="Search">
                            
			</form>
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

if(!empty($results)){
	echo '<h2 class="search-result">Search Results:</h2>';
echo '<ul class="paging">';
if($page>1){
echo '<li class="prev-page"><a href="?q='.$_GET['q'].'&page='.($page+1).'"><< Prev</a></li>';
}
if(count($results)>=20 ){
echo '<li class="next-page"><a href="?q='.$_GET['q'].'&page='.($page+1).'">Next >></a></li>';
}
echo '</ul>';
	echo '<ul class="user-list">';
	$i=0;
	foreach($results as $result){	
		echo '<li>';
		echo '<div class="top"><div class="pfname"><a href="https://twitter.com/'.$result->screen_name.'" target="_blank">&nbsp;'.$result->name.'</a></div><div class="image-set" align="center"><span class="pimg"><img src="'.str_replace('normal', 'bigger',$result->profile_image_url).'"></span>';
                 
		
		echo '</div>';
                echo '<div class="detail-box"><div class="pbtn">
                    <span class="view-profiletw"><a href="https://twitter.com/'.$result->screen_name.'" target="_blank" rel="view Profile" name="Profile" title="View Twitter Profile"></a></span>
		<span class="add-profile"><a  href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"  title="Add New"></a></span>
		<span class="exiting-profile"><a  href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')" title="Add Existing"></a></span>';
		if(in_array($result->id,$all_result)){
		echo  '<span><input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px; display:none;"></span>';
		}
		echo '</div></div></div>';
			
		echo '<div class="down"><div class="plable-data">';
		
		echo '<div class="pdata"><div class="plable"><label>Screen Name </label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->screen_name.'</div></div>';
		echo '<div class="pdata"><div class="plable"><label>Location </label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->location.'</div></div>';
		echo '<div class="pdata"><div class="plable"><label>Followers</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->followers_count.'</div></div>';	
		echo '<div class="pdata"><div class="plable"><label>Friends</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->friends_count.'</div></div></div></div>';
	
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
	       <input type="submit" value="Add Contact" style="display:none;"/></div>';
	

}else{
	if(!empty($_GET['q']))
	echo 'No Results Found';
}?>

</div>
    </td>
   </tr>
   
<?php }else{ ?>
<tr><td align="left">
<?php echo '<div class="twitter-login-button"><div class="social-login-box">
<a href="'._SiteUrl.'admin/crm/Twitter.php?action=redirect"><img src="images/signtw.png"></a></div></div>';

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


