<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<div class="had">Manage Notifications</div>

<div class="message" align="center"><? if(!empty($_SESSION['mess_notification'])) {echo $_SESSION['mess_notification']; unset($_SESSION['mess_notification']); }?>
</div>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			align="center">
			<tr>
				<td width="61%" height="32">&nbsp;</td>
				<td width="39%" align="right"><a href="editNotification.php" class="add">Add
				Notification</a></td>
			</tr>

		</table>

		<table <?= $table_bg ?>>
			<tr align="left">
				<td weight="20" class="head1"  >Heading</td>
				<td width="15%" height="20" class="head1" align="center">Image</td>
				<td width="10%" height="20" class="head1" align="center">Date</td>
				<td width="10%" height="20" class="head1" align="center">Latest Updated</td>
				<td width="5%" height="20" class="head1" align="center">Status</td>
				<td width="5%" height="20" class="head1" align="center">Action</td>
			</tr>
			<?php

			if (is_array($arryNotification) && $num > 0) {

				foreach ($arryNotification as $key => $values) {
					?>
			<tr align="left" bgcolor="<?= $bgcolor ?>">
				<td align="left"><?=stripslashes($values['Heading'])?></td>
			<td>

			<?  
			unset($PreviewArray);
			$PreviewArray['Folder'] = $Config['NotificationDir'];
			$PreviewArray['FileName'] = $values['Image']; 	
			$PreviewArray['FileTitle'] = stripslashes($values['Heading']);
			$PreviewArray['Width'] = "75";
			$PreviewArray['Height'] = "75";
			$PreviewArray['Link'] = "1";
			echo PreviewImage($PreviewArray);

			?>

			</td>

				<td align="center"><?=stripslashes($values['Date'])?></td>
				
				<td align="center"><? 
				if($values['latest_update'] ==1){
			  $status = 'Yes';
				}else{
			  $status = 'No';
				} 
					echo $status;?>
             </td>
				<td align="center"><? 
				if($values['Status'] ==1){
			  $status = 'Active';
				}else{
			  $status = 'InActive';
				}

				echo '<a href="editNotification.php?active_id='.$values["NotificationId"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';

				?></td>
				<td align="center" class="head1_inner">
				<a href="vNotification.php?view=<?=$values['NotificationId']?>" class="fancybox fancybox.iframe"><?=$view?></a>
					<a
					href="editNotification.php?edit=<?php echo $values['NotificationId'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

				<a
					href="editNotification.php?del_id=<?php echo $values['NotificationId'];?>&curP=<?php echo $_GET['curP'];?>"
					onClick="return confirmDialog(this, 'Notification')"><?=$delete?></a></td>
			</tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryNotification)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

		</td>
	</tr>
</table>



