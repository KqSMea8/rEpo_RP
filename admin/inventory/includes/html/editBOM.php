
    <?php
    /*     * ****************** */
    /*     * ****************** */
    $NextID = $objBom->NextPrevBom($_GET['edit'], 1);
    $PrevID = $objBom->NextPrevBom($_GET['edit'], 2);
    $NextPrevUrl = "editBOM.php?curP=" . $_GET['curP'];
    include("../includes/html/box/next_prev_edit.php");
    /*     * ****************** */
    /*     * ****************** */
    ?>

<script language="javascript1.2" type="text/javascript">



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
  
function validateForm(frm) {
  
 
    var NumLine = parseInt($("#NumLine").val());
    var newNumLine = parseInt($("#optionNumLine").val());
    
    
    var bomID = Trim(document.getElementById("bomID")).value;
    
    if (ValidateForSelect(frm.bom_Sku, "Bill Number"))                                      
    {
        if ($(".bill_option:checked").val() == 'No') {
            for (var i = 1; i <= NumLine; i++) {

                if (!ValidateForSimpleBlank(document.getElementById("sku" + i),"Sku")) {
                    return false;                   
                }

                if (!ValidateForSimpleBlank(document.getElementById("description" + i),"Description")) {
                    return false;
                }

                if (!ValidateMandNumField2(document.getElementById("qty" + i), "Quantity", 1, 999999)) {
                        return false;
                    }       
            }
        }

       else{
           if ($(".bill_option:checked").val() == 'Yes') {      
              
                for (var j = 1; j <= newNumLine; j++) {

                    if (!ValidateForSimpleBlank(document.getElementById("option_code" + j),"Option Code")) {
                        return false;

                    }
                    if (!ValidateForSimpleBlank(document.getElementById("description_one" + j),"Description")) {
                        return false;

                    }
                     
                   // alert(parseInt($("#NumLine"+j).val()));
                   // var SkuNumLine = parseInt($("#newNumberLine"+j).val());
                    for(var k=1; k<=parseInt($("#NumLine"+j).val());k++){
                     
                         
                         
                        if (!ValidateForSimpleBlank(document.getElementById("newsku"+j+"-"+k),"Sku")) {
                        return false;

                    } 
                 
                    }
//                    if (!ValidateForSimpleBlank(document.getElementById("newsku1-"+j),"Sku")) {
//                        return false;
//
//                    }
//                    
                    
                    // var optionID = Trim(document.getElementById("option_code"+j).value);
                    //DataExist = CheckExistingData("isRecordExists.php","&OPTIONCODE="+escape(document.getElementById("option_code"+j).value)+"&editID="+document.getElementById("optionID").value, "option_code"+j,"Option Code");
	            //if(DataExist==1)return false;

               }
          }  

           
        } 


        var Url = "isRecordExists.php?BOMSKU=" + escape(document.getElementById("bom_Sku").value)  + bomID;
        SendExistRequest(Url, 'Sku', "Bill Number");
        
       return false;


    } else {
        return false;
    }

}


function OpenLink() {


    if (document.getElementById("Sku").value != '' && document.getElementById("item_id").value > 0 && bill_option == 'Yes') {

        var linkhref = $('#addOption').attr("href") + '?Sku=' + document.getElementById("Sku").value + '&item_id=' + document.getElementById("item_id").value + '&description=' + document.getElementById("description").value + '&bill_option=' + document.getElementById("bill_option").value + '&bomID=' + document.getElementById("bomID").value;
        $('#addOption').attr("href", linkhref);
    } else {

        var styleU = "pointer-events: none; cursor: default";
        $('#addOption').attr("style", styleU);
    }

}




$(document).ready(function () {
    //$('#bill_option').on('change', function(){
    $('.bill_option').on('change', function () {
        var Sku = $('#bom_Sku').val();
        var item_id = $('#bom_item_id').val();
        var description = $('#bom_description').val();
        var bill_option = $('#bill_option').val();
        var bomID = $('#bomID').val();
       
        //console.log("value"+this.value);
        if (this.value == 'Yes') {
          //  ShowList();
        

		$('#opt_cat').show(1000);
		$('#component').hide(1000);
		$('#component table .itembg:first input[type!="button"]').val(''); //by chetan 24Jan2017//
		$('#component table .itembg:not(:first):not(:last)').remove();
		$('#component #NumLine').val(1);
            if (Sku != '' && item_id > 0 && description != '' && bill_option == 'Yes') {



                var linkhref = $('#addOption').attr("href") + '?Sku=' + Sku + '&item_id=' + item_id + '&description=' + description + '&bill_option=' + bill_option + '&bomID=' + bomID;
                $('#addOption').attr("href", linkhref);
            } else {

                var styleU = "pointer-events: none; cursor: default";
                $('#addOption').attr("style", styleU);
            }
        }
        else {
          
            	$('#opt_cat').hide(1000);
		$('#opt_cat .optionsTable:first input[type!="button"]').val('');//by chetan 24Jan2017//
		$('#opt_cat .optionsTable:first .itembg:not(:first)').remove('');
		$('#opt_cat .optionsTable:not(:first)').remove();
		$('#opt_cat #optionNumLine').val(1);
            	$('#component').show(1000);
            var linkhref = $('#addOption').attr("href") + '';
            $('#addOption').attr("href", linkhref);
        }
    });


});







