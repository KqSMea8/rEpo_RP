<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<link href='fullcalendar/css-linkedin-connection.css' rel='stylesheet' />
</head>
<body>
<div class="had">LinkedIn</div>
<style>
   
</style>
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




<a class="back" href="Linkedin.php">Back</a>
<a href="viewLinkedinPost.php" class="fancybox add_quick">Post List</a>
<div class="had">Connection List </div>
<? if (!empty($_SESSION['mess_social'])) {?>
			<div>
			<span  align="center"  class="message"  >
				<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
			</span>
			</div>
			<? } ?>
<form name="form1" action=""  method="post" id="socialfrom" enctype="multipart/form-data">
<?php
if($response['success'] === TRUE) {

              $connections = new SimpleXMLElement($response['linkedin']); 
//echo "<pre>";print_r($connections->person);die;			  
            
              if((int)$connections['total'] > 0) {
                ?>
               <!--  <p>First <?php echo CONNECTION_COUNT;?> of <?php echo $connections['total'];?> total connections being displayed:</p>-->

                <form id="linkedin_cmessage_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="message" />
                  <?php
                  	echo '<ul class="user-list">';
                  	$i=0;
                  foreach($connections->person as $connection) {          
                    	echo '<li>';
                    	
		echo '<div class="top"><div class="pfname"><a href="'.$connection->{'site-standard-profile-request'}->url.'" target="_blank">'.$connection->{'first-name'}.' '.$connection->{'last-name'}.'</a></div>';
		 if($connection->{'picture-url'}) {
			echo '<div class="image-set" align="center"><span class="pimg"><img src="'.$connection->{'picture-url'}.'"></span></div>';
		 }else{
		 echo '<div class="image-set" align="center"><span class="pimg"><img src="'._SiteUrl.'images/nouser.jpg" width="70"></span></div>';
		 }
		 
	echo '<div class="detail-box" align="center"><div class="pbtn"><span class="view-profileln"><a href="'.$connection->{'site-standard-profile-request'}->url.'" target="_blank" title="View Linkedin Profile"></a></span>
	
	<span class="add-profile"><a title="Add New" href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"></a></span>
	<span class="exiting-profile"><a title="Add Existing" href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')"></a></span>';
	
	if(in_array($connection->id,$all_result)){
	echo  '<input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px;">';
	}

	echo '</span></div></div></div>';
    echo '<div class="down"><div class="plable-data">';
	if(!empty($connection->location->name)){
		echo '<div class="pdata"><div class="plable"><label>Location :</label><span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$connection->location->name.'</div></div></div>';	
	}

			# start for Existing			
			echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
			if(in_array($connection->id,$contact_result)){	
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
			} else{ 
			echo '<a href="searchContact.php?type=linkedin&sid='.$connection->id.'&FullName='.$connection->{'first-name'}." ".$connection->{'last-name'}.'&Location='.$connection->location->name.'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
			}

			if(in_array($connection->id,$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
			}else{	
			echo '<a href="searchCustomer.php?type=linkedin&sid='.$connection->id.'&FullName='.$connection->{'first-name'}." ".$connection->{'last-name'}.'&Location='.$connection->location->name.'"  class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
			}
			echo'</div></div>';
			# start for new 		
			echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
			if(in_array($connection->id,$contact_result)){			  
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

			}else{
			echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
			}

			if(in_array($connection->id,$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
			}else{

			echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
			}
			echo  '</div></div>';	
		
	echo '</li>';  $i++;}
	echo '</ul>';
	echo '<div class="form-action">
	       <input type="hidden" class="userid-set" name="userid[]">
		   <input type="hidden" class="action-type" name="action-type">
		   <input type="submit" value="Add Contact" style="display:none;" />
		   </div>';
	?>
                </form>
                <?php
              } else {
                // no connections
                echo '<div>You do not have any LinkedIn connections to display.</div>';
              }
            } else {
            // request failed
            echo "<div style='color: red;font-size: 18px;'>Please Connect to Linkedin</div>";
            }
            ?>
			   </form>
 <script>
function SaveSocialData(obj, id, type){
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	}

</script>         
