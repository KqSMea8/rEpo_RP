
<a class="back" href="<?=$RedirectURL?>">Back</a> 

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<a href="<?=$EditUrl?>" class="edit">Edit</a> 
		<div class="had"><?=$MainModuleName?>   <span> &raquo;
			<? 	echo $SubHeading; ?>
				</span>
		</div>

		  
	<? 
	include("includes/html/box/asset_view.php");


}
?>

