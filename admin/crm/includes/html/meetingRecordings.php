<script language="JavaScript1.2" type="text/javascript">
$(document).ready(function() {
	$(".fancybox").fancybox();

	$('#ShipDate').datepicker(
			{
			showOn: "both",
			dateFormat: 'yy-mm-dd', 
			yearRange: '2015:2025', 
			changeMonth: true,
			changeYear: true
	
			}
		);

	$('#customers').on('change', function() {
		var email = $(this).find(':selected').attr('email');
		var fname = $(this).find(':selected').attr('fname');
		var lname = $(this).find(':selected').attr('lname');
		
		$("#email").val(email);
		$("#first_name").val(fname);
		$("#last_name").val(lname);

	});
});
</script>

<div class="had">Recordings Management</div>

<div class="message" align="center"><?
    if (!empty($_SESSION['mess_meeting'])) {
        echo $_SESSION['mess_meeting'];
        unset($_SESSION['mess_meeting']);
    }
    ?></div>

<form action="" method="post" name="form2">    
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
		<?php //if($_SESSION['AdminType']=='admin'){ ?>			
        <td align="right">
            <?php if(!empty($_GET['meeting_id'])){?>
        	<a href="<?=$RedirectUrl?>" class="grey_bt">View All</a>
        	<?php }?>
            <input type="submit" class="search_button" name="sync_meeting" value="Sync Recordings">
        </td>
        <?php //}?>
    </tr>
</table>
 </form>
 
 
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
                                <td width="12%" class="head1" >Meeting Start Time</td>
                                <td class="head1" >Meeting Host</td>
                                <td class="head1"> Meeting topic </td>
                                <td  width="12%" class="head1" >Meeting ID</td>
                                <td width="12%" class="head1" > File Size</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>

                            <?

                        if (is_array($arryMeetingRecords) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            foreach ($arryMeetingRecords as $key => $values) {
                            	$flag = !$flag;
                            	$Line++;
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td><?=date($Config['DateFormat'], strtotime($values['start_time'])).' '.date($Config['TimeFormat'], strtotime($values['start_time']))?></td>
                            	<td><?=$values['email']?></td>
                                <td><a href="../crm/meetingRecordingFiles.php?edit=<? echo urlencode($values['uuid']); ?>"><?=$values['topic']?></a></td>
                                <td><?php $result = substr_replace($values['meeting_number'], "-", 3, 0);
										echo substr_replace($result, "-", 7, 0);?></td>
                                <td><?=$objMeeting->StorageSize($values['total_size']).' ('.$values['recording_count'].' Files)'?></td>
                                <td align="center">
                                    <a href="../crm/meetingRecordingFiles.php?edit=<? echo urlencode($values['uuid']); ?>"><?= $view ?></a>
                                    <?php if( (($_SESSION['AdminType']!='admin') && (in_array('deleteRecording', $zoomPermission) || in_array('viewAll', $zoomPermission)) ) || ($_SESSION['AdminType']=='admin')) { ?>
                                    <a href="meeting.php?del_id=<? echo urlencode($values['uuid']); ?>&curP=<?php echo $_GET['curP']; ?>&tab=Recordings" onClick="return confDel('Recording')"  ><?= $delete ?></a>
                                    <?php }?>	
                                 </td>
                            </tr>	
                         <?php    } // foreach end //   ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryMeetingRecords) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryMeetingRecords)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
                <? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
             <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryMeetingRecords)?>">
        </td>
    </tr>
</table>
 </form>

