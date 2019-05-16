

<?php  if(!empty($_SESSION['msg'])){   ?>
<div style="color:red"> <?php echo $_SESSION['msg']; ?></div>
<?php }?>
<div class="had">Manage Company</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_user']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td align="right"><? if($_GET['key']!='') {?> <input type="button" 	class="view_button" name="view" value="View All"
			onclick="Javascript:window.location='company.php';" /> <? }?> <? if($_SESSION['AdminType']=="admin"){?>
		<a href="addCompany.php" class="add">Add Company</a> 
<a href="index.php" class="back">Back</a><? }?></td>
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
				<td class="head1" width="8%">Email</td>
				<td width="15%" class="head1">Expire Date</td>
                                <td width="15%" class="head1">No Of User</td>
				<td width="8%" class="head1">Created date</td>
				<!--    <td width="15%" class="head1" >Expiry Date</td>
     <td width="12%" class="head1" >Display Name</td>
      <td width="10%" class="head1" >Image</td> -->
				<td width="6%" align="center" class="head1">Status</td>
				<td width="6%" align="center" class="head1">Action</td>
			</tr>

			<?php

			$deleteUser = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

			$changepwd = '<img src="'.$Config['Url'].'admin/images/email.png" border="0"  onMouseover="ddrivetip(\'<center>Re-Send Activation Email</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

			//if(is_array($arryUser) && $num>0)
if(is_array($arryUser) ){
				$flag=true;
				$Line=0;
				foreach($arryUser as $key=>$values){
					$values     = get_object_vars($values);
//echo '<pre>';print_r($values);
					$flag=!$flag;
					#$bgcolor=($flag)?("#FDFBFB"):("");
					$Line++;
					?>
			<tr align="left" bgcolor="<?=$bgcolor?>">
				<!--<td ><input type="checkbox" name="CmpID[]" id="CmpID<?=$Line?>" value="<?=$values['CmpID']?>" /></td>-->

				<td height="50"><strong><?=stripslashes($values["name"])?></strong></td>
				<td><?  echo '<a href="mailto:'.$values['email'].'">'.$values['email'].'</a>'; ?></td>
				<td><?=$values["expire_date"]?></td>
                                 <td><?=$values["allow_users"]?></td>
				<td><?=$values["created_date"]?></td>
				<td align="center"><? 
				if($values['status'] =='Active'){
			  $status = 'Active';
				}else{
			  $status = 'InActive';
				}
	        echo '<a href="addCompany.php?active_id='.$values["cmp_id"].'&status='.$values["status"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';

	   ?></td>
				<td align="center" class="head1_inner"><a
					href="addCompany.php?edit=<?=$values['cmp_id']?>&curP=<?=$_GET['curP']?>" title="edit company details"><?=$edit?></a>
				<!--<a
					href="company.php?del_id=<?php echo $values['cmp_id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>"
					onclick="return confDel('<?= $ModuleName ?>')" title="delete company"><?= $deleteUser ?></a>-->
					
					<a href="changePassword.php?changepwd_id=<?php echo $values['cmp_id']; ?>" title="change password"><?= $changepwd ?></a>
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
                                    &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pageslink;}?>
                                </td>
			</tr>
		</table>

		</div>
		<? if(sizeof($arryUser)){ ?>
		<table width="100%" align="center" cellpadding="3" cellspacing="0"
			style="display: none">
			<tr align="center">
				<td height="30" align="left"><input type="button"
					name="DeleteButton" class="button" value="Delete"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','userID','addCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
				<input type="button" name="ActiveButton" class="button"
					value="Active"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','userID','addCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
				<input type="button" name="InActiveButton" class="button"
					value="InActive"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','userID','addCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
			</tr>
		</table>
		<? } ?> <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>
