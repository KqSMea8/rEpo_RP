<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_shipment_profile'])) {echo $_SESSION['mess_shipment_profile']; unset($_SESSION['mess_shipment_profile']); }?></div>

<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	?>

<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td align="right" height="40" valign="bottom"><a class="add"
			href="editShipmentProfile.php">Add Shipment Profile</a></td>
	</tr>

	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

			<tr align="left">

				<td width="10%" class="head1" align="center">Nickname</td>
				<td width="13%" class="head1" align="center">Company</td>
				<td width="10%" class="head1" align="center">Contact Name</td>
				<td width="13%" class="head1" align="center">Service Type</td>
				<td width="6%" class="head1" align="center">Weight</td>
				<td width="11%" align="center" class="head1">PackagingType</td>
				<td width="26%" align="center" class="head1">PackageDiscriptions</td>
				<td width="7%" align="center" class="head1 head1_action">Action</td>
			</tr>

			<?php
			if(is_array($arryReturn) && $num>0){
				$flag=true;
				$Line=0;
				foreach($arryReturn as $key=>$values){
					$flag=!$flag;
					$Line++;

					?>
			<tr align="left">

				<td align="center"><?=$values["Nickname"]?></td>
				<td align="center"><?=$values["Company"]?></td>
				<td align="center"><?=$values["ContactName"]?></td>
				<td align="center"><?=$values["ServiceType"]?></td>
				<td align="center"><?=$values["Weight"]?> <?=$values["wtUnit"]?></td>
				<td align="center"><?=$values["PackagingType"]?></td>
				<td align="center"><?=substr($values["PackageDiscriptions"], 0, 20);?></td>

				<td align="center" class="head1_inner"><a
					href="editShipmentProfile.php?edit=<?=$values['profileID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>
				<a
					href="editShipmentProfile.php?del_id=<?=$values['profileID']?>&curP=<?=$_GET['curP']?>"
					onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>
				</td>
			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="9" class="no_record"><?=NO_RECORD?></td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>
				<?php if(count($arryReturn)>0){?> &nbsp;&nbsp;&nbsp; Page(s) :&nbsp;
				<?php echo $pagerLink;
				}?></td>
			</tr>
		</table>

		</div>
		<? if(sizeof($arryReturn)){ ?>
		 
		<? } ?> <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>


		<? } ?>
