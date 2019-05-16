<?php 
	

	require_once($Prefix."classes/purchase.class.php");	
	$objPurchase=new purchase();

	$arryPurchase=$objPurchase->GetPurchase($_GET['orderid'],$_GET['po'],$_GET['module']);?>

        <div class="had">Stock In   
		<span> &raquo;<?=ucfirst($_GET["tab"])." Details"; ?></span>
	</div>

	<?php foreach($arryPurchase as $stock_data): ?>
		<h2><font color="darkred">StockIn [<?=$stock_data['OrderID']?>] : <?php echo stripslashes($stock_data['PurchaseID']); ?></h2>
	<?php endforeach; ?>
  
	<? 
	if(!empty($_GET['view'])):
		include("includes/html/box/stockin_edit.php");
	endif;

	
	require_once("../includes/footer.php"); 	 
?>


