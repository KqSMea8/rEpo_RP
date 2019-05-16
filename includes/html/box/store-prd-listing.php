<?
			
if($num>0 ) { 



	//$RecordsPerPage = 1;
	
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
   
  foreach($arryProduct as $key=>$values){
   $i++;
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'].'&cat='.$_GET['cat'].'&Parent='.$_GET['Parent'].'&store_cat='.$_GET['store_cat'];
		
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
			$ImagePath = '../resizeimage.php?img=upload/products/'.$values['Image'].'&w=100&h=100'; 
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
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
		}else if($values['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = $Config['Url'].'bid.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		}else{
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}
		
		
		$k = $Icon_Prefix.$i;	

			echo '<div class="probox">
				<div class="probox_inner1"><a href="'.$PrdLink.'" >'.$ImagePath.'</a></div>
				<div class="probox_inner4" style="height:25px;overflow:hidden">'.stripslashes($values['Name']).'</div>
				<div class="probox_inner3"><Div style="float:left"><a href="'.$BidLink.'"><img src="'.$Config['Url'].'images_small/'.$values['Bidding'].'1.png" border="0" id="iconprd'.$k.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\''.$Config['Url'].'images_small/'.$values['Bidding'].'2.png\',\'iconprd'.$k.'\')"; onMouseout="hideddrivetip(\''.$Config['Url'].'images_small/'.$values['Bidding'].'1.png\',\'iconprd'.$k.'\')" /></a>&nbsp;&nbsp;<a href="#"><img src="'.$Config['Url'].'images_small/Credit'.$arrayStore[0]['CreditCard'].'1.png" border="0" id="iconstr'.$k.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\''.$Config['Url'].'images_small/Credit'.$arrayStore[0]['CreditCard'].'2.png\',\'iconstr'.$k.'\')"; onMouseout="hideddrivetip(\''.$Config['Url'].'images_small/Credit'.$arrayStore[0]['CreditCard'].'1.png\',\'iconstr'.$k.'\')" /></a></Div><Div ><a href="'.$PrdLink.'" class="view_link">view</a></Div>
				
				<div class="clearfix"></div></div>
				</div>';

	 
	 } 
	 
			
			
			
	if($num>count($arryProduct)){
		if($ThisPage!='store.php'){ 
			echo '<div class="clearfix"></div><div align="center">'.$pagerLink.'</div>'; 
		}
	}
				
				
			
		  
 } else{ ?>			
		<div class="generaltxt" align="center">
			<strong><? echo NO_PRODUCT_FOUND; ?></strong>
		</div>
			
 <? } ?>
			 
