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

<div class="had">User Management</div>

<div class="message" align="center"><?
    if (!empty($_SESSION['mess_meeting'])) {
        echo $_SESSION['mess_meeting'];
        unset($_SESSION['mess_meeting']);
    }
    ?></div>
    
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
		<?php if($_SESSION['AdminType']=='admin'){ ?>			
        <td align="right">
            <a href="#AddUser" class="fancybox add" style="color:#fff;" >Add User</a>
        </td>
        <?php }?>
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
                                <td  class="head1" >Email/Name ID</td>
                                <td width="10%" class="head1"> First Name </td>
                                <td  class="head1" >Last Name</td>
                                <td width="12%" class="head1" >Type</td>
                                <td width="17%" class="head1" > Creation Date</td>
                                <td width="8%"  align="center" class="head1" >  Status</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>

                            <?

                        if (is_array($arryMeetingUsers) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            foreach ($arryMeetingUsers as $key => $values) {
                            	$flag = !$flag;
                            	$Line++;
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                            	<td><?=$values['email']?></td>
                                <td><?=$values['first_name']?></td>
                                <td><?=$values['last_name']?></td>
                                <td><?=($values['type']==2)?'Pro':'Basic'?></td>
                                <td><?=date($Config['DateFormat'], strtotime($values['created_at'])).' '.date($Config['TimeFormat'], strtotime($values['created_at']))?></td>
                                <td align="center">
                                 <?php if($values['status']){?>
                                     <a href="<?=$RedirectUrl?>&active_id=<? echo $values['user_id']; ?>&status=0" class="Active">Active</a>
                                     <?php }else{?>
                                     <a href="<?=$RedirectUrl?>&active_id=<? echo $values['user_id']; ?>&status=1" class="InActive">InActive</a>
                                     <?php }?>
                                </td>
                                <td align="center">
                                    <a href="../crm/meetingEditUserManagement.php?edit=<? echo $values['user_id']; ?>" class="fancybox fancybox.iframe"><?= $edit ?></a>
                                    <a href="meeting.php?del_id=<? echo $values['id']; ?>&module=Activity&curP=<?php echo $_GET['curP']; ?>&tab=UserManagement" onClick="return confDel('Product')"  ><?= $delete ?></a>	
                                 </td>
                            </tr>	
                         <?php    } // foreach end //   ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryMeetingUsers) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryMeetingUsers)) { ?>
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
             <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryMeetingUsers)?>">
        </td>
    </tr>
</table>
 </form>


<div style="display:none">
	<div id="AddUser">
		<?php 
		?>
		<form name="form3" action=""  method="post" onSubmit="" >
		<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
			<input name="group_id" type="hidden" value="<?=$group_id?>" />
			<input name="admin_id" type="hidden" value="<?=$admin_id?>" />
			
			<tr>
				 <td colspan="4" align="left" class="head">Add User</td>
			</tr>
			
			 <tr>
		        <td  align="left"   class="blackbold" width="20%">Customer:<span class="red">*</span> </td>
		        <td   align="left" width="40%">
					<select class="inputbox select" title="customers list" name="customers" id="customers">
							<option value="">-- Please select --</option>
							 <?php 
					        	foreach($arryCustomer as $Customer){
					        ?>
							<option value="<?=$Customer['EmpID']?>" email="<?=$Customer['Email']?>" fname="<?=$Customer['FirstName']?>" lname="<?=$Customer['LastName']?>" ><?=$Customer['UserName']?></option>					
							<?php }?>		
					</select>
				</td>
		    </tr>
			
			<tr>
				 <td align="left"   class="blackbold" width="20%">Email:<span class="red">*</span></td>
				 <td   align="left" width="40%">
					 <input type="email" id="email" name="email" class="disabled inputbox" value="" readonly >
				 </td>
			</tr>
		     
		    <tr>
				 <td align="left"   class="blackbold" width="20%">First Name:</td>
				 <td   align="left" width="40%">
				 <input id="first_name" name="first_name" class="inputbox" value="">
				 </td>
			</tr>
			
			<tr>
				 <td align="left"   class="blackbold" width="20%">Last Name:</td>
				 <td   align="left" width="40%">
				 <input id="last_name" name="last_name" class="inputbox" value="">
				 </td>
			</tr>
			
			 <tr>
				 <td align="left"   class="blackbold" width="20%">Type:</td>
				 <td   align="left" width="40%">
				 <input type="radio" id="type" name="type" class="" value="1" checked="checked" > Basic 
				 <input type="radio" id="type1" name="type" class="" value="2" > Pro <br/>
				 </td>
			</tr>
			
			<tr>
				 <td align="left"   class="blackbold" width="20%">Feature:</td>
				 <td   align="left" width="40%">
				 <input type="checkbox" name="enable_large" class="" value="1"> Large Meeting
				 </td>
			</tr>
		    
		        <td   align="center" width="40%" colspan="2">
		        	<br/>
					<input name="confirmAddUser" type="submit" class="button" id="confirmAddUser" value="Add User" /> 
				</td>
		    </tr>
		</table>
		</form>
	</div>
</div>

 <script src="javascript/chosen.jquery.min.js" type="text/javascript"></script>
 <link rel="stylesheet" href="css/chosen.min.css">
 <script type="text/javascript"> 
$(document).ready(function() {
     $("#customers").chosen({
    display_selected_options: 10,
    no_results_text: "Oops, nothing found!",
    width: "59%",
    Height: "10%"
  });
 });
  </script>