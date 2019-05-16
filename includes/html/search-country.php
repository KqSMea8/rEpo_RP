<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top"><?  include('includes/html/box/left.php'); ?></td>
        
        <td align="right" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="26"  class="heading" ><?=TRADE_IN_THE_WORLD?></td>
          </tr>
		  
		 <tr>
            <td height="20" class="border01 skytxt" valign="top"> &nbsp;&nbsp;<?=$FlowUrls?></td>
          </tr> 
		  
          <tr>
            <td >
			
<?
			
if(sizeof($arryCountry)>0 ) { 
	
?>
<table width="95%" border="0" cellpadding="0" cellspacing="0" align="center" >
  <tr>
 <? 
  $i = 0;
  foreach($arryCountry as $key=>$values){
  
		$CompanyLink   = 'company-listing.php?id='.$_GET['id'].'&cid='.$values['country_id'];
		
		if($i%2 == 0) echo '</tr><tr>';	
		
			echo '<td align="left" valign="middle" >
				   <table border="0" cellspacing="0" cellpadding="0" alt="'.stripslashes($values['name']).'" title="'.stripslashes($values['name']).'"><tr>
				   <td width="20" align="center" valign="top" style="padding-top:8px;"><img src="images/news-bullet.gif" width="11" height="11" /></td>
					<td align="left" class="blacktxt" height="24" nowrap><a href="'.$CompanyLink.'" ><b>'.stripslashes($values['name']).'</b></a></td>
						</tr>
				   </table>
			    </td>';
	
	 	$i++;
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>

	
<? }else{ ?>			

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="redtxt" >
	  <tr>
		<td height="200" align="center" ><?=NO_RECORD_FOUND?></td>
	  </tr>
	</table>

<? } ?>
			
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
