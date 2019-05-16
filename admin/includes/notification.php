<?php 	$arryNotification = $objConfig->GetAllNotification();	
	if(sizeof($arryNotification)>0){

	 $Config['CmpID'] = $Config['SuperCmpID'];
 
 ?>
		 
  <li class="blink-image notification" id="notificationli"   alt="Notifications" title="Notifications"><a  ><span >&nbsp;</span></a></li> 
 <!--li ><img  src="../admin/images/alarm.png"></li-->

 <div id="parent_notifications">	
  	<ul><? 
   foreach($arryNotification as $Key=>$Value){?>
	<li>

<?
if(IsFileExist($Config['NotificationDir'],$Value['Image'])){   
	$PreviewArray['Folder'] = $Config['NotificationDir'];
	$PreviewArray['FileName'] = $Value['Image'];
	$PreviewArray['FileTitle'] = stripslashes($Value['Heading']);
	$PreviewArray['Width'] = "80";
	$PreviewArray['Height'] = "80"; 
	echo PreviewImage($PreviewArray); 			
}


 

?>
	<a href="<?=$MainPrefix?>notificationdetail.php?NotifiID=<?=$Value['NotificationId']?>"  class="fancybox fancybox.iframe"><?=stripslashes($Value['Heading']);?></a>

	</li>
	<?php } ?>	
		<?php if(sizeof($arryNotification)>=10){?>
		<li><a class="see-more fancybox fancybox.iframe" href="<?=$MainPrefix?>allNotificationList.php">See All  Notification</a></li>
  <?php } ?>
 
   </ul>
  </div>

<SCRIPT LANGUAGE=JAVASCRIPT> 
$(document).ready(function() {
	jQuery(".header-container .top-right-nav li.notification").click(function(){ 
		 
		//jQuery(this).toggleClass('notification notification2');
		 
	 	jQuery(this).removeClass("blink-image");

		jQuery("#parent_notifications").toggle();
		
	});
	
	$(document).click(function(e) {		 
	   	   if (e.target != $('#notificationli')[0]) {			 
			$("#notificationli").attr('class', 'blink-image notification');
			jQuery("#parent_notifications").hide();
		    }
	});

});
</SCRIPT>

	<? 
		$Config['CmpID'] = $_SESSION['CmpID'];
	} ?>
