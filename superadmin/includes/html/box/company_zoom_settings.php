<?php 

	/***************************/
	$count = 0; 
	$sql = "select * from settings where Module = 'Zoom' ";
	$zoom = $objConfig->query($sql,1);
	
	$zoomArr = array();
	foreach ($zoom as $field => $val){
		$zoomArr[$val['S_Key']] = $val['S_Value'];
	}
	
	if(!empty($zoomArr) && !empty($zoomArr['webinar_company_list'])){
		$webinars = explode(",", $zoomArr['webinar_company_list']);
		$count = count($webinars);
	}
	
	$available_webinar = $zoomArr['available_webinar']-$count;
	/***************************/

	/****************************/
        $_GET['cmp']=$_GET['edit'];
	require_once("userInfoConnection.php");
	$_SESSION['locationID']=1;
	/****************************/
	

	$userData = $objMeeting->findMeetingUserByAdmin();
	$userData = (!empty($userData[0]))?($userData[0]):('');
$isZoomMeetngActive = $objMeeting->isZoomMeetngActive();
	
	$webinarStatus = $objMeeting->findMeetingUserColumn('enable_webinar',1);
	$webinarStatus = !empty($webinarStatus[0])?($webinarStatus[0]):('');
?>

<script language="JavaScript1.2" type="text/javascript">
function meetingAlert() {
    if(confirm("Changes will be applied to company's all members as well!")){
        return true;
    } else{
        return false;
    }
}
</script>


<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<form name="form1" action=""  method="post"  enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Manage Zoom Meeting</td>
</tr>
	<!--  
		<tr>
			 <td align="left" class="blackbold" width="20%">Type:</td>
			 <td align="left" width="50%">
			 <input type="radio" id="type" name="type" class="" value="1" <? //if($userData['type']) echo "checked"; ?> > Basic 
			 <input type="radio" id="type1" name="type" class="" value="2" <? //if($userData['type']==2) echo "checked"; ?> > Pro <br>
			 </td>
		</tr>
		-->
		<?php if(!empty($userData)){?>
		<tr>
			<td align="right" class="blackbold">Zoom Module:</td>
			<td align="left" width="50%">
			<select class="inputbox" name="zoom_module" id="zoom_module">
				<option value="0">Inactive</option>
				<option value="1" <? if($isZoomMeetngActive) echo "selected";?>>Active</option>
			</select>
			<input name="ActivateZoomModule" type="submit" class="button" id="ActivateZoomModule" style="height: 24px !important;" value="Update">
			</td>
		</tr>

		<tr>
			<td align="right" class="blackbold">Webinar: </td>
			<td align="left" width="40%">
			<?php if(!empty($available_webinar) || !empty($webinarStatus['enable_webinar'])){?>
			<select class="inputbox" name="enable_webinar">
			<option value="0">Disable</option>
			<option value="1" <?if($webinarStatus['enable_webinar']) echo "selected"; ?>>Enable</option>
			</select>
			<input type="hidden" value="<?=$userData['id']?>" name="user_id">
			<input type="hidden" value="<?=$zoomArr['webinar_company_list']?>" name="webinar_company_list">
			<input type="submit" value=" Update " id="SubmitButton" class="button" name="Webinar">
			<?php }else{
				echo "<div class='message' style='text-align:left;'>Reached to max limit.</div>";
			}?>
			</td>
		</tr>

		<tr>
			<td align="right" class="blackbold">Feature:</td>
			<td align="left" width="50%">
			<input type="checkbox" name="disable_chat" class="" value="1" <?if($userData['disable_chat']) echo "checked"; ?> > Disable In-meeting Chat
			</td>
		</tr>
			
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="disable_private_chat" class="" value="1" <?if($userData['disable_private_chat']) echo "checked"; ?> > Disable Private Chat
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_silent_mode" class="" value="1" <?if($userData['enable_silent_mode']) echo "checked"; ?> > Enable Attendee on-hold
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_cmr" class="" value="1" <?if($userData['enable_cmr']) echo "checked"; ?> > Enable cloud recording
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_cloud_auto_recording" class="" value="1" <?if($userData['enable_cloud_auto_recording']) echo "checked"; ?> > Enable cloud automatic recording
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_auto_saving_chats" class="" value="1" <?if($userData['enable_auto_saving_chats']) echo "checked"; ?> > Enable automatic chats saving
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_annotation" class="" value="1" <?if($userData['enable_annotation']) echo "checked"; ?> > Enable Annotation
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_file_transfer" class="" value="1" <?if($userData['enable_file_transfer']) echo "checked"; ?> > Enable File transfer
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_share_dual_camera" class="" value="1" <?if($userData['enable_share_dual_camera']) echo "checked"; ?> > Enable Share dual camera
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_far_end_camera_control" class="" value="1" <?if($userData['enable_far_end_camera_control']) echo "checked"; ?> > Enable Far end camera control
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="50%">
			<input type="checkbox" name="enable_breakout_room" class="" value="1" <?if($userData['enable_breakout_room']) echo "checked"; ?> > Enable breakout room
			</td>
		</tr>
	  
	<tr>
	<td  align="right"   class="blackbold" >&nbsp; </td>
	<td  align="left">

	<div id="SubmitDiv" style="display:none1">
	<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />
<input name="Email" type="hidden" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" />
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update " onclick="return meetingAlert();"  />

	</div>

	</td>
	</tr>
	<? }else{ ?>
	<tr>
	<td  align="left" class="blackbold" >
	<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />
	<input name="Email" type="hidden" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" />
		<input name="ActivateZoom" type="submit" class="button" id="SubmitButton" value=" Get Started ">
	</td>
	</tr>
<? } ?>
</table>	
  

	
	  
	
	</td>
   </tr>

   

 
   </form>
</table>
