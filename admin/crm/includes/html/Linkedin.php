<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
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

</style>
<style>
ul{
 list-style: none outside none;
}
.paging {
    display: inline-block;
    list-style: none outside none;
      width: 100%;
}
.paging > li.next-page {
    float: right;
    }
 .paging > li.prev-page {
    float: left;
    }

.paging .next-page a {
    font-size: 16px;
    margin-right: 35px;
}
.paging .prev-page a {
    font-size: 16px;
    margin-left: 35px;
}
.user-list li {
    border: 1px solid;
    float: left;
    height: 188px;
    margin: 5px;
    padding-top: 5px;
    width: 23%;
}
.user-list {
   
    display: inline-block;
    width: 100%;
}
.user-list label {
   display: inline-block;
    float: left;
    font-weight: bold;
    text-align: left;
    width: 100px;
}
.search-box > label {
    font-size: 18px;
    margin-right: 15px;
}
.btn-search{
    background-color: #55acee;
    background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.05));
    border: 1px solid #3b88c3;
    border-radius: 5px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.15) inset;
    color: #fff;
    margin-left: 9px;
       padding: 4px;
       cursor: pointer;
}

.search-box input[type="text"] {
      border: 1px solid !important;
    border-radius: 5px;
    padding: 5px;
    width: 26%;
}
.user-list div {
    margin-left: 9px;
    text-align: left;
}
.checkbox-user {
    float: right;
    height: 16px;
    margin-right: 8px;
    width: 16px;
}
.search-result{
float:left;
}

.twitter-login-button {
     height: 330px;
    position: relative;
    width: 100%;
}

.social-login-box {
    bottom: 0;
    height: 20%;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 30%;
}

.image-box {
    float: left;
}

.image-box img {
    width: 27px;
}
.header-user-board .name {

    font-size: 15px;

    /*margin-top: 7px;*/
    text-transform: capitalize;
}

.header-user-board .logout {
  
    font-size: 18px;

    /*margin-right: 17px;*/
    margin-top: 3px;
}

.header-user-board .logout a {  
    font-size: 18px;
 
}
#linkedin_revoke_form input[type="submit"] {
    background: none repeat scroll 0 0 rgb(0, 135, 191);
    border: 1px solid;
    border-radius: 5px;
    color: #fff;
    padding: 2px 12px;
}


