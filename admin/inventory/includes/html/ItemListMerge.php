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
	//var NumLine = window.parent.document.getElementById("NumLine").value;	
	
	/******************/
	var SkuExist = 0;

	/*for(var i=1;i<=NumLine;i++){
		if(window.parent.document.getElementById("sku"+i) != null){
			if(window.parent.document.getElementById("sku"+i).value == Sku){
				SkuExist = 1;
				break;
			}
		}
	}*/
	/******************/
	if(SkuExist == 1){
		 $("#msg_div").html('Item Sku [ '+Sku+' ] has been already selected.');
	}else{
		ResetSearch();
		//var SelID = $("#id").val();
		var proc = $("#proc").val();
		var SendUrl = "&action=ItemInfo&ItemID="+escape(ItemID)+"&proc="+escape(proc)+"&r="+Math.random(); 

		/******************/
		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			dataType : "JSON",
			success: function (responseText) {
			
			
					window.parent.document.getElementById("SKU").value=responseText["Sku"];
					window.parent.document.getElementById("ITEM_ID").value=responseText["ItemID"];
				
					window.parent.document.getElementById("DES").value=responseText["description"];
					//window.parent.document.getElementById("qty").value='1';
					window.parent.document.getElementById("HAND_QTY").value=responseText["qty_on_hand"];
if(responseText["evaluationType"]=='Serialized' || responseText["evaluationType"]=='Serialized Average'){    
                           
			  window.parent.document.getElementById("add_serial").style="";
        window.parent.document.getElementById("ParentValuationType").value=responseText["evaluationType"];     
			}else{
window.parent.document.getElementById("add_serial").style="display:none";
}
window.parent.document.getElementById("ParentPrice").value=responseText["purchase_cost"];
					window.parent.document.getElementById("subitemtext").style='';
					window.parent.document.getElementById("subitem").style='';
					
					//

					//window.parent.document.getElementById("price").focus();

					parent.jQuery.fancybox.close();
					ShowHideLoader('1','P');
				
			


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

<form name="frmSrch" id="frmSrch" action="ItemListMerge.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
	<input type="hidden" name="proc" id="proc" value="<?=$_GET["proc"]?>">
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
						<td width="20%" class="head1" >Purchase Cost [<?=$Config['Currency']?>] </td>
						<td width="16%" class="head1" >Sale Price [<?=$Config['Currency']?>]</td>
						<td width="12%" class="head1" >Qty on Hand</td>
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
                                <td ><a href="Javascript:void(0)" onclick="Javascript:SetItemCode('<?=$values["ItemID"]?>','<?=$values["Sku"]?>');" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=$values["Sku"]?></a></td>
                                <td><?= stripslashes($values['description']); ?></td>
								 
                                <td><?=number_format($values['purchase_cost'],2);?></td>
                                <td><?=number_format($values['sell_price'],2);?></td>
                                 <td><?=stripslashes($values['qty_on_hand'])?></td>
                               
                                 <td><? if(isset($values['UnitMeasure'])) echo  stripslashes($values['UnitMeasure']); ?></td>
                                 
                                
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
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

