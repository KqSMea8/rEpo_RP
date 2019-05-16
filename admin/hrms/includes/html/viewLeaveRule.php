<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>








<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_rule'])) {echo $_SESSION['mess_rule']; unset($_SESSION['mess_rule']); }?></div>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" >

	<a href="editLeaveRule.php" class="add">Add <?=$ModuleName?></a>
		
<? if($num>0){?>

	
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

<? } ?>


<? if($_GET['key']!='') {?>
	<a href="viewLeaveRule.php" class="grey_bt">View All</a>
<? }?>
	
		
		</td>
 </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >



<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
    <tr align="left"  >
		<td  class="head1" >Job Type</td>
		<td width="40%"  class="head1" >Rule Heading</td>
		<!--td width="15%"  class="head1" >Rule Column</td>
		<td width="15%"  class="head1" >Rule Operator</td>
		<td width="15%"  class="head1" >Value</td-->
		<td width="10%" align="center" class="head1" >Status</td>
		<td width="5%"  align="center"  class="head1 head1_action" >Action</td>
     </tr>
   
    <?php 

  if(is_array($arryCustomRule) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryCustomRule as $key=>$values){
	$flag=!$flag;
	$Line++;

	$bgclass = (!$flag)?("oddbg"):("evenbg");

	$RuleOnStr = getArrayName(stripslashes($values["RuleOn"]),$RuleOn);
	$RuleOppStr = getArrayName(stripslashes($values["RuleOpp"]),$RuleOpp);
  ?>


    <tr align="left" class="<?=$bgclass?>">
	<td><?=stripslashes($values["JobType"])?></td>
	<td><?=stripslashes($values["Heading"])?></td>
	<!--td><?=$RuleOnStr?></td>
	<td><?=$RuleOppStr?></td>
	<td><?=stripslashes($values["RuleValue"]).' '.$values["RuleUnit"]?></td-->

	<td align="center">
      <? 
	 if($values['Status'] ==1){
		  $status = 'Active';
	 }else{
		  $status = 'InActive';
	 }	 

	echo '<a href="editLeaveRule.php?active_id='.$values["RuleID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	   
	 ?>    </td>


      <td  align="center" class="head1_inner" ><a href="editLeaveRule.php?edit=<?php echo $values['RuleID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a> 

<a href="editLeaveRule.php?del_id=<?php echo $values['RuleID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 

	  </td>

	 
    </tr>
    <?php
	 
	} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="7" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCustomRule)>0){?>
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
