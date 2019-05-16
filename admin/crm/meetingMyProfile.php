<?php 
$RedirectUrl = "meeting.php?curP=".$_GET['curP']."&tab=MyProfile";

if(isset($_POST['saveTimeZone'])){
	$objMeeting->updateUserTimeZone($_POST);
	$_SESSION['mess_meeting'] = 'TimeZone updated successfully.';
	header("location:" . $RedirectUrl);
	exit;
}

if(isset($_POST['updatePassword'])){
	if (strlen($_POST['userNewPassword']) < '4') {
		$passwordErr = "Your password cannot contain less than 4 characters !";
	}elseif (strlen($_POST['userNewPassword']) >= '11') {
		$passwordErr = "Your password cannot contain more than 10 characters !";
	} else if( ! preg_match("/^[a-zA-Z0-9@_*-]+$/", $_POST['userNewPassword'] ) ) {
		$passwordErr = "Your password field can only contain a-z, A-Z, 0-9, @ - _ *";
	} else if(empty($_POST['userNewPassword'])) {
		$passwordErr = "Password is blank!";
	}
	
	 if(!empty($passwordErr)){
		$_SESSION['mess_meeting'] = $passwordErr;
		header("location:" . $RedirectUrl);
		exit;
	}
	
	$result = $objMeeting->updateUserPassword($_POST);
	if($result->id){
		$objMeeting->updateTableUserPassword($_POST);
		$_SESSION['mess_meeting'] = 'Password updated successfully.';
	}else if($result->error){ 
		$_SESSION['mess_meeting'] = $result->error->message;
	}else{
		$_SESSION['mess_meeting'] = 'Not able to update. Try after some time!';
	}
	header("location:" . $RedirectUrl);
	exit;
}

?>
<script type="text/javascript">
$(document).ready(function(){
	$('.showpasswordcheckbox').click(function(){
		   if(this.checked == true) {
		        $("#userNewPassword").attr('type','text');
		    } else {
		    	$("#userNewPassword").attr('type','password');
		   }
		});
});
</script>

<div class="had">
Zoom Meetings   &raquo; <span>
	My Profile
		</span>
</div>

<div class="message" align="center"> <?
    if (!empty($_SESSION['mess_meeting'])) {
        echo $_SESSION['mess_meeting'];
        unset($_SESSION['mess_meeting']);
    }
?></div>

<div id="AddUser" style="min-height: 400px;">
		<form name="form3" action=""  method="post" onSubmit="" >
		<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
			
			<input type="hidden" name="id" value="<?=$MeetingUser[0]['id']?>"/>
			
			<tr>
				 <td colspan="4" align="left" class="head">My Profile</td>
			</tr>
			
			<tr>
				 <td align="right"   class="blackbold" width="20%">Sign-In Email:</td>
				 <td   align="left" width="40%">
				 <?=$MeetingUser[0]['email']?>
				 </td>
			</tr>
			
			<tr>
				 <td align="right"   class="blackbold" width="20%">Meeting ID:</td>
				 <td   align="left" width="40%">
				 <b><?php $result1 = substr_replace($MeetingUser[0]['pmi'], "-", 3, 0);
										echo substr_replace($result1, "-", 7, 0);?> </b> &nbsp;&nbsp;  (Not used for instant meetings)
				 </td>
			</tr>
		
			<tr>
				 <td align="right"   class="blackbold" width="20%">Join URL:</td>
				 <td   align="left" width="40%">
				 	https://zoom.us/j/<?=$MeetingUser[0]['pmi']?>
				 </td>
			</tr>
			
			<tr>
				 <td align="right"   class="blackbold" width="20%">Member Since:</td>
				 <td   align="left" width="40%"><?=$MeetingUser[0]['created_at']?></td>
			</tr>
			
			<tr>
				 <td align="right"   class="blackbold" width="20%">Zoom TimeZone:</td>
				 <td   align="left" width="40%"><select class="inputbox" name="timezone" id="timezone" style="width: 265px;">
		        	<?php 
				       foreach ($objMeeting->meetingTimeZone() as $index=> $value){
				       	$tz = ($index==$MeetingUser[0]['timezone'])?'selected':'';
				       	if(empty($tz) && $index=='US/Eastern') $tz = 'selected';
				         echo "<option value='".$index."' $tz >" . $value ."</option>";
				       }
    				?>
		        </select> <input name="saveTimeZone" type="submit" class="button" id="saveTimeZone" style="height: 24px !important;" value="Save" /> </td>
			</tr>
			
			<tr>
				 <td align="right"   class="blackbold" width="20%">Password:</td>
				 <td   align="left" width="40%">
				 	<input type="password" name="userNewPassword" id="userNewPassword" class="showpassword inputbox" value="<?=$MeetingUser[0]['password']?>" />
				 	<input name="updatePassword" type="submit" class="button" id="updatePassword" style="height: 24px !important;" value="update" />
				 	<br/>
				 	<input type="checkbox" class="showpasswordcheckbox" style="margin-top: 5px;"> <span>Show Password</span>
				 </td>
			</tr>
			
		    </tr>
		</table>
		</form>
	</div>
	
