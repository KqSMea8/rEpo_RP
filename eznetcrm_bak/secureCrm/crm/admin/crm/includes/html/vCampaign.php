<?if($_GET['pop']!=1){?>

<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had">Manage Campaign   <span> &raquo;
	<? 	echo ucfirst($_GET["tab"])." Details"; ?>
		</span>
</div>
<? } ?>
  
<? 
if (!empty($_GET['view'])) {
	include("includes/html/box/campaign_view.php");
       
}

?>
