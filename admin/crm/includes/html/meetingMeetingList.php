<script language="JavaScript1.2" type="text/javascript">

   
</script>

<div class="had">My Meetings</div>

<div class="message" align="center"> <?
    if (!empty($_SESSION['mess_meeting'])) {
        echo $_SESSION['mess_meeting'];
        unset($_SESSION['mess_meeting']);
    }
?></div>
    
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
    	<td>
			 <?php 
	                    $MeetingType = $_GET["MeetingType"];
	                    $a = $b = 'background-color: #FBBC2F !important;';
	                    if($MeetingType=='Previous'){
	                    	$b = '';
	                    }else{
	                    	$a = '';
	                    }
                    ?>
			<a style="<?=$a?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="meeting.php" >Upcoming Meetings</a>
			<a style="<?=$b?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="meeting.php?MeetingType=Previous" >Previous Meetings</a>
		</td>
		<? if( in_array('createMeeting', $zoomPermission) || in_array('viewAll', $zoomPermission) || ($_SESSION['AdminType']=='admin')){ ?>			
        <td align="right">
            <a class="add" href="meetingScheduleMeeting.php" >Schedule a Meeting</a>
        </td>
		<? }?>
    </tr>
</table>
 
<form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  valign="top">
          
                <div id="prv_msg_div" style="display:none">
                    <img src="images/loading.gif">&nbsp;Searching.........</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                            <tr align="left"  >
                                <!--td width="6%"  class="head1" >ID</td-->
                                <td  class="head1" width="10%">Date</td>
                                <td width="10%" class="head1"> Time </td>
                                <td  class="head1" >Topic</td>
                                <td width="12%" class="head1" >Meeting ID</td>
                                <td width="8%" class="head1" >Created By</td>
                                <td width="20%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                            
                            <?php if(!empty($MeetingUser) && is_array($MeetingUser) && $_GET['MeetingType']!='Previous'){?>
							 <tr align="left" valign="middle">
                            	<td colspan="2"><b>Personal Meeting Room</b></td>
                                <td><a href="../crm/meetingViewMeeting.php?view=<?=$MeetingUser[0]['id']?>&type=personal" class="fancybox fancybox.iframe"></a><?=$MeetingUser[0]['first_name'].' '.$MeetingUser[0]['last_name']."'s Personal Meeting Room"?></td>
                                <td colspan="2"><?php $result1 = substr_replace($MeetingUser[0]['pmi'], "-", 3, 0);
										echo substr_replace($result1, "-", 7, 0);?></td>
                                <td align="center">
                               		 <a href=meeting.php?zpk=<?=$MeetingUser[0]['zpk']?>" target="_blank" class="Active">Start</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 </td>
                            </tr>
                            <? }

                        if (is_array($arryMeetings) && $num > 0) {
                            $flag = true;
                            $Line = 0;
								$adminuser = $objMeeting->findMeetingUserByAdmin();
                            foreach ($arryMeetings as $key => $values) { ?>
                            	
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                            	<td><?php if ($values['start_time'] > 0)
               							  echo date($Config['DateFormat'], strtotime($values['start_time']));?></td>
                                <td><?php if ($values['start_time'] > 0)
               							  echo date($Config['TimeFormat'], strtotime($values['start_time']));?></td>
                                <td><a href="../crm/meetingViewMeeting.php?view=<?=$values['meeting_id']?>" class="fancybox fancybox.iframe"><?=$values['topic']?></td>
                                <td><?php $result = substr_replace($values['meeting_id'], "-", 3, 0);
										echo substr_replace($result, "-", 7, 0);?></td>
								<td><?= ($values['user_id']==$adminuser[0]['id'])?'admin':'user' ?></td>
                                <td align="center">
                                <?php if($_GET['MeetingType']=='Previous'){?>
                                <a href="meeting.php?curP=1&meeting_id=<? echo $values['meeting_id']; ?>&tab=Recordings" >View Recordings</a>
                                <?php }else{?>
                                	<a href="<?=$values['start_url']?>" target="_blank" class="Active">Start</a> &nbsp;
                                    <a href="../crm/meetingScheduleMeeting.php?edit=<? echo urlencode($values['meeting_id']); ?>" ><?= $edit ?></a>&nbsp;
                                    <a href="meeting.php?del_id=<? echo $values['user_id']; ?>&meeting_id=<? echo $values['meeting_id']; ?>&curP=<?php echo $_GET['curP']; ?>" onClick="return confDel('Meeting')"  ><?= $delete ?></a>
                                    <?php } ?>	
                                 </td>
                            </tr>	
                            	
                          <?php  } // foreach end //   ?>

                        <?php } else { 
                       		 if($_GET['MeetingType']=='Previous'){?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php }
                        } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryMeetings) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 
                

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
             <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryMeetings)?>">
        </td>
    </tr>
</table>
 </form>

 
