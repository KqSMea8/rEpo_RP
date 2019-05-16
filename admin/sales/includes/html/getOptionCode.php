<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

 function SetItemCode(ItemID/*, Sku, optionID, option_code*/) {
      /**By Chetan**/  

var SelID = $("#id").val(); 
if($("input[type='checkbox']:checked").length > 0)
{  
    var optionID = [];
        
    $("input[type='checkbox']:checked").each(function(i){
        
        selthis = $(this);
        type = selthis.attr('data-type');
        if(type == 'optioncode')
        {
            optionID.push(selthis.attr('data-option'));
                        
        }
                            
    });
                
}

  optionID  =   JSON.stringify(optionID);
    
 
        /******************/
        /*if (SkuExist == 1) {
            $("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selected.');
        } else {*/
	ResetSearch();
	//var SelID = $("#id").val();
	var proc = $("#proc").val();
	$('#popup1', window.parent.document).css('display','none');         //By Chetan 18Sep//

	/*By Chetan14Aug*/
	var showComponent = ($('#showcompo').is(':checked'))? $('#showcompo').val() :''; 
	var SendUrl = {'action': 'ItemInfo', 'ItemID' :escape(ItemID), 'optionID':optionID, 'proc': escape(proc), 'showcompo':showComponent,'SelID':SelID, 'r':Math.random()};
     
            /********End**********/
            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: SendUrl,
                dataType: "JSON",
                success: function(responseText) {

                        //alert(responseText);
                        //return false;
                     
                        
			window.parent.document.getElementById("sku" + SelID).value = responseText["Sku"];

			window.parent.document.getElementById("item_id" + SelID).value = responseText["ItemID"];

			window.parent.document.getElementById("description" + SelID).value = responseText["description"];
			window.parent.document.getElementById("qty" + SelID).value = '1';
			//By chetan 11Jan//
			window.parent.document.getElementById("on_hand_qty" + SelID).value = '0';//responseText["qty_on_hand"];
			window.parent.document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];     //By Chetan 31Aug//
                    
			// added by Chetan for Condition Quantity 11Jan

			window.parent.document.getElementById("Condition" + SelID).setAttribute('onChange', "getItemCondionQty('"+responseText["Sku"]+"','"+SelID+"',this.value)");
			if(showComponent){
				//if(responseText["itemType"]=='Non Kit')
							window.parent.document.getElementById("Condition"+SelID).setAttribute("class", "disabled");
							window.parent.document.getElementById("Condition"+SelID).disabled=true;
				//}
			window.parent.document.getElementById("DropshipCheck"+SelID).setAttribute("class", "disabled");
			window.parent.document.getElementById("DropshipCheck"+SelID).disabled=true;
			}

			//by chetan 29Jan//	
			window.parent.document.getElementById("evaluationType"+SelID).value=responseText["evaluationType"];	
			if(responseText["evaluationType"] === 'Serialized' || responseText["evaluationType"] === 'Serialized Average')
			{
				$('#addItem'+ SelID, window.parent.document).hide();		
			}else{
				$('#addItem'+ SelID, window.parent.document).hide();	
			}
			window.parent.document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"];//responseText["Taxable"];// update by chetan 23Feb  //	
			//End//
			// end

		//window.parent.document.getElementById("price" + SelID).value = responseText["price"];
		//window.parent.document.getElementById("item_taxable" + SelID).value = responseText["Taxable"];

   /*************************Chetan *****************************/
		var MDAmount = window.parent.document.getElementById("MDAmount").value;
		var MDType = window.parent.document.getElementById("MDType").value;
		var MDiscount = window.parent.document.getElementById("MDiscount").value;
		var CustDisType = window.parent.document.getElementById("CustDisType").value;
		var totDiscountAmt =0;
		var totDiscountCal =0;
		if(MDiscount == 'Cost'){
 
	 
		if(MDType == 'Discount'){

			if(CustDisType == "Percentage"){
				totDiscountCal = Number(responseText["purchasePrice"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["purchasePrice"])-Number(totDiscountCal);

			}else{
				  totDiscountCal = Number(MDAmount);
				  totDiscountAmt = Number(responseText["purchasePrice"]) - Number(MDAmount); 
				  
			}


		}else{


			if(CustDisType == "Percentage"){
				totDiscountCal = Number(responseText["purchasePrice"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["purchasePrice"])+Number(totDiscountCal);

			}

		
//CustDiscount = MDAmount;
  
}
window.parent.document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2); window.parent.document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);
 
}else if(MDiscount == "Sale"){


		if(MDType == "Discount"){

			if(CustDisType == "Percentage"){
				totDiscountCal = Number(responseText["price"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["price"])-Number(totDiscountCal);

			}else if(CustDisType == "Fixed"){
				  totDiscountCal =  Number(MDAmount);
				  totDiscountAmt = Number(responseText["price"]) - Number(MDAmount); 
				  
			}

		 }else if(MDType == 'Markup'){

				totDiscountCal = Number(responseText["price"])*Number(MDAmount)/100;
				totDiscountAmt = Number(responseText["price"]) + Number(totDiscountCal);

                     }
   
	window.parent.document.getElementById("price" + SelID).value = totDiscountAmt.toFixed(2);
       window.parent.document.getElementById("CustDiscount"+ SelID).value = totDiscountCal.toFixed(2);



}else{

       window.parent.document.getElementById("price" + SelID).value = responseText["price"];
       window.parent.document.getElementById("CustDiscount"+ SelID).value = '';
}
					//window.parent.document.getElementById("item_taxable" + SelID).value = responseText["Taxable"];

					/****************end**********************updated by chetan 26feb
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
if(responseText['variantDisplay']!=''){ 
			var prev=window.parent.document.getElementById("VariantINvalues" + SelID).innerHTML;
			//COde for variant
			//alert(responseText['variantDisplay']);
			//prev= prev+'<div id="innerVariantlist_<?=$_GET['id']?>">'+jQuery.parseJSON(responseText);
			prev=prev+responseText['variantDisplay'];
			window.parent.document.getElementById("VariantINvalues" + SelID).innerHTML=prev;
			//End
}
		$('.itembg td:first-child input[data-sku="y"]', window.parent.document).each(function(){$(this).attr('disabled',false);});  //By Chetan 9Sep//                    
		window.parent.document.getElementById("price" + SelID).focus();
		window.parent.document.getElementById("sku" + SelID).focus();
    parent.ProcessTotal();
    /**********************************/
    parent.jQuery.fancybox.close();
    ShowHideLoader('1', 'P');




                }
            });
            /******************/
        //}

    }


