<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4>
    <?= stripslashes($arryProduct[0]['Name']) ?>
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
    <li <?= ($_GET['tab'] == "basic") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>basic"> General Details</a></li>
    <li <?= ($_GET['tab'] == "Price") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Price">Item Price</a></li>
    <li <?= ($_GET['tab'] == "Supplier") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Supplier"> Supplier </a></li>
    <li <?= ($_GET['tab'] == "Dimensions") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Dimensions"> Dimensions </a></li>
    <li <?= ($_GET['tab'] == "Cost") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Cost"> Cost</a></li>
    <li <?= ($_GET['tab'] == "Transaction") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>Transaction">Transaction </a></li>
    
    </ul>
  </div>
</div>
<? }else{ ?>
<div class="right-search">
  <h4>
    <?= stripslashes($arryProduct[0]['Name']) ?>
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
    <li <?= ($_GET['tab'] == "basic") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>basic">General Details</a></li>
    <li class="disable">Item Price</li>
    <li class="disable">Supplier</li>
    <li class="disable">Dimensions</li>
    <li class="disable"> Cost</a></li>
     <li class="disable">Transaction</li>
    
    </ul>
  </div>
</div>
<?php } ?>
