<script language="JavaScript1.2" type="text/javascript">

   
</script>

<div class="had">Registrants for '<?=$Webinar[0]['topic']?>'</div>

<div class="message" align="center"> <?
    if (!empty($_SESSION['mess_meeting'])) {
        echo $_SESSION['mess_meeting'];
        unset($_SESSION['mess_meeting']);
    }
?></div>
    

 
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
                                <td  class="head1" width="20%">Registration Date</td>
                                <td width="30%" class="head1"> Registrants </td>
                                <td  class="head1" >Email Address</td>
                                <td width="12%" class="head1" >Status</td>
                            </tr>
                            

                        <? if (is_array($result->attendees) && $result->total_records > 0) { 
                            $flag = true;
                            $Line = 0;

                            foreach ($result->attendees as $key => $values) {  ?>
                            	
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                            	<td><?php echo date($Config['DateFormat'], strtotime($values->create_time));?></td>
                                <td><?=$values->first_name.' '.$values->last_name?></td>
                                <td><?=$values->email?></td>
                                <td><?=$values->approval?></td>
                            </tr>	
                            	
                          <?php  } // foreach end //   ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $result->total_records; ?>      <?php if (count($result->attendees) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $result->page_number;
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

 