

<script>
function getGategoryByids(){ 
ShowHideLoader('1','L');
	var dep = $("#Category").val();
	   
	  window.parent.location.href = "?CategoryID="+dep;
	
}
</script>
<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<div class="had">Manage News</div>
<div class="drop-dep">
	 <select name="Category" class="inputbox" method="get" id="Category" onchange="getGategoryByids();">
	  <option value=""> --- ALL ---</option>
			 <?php foreach($arrayCatName as $CatNamevalues) { ?> 
			 <option value="<?=$CatNamevalues['CategoryID']?>" <? if($CatNamevalues['CategoryID']==$_GET['CategoryID']){ echo "selected='selected'";}?>><?php echo stripslashes($CatNamevalues['NewsCategoryName']);?> </option>  
		     <?php } ?>
    
   </select>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_news'])) {echo $_SESSION['mess_news']; unset($_SESSION['mess_news']); }?>
</div>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td>
		<div class="message"><? if (!empty($_SESSION['mess_news'])) {
			echo stripslashes($_SESSION['mess_news']);
			unset($_SESSION['mess_news']);
		} ?></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			align="center">
			<tr>
				<td width="61%" height="32">&nbsp;</td>
				<td width="39%" align="right"><a href="editNews.php" class="add">Add
				News</a></td>
			</tr>

		</table>

		<table <?= $table_bg ?>>
			<tr align="left">
				<td weight="20" class="head1"  >Heading</td>
				<td width="15%" height="20" class="head1" align="center">Category</td>
				<td width="10%" height="20" class="head1" align="center">Date</td>
				<td width="10%" height="20" class="head1" align="center">Image</td>
				<td width="5%" height="20" class="head1" align="center">Status</td>
				<td width="5%" height="20" class="head1" align="center">Action</td>
			</tr>
			<?php

			if (is_array($arryNews) && $num > 0) {

				foreach ($arryNews as $key => $values) {
					?>
			<tr align="left" bgcolor="<?= $bgcolor ?>">
				<td align="left"><?=stripslashes($values['Heading'])?></td>
				<td align="center"><?=stripslashes($values['NewsCategoryName'])?></td>
				<td align="center"><?=stripslashes($values['Date'])?></td>
				<td height="26" align="center"> 

<? 

	$PreviewArray['Folder'] = $Config['NewsDir'];
	$PreviewArray['FileName'] = $values['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($values['Heading']);
	$PreviewArray['Width'] = "75";
	$PreviewArray['Height'] = "75";
	$PreviewArray['Link'] = "1";
	$PreviewArray['NoImage'] = "../images/no.jpg";
	echo PreviewImage($PreviewArray);

 
?>

</td>
				<td align="center"><? 
				if($values['Status'] ==1){
			  $status = 'Active';
				}else{
			  $status = 'InActive';
				}

				echo '<a href="editNews.php?active_id='.$values["NewsID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';

				?></td>
				<td align="center" class="head1_inner"> 
				<a
					href="editNews.php?edit=<?php echo $values['NewsID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

				<a
					href="editNews.php?del_id=<?php echo $values['NewsID'];?>&curP=<?php echo $_GET['curP'];?>"
					onClick="return confirmDialog(this, 'News')"><?=$delete?></a></td>
			</tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryNews)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

		</td>
	</tr>
</table>



