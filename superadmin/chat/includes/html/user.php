
<?php /* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * Description: For company user form  user.php
 */ 
?> 
<div class="had">Manage Users</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td align="right"><? if($_GET['key']!='') {?> <input type="button"
			class="view_button" name="view" value="View All"
			onclick="Javascript:window.location='viewCompany.php';" /> <? }?> <? if($_SESSION['AdminType']=="admin"){?>
		<a href="addUser.php" class="add">Add User</a> <? }?></td>
	</tr>
	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

			<tr align="left">
				<!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?=sizeof($arryCompany)?>');" /></td>-->
				<td width="15%" class="head1">UserName</td>
				<td width="15%" class="head1">UserContacts</td>
				<td class="head1" width="8%">Email</td>
				<td width="8%" class="head1">Package</td>
				<!--    <td width="15%" class="head1" >Expiry Date</td>
     <td width="12%" class="head1" >Display Name</td>
      <td width="10%" class="head1" >Image</td> -->
				<td width="6%" align="center" class="head1">Status</td>
				<td width="6%" align="center" class="head1">Action</td>
			</tr>

			<?php

			$deleteUser = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

			//$resend = '<img src="'.$Config['Url'].'admin/images/email.png" border="0"  onMouseover="ddrivetip(\'<center>Re-Send Activation Email</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

			if(is_array($arryUser) && $num>0){
				$flag=true;
				$Line=0;
				foreach($arryUser as $key=>$values){
					$values     = get_object_vars($values);
					$flag=!$flag;
					#$bgcolor=($flag)?("#FDFBFB"):("");
					$Line++;

					//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }


					//$AdminUrl = $Config['Url'].$values["DisplayName"].'/'.$Config['AdminFolder']."/";


					?>
			<tr align="left" bgcolor="<?=$bgcolor?>">
				<!--<td ><input type="checkbox" name="CmpID[]" id="CmpID<?=$Line?>" value="<?=$values['CmpID']?>" /></td>-->

				<td height="50"><strong><?=stripslashes($values["userDispalyname"])?></strong></td>
				<td><?=$values["userContacts"]?></td>
				<td><?  echo '<a href="mailto:'.$values['userEmail'].'">'.$values['userEmail'].'</a>'; ?></td>
				<td><?=$values["userPackageId"]?></td>
				<!--  <td><?=ucfirst($values["PaymentPlan"])?></td>   
     <td ><?  if($values['ExpiryDate']>0){
		echo date("j F, Y",strtotime($values['ExpiryDate']));
	      }
	      
	?></td>-->
				<td align="center"><? 
				if($values['status'] ==1){
			  $status = 'Active';
				}else{
			  $status = 'InActive';
				}
	   echo '<a href="addUser.php?active_id='.$values["userID"].'&status='.$values["status"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';

	   ?></td>
				<td align="center" class="head1_inner"><a
					href="addUser.php?edit=<?=$values['userID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>
				<a
					href="user.php?del_id=<?php echo $values['userID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>"
					onclick="return confDel('<?= $ModuleName ?>')"><?= $deleteUser ?></a>
				</td>
			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="9" class="no_record">No record found.</td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="9">Total Record(s) : &nbsp;<?php echo $num;?> <?php if(count($arryUser)>0){?>
				&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
				}?></td>
			</tr>
		</table>

		</div>
		<? if(sizeof($arryCompany)){ ?>
		<table width="100%" align="center" cellpadding="3" cellspacing="0"
			style="display: none">
			<tr align="center">
				<td height="30" align="left"><input type="button"
					name="DeleteButton" class="button" value="Delete"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
				<input type="button" name="ActiveButton" class="button"
					value="Active"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
				<input type="button" name="InActiveButton" class="button"
					value="InActive"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
			</tr>
		</table>
		<? } ?> <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>
