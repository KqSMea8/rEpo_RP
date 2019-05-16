<style>
.vTop {
	vertical-align: top;
}

.numberBox-25 {
	display: block;
	margin: 0 auto;
	width: 25%;
}

.numberBox-75 {
	margin: 0 auto;
	width: 75%;
}

.help-icon {
	background: rgba(0, 0, 0, 0)
		url("http://icons.iconarchive.com/icons/dryicons/aesthetica-2/16/help-icon.png")
		no-repeat scroll 28% 112%;
	display: inline-block;
	height: 18px;
	width: 32px;
}

.ok-icon {
	background: rgba(0, 0, 0, 0)
		url("http://icons.iconarchive.com/icons/tatice/cristal-intense/16/ok-icon.png")
		no-repeat scroll 28% 112%;
	display: inline-block;
	height: 18px;
	width: 32px;
}
</style>

 <?php $RedirectURL='dashboard.php?curP=1&tab=salesorder';?>

<form class="form-search black-bg" id="formsearch" Name="formsearch" method="get" action="">
    <div class="field-area">
        <input type="text" class="search-query textbox" id="search" name="key" placeholder="Search" value="<?=stripslashes($_GET['key'])?>">        
        <button type="submit" class="add-on"><i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
</form>


<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0>
	<tr>
		<td>
		<div class="message" id="msg"></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			align="center">
			
			<tr>
			
				<td width="50%" align="left"></td>
				<td width="50%" align="right">
				<a href="<?=$RedirectURL?>" class="back">Back</a>
				<a href="javascript:void(0);"
					class="grey_bt" id="addtocartncheck">Add to cart & checkout</a> <a
					href="javascript:void(0);" class="white_bt" id="addtocart">Add to
				cart</a>               </td>
			</tr>
			

		</table>
		<form class="form-horizontal" method="post" id="productList"
			name="productList" enctype="multipart/form-data">

		<table <?= $table_bg ?>>
			<tr align="left">
				<td width="3%" class="head1" align="center"></td>
				<td width="10%" class="head1" align="center">Image</td>
				<td width="25%" class="head1" align="center">Product</td>
				<td width="25%" class="head1" align="center">Note</td>
				<td width="12%" class="head1" align="center">Quantity</td>
				
				<td width="5%" class="head1" align="center"></td>
			</tr>
			<?php 
			
			$count=0;
			if(count($arryProduct)>0){
				$MainDir = "../admin/inventory/upload/items/images/".$_SESSION['CmpID']."/";
				foreach($arryProduct as $list){?>
			<tr bgcolor="#ffffff"   align="center">
				<td rowspan=2><input type="checkbox" class="productcheck"
					name="ProductID[]" value="<?php echo $list['ItemID'];?>"></td>
				<td rowspan=2 align="center"><? if ($list['Image'] != '' && file_exists($MainDir . $list['Image'])) { 
					echo '<a href=" '.$MainDir.$list['Image'].'" class="fancybox" data-fancybox-group="gallery"  title="'.stripslashes($list["Sku"]).'" >
					<img src="resizeimage.php?w=80&h=80&img='.$MainDir . $list['Image'] . '" border=0  ></a>';  }
					else {  echo '<img src="resizeimage.php?w=80&h=80&img=./images/no.jpg" border=0  >';

				 }?></td>
				<td align="center"><!--<a
					href="productDetails.php?id=<?php echo $list['ItemID'];?>"><?php echo stripslashes($list['Sku']); ?></a>-->
					<?php echo stripslashes($list['Sku']); ?><br>
					<?php if($list['sell_price']>0) echo $Config['CurrencySymbol'].number_format( $list['sell_price'], 2, '.', '')?>
					</td>
				<td align="center">
				<textarea style="width:300px;height:50px" name="DesComment[<?php echo $list['ItemID'];?>]" class="inputbox" min="0"></textarea>
				
				</td>
				<td align="center">
				<input type="number"  name="Quantity[<?php echo $list['ItemID'];?>]" class="inputbox" min="0"/>
				
				</td>
				
	

				<td rowspan=2 id="select_<?php echo $count;?>"></td>
			</tr>
			<tr bgcolor="#ffffff" class="vTop">
				<td colspan=4><?php echo $list['description'];?></td>
			</tr>
			<?php $count++; } }else {?>
			<tr>
				<td colspan="9" class="no_record">No product found.</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="9">Total Product(s) : &nbsp;<?php echo $num; ?> <?php if (count($arryProduct) > 0) { ?>
				&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
				}
				?></td>
			</tr>
		</table>
		<input type="hidden" id="action" readonly value="" name="action">
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			align="center">
			
			<tr>
				<td width="50%" align="left"></td>
				<td width="50%" align="right"><a href="javascript:void(0);"
					class="grey_bt" id="addtocartncheck">Add to cart & checkout</a> <a
					href="javascript:void(0);" class="white_bt" id="addtocart">Add to
				cart</a>               </td>
			</tr>
			

		</table>
		</td>
	</tr>
</table>
				
<script type="text/javascript">
$("#search").autocomplete(
{
    search: function () {},
    source: function (request, response)
    {
        $.ajax(
        {
            url: 'jsonProduct.php',
            dataType: "json",
            data:
            {
                term: request.term,                
            },
            success: function (data)
            {
                response(data);
            }
        });
    },
    minLength: 1,
    select: function (event, ui)
    {
        var test = ui.item ? ui.item.id : 0;
        if (test > 0)
        {
           alert(test);
        }
    }
});

$("body").on('click','#addtocart',function(){

	addtoCart();

});

$("body").on('click','#addtocartncheck',function(){
	var selectedcheckbox=checkQuantity();
	
	if(selectedcheckbox){
		addtoCart();
		addtoCartNCheckout();
	}else{
		 selectedcheckbox=true;
		$(".productcheck:checked").each(function(index, val){

			   var proId=$(this).val();
			 
			   if($('input[name="Quantity['+proId+']"]').val()=='' || $('input[name="Quantity['+proId+']"]').val()==0 ){
				   selectedcheckbox=false;
				   
			   }else{
				   selectedcheckbox=true;
			   }   
			   
			   
			});
		if(selectedcheckbox){
			addtoCartNCheckout();
		}else{
			alert('Please select atleast one product and quantity greater then zero ');
		}
		
	}
	
	
});

function checkQuantity(){
	var selectedcheckbox=false;
	$(".productcheck:checked").each(function(index, val){
		   var proId=$(this).val();
		  
		  
		   if($('input[name="Quantity['+proId+']"]').val()=='' || $('input[name="Quantity['+proId+']"]').val()==0 ){
			   selectedcheckbox=false;
			   return selectedcheckbox;
		   }else{
			   selectedcheckbox=true;
		   }   
		   
		   
		});
	return selectedcheckbox;
}

function addtoCart(){

	var selectedcheckbox=checkQuantity();
	
	
	
	if(selectedcheckbox){
		$('#action').val('addToCart');
		$.ajax({
			url: 'ajaxOrder.php',
			async:false,
			type: 'POST',
			data: $("#productList").serialize(),			
			success:function(data){	
			var obj = jQuery.parseJSON(data);
			if(obj.message==1){
				$(".productcheck:checked").each(function(index, val){
					   $('#select_'+index).html('<span class="ok-icon"></span>');				   
					   
					});
				$("div#msg").html('Product has been successfully added in your cart').show();

				$("div#msg").delay(2000).fadeOut("slow");
				location.reload();
					
			}else{
				alert(obj.errormessage);
			}	

			
						
			}
		});
	}else{
		alert('Please select atleast one product and quantity greater then zero and less than or equal to <?php echo $MaxOrderQty?>');
	}
	
	
}

function addtoCartNCheckout(){
	
	$('#action').val('getCartItem');
	$.ajax({
		url: 'ajaxOrder.php',
		async:false,
		type: 'POST',
		data: $("#productList").serialize(),			
		success:function(data){	
		var obj = jQuery.parseJSON(data);
		if(obj.message==1){
			location.href = "cart.php";
		}else{
			alert('Your cart is blank');
		}

					
		}
	});
		
	}
</script>
