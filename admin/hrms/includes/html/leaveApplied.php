<script language="JavaScript1.2" type="text/javascript">

	function ShowListing(){
		ShowHideLoader('1','L');	
		location.href = "viewLeave.php?d="+document.getElementById("Department").value;
	}


	function ValidateSearch(){	
		var FromDate = document.getElementById("FromDate").value;
		var ToDate = document.getElementById("ToDate").value;
		if(ToDate!='' && FromDate!=''){
			if(ToDate < FromDate){
				alert("From Date should not be geater than To Date.");
				document.getElementById("FromDate").focus();
				return false;
			}
		}

		ShowHideLoader('1','F');
		/*document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';*/
		
	}
</script>




<a href="myLeave.php" class="back">Back</a>


<div class="had">Leave Applied to Me</div>




<div class="message" align="center"><? if(!empty($_SESSION['mess_leave'])) {echo $_SESSION['mess_leave']; unset($_SESSION['mess_leave']); }?></div>


<? if(!empty($ErrorMSG)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMSG?>
	  </div>
<? }else{?>
<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">


 <tr>
        <td>
	

<? if($_GET['search']!='') {?>
	<a href="viewLeave.php" class="grey_bt">View All</a>
<? }?>
		
		
		
		</td>
 </tr>






 <tr>
	  <td  valign="top">
	 


<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td  class="head1" >Employee</td>
    <td width="10%"  class="head1" >Leave Type</td>
       <td width="10%"  class="head1" align="center">From Date</td>
     <td width="10%"  class="head1" align="center">To Date</td>
     <td width="4%"  class="head1" align="center">Days</td>
    <td width="14%" class="head1" >Comment</td>
    <td width="10%"  class="head1" align="center">Applied On</td>
     <td width="10%"  class="head1" align="center">Final Status</td>
      <td width="15%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryLeave) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryLeave as $key=>$values){
	$flag=!$flag;
	$Line++;

	 if($values['Status'] == "Approved"){
		 $stClass = 'green';
	 }else if($values['Status'] == "Rejected"){
		 $stClass = 'red';
	 }else {$stClass = '';}

	$arryApproval = $objLeave->CheckLeaveApproval($values['LeaveID'],$_SESSION['AdminID']);
  ?>
    <tr align="left" >
      <td >
<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>   
	- <?=$values["EmpCode"]?>
	<br><?=$values["JobTitle"]?> - <?=$values["Department"]?>
	  </td>

     <td><?=$values["LeaveType"]?></td>
      <td align="center"> <? if($values["FromDate"]>0) echo date($Config['DateFormat'], strtotime($values["FromDate"])); ?></td>
      <td align="center"> <? if($values["ToDate"]>0) echo date($Config['DateFormat'], strtotime($values["ToDate"])); ?></td>
        <td align="center"><?=$values["Days"]?></td>
     <td><?=stripslashes($values["Comment"])?></td>
      <td align="center"> <? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
      <td align="center" class="<?=$stClass?>"><?=$values["Status"]?></td>
      <td  align="center" class="head1_inner" >
	  <a class="fancybox fancybox.iframe" href="vLeave.php?view=<?=$values['LeaveID']?>" ><?=$view?></a>

	 <?
	

	 if($values['Status'] == "Pending" && empty($arryApproval[0]['appID'])){
		echo '<a href="'.$EditUrl.'&Approve='.$values['LeaveID'].'" onclick="return confirmAction(this, \'Approve\', \''.APPROVE_LV_MSG.'\')" class="action_bt">Approve</a> ';			
		echo '<a href="'.$EditUrl.'&Reject='.$values['LeaveID'].'" onclick="return confirmAction(this, \'Reject\', \''.REJECT_LV_MSG.'\')" class="action_bt">Reject</a> ';
	 }

	if($values['Status'] == "Pending")echo $arryApproval[0]['Status'];
?>
	  
	  <!--a href="editLeaveApplied.php?edit=<?php echo $values['LeaveID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a-->
 

</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryLeave)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</td>
</tr>
</table>

</div>
<? } ?>
