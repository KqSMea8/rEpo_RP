
<table width="100%" cellpadding="0"  cellspacing="0" border="0">

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

		  
<tr>
<td class="featuretable_border" >
           
			
 <? 
   $i=0;

  foreach($arryWebsite as $key=>$values){
   $i++;
	

	
		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=90&h=98'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" alt="'.stripslashes($values['CompanyName']).'" title="'.stripslashes($values['CompanyName']).'"/>';
			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/company/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
			//$ImagePath = '<a href="upload/company/'.$values['Image'].'" rel="lightbox">'.$ImagePath.'</a>';
			
			
		}else{
			$ImagePath = '<img src="images/no.jpg"  border="0" class="imgborder_prd" />';
		}
		
		
		if($i%4==0) { 
			$MainDivClass = 'feature_boxnew';
		}else{
			$MainDivClass = 'feature_box';
		}

		$WebsiteLink = $Config['StorePrefix'].$values['UserName'].'/home.php';
		
		
		
		echo '<div class="'.$MainDivClass .'" >';
		
		echo '<div style="height:16px;overflow:hidden">'.stripslashes($values['CompanyName']).'</div>
		<div class="feature1"><a href="'.$WebsiteLink.'">'.$ImagePath.'</a></div>
		<div class="feature2">'.stripslashes($values['TagLine']).'</div>
		<div class="feature3"><Div style="float:left">&nbsp;&nbsp;&nbsp;</Div><Div ><a href="'.$WebsiteLink.'" class="greenviewtxt_link" >View</a></Div>
		</div>';

		echo '</div>';		
		
	 
	 } 
	 
	 ?>
	 
</td>
</tr>
		    

			
			
		 <tr>
    <td >&nbsp;<?php 
			if($num>count($arryWebsite)){ echo $pagerLink; }
			?></td>
  </tr>	
			
			
			
			
		  
   <? } else{ ?>			
 
 		   <tr><td height="250" align="center" class="redtxt featuretable_border">
			No shop found. 
		  </td></tr>
	
	 <? } ?>
			 

</table>
<br>