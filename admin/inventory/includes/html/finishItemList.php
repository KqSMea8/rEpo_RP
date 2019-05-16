<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){   
    $("#prv_msg_div").show();
    $("#frmSrch").hide();
    $("#preview_div").hide();
    $("#msg_div").html("");
}

function ShowList(){   
    $("#prv_msg_div").hide();
    $("#frmSrch").show();
    $("#preview_div").show();
}

function SetItemCode(ItemID,Sku){
    
  var SendUrl = "&action=ItemInfo&ItemID="+escape(ItemID)+"&r="+Math.random();
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
           
           
                    window.parent.document.getElementById("Sku").value=responseText["Sku"];
                    window.parent.document.getElementById("item_id").value=responseText["ItemID"];
               
                    window.parent.document.getElementById("description").value=responseText["description"];
                    //window.parent.document.getElementById("qty").value='1';
                    window.parent.document.getElementById("on_hand_qty").value=responseText["qty_on_hand"];
                   
                
                    
                     window.parent.document.getElementById("price").value=responseText["sell_price"];
                    //window.parent.document.getElementById("qty").focus();

                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1','P');
               
           


            }
        });
        /******************/
  

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
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="finishItemList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
        <input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
<input type="hidden" name="finish" id="finish" value="<?=$_GET["finish"]?>">
</form>



		</td>
      </tr>

    <tr>
               <td id="ProductsListing" height="400" valign="top">

            <form action="" method="post" name="form1">
				<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
				<div id="preview_div">

               <table <?= $table_bg ?>>


					<tr align="left">
						<td width="10%" class="head1">Sku</td>
						<td class="head1" >Item Description</td>
						<td width="10%" class="head1">Tax</td>
						<td width="12%" class="head1" >Purchase Cost </td>
						<td width="12%" class="head1" >Sale Price</td>
						<td width="12%" class="head1" >Qty on Hand</td>
                                                <td width="12%" class="head1" >Hold Qty</td>
						<td width="12%"  class="head1">Measure</td>
					</tr>

                    <?php
                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td ><a href="Javascript:void(0)" onclick="Javascript:SetItemCode('<?=$values["ItemID"]?>','<?=$values["Sku"]?>');"><?=$values["Sku"]?></a></td>
                                <td><?= stripslashes($values['description']); ?></td>
								 <td><?=stripslashes($values['ProductSku']); ?></td>
                                <td><?=number_format($values['purchase_cost'],2);?></td>
                                <td><?=number_format($values['sell_price'],2);?></td>
                                 <td><?=$values['qty_on_hand'];?></td>
                                <td><?=$values['allocated_qty'];?></td>
                                 <td><?= stripslashes($values['UnitMeasure']); ?></td>
                                 
                                
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
				</div>
               


            </form>
        </td>
    </tr>

</table>

