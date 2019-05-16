
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<style>		
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}
		a.Send{background: #81bd82;border: medium none;border-radius: 2px 2px 2px 2px;color: #FFFFFF;cursor: pointer; font-size: 12px;line-height: normal;padding: 1px 9px 2px 9px;}
      a.Unsend{background: #d40503;border: medium none;border-radius: 2px 2px 2px 2px;color: #FFFFFF;cursor: pointer; font-size: 12px;line-height: normal;padding: 1px 3px 2px 3px;}

</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<div class="had"><?= $MainModuleName ?> Campaign List</div>

<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
        <? if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<? } ?>
    <tr>
 
        <td align="right">	
          <a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
          <a class="add" href="AddchimpCampaign.php">Add Campaign</a>
          <a class="add" href="viewchimpReport.php">Report</a>
          
	    </td>
	</tr>
      
    	  <tr>
            <td  valign="top">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table <?= $table_bg ?>>
						<tr align="left"  >
                                                        <td width="11%" class="head1">Title</td>
							<td width="11%" class="head1">Subject Name</td>  
														
							
							<td width="11%" align="center" class="head1" >Created Date</td>
                                                        <td width="11%" align="center" class="head1" >Send Date</td>
                                                        
							<td width="11%" align="center" class="head1" >Status</td>
							
							<td width="10%"  align="center" class="head1 head1_action" >Action</td>
						</tr>
<?php 
                        if (is_array($result) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            foreach($result as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                            ?>
							<tr align="left"  bgcolor="<?= $bgcolor ?>">  
							 <td><?= (!empty($values['title'])) ? (stripslashes($values['title'])) : (NOT_SPECIFIED) ?> </td>
                                                         <td><?= (!empty($values['subject'])) ? (stripslashes($values['subject'])) : (NOT_SPECIFIED) ?> </td>
							<td align="center">
							<?= (!empty($values['create_time'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($values['create_time'])))) : (NOT_SPECIFIED) ?>		
							</td>
                                                        <td align="center">
							<?= (!empty($values['send_time'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($values['send_time'])))) : (NOT_SPECIFIED) ?>		
							</td>
							
                                                        
                                                        
							<td align="center">
							<?php if ($values['status_send'] == 'send') {
					$status = 'Sent';
                                        echo '<a href="javascript:void(0)" class="Send">' . $status . '</a>';
				} else {
					$status = 'Unsent';
                                        echo '<a href="ViewchimpCampaign.php?Camp_id=' . $values["campaign_id"] .'&S_id='.$values["id_local"].'" class="Unsend"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
				}

                                             
                                            ?></td>
							<td  align="center" class="head1_inner">
                                                            <?php if ($values['status_send'] == 'send') {
					$option = 'Reuse';
                                        echo '<a href="ReusechimpCampaign.php?Camp_id=' . $values["campaign_id"] .'&S_id='.$values["id_local"].'&Rtime='.$today.'" class="'.$option.'">' . $ReuseImage . '</a>';
				} else {
					$option = 'Edit';
                                        echo '<a href="EditchimpCampaign.php?Camp_id=' . $values["campaign_id"] .'&S_id='.$values["id_local"].'" class="'.$option.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $edit . '</a>';
				}

                                             
                                            ?>
							<a href="ViewchimpCampaign.php?del_id=<?php echo $values['id_local']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&del_campaign=<?php echo $values['campaign_id']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   
							</td>
							</tr>
                           <?php } // foreach end //?>

                          <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($result) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
		<?php if (sizeof($result)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" /></td>
                        </tr>
                    </table>
			<?php } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($result) ?>">

            </td>
        </tr>
    </table>
</form>
