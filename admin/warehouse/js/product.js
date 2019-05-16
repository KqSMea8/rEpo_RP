$(document).ready(function() {
   $("#SubmitButton").click(function(){
       
            var CategoryID = $("#CategoryID").val();
            var pname = $.trim($("#Name").val());
            var ProductSku = $.trim($("#ProductSku").val());
            var Price = $.trim($("#Price").val());
            var Price2 = $.trim($("#Price2").val());
            var data = '&ProductSku=' + ProductSku +'&action=checkProductSku';
          
 if(CategoryID == "")
       {
           alert("Please select product category");
           $("#CategoryID").focus();
           return false;
       }
 if(pname == "")
       {
           alert("Please enter product name");
           $("#Name").focus();
           return false;
       }
       
        if(ProductSku == "")
       {
           alert("Please enter product sku");
           $("#ProductSku").focus();
           return false;
       }
       
          if(ProductSku != "")
           {
               
                    $.ajax({
                    type: "POST",
                    url: "e_ajax.php",
                    data: data,
                    success: function (msg) {
                         if(msg == "1")
                        {
                            alert("Product sku already exists");
                            $("#ProductSku").focus();
                            return false;
                        }
                        
                        else if(Price == "" || Price == "0.00")
                            {
                                alert("Please enter product price");
                                $("#Price").focus();
                                return false;
                            }


                         else if(parseInt(Price2) > parseInt(Price))
                            {
                                alert("Please enter valid Sale Price!\nSale price must be less than the product price")
                                 $("#Price2").focus();
                                 return false;
                            }
                             
                             else
                                 {
                                     $("#productBasicInfoForm").submit();
                                     return true;
                                 }
                    }
                 });
            
           }
       
 
   });

  $("#UpdateAttribute").click(function(){
    
       var attname = $.trim($("#attname").val());
       var caption = $.trim($("#caption").val());
       var options = $.trim($("#options").val());
       
       if(attname == "")
       {
           alert("Please enter attribute name");
           $("#attname").focus();
           return false;
       }
       
     if(caption == "")
       {
           alert("Please enter attribute caption");
           $("#caption").focus();
           return false;
       }
       if(options == "")
       {
           alert("Please enter attribute options");
           $("#options").focus();
           return false;
       }
    
  });
  
   $("#UpdateBasic").click(function(){
       
            var CategoryID = $("#CategoryID").val();
            var pname = $.trim($("#Name").val());
            var Price = $.trim($("#Price").val());
            var Price2 = $.trim($("#Price2").val());
      
      if(CategoryID == "")
       {
           alert("Please select product category");
           $("#CategoryID").focus();
           return false;
       }
   if(pname == "")
       {
           alert("Please enter product name");
           $("#Name").focus();
           return false;
       }
       
     if(Price == "" || Price == "0.00")
       {
           alert("Please enter product Price");
           $("#Price").focus();
           $("#Price").val('');
           return false;
       }
     
    if(parseInt(Price2) > parseInt(Price))
    {
        alert("Please enter valid Sale Price!\nSale price must be less than the product price")
         $("#Price2").focus();
         return false;
    }
   
       
   });
   
  /* $("#UpdateOther").click(function(){
       
          var Weight = $.trim($("#Weight").val());
            if(Weight == "")
             {
                 alert("Please enter product Weight");
                 $("#Weight").focus();
                 return false;
             }
     
       
   });
   */
   $(".deleteProductAttribute").click(function(){
       
       var proVal = $(this).attr('alt');
       var SplitVal = proVal.split("#")
       var productID = SplitVal[0];
       var attrVal = SplitVal[1];
       var CatID = $("#CategoryID").val();
       var data = '&productID=' + productID +  '&attrVal=' + attrVal +'&CatID=' + CatID +'&action=deleteAttribute';
          
        if (data) {
           
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                 window.location.href = msg;
                }
            });
        }
       
   });
   
   $("#UpdateDiscount").click(function(){
   
        var range_min = $.trim($("#range_min").val());
        var range_max = $.trim($("#range_max").val());
        var discount = $.trim($("#discount").val());
        var discount_type = $.trim($("#discount_type").val());
        var customer_type = $.trim($("#customer_type").val());
       
       if(range_min == "")
       {
           alert("Please enter min range");
           $("#range_min").focus();
           return false;
       }
      if(range_max == "")
       {
           alert("Please enter max range");
           $("#range_max").focus();
           return false;
       }
      
       if(parseInt(range_min) > parseInt(range_max))
       {
           alert("Min range should be less than max range");
           $("#range_max").focus();
           return false;
       }
       if(discount == "")
       {
           alert("Please enter discount");
           $("#discount").focus();
           return false;
       }
       if(discount_type == "---Select---")
       {
           alert("Please select discount type");
           $("#discount_type").focus();
           return false;
       }
       if(customer_type == "---Select---")
       {
           alert("Please select customer type");
           $("#customer_type").focus();
           return false;
       }
   
   });
   
   $(".deleteProductDiscount").click(function(){
       
       var proVal = $(this).attr('alt');
       var SplitVal = proVal.split("#")
       var productID = SplitVal[0];
       var discVal = SplitVal[1];
       var CatID = $("#CategoryID").val();
       var data = '&productID=' + productID +  '&discVal=' + discVal +'&CatID=' + CatID +'&action=deleteDiscount';
          
        if (data) {
           
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                 window.location.href = msg;
                }
            });
        }
       
   });
   
 $("#inventory_control_no").click(function(){
   
   $("#showInventoryControl").hide();

  });
  
   $("#inventory_control_yes").click(function(){
   
   $("#showInventoryControl").show();

  });
  
  $("#UpdateInventory").click(function(){

        var inventory_rule = $.trim($("#inventory_rule").val());
        var Quantity = $.trim($("#Quantity").val());
        var stock_warning = $.trim($("#stock_warning").val());
        
       if(inventory_rule == "---Select---")
       {
           alert("Please select inventory rule");
           $("#inventory_rule").focus();
           return false;
       }
       if(Quantity == "")
       {
           alert("Please enter no. of items in inventory");
           $("#Quantity").focus();
           return false;
       }
       if(stock_warning == "")
       {
           alert("Please enter inventory notification");
           $("#stock_warning").focus();
           return false;
       }
       
         if(parseInt(stock_warning) > parseInt(Quantity))
       {
           alert("Inventory notification should be less than inventory stock");
           $("#stock_warning").focus();
           return false;
       }
       
  });
  

  
  $("#addmore").click(function(){
      
      $("#image4").show();
  });
  
     $(".deleteProductImages").click(function(){
       
       var proVal = $(this).attr('alt');
       var SplitVal = proVal.split("#")
       var productID = SplitVal[0];
       var ImgVal = SplitVal[1];
       var CatID = $("#CategoryID").val();
       var data = '&productID=' + productID +  '&ImgVal=' + ImgVal +'&CatID=' + CatID +'&action=deleteImage';
         
        if (data) {
           
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                 window.location.href = msg;
                }
            });
        }
       
   });

   
});




function keyup(me)
{
if(isNaN(me.value))
{
    me.value="";
}
}
   