
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top" width="190" ><?  include('includes/html/box/left.php'); ?></td>
        <td width="6" ><img src="images/spacer.gif" width="6" height="1" style="padding:0px; margin:0px;"/></td>
        <td width="574"  valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="26"  class="heading" ><?=GLOBAL_SPACES2?></td>
          </tr> 
	
		
		  
		 <tr>
            <td height="20" class="border01 skytxt" valign="top"> &nbsp;&nbsp;<?=$FlowUrls?></td>
          </tr> 
		 
          <tr>
            <td >
			
<?
			
if(sizeof($arrayCompanies)>0 ) { 
	
?>
<table width="95%" border="0" cellpadding="0" cellspacing="0"  align="center">
	  <tr>
		<td align="right"  height="40" class="greytxt">
		<? 
		
// echo '<input type="button" name="GlobalSpaces" style="cursor: pointer" class="forum_button" title="'.MY_TRADESPACE_FORUM.'"  value="'.MY_TRADESPACE_FORUM.'" onclick="OpenForum(\'tradeForum/index.php\');" >';
 
 ?>			 
	<!--
<table  border="0" cellspacing="0" cellpadding="0" align="right">
      <tr>
        <td class="curve-topnav-lt"></td>
        <td class="curve-topnav-t"></td>
        <td class="curve-topnav-rt"></td>
      </tr>
      <tr>
        <td class="curve-topnav-l"></td>
        <td height="22" align="center" valign="middle" class="curve-topnav-txt" nowrap>
		<? //echo '<a href="#" onclick="OpenForum(\'tradeForum/index.php\');" href="#">'.MY_TRADESPACE_FORUM.'</a>';?></td>
        <td class="curve-topnav-r"></td>
      </tr>
      <tr>
        <td class="curve-topnav-lb"></td>
        <td class="curve-topnav-b"></td>
        <td class="curve-topnav-rb"></td>
      </tr>
    </table>-->	 		 
		
		</td>
	  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="220">
  <tr>
 <? 
  $i = 0;
  foreach($arrayCompanies as $key=>$values){
  
		$CompanyLink   = 'view-company.php?view='.$values['MemberID'];
		
		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			//imageThumb('upload/company/'.$values['Image'],'upload/company/thumb/'.$values['Image'],110,60);
			//$ImagePath = 'upload/company/thumb/'.$values['Image']; 
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=110&h=60'; 
			
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"/>';
		}else{
			$ImagePath = '<img src="images/no-image.gif" border="0" />';
		}
		
		
		if($i%3==0) echo '</tr><tr>';	
		
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

 <?  }else{ ?>			
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="redtxt" >
	  <tr>
		<td height="220" align="center" ><?=NO_RECORD_FOUND?></td>
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
