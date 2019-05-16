<table width="100%" cellpadding="0"  cellspacing="0" border="0">
<tr>
<td align="left" class="header_bg">
<div class="header_txt" >featured products1</div>
  <? if($numPrd>8 && $ShowAllPrd!=1) { ?><a href="featured.php" class="whitetxt_link">View All</a> <? } ?>
  
  </td>
</tr>
<?
		
if($numPrd>0) { 

	
	
	/*
	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");
	*/

	
?>  

		  

           
			
 <? 
   $i=0;
   $ProductHTML='';
   $FeaturedType='';
	 $ProductDisplayed = '';
	 $FeaturedDisabled = '';
   
   
   
  foreach($arryProduct as $key=>$values){
  	
	
	$ShowProduct = 0;
	
  	if($values['FeaturedType'] == 'Impression'){
		if($values['Impression']>0 && ($values['Impression']-$values['ImpressionCount'])>0){
  			$ShowProduct = 1;
		}else{
			$FeaturedDisabled .= $values['ProductID'].',';
		}
	}else if($values['FeaturedType'] == 'Duration'){
		if($values['FeaturedStart'] <= date('Y-m-d') && $values['FeaturedEnd'] >= date('Y-m-d')){
  			$ShowProduct = 1;
		}else{
			$FeaturedDisabled .= $values['ProductID'].',';
		}
	}else{
			$FeaturedDisabled .= $values['ProductID'].',';
	}
  
  	
	if($ShowProduct==1){
		$i++;
		if($i>8 && $ShowAllPrd!=1) break;
		
		$ProductDisplayed .= $values['ProductID'].',';
		$FeaturedType .= $values['FeaturedType'].',';
		
		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=90&h=98'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
			//$ImagePath = '<a href="upload/products/'.$values['Image'].'" rel="lightbox" >'.$ImagePath.'</a>';
			
		}else{
			$ImagePath = '<img src="images/no.jpg"  border="0" class="imgborder_prd"  />';
		}
		
		
		if($i%4==0) { 
			$MainDivClass = 'feature_boxnew';
		}else{
			$MainDivClass = 'feature_box';
		}

		$PrdLink   = $Config['StorePrefix'].$values['UserName'].'/productDetails.php?id='.$values['ProductID'];
		
		$ToolTipMSG = ($values['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
		
		if($values['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
		}else if($values['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = 'bid.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		}else if($values['Bidding']=='Classified'){
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}
	
		$ProductHTML .= '<div class="'.$MainDivClass .'">';
		
		$ProductHTML .=  '<div style="height:16px;overflow:hidden">  '.stripslashes($values['Name']).'</div>
		<div class="feature1"><a href="'.$PrdLink.'">'.$ImagePath.'</a></div>
		<div class="feature2" style="height:14px;overflow:hidden">'.stripslashes($values['Detail']).'</div>
		<div class="feature3"><Div style="float:left"><a href="'.$BidLink.'"><img src="images_small/'.$values['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$values['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$values['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>&nbsp;&nbsp;&nbsp;<a href="#"><img src="images_small/Credit'.$values['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$values['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$values['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a></Div><Div ><a href="'.$PrdLink.'" class="greenviewtxt_link" >View</a></Div>
		</div>';
		
			  
		$RatingHTML = getRatingOrangeHTML($values['Ranking'],$arryTotalRanking[0]['TotalRanks']);
		
		$ProductHTML .=  '<div class="feature4"><table cellpadding=0 celspacing=0 border=0 ><tr><td class="greentxt_headenew" valign=top>'.STORE_RATING.'</td><td>'.$RatingHTML.'</td></tr></table></div>';

		$ProductHTML .=  '</div>';		
		}
	 
	 } 
	 
	 
	/*   update displayed featured Items */ 
	 
	if($ProductDisplayed!=''){
		 $ProductDisplayed = rtrim($ProductDisplayed,",");
		$FeaturedType = rtrim($FeaturedType,",");
		 $objPackage->FeaturedCounter($ProductDisplayed,$FeaturedType,'Product');
	}	 
	
	
	if($FeaturedDisabled!=''){
		 $FeaturedDisabled = rtrim($FeaturedDisabled,",");
		 $objProduct->FeaturedDisabled($FeaturedDisabled);
	}	 
		 
	 
	 ?>
	 

			
		  
   <? } ?>		
 
	   <tr><td height="200" align="center" class="featuretable_border">
	   	 <? if($i<=0 || empty($numPrd)){ ?>	
		<Div class="redtxt"><? echo 'No '.FEATURED_PRODUCTS.' found.'; ?></Div>
		<? }else{ echo $ProductHTML;} ?>
	  </td></tr>
			 

	
</table>
<br>
