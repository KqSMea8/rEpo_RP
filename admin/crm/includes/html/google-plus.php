
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/facebook-page.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<style>
    .pimg img {
    width: 80px;
}
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
<style>
    #authorize-button {
    background: url("images/gplus-sing-in.png") no-repeat scroll 0 0 transparent;
    cursor: pointer;
    height: 29px;
    margin-right: 6px;
    margin-top: 0;
    width: 124px;
}
#logoutText {
    
    background: url("images/gplus-logout.png") no-repeat scroll 0 0 transparent;
    cursor: pointer;
    height: 29px;
    margin-right: 6px;
    margin-top: 0;
    width: 124px;
}

.view-profile > a {
    background: url("images/g-plus.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    display: inline-block;
    height: 24px;
    padding: 3px;
    width: 24px;
}
.add_quick {
    
    background: url("../../admin/images/edit_white.png") no-repeat scroll 5px 5px #535353;
    border: medium none;
    border-radius: 2px;
    color: #ffffff;
    cursor: pointer;
    float: right;
    font-size: 12px;
    margin: 0 0 0 5px;
    padding: 1px 5px 2px 20px;
    
}
    
    
</style>
</head>
<body>
<form action="<?php echo $frndurl?>" method="get">
<!--<a class="fancybox add_quick fblogut Gdata frnd" href="" style="float: right; display:none;">Friends List</a>-->
<input style="display:none;" class="add_quick" type="submit" value="Friends List">
<input type="hidden" class="token" name="access_token" value="" />
</form>
<div class="had" >Google Plus</div>
<!--  start code for google login    -->
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

    <script type="text/javascript">

      var clientId = '64999272889-2c32noiofpvso9psbvnfvjh6fbig461n.apps.googleusercontent.com';
      var LOGOUT      =   'http://accounts.google.com/Logout';

      var apiKey = 'LT5IKsPd16e_O6BB1bjsQtcT';

      var scopes = 'https://www.googleapis.com/auth/plus.login';

      function handleClientLoad() {
		  
		 
        // Step 2: Reference the API key
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
      }

      function checkAuth() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
      }

      function handleAuthResult(authResult) {
        var authorizeButton = document.getElementById('authorize-button');
        if (authResult && !authResult.error) {
			
          authorizeButton.style.display = 'none';
          makeApiCall();
		  var acToken=  authResult.access_token;
		  getUserInfo(acToken);
                  jQuery('.token').val(acToken);
		  console.log(authResult);
		  
                  jQuery("#logoutText").show();
                  jQuery(".add_quick").show();
                  
                  jQuery("#logoutText").css("display", "block");
                  jQuery("#uName").css("display", "block");
                  
                  jQuery(".Gdata").show();
                  
                  
        } else {
		
			
                        jQuery("#logoutText").hide();
                        jQuery("#uName").css("display", "none");
                        jQuery(".Gdata").hide();
                        jQuery("#authorize-button").fadeIn();
                        
          authorizeButton.style.display = '';
          authorizeButton.onclick = handleAuthClick;
        }
      }

      function handleAuthClick(event) {
        // Step 3: get authorization to use private data
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
      }

      // Load the API and make an API call.  Display the results on the screen.
      function makeApiCall() {
        // Step 4: Load the Google+ API
        gapi.client.load('plus', 'v1').then(function() {
          // Step 5: Assemble the API request
          var request = gapi.client.plus.people.get({
            'userId': 'me'
          });
          // Step 6: Execute the API request
          request.then(function(resp) {
            var heading = document.createElement('h4');
            var image = document.createElement('img');
            image.src = resp.result.image.url;
            heading.appendChild(image);
            heading.appendChild(document.createTextNode(resp.result.displayName));

            document.getElementById('content').appendChild(heading);
          }, function(reason) {
            console.log('Error: ' + reason.result.error.message);
          });
        });
      }
	  
	  
	   function getUserInfo(acToken) {
            $.ajax({
                url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
                data: null,
                success: function(resp) {
                    user    =   resp;
                    
                    console.log(user);
                    $('#uName').text(' ' + user.name + '!');
                    $('#imgHolder').attr('src', user.picture);
                },
                dataType: "jsonp"
            });
        }
       		 //function startLogoutPolling() {
			 //alert("asdfasdfs");
           //gapi.auth.signOut();
           //window.location.reload;
        //}
        function startLogoutPolling() {
            alert("Logout......");
            jQuery("#authorize-button").fadeIn();
            jQuery(".Gdata").hide();
            jQuery('#logoutText').hide();
            
            jQuery(".add_quick").hide();
            jQuery('#uName').text('Welcome ');
            jQuery('#imgHolder').attr('src', 'none.jpg');
            jQuery("#uName").css("display", "none");
            
       
        }
        
         
    </script>
 
    <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<div id="fb-root"></div>



