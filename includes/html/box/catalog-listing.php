<table width="100%" border="0" cellpadding="0" cellspacing="0">


<?
			
if($numCatalog>0 ) { 



	/*
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($numCatalog/ $RecordsPerPage));
	
	
	
	$pagerLink=$objPager->getPager($arryCatalog,$RecordsPerPage,$_GET['curP']);
 	(count($arryCatalog)>0)?($arryCatalog=$objPager->getPageRecords()):("");

*/
	
?>  

	<? if($numCatalog>count($arryCatalog)){ ?>
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
   
  foreach($arryCatalog as $key=>$values){
   $i++;
   
    
		//$PrdLink   = 'products.php?brand='.$values['brandID'].'&cat='.$_GET['cat'].$StoreSuffix;
	


		if($values['Image'] !='' && file_exists('upload/catalog/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/catalog/'.$values['Image'].'&w=120&h=120'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
		}
		
		
		

		

		
		
			echo '<td align=center valign="top" width="33%">
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" align=center>
						
						 <tr>
						<td align=center >
						<input type="checkbox" name="Catalog[]" id="Catalog'.$i.'" value="'.stripslashes($values['heading']).'">
						<b>'.ucfirst(stripslashes($values['heading'])).'</b></td>
						</tr>
						<tr>
						<td align=center  alt="'.stripslashes($values['heading']).'" title="'.stripslashes($values['heading']).'">
						'.$ImagePath.'
					
						</td>
						</tr>
	
						
					 <tr>
						<td height=15 ></td>
						</tr>
				   </table>
			    </td>';
				
		if($i%4==0)  echo '</tr><tr>';		
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>


			
			</td>
          </tr>
		  
		  <? if($numCatalog>count($arryCatalog)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>	
			
		  
		   <? }  ?>			
 
 		 
			 
</table>
<input type="hidden" name="numCatalog" id="numCatalog" value="<?=$numCatalog?>">