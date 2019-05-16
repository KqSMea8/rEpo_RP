<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>  <?=MY_REVIEWS?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=MY_REVIEWS?>		</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  <? if(!empty($_SESSION['mess_review'])) {echo $_SESSION['mess_review']; unset($_SESSION['mess_review']); }?>
			  </td>
            </tr>
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                <tr>
                  <td width="100%" align="center" valign="top" ><form action="" method="post" name="formList" id="formList">
                      <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                        <? if(sizeof($arryRankingDetails)){?>
                        <tr align="left" valign="middle" bgcolor="#F5F5F5" style="border-bottom:1px solid #CCCCCC;">
                          <td width="2%" align="left"  ><?=EDIT?></td>
                          
						  <td width="2%" align="left"  ><?=DELETE?></td>
						  <td width="24%" height="20"   >Store Rating</td>
                          <td width="60%"  >Comments</td>
                          </tr>
  <? 
  	foreach($arryRankingDetails as $key=>$Values){
	
  ?>
                        
						<tr><td colspan="4" height="1" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>
						
						<tr align="left" valign="top" bgcolor="#FFFFFF"  >
						  <td align="left" class="verdan11" ><a href="editReview.php?edit=<? echo $Values['RankingID'];?>&amp;curP=<? echo $_GET['curP'];?>"><img src="images/edit.png" border="0" alt="<?=EDIT?>" title="<?=EDIT?>" /></a></td>
                          <td align="left" class="verdan11" ><a href="editReview.php?del_id=<? echo $Values['RankingID'];?>&amp;curP=<? echo $_GET['curP'];?>" onclick="return confDel('<?=DELETE_REVIEW_ALERT?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a></td>
                          <td height="20" valign="top" class="skytxt">
		<? 
		$StoreLink = $Config['StorePrefix'].$Values['UserName'].'/store.php';
		echo '<a href="'.$StoreLink.'" target="_blank">'.stripslashes($Values['CompanyName']).'</a><br>'; 
		?>	                     
		<img src="images_small/<?=$Values['Points']?>star.png">		   </td>
                          <td class="verdan11">
						  
						  <? 
				if($Values['Status'] ==1){
			  $status = '&nbsp;<span class=greentxt>Active</span>';
		 }else{
			  $status = '&nbsp;<span class=red12>InActive</span>';
		 }					
							
							  
						  
						  if(!empty($Values['Message'])){ 
							echo '"'.substr(stripslashes($Values['Message']),0,85).'...."<br><br>';
							echo '<i>Date: '.$Values['Date'].'</i>&nbsp;&nbsp;'.$status.'<br>';
							}
							
				
						?>						  </td>
                          </tr>
						  
						  
						  
                        <? } // foreach end //?>
                        <? }else{?>
                        <tr align="center" >
                          <td height="30" colspan="4" class="redtxt"><?=NO_REVIEW_FOUND?></td>
                        </tr>
                        <? } ?>
                      </table>
                    <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                  </form></td>
                </tr>
                <? 	if($num>count($arryRankingDetails)){ ?>
                <tr >
                  <td height="20"  >&nbsp;<? echo $pagerLink; ?> </td>
                </tr>
                <? } ?>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
