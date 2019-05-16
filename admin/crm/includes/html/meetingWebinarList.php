<script language="JavaScript1.2" type="text/javascript">

   
</script>

<div class="had">My Webinars</div>

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
	                    $WebinarType = $_GET["WebinarType"];
	                    $a = $b = 'background-color: #FBBC2F !important;';
	                    if($WebinarType=='Previous'){
	                    	$b = '';
	                    }else{
	                    	$a = '';
	                    }
                    ?>
			<a style="<?=$a?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="meeting.php?tab=Webinar" >Upcoming Webinars</a>
			<a style="<?=$b?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="meeting.php?tab=Webinar&WebinarType=Previous" >Previous Webinars</a>
		</td>
					
        <td align="right">
            <a class="add" href="meetingScheduleWebinar.php" >Schedule a Webinar</a>
						<a class="grey_bt fancybox fancybox.iframe" href="meetingLeadForm.php" >Generate a Site Link</a>
        </td>
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
                                <td  class="head1" width="10%">Start Date</td>
                                <td width="10%" class="head1"> Start Time </td>
                                <td  class="head1" >Topic</td>
                                <td width="12%" class="head1" >Webinar ID</td>
                                <td width="20%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                            

                        <? if (is_array($arryWebinars) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            foreach ($arryWebinars as $key => $values) { ?>
                            	
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                            	<td><?php if ($values['start_time'] > 0)
               							  echo date($Config['DateFormat'], strtotime($values['start_time']));?></td>
                                <td><?php if ($values['start_time'] > 0)
               							  echo date($Config['TimeFormat'], strtotime($values['start_time']));?></td>
                                <td><a href="../crm/meetingViewWebinar.php?view=<?=$values['webinar_id']?>" class="fancybox fancybox.iframe"><?=$values['topic']?></td>
                                <td><?php $result = substr_replace($values['webinar_id'], "-", 3, 0);
										echo substr_replace($result, "-", 7, 0);?></td>
                                <td align="center">
                                <?php if($_GET['WebinarType']=='Previous'){?>
                                <a href="meeting.php?curP=1&webinar_id=<? echo $values['webinar_id']; ?>&tab=Recordings" >View Recordings</a>
                                <?php }else{?>
                                	<a href="<?=$values['start_url']?>" target="_blank" class="Active">Start</a> &nbsp;
					<a href="meetingScheduleWebinar.php?edit=<?=$values['webinar_id']?>" ><?=$edit?></a> 
                                    <?php } ?>	
                                 </td>
                            </tr>	
                            	
                          <?php  } // foreach end //   ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryWebinars) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryWebinars)) { ?>
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
             <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryActivity)?>">
        </td>
    </tr>
</table>
 </form>

 
