
<script language="JavaScript1.2" type="text/javascript">

    function SetAutoCompleteoption(elms) {
        $(elms).autocomplete({
            
  
            source: "../jsonSku.php",
            minLength: 1
        });

    }



//By Chetan 25Nov//
    $(function(){

        $("table #opt_cat #myTable tbody").sortable({
            items: 'tr.itembg',
            helper: fixHelper,
            update: resetOrders,
        });

    }); 

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
    
    var resetOrders = function(e,ui){
        
         $("table #opt_cat #myTable tbody tr.itembg").each(function(i) {
            $(this).find('input[name^="orderby"]').val((i+1));
        });
    }
    
    //End//






</script>
<table width="100%" id="myTable" class="order-list1"  cellpadding="0" cellspacing="1">
    <thead>
        <tr align="left"  >
            <td class="heading" style="width: 20%" >SKU</td>
            <td  class="heading" style="width: 40%" >Description</td>
            <td style="width: 10%" class="heading" >Qty</td>
            <td style="width: 20%" class="heading" >Action </td>



</tr>
</thead>
<tbody>

<?php
$TotalQty = 0;
   if(!empty($optionID)){
   if($_GET['edit'] || $_GET['bc'] != ''){
        if($_GET['edit']){
		$arryoptionBomItem = $objBom->GetBOMStock($_GET['edit'],$values['optionID']);
	}else{
		$arryoptionBomItem = $objBom->GetBOMStock($_GET['bc'],$values['optionID']);
	}
         $NumLine1 = (sizeof($arryoptionBomItem))? sizeof($arryoptionBomItem) : 1;
    }  
}   



	if(empty($arryoptionBomItem)){   
		$arryoptionBomItem = $objConfigure->GetDefaultArrayValue('inv_item_bom');
	}



        for ($Line = 1; $Line <= $NumLine1; $Line++) {
         $Count = $Line - 1;
    ?>
    <tr class="itembg">
       <td style="width: 28%">
            <input type="text" name="newsku<?= $j?>-<?= $Line ?>" onclick="Javascript:SetAutoCompleteoption(this);" onblur="return SearchBOMoptionComponent(this.value, '<?= $j ?>-<?= $Line ?>');" id="newsku<?= $j ?>-<?= $Line ?>" class="textbox"  size="20" maxlength="20"  value="<?= stripslashes($arryoptionBomItem[$Count]["sku"]) ?>"/>&nbsp;<span id="g-search-buttonss" ><a id ="myLink" class="fancybox fancybox.iframe" href="mycomItemList.php?id=<?= $j?>-<?= $Line ?>" ><img src="../images/search.png" border="0"></a></span>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?= $Line ?>&oid=<?= $arryoptionBomItem[$Count]['id'] ?>" id="req_link<?= $Line ?>" <?= $ReqDisplay ?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a>
		<!--by chetan 24Jan2017-->
		<input  style="<?php if($arryoptionBomItem[$Count]['Primary'] ==1){ echo "padding:1px 5px 3px;background:#aaa;";}else{ echo "padding:1px 5px 3px;";  }?>" type="button" value="Primary" id="SubmitButton" class="button" name="itemPrimary<?= $j ?>-<?= $Line ?>" id="itemPrimary<?= $j ?>-<?= $Line ?>" >
		<input type="hidden" name="Primary<?= $j ?>-<?= $Line ?>" id="Primary<?= $j ?>-<?= $Line ?>" value="<?php if($arryoptionBomItem[$Count]['Primary'] == 1){ echo "1";} ?>" readonly  /><!--End-->
	
            <input type="hidden" name="newitem_id<?= $j ?>-<?= $Line ?>" id="newitem_id<?= $j ?>-<?= $Line ?>" value="<?= stripslashes($arryoptionBomItem[$Count]["item_id"]) ?>" readonly maxlength="20"  />

            <input type="hidden" name="newid<?= $j ?>-<?= $Line ?>" id="id<?= $j ?>-<?= $Line ?>" value="<?php if ($_GET['edit']) echo $arryoptionBomItem[$Count]["id"]; ?>" readonly maxlength="20" class="id"  />

            <input type="hidden" name="newreq_item<?= $j ?>-<?= $Line ?>" id="newreq_item<?= $j ?>-<?= $Line ?>" value="<?= stripslashes($arryoptionBomItem[$Count]['req_item']) ?>" readonly />

            <input type="hidden" name="newold_req_item<?= $j ?>-<?= $Line ?>" id="newold_req_item<?= $j ?>-<?= $Line ?>" value="<?= stripslashes($arryoptionBomItem[$Count]['req_item']) ?>" readonly />

            <input type="hidden" name="newadd_req_flag<?= $j ?>-<?= $Line ?>" id="newadd_req_flag<?= $j ?>-<?= $Line ?>" value="" readonly />
        </td>
        <!---<td><input type="checkbox" name="Primary<?=$j?>-<?= $Line ?>" <?php if($arryoptionBomItem[$Count]['Primary'] ==1){ echo "checked";} ?> id="Primary<?= $j ?>-<?= $Line ?> " class="textbox" value="1"  /> </td>-->

        <td style="width: 40%"><input type="text" name="newdescription<?= $j ?>-<?= $Line ?>" id="newdescription<?= $j ?>-<?= $Line ?>" class="disabled" readonly style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?= stripslashes($arryoptionBomItem[$Count]["description"]) ?>"/></td>
        <td style="width: 15%"><input type="text" name="newqty<?= $j ?>-<?= $Line ?>" id="newqty<?= $j ?>-<?= $Line ?>" onkeypress="return isNumberKey(event);" class="textbox"  size="5"  value="<?= stripslashes($arryoptionBomItem[$Count]["bom_qty"]) ?>"/>
        <td style="width: 20%"><? if($Line>1){?><img src="../images/delete-161.png" class="ibtnDel" id="ibtnDel<?= $j?>-<?= $Line ?>" ><? }?>

            <input type="hidden" name="orderby<?= $j ?>-<?= $Line ?>" id="orderby<?= $Line ?>" class="textbox" maxlength="5" value="<?= stripslashes($arryoptionBomItem[$Count]["orderby"]) ?>"/>





    <input type="hidden" align="right" name="newamount<?= $j ?>-<?= $Line ?>"id="newamount<?= $Line ?>-<?= $Line ?>" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?= stripslashes($arryoptionBomItem[$Count]["total_bom_cost"]) ?>"/>
    <input type="hidden" name="newprice<?= $j ?>-<?= $Line ?>"id="newprice<?= $Line ?>-<?= $Line ?>" class="textbox" size="15" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?= stripslashes($arryoptionBomItem[$Count]["unit_cost"]) ?>"/>

    </td>



    </tr>
    <?php
    //$TotalQty += $arryoptionBomItem[$Count]["bom_qty"];
    $Total_bom_cost += $arryoptionBomItem[$Count]["total_bom_cost"];
} 
?>
</tbody>
<tfoot>
   
    <tr class="newitembg">
        <td colspan="4" align="right"  class="addoptionrow">

            <a href="Javascript:void(0);"  id="add_row<?= $j ?>" class="add_row addmore" style="float:left;">Add Row</a>
            <input type="hidden" name="newNumberLine<?= $j ?>" id="NumLine<?= $j ?>" class="numline " value="<?= $NumLine1 ?>" readonly maxlength="20"  />


            <?php
            $TotalQty = $TotalQty;

            $TotalValue = $arryBOM[0]['total_cost'];
            ?>


            <?php //Totals Cost :?> <input type="hidden" align="right" name="TotalValue" id="TotalValue" class="disabled" readonly value="<?= $TotalValue ?>" size="15" style="text-align:right;"/>
            <br><br>
        </td>
    </tr>
</tfoot>
</table>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function () {
        $(".reqbox").fancybox({
            'width': 500
        });

    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#addItemBackup").click(function () {
            var TotQty = $("#qty1").val();
            $(this).attr("href", "editSerial.php?id=1&total=" + TotQty);
            $('.fancybox').fancybox();
        })

    });
</script>