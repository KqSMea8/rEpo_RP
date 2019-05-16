
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<style>

	.ui-widget-overlay{
		opacity: 0.6 !important;
	}	
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
		.Socialhad{background-color: #406697; color: #fff;}
		.profile-box{}
		.profile-box .pdata {
      
       
       }
    
     .profile-box .pdata .pcontent { font-size:15px !important; color:#005DBD; margin-left: 12px;}
     .profile-box .pdata .pcontentd{ font-size:15px !important; color:#000; margin-left: 12px;}
     
          .profile-box .image-ul {
            width:25%;
            margin-top: 5px;
            float: left;
            height: 150px;
             }



 .pcoln { }
 .plable{font-size:15px !important; color:#000; width:110px; display: inline-block;}
</style>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<body style="width:400px">

<script>


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
<div class="Hwrap" style="min-height:150px; width: 100%;">
<?php if($_GET['type'] == "facebook"){ ?>
    <div class="had Socialhad">Facebook Profile</div>
<?php }elseif($_GET['type'] == "twitter"){ ?>
<div class="had Socialhad">Twitter Profile</div>
<?php }elseif($_GET['type'] == "linkedin") { ?>
<div class="had Socialhad">Linkedin Profile</div>
<?php }elseif($_GET['type'] == "googleplus") { ?>
<div class="had Socialhad">Google Profile</div>
<?php }else { ?>
<div class="had Socialhad" style="display:none"></div>
<?php } ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
<tr>
<td align="left" width="20%"><?php echo '<img style="border-radius: 35px !important; margin-left: 25px; margin-top: 10px;" src="'.$data['image'].'" alt="'.$data['first_name'].'" width="70">';?></td>

<td align="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<?php if(!empty($data['name'])){?>
<td  align="left"   class="blackbold" style="width: 70px;">Name : </td>
<td   align="left" ><?php echo $data['name'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['link'])){?>
<td  align="left"   class="blackbold" >Url : </td>

<td   align="left" ><a class="pcontentd" href="<?php echo $data['link']?>" target="_blank"><?php echo $data['link']?></a></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['gender'])){?>
<td  align="left"   class="blackbold" >Gender : </td>

<td   align="left" ><?php echo $data['gender'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['location'])){?>
<td  align="left"   class="blackbold" >Location : </td>

<td   align="left" ><?php echo $data['location'];?></span></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['description'])){?>
<td  align="left"   class="blackbold" style="width: 70px;" >Description : </td>

<td   align="left" ><?php echo $data['description'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['followers_count'])){?>
<td  align="left" colspan="2" class="blackbold">
<span>Followers :</span> <span style="padding-left: 25px;"><?php echo $data['followers_count'];?></span>
<?php }?>
<?php if(!empty($data['friends_count'])){?>
<span style="padding-left: 32px;">Friends :</span> <span style="padding-left: 5px;"><?php echo $data['friends_count'];?></span>
<?php }?>
<?php if(!empty($data['statuses_count'])){?>
<span style="padding-left: 33px;">Status :</span> <span style="padding-left: 5px;"><?php echo $data['statuses_count'];?></span>
<?php }?>
</td>
</tr>

</table>
</td>
</tr>
</table>
</div>








<script>
function SaveSocialData(obj,id,type){
	
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}

</script>




