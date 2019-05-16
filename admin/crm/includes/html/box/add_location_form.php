
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        var counter = 2;
        //var TaxRateOption = $("#TaxRateOption").val();

        $("#addrow").on("click", function() {
            /*var counter = $('#myTable tr').length - 2;*/

            counter = parseInt($("#NumLine").val()) + 1;

            setInterval(function() {
                var number = 1 + Math.floor(Math.random() * 6);
                $('#num_gen').value(number);
            }, 10);

            //alert(counter);

            var newRow = $("<tr class='itembg'>");
            var cols = "";

            /*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
             cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/

            cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="country' + counter + '" id="country' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="addLocation.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="country_id' + counter + '" id="country_id' + counter + '" readonly maxlength="20"  /> </td> <td><span style="display:none;" id="state' + counter + '"><a class="fancybox slnoclass fancybox.iframe" href="addState.php?id=' + counter + '" id="addItem"><img src="../images/tab-new.png"  title="Add State">&nbsp;Add State</a><input type="hidden" name="state_id' + counter + '" id="state_id' + counter + '" value="" readonly maxlength="20"  /></span></td><td><span style="display:none;" id="city' + counter + '"><a class="fancybox slnoclass fancybox.iframe" href="addCity.php?id=' + counter + '" id="addItemCity"><img src="../images/tab-new.png"  title="Add City">&nbsp;Add City</a><input type="hidden" name="city_id' + counter + '" id="city_id' + counter + '" value="" readonly maxlength="20"  /></span></td>';



            newRow.append(cols);
            //if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
            $("table.order-list").append(newRow);
            $("#NumLine").val(counter);
            counter++;
        });

        $("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"]', function(event) {
            calculateRow($(this).closest("tr"));
            calculateGrandTotal();
        });

        $("table.order-list").on("blur", 'input[name^="qty"]', function(event) {
            calculateRow($(this).closest("tr"));
            components
            calculateGrandTotal();
        });


        $("table.order-list").on("click", "#ibtnDel", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var id = row.find('input[name^="id"]').val();
            if (id > 0) {
                var DelItemVal = $("#DelItem").val();
                if (DelItemVal != '')
                    DelItemVal = DelItemVal + ',';
                $("#DelItem").val(DelItemVal + id);
                components
            }
            /*****************************/
            $(this).closest("tr").remove();
            calculateGrandTotal();

        });

        $("table.order-list").on("click", "#addItem", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var country_id = row.find('input[name^="country_id"]').val();
            var state_value_sel = row.find('input[name^="state_id"]').val();
            
            if (country_id > 0) {
                var linkhref = $(this).attr("href") + '&country_id=' + country_id +'&state_value_sel='+state_value_sel;
                $(this).attr("href", linkhref);
            }
            /*****************************/

        });
        
        
         $("table.order-list").on("click", "#addItemCity", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var country_id = row.find('input[name^="country_id"]').val();
            var state_id = row.find('input[name^="state_id"]').val();
            var city_value_sel = row.find('input[name^="city_id"]').val();
            
            if (country_id > 0) {
                var linkhref = $(this).attr("href") + '&country_id=' + country_id +'&state_id='+ state_id +'&city_value_sel='+city_value_sel;
                $(this).attr("href", linkhref);
            }
            /*****************************/

        });


    });

    function calculateRow(row) {

        var price = +row.find('input[name^="price"]').val();
        var qty = +row.find('input[name^="qty"]').val();
        //var taxRate = row.find('select[name^="tax"]').val();
        var SubTotal = price * qty;
//alert(qty);


        row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
    }

    function calculateGrandTotal() {
        var subtotal = 0, TotalValue = 0;
        var TotalQty = 0;
        //var Currency = $("#Currency").val();

        $("table.order-list").find('input[name^="amount"]').each(function() {
            subtotal += +$(this).val();
        });
        $("table.order-list").find('input[name^="qty"]').each(function() {
            TotalQty += +$(this).val();
        });
        $("#TotalQty").val(TotalQty.toFixed(2));
        $("#TotalValue").val(subtotal.toFixed(2));

        subtotal += +$("#Freight").val();

        //$("#TotalAmount").val(subtotal.toFixed(2));
    }



