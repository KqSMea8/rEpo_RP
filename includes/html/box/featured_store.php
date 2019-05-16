<table width="100%" cellpadding="0"  cellspacing="0" border="0">
<tr>
<td align="left" class="header_bg">
<div class="header_txt" ><?=FEATURED_STORES?></div>
  <? if($LimitStore>0 && $num>8) { ?><a href="featured_store.php" class="whitetxt_link">View All</a> <? } ?></td>
</tr>
<?
			
if($num>0 ) { 



	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	/*
	$RecordsPerPage=16;
	$pagerLink=$objPager->getPager($arryWebsite,$RecordsPerPage,$_GET['curP']);
 	(count($arryWebsite)>0)?($arryWebsite=$objPager->getPageRecords()):("");
	*/

	
?>  


           
			
 <? 
   $i=0;
   
   $StoreHTML = '';
   
   $FeaturedType='';
	 $StoreDisplayed = '';
	 $FeaturedDisabled = '';
   
   
   
  foreach($arryWebsite as $key=>$values){
  
			$ShowStore = 0;
			
			if($values['FeaturedType'] == 'Impression'){
				if($values['Impression']>0 && ($values['Impression']-$values['ImpressionCount'])>0){
					$ShowStore = 1;
				}else{
					$FeaturedDisabled .= $values['MemberID'].',';
				}
			}else if($values['FeaturedType'] == 'Duration'){
				if($values['FeaturedStart'] <= date('Y-m-d') && $values['FeaturedEnd'] >= date('Y-m-d')){
					$ShowStore = 1;
				}else{
					$FeaturedDisabled .= $values['MemberID'].',';
				}
			}else{
					$FeaturedDisabled .= $values['MemberID'].',';
			}  
  
  
  
	if($ShowStore==1){
  
  
		  
		  
		   $i++;
			
			if($LimitStore>0 && $i==9) break;
			
			$StoreDisplayed .= $values['MemberID'].',';
			$FeaturedType .= $values['FeaturedType'].',';
			
			
			
				if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
					
					$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=90&h=98'; 
				
					$ImagePath = '<img src="'.$ImagePath.'"  border="0" alt="'.stripslashes($values['CompanyName']).'" title="'.stripslashes($values['CompanyName']).'"/>';
					//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/company/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
					//$ImagePath = '<a href="upload/company/'.$values['Image'].'" rel="lightbox" >'.$ImagePath.'</a>';
					
				}else{
					$ImagePath = '<img src="images/no.jpg"  border="0" class="imgborder_prd" />';
				}
				
				
				if($i%4==0) { 
					$MainDivClass = 'feature_boxnew';
				}else{
					$MainDivClass = 'feature_box';
				}
		
				$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';
				
				$ToolTipMSG = ($values['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
				
				
				$StoreHTML .= '<div class="'.$MainDivClass .'">';
				
				$StoreHTML .= '<div style="height:16px;overflow:hidden">'.stripslashes($values['CompanyName']).'</div>
				<div class="feature1"><a href="'.$StoreLink.'" >'.$ImagePath.'</a></div>
				<div class="feature2" style="height:14px;overflow:hidden">'.stripslashes($values['TagLine']).'</div>
				<div class="feature3"><Div style="float:left"><a href="#"><img src="images_small/Credit'.$values['CreditCard'].'1.png" border="0" id="icon'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$values['CreditCard'].'2.png\',\'icon'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$values['CreditCard'].'1.png\',\'icon'.$i.'\')" /></a>&nbsp;&nbsp;&nbsp;</Div><Div ><a href="'.$StoreLink.'" class="greenviewtxt_link" >View</a></Div>
				</div>';
				
					  
				if($WebsiteTitle == FEATURED_STORES){
					$RatingHTML = getRatingOrangeHTML($values['Ranking'],$arryTotalRanking[0]['TotalRanks']);
					
					$StoreHTML .= '<div class="feature4"><table cellpadding=0 celspacing=0 border=0 ><tr><td class="greentxt_headenew" valign=top>'.STORE_RATING.'</td><td>'.$RatingHTML.'</td></tr></table></div>';
				}
		
				$StoreHTML .= '</div>';		
				
			 
			 } 
	 
	
	 	} 
	 
	 
	 }
   
   
	/*   update displayed featured Items */ 
	 
	if($StoreDisplayed!=''){
		$StoreDisplayed = rtrim($StoreDisplayed,","); 
		$FeaturedType = rtrim($FeaturedType,",");
		$objPackage->FeaturedCounter($StoreDisplayed,$FeaturedType,'Store');
	}	 
	
	
	if($FeaturedDisabled!=''){
		 $FeaturedDisabled = rtrim($FeaturedDisabled,",");
		 $objMember->FeaturedDisabled($FeaturedDisabled);
	}   
   
   
   
    ?>			
 
   <tr><td height="200" align="center" class="featuretable_border">
	   	 <? if($i<=0 || empty($num)){ ?>	
		<Div class="redtxt"><? echo 'No '.FEATURED_STORES.' found.'; ?></Div>
		<? }else{ echo $StoreHTML;} ?>
	  </td></tr>	 
			 

</table>
<br>