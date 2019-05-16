<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>





<div class="had">Employee Salary</div>
<? if(!empty($_SESSION['mess_salary'])) {echo '<div class="message" align="center">'.$_SESSION['mess_salary'].'</div>'; unset($_SESSION['mess_salary']); }?>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

	<tr>
	  <td>
<a href="EmpList.php?link=editSalary.php" class="fancybox add fancybox.iframe">Add <?=$ModuleName?></a>
<? if($num>0){?>

<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_salary.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

<? } ?>


<? if($_GET['sc']!='') {?>
<a href="viewSalary.php" class="grey_bt">View All</a>
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
	<? if($PayMethod=='H'){ ?>
        <td width="10%" class="head1" >Pay Rate</td>
	 <td width="20%" class="head1" >Hourly Rate</td>
        <? }else{ ?>
       <td width="12%"  class="head1" >CTC (<?=$Config['Currency']?>)</td>
       <td width="12%"  class="head1">GROSS (<?=$Config['Currency']?>)</td>
       <td width="12%"  class="head1">Net Salary (<?=$Config['Currency']?>)</td>
	<? } ?>
      <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arrySalary) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arrySalary as $key=>$values){
	$flag=!$flag;
	$Line++;

	if($values["PayRate"]=="" || $values["PayRate"]=="H"){
		$PayRate="Hourly";					
	}else{ 
		$PayRate="Salary";		
	}

  ?>
    <tr align="left" >
      <td>
	   
  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values["EmpCode"]?></strong></a> 
		<? echo '<br><strong>'.$values['UserName'].'<br>'.stripslashes($values['JobTitle']).' - '.stripslashes($values['Department']).'</strong>'; 
		?>
	 
	</td>
	<? if($PayMethod=='H'){ ?>
	<td> <?=$PayRate?> </td>
        <td> <?=$values["HourRate"]?> </td>
	  <? }else{ ?>
	<td> <? if($values["CTC"]>0) echo number_format($values["CTC"]); ?> </td>
	<td> <? if($values["Gross"]>0) echo number_format($values["Gross"]); ?> </td>
	<td> <? if($values["NetSalary"]>0) echo number_format($values["NetSalary"]); ?> </td>
	<? } ?>
      <td  align="center" class="head1_inner">
<a href="vSalary.php?view=<?=$values['salaryID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	  
<a href="editSalary.php?edit=<?=$values['salaryID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
 
<a href="editSalary.php?del_id=<?=$values['salaryID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arrySalary)>0){?>
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
