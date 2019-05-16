<script class="jsbin" src="js/jquery.min.js"></script>
<script class="jsbin" src="js/jquery-ui.min.js"></script>

<div class="had">Manage Banner</div>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_banner'])) {echo $_SESSION['mess_banner']; unset($_SESSION['mess_banner']); }?>
</div><TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td align="right">
                   
		<a href="addBanner.php" class="add">Add Banner</a>
                 <div><a href="index.php" class="back">Back</a></div></td>
	</tr>
	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

			<tr align="left">
				<!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?=sizeof($arryBanner)?>');" /></td>-->
				<td width="15%" class="head1">S.No</td>
                                <td width="15%" class="head1">image</td>
                                
				<td width="6%" align="center" class="head1">Status</td>
				<td width="6%" align="center" class="head1">Action</td>
			</tr>

			<?php

			$deleteUser = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';


			if(is_array($arryBanner) && $num>0){
				$flag=true;
				$Line=0;
$start=0;
				foreach($arryBanner as $key=>$values){
					$values     = get_object_vars($values);
					$flag=!$flag;
					#$bgcolor=($flag)?("#FDFBFB"):("");
					$Line++;
					?>
			<tr align="left" bgcolor="<?=$bgcolor?>">
				 
				<td height="50"><strong><?=stripslashes(++$start)?></strong></td>
				<td>
                               <?php     echo '<img src="../../upload/ecomupload/37/banner_image/'.$values['image'].'" border=0 width="80px;" >';?>

<!--				<img src="http://localhost/erp/superadmin/ecommerce/upload/<?php echo $values["image"] ?>" width="100" height="50" img id="img" >-->
    <img id="img"/></td>
				
				<td align="center"><? 
				if($values['status'] ==1){
			  $status = 'Active';
				}else{
			  $status = 'InActive';
				}
	        echo '<a href="addBanner.php?active_id='.$values["id"].'&status='.$values["status"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';

	   ?></td>
				<td align="center" class="head1_inner"><a
					href="addBanner.php?edit=<?=$values['id']?>&curP=<?=$_GET['curP']?>" title="edit company details"><?=$edit?></a>
				<a
					href="banner.php?del_id=<?php echo $values['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>"
					onclick = "return confirm_delete();" title="delete company" ><?= $deleteUser ?></a>
					
					
				</td>
			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="9" class="no_record">No record found.</td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="9">Total Record(s) : &nbsp;<?php echo $num;?> <?php if(count($arryBanner)>0){?>
                                    &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pageslink;}?>
                                </td>
			</tr>
		</table>

		</div>
		  <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>
<script type="text/javascript">
function confirm_delete()
{
	return confirm("Are You Sure Delete User Account");
}
</script>
<script>
function readURL(input) 
{
        if (input.files && input.files[0]) 
		{
            var reader = new FileReader();

            reader.onload = function (e) 
			{
                $('#img')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
}
</script>
