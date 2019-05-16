<?php //session_start();?>
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

.view-profileIns > a {
    background: url("images/instagramAdd.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    display: inline-block;
	background-size: 24px 24px !important;
    height: 24px;
    padding: 3px;
    width: 24px;}

</style>
<script>
jQuery(document).ready(function() {
    //alert("qweqwe");
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

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
    
	<script src="jquery-1.10.2.js" type="text/javascript"></script>
	<script type="text/javascript">

		var accessToken = null; //the access token is required to make any endpoint calls, http://instagram.com/developer/endpoints/
		instagramClientId='8369a18b45cf4f7a90ac6321acfee7c8';
		//instagramRedirectUri='http://localhost/instagram/instagram-popup-login-master/index.php';
		instagramRedirectUri="https://www.eznetcrm.com/erp/admin/crm/instagram.php";
		//callback='login_callback';
		var authenticateInstagram = function(instagramClientId, instagramRedirectUri, callback, getUser) {

			//the pop-up window size, change if you want
			var popupWidth = 500,
				popupHeight = 350,
				popupLeft = (window.screen.width - popupWidth) / 2,
				popupTop = (window.screen.height - popupHeight) / 2;

			//the url needs to point to instagram_auth.php
			var popup = window.open('instagram_auth.php', '', 'width='+popupWidth+',height='+popupHeight+',left='+popupLeft+',top='+popupTop+'');

			popup.onload = function() {

				//open authorize url in pop-up
				if(window.location.hash.length == 0) {
					popup.open('https://instagram.com/oauth/authorize/?client_id='+instagramClientId+'&redirect_uri='+instagramRedirectUri+'&response_type=token', '_self');
				}

				//an interval runs to get the access token from the pop-up
				var interval = setInterval(function() {
					try {
						//check if hash exists
						if(popup.location.hash.length) {
							//hash found, that includes the access token
							clearInterval(interval);
							accessToken = popup.location.hash.slice(14); //slice #access_token= from string
							popup.close();
                                                        getUser(accessToken);
							jQuery("#token").val(accessToken);
							
							if(callback != undefined && typeof callback == 'function') callback();
						}
					}
					catch(evt) {
						//permission denied
					}

				}, 100);
			}

		};

		function login_callback(){/*document.write(accessToken); //alert("You are successfully logged in! Access Token: "+accessToken);*/}
		
		function getUser(accessToken)
		{ 
                    //alert('rrr');
			$.ajax({
				   type: "GET",
					url: "getInfo.php",
					data: "accesstocken="+accessToken+"&do=info",
  					//url: "https://api.instagram.com/v1/users/self/?access_token="+accessToken,
					success: function(result) {
						//var obj = jQuery.parseJSON(result);
						console.log(result);
						location.reload();
						//jQuery('#name').text(obj.data.full_name);$('#tagline').text(obj.data.full_name);jQuery("#uname").val(obj.data.username);
						},
					error: function(result) {
					alert("some error occured, please try again later");}
			});
			//$("#login").hide();$("#logout").show();$("#searchfbbox").show();
		}
		function login() 
		{
			authenticateInstagram(instagramClientId,instagramRedirectUri,login_callback,getUser);
			//authenticateInstagram('instagram id,your/instagram redirect URI,optional - a callback function);	
			return false;

		}
		
		function logout()
		{
			alert(" Logout...")
			$.ajax({
				   type: "GET",
				   dataType: "jsonp",
				   url: "https://instagram.com/accounts/logout/",
				   success:function(result){/*location.reload();*/},
				   error: function(result){/*alert("some error occured, please try again later");*/}});

			$.ajax({
				   type: "GET",
				   url: "getInfo.php",
				   data: "do=logOut",
				   success:function(result){location.reload();},
				   error: function(result){/*alert("some error occured, please try again later");*/}});

  					/*
					$.ajax({type: "GET",dataType: "jsonp",url: "https://instagram.com/accounts/logout/"});
			$("#name").text(" ");$("#tagline").text(" "); $("#logout").hide();$("#searchfbbox").hide();$("#login").show();*/
		}

	</script>

</head>
<body >

<!--div id="main_table_list" class="main-container clearfix">
	<div id="mid" class="main">
	
<!--div class="left-main-nav">	
	<h3><span class="icon"></span>Main Menu</h3>
	<ul>
		<!--<li class="new"></li>->
		<li class="submenu "><a href="facebook.php">Facebook</a></li><li class="submenu "><a href="Linkedin.php">LinkedIn</a></li><li class="submenu "><a href="Twitter.php">Twitter</a></li><li class="submenu "><a href="google-plus.php">Google Plus</a></li><li class="submenu active"><a href="instagram.php">Instagram</a></li>	   
	   
	   
</ul>
	</div> 

<div class="mid-continent" id="inner_mid" style="width: 84%;"><div id="load_div" align="center" style="display: none;"><img src="../images/loading.gif">&nbsp;Loading.......</div>
<div id="Event" -->
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td>
    <a class="fancybox add_quick fblogut" href="instagram-friends.php" style="float: right;<?php if(isset($_SESSION['accessToken']))echo "";else echo "display:none;"?>">Followed By</a>

        <div class="had">Instagram</div>
        </td>
    </tr>
 		<tr>
  			<td align="left">		
			<a href="javascript:void(0)" id="login" onClick="login()"<?php if(isset($_SESSION['accessToken']))echo "style='display:none;'";else echo ""?>>
			<img src='https://www.eznetcrm.com/erp/admin/crm/images/instagramS.png'/></a>
            <a href="javascript:void(0)" id="logout" <?php if(isset($_SESSION['accessToken']))echo ""; else echo "style='display:none;'";?>onClick="logout()"><img src="https://www.eznetcrm.com/erp/admin/crm/images/instagramL.png"/></a>
                <br/><label style=" font-size:14px; font-style:bold;"id="name">
				<?php if(isset($_SESSION['full_name']))echo $_SESSION['full_name'];?></label><br/>
                </td>
          
         </tr>
         <tr>
   <td align="center" valign="top" id="searchfbbox" <?php if(isset($_SESSION['accessToken']))echo "";else echo "style=' display:none;'";?>>
			 <form action="" method="get" id="searchbox">
				<input id="search" name="q" type="text" value="<?php if(isset($_REQUEST['q'])) echo $_REQUEST['q'];?>"/>
                <input id="submit" type="submit" value="Search" name="submit"/>
			 </form>
             
<? if (!empty($_SESSION['mess_social'])) {?>
	<div>
		<span  align="center"  class="message"  >
		<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
		</span>
	</div>
<? } ?>      
             <!--**************************-->
            
<form name="form1" action="" id="socialfrom"  method="post"  enctype="multipart/form-data">
	<div>
		
		<?php if(!empty($_GET['q']) && isset($Dres))
		{		
		echo '<h2 class="search-result">Search Results:</h2>';	
                
			echo '<ul class="user-list">';
			$i=0;
			foreach($Dres->data as $f_res)
			{			
                //echo $f_res->id;
				if($f_res->id){       	
					echo '<li style="height:250px;">';
					
					echo '<div class="top"><div class="pfname"><a href="http://instagram.com/'.$f_res->username.'" target="_blank">'.$f_res->full_name.'</a></div>
					<div class="image-set" align="center">
					<span class="pimg"><a href="http://instagram.com/'.$f_res->username.'" target="_blank"><img src="'.$f_res->profile_picture.'" height="120px"></a></span>';				 
					echo '</div>';
					echo '<div class="detail-box" align="center"><div class="pbtn">
					<span class="view-profileIns">
					<a href="http://instagram.com/'.$f_res->username.'" target="_blank" rel="Profile" name="Profile" title="Profile"></a></span>		
			       <span class="add-profile"><a name="Add New" title="Add New" href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"></a></span>
			       <span class="exiting-profile"><a name="Add Existing" title="Add Existing" href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')">
				   </a></span></div>';                                      
					echo '</div></div>';
					
                    echo '<div class="down"><div class="plable-data">';	
					echo '<div class="pdata"><div class="plable"><label>User Id</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$f_res->id.'</div></div><div class="pdata"><div class="plable"><label>User Name</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$f_res->username.'</div></div></div></div>';
					
					//************************
					# start for Existing			
					echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
        			if(in_array($f_res->id,$contact_result)){	
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
        			} else{ 
					echo '<a href="searchContact.php?type=instagram&sid='.$f_res->id.'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
					}
		
					if(in_array($f_res->id,$customer_result)){
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
					}else{	
					echo '<a href="searchCustomer.php?type=instagram&sid='.$f_res->id.'" class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
					}
					echo'</div></div>';
            
					# start for new 		
					echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
					if(in_array($f_res->id,$contact_result)){			  
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

					}else{
					echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$f_res->id.'\',\''.$f_res->full_name.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
					}

					if(in_array($f_res->id,$customer_result)){
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
					}else{
					echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$f_res->id.'\',\''.$f_res->full_name.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
					}
					echo  '</div></div>';             
					//************************	
					echo  '</li>';
			}// end if id
			$i++;
		}//end foreach loop
			echo '</ul>';
			
			echo '<div class="form-action">
				   <input type="hidden" class="userid-set" name="userid[]">
                                   <input type="hidden" class="dispalay-name" name="full_name">
                                   <input type="hidden" id="token" value="">
                                   
				   <input type="hidden" class="action-type" name="action-type">
				   <input type="submit" value="Add Contact" style="display:none;"/>
				  </div>';
	}
	else
	{			
		if(!empty($_GET['q']))
		echo 'No Results Found';
	}?>
	</div>
</form>

             <!--**************************-->
             
    </td></tr>
    </table>
<script>
function SaveSocialData(obj,id,full_name,type)
{
    jQuery('.userid-set').val(id);
    jQuery('.dispalay-name').val(full_name);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
}

</script>

<!--/div>
</div>
</div>
</div-->
