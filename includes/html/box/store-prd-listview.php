 <form action=""  method="post" name="form1" id="form1" onsubmit="return validate(this);">
<?
			
if($num>0 ) { 

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
	
	
	<input name="Submit33" type="image" src="<?=$TemplateFolder?>images/basket.png" style="float:right" atl=" Buy Now " />	</td>
  </tr>
  <tr>
      <td valign="top" height="10"></td>
    </tr>
   <tr>
    <td valign="top">
	

<?

	$RecordsPerPage = 100;
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	
	
	
	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");


	
?>  

		  

 <? 
   
	$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

	$ToolTipMSG = ($arrayStore[0]['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
	
   $i=0;
   $Count = 0;
  foreach($arryProduct as $key=>$values){
   $i++;
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'].'&cat='.$_GET['cat'];
		$CartLink  = 'products.php?id='.$values['ProductID'].'&Price='.round($values['Price'],2);
		$ContactLink = 'send-email.php?cmp='.$values['PostedByID'];
		$ReviewLink = 'review.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		


		if(!empty($values['UserName'])){
			//$StoreLink = 'view-company.php?view='.$values['PostedByID'];
			$StoreLink = 'st/'.$values['UserName'];
			$StoreLink = '&nbsp;|&nbsp; <a href="'.$StoreLink.'" class="view_white_link">'.GO_TO_STORE.'</a>';
			$WebsiteLink = '&nbsp;|&nbsp;<a href="'.$values['Website'].'" class="view_white_link" target="_blank">'.GO_TO_WEBSITE.'</a>';
		}else{
			$StoreLink = '';
			$WebsiteLink = '';
		}




		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			//imageThumb('upload/products/'.$values['Image'],'upload/products/thumb/'.$values['Image'],100,100);
			//$ImagePath = 'upload/products/thumb/'.$values['Image']; 
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=100&h=100'; 
			//$ImagePath = '<a onclick="OpenNewPopUp(\''.$Config['Url'].'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt><img src="'.$ImagePath.'"  border="0" /></a>';
			
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"  />';
		}else{
			$ImagePath = $NoImageUrl;
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
		
		
		if($values['Bidding']=='Fixed'){
		 	$Count++;
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';

			$PriceHTML = '<table cellpadding=0 cellspacing=0>';
			
			$TaxPer = ($values['TaxExempt']!=1)?($_SESSION['VatPercentage']):("");


			$PriceHTML .= '<tr><td valign=top  class="generaltxt" align="left"><b>'.PRICE.':</b></td><td valign=top  class="generaltxt" >'.display_price($values['Price'], $TaxPer,$_SESSION['TaxType'], $arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).'</td></tr>';
			
			if(!empty($_SESSION['VatPercentage']) && $values['TaxExempt']!=1 ){
				$Tax = ($values['Price'] * $_SESSION['VatPercentage'])/100;
				$PriceFinal = $values['Price']+$Tax;
			}else{
				$Tax = 0;
				$PriceFinal = $values['Price'];
			}

			$PriceHTML .= '<tr><td valign=top  class="generaltxt" align="left"><b>'.QUANTITY.':</b></td><td valign=top   ><input name="Quantity'.$Count.'"  id="Quantity'.$Count.'" type="text" class="txt-feild" size="5" maxlength="5" value="1" style="width:30px;" /><input name="AvailableQuantity'.$Count.'"  id="AvailableQuantity'.$Count.'" value="'.$values['Quantity'].'" type="hidden" /><input name="Price'.$Count.'"  id="Price'.$Count.'" value="'.number_format($values['Price'],2,'.','').'" type="hidden" /><input name="Tax'.$Count.'"  id="Tax'.$Count.'" value="'.number_format($Tax,2,'.','').'" type="hidden" /></td></tr>';

			$PriceHTML .= '</table>';

			
		$PriceCheckbox = '<input type="checkbox" name="AddCart'.$Count.'" id="AddCart'.$Count.'" value="'.$values['ProductID'].'" />';
		
		}else if($values['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = $Config['Url'].'bid.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
			$PriceHTML = '';
			$PriceCheckbox = '';
		}else{
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
			$PriceHTML = '';
			$PriceCheckbox = '';
		}
		
		
		$k = $Icon_Prefix.$i;	

		$BiddingHtml = '<a href="'.$BidLink.'"><img src="'.$Config['Url'].'images_small/'.$values['Bidding'].'1.png" border="0" id="iconprd'.$k.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\''.$Config['Url'].'images_small/'.$values['Bidding'].'2.png\',\'iconprd'.$k.'\')"; onMouseout="hideddrivetip(\''.$Config['Url'].'images_small/'.$values['Bidding'].'1.png\',\'iconprd'.$k.'\')" /></a>&nbsp;&nbsp;<a href="#"><img src="'.$Config['Url'].'images_small/Credit'.$arrayStore[0]['CreditCard'].'1.png" border="0" id="iconstr'.$k.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\''.$Config['Url'].'images_small/Credit'.$arrayStore[0]['CreditCard'].'2.png\',\'iconstr'.$k.'\')"; onMouseout="hideddrivetip(\''.$Config['Url'].'images_small/Credit'.$arrayStore[0]['CreditCard'].'1.png\',\'iconstr'.$k.'\')" /></a>';

			/*
			echo '<div class="probox_inner3" style="width:100%;height:100px; text-align:left;padding-left:6px;margin-top:12px;" >
				
				<div class="probox_inner4" style="width:90%;text-align:left;float:left;">
				'.$PriceCheckbox.'
				'.stripslashes($values['Name']).'</div><div class="clearfix"></div>
				
				<Div style="width:70%; text-align:left;float:left;">
				
				<Div><br><a href="'.$PrdLink.'" class="view_link" style="text-align:left;float:left">view</a></Div>
				<br><br>
				'.$BiddingHtml.'
				
				</Div> 
				<Div style="float:left;">
				'.$PriceHTML.'
				</Div>';
				
				
			echo '</div><div class="clearfix"></div>';
			*/


		echo '<div class="probox_inner3" style="width:100%;height:64px; text-align:left;" >';
		
		echo '<table width="100%" border="0" cellpadding="2" cellspacing="0"><tr>';
			  
		echo  '<td width="65%">';
		
		
			echo '<table width="100%" cellpadding=2 cellspacing=0 border="0">';
		
			echo '<tr><td width="2%" valign="top">'.$PriceCheckbox.'</td>';
			echo '<td colspan=2>
				<div class="probox_inner4" style="text-align:left;margin-left:0px;width:220px;">'.stripslashes($values['Name']).'</div>
				</td>';
			echo '</tr>';
			
			echo '<tr><td ></td>';
			echo '<td valign="top" width="10"><a href="'.$PrdLink.'" class="view_link" style="text-align:left;float:left;Style="width:3px;">view</a></td><td>'.$BiddingHtml.'</td>';
			echo '</tr>';
			echo '</table>';
		
		echo '</td><td>'.$PriceHTML.'</td>';
		
		echo '</tr></table>';
		echo '</div><div class="clearfix"></div>';
	 
	 } 
	 
			
	 echo '<input type="hidden" name="numPriceProduct" id="numPriceProduct" value="'.$Count.'" />';	
	 echo  '<input type="hidden" name="MemberID" id="MemberID" value="'.$MemberID.'" />';
	
	?>	</td>
  </tr>
    <tr>
      <td valign="top" height="10"></td>
    </tr>
    <tr>
    <td valign="top"><input name="Submit" type="image" src="<?=$TemplateFolder?>images/basket.png" style="float:right" atl=" Buy Now " />	</td>
  </tr>
  
   <tr>
    <td><? if($num>count($arryProduct)){
			echo '<div class="clearfix"></div><div align="center">'.$pagerLink.'</div>'; 
	} ?></td>
  </tr>
</table>		
		  
<? } else{ ?>			
		<div class="red12">
			<? echo NO_PRODUCT_FOUND; ?>
		</div>
			
 <? } ?>
			 
</form>