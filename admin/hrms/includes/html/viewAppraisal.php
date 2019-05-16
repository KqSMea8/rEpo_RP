<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>

	

<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_appraisal'])) {echo '<div class="message" align="center">'.$_SESSION['mess_appraisal'].'</div>'; unset($_SESSION['mess_appraisal']); }?>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

	<tr>
        <td>
		

<a href="editAppraisal.php" class="add">Add <?=$ModuleName?></a>

	 <? if($num>0){?>

<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_appraisal.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

<? } ?>


 <? if($_GET['sc']!='') {?>
	  <a href="viewAppraisal.php" class="grey_bt">View All</a>
	<? }
 
 
$viewSal = '<img src="'.$Config['Url'].'admin/images/view.gif" border="0"  onMouseover="ddrivetip(\'<center>View Salary</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';

 
 
 ?>

		</td>
      </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td width="10%" class="head1" >Emp Code</td>
       <td width="15%" class="head1" >Employee Name</td>
        <td width="10%" class="head1" >Department</td>
       <td width="10%"  class="head1" >CTC (<?=$Config['Currency']?>)</td>
        <td width="10%"  class="head1" >GROSS (<?=$Config['Currency']?>)</td>
      <td width="11%"  class="head1">Net Salary (<?=$Config['Currency']?>)</td>
      <td class="head1" >Appraisal From</td>
       <td width="15%"  class="head1"> Appraisal Amount (<?=$Config['Currency']?>)</td>
      <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAppraisal) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryAppraisal as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><?=$values["EmpCode"]?></td>
      <td>
	   
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>	 
	</td>
	<td><?=stripslashes($values["Department"])?></td>
	<td><? if($values["CTC"]>0) echo number_format($values["CTC"]); ?></td>
	<td><? if($values["Gross"]>0) echo number_format($values["Gross"]); ?></td>
	<td><? if($values["NetSalary"]>0) echo number_format($values["NetSalary"]); ?></td>
	<td><? if($values["FromDate"]>0) echo date($Config['DateFormat'], strtotime($values["FromDate"])); ?></td>
	<td><? if($values["AppraisalAmount"]>0) echo number_format($values["AppraisalAmount"]); ?></td>

      <td  align="center" class="head1_inner">
	  
<a class="fancybox fancybox.iframe" href="vSalary.php?emp=<?=$values['EmpID']?>&pop=1" ><?=$viewSal?></a>
 
<a href="editAppraisal.php?del_id=<?=$values['appraisalID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryAppraisal)>0){?>
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