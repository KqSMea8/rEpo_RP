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
<?php include_once 'includes/html/box/linkedinauth.php';?>
<div class="linkedin-login-view" style="display:none">
	<a style="float:right;" class="add" href="linkedin-connection.php">Connection List</a>
	<a class="fancybox add_quick" href="postLinkedin.php" style="float:right;">Create Post</a>
</div>
<div id="Event" >
<? if($ModifyLabel==1 ){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td><div class="had">LinkedIn</div></td></tr>
 <tr>
  <td align="left">		
	  <?php    echo '</ul>';
		echo '<ul class="header-user-board linkedin-login-view" style="display:none;">';
		$i=0;
		echo '<li>';
		echo '<div class="image-box" style="display:none"><img src="'.$Linkedindata[0]['image'].'" alt ="No Image"></div>';
		echo '<div class="name linkedin-name">'.$Linkedindata[0]['name'].'</div>';	
		echo '<div class="logout-button"></div>';
					
		echo '</li>';	
		echo '</ul>';?>
	   <script type="in/Login"></script> 
	 	 </td>
 </tr>
</table>
<? }else{?>
<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>