//By Chetan 27Aug//
$(function(){

$('.optioncode :checkbox').on('click',function(){
    
    if($(this).is(':checked'))
    {
        $('.optioncode :checkbox:not(:checked)').each(function(){ $(this).attr("disabled", true);});
    }else{
        
        $('.optioncode :checkbox:not(:checked)').each(function(){ $(this).attr("disabled", false);});
    }
    
})


//15Sep to hide and show option code table//
$('#showcompo').on('click',function(){
        $('.optioncode').slideToggle();
        if(!$(this).is(':checked'))
        {
             $('.optioncode :checkbox').each(function(){ $(this).attr("checked", false);$(this).attr("disabled", false);});
             
        }
});   



})

//End//

</script>

<div class="had">Sku&nbsp;-&nbsp;<?=$_GET['key']?>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

  <!--By Chetan 14Aug-->
  <table <?=$table_bg?>>
    <tr align="left">
        <td width="6%" class="head1"><input type="checkbox" name="showcompo" id="showcompo" value="1"></td>    
        <td width="94%" class="head1">Display Component Item( To show select It )</td>
    </tr>
	 
  </table>  
    <!--End-->


<table class="optioncode" style="display: none" <?=$table_bg?>>
    <tr align="left">
	    <td width="12%" colspan="2" class="head1">Option Code</td>
		 
    </tr>
   
	<?php 
	if(is_array($arryOptionCode) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryOptionCode as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	?>
	<tr align="left"  bgcolor="<?=$bgcolor?>">
            <!--By Chetan-->   
            <td><input type="checkbox" data-type="optioncode" data-key="<?=$_GET['key']?>" data-option="<?=$values['optionID']?>" data-code="<?=$values['option_code']?>" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"></td>    
            <td colspan="2"><a href="Javascript:void(0);" <!--onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetItemCode('<?=$_GET['ItemID']?>','<?=$_GET['key']?>','<?=$values['optionID']?>','<?=$values['option_code']?>')-->"><?=$values['option_code']?></a>
            <!--<input type="hidden" name="id" id="id" value="<?= $_GET["id"] ?>">-->
            <input type="hidden" name="proc" id="proc" value="<?= $_GET["proc"] ?>">
        </td>
			 
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 
  </table>
 <!--By Chetan-->
             
  </div> 
<div style="margin-top: 20px;text-align: center;">
      
<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
<input type="button" name="submit" value="submit" onclick="javascript:SetItemCode('<?=$_GET['ItemID']?>')" class="button" id="SubmitButton">  
</div>
<!--End-->
<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>
</td>
	</tr>
</table>
  </div> 


  
</form>
</td>
	</tr>






</table>


