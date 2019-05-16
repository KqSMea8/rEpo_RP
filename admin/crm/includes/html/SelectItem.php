<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
        $("#msg_div").html("");
    }

    function ShowList() {
        $("#prv_msg_div").hide();
        $("#frmSrch").show();
        $("#preview_div").show();
    }

    function SetItemCode(ItemID, Sku) {
        var NumLine = window.parent.document.getElementById("NumLine").value;

        /******************/
        var SkuExist = 0;

        for (var i = 1; i <= NumLine; i++) {
            if (window.parent.document.getElementById("sku" + i) != null) {
                if (window.parent.document.getElementById("sku" + i).value == Sku) {
                    SkuExist = 1;
                    break;
                }
            }
        }
        /******************/
        if (SkuExist == 1) {
            $("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selected.');
        } else {
            ResetSearch();
            var SelID = $("#id").val();
            var proc = $("#proc").val();
            var SendUrl = "&action=ItemInfo&ItemID=" + escape(ItemID) + "&proc=" + escape(proc) + "&r=" + Math.random();

            /******************/
            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: SendUrl,
                dataType: "JSON",
                success: function(responseText) {

                        /*alert(responseText);
                        return false;*/
                        
                    window.parent.document.getElementById("sku" + SelID).value = responseText["Sku"];
                    window.parent.document.getElementById("item_id" + SelID).value = responseText["ItemID"];
                    window.parent.document.getElementById("description" + SelID).value = responseText["description"];
                    window.parent.document.getElementById("qty" + SelID).value = '1';
                    window.parent.document.getElementById("on_hand_qty" + SelID).value = responseText["qty_on_hand"];
                    window.parent.document.getElementById("price" + SelID).value = responseText["price"];
                    window.parent.document.getElementById("item_taxable" + SelID).value = responseText["Taxable"];


                    if (window.parent.document.getElementById("serial" + SelID) != null) {
                        if (responseText["evaluationType"] == 'Serialized') {

                            window.parent.document.getElementById("serial" + SelID).style.display = "block";
			    window.parent.document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];


                        } else {
                            window.parent.document.getElementById("serial" + SelID).style.display = "none";
                        }
                    }   
                    /***/
                    if (window.parent.document.getElementById("req_link" + SelID) != null) {
                        var ReqDisplay = 'none';
                        if (responseText["NumRequiredItem"] > 0) {
                            ReqDisplay = 'inline';
                            var link_req = window.parent.document.getElementById("req_link" + SelID);
                            link_req.setAttribute("href", 'reqItem.php?item=' + responseText["ItemID"]);

                        }
                        window.parent.document.getElementById("req_link" + SelID).style.display = ReqDisplay;

		  	if (window.parent.document.getElementById("old_req_item" + SelID) != null) {
			  window.parent.document.getElementById("old_req_item" + SelID).value = window.parent.document.getElementById("req_item" + SelID).value;
			  window.parent.document.getElementById("add_req_flag" + SelID).value = 0;
			}

                        window.parent.document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];
			//window.parent.document.getElementById("no_req_item" + SelID).value = responseText["NumRequiredItem"];
                           

                    }
                    /***/

                    window.parent.document.getElementById("price" + SelID).focus();
		    window.parent.document.getElementById("sku" + SelID).focus();


                    parent.ProcessTotal();
                    /**********************************/


                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1', 'P');




                }
            });
            /******************/
        }

    }

</script>

<div class="had">
    Select Item
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="center" height="20">
            <div id="msg_div" class="redmsg"></div>
        </td>
    </tr>	

    <tr>
        <td align="right" valign="top">

            <form name="frmSrch" id="frmSrch" action="SelectItem.php" method="get" onSubmit="return ResetSearch();">
                <input type="text" name="key" id="key" placeholder="<?= SEARCH_KEYWORD ?>" class="textbox" size="20" maxlength="30" value="<?= $_GET['key'] ?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
                <input type="hidden" name="id" id="id" value="<?= $_GET["id"] ?>">
                <input type="hidden" name="proc" id="proc" value="<?= $_GET["proc"] ?>">
            </form>



        </td>
    </tr>

    <tr>
        <td id="ProductsListing" height="400" valign="top">

            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none; padding:50px;"><img src="../images/ajaxloader.gif"></div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>


                        <tr align="left">
                            <td width="10%" class="head1">Sku</td>
                            <td class="head1" >Item Description</td>
                            <td width="20%" class="head1" >Purchase Cost [<?= $Config['Currency'] ?>] </td>
                            <td width="16%" class="head1" >Sale Price [<?= $Config['Currency'] ?>]</td>
                            <td width="12%" class="head1" >Qty on Hand</td>
                            <td width="12%"  class="head1">Taxable</td>
                        </tr>

                        <?php
                        if (is_array($arryProduct) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryProduct as $key => $values) {
                                $flag = !$flag;
                                //$bgcolor=($flag)?(""):("#F3F3F3");
                                $Line++;
                                if (empty($values["Taxable"]))
                                    $values["Taxable"] = "No";
                                ?>
                                <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                    <td>
                                    
                                        <?php if($values["bill_option"] == "Yes"){ ?>
                                        <a href="getOptionCode.php?ItemID=<?=$values["ItemID"]?>&key=<?= $values["Sku"] ?>&id=<?= $_GET["id"] ?>&proc=<?= $_GET["proc"] ?>" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?= $values["Sku"] ?></a>
                                        <?php } else {?>
                                        <a href="Javascript:void(0)" onclick="Javascript:SetItemCode('<?= $values["ItemID"] ?>', '<?= $values["Sku"] ?>');" onMouseover="ddrivetip('<?= CLICK_TO_SELECT ?>', '', '')"; onMouseout="hideddrivetip()"><?= $values["Sku"] ?></a>
                                        <?php }?>
                                    
                                    </td>
                                    <td><?= stripslashes($values['description']); ?></td>

                                    <td><?= number_format($values['purchase_cost'], 2); ?></td>
                                    <td><?= number_format($values['sell_price'], 2); ?></td>
                                    <td><?= stripslashes($values['qty_on_hand']) ?></td>

                                    <td><?= stripslashes($values['Taxable']) ?></td>


                                </tr>
    <?php } // foreach end //  ?>



<?php } else { ?>
                            <tr >
                                <td  colspan="7" class="no_record"><?= NO_RECORD ?></td>
                            </tr>

<?php } ?>



                        <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>
                </div>



            </form>
        </td>
    </tr>

</table>

