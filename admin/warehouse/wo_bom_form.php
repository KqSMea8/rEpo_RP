

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        var counter = 2;
        $("#addrow").on("click", function() {
            counter = parseInt($("#NumLine").val()) + 1;
            var newRow = $("<tr class='itembg'>");
            var cols = "";

           cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox  fancybox.iframe" href="wobomList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="bomID' + counter + '" id="bomID' + counter + '" readonly maxlength="20"  /></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly size="80" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" class="disabled" readonly name="BomDate' + counter + '" id="BomDate' + counter + '" class="textbox"  size="5"/><td><input type="text" name="BomQty' + counter + '"  id="BomQty' + counter + '" class="textbox" size="5" maxlength="6" onkeypress="return isDecimalKey(event);"/></td>';



            newRow.append(cols);
            $("table.order-list").append(newRow);
            $("#NumLine").val(counter);
            counter++;
        });
 
        
        $("table.order-list").on("click", "#ibtnDel", function(event) {

     
            var row = $(this).closest("tr");
            var id = row.find('input[name^="id"]').val();
            if (id > 0) {
                var DelItemVal = $("#DelItem").val();
                if (DelItemVal != '')
                    DelItemVal = DelItemVal + ',';
                $("#DelItem").val(DelItemVal + id);
            }
           
            $(this).closest("tr").remove();
            //calculateGrandTotal();

        });

        


    });

   

   




</script>



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
                <td><?= ($Line >= 1) ? ('<img src="../images/delete.png" id="ibtnDel">') : ("&nbsp;&nbsp;&nbsp;") ?>
                    <input type="text" name="sku<?= $Line ?>" id="sku<?= $Line ?>" class="disabled" readonly size="10" maxlength="10"  value="<?= stripslashes($arryBomItem[$Count]['sku']) ?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="wobomList.php?id=<?= $Line ?>" ><img src="../images/view.gif" border="0"></a>
                    <input type="hidden" name="item_id<?= $Line ?>" id="item_id<?= $Line ?>" value="<?= stripslashes($arryBomItem[$Count]['item_id']) ?>" readonly maxlength="20"  />
 <input type="hidden" name="bomID<?= $Line ?>" id="bomID<?= $Line ?>" value="<?= stripslashes($arryBomItem[$Count]['bomID']) ?>" readonly maxlength="20"  />
                    <input type="hidden" name="id<?= $Line ?>" id="id<?= $Line ?>" value="<?= stripslashes($arryBomItem[$Count]['id']) ?>" readonly maxlength="20"  /> </td>

                <td><input type="text" class="disabled" readonly name="description<?= $Line ?>" id="description<?= $Line ?>" class="inputbox"  size="80" onkeypress="return isAlphaKey(event);" value="<?= stripslashes($arryBomItem[$Count]['description']) ?>"/></td>

                <td><input type="text" class="textbox" onkeypress="return isNumberKey(event);"   name="BomDate<?= $Line ?>" id="BomDate<?= $Line ?>" class="disabled" readonly  size="5"  value="<?=$arryBomItem[$Count]['BomDate'] ?>"/></td>

                <td><input type="text"  name="BomQty<?= $Line ?>" id="BomQty<?= $Line ?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?= stripslashes($arryBomItem[$Count]["BomQty"]) ?>"/></td>

               


            </tr>
            <?
            //$TotalQty += $arryBomItem[$Count]["bom_qty"];
            //$Total_bom_cost += $arryBomItem[$Count]["total_bom_cost"];
        }
        ?>
    </tbody>
    <tfoot>

        <tr class="itembg">
            <td colspan="8" align="right">

                <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
                <input type="hidden" name="NumLine" id="NumLine" value="<?= $NumLine ?>" readonly maxlength="20"  />
                <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


                <?
                $TotalQty = $TotalQty;

                //$TotalValue = $Total_bom_cost;
                ?>


               
            </td>
        </tr>
    </tfoot>
</table>

<? //echo '<script>SetInnerWidth();</script>';    ?>
<script type="text/javascript">
   

    $(document).ready(function() {


        $("#addItem").fancybox({
            'width': 450
        });



    });

</script>
