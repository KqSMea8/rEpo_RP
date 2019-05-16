<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>








<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_entitlement'])) {echo $_SESSION['mess_entitlement']; unset($_SESSION['mess_entitlement']); }?></div>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" >

	<a href="editEntitlement.php" class="add">Add <?=$ModuleName?></a>
		
<? if($num>0){?>

	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_ent.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

<? } ?>


<? if($_GET['key']!='') {?>
	<a href="viewEntitlement.php" class="grey_bt">View All</a>
<? }?>
	
		
		</td>
 </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >

 <? if($num>0 && $DeleteLabel==1){ ?>
 <br>
<input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Delete" onclick="javascript: return ValidateMultiple('entitlement record','delete','NumField','EntID');">
<br>
<? } ?>

<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
    <tr align="left"  >
		<td  class="head1" >Employee</td>
		<td width="15%"  class="head1" >Leave Type</td>
		<!--td width="15%"  class="head1" align="center">Valid From</td>
		<td width="15%"  class="head1" align="center">Valid To</td-->
		<td width="8%"  class="head1" align="center">Days</td>
		<td width="5%"  align="center"  class="head1 head1_action" >Edit</td>
       <td width="4%"  align="center" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','EntID','<?=sizeof($arryEntitlement)?>');" />  </td>
    </tr>
   
    <?php 
  if(is_array($arryEntitlement) && $num>0){
	$flag=true;
	$Line=0;
	$NewEmpID=0;
	foreach($arryEntitlement as $key=>$values){
	$flag=!$flag;
	$Line++;

	$bgclass = (!$flag)?("oddbg"):("evenbg");
  ?>


	<? if($NewEmpID != $values['EmpID']){ ?>
		 <tr class="evenbg">
		  <td  colspan="7" >
		 
		  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values["EmpCode"]?></strong></a> 
		<? echo '<br><strong>'.$values['UserName'].'<br>'.stripslashes($values['JobTitle']).' - '.stripslashes($values['Department']).'</strong>'; 
		echo '<br><strong>Job Type: '.stripslashes($values['JobType']).'</strong>';
		?>
	
		  </td>
		</tr>
		<? } ?>



    <tr align="left" class="<?=$bgclass?>">
      <td>&nbsp;</td>
      <td><?=$values["LeaveType"]?></td>
      <!--td align="center"> <? if($values["LeaveStart"]>0) echo date($Config['DateFormat'], strtotime($values["LeaveStart"])); ?></td>
      <td align="center"> <? if($values["LeaveEnd"]>0) echo date($Config['DateFormat'], strtotime($values["LeaveEnd"])); ?></td-->
      <td align="center"><?=$values["Days"]?></td>
      <td  align="center" class="head1_inner" ><a href="editEntitlement.php?edit=<?php echo $values['EntID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a> 
	  </td>

	  <td align="center" class="head1_inner"><!--a href="editEntitlement.php?del_id=<?php echo $values['EntID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a-->  

	   <input type="checkbox" name="EntID[]" id="EntID<?=$Line?>" value="<?=$values['EntID']?>" />

	  </td>
    </tr>
    <?php
	 $NewEmpID = $values['EmpID'];
	} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="7" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEntitlement)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>


 
</td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">


</form>

</td>
</tr>
</table>

</div>
