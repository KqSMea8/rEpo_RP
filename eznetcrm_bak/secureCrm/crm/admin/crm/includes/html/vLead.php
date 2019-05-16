<?if($_GET['pop']!=1){?>


<?
	/*********************/
	/*********************/
   	$NextID = $objCommon->NextPrevLead($_GET['view'],1);
	$PrevID = $objCommon->NextPrevLead($_GET['view'],2);
	$NextPrevUrl = "vLead.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	include("includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>




<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had">Manage Lead   <span> &raquo;
	<? 	echo ucfirst($_GET["tab"])." Details"; ?>
		</span>
</div>

<? } ?>

<? if($_GET['tab']!="Lead"){?>
<h2><font color="darkred"> Lead [<?=$arryLead[0]['leadID']?>] : <?php echo stripslashes($arryLead[0]['FirstName']); ?> &nbsp; <?php echo stripslashes($arryLead[0]['LastName']); ?>           </h2>

<? }?>
  
<? 
if (!empty($_GET['view'])) {
	include("includes/html/box/lead_view.php");
}

?>

<?  include("includes/html/box/alert_msg.php"); ?>
<?  include("includes/html/box/convert_form.php"); ?>
