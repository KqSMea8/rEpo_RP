<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<div><a href="viewProduct.php?curP=1" class="back">Back</a></div>

<div class="had">
    Manage Products &raquo; <span>Vew Product</span>
    
   

</div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<?php  include("includes/html/box/product_view.php");?>

	
	</td>
    </tr>
 
</table>