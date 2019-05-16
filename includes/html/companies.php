<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
       
        <td align="left" width="574" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="26"  class="heading" ><?=ONLINE_STORES?></td>
          </tr>
	
	
		  <tr>
            <td >&nbsp;
			</td>
			</tr>
		  
          <tr>
            <td  valign="top"  height="250">
			
<?	if(empty($_GET['view'])){ 
		if($arrayContents[0]['PageContent'] != ''){

?>			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="5" cellpadding="3">
  <tr>
    <td >
	<div class="blacktxt1" style="text-align:justify">
	<? 	echo  stripslashes($arrayContents[0]['PageContent']);  ?>

	</div>
	</td>
  </tr>
</table>
	</td>
  </tr>
</table>

 <? } } ?>			
			
			
<?
			
if(sizeof($arrayCompanies)>0 ){ 
	
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
 <? 
  $i = 0;
  foreach($arrayCompanies as $key=>$values){
  
		if($i==4 && empty($_GET['view'])) break;
		
		
		$CompanyLink   = 'view-company.php?view='.$values['MemberID'];
		
		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			//imageThumb('upload/company/'.$values['Image'],'upload/company/thumb/'.$values['Image'],110,60);
			//$ImagePath = 'upload/company/thumb/'.$values['Image']; 
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=110&h=60'; 
			
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"/>';
		}else{
			$ImagePath = '<img src="images/no-image.gif" border="0" />';
		}
		
		
		if($i%4==0) echo '</tr><tr>';	
		
			echo '<td align="center" valign="middle" >
				   <table border="0" cellspacing="0" cellpadding="0" alt="'.stripslashes($values['CompanyName']).'" title="'.stripslashes($values['CompanyName']).'">
						<tr>
						<td align="center" height="60" width="110" class="ImgBorder"><a href="'.$CompanyLink.'" >'.$ImagePath.'</a></td>
						<td width=3></td>
						</tr>
						<tr>
					<td align="center" colspan=2 class="skytxt" height="24" nowrap><Div style="width:110px; height:24px; overflow: hidden">'.stripslashes($values['CompanyName']).'</Div></td>
						</tr>
				   </table>
			    </td>';
	
	 	$i++;
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>

	<? 	if($num>count($arrayCompanies)){ ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center">
	  <tr>
		<td align="center" ><? echo $pagerLink; ?></td>
	  </tr>
	</table>
	  <? } ?>


	<? 	 if(sizeof($arrayCompanies)>4 && empty($_GET['view'])) { ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="skytxt"  bgcolor="">
	  <tr>
		<td height="10" align="right" style="padding-right:5px;"><a href="companies.php?view=all"><?=MORE?>...</a></td>
	  </tr>
	</table>
	  <? } 
  
} ?>			
			
			</td>
          </tr>
		  
         
          <tr>
            <td height="6"></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
        </table></td>
		
		 <td align="right" valign="top">
		 		 
		 <? require_once("includes/html/box/right.php"); ?>

		 
		 </td>
  </tr>
    </table></td>
  </tr>
</table>
