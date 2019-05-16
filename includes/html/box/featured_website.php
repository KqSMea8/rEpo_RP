<table width="100%" cellpadding="0"  cellspacing="0" border="0">
<tr>
<td align="left" class="header_bg">
<div class="header_txt" ><?=FEATURED_WEBSITES?></div>
 	<span id="ViewAllSpan" style="display:none"><? if($num>16 && $AllFeaturedWebsite!=1) { ?><a href="featuredWebsite.php" class="whitetxt_link">View All</a> <? } ?></span>
  </td>
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
   
   $WebsiteHTML = '';
   
   $FeaturedWebType='';
	 $WebsiteDisplayed = '';
	 $FeaturedDisabled = '';
   
   
   
  foreach($arryWebsite as $key=>$values){
  
			$ShowWebsite = 0;
			
			if($values['FeaturedWebType'] == 'Impression'){
				if($values['WebImpression']>0 && ($values['WebImpression']-$values['WebImpressionCount'])>0){
					$ShowWebsite = 1;
				}else{
					$FeaturedDisabled .= $values['MemberID'].',';
				}
			}else if($values['FeaturedWebType'] == 'Duration'){
				if($values['FeaturedWebStart'] <= date('Y-m-d') && $values['FeaturedWebEnd'] >= date('Y-m-d')){
					$ShowWebsite = 1;
				}else{
					$FeaturedDisabled .= $values['MemberID'].',';
				}
			}else{
					$FeaturedDisabled .= $values['MemberID'].',';
			}  
  
  
  
	if($ShowWebsite==1){
  
  
		  
		  
		   $i++;
		   if($i==17 && $AllFeaturedWebsite!=1) break;
			
			
			$WebsiteDisplayed .= $values['MemberID'].',';
			$FeaturedWebType .= $values['FeaturedWebType'].',';
			
			
			
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
		
				$WebsiteLink = $Config['StorePrefix'].$values['UserName'].'/home.php';
				
				
				$WebsiteHTML .=  '<div class="'.$MainDivClass .'">';
				
				$WebsiteHTML .=  '<div style="height:16px;overflow:hidden">'.stripslashes($values['CompanyName']).' </div>
				<div class="feature1"><a href="'.$WebsiteLink.'">'.$ImagePath.'</a></div>
				<div class="feature2" style="height:14px;overflow:hidden">'.stripslashes($values['TagLine']).'</div>
				<div class="feature3"><Div style="float:left">&nbsp;&nbsp;&nbsp;</Div><Div ><a href="'.$WebsiteLink.'" class="greenviewtxt_link" >View</a></Div>
				</div>';
		
				$WebsiteHTML .= '</div>';					
				
		
				$WebsiteHTML .= '</div>';		
				
			 
			 } 
	 
	
	 	} 
	 
	 
	 }
   
   
	/*   update displayed featured Items */ 
	 
	if($WebsiteDisplayed!=''){
		$WebsiteDisplayed = rtrim($WebsiteDisplayed,","); 
		$FeaturedWebType = rtrim($FeaturedWebType,",");
		$objPackage->FeaturedCounter($WebsiteDisplayed,$FeaturedWebType,'Website');
	}	 
	
	
	if($FeaturedDisabled!=''){
		 $FeaturedDisabled = rtrim($FeaturedDisabled,",");
		 $objMember->FeaturedWebDisabled($FeaturedDisabled);
	}   
   
   
   
    ?>			
 
   <tr><td height="200" align="center" class="featuretable_border">
	   	 <? if($i<=0 || empty($num)){ ?>	
		<Div class="redtxt"><? echo 'No '.FEATURED_WEBSITES.' found.'; ?></Div>
		<? }else{ 
			echo $WebsiteHTML;
			if($i>16 && $AllFeaturedWebsite!=1){	?>
			 <script language="javascript1.2" type="text/javascript">
				document.getElementById('ViewAllSpan').style.display = 'inline';
			 </script>
			<?	}
		} ?>
	  </td></tr>	 
			 

</table>
<br>