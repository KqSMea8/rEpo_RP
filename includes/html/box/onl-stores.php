<?
/*
if(empty($StoreTitle))
	$StoreTitle = ($_GET['SearchBy']!='Store')?(ONLINE_STORES):(ONLINE_STORES);*/
	
$StoreTitle = ONLINE_STORES;
?>

<table width="100%" cellpadding="0"  cellspacing="0" border="0">
<tr>
<td align="left" class="header_bg">
<div class="header_txt" ><?=$StoreTitle?></div>
  <? if($_GET['SearchBy']!='Website' && $num>8 && empty($_GET['ch'])) { ?><a href="websites.php?SearchBy=Website" class="whitetxt_link">View All</a> <? } ?></td>
</tr>
<?
			
if($num>0 ) { 



	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	
	$RecordsPerPage=16;
	$pagerLink=$objPager->getPager($arryStore,$RecordsPerPage,$_GET['curP']);
 	(count($arryStore)>0)?($arryStore=$objPager->getPageRecords()):("");


	
?>  

		  
<tr>
<td class="featuretable_border" >
           
			
 <? 
   $i=0;
   
  foreach($arryStore as $key=>$values){
   $i++;
	
	if($StoreTitle == FEATURED_STORES && $i==9) break;
	
	
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

		$StoreLink = $Config['StorePrefix'].$values['UserName'].'/store.php';
		
		$ToolTipMSG = ($values['CreditCard']=='Yes')?(CREDIT_CARD_AVAILABLE):(CREDIT_CARD_NOT_AVAILABLE);
		
		
		echo '<div class="'.$MainDivClass .'">';
		
		echo '<div style="height:16px;overflow:hidden">'.stripslashes($values['CompanyName']).'</div>
		<div class="feature1"><a href="'.$StoreLink.'">'.$ImagePath.'</a></div>
		<div class="feature2">'.stripslashes($values['TagLine']).'</div>
		<div class="feature3"><Div style="float:left"><a href="#"><img src="images_small/Credit'.$values['CreditCard'].'1.png" border="0" id="icon'.$i.'" onMouseover="ddrivetip(\''.$ToolTipMSG.'\', 150,\'\',\'images_small/Credit'.$values['CreditCard'].'2.png\',\'icon'.$i.'\')"; onMouseout="hideddrivetip(\'images_small/Credit'.$values['CreditCard'].'1.png\',\'icon'.$i.'\')" /></a>&nbsp;&nbsp;&nbsp;</Div><Div ><a href="'.$StoreLink.'" class="greenviewtxt_link" >View</a></Div>
		</div>';
		
			  
		
			$RatingHTML = getRatingOrangeHTML($values['Ranking'],$arryTotalRanking[0]['TotalRanks']);
			
			echo '<div class="feature4"><table cellpadding=0 celspacing=0 border=0 ><tr><td class="greentxt_headenew" valign=top>'.STORE_RATING.'</td><td>'.$RatingHTML.'</td></tr></table></div>';
	

		echo '</div>';		
		
	 
	 } 
	 
	 ?>
	 
</td>
</tr>
		    

			
			
		  <tr>
    <td >&nbsp;<?php 
			if($num>count($arryStore)){ echo $pagerLink; }
			?></td>
  </tr>
			
			
			
			
		  
   <? } else{ ?>			
 
 		   <tr><td height="250" align="center" class="redtxt featuretable_border">
			<? echo 'No '.$StoreTitle.' found.'; ?>
		  </td></tr>
	
	 <? } ?>
			 

</table>
<br>