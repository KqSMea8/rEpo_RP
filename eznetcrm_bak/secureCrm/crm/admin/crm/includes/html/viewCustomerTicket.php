<script language="JavaScript1.2" type="text/javascript">
function ValidateFind(frm){	
	if(!ValidateForSelect(frm.Cid,"Customer")){
		return false;
	}
	ShowHideLoader('1','F');

}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 <tr>
	  <td  valign="top">

	<form action="" method="get" name="formSrch" onSubmit="return ValidateFind(this);">
	  <table id="search_table" cellpadding="0" cellsapcing="0" align="left">
	  <tr><td>Customer  : </td>
	  <td> 
			<select id="Cid" method="get" class="inputbox" name="Cid">
			   <option value="">--- Please Select ---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['Cid'];?>" <?php if($_GET['Cid'] == $customer['Cid']){echo "selected";}?>><?php echo $customer['FirstName']." ".$customer['LastName']; ?></option>
				<?php }?>
			</select>

	        
		  </td>
	 <td><input type="submit" value="Go" id="GoSubmitButton" class="button" name="search"></td>
	  </tr>
	  </table>
	</form>

	  </td>
      </tr>
	  <tr>
        <td align="right" valign="top">
		
	 <? if($num>0 && !empty($_GET['Cid'])){?>
            <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_so.php?<?=$QueryString?>';" -->

	    <? } ?>


		</td>
      </tr>
<?php if(!empty($_GET['Cid'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

		<tr align="left"  >
		      <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?=sizeof($arryTicket)?>');" /></td>-->
		      <!--td width="7%"  class="head1" >Ticket ID</td-->
		      <td width="25%"  class="head1" >Title</td>
		      <td width="16%" class="head1" > Assign To</td>	
		      <td width="12%"  align="center" class="head1" >Status</td>
		      <td width="12%" class="head1" align="center"> Created On</td>
	
		    </tr>

		<?php 
		if(is_array($arryTicket) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arryTicket as $key=>$values){
		$flag=!$flag;
		$class=($flag)?("oddbg"):("evenbg");
		$Line++;

		?>
		<tr align="left"  class="<?=$class?>">
		<!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>-->
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
		<?php } // foreach end //?>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="12" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTicket)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>
		</table>

		</div> 


		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		</form>
</td>
</tr>
<?php } ?>

</table>

