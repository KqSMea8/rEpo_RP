<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
      <h4> SKU: <?=stripslashes($arryItem[0]['Sku']) ?><br><br>

	 [ <?=stripslashes($arryItem[0]['description'])?> ]</h4>
  <div class="right_box">

   	<ul class="rightlink">
	
		<li <?= ($_GET['tab'] == "basic") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>basic" onclick="return LoaderSearch();">Basic Details</a></li>
<?if($_SESSION['SelectOneItem'] == 0){ ?>
		<? if($arryItem[0]['non_inventory']=='yes' && $Config['TrackInventory']=='1'){?>
<?php if($arrySection['binlocation']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "binlocation") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>binlocation">Warehouse/Bin</a></li>
		<? }?>


		<?php if($arrySection['Alias']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Alias") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Alias">Item Alias</a></li>
		<?} }?>
		<? }?>
		<?php if($arrySection['Price']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Price") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Price" onclick="return LoaderSearch();">Item Price</a></li>
<?} ?>
		<?if($_SESSION['SelectOneItem'] == 0){ ?>
<?php if($arrySection['Quantity']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Quantity") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Quantity" onclick="return LoaderSearch();">Quantity</a></li>
<?} }?>
<?php if($arrySection['Supplier']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Supplier") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Supplier" onclick="return LoaderSearch();">Vendor</a></li>
<?} ?>
<?if($_SESSION['SelectOneItem'] == 0){ ?>
<?php if($arrySection['Dimensions']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Dimensions") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Dimensions" onclick="return LoaderSearch();">Dimensions</a></li>

<?} ?>
		<?php if($arrySection['alterimages']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "alterimages") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>alterimages" onclick="return LoaderSearch();">Alternative Images</a></li>
		<? } }?>


		<!--li <?= ($_GET['tab'] == "Cost") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Cost" onclick="return LoaderSearch();"> Cost</a></li-->
<?php if($arrySection['Transaction']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Transaction") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Transaction" onclick="return LoaderSearch();">Transaction</a></li>
<? }?>
<?php if($arrySection['Required']==1)
    	{ ?>
		<li <?= ($_GET['tab'] == "Required") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Required" onclick="return LoaderSearch();">Required Items</a></li><? }?>


    	</ul>


  </div>
</div>
<? }?>
