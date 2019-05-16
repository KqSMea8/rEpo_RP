 <div id="view_gallery_box">
<table border="0" cellpadding="0" cellspacing="0">


<?  if($num>0 ) { 
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	
	
	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");


	
?>  

		  
          <tr >
           
			
 <? 
   
	//$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

 
   $i=0;
   
  foreach($arryProduct as $key=>$values){
   $i++;
		$PrdLink   = $Config['StorePrefix'].$values['UserName'].'/productDetails.php?id='.$values['ProductID'];
		$CartLink  = 'products.php?id='.$values['ProductID'].'&Price='.round($values['Price'],2);
		$ContactLink = 'send-email.php?cmp='.$values['PostedByID'];
		$ReviewLink = 'review.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		

		/************  Calculate Rating ***************/
		//$RatingHTML = getRatingHTML($values['Ranking'],$arryTotalRanking[0]['TotalRanks']);
		/************  Calculate Rating ***************/

		if(!empty($values['UserName'])){
			$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';
			$WebsiteLink = $Config['StorePrefix'].$values['UserName'].'/home.php';

			$StoreLink = '<li><a href="'.$StoreLink.'" class="gallery_link">'.GO_TO_STORE.'</a></li>';
			

			if($values['WebsiteStoreOption']=='ws'){
				$WebsiteLink = '<li><a href="'.$WebsiteLink.'" class="gallery_link" >'.GO_TO_WEBSITE.'</a></li>';
			}else{
				$WebsiteLink = '';
			}
		}else{
			$StoreLink = '';
			$WebsiteLink = '';
		}




		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			//imageThumb('upload/products/'.$values['Image'],'upload/products/thumb/'.$values['Image'],100,84);
			//$ImagePath = 'upload/products/thumb/'.$values['Image']; 
			
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=90&h=84'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
			//$ImagePath = '<a href="upload/products/'.$values['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
			
			
		}else{
			$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="90" height="84"/>';
		}
		
		$ImagePath = '<a href="'.$PrdLink.'" >'.$ImagePath.'</a>';
		
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
		
		if($i>1) { 
			$border_td = 'stories_section';
		}else{
			$border_td = 'stories_section';
		}

		
		
			echo ' <td valign="top" style="border-bottom:1px solid #CCCCCC;">
			<table width="100%" border="0" cellspacing="0" cellpadding="3" >
			
							<tr>
								<td class="bluetxt_head12"  colspan=2 height="25px;" valign=bottom>
								<a href="'.$PrdLink.'" >'.stripslashes($values['Name']).'</a>
								</td>
						</tr>
			
			
						<tr>
						<td height="100"  valign=top>
								'.$ImagePath.'
							</td>
							<td valign=top width="124">
								<ul><li><a href="'.$PrdLink.'" class="gallery_link">'.VIEW_PRODUCT.'</a></li>  
								'.$StoreLink.'
								'.$WebsiteLink.'
								<li><a href="'.$ReviewLink.'" class="gallery_link">'.BUYERS_REVIEWS.'</a></li> 
								</ul>
							
							</td>
						</tr>
						
						
								
						<tr>
								<td align="center" height="10px;" colspan=2>
								</td>
						</tr>
							 
				   </table></td> ';
			  
				
			
			if($i%3==0) echo '</tr><tr >';	
			
					
	 
	 } 
	 
	 ?>
	 
	   



			
			</td>
          </tr>
		  
	<form  name="form5" method="post" action="" onSubmit="return ChangePageLink(this,<?php echo $TotalPage;?>,'<? echo $queryString;?>','<? echo basename($_SERVER['PHP_SELF']);?>');">
		    <tr>
            <td height="60" align="left">&nbsp;
			<?
			if($num>count($arryProduct)){
				echo $pagerLink;
				}
			?>
		
	
			</td>
			</tr>
	</form>		
			
			
			
			
			
			
			
			
			
		  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt" height="250" align="center">
			<? echo NO_PRODUCT_FOUND; ?>
			</td>
			</tr>
			 <? } ?>
			 
</table>
</div>