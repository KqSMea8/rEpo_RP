<?if($_GET['pop']!=1){?>

<?
	/*********************/
	/*********************/
   	$NextID = $objCommon->NextPrevOpp($_GET['view'],1);
	$PrevID = $objCommon->NextPrevOpp($_GET['view'],2);
	$NextPrevUrl = "vOpportunity.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	include("includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>

<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had">Manage Opportunity   <span> &raquo;
	View <? 	echo ucfirst($_GET["tab"])." Details"; ?>
		</span>
</div>
<? } ?>
  
<? if($_GET['tab']!="Opportunity"){?>
<h2><font color="darkred"> Opportunity [<?=$arryOpportunity[0]['OpportunityID']?>] : <?=stripslashes($arryOpportunity[0]['OpportunityName'])?></font></h2>         
<? } ?>
<? 
if (!empty($_GET['view'])) {
	include("includes/html/box/opportunity_view.php");
}

?>
