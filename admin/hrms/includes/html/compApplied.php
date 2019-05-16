<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_comp'])) {echo '<div class="message" align="center">'.$_SESSION['mess_comp'].'</div>'; unset($_SESSION['mess_comp']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">


 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
		<td width="20%" class="head1" >Working Date</td>
		<td width="15%"  class="head1">Working Hours</td>
		<td   class="head1">Apply Date</td>
		<td width="18%" align="center" class="head1" >Supervisor Approval</td>
		<td width="10%" align="center" class="head1" >Status</td>
		<td width="10%" align="center" class="head1" >Approved</td>
		<td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryComp) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryComp as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >
	 <td> <? if($values["WorkingDate"]>0) echo date($Config['DateFormat'].", l", strtotime($values["WorkingDate"])); ?></td>
	<td><?=$values['Hours']?>  </td>
	 <td> <? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
	<td align="center">
	<? 
		 if($values['SupApproval'] == '1'){
			echo '<span class="green">Yes</span>';
		 }else{
			echo '<a href="compApplied.php?approve_id='.$values["CompID"].'&curP='.$_GET["curP"].'" class="InActive"  onclick="return confirmAction(this, \''.$ModuleName.'\', \''.COMP_APPROVE.'\')">Pending</a>';
		 }

		?>	
	</td>
	 <td align="center">	 
		<? 
		 if($values['Compensated'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($values['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		?>	 
	 </td>

	 <td align="center">	 
		<? 
		 if($values['Approved'] == '1'){
			 $ApprovedCls = 'green'; $ApprovedStatus = 'Yes';
		 }else{
			 $ApprovedCls = 'red'; $ApprovedStatus = 'No';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$ApprovedStatus.'</span>';
		?>	 
	 </td>

      <td  align="center" class="head1_inner">
	  
<a class="fancybox fancybox.iframe" href="vComp.php?view=<?=$values['CompID']?>&curP=<?=$_GET['curP']?>&pop=1" ><?=$view?></a>


</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryComp)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
  </td>
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