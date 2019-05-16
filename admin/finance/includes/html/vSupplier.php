
<a class="back" href="<?=$RedirectURL?>">Back</a> 

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<a href="<?=$EditUrl?>" class="edit" <?=$HideEdit?>>Edit</a> 


		<!--a href="viewSuppReturn.php?sc=<?=$arrySupplier[0]['SuppCode']?>" target="_blank" class="grey_bt">Returns</a--> 
		<!--a href="viewSuppInvoice.php?sc=<?=$arrySupplier[0]['SuppCode']?>" target="_blank" class="grey_bt">Invoices</a--> 
		<!--a href="viewSuppPO.php?sc=<?=$arrySupplier[0]['SuppCode']?>" target="_blank" class="grey_bt">Purchases</a--> 

		<div class="had"><?=$MainModuleName?>   <span> &raquo;
			<? 	echo $SubHeading; ?>
				</span>
		</div>

		  
	<? 
	include("includes/html/box/supplier_view.php");


}
?>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>
