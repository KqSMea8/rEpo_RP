<?php  

	include_once ('../includes/bbb-api.php');
	require_once("../classes/admin.class.php");
	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/meeting.class.php"); 
	require_once("../classes/cmp.class.php"); 
	$objCmp = new cmp();
	
	$ModuleName = "Meeting";
    $objMeeting = new Meeting();
    /*echo $Config['DbName'] = $_SESSION['CmpDatabase'];
	echo $objConfig->dbName = $Config['DbName']; die;
	$_SESSION['mess_reset'] = ENTER_EMAIL;
	$objConfig->connect();*/
    $MeetingData = '';
    $display = 0;
    if(!empty($_GET['MCode'])) {$display = 1;}

    if($_REQUEST && !empty($_REQUEST['MCode'])) { 
    	//print_r($_REQUEST);
		$CmpName = mysql_real_escape_string($_REQUEST['OrgName']);
		$MeetingID = mysql_real_escape_string($_REQUEST['MCode']);
		$Email = mysql_real_escape_string($_REQUEST['Email']); 
		#get company name from meeting ID	
		$cmpID = 0;
		$cmpID = substr($MeetingID,0,strpos($MeetingID,'-'));
		$cmpData = $objCmp->getCompanyById($cmpID);
		
		if(!empty($MeetingID) && !empty($cmpData[0]['CompanyName'])){  
			// Connect
			 $Config['DbName'] = 'ezshare_'.$cmpData[0]['DisplayName']; 
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 
              $MeetingData=$objMeeting->getMeetingId($MeetingID);
              if($MeetingData)
              {
              	$shareDetail = $objMeeting->getSharedUser($MeetingID,$Email);
              	
              	$arryMeetingDetail[0] = $MeetingData;
              	$arryMeetingDetail[0]['MType'] = $_REQUEST['MType'] = (!empty($shareDetail[0]['MType'])) ? Meeting::MEETING_MOD : Meeting::MEETING_ATTENDEE;
              	$status = false;
              	
              	if($_POST['submit']=='submit' && isset($_REQUEST['MType'])  && !empty($_REQUEST['Name'])){ 
              		
              		if($MeetingData['moderatorPw']== Meeting::DEFAULT_MOD_PWD && $_REQUEST['MType']==Meeting::MEETING_MOD){
              			$status = $objMeeting->goForMeetingCreateAndJoin($arryMeetingDetail,true,$_REQUEST['Name']);
              		}elseif($MeetingData['attendeePw']==Meeting::DEFAULT_ATD_PWD  && $_REQUEST['MType']==Meeting::MEETING_ATTENDEE){
              			$status = $objMeeting->goForMeetingCreateAndJoin($arryMeetingDetail,false,$_REQUEST['Name']);
              		}
	              	
	             }
								 
	             if(!empty($_REQUEST['Password'])){ 
	             	
	            	if($_POST['Password']==$MeetingData['moderatorPw'] && $MeetingData['moderatorPw']!=Meeting::DEFAULT_MOD_PWD)
	            	{
              			$status = $objMeeting->goForMeetingCreateAndJoin($arryMeetingDetail,true,$_REQUEST['Name']);
              		}
              		elseif($_POST['Password']==$MeetingData['attendeePw'] && $MeetingData['attendeePw']!=Meeting::DEFAULT_ATD_PWD)
              		{
		              	$status = $objMeeting->goForMeetingCreateAndJoin($arryMeetingDetail,false,$_REQUEST['Name']);
              		}
              		else
              		{
	              		$_SESSION['mess_reset'] = "Wrong Password";
	              	}
	              	
	             }
	             
	              if(!empty($_SESSION['mess_meeting'])){
	            	  $_SESSION['mess_reset'] =	$_SESSION['mess_meeting'];
	            	  unset($_SESSION['mess_meeting']);
	              }
	              
             	 if(!empty($status) && empty($_SESSION['mess_reset'])){
             	 	if(!empty($shareDetail)){
             	 		$objMeeting->updateMeetingStatus($shareDetail[0]['id'],$_REQUEST['Name']);
             	 	}else{
             	 		$_REQUEST['meetingId'] = $MeetingID;
             	 		$_REQUEST['userId'] = 0;
             	 		$_REQUEST['email'] = $_REQUEST['Email'];
             	 		$_REQUEST['userName'] = $_REQUEST['Name'];
             	 		$objMeeting->joinMeeting($_REQUEST);
             	 	}
              		header("Location: ".$status);	
              	}
	              
	              
              }else {
	              	$_SESSION['mess_reset']='Intered a wrong meeting code for this organisation.';
	              }
              
              
		}else{
			$_SESSION['mess_reset'] = "Invalid Meeting!"; 
		}
	}

 ?>
	<style type="text/css">
