
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/facebook-page.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link href="fullcalendar/search-box.css" type="text/css" rel="stylesheet" media="screen" />

<style>
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
    margin-top: 20px;
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



<a class="fancybox add_quick fblogut" href="facebook-friends.php" style="float: right; display:none;">Friends List</a>
<a class="fancybox add_quick fblogut" href="viewFacebookPost.php" style="float: right; display:none;">Post List</a>


<div class="had" >Facebook</div>
<!--  start code for facebook login    -->
<script>

$(document).ready(function() {
     // alert("document ready occurred!");
	  //$(document).load(checkLoginState);
	  checkLoginState();
});
  $("#load_div").hide();
 
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
	  
    //console.log('statusChangeCallback');
   // console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
	//var uid = response.authResponse.userID;
	//alert("connected");
    var accessToken = response.authResponse.accessToken;
	$("#token").val(accessToken);
	$("#login").fadeOut();
	$(".fblogut").fadeIn();
	
	if(accessToken){
		$("#searchfbbox").fadeIn();
		
	}else{
		$("#searchfbbox").fadeOut();
	}
//	console.log('Access Token' + accessToken);
      testAPI();
    } else if (response.status === 'not_authorized') {
		//alert("not_authorized");
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
		//alert("notconnected");
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
	$("#login").fadeIn();
	$(".fblogut").fadeOut();
      document.getElementById('status').innerHTML = '';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.login(function(response) {
      statusChangeCallback(response);
    }, {
        scope: 'public_profile,email,user_friends,user_birthday,user_hometown,user_location,read_friendlists'
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1608313902793535',
      xfbml      : true,
 cookie     : true,  // enable cookies to allow the server to access 
                        // the session
   
      version    : 'v3.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
	  //alert("asdjasjdnakjn");
   // console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=gender,about,friends,name,birthday,age_range,email,first_name,last_name,picture,friendlists,link', function(response) {
	  
      
	console.log(response);
      //console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML = ' ' + response.name + '<br><a href="'+response.link+'"target="_new"><img src="https://graph.facebook.com/'+ response.id +'/picture"></a>';
    });

FB.api('/me/friends','GET', {"fields": "id,first_name,last_name,name,birthday,gender,location,link,installed"}, function(response){
  console.log('Hello='+response);
});
  }
  
function logout() {
FB.logout(function(response) {
// user is now logged out
});
$("#login").fadeIn();
$(".fblogut").fadeOut();
document.getElementById('status').innerHTML = '';
 //$("#load_div").hide();
 $("#searchfbbox").fadeOut();
}
  
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<div id="fb-root"></div>



<div class="fblogut" style="display:none;">
<button onclick="javascript:logout();" class="fblogout" ></button>
</div>

<div id="status" style="font-size: 15px; text-transform: capitalize;"></div>
<!--  end code for facebook login    -->


<div id="Event">
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <link href="cbdb-search-form.css" rel="stylesheet" type="text/css"/>
    

<tr>
  <td valign="top">
    <div id="login" style="display:none;">

<button onclick="checkLoginState();" class="fblogin" style="float:none;" ></button>

<!--
<fb:login-button scope="public_profile,email,user_friends,user_birthday,user_hometown,user_location,read_friendlists" onlogin="checkLoginState();"></fb:login-button>
-->
</div>  
  </td>
</tr>