function SearchBoCode(Key) {

    var DataExist = 0;
    var bomID = document.getElementById("bomID").value;
//alert(bomID);
    if (document.getElementById("bom_Sku").value == '') {
        return false;
    }
    DataExist = CheckAvailField('MsgSpan_Display', 'bom_Sku', bomID);

//DataExist = CheckExistingData("isRecordExists.php","&bom_Sku="+escape(Key)+"&editID="+bomID, "Sku","Bill Number");

    if (DataExist == 'undefined') {
        //$("#msg_div").html('Item Sku [ '+Key+' ] has been already selected.');

        //document.getElementById("bomCondition").value = '';
        document.getElementById("bom_item_id").value = '';
        document.getElementById("bom_description").value = '';
        document.getElementById("bom_on_hand_qty").value = '';
        document.getElementById("bom_price").value = '';
        return false;
    } else {

        var SendUrl = "&action=SearchBomCode&key=" + escape(Key) + "&r=" + Math.random();
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType: "JSON",
            success: function (responseText) {


                if (responseText["Sku"] == undefined) {
                    //alert('Item Sku [ '+document.getElementById("bom_Sku").value+' ] Does not exists.');
                    document.getElementById('MsgSpan_Display').innerHTML = "<span class=redmsg>Item sku! Does not exists.</span>";
document.getElementById("bom_Sku").value = '';
//                    document.getElementById("bom_Sku").value='';
//                    document.getElementById("bomCondition").value='';
//                    document.getElementById("bom_item_id").value='';
//                    document.getElementById("bom_description").value='';
//                    document.getElementById("bom_on_hand_qty").value='';
//                    document.getElementById("bom_price").value='';

                } else {


                    document.getElementById("bom_Sku").value = responseText["Sku"];
                    //document.getElementById("bomCondition").value = responseText["Condition"];
                    document.getElementById("bom_item_id").value = responseText["ItemID"];
                    document.getElementById("bom_description").value = responseText["description"];
                    document.getElementById("bom_on_hand_qty").value = responseText["qty_on_hand"];
                    document.getElementById("bom_price").value = responseText["sell_price"];
//                    document.getElementById("sku1").focus();
                    if (responseText["RequiredItem"] != '')
                    {
                        var req_itm_sp = responseText["RequiredItem"].split("#");
                        var req_item_length = req_itm_sp.length;
                        if (req_item_length > 1) {
                            for (var r = 1; r <= req_item_length; r++) {
                                $("#addrow").click();
                            }
                        }

                        var NumLine = parseInt($("#NumLine").val());


                        for (var s = 0; s < req_item_length; s++) {
                            var reqItem = req_itm_sp[s];
                            var req_itm_sp_pipe = reqItem.split("|");

                            for (var m = 1; m <= NumLine; m++) {
                                if (document.getElementById("sku" + m) != null) {
                                    if (document.getElementById("sku" + m).value == "")
                                    {
                                        document.getElementById("item_id" + m).value = req_itm_sp_pipe[0];
                                        document.getElementById("sku" + m).value = req_itm_sp_pipe[1];
                                        document.getElementById("description" + m).value = req_itm_sp_pipe[2];
                                        document.getElementById("qty" + m).value = req_itm_sp_pipe[3];
                                        break;
                                    }

                                }
                            }
                        }

                    }

                }



            }
        });
        /******************/
    }

}
function SearchBOMComponent(key, count) {
 
    var NumLine = document.getElementById("NumLine").value;

    /******************/
    var SkuExist = 0;
    if (document.getElementById("sku" + count).value == '') {
        return false;
    }
   
    
    for (var i = 1; i <= NumLine; i++) {
        if (document.getElementById("sku" + i) != null) {
            if (document.getElementById("sku" + count).value != '') {
                if (i != count) {
                    if (document.getElementById("sku" + i).value == key) {
                        SkuExist = 1;
                        break;
                    }
                }
            } else {
                return false;
            }
        }
    }

//alert(NumLine );

    /******************/
    if (SkuExist == 1) {

        alert('Item Sku [ ' + key + ' ] has been already selected.');
        document.getElementById("sku" + count).focus();

    } else {
        ResetSearch();
        document.getElementById("sku" + count).value = '';
        var SelID = count;
        //alert(SelID );
        var SendUrl = "&action=SearchBomCode&key=" + escape(key) + "&r=" + Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType: "JSON",
            success: function (responseText) {
                if($("#component").is(':visible'))
                {
                    $obj = $("#component");  
                }    
                else{
                     $obj = $("#opt_cat");
                }
                //alert(responseText["Condition"]);
                if (responseText["Sku"] == undefined) {
                    alert('Item Sku [ ' + key + ' ] is not exists.');
                    document.getElementById("sku" + SelID).value = '';
                    document.getElementById("sku" + SelID).value = '';
                    document.getElementById("item_id" + SelID).value = '';
                    //document.getElementById("Condition" + SelID).value = '';
                    //window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
                    document.getElementById("description" + SelID).value = '';
                    document.getElementById("qty" + SelID).value = '';
                    document.getElementById("price" + SelID).value = '';
                    document.getElementById("sku" + SelID).focus();

                } else {
                    document.getElementById("sku" + SelID).value = responseText["Sku"];
                    document.getElementById("item_id" + SelID).value = responseText["ItemID"];
                    //document.getElementById("Condition" + SelID).value = responseText["Condition"];
                    //window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
                    document.getElementById("description" + SelID).value = responseText["description"];
                    document.getElementById("qty" + SelID).value = '1';
                    document.getElementById("price" + SelID).value = responseText["purchase_cost"];
                    document.getElementById("qty" + SelID).focus();
                }



                //parent.jQuery.fancybox.close();
                //ShowHideLoader('1','P');
                //jQuery.fancybox.close();



            }
        });
        /******************/
    }

}
function SearchBOMoptionComponent(key, count) {
    if(key ==''){return false;}        
           
    $ID =  count.split('-');
//alert($ID);
    var newNumLine = document.getElementById("NumLine"+$ID[0]).value;
    

    /******************/
    var SkuExist = 0;
    if (document.getElementById("newsku" +count).value == '') {
        return false;
    }
   
    for (var i = 1; i <=newNumLine; i++) {
   
        if (document.getElementById("newsku"+$ID[0]+'-'+i) != null)
        {
           
            if ($.trim($("#newsku" +$ID[0]+'-'+i).val())!='') {
                if (count != $ID[0]+'-'+i) {
                    if ($("#newsku"+$ID[0]+'-'+i).val() == key) {
                       // alert(document.getElementById("newsku"+$ID[0]+'-'+i).value==key);
                        SkuExist = 1;
                        break;
                    }
                }
            } else {
                alert("Item Sku can't be empty.");
                return false;
            }
        }else{
            alert("Item Sku can't be empty.");
            return false;
        }
    }

//alert(NumLine );

    /******************/
    if (SkuExist == 1) {

        alert('Item Sku [ ' + key + ' ] has been already selected.');
        document.getElementById("newsku" + count).focus();

    } else {
        ResetSearch();
        document.getElementById("newsku" + count).value = '';
        var SelID = count;
        //alert(SelID );
        var SendUrl = "&action=SearchBomCode&key=" + escape(key) + "&r=" + Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType: "JSON",
            success: function (responseText) {
                if($("#component").is(':visible'))
                {
                    $obj = $("#component");  
                }    
                else{
                     $obj = $("#opt_cat");
                }
                //alert(responseText["Condition"]);
                if (responseText["Sku"] == undefined) {
                    alert('Item Sku [ ' + key + ' ] is not exists.');
                    document.getElementById("newsku" + SelID).value = '';
                    document.getElementById("newsku" + SelID).value = '';
                    document.getElementById("newitem_id" + SelID).value = '';
                   // document.getElementById("Condition" + SelID).value = '';
                    //window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
                    document.getElementById("newdescription" + SelID).value = '';
                    document.getElementById("newqty" + SelID).value = '';
                    document.getElementById("newprice" + SelID).value = '';
                    document.getElementById("newsku" + SelID).focus();

                } else {
                    document.getElementById("newsku" + SelID).value = responseText["Sku"];
                    document.getElementById("newitem_id" + SelID).value = responseText["ItemID"];
                   // document.getElementById("newCondition" + SelID).value = responseText["Condition"];
                    //window.parent.document.getElementById("on_hand_qty"+SelID).value=responseText["qty_on_hand"];
                    document.getElementById("newdescription" + SelID).value = responseText["description"];
                    document.getElementById("newqty" + SelID).value = '1';
                    document.getElementById("newprice" + SelID).value = responseText["purchase_cost"];
                    //document.getElementById("newqty" + SelID).focus();
                }



                //parent.jQuery.fancybox.close();
               //ShowHideLoader('1','P');
                //jQuery.fancybox.close();



            }
        });
        /******************/
    }

}



