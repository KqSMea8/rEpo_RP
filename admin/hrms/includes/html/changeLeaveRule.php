<script language="JavaScript1.2" type="text/javascript">
function ProcessPage(){	
	$("#prv_msg_div").show();
	$("#had").hide();
	$("#message").hide();
	$("#preview_div").hide();
}
</script>






<div class="had">Edit Leave Custom Rule </div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_rule'])) {echo $_SESSION['mess_rule']; unset($_SESSION['mess_rule']); }?></div>


<div id="ListingRecords">

<br><strong>Job Type : <?=stripslashes($arryEmployee[0]['JobType'])?></strong>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">


 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" >



<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
    <tr align="left"  >
		<td  class="head1" >Job Type</td>
		<td width="45%"  class="head1" >Rule Heading</td>
		<!--td width="20%"  class="head1" >Rule Column</td>
		<td width="20%"  class="head1" >Rule Operator</td>
		<td width="10%"  class="head1" >Value</td-->
		<td width="15%" align="center" class="head1" >Apply</td>
	
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

	 if($objLeave->isCustomRuleDenied($values["RuleID"],$_GET["emp"])){
		 $status = 'Not Applied'; $statusCls = 'InActive';
	 }else{
		 $status = 'Applied'; $statusCls = 'Active';
	 }	 

	echo '<a href="changeLeaveRule.php?rule_id='.$values["RuleID"].'&curP='.$_GET["curP"].'&emp='.$_GET["emp"].'" class="'.$statusCls.'" onclick="Javascript:ProcessPage();">'.$status.'</a>';
	   
	 ?>    </td>



	 
    </tr>
    <?php
	 $NewEmpID = $values['EmpID'];
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
