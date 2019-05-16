<? if (!empty($_GET['edit'])) { ?>

    <div class="right-search" >
        <h4>
	<? echo stripslashes($arryBOM[0]['Sku']);
	if(($arryBOM[0]['bill_option'] =='No' || $arryBOM[0]['bill_option'] =='') || $_GET['edit'] ==''){

	    $disabled ='style="pointer-events: none; cursor: default;"';
	}else{
	    $disabled =" ";
	} 
if($_GET['edit'] ==''){
 $disabled_com ='style="pointer-events: none; cursor: default;"';
}else{
$disabled_com = "";
}
?>
        </h4>
        <div class="right_box">
            <ul class="rightlink">

                <li <?= ($_GET['tab'] == "bill_Information") ? ("class='active'") : (""); ?>><a onclick="return LoaderSearch();" href="<?= $EditUrl ?>bill_Information"> BOM Information</a></li>

<li <?= ($_GET['tab'] == "Option_Bill") ? ("class='active'") : (""); ?>><a <?=$disabled?> onclick="return LoaderSearch();" href="<?= $EditUrl ?>Option_Bill"> Option Bill</a></li>
 <!--li <?= ($_GET['tab'] == "Component") ? ("class='active'") : (""); ?>><a <?=$disabled_com?> onclick="return LoaderSearch();" href="<?= $EditUrl ?>Component"> Component Item</a></li-->


            </ul>
        </div>
    </div>
<? } else { ?>
    <div class="right-search">
        <h4>
            <?= stripslashes($arryProduct[0]['Name']) ?>
        </h4>
        <div class="right_box">
            <ul class="rightlink">	
                 <li <?= ($_GET['tab'] == "bill_Information") ? ("class='active'") : (""); ?>> BOM Information</li>
 <li <?= ($_GET['tab'] == "Option_Bill") ? ("class='active'") : (""); ?>> Option Bill</li>
 <!--li <?= ($_GET['tab'] == "Component") ? ("class='active'") : (""); ?>> Component Item</li-->

            </ul>
        </div>
    </div>
<?php } ?>
