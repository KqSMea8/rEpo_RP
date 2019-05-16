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
        <td>
		
	
<a href="editComp.php" class="add">Add <?=$ModuleName?></a>

<? if($num>0){?>
	<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_comp.php?<?=$QueryString?>';" -->
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<? if($_GET['sc']!='') {?>
  <a href="viewComp.php" class="grey_bt">View All</a>
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
       <td class="head1" >Employee</td>
		<td width="15%" class="head1" >Working Date</td>
		<td width="15%"  class="head1">Working Hours</td>
		<td   class="head1">Apply Date</td>
		<td width="10%" align="center" class="head1" >Supervisor Approval</td>
		<td width="8%" align="center" class="head1" >Status</td>		
		<td width="8%" align="center" class="head1" >Approved</td>
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
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpCode"]?></a>
	  <br><?=stripslashes($values['UserName'])?> - <?=stripslashes($values["Department"])?>
	  
	  
	  
	  </td>
 

	<td> <? if($values["WorkingDate"]>0) echo date($Config['DateFormat'].", l", strtotime($values["WorkingDate"])); ?></td>
	<td><?=$values['Hours']?>  </td>
	 <td> <? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
	
	<td align="center">
	<? 
		 if($values['SupApproval'] == '1'){
			 $SupApprovalCls = 'green'; $SupApprovedStatus = 'Yes';
		 }else{
			 $SupApprovalCls = ''; $SupApprovedStatus = 'Pending';
		 }

		echo '<span class="'.$SupApprovalCls.'">'.$SupApprovedStatus.'</span>';
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
	  
<a href="vComp.php?view=<?=$values['CompID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>

<? if(empty($values['Approved']) && $values['SupApproval'] == '1'){?> 
<a href="editComp.php?edit=<?=$values['CompID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
<? } ?>

<a href="editComp.php?del_id=<?=$values['CompID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  



</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryComp)>0){?>
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