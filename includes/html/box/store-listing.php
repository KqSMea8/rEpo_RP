<table width="100%" border="0" cellpadding="0" cellspacing="0">


<?
			
if($num>0 ) { 



	//$RecordsPerPage = 1;
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$_GET['curP'],'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	
	
	$pagerLink=$objPager->getPager($arryStore,$RecordsPerPage,$_GET['curP']);
 	(count($arryStore)>0)?($arryStore=$objPager->getPageRecords()):("");


	
?>  

	
	<? if($num>count($arryStore)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>		
				  
          <tr>
            <td valign="top">
			
			
			<table  border="0" cellpadding="4" cellspacing="0"  align="left" >
				<tr>
 <? 
   
	//$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

 
   $i=0;
   
   		$StoreLinkAdd = '';
		
 		if($_GET['cat']>0) $StoreLinkAdd .= '&cat='.$_GET['cat'];
  		if($_GET['country']>0) $StoreLinkAdd .= '&country='.$_GET['country'];
 
  foreach($arryStore as $key=>$values){
   $i++;
   



		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=140&h=140'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0" />';
		}
		
		
		$StoreLink = 'category.php?StoreID='.$values['MemberID'].$StoreLinkAdd;
		

		

		
		
			echo '<td align=center valign="top" width="166">
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" align=center>
						<tr>
						<td align=center height="160"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">
						<a href="'.$StoreLink.'" >'.$ImagePath.'</a>
					
						</td>
						</tr>
						 <tr>
						<td align=center class="blacktxt" ><a href="'.$StoreLink.'" >'.ucfirst(stripslashes($values['CompanyName'])).'</a></td>
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
		  
		  <? if($num>count($arryStore)){ ?>
	 <tr>
          <td height="40" align="right">
				<?=$pagerLink?>
		</td>
	</tr>
	<?	} ?>	
			
			
			
			
			
			
			
			
			
		  
		   <? } else{ ?>			
 
 		  <tr>
            <td class="redtxt" height="250" align="center">
			No shop found.
			</td>
			</tr>
			 <? } ?>
			 
</table>