<div class="fblogut">
<a href="javascript:void(0)" id="logoutText" target='myIFrame' onclick="myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;"></a>
<iframe name='myIFrame' id="myIFrame" style='display:none'></iframe>
</div>

<div id="uName" style="font-size: 15px; text-transform: capitalize;"></div>
<!--  end code for facebook login    -->


<div id="Event">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <link href="cbdb-search-form.css" rel="stylesheet" type="text/css"/>
    

<tr>
  <td valign="top">
    

<button id="authorize-button" onclick="handleAuthClick();" style="display:none;"></button>

 
  </td>
</tr>
<tr>

    <td  align="center" valign="top" style="display:none;" id="searchfbbox" class="Gdata">
			 <form action="" method="get" id="searchbox">
				<input id="search" name="q" type="text" value="<?php echo !empty($_GET['q'])?$_GET['q']:'Search';?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '<?php echo !empty($_GET['q'])?$_GET['q']:'Search';?>';}">
                                <input type="hidden" class="token" name="access_token" value="" />
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
		
		<?php if(!empty($_GET['q']) && !empty($_GET['access_token'])) {
		
			
			
		echo '<h2 class="search-result">Search Results:</h2>';	
                echo '<ul class="paging">';
		
		if(empty($token)){
		  //$pre_paging   = explode('search?',$search_user['paging']->previous);
                    
		//echo '<li class="prev-page"><a href="#"><< Prev</a></li>';
		}
		else{
		//$plusresults = $objsocialcrm->google_plus($urlnextpagetoken);
		echo '<li class="next-page"><a href="'.$urlnextpagetoken.'">Next >></a></li>';
                echo '<input type="hidden" name="nextpagetoken" value="'.$token.'" />';
		}
		
		echo '</ul>';
		
		
			echo '<ul class="user-list">';
		$i=0;
			foreach($plusresults->items as $result){
                            //echo $result->id;
				if($result->id){
					echo '<li>';
					echo '<div class="top"><div class="pfname"><a href="'.$result->url.'" target="_blank">'.$result->displayName.'</a></div><div class="image-set" align="center"><span class="pimg"><a href="'.$result->url.'" target="_blank"><img src="'.$result->image->url.'"></a></span>';
				 
					echo '</span></div>';
					echo '<div class="detail-box" align="center"><div class="pbtn"><span class="social_view_profile view-profile"><a href="'.$result->url.'" target="_blank" rel="Profile" name="Profile" title="Profile"></a></span>
					
			
			       <span class="add-profile"><a name="Add New" title="Add New" href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"></a></span>
			       <span class="exiting-profile"><a name="Add Existing" title="Add Existing" href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')"></a></span></div>';
                                        
					echo '</div></div>';
                                        echo '<div class="down"><div class="plable-data">';
					
						
					echo '<div class="pdata"><div class="plable"><label>User Id</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$result->id.'</div></div></div></div>';	
					
					
		# start for Existing			
		echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
        if(in_array($result->id,$contact_result)){	
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
        } else{ 
		echo '<a href="searchContact.php?type=googleplus&sid='.$result->id.'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
		}
		
		if(in_array($result->id,$customer_result)){
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
		}else{	
		echo '<a href="searchCustomer.php?type=googleplus&sid='.$result->id.'" class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
		}
		echo'</div></div>';
                           # start for new 		
			echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
			if(in_array($result->id,$contact_result)){			  
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

			}else{
			echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$result->id.'\',\''.$result->displayName.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
			}

			if(in_array($result->id,$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
			}else{

			echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$result->id.'\',\''.$result->displayName.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
			}
			echo  '</div></div>';             
                                        
			echo  '</li>';
			}
			 $i++;
			}
			echo '</ul>';
			echo '<div class="form-action">
				   <input type="hidden" class="userid-set" name="userid[]">
                                   <input type="hidden" class="dispalay-name" name="displayname">
				   <input type="hidden" class="action-type" name="action-type">
				   <input type="submit" value="Add Contact" style="display:none;"/>
				  </div>';

		  }else {			
			 if(!empty($_GET['q']))
				echo 'No Results Found';
		  }?>
                </div>
       </form>

		
</td>
   </tr>
<tr>
    <td>
        <div class="Gdata" style="display:none;">
    
    <img style="width: 100px; display:none;" src='' id='imgHolder'/>
    </div>
        
    </td>    
    
</tr>

   </div>


</table>
</div>

<script>
function SaveSocialData(obj,id,displayName,type){
	
	
        jQuery('.userid-set').val(id);
        jQuery('.dispalay-name').val(displayName);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}

</script>





