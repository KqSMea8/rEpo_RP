<?php 

	if($Config['Junk']==0){
		/*********************/
		/*********************/
		
	   	list($NextID,$NextCatID) = $objProduct->NextPrevRow($_GET['view'],1);
		list($PrevID,$PrevCatID)  = $objProduct->NextPrevRow($_GET['view'],2);
		$NextPrevUrl = "vProduct.php?tab=".$_GET["tab"]."&curP=".$_GET["curP"];
		include("includes/html/box/next_prev_product.php");
		/*********************/
		/*********************/
	}	
	?>
<div><a href="viewProduct.php?curP=1" class="back">Back</a></div>

<div class="had"> Manage Products &raquo; <span>View Product</span></div>
   
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
