<table width="100%" border="0" cellpadding="0" cellspacing="0">


<?
			
if($numStore>0 ) { 



	/*
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($numStore/ $RecordsPerPage));
	
	
	
	$pagerLink=$objPager->getPager($arryStore,$RecordsPerPage,$_GET['curP']);
 	(count($arryStore)>0)?($arryStore=$objPager->getPageRecords()):("");

*/
	
?>  

	
	<? if($numStore>count($arryStore)){ ?>
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
   
  foreach($arryStore as $key=>$values){
   $i++;
   
    
		$PrdLink   = 'products.php?StoreID='.$values['MemberID'].'&cat='.$_GET['cat'].$StoreSuffix;
	


		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=120&h=120'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
		}
		
		
		

		

		
		
			echo '<td align=center valign="top" width="33%">
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" align=center>
						<tr>
						<td align=center  alt="'.stripslashes($values['CompanyName']).'" title="'.stripslashes($values['CompanyName']).'">
						<a href="'.$PrdLink.'" >'.$ImagePath.'</a>
					
						</td>
						</tr>
						 <tr>
						<td align=center >'.ucfirst(stripslashes($values['CompanyName'])).'</td>
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
		  
		  <? if($numStore>count($arryStore)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>	
			
			
			
			
			
			
			
			
			
		  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt" height="250" align="center">
			No store found.
			</td>
			</tr>
			 <? } ?>
			 
</table>