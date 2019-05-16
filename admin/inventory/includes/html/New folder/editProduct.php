<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<!--<script type="text/javascript" src="js/product.js"></script>-->
<a href="viewProduct.php?curP=<?=$_GET['curP']?>" class="back">Back</a>

<div class="had">
    Manage Items <?= $MainParentCategory ?> 
    &raquo;
    <span><?
    $MemberTitle = (!empty($_GET['edit'])) ? ("Edit ") : ("Add ");
    echo $MemberTitle . $ModuleName;
    

    ?></span>

</div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<? 
       
	if (!empty($_GET['edit'])) {
           
		include("includes/html/box/item_edit.php");
	}else{
             
		include("includes/html/box/item_form.php");
	}
	
	
	?>

	
	</td>
    </tr>
 
</table>