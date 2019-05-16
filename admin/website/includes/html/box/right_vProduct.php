<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4>
    <?= stripslashes($arryProduct[0]['Name']) ?>
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
    <li <?= ($_GET['tab'] == "basic") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>basic"> Basic Properties</a></li>
    <li <?= ($_GET['tab'] == "other") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>other"> Other Properties </a></li>
    <li <?= ($_GET['tab'] == "alterimages") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>alterimages"> Alternative Images </a></li>
    <li <?= ($_GET['tab'] == "description") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>description"> Description </a></li>
    <li <?= ($_GET['tab'] == "seo") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>seo"> Seo Properties</a></li>
    <li <?= ($_GET['tab'] == "addattributes") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>addattributes">Attributes </a></li>
    <li <?= ($_GET['tab'] == "inventory") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>inventory">Inventory </a></li>
    <li <?= ($_GET['tab'] == "discount") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>discount">Quantity Discounts</a></li>
    </ul>
  </div>
</div>
<? }?>
