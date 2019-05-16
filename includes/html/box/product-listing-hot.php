<table width="100%" border="0" cellpadding="0" cellspacing="0">


<?
			
if($num>0 ) { 



	//$RecordsPerPage = 1;
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	if(empty($PageLimit)) $PageLimit = $RecordsPerPage;
	
	$pagerLink=$objPager->getPager($arryProduct,$PageLimit,$_GET['curP']);
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");


	
?>  

  
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center" >
				<tr>
 <? 
   
	//$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

 
   $i=0;
   
  foreach($arryProduct as $key=>$values){
   $i++;
   
   
  		$Price = ($values['OfferPrice']>0)?($values['OfferPrice']):($values['Price']);
 
   
		if(!empty($_SESSION['VatPercentage']) && $values['TaxExempt']!=1){
			$Tax = ($Price * $_SESSION['VatPercentage'])/100;
			$PriceFinal = $Price+$Tax;
		}else{
			$Tax = 0;
			$PriceFinal =$Price;
		}
   
   
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'];
		$CartLink  = 'cart.php?ProductID='.$values['ProductID'].'&Price='.round($Price,2).'&StoreID='.$values['PostedByID'].'&Tax='.round($Tax,2);
		
		/*$ContactLink = 'send-email.php?cmp='.$values['PostedByID'];
		$ReviewLink = 'review.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		

		
		$RatingHTML = getRatingHTML($values['Ranking'],$arryTotalRanking[0]['TotalRanks']);
		

		if(!empty($values['UserName'])){
			$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';
			$StoreLink = '&nbsp;|&nbsp; <a href="'.$StoreLink.'" class="view_white_link">'.GO_TO_STORE.'</a>';
			$WebsiteLink = '&nbsp;|&nbsp;<a href="'.$values['Website'].'" class="view_white_link" target="_blank">'.GO_TO_WEBSITE.'</a>';
		}else{
			$StoreLink = '';
			$WebsiteLink = '';
		}
		
		$SendEmail = '<input  class="button" type="button" name="SendSubmit'.$i.'" value="'.CONTACT_NOW.'" alt="'.CONTACT_NOW.'" title="'.CONTACT_NOW.'" onclick="location.href=\''.$ContactLink.'\';" />';
		
		
		*/
	$AddToCart = '&nbsp;';
	if($values['Quantity']>0){
		$AddToCart = '<a href="'.$CartLink.'" class="addtocart">Add to Cart</a>';
	}else{
		$AddToCart = OUT_OF_STOCK;
	}
		
		
		
				
		
		




		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=80&h=80'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			//$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
			//$EnlargeImage = '';
		}
		
		
		

		

		
		
			echo '<td align=center valign="top" class="hotproductsbg" >
				   <table width="95%" border="0" cellspacing="0" cellpadding="0" align=center>
						 <tr>
						<td height=5 ></td>
						</tr>
						
						 <tr>
						<td align=center height=25>'.ucfirst(stripslashes($values['Name'])).'</td>
						</tr>
						
						 <tr>
						<td height=5 ></td>
						</tr>
						<tr>
						<td align=center height="80"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">
						<a href="'.$PrdLink.'" >'.$ImagePath.'</a>
					
						</td>
						</tr>
						
						 <tr>
						<td height=5 ></td>
						</tr>
						 <tr>
						<td align=center ><b>'.display_price($PriceFinal,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).'</b></td>
						</tr>
						 <tr>
						<td><a href="'.$PrdLink.'" class="details">Details &raquo;</a></td>
						</tr>
						<tr>
						<td>'.$AddToCart.'</td>
						</tr>
						
				   </table>
			    </td>';
		
						
		if($i%4==0)  echo '</tr><tr>';	
		
		else echo '<td class="width5px"></td>';	
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>


			
			</td>
          </tr>
		  
		 
			
			
			
			
			
			
			
			
			
		  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt"  align="center">
			<? echo NO_PRODUCT_FOUND; ?>
			</td>
			</tr>
			 <? } ?>
			 
</table>