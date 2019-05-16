
<?
			
if($num>0 ) { 



	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	
	$RecordsPerPage=16;
	$pagerLink=$objPager->getPager($arryWebsite,$RecordsPerPage,$_GET['curP']);
 	(count($arryWebsite)>0)?($arryWebsite=$objPager->getPageRecords()):("");


	
?>  

		  
           
			
 <? 
   $i=0;
   
  foreach($arryWebsite as $key=>$values){
   $i++;

		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=79&h=84'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/company/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
		}else{
			$ImagePath = '<img src="images/no.jpg"  border="0" />';
		}
		
		
		if($i%4==0) { 
			$MainDivClass = 'feature_boxnew';
		}else{
			$MainDivClass = 'feature_box';
		}

		
		
		echo '<div class="'.$MainDivClass .'">
		<div class="feature1" style="height:16px;overflow:hidden">'.stripslashes($values['CompanyName']).'<br /><br />'.$ImagePath.'</div>
		<div class="feature2">Put Intel Desktop Boards together with the Intel Core</div>
		
		<div class="feature3"><a href="#"><img src="images/pro_icon2.jpg" width="22" height="20" border="0" style="float:left;"/></a><a href="'.$values['Website'].'" class="greenviewtxt_link" target="_blank">View</a>
		<div class="clearfix"></div></div>
		</div>';
			  
				
			

					
	 
	 } 
	 
	 ?>
	 
	   

		    
            
			<? 
			if($num>count($arryWebsite)){
				echo '<div style="clear:both"></div><div style="padding-left:60px" >&nbsp;&nbsp;&nbsp;'.$pagerLink.'</div><br><br>';
				}
			?>
		
			
			</div>
			
			
			
			
			
			
			
		  
   <? } else{ ?>			
 
 		  <div class="redtxt" height="250" align="center">
			<? echo NO_WEBSITE_FOUND; ?>
		  </div>
	
	 <? } ?>
			 


