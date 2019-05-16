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
            <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0"  align="center" >
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
			$PriceFinal = $Price;
		} 
   
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'].$StoreSuffix;
		$CartLink  = 'cart.php?ProductID='.$values['ProductID'].'&Price='.round($Price,2).'&StoreID='.$values['PostedByID'].'&Tax='.round($Tax,2);
		
		
		/*
		
		$ContactLink = 'send-email.php?cmp='.$values['PostedByID'];
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
		
	if($arrayConfig[0]['CartStatus'] == 1){
		if($values['Quantity']>0){
				$AddToCart = '<input  class="button" type="button" name="Submit'.$i.'" value="'.ADD_TO_CART.'" alt="'.ADD_TO_CART.'" title="'.ADD_TO_CART.'" onclick="location.href=\''.$CartLink.'\';" />';
			}else{
				$AddToCart = OUT_OF_STOCK;
			}
		}else{
			$AddToCart = '&nbsp;';
		}
		
		
		$SendEmail = '<input  class="button" type="button" name="SendSubmit'.$i.'" value="'.CONTACT_NOW.'" alt="'.CONTACT_NOW.'" title="'.CONTACT_NOW.'" onclick="location.href=\''.$ContactLink.'\';" />';
				
		
		*/




		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=160&h=160'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			//$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
			//$EnlargeImage = '';
		}
		
		
		

		

		
		
			echo '<td align=center valign="top" width="33%">
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" align=center>
						<tr>
						<td align=center height="160"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">
						<a href="'.$PrdLink.'" >'.$ImagePath.'</a>
					
						</td>
						</tr>
						 <tr>
						<td align=center >'.ucfirst(stripslashes($values['Name'])).'</td>
						</tr>
						 <tr>
						<td align=center class="subtotalbig">'.display_price($PriceFinal,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).'</td>
						</tr>
					 <tr>
						<td height=15 ></td>
						</tr>
				   </table>
			    </td>';
				
		if($i%3==0)  echo '</tr><tr>';		
	 
	 } 
	 
	 ?>
	 
	   </tr>
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