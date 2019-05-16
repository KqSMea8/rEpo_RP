
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

</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<div class="had"><?= $MainModuleName ?> User List</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_lead'])) {
    echo $_SESSION['mess_lead'];
    unset($_SESSION['mess_lead']);
} ?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
 
        <td align="right">	
          <a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
          <a class="add" href="addchimpUser.php">Add User</a>
          <a class="add" href="MailChamp_ImportUser.php">Import From Excel</a>
          <a class="add" href="MailChamp_ImportIntenal.php">Import From CRM</a>
	    </td>
	</tr>
      
    	  <tr>
            <td  valign="top">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table <?= $table_bg ?>>
						<tr align="left"  >
							<td width="11%" class="head1">First Name</td>  
							<td width="9%" class="head1">Last Name</td>								
							<td width="9%" class="head1">Email</td> 
							<td width="11%" align="center" class="head1" >Created Date</td>
							<td width="11%" align="center" class="head1" >Status</td>
							<td width="10%"  align="center" class="head1 head1_action" >Action</td>
						</tr>
<? 
                        if (is_array($ChimpUserList) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            foreach($ChimpUserList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                            ?>
							<tr align="left"  bgcolor="<?= $bgcolor ?>">  
							 <td><?= (!empty($values['fname'])) ? (stripslashes($values['fname'])) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($values['lname'])) ? (stripslashes($values['lname'])) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($values['email'])) ? (stripslashes($values['email'])) : (NOT_SPECIFIED) ?> </td>		
							<td align="center">
							<?= (!empty($values['create_date'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($values['create_date'])))) : (NOT_SPECIFIED) ?>		
							</td>
							<td><?= (!empty($values['status'])) ? (stripslashes($values['status'])) : (NOT_SPECIFIED) ?> </td>	
							
							<td  align="center" class="head1_inner">
							<a href="viewchimpUser.php?del_id=<?php echo $values['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&del_email=<?php echo $values['email']; ?>" onclick="return confirmDialog(this, 'MailChimp User')"  ><?= $delete ?></a>   
							</td>
							</tr>
                           <?php } // foreach end //?>

                          <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($ChimpUserList) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
		<? if (sizeof($ChimpUserList)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>', 'active', '<?=$Line?>', 'leadID', 'editLead.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>', 'inactive', '<?=$Line?>', 'leadID', 'editLead.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
                        </tr>
                    </table>
			<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($ChimpUserList) ?>">

            </td>
        </tr>
    </table>
</form>
