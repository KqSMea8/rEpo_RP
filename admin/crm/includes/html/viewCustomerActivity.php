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
		      <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?=sizeof($arryActivity)?>');" /></td>-->
			<td  class="head1" >Title</td>
			<td width="12%" class="head1"> Activity Type </td>
			<td width="10%" class="head1" >Priority</td>
			<td width="12%" class="head1" >Created By</td>
			<td width="15%" class="head1" > Start Date</td>
			<td width="15%" class="head1" > Close Date</td>
			<td width="8%"  align="center" class="head1" >Status</td>
	
		    </tr>

		<?php 
		if(is_array($arryActivity) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arryActivity as $key=>$values){
		$flag=!$flag;
		$class=($flag)?("oddbg"):("evenbg");
		$Line++;

		?>
		<tr align="left"  class="<?=$class?>">
		<!--<td ><input type="checkbox" name="activityID[]" id="activityID<?=$Line?>" value="<?=$values['activityID']?>" /></td>-->
      <!--td ><?=$values["activityID"]?></td-->
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
		<?php } // foreach end //?>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="12" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivity)>0){?>
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

