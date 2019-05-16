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
    var NumLine = window.parent.document.getElementById("NumLine").value;   
    
    
   //alert(ItemID);
    /******************/
    var SkuExist = 0;

   /* for(var i=1;i<=NumLine;i++){
        if(window.parent.document.getElementById("item_id"+i) != null){
            if(window.parent.document.getElementById("item_id"+i).value == ItemID){
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
        var SelID = $("#id").val();
       // alert(SelID );
        var SendUrl = "&action=ItemInfo&ItemID="+escape(ItemID)+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
          
            //alert(responseText["Condition"]);
			window.parent.document.getElementById("sku"+SelID).value=responseText["Sku"];
                         window.parent.document.getElementById("Condition"+SelID).value=responseText["Condition"];
			window.parent.document.getElementById("item_id"+SelID).value=responseText["ItemID"];
                        window.parent.document.getElementById("valuationType"+SelID).value = responseText["evaluationType"];
			//window.parent.document.getElementById("on_hand"+SelID).value=responseText["qty_on_hand"];
			if(responseText["evaluationType"] == 'Serialized' || responseText["evaluationType"] == 'Serialized Average'){
                            window.parent.document.getElementById("editType"+SelID).style.display="none";
                            window.parent.document.getElementById("serial"+SelID).style.display="block";
                         
			}else{
                            
                            window.parent.document.getElementById("serial"+SelID).style.display="none";
                             window.parent.document.getElementById("editType"+SelID).style.display="none";
                            
                        }
                        window.parent.document.getElementById("Comp_Serialized"+SelID).value = responseText["evaluationType"];
			window.parent.document.getElementById("description"+SelID).value=responseText["description"];
			//window.parent.document.getElementById("qty"+SelID).value='1';
			//window.parent.document.getElementById("price"+SelID).value=responseText["purchase_cost"];
			window.parent.document.getElementById("qty"+SelID).focus();
/***/
                    if (window.parent.document.getElementById("req_link" + SelID) != null) {
                        var ReqDisplay = 'none';
                        if (responseText["NumRequiredItem"] > 0) {
                            ReqDisplay = 'inline';
                            var link_req = window.parent.document.getElementById("req_link" + SelID);
                            link_req.setAttribute("href", 'reqAssebleItem.php?item=' + responseText["ItemID"]);

                        }
                        window.parent.document.getElementById("req_link" + SelID).style.display = ReqDisplay;

		  	if (window.parent.document.getElementById("old_req_item" + SelID) != null) {
			  window.parent.document.getElementById("old_req_item" + SelID).value = 			  window.parent.document.getElementById("req_item" + SelID).value;
			  window.parent.document.getElementById("add_req_flag" + SelID).value = 0;
			}

                        window.parent.document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];
			//window.parent.document.getElementById("no_req_item" + SelID).value = responseText["NumRequiredItem"];
                           

                    }
                    /***/
                   window.parent.document.getElementById("sku" + SelID).focus();
                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1','P');
               
           


            }
        });
        /******************/
    }

}

</script>

<div class="had">
    Select Kit Item
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		
    <tr>
       <td align="center" height="20">
               <div id="msg_div" class="redmsg"></div>
               </td>
     </tr> 
     <? 
     if(empty($_GET["kit"])){ $_GET["kit"]='';}
     
     if (is_array($arryProduct) && $num > 0) { ?>
    <tr>
        <td align="right" valign="bottom">

	<form name="frmSrch" id="frmSrch" action="DisItemList.php" method="get" onSubmit="return ResetSearch();">
		<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
		<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
		<input type="hidden" name="kit" id="kit" value="<?=$_GET["kit"]?>">
	</form>



		</td>
      </tr>
     <? }?>

    <tr>
               <td id="ProductsListing" height="400" valign="top">

            <form action="" method="post" name="form1">
				<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
				<div id="preview_div">

               <table <?= $table_bg ?>>


					<tr align="left">
						<td width="20%" class="head1">Sku</td>
						<td class="head1" width="10%" >Condition</td>
						<td class="head1" width="10%" >Quantity</td>
						<td class="head1" width="10%" >Cost</td>
						<td class="head1" align="right" >Total Cost</td>
					
					</tr>

                    <?php
                    
                    
                    
                    
                    if (is_array($arryQuant)) {
                        $flag = true;
                        $Line = 0;
                      
                        foreach ($arryQuant as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                             $Line++;
                             $Unitcost = ($values['srQt']>0)?($values['conAmt']/$values['srQt']):(0) ;
                             $qtyonhand = $values['srQt'];
                             $totalamount = $Unitcost * $qtyonhand; 

                             $totalValue +=$totalamount; 
                             $toalQty += $qtyonhand;
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td ><a href="Javascript:void(0)" onclick="Javascript:SetItemCode('<?=$values["ItemID"]?>','<?=$values["Sku"]?>');"><?=$values["Sku"]?></a></td>
                                <td><?= $values['Condition']; ?></td>
                                <td><?= $qtyonhand; ?></td>
                                 <td><?= number_format($Unitcost,2); ?></td>
                                  <td align="right"><?= number_format($totalamount,2); ?></td>
								 
                                 
                                
                            </tr>
                        <?php  } // foreach end // ?>

<tr align="right" bgcolor="#FFF">
<td  colspan="2"><b>Total Qty  : <?=$toalQty?> </b></td>
		<td  colspan="3"><b>Total Amount In <?=$Config['Currency']?> : <?=number_format($totalValue,2);?> </b></td>
		</tr>

                    <?php } else { ?>
                        <tr >
                            <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      
                   </td>
                    </tr>
                </table>
				</div>
               


            </form>
        </td>
    </tr>

</table>

