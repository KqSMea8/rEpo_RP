<Div id="MainResultTable">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >

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
	
	$pagerLink=$objPager->getPager($arryWebsite,$RecordsPerPage,$_GET['curP']);
	
	
	
	$pagerLink2  = str_replace('pagenumber_link','blacktxt_link', $pagerLink);
	$pagerLink2  = str_replace('pagenumber_sel','blacktxt_link_sel', $pagerLink2);
	$pagerLink2  = str_replace('&#8249 Previous','', $pagerLink2);
	$pagerLink2  = str_replace('Next &#8250; ','', $pagerLink2);
	 
	
 	(count($arryWebsite)>0)?($arryWebsite=$objPager->getPageRecords()):("");

 
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

  foreach($arryWebsite as $key=>$values){
	$i++;
		
	
		if(!empty($values['SearchTag'])){
			$SimilarKeywords .= stripslashes($values['SearchTag']).',';
		}
		
		if(empty($values['MembershipID'])) $values['MembershipID']=1;

		
		if(!empty($values['UserName'])){
			$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';
			$WebLink = $Config['StorePrefix'].$values['UserName'].'/home.php';
			
			$WebsiteLink = '<a href="'.$WebLink.'" class="view_white_link" >'.GO_TO_WEBSITE.'</a>';
			if($values['WebsiteStoreOption']=='ws'){
				$StoreLink = '&nbsp;|&nbsp;<a href="'.$StoreLink.'" class="view_white_link">'.GO_TO_STORE.'</a>';
			}else{
				$StoreLink = '';
			}
		}else{
			$StoreLink = '';
			$WebsiteLink = '';
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



		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=128&h=111&bg='.$ResizeImageBg; 
			
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/>';
			$EnlargeImage = '<br><a href="upload/company/'.$values['Image'].'" class=skytxt rel="lightbox">'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="images/no-image.jpg" border="0" class="imgborder_prd"/>';
			$EnlargeImage = '';
		}


		if(sizeof($arryWebsite)==$i){
			$BoxStyle = 'style="border-bottom:0px dashed #A9BAD3;"';
		}else{
			$BoxStyle = '';
		}

		
			$MainHTMLRow = '<tr><td align="left" valign="top" class="'.$border_td.'"  '.$BoxStyle.' >
				  <table width="100%" border="0" cellspacing="0" cellpadding="2" >
						<tr>
						<td valign="top" ><input type="checkbox" name="'.$CheckProductID.'" id="'.$CheckProductID.'" value="'.$values['ProductID'].'"/>'.$PrdLine.'</td>
						<td align="center"  width="150" valign="top" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">
						<a href="'.$WebLink.'" >'.$ImagePath.'</a>
						'.$EnlargeImage.'
						</td>
						<td valign=top >
						
						<table width="100%" border="0" cellspacing="0" cellpadding="1" >
							  <tr>
								<td align=left class="bluetxt_headenew"><a href="'.$WebLink.'">'.stripslashes($values['CompanyName']).'</a></td>
							  </tr>
							  <tr>
								<td align=left  class="blacktxt" valign=top>'.substr(stripslashes($values['TagLine']),0,150).'&nbsp;</a></td>
							  </tr>
							  
							
				  
							  <tr>
								<td height="28"><table width="403" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="10"><img src="images/blue_curve.gif" width="12" height="19" /></td>
									<td width="390" class="vewbg">'.$WebsiteLink.$StoreLink.'</td>
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

if($num>count($arryWebsite)){

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
			if($num>count($arryWebsite)){
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
			No website found
			</td>
			</tr>
			
			
			
			 <? } ?>
			 
</table>

<input type="hidden" name="NumTopProduct" id="NumTopProduct" value="<?=$NumTopProduct?>">
<input type="hidden" name="NumBottomProduct" id="NumBottomProduct" value="<?=$NumBottomProduct?>">
<input type="hidden" name="GalleryProducts" id="GalleryProducts" value="<?=$GalleryProducts?>">

</Div>