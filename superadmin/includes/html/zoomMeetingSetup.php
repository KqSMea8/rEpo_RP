<script language="JavaScript1.2" type="text/javascript">
$( function() {
	var myPos = { my: "center top", at: "center top+200", of: window };
	
dialog1 = $( "#CommentListdialog").dialog({
    autoOpen: false,
    show: {
      effect: "blind",
      duration: 100
    },
    hide: {
      effect: "blind",
      duration: 100
    },
    position: myPos,
    height: 400,
    width: 400
   
  });

$( "#CommentList" ).on( "click", function() {
    $( "#CommentListdialog" ).dialog( "open" ,"#CommentListdialog");
  });

});
</script>

<style>
<!--
div#CommentListdialog p {
    border: 1px solid #EB8;
    padding: 8px;
    border-radius: 7px;
    background-color: antiquewhite;
}

.comment_delete{
    text-align: right;
    display: block;
    margin-top: -25px;
    margin-right: -6px;
    cursor: pointer;
}

a#CommentList, a#AddComment {
    text-decoration: blink;
    font-weight: bold;
    cursor: pointer;
}

a#CommentList{margin-right: 40px;}
-->
</style>

<div class="message" align="center"><? if(!empty($_SESSION['mess_server'])) {echo $_SESSION['mess_server']; unset($_SESSION['mess_server']); }?></div>
<div><a class="back" href="viewCompany.php">Back</a></div>
<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<!--<form name="form1" action=""  method="post" onSubmit="return validateCompany(this);" enctype="multipart/form-data"> -->
<form name="form1" action=""  method="post"  enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Manage Zoom Meeting</td>
</tr>
		
		<tr>
			<td align="left" class="blackbold" width="20%">  Webinar: </td>
			<td align="left" width="40%">
			<input type="number" name="available_webinar" style="text-align: center;width: 35px;" class="inputbox" value="<?=$zoomArr['available_webinar'];?>" > (Total Licences)
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold" width="20%">Used Webinars: </td>
			<td align="left" width="40%"> 
				<b><?=count($zoomArr['webinar_company_list']);?></b>  
				&nbsp; &nbsp; &nbsp;<a id="CommentList"> Company List</a>
				<div id="CommentListdialog" title="Company List" style="display:none;">
				 <?php 
			 		if(!empty($zwebinarlist)){
			 		foreach ($zwebinarlist as $name){ ?>
						<p><?=stripslashes($name['CompanyName'])?> </p>
				<?php } }?>
				</div>
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold" width="20%"> Available Webinars </td>
			<td align="left" width="40%"> 
				<b><?=$zoomArr['available_webinar']-count($zoomArr['webinar_company_list']);?></b>   
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold" width="20%">Feature:</td>
			<td align="left" width="40%">
			<input type="checkbox" name="disable_chat" class="" value="1" <?if($zoomArr['disable_chat']) echo "checked"; ?> > Disable In-meeting Chat
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="disable_private_chat" class="" value="1" <?if($zoomArr['disable_private_chat']) echo "checked"; ?> > Disable Private Chat
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_silent_mode" class="" value="1" <?if($zoomArr['enable_silent_mode']) echo "checked"; ?> > Enable Attendee on-hold
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_cmr" class="" value="1" <?if($zoomArr['enable_cmr']) echo "checked"; ?> > Enable cloud recording
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_cloud_auto_recording" class="" value="1" <?if($zoomArr['enable_cloud_auto_recording']) echo "checked"; ?> > Enable cloud automatic recording
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_auto_saving_chats" class="" value="1" <?if($zoomArr['enable_auto_saving_chats']) echo "checked"; ?> > Enable automatic chats saving
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_annotation" class="" value="1" <?if($zoomArr['enable_annotation']) echo "checked"; ?> > Enable Annotation
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_file_transfer" class="" value="1" <?if($zoomArr['enable_file_transfer']) echo "checked"; ?> > Enable File transfer
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_share_dual_camera" class="" value="1" <?if($zoomArr['enable_share_dual_camera']) echo "checked"; ?> > Enable Share dual camera
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_far_end_camera_control" class="" value="1" <?if($zoomArr['enable_far_end_camera_control']) echo "checked"; ?> > Enable Far end camera control
			</td>
		</tr>
		
		<tr>
			<td align="left" class="blackbold"></td>
			<td align="left" width="40%">
			<input type="checkbox" name="enable_breakout_room" class="" value="1" <?if($zoomArr['enable_breakout_room']) echo "checked"; ?> > Enable breakout room
			</td>
		</tr>
	  
	<tr>
	<td  align="right"   class="blackbold" >&nbsp; </td>
	<td  align="left">

	<div id="SubmitDiv" style="display:none1">

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit "  />

	</div>

	</td>
	</tr>
	
</table>	
  

	
	  
	
	</td>
   </tr>

   

 
   </form>
</table>
