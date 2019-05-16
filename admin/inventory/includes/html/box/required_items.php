<? 
if($ItemID>0){
	$arryRequired = $objItem->GetRequiredItem($ItemID,'');
	$NumLine = sizeof($arryRequired);	

	if($NumLine==0){
	 	$NumLine=1;
	}
?>
<script language="JavaScript1.2" type="text/javascript">

function SetItemReqCode(key,Count){
    var NumLine = document.getElementById("NumLine").value;   
 $("#msg_div").html('');
    var ParentItemID = document.getElementById("item_sku").value;	
//var ItemID = document.getElementById("item_id"+Count).value;	
     if(document.getElementById("sku"+Count).value == ''){
		return false;
	}
    
   
    /******************/
    var SkuExist = 0;

   for(var i=1;i<=NumLine;i++){
        if(document.getElementById("sku"+i) != null){
         if(i!=Count){
            if(document.getElementById("sku"+i).value == key){
                SkuExist = 1;
                break;
            }
          }
        }
    }
    /******************/
   if(SkuExist == 1){
         $("#msg_div").html('Item Sku [ '+key+' ] has been already selected.');
                   document.getElementById("sku"+Count).value='';
                    document.getElementById("item_id"+Count).value='';
                    document.getElementById("description"+Count).value='';
		    document.getElementById("on_hand_qty"+Count).value='';	
                   document.getElementById("qty"+Count).value='';
    }else if(ParentItemID==key){
	 $("#msg_div").html('Item Sku [ '+key+' ] can not be selected as this is parent item.');
                  document.getElementById("sku"+Count).value='';
                    document.getElementById("item_id"+Count).value='';
                    document.getElementById("description"+Count).value='';
		    document.getElementById("on_hand_qty"+Count).value='';	
                   document.getElementById("qty"+Count).value='';
    }else{
        //ResetSearch();
document.getElementById("sku"+Count).value = '';
        var SelID = Count;
       //alert(SelID );
        var SendUrl = "&action=ReqItemCode&key="+escape(key)+"&r="+Math.random();
//alert(SendUrl );
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
          
           if(responseText == null){
                    document.getElementById("sku"+SelID).value='';
                    document.getElementById("item_id"+SelID).value='';
               
                    document.getElementById("description"+SelID).value='';
		    document.getElementById("on_hand_qty"+SelID).value='';	
                   document.getElementById("qty"+SelID).value='';
                    
                    
}else{

			document.getElementById("sku"+SelID).value=responseText["Sku"];
                    document.getElementById("item_id"+SelID).value=responseText["ItemID"];
               
                    document.getElementById("description"+SelID).value=responseText["description"];
		    document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];	
                   document.getElementById("qty"+SelID).value='1';
                    
                    document.getElementById("qty"+SelID).focus();

}
                    //parent.jQuery.fancybox.close();
                    //ShowHideLoader('1','P');
               
           


            }
        });
        /******************/
    }

}

</script>

<script language="JavaScript1.2" type="text/javascript">

function validateRequired(frm){
	var NumLine = parseInt($("#NumLine").val());
	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("sku"+i) != null){
			if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
				return false;
			}			
			if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
				return false;
			}
                     
		}
	}

	ShowHideLoader('1','S');
}





	$(document).ready(function () {
	var counter = 2;
	
	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;
             
		var newRow = $("<tr class='itembg'>");
		var cols = "";
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox" onclick="Javascript:SetAutoComplete(this);" onblur="return SetItemReqCode(this.value,' + counter + ');"  size="10" maxlength="15"  />&nbsp;<a class="fancybox fancybox.iframe" href="reqItemList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '" id="qty' + counter + '" class="textbox"  size="5" maxlength="6" onkeypress="return isNumberKey(event);"/></td>';

		newRow.append(cols);
		
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});
	

	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		

	});
        
       
        

	});



function SetAutoComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});

}
</script>


<div id="msg_div" align="center" class="redmsg"></div>
 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left"  >
		<td class="heading" width="25%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKU</td>
		<td  class="heading" >Description</td>
     		<td width="15%" class="heading">Qty on Hand</td>
		<td width="12%" class="heading" >Qty</td>
		
    </tr>
</thead>
<tbody>
	<? if(sizeof($arryRequired)==0 && $_GET['view']>0){?>
 <tr >		
	<td colspan="4" class="no_record"><?=NO_RECORD?></td>		
    </tr>
	<?
	}else{
	$inputClass = ($_GET['edit']>0 || $_GET['bc']>0)?('textbox'):('disabled');
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	

		$sku = (!empty($arryRequired[$Count]['sku']))?($arryRequired[$Count]['sku']):('');		
		 
		$item_id = (!empty($arryRequired[$Count]['item_id']))?($arryRequired[$Count]['item_id']):('');
		$id = (!empty($arryRequired[$Count]['id']))?($arryRequired[$Count]['id']):('');

		
		 $description = (!empty($arryRequired[$Count]['description']))?($arryRequired[$Count]['description']):('');		
		$qty_on_hand = (!empty($arryRequired[$Count]['qty_on_hand']))?($arryRequired[$Count]['qty_on_hand']):('');
		$qty = (!empty($arryRequired[$Count]['qty']))?($arryRequired[$Count]['qty']):('');
	


		
	?>
     <tr class="itembg">
		<td><?=($Line>0 && ($_GET['edit']>0 || $_GET['bc']>0))?('<img src="../images/delete.png" id="ibtnDel">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" onblur="return SetItemReqCode(this.value,'<?=$Line?>');" class="textbox"  onclick="Javascript:SetAutoComplete(this);" size="10" maxlength="15"  value="<?=stripslashes($sku)?>"/>&nbsp;<?if($_GET['edit']>0 || $_GET['bc']>0){?><a class="fancybox fancybox.iframe" href="reqItemList.php?id=<?=$Line?>" ><img src="../images/view.gif" border="0"></a><?}?>
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($item_id)?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($id)?>" readonly maxlength="20"  />
		</td>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="disabled" style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($description)?>" readonly/></td>
	<td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($qty_on_hand)?>"/></td>
        <td><input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="<?=$inputClass?>"  size="5"  value="<?=stripslashes($qty)?>" maxlength="6" onkeypress="return isNumberKey(event);"/>

</td>
       
       
       
    </tr>
	<? 
	}} ?>
</tbody>
<tfoot>

<? if($_GET['edit']>0 || $_GET['bc']>0){ ?>
    <tr class="itembg">
        <td colspan="8" align="right">

<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Item Row</a>

<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
<input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
<input type="hidden" name="item_sku" id="item_sku" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" class="inputbox" readonly />
		
        </td>
    </tr><? } ?>
</tfoot>
</table>

<? } ?>
