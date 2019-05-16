
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
<div class="message" align="center"><? if (!empty($_SESSION['mess_lead'])) {
    echo $_SESSION['mess_lead'];
    unset($_SESSION['mess_lead']);
} ?></div>
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
          <a class="add" href="ExportCsv.php">Export CSV</a>
          
	    </td>
	</tr>
      
    	  <tr>
            <td  valign="top">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table <?= $table_bg ?>>
						<tr align="left"  >
							<td width="11%" class="head1">Subject Name</td>  
														
							
							<td width="11%" align="center" class="head1" >Subscribers</td>
							<td width="11%" align="center" class="head1" >Opens</td>
							
							<td width="10%"  align="center" class="head1 head1_action" >Clicks</td>
                                                        <td width="10%"  align="center" class="head1 head1_action" >View Report</td>
						</tr>
<?php 
                        //echo '<pre>';print_r($updatelistcmp);die;
                        if (is_array($updatelistcmp) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            //foreach($ChimpCampaignList as $key => $values) {
                            for($i=1; $i<count($updatelistcmp);$i++){
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                                //if($values['status'] == 'send'){
                            ?>
							<tr align="left"  bgcolor="<?= $bgcolor ?>">  
							 <td><?= (!empty($updatelistcmp[$i]['subject'])) ? (stripslashes($updatelistcmp[$i]['subject'])) : (NOT_SPECIFIED) ?> </td>
							<td align="center">
							<?= (!empty($updatelistcmp[$i]['emails_sent'])) ? (stripslashes($updatelistcmp[$i]['emails_sent'])) : (NOT_SPECIFIED) ?> 		
							</td>
							
							<td align="center">
							<?= (!empty($updatelistcmp[$i]['unique_opens'])) ? (stripslashes($updatelistcmp[$i]['unique_opens'])) : (NOT_SPECIFIED) ?> </td>
							<td  align="center" class="head1_inner">
							<?= (!empty($updatelistcmp[$i]['clicks'])) ? (stripslashes($updatelistcmp[$i]['clicks'])) : (NOT_SPECIFIED) ?>
							</td>
                                                        <td  align="center" class="head1_inner">
							<a href="ViewChimpSummery.php?ReCmpID=<?php echo $updatelistcmp[$i]['id'];?>"><?=$view?></a>
							</td>
							</tr>
                                <?php //} /*end if status*/ 
                                
                                
                                } // foreach end //?>

                          <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($updatelistcmp) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
		<? if (sizeof($updatelistcmp)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
			<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($updatelistcmp) ?>">

            </td>
        </tr>
    </table>
</form>
