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

    for(var i=1;i<=NumLine;i++){
        if(window.parent.document.getElementById("item_id"+i) != null){
            if(window.parent.document.getElementById("item_id"+i).value == ItemID){
                SkuExist = 1;
                break;
            }
        }
    }
    /******************/
    if(SkuExist == 1){
         $("#msg_div").html('Item Sku [ '+Sku+' ] has been already selected.');
    }else{
        ResetSearch();
        var SelID = $("#id").val();
        var SendUrl = "&action=ItemInfo&ItemID="+escape(ItemID)+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
            if(responseText["Sku"]==window.parent.document.getElementById("bom_Sku").value){
 		alert('Item sku does not exist.');
                  }else {
			window.parent.document.getElementById("sku"+SelID).value=responseText["Sku"];
			window.parent.document.getElementById("item_id"+SelID).value=responseText["ItemID"];
                        	//window.parent.document.getElementById("Condition"+SelID).value=responseText["Condition"];
			//window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
			window.parent.document.getElementById("description"+SelID).value=responseText["description"];
			window.parent.document.getElementById("qty"+SelID).value='1';
			window.parent.document.getElementById("price"+SelID).value=responseText["purchase_cost"];
			window.parent.document.getElementById("qty"+SelID).focus();
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
}
                   window.parent.document.getElementById("sku" + SelID).focus();
                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1','P');
               
           


            }
        });
        /******************/
    }

}




function SetBomHeading(){
	
	if(window.parent.document.getElementById("bom_Sku").value!=''){
		var BillHtml = "Bill Number : "+window.parent.document.getElementById("bom_Sku").value+"<br>[ "+window.parent.document.getElementById("bom_description").value+" ]";
		$("#BomForDiv").html(BillHtml);
	}
}



    $(document).ready(function(){       
        
	$(function() {

	$( ".autocomplete" ).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});
	});
        
        
    });
</script>

<div class="had">
    Select Kit Item
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
       <td align="left" >
               <div id="BomForDiv" class="had_item"></div>
		

		<script language="JavaScript1.2" type="text/javascript">
		SetBomHeading();
		</script>

               </td>
     </tr> 


		
    <tr>
       <td align="center" height="20">
               <div id="msg_div" class="redmsg"></div>
               </td>
     </tr> 
     
    <tr>
        <td align="right" valign="bottom">

	<form name="frmSrch" id="frmSrch" action="comItemList.php" method="get" onSubmit="return ResetSearch();">
		<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox autocomplete" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
		<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
		<input type="hidden" name="kit" id="kit" value="<?=$_GET["kit"]?>">
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
                                                 <td class="head1" >Item Condition</td>
						<td class="head1" >Item Description</td>
						<td width="10%" class="head1">Tax</td>
						<td width="12%" class="head1" >Purchase Cost </td>
						<td width="12%" class="head1" >Sale Price</td>
						<td width="12%" class="head1" >Qty on Hand</td>
                                              
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
<td><? if(isset($values['Condition'])) echo stripslashes($values['Condition']); ?></td>
                                <td><?= stripslashes($values['description']); ?></td>
				<td><? if(isset($values['ProductSku'])) echo stripslashes($values['ProductSku']); ?></td>
                                <td><?=number_format($values['purchase_cost'],2);?></td>
                                <td><?=number_format($values['sell_price'],2);?></td>
                                 <td><?=$values['qty_on_hand'];?></td>
                               
                                 
                                
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

