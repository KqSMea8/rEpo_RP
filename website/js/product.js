$(document).ready(function() {
   $("#SubmitButton").click(function(){
       
            var CategoryID = $("#CategoryID").val();
            var pname = $.trim($("#Name").val());
            var ProductSku = $.trim($("#ProductSku").val());
            var Price = $.trim($("#Price").val());
            var Price2 = $.trim($("#Price2").val());
			var ImageName = $("#Image").val();
            var data = '&ProductSku=' + ProductSku +'&action=checkProductSku';
          
 if(CategoryID == "")
       {
           alert("Please Select Product Category");
           $("#CategoryID").focus();
           return false;
       }
 if(pname == "")
       {
           alert("Please Enter Product Name");
           $("#Name").focus();
           return false;
       }
       
        if(ProductSku == "")
       {
           alert("Please Enter Product Sku");
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
                            alert("Product Sku Already Exists");
                            $("#ProductSku").focus();
                            return false;
                        }
                        
                        else if(Price == "" || Price == "0.00")
                            {
                                alert("Please Enter Product Price");
                                $("#Price").focus();
                                return false;
                            }


                         else if(parseInt(Price2) >= parseInt(Price))
                            {
                                alert("Please Enter Valid Sale Price!\nSale Price Must Be Less Than The Product Price")
                                 $("#Price2").focus();
                                 return false;
                            }
							
						else if(!ValidateImageUpload(ImageName, "Image")){
						$("#Image").focus();
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
       //var caption = $.trim($("#caption").val());
       var options = $.trim($("#options").val());
       
       if(attname == "")
       {
           alert("Please Enter Attribute Name");
           $("#attname").focus();
           return false;
       }
       
    /* if(caption == "")
       {
           alert("Please Enter attribute caption");
           $("#caption").focus();
           return false;
       }*/
       if(options == "")
       {
           alert("Please Enter Attribute Options");
           $("#options").focus();
           return false;
       }
    
  });
  
   $("#UpdateBasic").click(function(){
       
            var CategoryID = $("#CategoryID").val();
            var pname = $.trim($("#Name").val());
            var Price = $.trim($("#Price").val());
            var Price2 = $.trim($("#Price2").val());
			var ImageName = $("#Image").val();
      
      if(CategoryID == "")
       {
           alert("Please Select Product Category");
           $("#CategoryID").focus();
           return false;
       }
   if(pname == "")
       {
           alert("Please Enter Product Name");
           $("#Name").focus();
           return false;
       }
       
     if(Price == "" || Price == "0.00")
       {
           alert("Please Enter Product Price");
           $("#Price").focus();
           $("#Price").val('');
           return false;
       }
     
    if(parseInt(Price2) >= parseInt(Price))
    {
        alert("Please Enter Valid Sale Price!\nSale Price Must Be Less Than The Product Price")
         $("#Price2").focus();
         return false;
    }
	
   if(!ValidateImageUpload(ImageName, "Image")){
           $("#Image").focus();
		   return false;
		}
   
    ShowHideLoader('1','S');
       
   });
   
  /* $("#UpdateOther").click(function(){
       
          var Weight = $.trim($("#Weight").val());
            if(Weight == "")
             {
                 alert("Please Enter product Weight");
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
       var   rconfirm = confirm("Are you sure you want to delete this Attribute?");
        if (rconfirm == true) {
           
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
        //var customer_type = $.trim($("#customer_type").val());
        var ProductSalePrice = $("#ProductSalePrice").val();
        var ProductSalePrice = number_format(ProductSalePrice,2,'.','')
        
       if(range_min == "")
       {
           alert("Please Enter Min Range");
           $("#range_min").focus();
           return false;
       }
      if(range_max == "")
       {
           alert("Please Enter Max Range");
           $("#range_max").focus();
           return false;
       }
      
       if(parseInt(range_min) > parseInt(range_max))
       {
           alert("Min Range Should Be Less Than Max Range");
           $("#range_max").focus();
           return false;
       }
       if(discount == "")
       {
           alert("Please Enter Discount");
           $("#discount").focus();
           return false;
       }
       
       
       
       if(discount_type == "---Select---")
       {
           alert("Please Select Discount Type");
           $("#discount_type").focus();
           return false;
       }
       
       if(parseFloat(discount) > parseFloat(ProductSalePrice) && discount_type == "amount")
       {
          alert("Discount Should Be Less Than Product Price");
           $("#discount").focus();
           return false;
       }
       
       if(parseFloat(discount) == "100" && discount_type == "percent")
       {
          alert("Discount Should Be Less Than 100%");
           $("#discount").focus();
           return false;
       }
       
       /*if(customer_type == "---Select---")
       {
           alert("Please Select Customer Type");
           $("#customer_type").focus();
           return false;
       }*/
   
     ShowHideLoader('1','S');
   
   });
   
   $(".deleteProductDiscount").click(function(){
       
       var proVal = $(this).attr('alt');
       var SplitVal = proVal.split("#")
       var productID = SplitVal[0];
       var discVal = SplitVal[1];
       var CatID = $("#CategoryID").val();
       var data = '&productID=' + productID +  '&discVal=' + discVal +'&CatID=' + CatID +'&action=deleteDiscount';
       var rConfirm = confirm("Are You Sure to Delete This Discount?");
        if (rConfirm == true) {
           
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
           alert("Please Select Inventory Rule");
           $("#inventory_rule").focus();
           return false;
       }
       if(Quantity == "")
       {
           alert("Please Enter No. Of Items In Inventory");
           $("#Quantity").focus();
           return false;
       }
       if(stock_warning == "")
       {
           alert("Please Enter Inventory Notification");
           $("#stock_warning").focus();
           return false;
       }
       
         if(parseInt(stock_warning) > parseInt(Quantity))
       {
           alert("Inventory Notification Should Be Less Than Inventory stock");
           $("#stock_warning").focus();
           return false;
       }
       
       ShowHideLoader('1','S');
       
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