.tabs {
	display: block;
}

#page-title {
	color: #333;
	font-size: 32px;
	font-weight: 300;
	margin: 50px 0 0;
	padding: 0 0 30px;
	text-align: left;
}
</style>
<SCRIPT LANGUAGE=JAVASCRIPT>
function validateForm(frm)
{	
	if( ValidateLoginEmail(frm.Email, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	){
		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>
<div class="top-cont1"> </div>

			<section id="mainContent">
			<?php //echo $datah['Content'];?>
				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">Join a Meeting</h1>
										

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">

											<div class="message_success"  id="msg_div" >
											<? if(!empty($_SESSION['mess_reset'])) {
												echo $_SESSION['mess_reset']; 
												unset($_SESSION['mess_reset']); 
											}?>
											</div>
											
												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-pass-errors"
														style="display: none;">
														<ul></ul>
													</div>
													<?php if(empty($_REQUEST['MCode']) || empty($_REQUEST['Email']) || empty($_REQUEST['Name'])){?>
													<form accept-charset="UTF-8" id="user-pass" method="post"
														action="" novalidate="novalidate" onSubmit="return validateForm(this);">
														<div>
														<?php if(!$display){ ?>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Meeting Code <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="<?=$_REQUEST['MCode']?>" name="MCode"
																	id="MCode" required>
															</div>
															
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Email <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="<?=$_REQUEST['Email']?>" name="Email"
																	id="Email">
															</div>
															
															<!--<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Organization Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="<?=$_REQUEST['OrgName']?>" name="OrgName"
																	id="OrgName">
															</div>
														--><?php }?>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Name 
																</label> <input type="text" class="form-text"
																	maxlength="254" size="60" value="<?=$_REQUEST['Name']?>" name="Name"
																	id="Name">
															</div>
															
															<div id="edit-actions" class="form-actions form-wrapper">
																<input type="submit" class="form-submit"
																	value="submit" name="submit" id="submit">
															</div>
														</div>
													</form>
													
													<?php }
													if($MeetingData && !empty($_POST['Name'])){ ?>
													<form accept-charset="UTF-8" id="user-pass" method="post"
														action="" novalidate="novalidate" onSubmit="return validateForm(this);">
														<input type="hidden" name="MCode" value="<?=$_REQUEST['MCode']?>">
														<input type="hidden" name="Name" value="<?=$_REQUEST['Name']?>">
														<input type="hidden" name="Email" value="<?=$_REQUEST['Email']?>">
														<div class="form-item form-type-textfield form-item-name">
															<label for="edit-name">Password <span
																title="This field is required." class="form-required">*</span>
															</label> <input type="text" class="form-text required"
																maxlength="254" size="60" value="" name="Password"
																id="Password">
														</div>
														
														<div id="edit-actions" class="form-actions form-wrapper">
															<input type="submit" class="form-submit"
																value="submit" name="pass_submit" id="submit">
														</div>
													</form>
													<?php }?>
													
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>
			</section>
</div>