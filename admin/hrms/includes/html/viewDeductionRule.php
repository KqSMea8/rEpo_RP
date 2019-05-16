<div class="had"><?=$MainModuleName?></div>
<div class="message"><? if(!empty($_SESSION['mess_rule'])) {echo $_SESSION['mess_rule']; unset($_SESSION['mess_rule']); }?></div>

<TABLE WIDTH="100%" BORDER="0" align="center" CELLPADDING="0" CELLSPACING="0" >
<tr>
        <td>
	<a href="editDeductionRule.php" class="add">Create Rule</a>
	</td>
</tr>
	
<tr>
  <td  valign="top">


	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
<tr align="left" valign="middle" >
	<td class="head1">Rule Heading</td>
	<td width="8%" class="head1">Year</td>
	<td width="20%" class="head1">Filing Status</td>
	<td width="20%" class="head1">Tax Bracket</td>
	<td width="20%" class="head1">Deduction</td>
	<td width="8%" align="center" class="head1" >Status</td>
	<td width="5%" align="center" class="head1" >Action</td>
</tr>

  <?php 
$pagerLink=$objPager->getPager($arryDeductionRule,$RecordsPerPage,$_GET['curP']);
(count($arryDeductionRule)>0)?($arryDeductionRule=$objPager->getPageRecords()):("");

if(is_array($arryDeductionRule) && $num>0){
  	$flag=true;      
  	foreach($arryDeductionRule as $key=>$values){
	$flag=!$flag;

	$FinalBracket = '';
	if(!empty($values['bracketID'])){
		$FinalBracket = $values['PayrollPeriod'].'-'.$values['FilingStatus'];				
	}


  ?>
<tr align="left" valign="middle" >
	<td><?=stripslashes($values['Heading'])?></td>
	<td><?=stripslashes($values['Year'])?></td>
	<td><?=stripslashes($values['filingStatus'])?></td>
	<td><?=$FinalBracket?></td>
	<td><?=stripslashes($values['Deduction'])?></td>
    <td align="center">
      <? 
	 if($values['Status'] ==1){
		  $class = 'Active'; 
	 }else{
		  $class = 'InActive'; 
	 }
	
	 echo '<a href="editDeductionRule.php?active_id='.$values["ruleID"].'" class="'.$class.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$class.'</a>';
		
	   
	 ?>    </td>
    <td align="center" class="head1_inner" >

	<a href="editDeductionRule.php?edit=<?=$values['ruleID']?>"><?=$edit?></a>

	<a href="editDeductionRule.php?del_id=<?=$values['ruleID']?>" onClick="return confirmDialog(this, 'Rule')"><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="8" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryDeductionRule)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