$(document).ready(function () {
    var counter = 2;

    $("#addrow").on("click", function () {
       

        counter = parseInt($("#NumLine").val()) + 1;
      

        var newRow = $("<tr class='itembg'>");
        var cols = "";

        /*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
         cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/

        // cols += '<td><img src="../images/delete.png" id="ibtnDel">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="10" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMComponent(this.value,'+counter+');" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="comItemList.php?id=' + counter + '" ><img src="../images/view.gif" border="0"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /></td><td style="display:none"><select name="Condition'+counter+'" id="Condition'+counter+'" class="textbox" style="width:120px;"><option value="">Select Condition</option><?=$ConditionDrop?></select></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly style="width:350px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="qty' + counter + '" id="qty' + counter + '" class="textbox"  size="5"/><input type="hidden" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isNumberKey(event);"/><input type="hidden" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';


       /* cols += '<td style="width: 25%"><input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="20" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMComponent(this.value,' + counter + ');" maxlength="20"  />&nbsp;<a class="fancybox fancybox.iframe" href="comItemList.php?id=' + counter + '" ><span id="g-search-buttonss"><img src="../images/search.png" border="0"></span></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /></td><td><input type="checkbox" name="Primary' + counter +' " id="Primary' + counter +' " class="textbox" value="1"  /> </td><td style="width: 20%"><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td style="width: 15%"><input type="text" name="qty' + counter + '" id="qty' + counter + '" class="textbox"  size="5"/><input type="hidden" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isNumberKey(event);"/><input type="hidden" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td><td style="width: 20%"><img src="../images/delete-161.png" id="ibtnDel">&nbsp;<input type="hidden" name="orderby' + counter + '" id="orderby' + counter + '" class="textbox" maxlength="5" /></td>';*/
 cols += '<td style="width: 25%"><input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="20" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMComponent(this.value,' + counter + ');" maxlength="20"  />&nbsp;<a class="fancybox fancybox.iframe" href="comItemList.php?id=' + counter + '" ><span id="g-search-buttonss"><img src="../images/search.png" border="0"></span></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input  style="padding:1px 5px 3px;" type="button" value="Primary" id="SubmitButton" class="button" name="itemPrimary' + counter +'" id="itemPrimary' + counter +'" ><input type="hidden" name="Primary' + counter +'" id="Primary' + counter +'" value="" readonly  /><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /></td><td style="width: 20%"><input type="text" name="description' + counter + '" id="description' + counter + '" class="disabled" readonly style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td style="width: 15%"><input type="text" name="qty' + counter + '" id="qty' + counter + '" class="textbox"  size="5"/><input type="hidden" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isNumberKey(event);"/><input type="hidden" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td><td style="width: 20%"><img src="../images/delete-161.png" id="ibtnDel">&nbsp;<input type="hidden" name="orderby' + counter + '" id="orderby' + counter + '" class="textbox" maxlength="5" /></td>';



        newRow.append(cols);
        //if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
        
       if( $("#component").is(':visible'))
       { 
         //$( ".order-list1" ).empty();
         //$("#sku" ).prop( "disabled", true );;  
        $("table.order-list").append(newRow);
        
        $("#NumLine").val(counter);
        $("#sku" + counter).focus();
        ;
        counter++;
        
    }
    else{
       
      
      // $( "#sku" ).prop( "disabled", false );;
        $("table.order-list1").append(newRow);
         $("#NumLine1").val(counter);
        $("#newsku" + counter).focus();
        ;
        counter++;
    }
    });

    $("table.order-list").on("blur", 'input[name^="price"],input[name^="WastageQty"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });

    $("table.order-list").on("focus", 'input[name^="sku"]', function (event) {

        var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
        if (add_req_flag == 0) {
            addRequiredItem($(this).closest("tr"));
        }





    });

    $("table.order-list").on("blur", 'input[name^="WastageQty"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });

    $("table.order-list").on("blur", 'input[name^="qty"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });
    $("table.order-list").on("click", "#ibtnDel", function (event) {

        /********Edited by pk **********/
        var row = $(this).closest("tr");
        var id = row.find('input[name^="id"]').val();
        if (id > 0) {
            var DelItemVal = $("#DelItem").val();
            if (DelItemVal != '')
                DelItemVal = DelItemVal + ',';
            $("#DelItem").val(DelItemVal + id);
        }
        /*****************************/
        $(this).closest("tr").remove();
        calculateGrandTotal();

    });

    $("table.order-list").on("click", "#addItem", function (event) {

        /********Edited by pk **********/
        var row = $(this).closest("tr");
        var qty = row.find('input[name^="qty"]').val();
        var Wastageqty = row.find('input[name^="Wastageqty"]').val();
        var serial_sku = row.find('input[name^="sku"]').val();
        if (qty > 0) {
            var linkhref = $(this).attr("href") + '&total=' + qty + '&Wastageqty=' + Wastageqty + '&sku=' + serial_sku;
            $(this).attr("href", linkhref);
        }
        /*****************************/

    });

    
    
    $('input[name="bill_option"]').click(function(){
                //newitembg
     
       
                        $("#NumLine").val('1');
                     
                         
        
        
        
    })
    
    
    
    
});

function calculateRow(row) {

    var price = +row.find('input[name^="price"]').val();
    var qty = +row.find('input[name^="qty"]').val();
    var WastageQty = +row.find('input[name^="WastageQty"]').val();
    var totalQ = qty;
    var SubTotal = price * totalQ;
//alert(totalQ);


    row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
}

function calculateGrandTotal() {
    var subtotal = 0, TotalValue = 0;
    var TotalQty = 0;
    //var Currency = $("#Currency").val();

    $("table.order-list").find('input[name^="amount"]').each(function () {
        subtotal += +$(this).val();
    });
    $("table.order-list").find('input[name^="qty"]').each(function () {
        TotalQty += +$(this).val();
    });
    $("#TotalQty").val(TotalQty.toFixed(2));
    $("#TotalValue").val(subtotal.toFixed(2));

    subtotal += +$("#Freight").val();

    //$("#TotalAmount").val(subtotal.toFixed(2));
}


function addRequiredItem(row) {

    var req_item = row.find('input[name^="req_item"]').val();
    //alert(req_item);
    //var no_req_item = row.find('input[name^="no_req_item"]').val();
    if (req_item != '') {
        var req_itm_sp = req_item.split("#");
        var req_item_length = req_itm_sp.length;
    }

    //FOR ITEM DELETE CODE//
    var old_req_item = row.find('input[name^="old_req_item"]').val();

    if (old_req_item != '') {
        var old_req_itm_sp = old_req_item.split("#");
        var lenOldReqItem = old_req_itm_sp.length;
    }

    var NumLineOld = parseInt($("#NumLine").val());

    if (lenOldReqItem > 0) {

        for (var f = 0; f < lenOldReqItem; f++) {
            var oldreqItem = old_req_itm_sp[f];
            var old_req_itm_sp_pipe = oldreqItem.split("|");
            for (var a = 1; a <= NumLineOld; a++) {
                if (document.getElementById("sku" + a) != null) {

                    if (document.getElementById("sku" + a).value == old_req_itm_sp_pipe[1])
                    {

                        var rowTR = $("#sku" + a).closest("tr");
                        var skutemp = rowTR.find('input[name^="sku"]').val();
                        // alert(old_req_itm_sp_pipe[1]+"=="+skutemp);

                        var id = rowTR.find('input[name^="id"]').val();
                        if (id > 0) {
                            var DelItemVal = $("#DelItem").val();
                            if (DelItemVal != '')
                                DelItemVal = DelItemVal + ',';
                            $("#DelItem").val(DelItemVal + id);
                        }
                        /*****************************/
                        rowTR.remove();


                    }


                }
            }
        }
    }

    //END ITEM DELETE CODE//

    //FOR ITEM ADD CODE//
    //alert(req_item_length);
    if (req_item_length > 0) {
        for (var r = 1; r <= req_item_length; r++) {
            $("#addrow").click();
        }

        var NumLine = parseInt($("#NumLine").val());


        for (var s = 0; s < req_item_length; s++) {
            var reqItem = req_itm_sp[s];
            var req_itm_sp_pipe = reqItem.split("|");


            for (var m = 1; m <= NumLine; m++) {
                if (document.getElementById("sku" + m) != null) {
                    if (document.getElementById("sku" + m).value == "")
                    {
                        document.getElementById("item_id" + m).value = req_itm_sp_pipe[0];
                        document.getElementById("sku" + m).value = req_itm_sp_pipe[1];
                        document.getElementById("description" + m).value = req_itm_sp_pipe[2];
                        document.getElementById("qty" + m).value = req_itm_sp_pipe[3];
                        //document.getElementById("on_hand_qty"+m).value = req_itm_sp_pipe[4];
                        //document.getElementById("price"+m).value = '0.00';
                        // document.getElementById("price"+m).disabled=true;
                        //document.getElementById("price"+m).setAttribute("class", "disabled");
                        //class="disabled"
                        break;
                    }

                }
            }
        }

    }

    //END ITEM ADD CODE//

    row.find('input[name^="add_req_flag"]').val('1');


}

//*********Add new option Bill  code***********************


$(document).ready(function () {
    
    // var count = 2;
     $("#addoptionBill").on("click", function () {
         count = parseInt($("#optionNumLine").val()) + 1;
         if( $("#opt_cat").is(':visible'))
       { 
           
        counter = parseInt($("#optionNumLine").val()) + 1;
        var Opcontent = $('#optionsTable1').clone();
        Opcontent.find('input[type!="button"]').val(''); //update by chetan on 26May2017//
        
        length = $('.optionsTable').length;        
        length = length+1;
        
        Opcontent.find('.ibtnDeloption').show().attr('id','ibtnDeloption'+length);
        Opcontent.attr('id','optionsTable'+length);
        Opcontent.find('input[name="option_code1"]').attr('onBlur','Javascript:return OptionItemCode(this.value,"'+length+'")');
         
        Opcontent.find('table tr:eq("2") input').each(function(){
            $name = $(this).attr('name').replace(/[^A-Za-z_]/g, '');
            //alert($name);
            $(this).attr('name',$name+length);
            $(this).attr('id',$name+length);
           
        })
        Opcontent.find('table tr.itembg:not(:first)').remove();
        Opcontent.find('table tr.itembg input:first').each(function(){
            $name = $(this).attr('name').replace(/[^A-Za-z_]/g, ''); // alert($name);
            $(this).attr('name',$name+length+'-1');
            $(this).attr('id',$name+length+'-1');
            $(this).attr('onBlur','Javascript:return SearchBOMoptionComponent(this.value,"'+length+'-1")');

        })
        
	//by chetan 10Mar//
	Opcontent.find('table tr.itembg input:not(:first)').each(function(){
            $name = $(this).attr('name').replace(/[^A-Za-z_]/g, '');  
            $(this).attr('name',$name+length+'-1');
            $(this).attr('id',$name+length+'-1');
        })
	//End// 

       //Opcontent.find('input[name="newdescription'+length+'-1"]').removeAttr('onBlur');
       //Opcontent.find('input[name="newqty'+length+'-1"]').removeAttr('onBlur');
        
        Opcontent.find('table span a').each(function(){
                      $(this).attr('href','mycomItemList.php?id='+length+'-1');
            
        })
        Opcontent.find('table td .addoptionrow a').each(function(){
            $(this).attr('id','addrow'+length);                   
        })
        Opcontent.find('#NumLine1').val('1');
        Opcontent.find('#NumLine1').attr({'name':'newNumberLine'+length,'id':'NumLine'+length});
        
        $('#optionHtml').append(Opcontent);
        
        $("#optionNumLine").val(counter);
         count++;
     }
       
   else{
        $('#opt_cat').hide();
        $("#optionNumLine").val(counter);
         count++;
}

    });
    



// end code


    $(document).on("click",".addmore", function () {
        
        $Index = $(this).attr('id').replace(/[^0-9]/g, '');
        $num = parseInt($("#optionsTable"+$Index+" .numline").val())+1;
        //$Idcount = ($Index) ? $Index : 1;
        counter = $Index+'-'+$num;   
       
        var newRow = $("<tr class='itembg'>");
        var cols = "";
        
       /* cols += '<td style="width: 25%"><input type="text" name="newsku' + counter + '" id="newsku'+counter+'" class="textbox"  size="20" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMoptionComponent(this.value,\''+counter+'\');" maxlength="20"  />&nbsp;<a class="fancybox fancybox.iframe" href="mycomItemList.php?id=' + counter + '" ><span id="g-search-buttonss"><img src="../images/search.png" border="0"></span></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="newitem_id' + counter + '" id="newitem_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="newreq_item' + counter + '" id="newreq_item' + counter + '" readonly /><input type="hidden" name="newold_req_item' + counter + '" id="newold_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="newadd_req_flag' + counter + '" readonly /></td><td><input type="checkbox" name="Primary' + counter +' " id="Primary' + counter +' " class="textbox" value="1"  /> </td><td style="width: 40%"><input type="text" name="newdescription' + counter + '" id="newdescription' + counter + '" class="disabled" readonly style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td style="width: 15%"><input type="text" name="newqty' + counter + '" id="newqty' + counter + '" class="textbox"  size="5"/><input type="hidden" name="newprice' + counter + '"  id="newprice' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isNumberKey(event);"/><input type="hidden" name="newamount' + counter + '" id="newamount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td><td style="width: 20%"><img src="../images/delete-161.png" id="'+ counter +'" class="ibtnDel">&nbsp;<input type="hidden" name="orderby' + counter + '" id="orderby' + counter + '" class="textbox" maxlength="5" /></td>';*/
	cols += '<td style="width: 25%"><input type="text" name="newsku' + counter + '" id="newsku'+counter+'" class="textbox"  size="20" onclick="Javascript:SetAutoComplete(this);" onblur="return SearchBOMoptionComponent(this.value,\''+counter+'\');" maxlength="20"  />&nbsp;<a class="fancybox fancybox.iframe" href="mycomItemList.php?id=' + counter + '" ><span id="g-search-buttonss"><img src="../images/search.png" border="0"></span></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input  style="padding:1px 5px 3px;" type="button" value="Primary" id="SubmitButton" class="button" name="itemPrimary' + counter +'" id="itemPrimary' + counter +'" ><input type="hidden" name="Primary' + counter +'" id="Primary' + counter +'" value="" readonly  /><input type="hidden" name="newitem_id' + counter + '" id="newitem_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="newreq_item' + counter + '" id="newreq_item' + counter + '" readonly /><input type="hidden" name="newold_req_item' + counter + '" id="newold_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="newadd_req_flag' + counter + '" readonly /></td><td style="width: 40%"><input type="text" name="newdescription' + counter + '" id="newdescription' + counter + '" class="disabled" readonly style="width:300px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td style="width: 15%"><input type="text" name="newqty' + counter + '" id="newqty' + counter + '" class="textbox"  size="5"/><input type="hidden" name="newprice' + counter + '"  id="newprice' + counter + '" class="textbox" size="15" maxlength="10" onkeypress="return isNumberKey(event);"/><input type="hidden" name="newamount' + counter + '" id="newamount' + counter + '" class="disabled" readonly size="15" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td><td style="width: 20%"><img src="../images/delete-161.png" id="'+ counter +'" class="ibtnDel">&nbsp;<input type="hidden" name="orderby' + counter + '" id="orderby' + counter + '" class="textbox" maxlength="5" /></td>';
        

        newRow.append(cols);
        $("#optionsTable"+$Index+" table.order-list1").append(newRow);
        $("#optionsTable"+$Index+" .numline").val($num);
        $("#newsku"+ counter).focus();
        
    
    });

    $("table.order-list1").on("blur", 'input[name^="newprice"],input[name^="newWastageQty"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });

    $("table.order-list1").on("focus", 'input[name^="newsku"]', function (event) {

        var add_req_flag = $(this).closest("tr").find('input[name^="newadd_req_flag"]').val();
        if (add_req_flag == 0) {
            addRequiredItem($(this).closest("tr"));
        }





    });

    $("table.order-list1").on("blur", 'input[name^="newWastageQty"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });

    $("table.order-list1").on("blur", 'input[name^="newqty"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });
    
    $(document).on("click", ".ibtnDel", function (e) {
        $itId = $(this).attr('id').replace(/[A-Za-z]/g,'');
        if($('#id'+$itId).val()!='')
        {
         if($('#newDelItem').val()!='')
            {
                $val = $.trim($('#newDelItem').val())+','+$.trim($('#id'+$itId).val());
            }else{
                $val = $.trim($('#id'+$itId).val());
            }
            $('#newDelItem').val($val);   
        }
        
        $(this).closest('tr.itembg').remove();
        
    });
    
    $(document).on("click", ".ibtnDeloption", function (e) {
        
        $OID = $(this).attr('id').replace(/[^0-9]/g,'');
        
        if($('#optionId'+$OID).val()!='')
        {
            if($('#delOptId').val()!='')
            {
                $val = $.trim($('#delOptId').val())+','+$.trim($('#optionId'+$OID).val());
            }else{
                $val = $.trim($('#optionId'+$OID).val());
            }
            $('#delOptId').val($val);
        }
        
       
        if($('.optionsTable').length == 1){
            
            $('.optionsTable input').val('');
            if($('.optionsTable .itembg').length > 1)
            {
                $('.optionsTable .itembg:not(:first)').remove();
            }
             $('.optionsTable .newitembg .numline').attr({'id':'NumLine1','name':'newNumberLine1'}).val(1);
              $('.optionsTable .newitembg a').attr('id','addrow1');
             $('input[name="optionNumLine"]').val(1);
             $('.optionsTable').find('table tr:eq("2") input').each(function(){
                $name = $(this).attr('name').replace(/[^A-Za-z_]/g, '');
                $(this).attr('name',$name+'1');
                $(this).attr('id',$name+'1');
               $(this).attr('onBlur','Javascript:return OptionItemCode(this.value,"1")');

            })
            $('.optionsTable').find('table tr.itembg input:first').each(function(){
                $name = $(this).attr('name').replace(/[^A-Za-z_]/g, ''); // alert($name);
                $(this).attr('name',$name+'1-1');
                $(this).attr('id',$name+'1-1');
                $(this).attr('onBlur','Javascript:return SearchBOMoptionComponent(this.value,"1-1")');
                
            })
            $('.optionsTable').attr('id','optionsTable1');
            $('.optionsTable').find('table span a').each(function(){
                      $(this).attr('href','mycomItemList.php?id='+'1-1');
            })
            $('.optionsTable').find('.ibtnDeloption').hide().attr('id','ibtnDeloption1');
        }else{
        
            $('#optionsTable'+$OID).remove();
        }
    });
    

    $("table.order-list1").on("click", "#addItem", function (event) {

        /********Edited by pk **********/
        var row = $(this).closest("tr");
        var qty = row.find('input[name^="newqty"]').val();
        var Wastageqty = row.find('input[name^="newWastageqty"]').val();
        var serial_sku = row.find('input[name^="newsku"]').val();
        if (qty > 0) {
            var linkhref = $(this).attr("href") + '&total=' + newqty + '&Wastageqty=' + newWastageqty + '&newsku=' + serial_sku;
            $(this).attr("href", linkhref);
        }
        /*****************************/

    });

    
    
    $('input[name="bill_option"]').click(function(){
       
                            $("#NumLine1").val('1');
                     
                         
        
        
        
    })
    
    
    
    
});

function OptionItemCode(Key,ID){
  
if(Key==''){ return false;}
var DataExist =0;




  var SendUrl = "&action=SearchBillNumber&key="+escape(Key)+"&r="+Math.random();
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {


             if(responseText["Sku"] != undefined){
                         document.getElementById("option_code"+ID+"").value=responseText["Sku"];
		           
		           document.getElementById("description_one"+ID+"").value=responseText["description"];
		          
                                  document.getElementById("sku1").focus();

		           
               }
           


            }
        });
        /******************/
  

}


</script>

<a href="<?= $RedirectURL ?>" class="back">Back</a>



<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <? echo (!empty($_GET['edit'])) ? ("Edit " . $ModuleName) : ("Add New " . $ModuleName); ?>

    </span>
</div>
<?php if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
    <?php } ?>





    <form id="form1" name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

   
        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

            <tr>
                <td  >
                    <div class="message"><?php
                        if (!empty($_SESSION['mess_bom'])) {
                            echo $_SESSION['mess_bom'];
                            unset($_SESSION['mess_bom']);
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

                        <tr>
                            <td colspan="2" align="left" class="head">BOM Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 
                                    <tr>
                                        <td align="right" valign="top"   class="blackbold" > Bill Number  : <span class="red">*</span> </td>
                                        <td  height="30" align="left">
<!--                                           <input  name="bom_Sku" onblur="return SearchBoCode(this.value);" id="bom_Sku" value="<?= $arryBOM[0]['Sku'] ?>"   type="text" class="inputbox" size="10" maxlength="30"/>-->
                                          <input id="bom_Sku" class="inputbox" type="text" onblur="Javascript:return SearchBoCode(this.value); " onclick="Javascript:SetAutoComplete(this);" onkeypress="Javascript:ClearAvail('MsgSpan_Display'); " maxlength="30" value="<?= $arryBOM[0]['Sku'] ?>"  name="bom_Sku">

                                     <!--         <input name="bom_Sku" type="text" class="inputbox" style="text-transform:uppercase"   id="bom_Sku" value="<?= $arryBOM[0]['Sku'] ?>" maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');" onblur="Javascript:return SearchBoCode(this.value); />-->
                                            <input  name="bom_item_id" id="bom_item_id" value="<?= $arryBOM[0]['item_id'] ?>" type="hidden"  class="inputbox"  maxlength="30" />
                                            <input  name="bom_on_hand_qty" id="bom_on_hand_qty" value="<?= $arryBOM[0]['on_hand_qty'] ?>" type="hidden"  class="inputbox"  maxlength="30" />	
                                            <a class="fancybox fancybox.iframe" href="ItemListBom.php" id="g-search-button" ><?= $search ?></a>
                                            </br><span id="MsgSpan_Display"></span>
                                        </td>

                                        </td>
                                    </tr>
                                    <tr style="display:none">
                                        <td align="right"   class="blackbold" > Condition : </td>
                                        <td  height="30" align="left">

                                            <select name="bomCondition" id="bomCondition" class="inputbox">
                                                <option value="">Select Condition</option>
                                                <?= $ConditionDrop ?>
                                            </select>



                                        </td>
                                    </tr>
                                    <tr style="margin-left: 50px;">
                                        <td align="right" valign="top"   class="blackbold"> Description : </td>
                                        <td  height="30" align="left">


                                            <input  name="bom_description" id="bom_description" value="<?= $arryBOM[0]['description'] ?>" type="text" readonly="readonly"  style="width:350px;"  class="disabled"    />
                                            <input  name="bom_price" id="bom_price" value="<?= $arryBOM[0]['unit_cost'] ?>" type="hidden" readonly="readonly" size="10"  class="disabled"  maxlength="15" />

                                        </td>
                                    </tr>
                                    <tr>
                                        <td  align="right" valign="top"   class="blackbold" > Bill With Option :  </td>
                                        <td  height="30" valign="top"  align="left" >
                                            <?php if (empty($arryBOM[0]['bill_option'])) $arryBOM[0]['bill_option'] = "No"; ?>
                                            <input type="radio" value="Yes" name="bill_option" class="bill_option"  <?= ($arryBOM[0]['bill_option'] == 'Yes') ? ("checked") : ("") ?> />  YES
                                            <input type="radio" value="No" name="bill_option" class="bill_option"  <?= ($arryBOM[0]['bill_option'] == 'No') ? ("checked") : ("") ?>  />  NO
    
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" width="45%" align="left">

                                        </td>
                                    </tr>
<tr>
                                        <td colspan="2" align="right">
	
                                          <a  class="js-open-modal add" href="#" id="click_to_load_modal_popup" >Copy Bom Item</a>	 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" width="45%" align="left">
                                            <div id="component" <?= $display2 ?> >
                                                <table width="100%" cellspacing="1" cellpadding="3" align="center" >

                                                    <tr>
                                                  
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head" >Component Item</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left" colspan="2">

                                                            <?php include("includes/html/box/bom_item_form.php"); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>



                                    <tr >
                                        <td colspan="2" width="45%" align="left">
                                            <div id="opt_cat" <?= $display1 ?>>
                                                <table width="100%" cellspacing="1" cellpadding="3" align="center" >
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table  width="100%" cellspacing="1" cellpadding="3" align="center"<?//= $table_bg ?>>

                                                                    <tr align="left">


                                                                        <td class="head1"><div style="float:left;">Option</div></td>			

                                                                    </tr>
                                                                    <tr>
                                                                        <td id="optionHtml">
                                                                            <input type="hidden" name="delOptId" id="delOptId" value="" >
                                                                            <input type="hidden" name="newDelItem" id="newDelItem" value="" class="inputbox" readonly />
                                                                    <?php
                                                                    $j =1;
 					 if($_GET['edit']>0  || $_GET['bc'] != ''){
                                                                    if (is_array($arryOption) && !empty($arryOption)) {
                                                                         
                                                                      
                                                                        foreach ($arryOption as $key => $values) {
                                                                           
                                                                       ?>
                                                                                         
                                                                       
                                                                        <?php include("includes/html/editOptionBill.php"); ?>



                                                                        <?php $j++; 
                                                                        
                                                                        } } else{
                                                                            include("includes/html/editOptionBill.php");
                                                                            
                                                                        }} else{
                                                                            include("includes/html/editOptionBill.php");
                                                                            
                                                                        }?>	
                                                                </td>
                                                                        </tr>
                                                                        
                                                                        </div>  


                                                                        <tr class="newitembg">
                                                                            <td colspan="4" align="right">
                                                                                <a href="Javascript:void(0);"  id="addoptionBill" class="add_row" style="float:left;background-color:red;">Add New Option Bill</a>
                                                                                <input type="hidden" name="optionNumLine" id="optionNumLine" value="<?= count($arryOption) ? count($arryOption) :1; ?>" readonly maxlength="20"  />
                                                                                <input type="hidden" name="optionDelItem" id="DelItem" value="" class="inputbox" readonly />
                                                                                <input type="hidden" id="optionBillCounter" value="" >

                                                                                <?php
                                                                                $TotalQty = $TotalQty;

                                                                                $TotalValue = $arryBOM[0]['total_cost'];
                                                                                ?>

                                                                                <br><br>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>                          
                                                         </div>
                                                   </table>
                                              </td>
                                         </tr>
                                    </table>	
                                </td>
                            </tr>
                           


                        </table>
                        
                    
                </td>
            </tr>    
             <?php
                            if ($_GET['edit'] > 0) {
                                $ButtonHide = 'style="display:none;" ';
                                $ButtonTitle = 'Update ';
                            } else {
                                $ButtonTitle = ' Submit ';
                            }
                            ?>
                            <tr >
                                <td  align="center">

                                    <div align="center">
                                        <input type="hidden" name="optionID" id="optionID" value="<?= $_GET['optionID'] ?>" />
                                        <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                                        <input type="hidden" name="option" class="inputbox" id="option" value="<?= $editBomID ?>" />
                                        
                                        <input type="hidden" name="bomID" class="inputbox" id="bomID" value="<?= $editBomID ?>" />
                                        <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?= $PrefixPO ?>" />
                                    </div>

                                </td>
                            </tr>
        </table>           
                        </form>


    <?php //} ?>


                    <script type="text/javascript">

                        $('#bom_Sku').focus();
                    </script>

<!--<script type="text/javascript" src="js/neweditBOM.php.js"></script>-->


        <script type="text/javascript">
            $(document).ready(function () {

                $('#editGnBtn').fancybox({
                    closeBtn: false, // hide close button
                    closeClick: false, // prevents closing when clicking INSIDE fancybox
                    helpers: {
                        // prevents closing when clicking OUTSIDE fancybox
                        overlay: {closeClick: false}
                    },
                    keys: {
                        // prevents closing when press ESC button
                        close: null
                    }
                });

            });

        //By Chetan 18Aug//
            function deleteThisCode(obj)
            {
                console.log(obj);
                $(obj).closest('tr').remove();
            }
        //End//


    $(document).ready(function(){       
        
	$(function() {

	$( ".autocomplete" ).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});
	});
        
        
   
});

</script>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript" src="js/bootstrap.js"></script>
        

    <script type="text/javascript">

$(document).ready(function(){
var $modal = $('#load_popup_modal_show_id');
$('#click_to_load_modal_popup').on('click', function(){
ShowHideLoader('1','P');


$modal.load('bom-list.php',{'id1': '1', 'id2': '2'},function() { $modal.modal('show'); ShowHideLoader('2','P');
});
//$('#load_popup_modal_show_iddd').('show');

//ShowHideLoader('');
});

$('#bom_Sku').focus();
});

function SetAutoComplete(elm){	
//alert(elm);	
	$(elm).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});

} 
</script>

<div id="load_popup_modal_show_id" class="modal fade" tabindex="-1"></div>






<? //include("includes/html/box/bomPopUp.php");?>

