<div class="message" align="center"><?
    if (!empty($_SESSION['mess_meetingBasic'])) {
        echo $_SESSION['mess_meetingBasic'];
        unset($_SESSION['mess_meetingBasic']);
    }
    ?></div>
<?php if(empty($MeetingUser) && ($_SESSION['AdminType']=='admin')){?>
<form action="" method="post" name="form1">
	<input name="ActivateSubmit" type="submit" class="button" id="SubmitButton" value=" Get Started ">
</form>
<?php }elseif(empty($MeetingUser) && ($_SESSION['AdminType']!='admin')){ ?>
			<div align="center" style="padding-top:200px;" class="redmsg">Sorry, you are not authorized to access this section.</div>
    <?php }?>