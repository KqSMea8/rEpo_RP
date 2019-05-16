<table width="100%" border="0" cellpadding="0" cellspacing="0">


<?
			
if($numBrand>0 ) { 



	/*
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($numBrand/ $RecordsPerPage));
	
	
	
	$pagerLink=$objPager->getPager($arryBrand,$RecordsPerPage,$_GET['curP']);
 	(count($arryBrand)>0)?($arryBrand=$objPager->getPageRecords()):("");

*/
	
?>  

	
	<? if($numBrand>count($arryBrand)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>		
				  
          <tr>
            <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0"  align="center" >
				<tr>
 <? 
   
	//$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

 
   $i=0;
   
  foreach($arryBrand as $key=>$values){
   $i++;
   
    
		$PrdLink   = 'products.php?brand='.$values['brandID'].'&cat='.$_GET['cat'].$StoreSuffix;
	


		if($values['Image'] !='' && file_exists('upload/brands/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/brands/'.$values['Image'].'&w=120&h=120'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
		}
		
		
		

		

		
		
			echo '<td align=center valign="top" width="33%">
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" align=center>
						<tr>
						<td align=center  alt="'.stripslashes($values['heading']).'" title="'.stripslashes($values['heading']).'">
						<a href="'.$PrdLink.'" >'.$ImagePath.'</a>
					
						</td>
						</tr>
						 <tr>
						<td align=center >'.ucfirst(stripslashes($values['heading'])).'</td>
						</tr>
						
					 <tr>
						<td height=15 ></td>
						</tr>
				   </table>
			    </td>';
				
		if($i%3==0)  echo '</tr><tr>';		
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>


			
			</td>
          </tr>
		  
		  <? if($numBrand>count($arryBrand)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>	
			
			
			
			
			
			
			
			
			
		  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt" height="250" align="center">
			<? echo NO_PRODUCT_FOUND; ?>
			</td>
			</tr>
			 <? } ?>
			 
</table>