</script>



<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <thead>
        <tr align="left"  >
            <td  class="heading" colspan="3" >&nbsp;&nbsp;&nbsp;Country</td>
           
           
        </tr>
    </thead>
    <tbody>
        <?
        $TotalQty = 0;
        for ($Line = 1; $Line <= $NumLine; $Line++) {
            $Count = $Line - 1;
            ?>
            <tr class="itembg">
                <td width="20%"><?= ($Line > 1) ? ('<img src="../images/delete.png" id="ibtnDel">') : ("&nbsp;&nbsp;&nbsp;") ?>
                    <input type="text" name="country<?= $Line ?>" id="country<?= $Line ?>" class="disabled" readonly size="10" maxlength="10"  value="<?=(isset($arryAdjustmentItem[$Count]["country"])) ? stripslashes($arryAdjustmentItem[$Count]["country"]) : ''; ?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="addLocation.php?id=<?= $Line ?>" ><img src="../images/view.gif" border="0"></a>
                    <input type="hidden" name="country_id<?= $Line ?>" id="country_id<?= $Line ?>" value="<?=(isset($arryAdjustmentItem[$Count]["country_id"])) ? stripslashes($arryAdjustmentItem[$Count]["country_id"]) : ''; ?>" readonly maxlength="20"  />
                    <input type="hidden" name="id<?= $Line ?>" id="id<?= $Line ?>" value="<?=(isset($arryAdjustmentItem[$Count]["id"])) ?  stripslashes($arryAdjustmentItem[$Count]["id"]) : '';?>" readonly maxlength="20"  />
                    </td>
                 <td width="20%">
                    <span style="display:none;"  id="state<?= $Line ?>">
                        <a  class="fancybox slnoclass fancybox.iframe" href="addState.php?id=<?= $Line ?>"id="addItem"><img src="../images/tab-new.png"  title="Add State">&nbsp;Add State</a>
                        <input type="hidden" name="state_id<?= $Line ?>" id="state_id<?= $Line ?>" value="<?=(isset($arryAdjustmentItem[$Count]["state_id"])) ?  stripslashes($arryAdjustmentItem[$Count]['state_id']) : ''; ?>" readonly maxlength="20"  />
                    </span>
                </td>
                  <td>
                    <span style="display:none;"  id="city<?= $Line ?>">
                        <a  class="fancybox cityclass fancybox.iframe" href="addCity.php?id=<?= $Line ?>"id="addItemCity"><img src="../images/tab-new.png"  title="Add City">&nbsp;Add City</a>
                        <input type="hidden" name="city_id<?= $Line ?>" id="city_id<?= $Line ?>" value="<?=(isset($arryAdjustmentItem[$Count]["city_id"])) ?  stripslashes($arryAdjustmentItem[$Count]['city_id']) : '';?>" readonly maxlength="20"  />
                    </span>
                </td>
            </tr>
            <?
            $TotalQty += (isset($arryAdjustmentItem[$Count]["qty"])) ?  $arryAdjustmentItem[$Count]["qty"] : '';
        }
        ?>
    </tbody>
    <tfoot>

        <tr class="itembg">
            <td colspan="3" align="right">

                <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Location</a>
                <input type="hidden" name="NumLine" id="NumLine" value="<?= $NumLine ?>" readonly maxlength="20"  />
                <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />

            </td>
        </tr>
    </tfoot>
</table>


<script>

 $(document).ready(function() {


        $(".slnoclass").fancybox({
            'width': 800
        });
        
         $(".cityclass").fancybox({
            'width': 800
        });



    });

</script>