<tr>

    <td  align="center" valign="top" style="display:none;" id="searchfbbox">
			 <form action="" method="get" id="searchbox">
				<input id="search" name="q" type="text" value="<?php echo !empty($_GET['q'])?$_GET['q']:'Search';?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '<?php echo !empty($_GET['q'])?$_GET['q']:'Search';?>';}">
                                <input type="hidden" name="access_token" id="token" value="<?php echo !empty($_GET['access_token'])?$_GET['access_token']:'';?>" />
                                <input id="submit" type="submit" value="Search">
			 </form>
			  <? if (!empty($_SESSION['mess_social'])) {?>
<div>
<span  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
</span>
</div>
<? } ?>
        <form name="form1" action="" id="socialfrom"  method="post"  enctype="multipart/form-data">
		<div>
		
		<?php if(!empty($search_user['userdata'])){
		
			
			
		echo '<h2 class="search-result">Search Results:</h2>';	
		echo '<ul class="paging">';
		
		if($search_user['paging']->previous){
		$pre_paging   = explode('search?',$search_user['paging']->previous);
		echo '<li class="prev-page"><a href="'._SiteUrl.'admin/crm/facebook.php?'.$pre_paging[1].'"><< Prev</a></li>';
		}
		if($search_user['paging']->next){
			$next_paging   = explode('search?',$search_user['paging']->next);
			
		echo '<li class="next-page"><a href="'._SiteUrl.'admin/crm/facebook.php?'.$next_paging[1].'">Next >></a></li>';
		}
		
		echo '</ul>';
		
			echo '<ul class="user-list">';
		$i=0;
			foreach($search_user['userdata'] as $result){
				if($result['id']){
					echo '<li>';
					echo '<div class="top"><div class="pfname"><a href="'.$result['link'].'" target="_blank">'.$result['first_name'].'</a></div><div class="image-set" align="center"><span class="pimg"><a href="'.$result['link'].'" target="_blank"><img src="https://graph.facebook.com/'.$result['id'].'/picture?type=small&width=80&height=80"></a></span>';
				 
					echo '</span></div>';
					echo '<div class="detail-box" align="center"><div class="pbtn"><span class="social_view_profile view-profile"><a href="'.$result['link'].'" target="_blank" rel="Profile" name="Profile" title="View Facebook Profile"></a></span>
					
			<!--<a href="javascript:void(0);" onclick="jQuery(this).parents(\'li\').find(\'.add-dashboard\').toggleClass(\'active\')">Add To CRM</a> -->
			       <span class="add-profile"><a name="Add New" title="Add New" href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"></a></span>
			       <span class="exiting-profile"><a name="Add Existing" title="Add Existing" href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')"></a></span></div>';
                                        if(in_array($result['id'],$all_result)){
      		          echo  '<input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px;">';
				     }
					echo '</div></div>';
                                        echo '<div class="down"><div class="plable-data">';
					echo '<div class="pdata"><div class="plable"><label>Screen Name</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result['name'].'</div></div>';
						
					echo '<div class="pdata"><div class="plable"><label>Gender</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result['gender'].'</div></div></div></div>';	
					
		# start for Existing			
		echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
        if(in_array($result['id'],$contact_result)){	
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
        } else{ 
		echo '<a href="searchContact.php?type=facebook&sid='.$result['id'].'&FirstName='.$result['first_name'].'&LastName='.$result['last_name'].'&FullName='.$result['name'].'&Gender='.$result['gender'].'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
		}
		
		if(in_array($result['id'],$customer_result)){
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
		}else{	
		echo '<a href="searchCustomer.php?type=facebook&sid='.$result['id'].'&FirstName='.$result['first_name'].'&LastName='.$result['last_name'].'&FullName='.$result['name'].'&Gender='.$result['gender'].'" class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
		}
		echo'</div></div>';
		# start for new 		
			echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
			if(in_array($result['id'],$contact_result)){			  
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

			}else{
			echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
			}

			if(in_array($result['id'],$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
			}else{

			echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
			}
			echo  '</div></div></li>';
			}
			 $i++;
			}
			echo '</ul>';
			echo '<div class="form-action">
				   <input type="hidden" class="userid-set" name="userid[]">
				   <input type="hidden" class="action-type" name="action-type">
				   <input type="submit" value="Add Contact" style="display:none;"/>
				  </div>';

		  }else {			
			 if(!empty($_GET['q']))
				echo 'No Results Found';
		  }?>

		
</td>
   </tr>
   </div>

   </form>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>


<script>
function SaveSocialData(obj,id,type){
	
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}

</script>




