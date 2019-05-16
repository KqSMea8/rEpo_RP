<div class="right-search">
            <!--  	<h3><span class="icon"></span>Search</h3> -->

<div class="right_box">
<ul class="rightlink">
<? if(is_array($MeetingUser)){ ?>
<li <?=($_GET['tab']=="MyProfile")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=MyProfile" >My Profile</a></li>
<? } ?>

<? if($MeetingUser[0]['enable_webinar']){ ?>
<li <?=($_GET['tab']=="Webinar")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=Webinar">Webinars</a></li>
<li <?=($_GET['type']=="meetingLead")?("class='active'"):("");?>><a href="meetingViewCreateLead.php?type=meetingLead">Site Links</a></li>
<?php } ?> 


<!--  <li <?=($_GET['tab']=="UserManagement")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=UserManagement">User Management</a></li>-->
<li <?=($_GET['tab']=="Recordings")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=Recordings">Recording Management</a></li>
<!-- <li <?=($_GET['tab']=="Reports")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=Reports">Reports</a></li>-->
</ul>
</div>

</div>
            
            
