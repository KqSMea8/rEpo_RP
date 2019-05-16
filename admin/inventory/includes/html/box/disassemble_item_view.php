

<table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">

    <tr align="left"  >
        <td  width="12%"class="heading" >SKU</td>
<td class="heading" >Condition</td>
        <td class="heading" >Description</td>
        <td width="10%" class="heading" >Valuation Type</td>
        <td  class="heading" >Qty</td>
        <!--td width="12%" class="heading" >Wastage Qty</td-->
        <td width="14%"  class="heading" >Unit Cost</td>
        <td width="14%" align="right"  class="heading" >Total Cost</td>


    </tr>


    <?php
    $TotalQty = $TotalorderQty = $TotalValue = 0;


    for ($Line = 1; $Line <= $NumLine; $Line++) {
        $Count = $Line - 1;
        //$total_received = $objPurchase->GetQtyReceived($arryBOMItem[$Count]["id"]);
        $ordered_qty = $arryBOMItem[$Count]["qty"];

if(!isset($arryBomItem[$Count]["serialPrice"])) $arryBomItem[$Count]["serialPrice"]='';
if(!isset($arryBomItem[$Count]["serialdesc"])) $arryBomItem[$Count]["serialdesc"]='';

        ?>
        <tr class="itembg">
            <td><?= stripslashes($arryBOMItem[$Count]["sku"]) ?></td>
<td><?= stripslashes($arryBOMItem[$Count]["Condition"]) ?></td>
            <td><?= stripslashes($arryBOMItem[$Count]["description"]) ?></td>
            <td><?= stripslashes($arryBOMItem[$Count]["valuationType"]) ?></td>
            <td><?
                echo $ordered_qty;
                if ($arryBOMItem[$Count]["valuationType"] == 'Serialized' || $arryBOMItem[$Count]["valuationType"] == 'Serialized Average') {

                    echo '&nbsp&nbsp&nbsp<a  class="fancybox slnoclass fancybox.iframe" href="AddDisSerial.php?id=' . $Line . '&total='.$ordered_qty.'&dismly=' . $_GET['view'] . '&sku=' . $arryBOMItem[$Count]["sku"] . '&lavel=1&view=1" id="addItem"><img src="../images/tab-new.png"  title="Serial number">&nbsp;View S.N.</a>';
                }
                ?>

 <input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?= stripslashes($arryBOMItem[$Count]["serial_value"]) ?>" readonly maxlength="20"  />
<input type="hidden" name="serialPrice<?= $Line ?>" id="serialPrice<?= $Line ?>" value="<?= stripslashes($arryBomItem[$Count]["serialPrice"]) ?>" readonly   />
 <input type="hidden" name="serialdesc<?= $Line ?>" id="serialdesc<?= $Line ?>" value="<?= stripslashes($arryBomItem[$Count]["serialdesc"]) ?>" readonly   /></td>
          <!--td><?= number_format($arryBOMItem[$Count]["wastageQty"]) ?></td-->
            <td><?= number_format($arryBOMItem[$Count]["unit_cost"], 2) ?></td>   
            <td align="right"><?= number_format($arryBOMItem[$Count]["total_bom_cost"], 2) ?></td>

        </tr>
        <?
        $TotalorderQty += $ordered_qty;
        $TotalValue += $arryBOMItem[$Count]["total_bom_cost"];
        
    }
    ?>


    <tr class="itembg">
        <td colspan="9" align="right">

            <input type="hidden" name="NumLine" id="NumLine" value="<?= $NumLine ?>" readonly maxlength="20"  />

            <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


            <?
            #echo $TotalQtyReceived.'-'.$TotalQtyLeft;
            /* if($TotalQtyLeft<=0){
              echo '<div class=redmsg style="float:left">'.PO_ITEM_RECEIVED.'</div>';
              } */


            $TotalorderQty = number_format($TotalorderQty, 2);
            $TotalValue = number_format($TotalValue, 2);
            #$TotalValue += $arryBOMItem[$Count]["amount"];
            //$TotalValue = number_format($arryAdjustment[0]['total_adjust_value'],2);
            ?>
            <br>



            Total Value : <?= $TotalValue ?>
            <br><br>
        </td>
    </tr>
</table>

<? //echo '<script>SetInnerWidth();</script>';  ?>
 
<script>
$(document).ready(function() {


        $(".slnoclass").fancybox({
            'width': 300
        });



    });

</script>
