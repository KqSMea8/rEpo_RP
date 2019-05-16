
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
<div class="had"><?= $MainModuleName ?> Template List</div>
<div class="message" align="center"><? if (!empty($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
	
	
} ?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
 
        <td align="right">	
          <a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
          <a class="add" href="addchimpTemplate.php">Add Template</a>		    
	    </td>
	</tr>
      
    	  <tr>
            <td  valign="top">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table <?= $table_bg ?>>
						<tr align="left"  >
							<td width="11%" class="head1">Name</td>  
							<td width="9%" class="head1">Preview</td>								
							<td width="11%" align="center" class="head1" >Created Date</td>
							<td width="10%"  align="center" class="head1 head1_action" >Action</td>
						</tr>
<?php 
                        if (is_array($listtamplate['user']) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            for($i=0; $i< sizeof($listtamplate['user']); $i++){
                                //$data3[$i] = $listtamplate['user'][$i]+$templateList[$i];
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                            ?>
							<tr align="left"  bgcolor="<?= $bgcolor ?>">  
							 <td><?= (!empty($listtamplate['user'][$i]['name'])) ? (stripslashes($listtamplate['user'][$i]['name'])) : (NOT_SPECIFIED) ?> </td>
							 <td> 
							 <?php if(!empty($listtamplate['user'][$i]['preview_image'])) { ?>
							 <!--<a href="<?php echo $listtamplate['user'][$i]['preview_image'];?>"  target="_blank">Click here </a>-->
                                                         <a href="javascript:void(0)" onclick="return window.open('<?php echo $listtamplate['user'][$i]['preview_image'];?>','test','width=640,height=602,resizable=no,scrollbars=yes,toolbar=no,menubar=no,titlebar=no,top=50,left=100');">Click here </a>
                             <?php } else {   
							   echo NOT_SPECIFIED;
							  } ?> 

							 </td>
									
							<td align="center">
							<?= (!empty($listtamplate['user'][$i]['date_created'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($listtamplate['user'][$i]['date_created'])))) : (NOT_SPECIFIED) ?>		
							</td>
						
							
							<td  align="center" class="head1_inner">
							<a href="viewchimpTemplate.php?del_id=<?php echo $listtamplate['user'][$i]['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;id=<?php echo $listtamplate['user'][$i]['id']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>
                                                        <a href="EditchimpTemplate.php?Temp_id=<?php echo $listtamplate['user'][$i]['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" class=""><?= $edit ?></a>
							</td>
							</tr>
                           <?php } // foreach end //?>

                          <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if ($num > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
		<?php if (sizeof($listtamplate['user'])) { ?>
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

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($listtamplate['user']) ?>">

            </td>
        </tr>
    </table>
</form>
