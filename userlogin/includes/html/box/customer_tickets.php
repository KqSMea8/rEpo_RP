<? 
if($_GET['CustID']>0){
	$arryTicket=$objLead->ListTicket($_GET);
	$vTicket="vTicket.php?module=Ticket&view=";
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arryTicket)>0){ ?>
<tr align="left"  >
	<!--td width="7%"  class="head1" >Ticket ID</td-->
	<td  class="head1" >Title</td>
	<td width="30%" class="head1" > Assign To</td>	
	<td width="15%"  align="center" class="head1" >Status</td>
	<td width="15%" class="head1" align="center">Created On</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arryTicket as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
      <!--td ><?=$values["TicketID"]?></td-->
		<td > 
		<a href="<? echo $vTicket.$values['TicketID']?>&curP=<?php echo $_GET['curP'];?>&tab=Information" target="_blank"><?=stripslashes($values['title'])?></a>	       </td>


		<td>
		<? 
		if($values['AssignType'] == 'Group') { 

		$arryGrp = $objGroup->getGroup($values['GroupID'],1);
		$AssignName = $arryGrp[0]['group_name'];
		?>

		<?php
		if($values['AssignedTo']!=''){
		$arryAssignee = $objLead->GetAssigneeUser($values['AssignedTo']);
		echo $AssignName;
		?>
		<div> 
		<? foreach($arryAssignee as $values2) {?>
		<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values2['EmpID']?>" ><?=$values2['UserName']?></a>,
		<? }
		}
		} else if($values['AssignType'] == 'User') {

		if($values['AssignedTo']!=''){
		$arryAssignee2 = $objLead->GetAssigneeUser($values['AssignedTo']);
		$assignee = $values['AssignedTo'];
		}
		$AssignName = $arryAssignee2[0]['UserName'];?>
		<? foreach($arryAssignee2 as $values3) {?>
		<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values3['EmpID']?>" ><?=$values3['UserName']?></a>,
		<? }} else{
		echo "Not Specified";
		}?>


		</td>

		<td align="center"><? echo $values['Status'];?></td>

		<td align="center"> <? echo date($Config['DateFormat']  , strtotime($values["ticketDate"]));?></td>
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
