<script language="javascript1.2" type="text/javascript">
function validate(frm,opt){

	if(!ValidateMandNumField3(document.getElementById('Quantity'+opt), 'Quantity',1,100)
	){
		return false;
	}else if(parseInt(document.getElementById('Quantity'+opt).value) > parseInt(document.getElementById('AvailableQuantity'+opt).value)){
		alert("Sorry, only "+document.getElementById('AvailableQuantity'+opt).value+" items are available for this product.");
		document.getElementById('Quantity'+opt).select();
		return false;
	}else{
		var SendUrl = 'cart.php?ProductID='+document.getElementById('ProductID'+opt).value+'&Price='+document.getElementById('Price'+opt).value+'&StoreID='+document.getElementById('StoreID'+opt).value+'&Quantity='+document.getElementById('Quantity'+opt).value+'&Tax='+document.getElementById('Tax'+opt).value;
		
		if(document.getElementById("ProductSize"+opt) != null){
			SendUrl += '&Size='+document.getElementById('ProductSize'+opt).value;
		}
		
		//alert(SendUrl);
		location.href = SendUrl;
		
		return false;
	}

	
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">


<?
			
if($num>0 ) { 



	$RecordsPerPage = 6;
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	
	
	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");


	
?>  

	
	<? if($num>count($arryProduct)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>		
				  
          <tr>
            <td valign="top">
			<table width="100%" border="0" cellpadding="2" cellspacing="0"  align="center" >
			
 <? 

 
   $i=0;
   
  foreach($arryProduct as $key=>$values){
   $i++;
   
    	
	
		
		
		$Price = ($values['OfferPrice']>0)?($values['OfferPrice']):($values['Price']);
		if(!empty($_SESSION['VatPercentage']) && $values['TaxExempt']!=1){
			$Tax = ($Price * $_SESSION['VatPercentage'])/100;
			$PriceFinal = $Price+$Tax;
		}else{
			$Tax = 0;
			$PriceFinal = $Price;
		} 
   
		$TaxPer = ($values['TaxExempt']!=1)?($_SESSION['VatPercentage']):("");
   
   
   
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'].$StoreSuffix;
		$CartLink  = 'cart.php?ProductID='.$values['ProductID'].'&Price='.round($Price,2).'&StoreID='.$values['PostedByID'].'&Tax='.round($Tax,2);
		
	




		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=110&h=110'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
		}
		
		$ProductCode ='';
	   if(!empty($values['ProductNumber'])){
			$ProductCode = '<br><br>'.PRODUCT_NUMBER.': '.stripslashes($values['ProductNumber']);
		} 		


		
	unset($arrySize);
	$ProductSize ='';
		
		
	if($values['Quantity']>0){
	
	if(!empty($values['ProductSize'])){
		 $arrySize = explode(",",$values['ProductSize']);
		 $ProductSize = '<div style="height:25px;">
		 Size:&nbsp;<select name="ProductSize'.$i.'" id="ProductSize'.$i.'" class="txtfield" style="width:60px;" >
			 	<option value="">--Any--</option>';
				
		 for($j=0;$j<sizeof($arrySize);$j++) {
           $ProductSize .= ' <option value="'.$arrySize[$j].'"> '.$arrySize[$j].'</option>';
             
        }
		$ProductSize .= '</select></div>';	
	}
	
	
	
		$AddToCartHtml = '
		
	<div style="height:25px;">Qty:&nbsp;&nbsp;&nbsp;<input type="text" name="Quantity'.$i.'" id="Quantity'.$i.'"  value="1"  class="txtfield_quantity" style="width:45px;" maxlength="4" /></div>
		<input type="image" src="images/addtocartbt.jpg" alt="Add To Cart" value="Add To Cart"  />
		
			
	<input name="Price'.$i.'" id="Price'.$i.'" type="hidden" value="'.round($Price,2).'" />
<input name="ProductID'.$i.'" id="ProductID'.$i.'" type="hidden" value="'.$values['ProductID'].'" />

<input name="AvailableQuantity'.$i.'"  id="AvailableQuantity'.$i.'" value="'.$values['Quantity'].'" type="hidden" /> 

<input name="Tax'.$i.'" id="Tax'.$i.'" type="hidden" value="'.$Tax.'" />
<input name="StoreID'.$i.'" id="StoreID'.$i.'" type="hidden" value="'.$values['PostedByID'].'" />
		';
		
		
		
	}else{
		$AddToCartHtml = '<div class="redbig" style="height:40px;"><br><b>Out of stock</b></div>';
	}
	
	
	$VisitStore = '<a href="products.php?cat='.$_GET['cat'].'&StoreID='.$values['PostedByID'].'"><img src="images/visitstorebt.jpg" border="0" style="margin-top:7px" /></a>';
	
	
		
			echo '<tr><td align=center valign="top" class="outline"  >
			
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" class="blacktxt">
				   <form action=""  method="post" name="form_quick'.$i.'" id="form_quick'.$i.'" onsubmit="return validate(this,'.$i.');">
						<tr>
						<td align=left width="20%" valign="top" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">
						<a href="'.$PrdLink.'" >'.$ImagePath.'</a>
				
						</td>
					
						<td align=left valign="top" width="58%"  ><a href="'.$PrdLink.'" ><b>'.ucfirst(stripslashes($values['Name'])).'</b></a><br><br>'.display_price($Price,$TaxPer,$_SESSION['TaxType'],$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).''.$ProductCode.'	
						
						</td>
						
						<td align=left valign="top">
						
						'.$ProductSize.'
						'.$AddToCartHtml.'
						'.$VisitStore.'
						</td>
						
						</tr>
						</form>
				   </table>
				 
			    </td></tr>';
				
		echo '<tr><td height="20" ></td></tr>';
	 
	 } 
	 
	 ?>
	 
	 
</table>


			
			</td>
          </tr>
		  
		  <? if($num>count($arryProduct)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>	
			
			
			
	<tr>
	<td class="skytxt" height="50" align="center">
	
	<a href="recent_items.php">Click here to view recently viewed items</a>
	
	</td>
	</tr>			
			
			
			
			
			
		  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt" height="250" align="center">
			<? echo NO_PRODUCT_FOUND; ?>
			</td>
			</tr>
			 <? } ?>
			 
			 
			 
			 
			 
</table>