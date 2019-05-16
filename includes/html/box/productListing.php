<Div id="MainResultTable">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >

<!--
<tr>
<td  height="15" align="right">
	<? if(empty($_GET['ch'])) { ?>
	<a href="Javascript:window.history.go(-1)" class="greentxt_link"><?=GO_BACK?></a>
	<? } ?>
</td>
</tr>
-->	

<?
			
if($num>0 ) { 

	

	/*****************  Setting Urls ***********************/
	
	
	$arryServerVar=$_SERVER;
	
	
	$queryString  = str_replace('curP='.$_GET['curP'].'&','', $arryServerVar['QUERY_STRING']);
	
	$PhotoShowTopUrl  = str_replace('&OnlyPhotoTop=1','', $arryServerVar['QUERY_STRING']);
	$PhotoShowTopUrl  = str_replace('#BtPrdDv','', $PhotoShowTopUrl);
	$PhotoShowTopUrl  = $ThisPage.'?'.$PhotoShowTopUrl;
	


	$PhotoShowBottomUrl  = str_replace('&OnlyPhotoBottom=1','', $arryServerVar['QUERY_STRING']);
	$PhotoShowBottomUrl  = str_replace('#BtPrdDv','', $PhotoShowBottomUrl);
	$PhotoShowBottomUrl  = $ThisPage.'?'.$PhotoShowBottomUrl;
	
	
	/******************* Paging *********************/
	$RecordsPerPage=15;
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
	
	
	
	$pagerLink2  = str_replace('pagenumber_link','blacktxt_link', $pagerLink);
	$pagerLink2  = str_replace('pagenumber_sel','blacktxt_link_sel', $pagerLink2);
	$pagerLink2  = str_replace('&#8249 Previous','', $pagerLink2);
	$pagerLink2  = str_replace('Next &#8250; ','', $pagerLink2);
	 
	
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");


	/******************* Get All Rankings of sellers *********************/
	$arryTotalRanking = $objMember->GetMemberRanking('','Seller');



	/****************************************/
 
	$i=0;
	$flag=true;

	$MainHTMLTop = ''; 
	$MainHTMLBottom = ''; 
	$SimilarKeywords = '';
	$NumTopProduct=0;
	$NumBottomProduct=0;
	
	$GalleryProducts='';
	$FeaturedType='';
	$ProductDisplayed = '';
	$SponserDisabled = '';

  foreach($arryProduct as $key=>$values){
	$i++;
   
		$PrdLink   = $Config['StorePrefix'].$values['UserName'].'/productDetails.php?id='.$values['ProductID'];
		$CartLink  = 'products.php?id='.$values['ProductID'].'&Price='.round($values['Price'],2);
		$ContactLink = 'send-email.php?cmp='.$values['PostedByID'];
		$ReviewLink = 'review.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		
		
		if(!empty($values['SearchTag'])){
			$SimilarKeywords .= stripslashes($values['SearchTag']).',';
		}
		
		if(empty($values['MembershipID'])) $values['MembershipID']=1;

		/************  Calculate Rating ***************/
		$RatingHTML = getRatingHTML($values['Ranking'],$arryTotalRanking[0]['TotalRanks']);
		/************  Calculate Rating ***************/

		if(!empty($values['UserName'])){
			$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';
			$WebsiteLink = $Config['StorePrefix'].$values['UserName'].'/home.php';
			
			$StoreLink = '&nbsp;|&nbsp; <a href="'.$StoreLink.'" class="view_white_link">'.GO_TO_STORE.'</a>';
			if($values['WebsiteStoreOption']=='ws'){
				$WebsiteLink = '&nbsp;|&nbsp;<a href="'.$WebsiteLink.'" class="view_white_link" >'.GO_TO_WEBSITE.'</a>';
			}else{
				$WebsiteLink = '';
			}
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
		
		$ToolTipMSG = ($values['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
		
		if($values['Bidding']=='Fixed'){
			$PrdToolTipMSG = FIXED_PRICE_ITEM;
			$PriceHTML = '';
			//$PriceHTML = '<span class="greentxt_headenew">'.PRICE.' </span><span class="redstar">'.number_format($values['Price'],2,'.','').' '.$Config['Currency']. '</span>';
			$BidLink = '#';
			
		}else if($values['Bidding']=='Auction'){
			$PrdToolTipMSG = AUCTION_ITEM;
			$PriceHTML = '';
			$BidLink = 'bid.php?mId='.$values['PostedByID'].'&pId='.$values['ProductID'];
		}else{
			$PrdToolTipMSG = CLASSIFIED_ITEM;
			$PriceHTML = '';
			$BidLink = '#';
		}
		
		/***********  Sponser Section ****************/
		
		$ShowSponser = 0;
		
		if($values['Sponser'] == 'Yes'){
				if($values['SponserType'] == 'Impression'){
					if($values['SponserImpression']>0 && ($values['SponserImpression']-$values['SponserImpressionCount'])>0){
						$ShowSponser = 1;
					}else{
						$SponserDisabled .= $values['ProductID'].',';
					}
				}else if($values['SponserType'] == 'Duration'){
					if($values['SponserStart'] <= date('Y-m-d') && $values['SponserEnd'] >= date('Y-m-d')){
						$ShowSponser = 1;
					}else{
						$SponserDisabled .= $values['ProductID'].',';
					}
				}else{
						$SponserDisabled .= $values['ProductID'].',';
				}
		}		
		
		
		
		
		
		
		if($ShowSponser==0) { 
			$border_td = 'search_color2';
			$BottomProductLine++;
			$CheckProductID = 'CheckProductBottom'.$BottomProductLine;
			$ResizeImageBg = 'ffffff';
		}else if($flag) { 
			$border_td = 'search_color';
			$flag=!$flag;
			$TopProductLine++;
			$CheckProductID = 'CheckProductTop'.$TopProductLine;
			$ResizeImageBg = 'C4E095';
		}else{
			$border_td = 'search_color1';
			$flag=!$flag;
			$TopProductLine++;
			$CheckProductID = 'CheckProductTop'.$TopProductLine;
			$ResizeImageBg = 'EEF9DC';
		}



		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=128&h=111&bg='.$ResizeImageBg; 
			
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/>';
			$EnlargeImage = '<br><a href="upload/products/'.$values['Image'].'" class=skytxt rel="lightbox">'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="images/no-image.jpg" border="0" class="imgborder_prd"/>';
			$EnlargeImage = '';
		}


		if(sizeof($arryProduct)==$i){
			$BoxStyle = 'style="border-bottom:0px dashed #A9BAD3;"';
		}else{
			$BoxStyle = '';
		}

		
			$MainHTMLRow = '<tr><td align="left" valign="top" class="'.$border_td.'"  '.$BoxStyle.' >
				  <table width="100%" border="0" cellspacing="0" cellpadding="2" >
						<tr>
						<td valign="top" ><input type="checkbox" name="'.$CheckProductID.'" id="'.$CheckProductID.'" value="'.$values['ProductID'].'"/>'.$PrdLine.'</td>
						<td align="center"  width="150" valign="top" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">
						<a href="'.$PrdLink.'" >'.$ImagePath.'</a>
						'.$EnlargeImage.'
						</td>
						<td valign=top >
						
						<table width="100%" border="0" cellspacing="0" cellpadding="1" >
							  <tr>
								<td align=left class="bluetxt_headenew"><a href="'.$PrdLink.'">'.stripslashes($values['Name']).'</a></td>
							  </tr>
							  <tr>
								<td align=left class="blacktxt">'.substr(stripslashes($values['Detail']),0,150).'</a></td>
							  </tr>
							  
							<tr>
								<td height="31" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td class="greentxt_headenew"  width="53%" >'.stripslashes($values['CompanyName']).'</td>
									<td align="left"  class="greentxt" width="15%">'.STORE_RATING.'</td>
									<td align="left" style="padding-top:5px;padding-left:6px;">'.$RatingHTML.'</td>
								  </tr>
								</table></td>
							  </tr>
							  
							  
							  
							 <tr>
								<td height="30" align="left" valign="middle"><a href="'.$BidLink.'"><img src="images_small/'.$values['Bidding'].'1.png" border="0" id="iconprd'.$i.'" onMouseover="ddrivetip(\''.$PrdToolTipMSG.'\', 150,\'\',\'images_small/'.$values['Bidding'].'2.png\',\'iconprd'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/'.$values['Bidding'].'1.png\',\'iconprd'.$i.'\')" /></a>&nbsp;&nbsp;&nbsp;<a href="#"><img src="images_small/Credit'.$values['CreditCard'].'1.png" border="0" id="iconstr'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$values['CreditCard'].'2.png\',\'iconstr'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$values['CreditCard'].'1.png\',\'iconstr'.$i.'\')" /></a></td>
							  </tr>
				  
							  <tr>
								<td height="28"><table width="403" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="10"><img src="images/blue_curve.gif" width="12" height="19" /></td>
									<td width="390" class="vewbg"><a href="'.$PrdLink.'" class="view_white_link">'.VIEW_PRODUCT.'</a>'.$StoreLink.$WebsiteLink.'&nbsp;   |&nbsp; <a href="'.$ReviewLink.'" class="view_white_link">'.BUYERS_REVIEWS.'</a></td>
									<td width="10"><img src="images/blue_curve1.gif" width="12" height="19" /></td>
								  </tr>
								</table></td>
							  </tr>	  
							  
							
						</table>
						</td>
						</tr>
				   </table>
			    </td></tr>';
				
			
			
			
			
		if($ShowSponser==1) { 
			if($_GET['OnlyPhotoTop']==1){			
				if($EnlargeImage == '') $MainHTMLRow='';
			}
		
			$MainHTMLTop .= $MainHTMLRow;	
			$NumTopProduct++;
			
			$ProductDisplayed .= $values['ProductID'].',';
			$SponserType .= $values['SponserType'].',';
			
		}else{
			if($_GET['OnlyPhotoBottom']==1){			
				if($EnlargeImage == '') $MainHTMLRow='';
			}
			
			$MainHTMLBottom .= $MainHTMLRow;		
			$NumBottomProduct++;

			$GalleryProducts .= $values['ProductID'].',';
			
		}
		
		
		
		
		
		
		
		
	 
	 } 
	 


	 
	if(empty($MainHTMLTop) && empty($MainHTMLBottom)){
		$num = 0;
	}else{
		$objProduct->AddSearchKeyword($_GET['topkey'],'Product');
	}
	
	
	if(!empty($SimilarKeywords)){
		$SimilarKeywords = rtrim($SimilarKeywords,",");
		$SimilarKeyArry = explode(",",$SimilarKeywords);
		$SimilarKeyArry = array_unique($SimilarKeyArry);
		
	}
	
	
?>  

	

	
	<? if(sizeof($SimilarKeyArry)>0 && empty($_GET['ch'])) { ?>
		<tr>
            <td height="29" align="left" valign="middle">
			<div style="float:left;"><span class="bluetxt_bold10"><?=RELATED_SEARCHES?></span> 
			<? 
			
			
			$PopUpContent = '<div align="right">
				<a href="javascript: ShowPopupKeyword(0);"><img src="images/delete.png" alt="Close" border="0" /></a>
				</div>';
				
			for($i=0;$i<sizeof($SimilarKeyArry);$i++) {
				
				$SimilarLink = '<a href="search-products.php?SearchBy=Product&productkeyword='.stripslashes($SimilarKeyArry[$i]).'&region='.$_GET['region'].'" class="read_link_more">'.stripslashes($SimilarKeyArry[$i]).'</a>&nbsp;';
				
				if($i<5) echo $SimilarLink;
				$PopUpContent .= $SimilarLink;
				
			 } ?>
			 
			</div>
			<? if(sizeof($SimilarKeyArry)>5){?>
			 <a href='javascript: ShowPopupKeyword(1);'><img src="images/viewall_button.jpg" width="58" id="PopUpImg" height="19" border="0" style="float:left;"/></a>
			 


		<div id="PopUpKeywords"> 
				<?=$PopUpContent?>			
		</div>	 
			 
			 <? } ?>
			 </td>
          </tr>		
		<? } ?>			
			
          	
	
	
<?	

if($num>count($arryProduct)){

$NextPageLink = '#';
$PrevPageLink = '#';


$NextPageID = $_GET['curP']+1;
$PrevPageID = $_GET['curP']-1;

if($NextPageID<=$TotalPage){
	 $NextPageLink = "Javascript:ChangePageLinkNextPrev(".$NextPageID.",'".$queryString."','".basename($_SERVER['PHP_SELF'])."')";
}
if($PrevPageID>0){
	 $PrevPageLink = "Javascript:ChangePageLinkNextPrev(".$PrevPageID.",'".$queryString."','".basename($_SERVER['PHP_SELF'])."')";
}

 ?>
	

<tr>
            <td height="40" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%" align="left" valign="middle" class="bluestar"><a href="<?=$PrevPageLink?>"><img src="images/back.jpg" width="18" height="18" border="0" style="float:left; margin-right:10px;"/></a><a href="<?=$NextPageLink?>"><img src="images/next.jpg" width="18" height="18" border="0" style="float:left; margin-right:10px;"/></a>page <?=$_GET['curP']?> of <?=$TotalPage?> | view page
                  <select name="PaginDrp" id="PaginDrp" class="txtfield" onChange="ChangePageLinkDrop('<? echo $queryString;?>','<? echo basename($_SERVER['PHP_SELF']);?>');">
                    <? for($PageI=1;$PageI<=$TotalPage;$PageI++ ){
						$PageSel  = ($PageI==$_GET['curP'])?(" selected"):("");
						echo '<option value="'.$PageI.'"  '.$PageSel.'>'.$PageI.'</option>';
					}?>
					
                  </select>
                  </td>
                <td width="48%" align="right" valign="middle" >
				<? //echo $pagerLink2 ;?>
				
				</td>
              </tr>
            </table></td>
          </tr>




<? } ?>	
	
	
	
<? if(!empty($MainHTMLTop)){?>
	
	<tr>
		<td align="left" class="header_bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="25%"><a href="Javascript:CompareProducts('Top')" class="compare_link"><?=COMPARE_SELECTED_PRODUCTS?></a></td>
			<td width="58%" class="white_generaltxt">
			
<input type="checkbox" name="OnlyPhotoTop" id="OnlyPhotoTop" value="checkbox" onclick="ShowOnlyPhoto('<?=$PhotoShowTopUrl?>','OnlyPhotoTop');" <?=(!empty($_GET['OnlyPhotoTop']))?(" checked"):("")?> />

			 <?=SHOW_RESULTS_WITH_PHOTO?></td>
			<td width="17%"><div class="white_generaltxt" ><B><?=SPONSER_LINKS?></B></div></td>
		  </tr>
		</table></td>
	  </tr>			
	
		  
  <tr>
	<td valign="top" class="featuretable_border">
			
		<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center" >
		<?  echo $MainHTMLTop; ?>
		</table>
	</td>
  </tr>
  <tr>
            <td height="10"></td>
          </tr>
  <? } ?>
  
  
  
  
<? if(!empty($MainHTMLBottom)){
	
	
	
$GalleryProducts = rtrim($GalleryProducts,",");
?>

	
	
	<tr>
		<td align="left" class="header_bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="25%"><a href="Javascript:CompareProducts('Bottom')" class="compare_link"><?=COMPARE_SELECTED_PRODUCTS?></a></td>
			<td width="58%" class="white_generaltxt" id="BtPrdDv">
<input type="checkbox" name="OnlyPhotoBottom" id="OnlyPhotoBottom" value="checkbox" onclick="ShowOnlyPhoto('<?=$PhotoShowBottomUrl?>','OnlyPhotoBottom');" <?=(!empty($_GET['OnlyPhotoBottom']))?(" checked"):("")?> />		
			  <?=SHOW_RESULTS_WITH_PHOTO?></td>
			<td width="17%"><a href="Javascript:ViewGallery()" class="whitetxt_link"><?=VIEW_GALLERY?></a>
			
			</td>
		  </tr>
		</table></td>
	  </tr>			
	
		  
  <tr>
	<td valign="top" class="featuretable_border">
			
		<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center" >
		<?  echo $MainHTMLBottom; ?>
		</table>
	</td>
  </tr>
  <? } ?>  
  
  
  
		  
	<form  name="form5" method="post" action="" onSubmit="return ChangePageLink(this,<?php echo $TotalPage;?>,'<? echo $queryString;?>','<? echo basename($_SERVER['PHP_SELF']);?>');">
		    <tr>
            <td height="60" align="left">&nbsp;
			<?
			if($num>count($arryProduct)){
			?>
		
	<?=$pagerLink?>	
	<!--
<input type="image" src="images/go.jpg" alt="Go" width="23" height="18" border="0" style="float:right; margin-left:10px;"/>
                  <input name="Page" ID="Page" type="text" class="txtfield_number" size="3" maxlength="6"/>
                  <span class="pagenumber_txt1"><?=GO_TO_PAGE?></span>			
			
			-->
			
			<?
			}
			?>
			</td>
			</tr>
	</form>		
			
		  
		   <? 
		   
		   
	/*   update displayed sponser Items */ 
	 
	if($ProductDisplayed!=''){
		 $ProductDisplayed = rtrim($ProductDisplayed,",");
		$SponserType = rtrim($SponserType,",");
		$objPackage->FeaturedCounter($ProductDisplayed,$SponserType,'Sponser');
	}	 
	
	
	if($SponserDisabled!=''){
		 $SponserDisabled = rtrim($SponserDisabled,",");
		 $objProduct->SponserDisabled($SponserDisabled);
	}	 
		   
		   
		   
		   
		   } 
		   
		   if($num<=0 ) { 
		   
		    ?>			
 
 
 
 
 		  <tr>
            <td class="redtxt"  align="center">
			<? if($_GET['month']>0) echo NO_PRODUCT_FOUND_PERIOD; else echo NO_PRODUCT_FOUND; ?>
			</td>
			</tr>
			
			
			
			 <? } ?>
			 
</table>

<input type="hidden" name="NumTopProduct" id="NumTopProduct" value="<?=$NumTopProduct?>">
<input type="hidden" name="NumBottomProduct" id="NumBottomProduct" value="<?=$NumBottomProduct?>">
<input type="hidden" name="GalleryProducts" id="GalleryProducts" value="<?=$GalleryProducts?>">

</Div>