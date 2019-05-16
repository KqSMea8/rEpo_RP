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
