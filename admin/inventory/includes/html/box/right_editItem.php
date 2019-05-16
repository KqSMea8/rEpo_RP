<? if (!empty($_GET['edit'])) { ?>

    <div class="right-search" >
        <h4> SKU: <?=isset($arryProduct[0]['Sku']) ? $arryProduct[0]['Sku'] : '' ?><br><br>

	 [ <?= isset($arryProduct[0]['description']) ? stripslashes($arryProduct[0]['description']) : '' ?> ]</h4>

        <div class="right_box">
            <ul class="rightlink">
	
                <li <?= ($_GET['tab'] == "basic") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>basic">Basic Details</a></li>

    	
    	
    	
    	<? 
    	
    	$arryProduct[0]['non_inventory'] = isset($arryProduct[0]['non_inventory']) ? stripslashes($arryProduct[0]['non_inventory']) : '';
    	
    	if($arryProduct[0]['non_inventory']=='yes' && $Config['TrackInventory']=='1'){?>
    		<?php //if(!empty($arrySection['binlocation']))
    	//{ ?>
<li <?= ($_GET['tab'] == "binlocation") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>binlocation">Warehouse/Bin </a></li>
<? //}?>

	<?php if(!empty($arrySection['Alias']))
    	{ ?>
 <li <?= ($_GET['tab'] == "Alias") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Alias"> Item Alias</a></li>
         <? }?> 
<? }?>     
               
               <?php if(!empty($arrySection['Price']))
    	{ ?>
                <li <?= ($_GET['tab'] == "Price") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Price">Item Price</a></li>
 <? }?>
    	
    	
    	<? if($_SESSION['SelectOneItem'] == 0){ ?>
    	  <?php if(!empty($arrySection['Quantity']))
    	{ ?>
				<li <?= ($_GET['tab'] == "Quantity") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Quantity">Quantity</a></li>
              <? } }?>
                <?php if(!empty($arrySection['Supplier']))
    	{ ?>
                <li <?= ($_GET['tab'] == "Supplier") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Supplier"> Vendor </a></li>
              <? }?>
<? if($_SESSION['SelectOneItem'] == 0){ ?>
               <?php if(!empty($arrySection['Dimensions']))
    	{ ?>
                <li <?= ($_GET['tab'] == "Dimensions") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Dimensions"> Dimensions </a></li>
              <? }?>
                <?php if(!empty($arrySection['alterimages']))
    	{ ?>
                <li <?= ($_GET['tab'] == "alterimages") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>alterimages"> Alternative Images</a></li>
<? } }?>
  <?php if(!empty($arrySection['Dimensions']))
    	{ ?>
                <!--li <?= ($_GET['tab'] == "Cost") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Cost"> Cost</a></li-->
              <? }?>
                <?php if(!empty($arrySection['Transaction']))
    	{ ?>
                <li <?= ($_GET['tab'] == "Transaction") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Transaction">Transaction </a></li>
		<? }?>
		 <?php if(!empty($arrySection['Required']))
    	{ ?>
		 <li <?= ($_GET['tab'] == "Required") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Required">Required Items</a></li>
<? }?>
 <?php if(!empty($arrySection['Component']))
    	{ ?>
<li <?= ($_GET['tab'] == "Component") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>Component">Item Setting</a></li>
<? }?>

    <?php if($Config['TrackVariant']==1 && !empty($arrySection['Variant']))
    	{ ?>	
<li <?= ($_GET['tab'] == "viewattributes") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>viewattributes">Attribute </a></li>
<?}?>

            </ul>
        </div>
    </div>

<? } else { ?>
    <div class="right-search">
        <h4>
           
        </h4>
        <div class="right_box">
            <ul class="rightlink">	
              <?php if(!empty($arrySection['basic']))
    	       { ?>
                <li <?= ($_GET['tab'] == "basic") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>basic">Basic Details</a></li>
                <?php } ?>
                <? if($_SESSION['SelectOneItem'] == 0){ ?>
                  <?php if(!empty($arrySection['Price']))
           	{ ?>
                <li class="disable">Item Price</li>
                
                <?php } ?>
                
              <?php if(!empty($arrySection['Alias']))
           	{ ?>     
    <li class="disable"> Item Alias</li>
     <?php } ?>

  <?php if(!empty($arrySection['Quantity']))
    	{ ?>
				 <li class="disable">Quantity</li>
				 <?php } ?>
				 <? }?>
				   <?php if(!empty($arrySection['Vendor']))
    	{ ?>
                <li class="disable">Vendor</li>
                <?php } ?>
                  <?php if(!empty($arrySection['Dimensions']))
    	{ ?>
<? if($_SESSION['SelectOneItem'] == 0){ ?>
                <li class="disable">Dimensions</li>
                <?php } ?>
                  <?php if(!empty($arrySection['alterimages']))
    	      { ?>
                <li class="disable">Alternative Images</li>
                <?php } ?>
<? } ?>
                  <?php if(!empty($arrySection['Cost']))
    	{ ?>
                <li class="disable"> Cost</a></li>
                <?php } ?>
                  <?php if(!empty($arrySection['Transaction']))
    	{ ?>
                <li class="disable">Transaction</li>
                <?php } ?>

            </ul>
        </div>
    </div>
<?php } ?>
