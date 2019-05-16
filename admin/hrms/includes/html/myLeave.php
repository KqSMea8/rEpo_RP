<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had">My Leaves</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_leave'])) {echo $_SESSION['mess_leave']; unset($_SESSION['mess_leave']); }?></div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
	  <td  valign="top">
	  Leave Entitled : <span class="red"><?=$LeaveEntitle?></span>
	 <br /> Leave Balance : <span class="red"><?=$LeaveBalance?></span>
	  </td>
</tr>	


   <tr>
	  <td>
<? if($IsDeptHead==1){?>
<a href="leaveApplied.php" class="grey_bt">Leave Applied to Me</a>
<?}?>

<a href="applyLeave.php" class="add">Apply For Leave</a>
		
<a class="grey_bt fancybox"  href="#holiday_div" >Holiday List</a>


	  
	  </td>
 </tr>
 <tr>
	  <td  valign="top">
	  


<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >

<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td width="10%"  class="head1" >Leave Type</td>
       <td width="15%"  class="head1" align="center">From Date</td>
     <td width="15%"  class="head1" align="center">To Date</td>
     <td width="4%"  class="head1" align="center">Days</td>
	<!--td width="4%"  class="head1" align="center">Last Balance</td-->
    <td   class="head1" >Comment</td>
     <td width="15%"  class="head1" align="center">Applied On</td>
      <td width="7%"  align="center" class="head1" >Status</td>
       <td width="5%"  align="center" class="head1 head1_action" >Action</td>
   </tr>
   
    <?php 
  if(is_array($arryLeave) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryLeave as $key=>$values){
	$flag=!$flag;
	$Line++;

	 if($values['Status'] == "Approved") $stClass = 'green';
	 else if($values['Status'] == "Rejected") $stClass = 'red';
	 else $stClass = '';

  ?>
    <tr align="left" >
      <td ><?=$values["LeaveType"]?></td>
      <td align="center"> <? if($values["FromDate"]>0) echo date($Config['DateFormat'], strtotime($values["FromDate"])); ?></td>
      <td align="center"> <? if($values["ToDate"]>0) echo date($Config['DateFormat'], strtotime($values["ToDate"])); ?></td>
        <td align="center"><?=$values["Days"]?></td>
        <!--td align="center"><?=$values["LastBalance"]?></td-->
     <td ><?=stripslashes($values["Comment"])?></td>
      <td align="center"><? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
      <td align="center" class="<?=$stClass?>"><?=$values["Status"]?></td>
		 <td  align="center" class="head1_inner" >

			  <a class="fancybox fancybox.iframe" href="vLeave.php?view=<?=$values['LeaveID']?>" ><?=$view?></a>
		</td>
    </tr>
    <?php 

	//echo "<br>UPDATE h_leave SET LastBalance = '0' WHERE LeaveID = ".$values['LeaveID'].";";

} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_LEAVE_TAKEN?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="10" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?></td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</td>
</tr>
</table>
<?  include("includes/html/box/holiday_list.php"); ?>
</div>
