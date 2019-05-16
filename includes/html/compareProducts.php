<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td  height="32" align="left" valign="middle" class="pagenav">
		<span ><?=$Nav_Home?>  <a href="Javascript:window.history.go(-1)"><?=SEARCH_PRODUCTS?></a> </span> <?=COMPARE_SELECTED_PRODUCTS?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading">
		<?=COMPARE_SELECTED_PRODUCTS?>
			</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32">
		
<table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr ><td>

<?  
	
	
	if($num>0 ) { 
 /*
   $i=0;
   
  foreach($arryProduct as $key=>$values){
   $i++;
		$PrdLink   = $Config['StorePrefix'].$values['UserName'].'/productDetails.php?id='.$values['ProductID'];
		$CartLink  = 'products.php?id='.$values['ProductID'].'&Price='.round($values['Price'],2);
		$ContactLink = 'send-email.php?cmp='.$values['PostedByID'];
		$ReviewLink = 'review.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		

		if(!empty($values['UserName'])){
			$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';

			$StoreLink = '<li><a href="'.$StoreLink.'" class="gallery_link">'.GO_TO_STORE.'</a></li>';
			$WebsiteLink = '<li><a href="'.$values['Website'].'" class="gallery_link" target="_blank">'.GO_TO_WEBSITE.'</a></li>';
		}else{
			$StoreLink = '';
			$WebsiteLink = '';
		}




		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=90&h=84'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
		}else{
			$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="90" height="84"/>';
		}
		
		
		if($i!=$num)		
			$MainDivClass = 'compare_box';
		else 
			$MainDivClass = 'compare_boxnew';
		
		echo '<div class="'.$MainDivClass .'">';
		
		echo '<div>'.stripslashes($values['Name']).'</div>
		<div class="feature1">'.$ImagePath.'</div>
		</div>';
			
	 } 

	 */


	 ?>
	 
	   

		

			
		</td>	
          </tr>
		  
	
			 
			
			
			
			
			<tr>
            <td align="left" class="graybox" >
			<?=VIEW_DETAILS?>
			</td>
			</tr>
			
			<tr>
            <td align="left" valign="top" >
			
			
<table width="100%" border="0" cellspacing="1" cellpadding="4" class="generaltxt_inner" bgcolor="#CCCCCC" >
  <tr>
    <td align="left" width="25%" valign="top" bgcolor="#FFFFFF" height="30">&nbsp;</td>
    <td align="center" width="25%" valign="top" bgcolor="#FFFFFF" class="greentxt"><a href="<?=$Config['StorePrefix'].$arryProduct[0]['UserName'].'/productDetails.php?id='.$arryProduct[0]['ProductID']?>"><strong><?=stripslashes($arryProduct[0]['Name'])?></strong></a>

<?
	if($arryProduct[0]['Image'] !='' && file_exists('upload/products/'.$arryProduct[0]['Image']) ){  
		$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[0]['Image'].'&w=90&h=84'; 
	
		$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($arryProduct[0]['Name']).'" title="'.stripslashes($arryProduct[0]['Name']).'"/>';
		//$ImagePath = '<a href="upload/products/'.$arryProduct[0]['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
	}else{
		$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="90" height="84"/>';
	}
		
	$PrdLink   = $Config['StorePrefix'].$arryProduct[0]['UserName'].'/productDetails.php?id='.$arryProduct[0]['ProductID'];
	$ImagePath = '<a href="'.$PrdLink .'" >'.$ImagePath.'</a>';
	
	echo '<div class="feature1">'.$ImagePath.'</div>';
?>





	</td>
    <td align="center" width="25%" valign="top" bgcolor="#FFFFFF" class="greentxt"><a href="<?=$Config['StorePrefix'].$arryProduct[1]['UserName'].'/productDetails.php?id='.$arryProduct[1]['ProductID']?>"><strong><?=stripslashes($arryProduct[1]['Name'])?></strong></a>
	
<?
	if($arryProduct[1]['Image'] !='' && file_exists('upload/products/'.$arryProduct[1]['Image']) ){  
		$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[1]['Image'].'&w=90&h=84'; 
	
		$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($arryProduct[1]['Name']).'" title="'.stripslashes($arryProduct[1]['Name']).'"/>';
		//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$arryProduct[1]['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
		//$ImagePath = '<a href="upload/products/'.$arryProduct[1]['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
	}else{
		$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="90" height="84"/>';
	}
	
	$PrdLink   = $Config['StorePrefix'].$arryProduct[1]['UserName'].'/productDetails.php?id='.$arryProduct[1]['ProductID'];
	$ImagePath = '<a href="'.$PrdLink .'" >'.$ImagePath.'</a>';
	
	echo '<div class="feature1">'.$ImagePath.'</div>';
?>	
	
	
	
	</td>
<? if(!empty($arryProduct[2]['Name'])){?>
<td align="center" width="25%" valign="top" bgcolor="#FFFFFF" class="greentxt"><a href="<?=$Config['StorePrefix'].$arryProduct[2]['UserName'].'/productDetails.php?id='.$arryProduct[2]['ProductID']?>"><strong><?=stripslashes($arryProduct[2]['Name'])?></strong></a>

<?
	if($arryProduct[2]['Image'] !='' && file_exists('upload/products/'.$arryProduct[2]['Image']) ){  
		$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[2]['Image'].'&w=90&h=84'; 
	
		$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($arryProduct[2]['Name']).'" title="'.stripslashes($arryProduct[2]['Name']).'"/>';
		//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$arryProduct[2]['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
		//$ImagePath = '<a href="upload/products/'.$arryProduct[2]['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
	}else{
		$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="90" height="84"/>';
	}
	
	
	$PrdLink   = $Config['StorePrefix'].$arryProduct[2]['UserName'].'/productDetails.php?id='.$arryProduct[2]['ProductID'];
	$ImagePath = '<a href="'.$PrdLink .'" >'.$ImagePath.'</a>';
	echo '<div class="feature1">'.$ImagePath.'</div>';
?>	




</td>
<? } ?>

<? if(!empty($arryProduct[3]['Name'])){?>
 <td align="center" width="25%" valign="top" bgcolor="#FFFFFF" class="greentxt"><a href="<?=$Config['StorePrefix'].$arryProduct[3]['UserName'].'/productDetails.php?id='.$arryProduct[3]['ProductID']?>"><strong><?=stripslashes($arryProduct[3]['Name'])?></strong></a>
 
<?
	if($arryProduct[3]['Image'] !='' && file_exists('upload/products/'.$arryProduct[3]['Image']) ){  
		$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[3]['Image'].'&w=90&h=84'; 
	
		$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($arryProduct[3]['Name']).'" title="'.stripslashes($arryProduct[3]['Name']).'"/>';
		//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$arryProduct[3]['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
		//$ImagePath = '<a href="upload/products/'.$arryProduct[3]['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
	}else{
		$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="90" height="84"/>';
	}
	
	$PrdLink   = $Config['StorePrefix'].$arryProduct[3]['UserName'].'/productDetails.php?id='.$arryProduct[3]['ProductID'];
	$ImagePath = '<a href="'.$PrdLink .'" >'.$ImagePath.'</a>';
	
	echo '<div class="feature1">'.$ImagePath.'</div>';
?>	 
 
 
 </td>
<? } ?>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=PRICE?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF">
		<? if($arryProduct[0]['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
		}else if($arryProduct[0]['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = 'bid.php?mId='.$arryProduct[0]['PostedByID'].'&pId='.$arryProduct[0]['ProductID'];
		}else if($arryProduct[0]['Bidding']=='Classified'){
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}
		$i = 1;
		echo '<a href="'.$BidLink.'"><img src="images_small/'.$arryProduct[0]['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$arryProduct[0]['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$arryProduct[0]['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>';
		
		if($arryProduct[0]['Bidding']=='Fixed'){
			echo '<span class="red12">&nbsp;'.number_format($arryProduct[0]['Price'],2,'.','').' '.$Config['Currency']. '</span>';
		}
		?>	</td>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<? if($arryProduct[1]['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
		}else if($arryProduct[1]['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = 'bid.php?mId='.$arryProduct[1]['PostedByID'].'&pId='.$arryProduct[1]['ProductID'];
		}else if($arryProduct[1]['Bidding']=='Classified'){
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}
		$i = 2;
		echo '<a href="'.$BidLink.'"><img src="images_small/'.$arryProduct[1]['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$arryProduct[1]['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$arryProduct[1]['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>';
		
		if($arryProduct[1]['Bidding']=='Fixed'){
			echo '<span class="red12">&nbsp;'.number_format($arryProduct[1]['Price'],2,'.','').' '.$Config['Currency']. '</span>';
		}
		?>	</td>
		
		
<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><? if($arryProduct[2]['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
		}else if($arryProduct[2]['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = 'bid.php?mId='.$arryProduct[2]['PostedByID'].'&pId='.$arryProduct[2]['ProductID'];
		}else if($arryProduct[2]['Bidding']=='Classified'){
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}
		$i = 3;
		echo '<a href="'.$BidLink.'"><img src="images_small/'.$arryProduct[2]['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$arryProduct[2]['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$arryProduct[2]['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>';
		
		if($arryProduct[2]['Bidding']=='Fixed'){
			echo '<span class="red12">&nbsp;'.number_format($arryProduct[2]['Price'],2,'.','').' '.$Config['Currency']. '</span>';
		}
		?></td>
<? } ?>


<? if(!empty($arryProduct[3]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><? if($arryProduct[3]['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
		}else if($arryProduct[3]['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = 'bid.php?mId='.$arryProduct[3]['PostedByID'].'&pId='.$arryProduct[3]['ProductID'];
		}else if($arryProduct[3]['Bidding']=='Classified'){
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}
		$i = 4;
		echo '<a href="'.$BidLink.'"><img src="images_small/'.$arryProduct[3]['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$arryProduct[3]['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$arryProduct[3]['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>';
		
		if($arryProduct[3]['Bidding']=='Fixed'){
			echo '<span class="red12">&nbsp;'.number_format($arryProduct[3]['Price'],2,'.','').' '.$Config['Currency']. '</span>';
		}
	?></td>
<? } ?>	
  </tr>
 
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=CREDIT_CARD?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<?
	$ToolTipMSG = ($arryProduct[0]['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
	$i=11;
	echo '<a href="#"><img src="images_small/Credit'.$arryProduct[0]['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$arryProduct[0]['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$arryProduct[0]['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a>';
	?>
	</td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?
	$ToolTipMSG = ($arryProduct[1]['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
	$i=12;
	echo '<a href="#"><img src="images_small/Credit'.$arryProduct[1]['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$arryProduct[1]['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$arryProduct[1]['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a>';
	?></td>
	
	<? if(!empty($arryProduct[2]['Name'])){?>

    <td align="left" valign="top" bgcolor="#FFFFFF"><?
	$ToolTipMSG = ($arryProduct[2]['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
	$i=13;
	echo '<a href="#"><img src="images_small/Credit'.$arryProduct[2]['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$arryProduct[2]['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$arryProduct[2]['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a>';
	?></td>
	<? } ?>
	
	<? if(!empty($arryProduct[3]['Name'])){?>

    <td align="left" valign="top" bgcolor="#FFFFFF"><?
	$ToolTipMSG = ($arryProduct[3]['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
	$i=14;
	echo '<a href="#"><img src="images_small/Credit'.$arryProduct[3]['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$arryProduct[3]['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$arryProduct[3]['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a>';
	?></td>
	<? } ?>
  </tr> 
  
   <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=STORE_RATING?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<?
	echo $RatingHTML = getRatingOrangeHTML($arryProduct[0]['Ranking'],$arryTotalRanking[0]['TotalRanks']); 
	?>	</td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?
	echo $RatingHTML = getRatingOrangeHTML($arryProduct[1]['Ranking'],$arryTotalRanking[0]['TotalRanks']); 
	?></td>

	<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?
	echo $RatingHTML = getRatingOrangeHTML($arryProduct[2]['Ranking'],$arryTotalRanking[0]['TotalRanks']); 
	?></td>
	<? } ?>
	
	<? if(!empty($arryProduct[3]['Name'])){?>

    <td align="left" valign="top" bgcolor="#FFFFFF"><?
	echo $RatingHTML = getRatingOrangeHTML($arryProduct[3]['Ranking'],$arryTotalRanking[0]['TotalRanks']); 
	?></td>
	<? } ?>
  </tr>
  
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=STATE?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[0]['State'])?></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[1]['State'])?></td>
	<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[2]['State'])?></td>
	<? } ?>
	<? if(!empty($arryProduct[3]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[3]['State'])?></td>
	<? } ?>
  </tr> 
<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=COUNTRY_TERRITORY?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[0]['Country'])?></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[1]['Country'])?></td>
	<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[2]['Country'])?></td>
	<? } ?>
	<? if(!empty($arryProduct[3]['Name'])){?>
	   <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[3]['Country'])?></td>
	 <? } ?>  
  </tr>
  
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=PRODUCT_URL?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF" nowrap="nowrap" class="skytxt">
	<?
	$PrdLink   = $Config['StorePrefix'].$arryProduct[0]['UserName'].'/productDetails.php?id='.$arryProduct[0]['ProductID'];
	echo '<a href="'.$PrdLink.'" >'.VIEW_PRODUCT.'</a>';
	?></td>
    <td align="left" valign="top" bgcolor="#FFFFFF" nowrap="nowrap" class="skytxt">
	<?
	$PrdLink   = $Config['StorePrefix'].$arryProduct[1]['UserName'].'/productDetails.php?id='.$arryProduct[1]['ProductID'];
	echo '<a href="'.$PrdLink.'" >'.VIEW_PRODUCT.'</a>';
	?>
	</td>

	<? if(!empty($arryProduct[2]['Name'])){?>
	
    <td align="left" valign="top" bgcolor="#FFFFFF" nowrap="nowrap" class="skytxt">
	<?
	$PrdLink   = $Config['StorePrefix'].$arryProduct[2]['UserName'].'/productDetails.php?id='.$arryProduct[2]['ProductID'];
	echo '<a href="'.$PrdLink.'" >'.VIEW_PRODUCT.'</a>';
	?>	
	</td>
	<? } ?>
	
	<? if(!empty($arryProduct[3]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF" nowrap="nowrap" class="skytxt">
	<?
	$PrdLink   = $Config['StorePrefix'].$arryProduct[3]['UserName'].'/productDetails.php?id='.$arryProduct[3]['ProductID'];
	echo '<a href="'.$PrdLink.'" >'.VIEW_PRODUCT.'</a>';
	?>	
	</td>
	<? } ?>
	
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=STORE_URL?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="skytxt" nowrap="nowrap">
	<?	
	$StoreLink = $Config['StorePrefix'].$arryProduct[0]['UserName'].'/store.php';
	echo '<a href="'.$StoreLink.'">'.GO_TO_STORE.'</a>';
	?>	
	</td>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="skytxt" nowrap="nowrap">
	<?	
	$StoreLink = $Config['StorePrefix'].$arryProduct[1]['UserName'].'/store.php';
	echo '<a href="'.$StoreLink.'">'.GO_TO_STORE.'</a>';
	?>	
	</td>
<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="skytxt" nowrap="nowrap">
	<?	
	$StoreLink = $Config['StorePrefix'].$arryProduct[2]['UserName'].'/store.php';
	echo '<a href="'.$StoreLink.'">'.GO_TO_STORE.'</a>';
	?>	
	</td>
<? } ?>	

<? if(!empty($arryProduct[3]['Name'])){?>
	
    <td align="left" valign="top" bgcolor="#FFFFFF" class="skytxt" nowrap="nowrap">
	<?	
	$StoreLink = $Config['StorePrefix'].$arryProduct[3]['UserName'].'/store.php';
	echo '<a href="'.$StoreLink.'">'.GO_TO_STORE.'</a>';
	?>	
	</td>
<? } ?>	
  </tr>  
  
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=DESCRIPTION?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[0]['Detail'])?></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[1]['Detail'])?></td>
<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[2]['Detail'])?></td>
 <? } ?>
 <? if(!empty($arryProduct[3]['Name'])){?>

    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[3]['Detail'])?></td>
<? }?>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><strong><?=FEATURES?></strong></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[0]['Features'])?></td>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[1]['Features'])?></td>
<? if(!empty($arryProduct[2]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[2]['Features'])?></td>
<? } ?>
<? if(!empty($arryProduct[3]['Name'])){?>
    <td align="left" valign="top" bgcolor="#FFFFFF"><?=stripslashes($arryProduct[3]['Features'])?></td>
<? } ?>
  </tr>
 
  
</table>
	
			
			</td>
			</tr>	
			
				  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt" height="250"align="center">
			<? echo NO_PRODUCT_FOUND; ?>
			</td>
			</tr>
			 <? } ?>
			 
</table>
		
		</td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>

