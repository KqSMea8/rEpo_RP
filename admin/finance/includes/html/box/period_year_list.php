<?
$arryPeriodYear = $objReport->getPeriodYear('');   

?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="borderall" >
<tr>
      <td  valign="top" class="had">Period Year List</td>  
  </tr>
 
<tr>
      <td>
<table <?=$table_bg?>>   
    <tr align="left" >
		<td width="20%" align="center" class="head1">Year</td>
		<td width="20%" align="center" class="head1">Status</td>
     </tr>
   
  <?php if(sizeof($arryPeriodYear)>0){
	  	$flag=true;
		$Line=0;
  	foreach($arryPeriodYear as $key=>$values){
		$flag=!$flag;		 
		$Line++;    
	
  ?>		
    <tr align="left" >       
      <td align="center"><?=$values['PeriodYear']?></td>
        <td align="center">

<?php
	if($values['PeriodStatus'] == 'Closed') {
		$statusCls = 'InActive';
		$action = 'open';
		echo '<a href="periodEndSetting.php?OpenYear='.$values["PeriodYear"].'" class="'.$statusCls.'" onclick="return confirmAction(this,\'Year '.ucfirst($action).'\',\'Are you sure you want to '.$action.' '.$values['PeriodYear'].'?\' )">' . $values['PeriodStatus'] . '</a>';
	} else {
		$statusCls = 'Active';
		$action = 'close';
		#echo '<span class="'.$statusCls.'" >'.$values['PeriodStatus'].'</a>';
		echo '<a href="periodEndSetting.php?CloseYear='.$values["PeriodYear"].'" class="'.$statusCls.'" onclick="return confirmAction(this,\'Year '.ucfirst($action).'\',\'Are you sure you want to '.$action.' '.$values['PeriodYear'].'?\' )">' . $values['PeriodStatus'] . '</a>';
	}



?>

</td>
      
    </tr>
	

	
        <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="2" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="2"  id="td_pager">Total Record(s) : &nbsp;<?=sizeof($arryPeriodYear)?>   </td>
  </tr>
  </table>

</td>  
  </tr>
</table>