</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
 
 <?php if(!empty($Linkedindata[0]) && $ModifyLabel==1){ ?>

<a style="float:right;" class="add" href="linkedin-connection.php">Connection List</a>
<a class="fancybox add_quick" href="postLinkedin.php" style="float:right;">Create Post</a>
            
<? } ?>
<div id="Event" >
<? if($ModifyLabel==1 ){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td><div class="had">LinkedIn</div></td></tr>
 <tr>
  <td align="left">		
	  <?php    echo '</ul>';
	echo '<ul class="header-user-board">';
	$i=0;
	if(!empty($Linkedindata[0])){	
	echo '<li>';
	echo '<div class="image-box" style="display:none"><img src="'.$Linkedindata[0]['image'].'" alt ="No Image"></div>';

	
	echo '<div class="logout">  <form id="linkedin_revoke_form" action="'.$_SERVER['PHP_SELF'].'" method="get">
              <input type="hidden" name="'.LINKEDIN::_GET_TYPE.'" id="'.LINKEDIN::_GET_TYPE.'" value="revoke" />
               <input type="hidden" name="linkedinid"  value="'.$Linkedindata[0]['id'].'" />
              <input type="image" src="images/lin-logout.png" value="logout" />
            </form></div>';
	echo '<div class="name">'.$Linkedindata[0]['name'].'!</div>';				
	echo '</li>';
	}
	echo '</ul>';?>
	      
	 	 </td>
 </tr>
  

<tr>
    <td  align="center" valign="top" >
    <?php
   
    if(!empty($settings['oauth_access_token']) AND !empty($settings['oauth_access_token_secret'])){?>
   
			<form action="" method="get">
				<div class="search-box"><label>Search User</label><input type="text" name="q" value="<?php echo !empty($_GET['q'])?$_GET['q']:'';?>" /><input type="submit" value="search" class="btn-search"></div>
			</form>
<form name="form1" action=""  method="post" onSubmit="return validateEvent(this);" enctype="multipart/form-data">
<div> 

<?php 

if(!empty($results)){
	echo '<h2 class="search-result">Results</h2>';
echo '<ul class="paging">';
if($page>1){
echo '<li class="prev-page"><a href="?q='.$_GET['q'].'&page='.($page+1).'"><<--Prev</a></li>';
}
if(count($results)>=20 ){
echo '<li class="next-page"><a href="?q='.$_GET['q'].'&page='.($page+1).'">Next-->></a></li>';
}
echo '</ul>';
	echo '<ul class="user-list">';
	$i=0;
	foreach($results as $result){	
	echo '<li>';
	echo '<div><img src="'.$result->profile_image_url.'"><span class="checkbox-user"><input type="checkbox" name="userid[]" value="'.$i.'"></span></div>';
	echo '<div><label>Id :</label>'.$result->id.'</div>';
	echo '<div><label>Name :</label>'.$result->name.'</div>';
	echo '<div><label>Screen Name :</label>'.$result->screen_name.'</div>';
	echo '<div><label>Location :</label>'.$result->location.'</div>';
	echo '<div><label>followers count :</label>'.$result->followers_count.'</div>';	
	echo '<div><label>friends count :</label>'.$result->friends_count.'</div>';	
	echo '<div><a href="viewSocialUser.php?screen_name='.$result->screen_name.'">Profile</a></div>';
	echo '</li>';
	$i++;
	
	}
	echo '</ul>';
	echo '<div class="form-action"><input type="submit" value="Add Contact" /></div>';
	

}?>

</div>
</td></tr>
<?php }else{ ?>
<tr><td align="left">
<?php 
 switch($_REQUEST[LINKEDIN::_GET_TYPE]) {
    case 'revoke':    
    //  if(!oauth_session_exists()) {
       // throw new LinkedInException('This script requires session support, which doesn\'t appear to be working correctly.');
     // }
      
    //  $OBJ_linkedin = new LinkedIn($API_CONFIG);
    //  $OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
   //   $response = $OBJ_linkedin->revoke();
   //   if($response['success'] === TRUE) {
        // revocation successful, clear session     
    	 $objsocialcrm->deleteSocialConnect($_REQUEST['linkedinid'],'linkedin');
		 header('Location: ' . _SiteUrl.'admin/crm/Linkedin.php'); 	
		 die;
     // } else {
        // revocation failed
     //   echo "Error revoking user's token:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
    //  }
      break;
    default:
         /* $_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
          if($_SESSION['oauth']['linkedin']['authorized'] === TRUE) {
            $OBJ_linkedin = new LinkedIn($API_CONFIG);
            $OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
          	$OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
            	// check if the viewer is a member of the test group
            	$response = $OBJ_linkedin->group(DEMO_GROUP, ':(relation-to-viewer:(membership-state))');
              if($response['success'] === TRUE) {
          		  $result         = new SimpleXMLElement($response['linkedin']);
          		  $membership     = $result->{'relation-to-viewer'}->{'membership-state'}->code;
          		  $in_demo_group  = (($membership == 'non-member') || ($membership == 'blocked')) ? FALSE : TRUE;
	            
			  		  } else {
			  		    // request failed
          			echo "Error retrieving group membership information: <br /><br />RESPONSE:<br /><br /><pre>" . print_r ($response, TRUE) . "</pre>";
			  		  }
		          ?>
            </ul>
            <?php
          } else {
           
          }*/
          ?>
          <?php
          //if(empty($Linkedindata[0])) {
            // user is already connected
            /*
            ?>
            <form id="linkedin_revoke_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
              <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="revoke" />
              <input type="submit" value="Revoke Authorization" />
            </form>
            
            <!-- <hr />
          
            <h2 id="application">Application Information:</h2>
            
            <ul>
              <li>Application Key: 
                <ul>
                  <li><?php echo $OBJ_linkedin->getApplicationKey();?></li>
                </ul>
              </li>
            </ul>
            
            <hr /> -->
            
            <h2 id="profile">Your Profile:</h2>
            
            <?php
            $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address,phone-numbers)');
         
            if($response['success'] === TRUE) {
              $response['linkedin'] = new SimpleXMLElement($response['linkedin']);
             echo "<pre>" . print_r($response['linkedin'], TRUE) . "</pre>";
              $array = (array) $response['linkedin'];
              
              print_r($array);
             echo $array['first-name'];
            } else {
              // request failed
              echo "Error retrieving profile information:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response) . "</pre>";
            } 
        */ 
            // user isn't connected
            
          if(empty($Linkedindata[0])) {
            ?>
            <form id="linkedin_connect_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" style="margin-top: -25px;">
              <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="initiate" />
              <input type="image" src="images/lin-sign.png"/>
            </form>
            <?php
          }
          ?>
       
      <?php
      break;
  }
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

