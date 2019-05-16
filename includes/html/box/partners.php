
<table width="100%" cellpadding="0"  cellspacing="0" border="0">
<tr>
<td align="left" class="header_bg">
<div class="header_txt" ><?=FEATURED_PARTNERS_WEBSITES?></div>
  <? if($numPartner>4 && $ShowAll!=1) { ?><a href="partners.php" class="whitetxt_link">View All</a> <? } ?></td>
</tr>
<?
			
if($numPartner>0 ) { 



	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($numPartner/ $RecordsPerPage));
	
	
	$RecordsPerPage=16;
	$pagerLink=$objPager->getPager($arryPartner,$RecordsPerPage,$_GET['curP']);
 	(count($arryPartner)>0)?($arryPartner=$objPager->getPageRecords()):("");


	
?>  

		  
<tr>
<td class="featuretable_border">
           
			
 <? 
   $i=0;
   
  foreach($arryPartner as $key=>$values){
   $i++;
	
	if($i>4 && $ShowAll!=1) break;
	
	
		if($values['Image'] !='' && file_exists('upload/partners/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/partners/'.$values['Image'].'&w=90&h=98'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/partners/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
			//$ImagePath = '<a href="upload/partners/'.$values['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
			
		}else{
			$ImagePath = '<img src="images/no.jpg"  border="0" class="imgborder_prd"  />';
		}
		
		$ImagePath = '<a href="'.$values['Website'].'" target="_blank">'.$ImagePath.'</a>';
		
		if($i%4==0) { 
			$MainDivClass = 'feature_boxnew';
		}else{
			$MainDivClass = 'feature_box';
		}


		
		echo '<div class="'.$MainDivClass .'">';
		
		echo '<div style="height:16px;overflow:hidden">'.stripslashes($values['heading']).' </div>
		<div class="feature1">'.$ImagePath.'</div>
		<div class="feature2" style="height:14px;overflow:hidden">'.stripslashes($values['detail']).'</div>
		<div class="feature3"><Div style="float:left">&nbsp;</Div><Div ><a href="'.$values['Website'].'" target="_blank" class="greenviewtxt_link" >View</a></Div>
		</div>';
		

		echo '</div>';		
		
	 
	 } 
	 
	 ?>
	 
</td>
</tr>
		    
 <tr><td> &nbsp;          
			<? 
			if($numPartner>count($arryPartner)){
				echo $pagerLink;
				}
			?>
		
			
</td></tr>
			
			
			
			
			
			
			
		  
   <? } else{ ?>			
 
 		   <tr><td height="250" align="center" class="redtxt featuretable_border">
			<? echo 'No partners found !'; ?>
		  </td></tr>
	
	 <? } ?>
			 

	
</table>
