<div class="had">Manage Packages</div>
<!--<div class="message" align="center"><?php // if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); } ?></div>-->
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td align="right"><?php if ($_GET['key'] != '') { ?> <input
			type="button" class="view_button" name="view" value="View All"
			onclick="Javascript:window.location = 'package.php';" /> <?php } ?> <?php if ($_SESSION['AdminType'] == "admin") { ?>
		<a href="addPackage.php" class="add">Add Package</a>
		<div><a href="index.php" class="back">Back</a></div>
		<?php } ?></td>
	</tr>
	<tr>
		<td valign="top">

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?= $table_bg ?>>

			<tr align="left">
				<!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','id','<?= sizeof($arryPackage) ?>');" /></td>-->
				<td width="10%" class="head1">Name</td>
				<td width="8%" class="head1">Amount</td>
				<td width="10%" class="head1">Allowed Document</td>
				<td width="10%" class="head1">Allowed Page</td>
				<td width="10%" class="head1">Allowed Video</td>
				<td width="10%" class="head1">Allowed Video Size</td>
				<td width="10%" class="head1">Allowed User</td>
				<td width="10%" class="head1">Duration</td>
                                <td width="10%" class="head1">Allowed License</td>
                                <td width="15%" class="head1">Allowed Store</td>
				<td width="6%" align="center" class="head1">Status</td>
				<td width="6%" align="center" class="head1">Action</td>
			</tr>

			<?php
			$deletePackage = '<img src="' . $Config['Url'] . 'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

			if (is_array($arryPackage) && $num > 0) {
				$flag = true;
				$Line = 0;
				foreach ($arryPackage as $key => $values) {
					$values = get_object_vars($values);
					$flag = !$flag;
					#$bgcolor=($flag)?("#FDFBFB"):("");
					$Line++;
					?>
			<tr align="left" bgcolor="<?= $bgcolor ?>">
				<td><?= stripslashes($values["name"]) ?></td>
				<td>$<?= stripslashes($values["amount"]) ?></td>
				<td><?=  (!empty($values["allowedDoc"]))?$values["allowedDoc"]:'N/A' ?></td>
				<td><?=(!empty($values["allowedPage"]))?$values["allowedPage"]:'N/A'  ?></td>
				<td><?= (!empty($values["allowedVideo"]))?$values["allowedVideo"]:'N/A' ?></td>
				<td><?=(!empty($values["allowMaxvideoSize"]))?$values["allowMaxvideoSize"]:'N/A' ?></td>
				<td><?=(!empty($values["allowUser"]))?$values["allowUser"]:'N/A' ?></td>

                                <td><?= $values["timePeriod"] && $values['periodType']   ? $values['timePeriod'].' '.$values['periodType'] : 'N/A'?></td>
<?php 

 if ($values['storageType'] == 'MB') {
              $values['allowedStorage']=round($values['allowedStorage'] * 1024);
            } else if ($values['storageType'] == 'TB') {
              $values['allowedStorage']=round($values['allowedStorage'] /1024);  
            }
?>
				<td><?= (!empty($values["alloweLicense"]))?$values["alloweLicense"]:'N/A' ?></td>
  <td><?= $values['allowedStorage'] && $values['storageType']  ? $values['allowedStorage'] .' '.$values['storageType'] : 'N/A'?></td>
                             
				<td align="center"><?php
				if ($values['status'] == 1) {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}
				echo '<a href="package.php?active_id=' . $values["id"] . '&status=' . $values["status"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';?>
				</td>
				<td align="center" class="head1_inner"><a
					href="addPackage.php?edit=<?= $values['id'] ?>&curP=<?= $_GET['curP'] ?>"><?= $edit ?></a>
				<a
					href="package.php?del_id=<?php echo $values['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>"
					onclick="return confirm('Are you sure to delete this package?');"><?= $deletePackage ?></a>
				</td>
			</tr>
			<?php } // foreach end //  ?>
			<?php } else { ?>
			<tr align="center">
				<td colspan="6" class="no_record">No record found.</td>
			</tr>
			<?php } ?>
			<tr>
				<td height="20" colspan="6">Total Record(s) : &nbsp;<?php echo $num; ?><?php if (count($arryPackage) > 0) { ?>
				&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;}?></td>
			</tr>
		</table>

		  <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>" /> <input type="hidden"
			name="opt" id="opt" value="<?php echo $ModuleName; ?>" /></div>
		</form>
		</td>
	</tr>
</table>
