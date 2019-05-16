<? 
if($_GET['CustID']>0){
	$arryActivity=$objActivity->GetActivityList($_GET);	
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arryActivity)>0){ ?>
<tr align="left"  >
	<td  class="head1" >Title</td>
	<td width="12%" class="head1"> Activity Type</td>
	<td width="10%" class="head1">Priority</td>
	<td width="12%" class="head1">Created By</td>
	<td width="15%" class="head1">Start Date</td>
	<td width="15%" class="head1">Close Date</td>
	<td width="8%"  align="center" class="head1">Status</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arryActivity as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
 <td height="22" > 
<?php if($values['activityType']=="Task"){$mode="Task";	}else{$mode="Event";}?>
    <a href="vActivity.php?view=<?php echo $values['activityID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=Activity&mode=<?=$mode?>" target="_blank"><?=stripslashes($values["subject"])?></a>

		       </td>
		   <td><?=$values['activityType']?></td>
      <td><?=(!empty($values['priority']))?(stripslashes($values['priority'])):(NOT_SPECIFIED)?> </td>
	  <td>
		<?php if($values['created_by'] == 'admin'){

$created_by ="Admin";
?>

<?=$created_by?> 

<?
		} else{

		$created_by =$values['created'];?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values["created_id"]?>"><?=$created_by?> </a>
<?
		}
		?>
		
		
	  </td>
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." H:i A" , strtotime($stdate));?>
      </td>
 <td>
      <?php  
	   $ctdate= $values["closeDate"]." ".$values["closeTime"];
	 echo date($Config['DateFormat']." H:i A" , strtotime($ctdate));?>
      </td>
       
    <td align="center"><? $status = $values['status']; echo $status;?></td>   


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
