
<table border="0" cellspacing="0" cellpadding="0" style="margin-left:15px;">
	
<tr>
	<td><a href="shops.php?cat=<?=$TopCatID?>"><img src="images/view_shops.jpg" alt="Shop" border="0" /></a></td>
  </tr>
  <tr>
	<td height="30"></td>
  </tr>	
  <tr>
   <? 
   if($ShowRecommended == 1){
   		include("includes/html/box/recommended_right.php"); 
   }else{
  	 	include("includes/html/box/featured_right.php"); 
   }
   ?>
  </tr>
</table>