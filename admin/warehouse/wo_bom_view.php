
<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <thead>
        <tr align="left"  >
            <td width="15%" class="heading" >&nbsp;&nbsp;&nbsp;BOM</td>
            <td   class="heading" >Description</td>
            <td   width="15%" class="heading" >Date</td>
            <td width="12%" class="heading" >Qty</td>
            
        </tr>
    </thead>
    <tbody>
        <?
        $TotalQty = 0;
        for ($Line = 1; $Line <= $NumLine; $Line++) {
            $Count = $Line - 1;
if(!empty($_GET['edit']) && $_GET['edit']!='' ){
            //$arryItem = $objItem->GetItems($arryBomItem[$Count]['item_id'], '', '', '');
}


            ?>
            <tr class="itembg">
                <td><?= stripslashes($arryBomItem[$Count]['sku']) ?></td>

                <td><?= stripslashes($arryBomItem[$Count]['description']) ?></td>

                <td><?=$arryBomItem[$Count]['BomDate'] ?></td>

                <td><?= stripslashes($arryBomItem[$Count]["BomQty"]) ?></td>

               


            </tr>
            <?
            //$TotalQty += $arryBomItem[$Count]["bom_qty"];
            //$Total_bom_cost += $arryBomItem[$Count]["total_bom_cost"];
        }
        ?>
    </tbody>
    
</table>

<? //echo '<script>SetInnerWidth();</script>';    ?>
<script type="text/javascript">
   

    $(document).ready(function() {


        $("#addItem").fancybox({
            'width': 450
        });



    });

</script>
