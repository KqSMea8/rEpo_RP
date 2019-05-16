<SCRIPT LANGUAGE=JAVASCRIPT>
$(document).ready(function () {
	$("#ZipCode").on("click", function () { 
		autozipcode();
	});	 
});



</SCRIPT>


<?php 
$width='98%';
?>


<div id="inner_mid" class="mid-continent" style="width:<?=$width?>;">

<?php
$arrDuration = explode("/", $_POST['PlanDuration']);

?>

<style>
#chkt table th {
	background: #f6f6f6;
	padding: 14px 10px;
	border-right: 1px solid #e8e4e4;
	border-bottom: 1px solid #e8e4e4;
	font-size: 14px;
}

#chkt table td {
	padding: 17px 4px 17px 10px;
	color: #6f6f6f;
	font-size: 16px;
	border-bottom: solid 1px #d7d7d7;
	border-right: solid 1px #d7d7d7;
	font-weight: 300;
	text-transform: capitalize;
}

</style>

<div id="chkt">
<h1 style="text-align: center;" class="title" id="page-title">Checkout</h1>

<table id="cart-table" class="table table-striped" width="100%" >
	<thead>
		<tr>
			<th width="20%" class="text-center" >Item</th>
			<th width="30%" class="text-center">Number of users</th>
			<th width="20%" class="text-center">Plan Type</th>
			<th width="20%" class="text-center">Price $</th>
			<th width="15%" class="text-center">Subtotal $</th>
		</tr>
	</thead>
	<tbody id="cartcontents">
		<tr>
			<td>CRM: <?php echo $arrayPkjName[0]['name'];?></td>
			<td class="text-center"><?php echo $_POST['MaxUser'];?></td>
			<td class="text-center"><?php echo $arrayPkjName[0]['name'];?></td>
			<td class="text-center"><?php echo $_POST['TotalAmount'];?></td>
			<td class="text-right"><?php echo $_POST['TotalAmount'];?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td class="text-right" colspan="4">
			<h3>Total:</h3>
			</td>
			<td class="text-right">
			<h3 id="total-display">$ <?php echo $_POST['TotalAmount'];?></h3>
			</td>
		</tr>
	</tfoot>
</table>

</div>



<div class="had">
<span>Create Company</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } ?>
  <?php if(!empty($_SESSION['mess_company'])){
  	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_company'].'</div>';
  	unset($_SESSION['mess_company']);  	
  }?>


	<? 
	include("includes/html/box/company_create.php");
	
	
	?>
</div>
