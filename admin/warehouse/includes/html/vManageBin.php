<?php
	require_once($Prefix."classes/warehouse.class.php");
	$objWarehouse = new Warehouse();
	$binlocation_listted = $objWarehouse->getBindata($_GET['view']);     
?>

	<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 

	<div class="had">Manage Bin   
		<span> &raquo;<?=ucfirst($_GET["tab"])." Details"; ?></span>
	</div>

	<?php foreach($binlocation_listted as $bin_data): ?>
		<h2><font color="darkred"> Manage Bin [<?=$bin_data['binid']?>] : <?php echo stripslashes($bin_data['binlocation_name']); ?></h2>
	<?php endforeach; ?>
  
	<? 
	if(!empty($_GET['view'])):
		include("includes/html/box/managebin_view.php");
	endif;

?>
