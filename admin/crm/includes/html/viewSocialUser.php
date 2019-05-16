
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

.user-list.detail > li {
    width: 100% !important;
}

</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>

<div id="Event" >
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
        <td align="right">		
	      <a class="fancybox add_quick fancybox.iframpankaje" href="editContact.php?module=contact">Add Profile</a>
	      <a class="add" href="editContact.php?module=contact">Contact List</a>
	      
	 	 </td>
 </tr>



<tr>
    <td  align="center" valign="top" >		
<form name="form1" action=""  method="post" onSubmit="return validateEvent(this);" enctype="multipart/form-data">
<div>
<h2 class="search-result">Results</h2>
<?php if(!empty($result)){
echo '</ul>';
	echo '<ul class="user-list detail">';
	$i=0;
	
	
	echo '<li>';
	echo '<div><img src="'.$result->profile_image_url.'"><span class="checkbox-user"><input type="checkbox" name="userid[]" value="'.$i.'"></span></div>';
	echo '<div><label>Id :</label>'.$result->id.'</div>';
	echo '<div><label>Name :</label>'.$result->name.'</div>';
	echo '<div><label>Screen Name :</label>'.$result->screen_name.'</div>';
	echo '<div><label>Location :</label>'.$result->location.'</div>';
	echo '<div><label>followers count :</label>'.$result->followers_count.'</div>';	
	echo '<div><label>friends count :</label>'.$result->friends_count.'</div>';	
	echo '</li>';	
	echo '</ul>';
	

}?>

</div>
</td>
   </tr>

   </form>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>


</div>