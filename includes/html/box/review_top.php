<table border="0" cellspacing="4" cellpadding="2" >
  <tr>
    <? if(sizeof($arryProduct)>0){ 
			echo '<td class="graybox">Product</td>';
		}
	?> 

	 <? if(sizeof($arryMember)>0){ 
			echo '<td class="graybox">Store</td>';
		}
	?> 
	

  </tr>
  <tr>
   <? if(sizeof($arryProduct)>0){ 
   
   			$PrdLink   = $Config['StorePrefix'].$arryMember[0]['UserName'].'/productDetails.php?id='.$arryProduct[0]['ProductID'];

   
   
			if($arryProduct[0]['Image'] !='' && file_exists('upload/products/'.$arryProduct[0]['Image']) ){  
			
						$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[0]['Image'].'&w=90&h=98'; 
			
						//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$arryProduct[0]['Image'].'\', 150, 100, \'no\' );" href="#"><img src="'.$ImagePath.'"  border="0" /></a>';
						$ImagePath = '<a href="'.$PrdLink.'" ><img src="'.$ImagePath.'"  border="0" /></a>';
			
						$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$arryProduct[0]['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
				}else{
						$ImagePath = '<div class="probox_inner1"><a href="'.$PrdLink.'" ><img src="store_images/no-image.jpg" border="0"  /></a></div>';
						$EnlargeImage = '&nbsp;';
			
				}
	  
	  

			
		if($arryProduct[0]['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$BidLink = '#';
			
		}else if($arryProduct[0]['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$BidLink = 'bid.php?mId='.$arryProduct[0]['PostedByID'].'&pId='.$arryProduct[0]['ProductID'];
		}else{
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$BidLink = '#';
		}			
			
			
			
			
			
			echo '<td class="outline" valign="top"><div class="feature_boxnew">';
			echo '<div style="height:16px;overflow:hidden">'.stripslashes($arryProduct[0]['Name']).'</div>
			<div class="feature1">'.$ImagePath.'</div>
			<div class="feature3"><Div style="float:left"><a href="'.$BidLink.'"><img src="images_small/'.$arryProduct[0]['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$arryProduct[0]['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$arryProduct[0]['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>&nbsp;&nbsp;&nbsp;</Div><Div ><a href="'.$PrdLink.'" class="greenviewtxt_link" >View</a></Div>
			</div>';
			echo '</div></td>';	   			

   	  }
	 ?>
    
	<? 



	if(sizeof($arryMember)>0){ 

		$StoreLink = $Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';

		if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/company/'.$arryMember[0]['Image'].'&w=90&h=98'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" alt="'.stripslashes($arryMember[0]['Name']).'" title="'.stripslashes($arryMember[0]['Name']).'"/>';
			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/company/'.$arryMember[0]['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
		}else{
			$ImagePath = '<img src="images/no.jpg"  border="0" class="imgborder_prd" />';
		}



		$ToolTipMSG = ($values['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);

		echo ' <td class="outline" valign="top"><div class="feature_boxnew">';
		echo '<div style="height:16px;overflow:hidden">'.stripslashes($arryMember[0]['CompanyName']).'</div>
		<div class="feature1"><a href="'.$StoreLink.'" >'.$ImagePath.'</a></div>
		<div class="feature3"><Div style="float:left"><a href="#"><img src="images_small/Credit'.$arryMember[0]['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$arryMember[0]['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$arryMember[0]['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a></Div><Div ><a href="'.$StoreLink.'" class="greenviewtxt_link" >View</a></Div>
		</div>';
		//echo $arryMember[0]['Ranking'].'-'.$arryTotalRanking[0]['TotalRanks'];
		$RatingHTML = getRatingOrangeHTML($arryMember[0]['Ranking'],$arryTotalRanking[0]['TotalRanks']);

		echo '<div class="feature4"><table cellpadding=0 celspacing=0 border=0 ><tr><td class="greentxt_headenew" valign=top>'.STORE_RATING.'</td><td>'.$RatingHTML.'</td></tr></table></div>';
		echo '</div></td>';		  
	  
	  }
	  
	  
	  ?>
	
	
	
  </tr>
</table>
